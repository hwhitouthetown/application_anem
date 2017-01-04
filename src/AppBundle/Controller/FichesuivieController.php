<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\View\TwitterBootstrap3View;

use AppBundle\Entity\Fichesuivie;

/**
 * Fichesuivie controller.
 *
 * @Route("/fichesuivie")
 */
class FichesuivieController extends Controller
{
    /**
     * Lists all Fichesuivie entities.
     *
     * @Route("/", name="fichesuivie")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $queryBuilder = $em->getRepository('AppBundle:Fichesuivie')->createQueryBuilder('e');
        
        list($filterForm, $queryBuilder) = $this->filter($queryBuilder, $request);
        list($fichesuivies, $pagerHtml) = $this->paginator($queryBuilder, $request);
        
        return $this->render('fichesuivie/index.html.twig', array(
            'fichesuivies' => $fichesuivies,
            'pagerHtml' => $pagerHtml,
            'filterForm' => $filterForm->createView(),

        ));
    }

    /**
    * Create filter form and process filter request.
    *
    */
    protected function filter($queryBuilder, Request $request)
    {
        $session = $request->getSession();
        $filterForm = $this->createForm('AppBundle\Form\FichesuivieFilterType');

        // Reset filter
        if ($request->get('filter_action') == 'reset') {
            $session->remove('FichesuivieControllerFilter');
        }

        // Filter action
        if ($request->get('filter_action') == 'filter') {
            // Bind values from the request
            $filterForm->handleRequest($request);

            if ($filterForm->isValid()) {
                // Build the query from the given form object
                $this->get('lexik_form_filter.query_builder_updater')->addFilterConditions($filterForm, $queryBuilder);
                // Save filter to session
                $filterData = $filterForm->getData();
                $session->set('FichesuivieControllerFilter', $filterData);
            }
        } else {
            // Get filter from session
            if ($session->has('FichesuivieControllerFilter')) {
                $filterData = $session->get('FichesuivieControllerFilter');
                
                foreach ($filterData as $key => $filter) { //fix for entityFilterType that is loaded from session
                    if (is_object($filter)) {
                        $filterData[$key] = $queryBuilder->getEntityManager()->merge($filter);
                    }
                }
                
                $filterForm = $this->createForm('AppBundle\Form\FichesuivieFilterType', $filterData);
                $this->get('lexik_form_filter.query_builder_updater')->addFilterConditions($filterForm, $queryBuilder);
            }
        }

        return array($filterForm, $queryBuilder);
    }


    /**
    * Get results from paginator and get paginator view.
    *
    */
    protected function paginator($queryBuilder, Request $request)
    {
        //sorting
        $sortCol = $queryBuilder->getRootAlias().'.'.$request->get('pcg_sort_col', 'id');
        $queryBuilder->orderBy($sortCol, $request->get('pcg_sort_order', 'desc'));
        // Paginator
        $adapter = new DoctrineORMAdapter($queryBuilder);
        $pagerfanta = new Pagerfanta($adapter);
        $pagerfanta->setMaxPerPage($request->get('pcg_show' , 10));

        try {
            $pagerfanta->setCurrentPage($request->get('pcg_page', 1));
        } catch (\Pagerfanta\Exception\OutOfRangeCurrentPageException $ex) {
            $pagerfanta->setCurrentPage(1);
        }
        
        $entities = $pagerfanta->getCurrentPageResults();

        // Paginator - route generator
        $me = $this;
        $routeGenerator = function($page) use ($me, $request)
        {
            $requestParams = $request->query->all();
            $requestParams['pcg_page'] = $page;
            return $me->generateUrl('fichesuivie', $requestParams);
        };

        // Paginator - view
        $view = new TwitterBootstrap3View();
        $pagerHtml = $view->render($pagerfanta, $routeGenerator, array(
            'proximity' => 3,
            'prev_message' => 'previous',
            'next_message' => 'next',
        ));

        return array($entities, $pagerHtml);
    }
    
    

    /**
     * Displays a form to create a new Fichesuivie entity.
     *
     * @Route("/new", name="fichesuivie_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
    
        $fichesuivie = new Fichesuivie();
        $form   = $this->createForm('AppBundle\Form\FichesuivieType', $fichesuivie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($fichesuivie);
            $em->flush();
            
            $editLink = $this->generateUrl('fichesuivie_edit', array('id' => $fichesuivie->getId()));
            $this->get('session')->getFlashBag()->add('success', "<a href='$editLink'>New fichesuivie was created successfully.</a>" );
            
            $nextAction=  $request->get('submit') == 'save' ? 'fichesuivie' : 'fichesuivie_new';
            return $this->redirectToRoute($nextAction);
        }
        return $this->render('fichesuivie/new.html.twig', array(
            'fichesuivie' => $fichesuivie,
            'form'   => $form->createView(),
        ));
    }
    

    /**
     * Finds and displays a Fichesuivie entity.
     *
     * @Route("/{id}", name="fichesuivie_show")
     * @Method("GET")
     */
    public function showAction(Fichesuivie $fichesuivie)
    {
        $deleteForm = $this->createDeleteForm($fichesuivie);
        return $this->render('fichesuivie/show.html.twig', array(
            'fichesuivie' => $fichesuivie,
            'delete_form' => $deleteForm->createView(),
        ));
    }
    
    

    /**
     * Displays a form to edit an existing Fichesuivie entity.
     *
     * @Route("/{id}/edit", name="fichesuivie_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Fichesuivie $fichesuivie)
    {
        $deleteForm = $this->createDeleteForm($fichesuivie);
        $editForm = $this->createForm('AppBundle\Form\FichesuivieType', $fichesuivie);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($fichesuivie);
            $em->flush();
            
            $this->get('session')->getFlashBag()->add('success', 'Edited Successfully!');
            return $this->redirectToRoute('fichesuivie_edit', array('id' => $fichesuivie->getId()));
        }
        return $this->render('fichesuivie/edit.html.twig', array(
            'fichesuivie' => $fichesuivie,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    
    

    /**
     * Deletes a Fichesuivie entity.
     *
     * @Route("/{id}", name="fichesuivie_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Fichesuivie $fichesuivie)
    {
    
        $form = $this->createDeleteForm($fichesuivie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($fichesuivie);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'The Fichesuivie was deleted successfully');
        } else {
            $this->get('session')->getFlashBag()->add('error', 'Problem with deletion of the Fichesuivie');
        }
        
        return $this->redirectToRoute('fichesuivie');
    }
    
    /**
     * Creates a form to delete a Fichesuivie entity.
     *
     * @param Fichesuivie $fichesuivie The Fichesuivie entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Fichesuivie $fichesuivie)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('fichesuivie_delete', array('id' => $fichesuivie->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
    
    /**
     * Delete Fichesuivie by id
     *
     * @Route("/delete/{id}", name="fichesuivie_by_id_delete")
     * @Method("GET")
     */
    public function deleteByIdAction(Fichesuivie $fichesuivie){
        $em = $this->getDoctrine()->getManager();
        
        try {
            $em->remove($fichesuivie);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'The Fichesuivie was deleted successfully');
        } catch (Exception $ex) {
            $this->get('session')->getFlashBag()->add('error', 'Problem with deletion of the Fichesuivie');
        }

        return $this->redirect($this->generateUrl('fichesuivie'));

    }
    

    /**
    * Bulk Action
    * @Route("/bulk-action/", name="fichesuivie_bulk_action")
    * @Method("POST")
    */
    public function bulkAction(Request $request)
    {
        $ids = $request->get("ids", array());
        $action = $request->get("bulk_action", "delete");

        if ($action == "delete") {
            try {
                $em = $this->getDoctrine()->getManager();
                $repository = $em->getRepository('AppBundle:Fichesuivie');

                foreach ($ids as $id) {
                    $fichesuivie = $repository->find($id);
                    $em->remove($fichesuivie);
                    $em->flush();
                }

                $this->get('session')->getFlashBag()->add('success', 'fichesuivies was deleted successfully!');

            } catch (Exception $ex) {
                $this->get('session')->getFlashBag()->add('error', 'Problem with deletion of the fichesuivies ');
            }
        }

        return $this->redirect($this->generateUrl('fichesuivie'));
    }
    

}
