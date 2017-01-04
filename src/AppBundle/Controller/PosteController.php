<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\View\TwitterBootstrap3View;

use AppBundle\Entity\Poste;

/**
 * Poste controller.
 *
 * @Route("/poste")
 */
class PosteController extends Controller
{
    /**
     * Lists all Poste entities.
     *
     * @Route("/", name="poste")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $queryBuilder = $em->getRepository('AppBundle:Poste')->createQueryBuilder('e');
        
        list($filterForm, $queryBuilder) = $this->filter($queryBuilder, $request);
        list($postes, $pagerHtml) = $this->paginator($queryBuilder, $request);
        
        return $this->render('poste/index.html.twig', array(
            'postes' => $postes,
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
        $filterForm = $this->createForm('AppBundle\Form\PosteFilterType');

        // Reset filter
        if ($request->get('filter_action') == 'reset') {
            $session->remove('PosteControllerFilter');
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
                $session->set('PosteControllerFilter', $filterData);
            }
        } else {
            // Get filter from session
            if ($session->has('PosteControllerFilter')) {
                $filterData = $session->get('PosteControllerFilter');
                
                foreach ($filterData as $key => $filter) { //fix for entityFilterType that is loaded from session
                    if (is_object($filter)) {
                        $filterData[$key] = $queryBuilder->getEntityManager()->merge($filter);
                    }
                }
                
                $filterForm = $this->createForm('AppBundle\Form\PosteFilterType', $filterData);
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
            return $me->generateUrl('poste', $requestParams);
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
     * Displays a form to create a new Poste entity.
     *
     * @Route("/new", name="poste_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
    
        $poste = new Poste();
        $form   = $this->createForm('AppBundle\Form\PosteType', $poste);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($poste);
            $em->flush();
            
            $editLink = $this->generateUrl('poste_edit', array('id' => $poste->getId()));
            $this->get('session')->getFlashBag()->add('success', "<a href='$editLink'>New poste was created successfully.</a>" );
            
            $nextAction=  $request->get('submit') == 'save' ? 'poste' : 'poste_new';
            return $this->redirectToRoute($nextAction);
        }
        return $this->render('poste/new.html.twig', array(
            'poste' => $poste,
            'form'   => $form->createView(),
        ));
    }
    

    /**
     * Finds and displays a Poste entity.
     *
     * @Route("/{id}", name="poste_show")
     * @Method("GET")
     */
    public function showAction(Poste $poste)
    {
        $deleteForm = $this->createDeleteForm($poste);
        return $this->render('poste/show.html.twig', array(
            'poste' => $poste,
            'delete_form' => $deleteForm->createView(),
        ));
    }
    
    

    /**
     * Displays a form to edit an existing Poste entity.
     *
     * @Route("/{id}/edit", name="poste_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Poste $poste)
    {
        $deleteForm = $this->createDeleteForm($poste);
        $editForm = $this->createForm('AppBundle\Form\PosteType', $poste);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($poste);
            $em->flush();
            
            $this->get('session')->getFlashBag()->add('success', 'Edited Successfully!');
            return $this->redirectToRoute('poste_edit', array('id' => $poste->getId()));
        }
        return $this->render('poste/edit.html.twig', array(
            'poste' => $poste,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    
    

    /**
     * Deletes a Poste entity.
     *
     * @Route("/{id}", name="poste_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Poste $poste)
    {
    
        $form = $this->createDeleteForm($poste);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($poste);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'The Poste was deleted successfully');
        } else {
            $this->get('session')->getFlashBag()->add('error', 'Problem with deletion of the Poste');
        }
        
        return $this->redirectToRoute('poste');
    }
    
    /**
     * Creates a form to delete a Poste entity.
     *
     * @param Poste $poste The Poste entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Poste $poste)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('poste_delete', array('id' => $poste->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
    
    /**
     * Delete Poste by id
     *
     * @Route("/delete/{id}", name="poste_by_id_delete")
     * @Method("GET")
     */
    public function deleteByIdAction(Poste $poste){
        $em = $this->getDoctrine()->getManager();
        
        try {
            $em->remove($poste);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'The Poste was deleted successfully');
        } catch (Exception $ex) {
            $this->get('session')->getFlashBag()->add('error', 'Problem with deletion of the Poste');
        }

        return $this->redirect($this->generateUrl('poste'));

    }
    

    /**
    * Bulk Action
    * @Route("/bulk-action/", name="poste_bulk_action")
    * @Method("POST")
    */
    public function bulkAction(Request $request)
    {
        $ids = $request->get("ids", array());
        $action = $request->get("bulk_action", "delete");

        if ($action == "delete") {
            try {
                $em = $this->getDoctrine()->getManager();
                $repository = $em->getRepository('AppBundle:Poste');

                foreach ($ids as $id) {
                    $poste = $repository->find($id);
                    $em->remove($poste);
                    $em->flush();
                }

                $this->get('session')->getFlashBag()->add('success', 'postes was deleted successfully!');

            } catch (Exception $ex) {
                $this->get('session')->getFlashBag()->add('error', 'Problem with deletion of the postes ');
            }
        }

        return $this->redirect($this->generateUrl('poste'));
    }
    

}
