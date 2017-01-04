<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\View\TwitterBootstrap3View;

use AppBundle\Entity\Membre;

/**
 * Membre controller.
 *
 * @Route("/membre")
 */
class MembreController extends Controller
{
    /**
     * Lists all Membre entities.
     *
     * @Route("/", name="membre")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $queryBuilder = $em->getRepository('AppBundle:Membre')->createQueryBuilder('e');
        
        list($filterForm, $queryBuilder) = $this->filter($queryBuilder, $request);
        list($membres, $pagerHtml) = $this->paginator($queryBuilder, $request);
        
        return $this->render('membre/index.html.twig', array(
            'membres' => $membres,
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
        $filterForm = $this->createForm('AppBundle\Form\MembreFilterType');

        // Reset filter
        if ($request->get('filter_action') == 'reset') {
            $session->remove('MembreControllerFilter');
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
                $session->set('MembreControllerFilter', $filterData);
            }
        } else {
            // Get filter from session
            if ($session->has('MembreControllerFilter')) {
                $filterData = $session->get('MembreControllerFilter');
                
                foreach ($filterData as $key => $filter) { //fix for entityFilterType that is loaded from session
                    if (is_object($filter)) {
                        $filterData[$key] = $queryBuilder->getEntityManager()->merge($filter);
                    }
                }
                
                $filterForm = $this->createForm('AppBundle\Form\MembreFilterType', $filterData);
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
            return $me->generateUrl('membre', $requestParams);
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
     * Displays a form to create a new Membre entity.
     *
     * @Route("/new", name="membre_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
    
        $membre = new Membre();
        $form   = $this->createForm('AppBundle\Form\MembreType', $membre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($membre);
            $em->flush();
            
            $editLink = $this->generateUrl('membre_edit', array('id' => $membre->getId()));
            $this->get('session')->getFlashBag()->add('success', "<a href='$editLink'>New membre was created successfully.</a>" );
            
            $nextAction=  $request->get('submit') == 'save' ? 'membre' : 'membre_new';
            return $this->redirectToRoute($nextAction);
        }
        return $this->render('membre/new.html.twig', array(
            'membre' => $membre,
            'form'   => $form->createView(),
        ));
    }
    

    /**
     * Finds and displays a Membre entity.
     *
     * @Route("/{id}", name="membre_show")
     * @Method("GET")
     */
    public function showAction(Membre $membre)
    {
        $deleteForm = $this->createDeleteForm($membre);
        return $this->render('membre/show.html.twig', array(
            'membre' => $membre,
            'delete_form' => $deleteForm->createView(),
        ));
    }
    
    

    /**
     * Displays a form to edit an existing Membre entity.
     *
     * @Route("/{id}/edit", name="membre_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Membre $membre)
    {
        $deleteForm = $this->createDeleteForm($membre);
        $editForm = $this->createForm('AppBundle\Form\MembreType', $membre);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($membre);
            $em->flush();
            
            $this->get('session')->getFlashBag()->add('success', 'Edited Successfully!');
            return $this->redirectToRoute('membre_edit', array('id' => $membre->getId()));
        }
        return $this->render('membre/edit.html.twig', array(
            'membre' => $membre,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    
    

    /**
     * Deletes a Membre entity.
     *
     * @Route("/{id}", name="membre_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Membre $membre)
    {
    
        $form = $this->createDeleteForm($membre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($membre);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'The Membre was deleted successfully');
        } else {
            $this->get('session')->getFlashBag()->add('error', 'Problem with deletion of the Membre');
        }
        
        return $this->redirectToRoute('membre');
    }
    
    /**
     * Creates a form to delete a Membre entity.
     *
     * @param Membre $membre The Membre entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Membre $membre)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('membre_delete', array('id' => $membre->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
    
    /**
     * Delete Membre by id
     *
     * @Route("/delete/{id}", name="membre_by_id_delete")
     * @Method("GET")
     */
    public function deleteByIdAction(Membre $membre){
        $em = $this->getDoctrine()->getManager();
        
        try {
            $em->remove($membre);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'The Membre was deleted successfully');
        } catch (Exception $ex) {
            $this->get('session')->getFlashBag()->add('error', 'Problem with deletion of the Membre');
        }

        return $this->redirect($this->generateUrl('membre'));

    }
    

    /**
    * Bulk Action
    * @Route("/bulk-action/", name="membre_bulk_action")
    * @Method("POST")
    */
    public function bulkAction(Request $request)
    {
        $ids = $request->get("ids", array());
        $action = $request->get("bulk_action", "delete");

        if ($action == "delete") {
            try {
                $em = $this->getDoctrine()->getManager();
                $repository = $em->getRepository('AppBundle:Membre');

                foreach ($ids as $id) {
                    $membre = $repository->find($id);
                    $em->remove($membre);
                    $em->flush();
                }

                $this->get('session')->getFlashBag()->add('success', 'membres was deleted successfully!');

            } catch (Exception $ex) {
                $this->get('session')->getFlashBag()->add('error', 'Problem with deletion of the membres ');
            }
        }

        return $this->redirect($this->generateUrl('membre'));
    }
    

}
