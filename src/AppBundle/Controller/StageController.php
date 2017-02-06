<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\View\TwitterBootstrap3View;

use AppBundle\Entity\Stage;

/**
 * Stage controller.
 *
 * @Route("/stage")
 */
class StageController extends Controller
{
    /**
     * Lists all Stage entities.
     *
     * @Route("/", name="stage")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $queryBuilder = $em->getRepository('AppBundle:Stage')->createQueryBuilder('e');
        
        list($filterForm, $queryBuilder) = $this->filter($queryBuilder, $request);
        list($stages, $pagerHtml) = $this->paginator($queryBuilder, $request);
        
        return $this->render('stage/index.html.twig', array(
            'stages' => $stages,
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
        $filterForm = $this->createForm('AppBundle\Form\StageFilterType');

        // Reset filter
        if ($request->get('filter_action') == 'reset') {
            $session->remove('StageControllerFilter');
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
                $session->set('StageControllerFilter', $filterData);
            }
        } else {
            // Get filter from session
            if ($session->has('StageControllerFilter')) {
                $filterData = $session->get('StageControllerFilter');
                
                foreach ($filterData as $key => $filter) { //fix for entityFilterType that is loaded from session
                    if (is_object($filter)) {
                        $filterData[$key] = $queryBuilder->getEntityManager()->merge($filter);
                    }
                }
                
                $filterForm = $this->createForm('AppBundle\Form\StageFilterType', $filterData);
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
            return $me->generateUrl('stage', $requestParams);
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
     * Displays a form to create a new Stage entity.
     *
     * @Route("/new", name="stage_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
    
        $stage = new Stage();
        $form   = $this->createForm('AppBundle\Form\StageType', $stage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($stage);
            $em->flush();
            
            $editLink = $this->generateUrl('stage_edit', array('id' => $stage->getId()));
            $this->get('session')->getFlashBag()->add('success', "<a href='$editLink'>New stage was created successfully.</a>" );
            
            $nextAction=  $request->get('submit') == 'save' ? 'stage' : 'stage_new';
            return $this->redirectToRoute($nextAction);
        }
        return $this->render('stage/new.html.twig', array(
            'stage' => $stage,
            'form'   => $form->createView(),
        ));
    }
    

    /**
     * Finds and displays a Stage entity.
     *
     * @Route("/{id}", name="stage_show")
     * @Method("GET")
     */
    public function showAction(Stage $stage)
    {
        $deleteForm = $this->createDeleteForm($stage);
        return $this->render('stage/show.html.twig', array(
            'stage' => $stage,
            'delete_form' => $deleteForm->createView(),
        ));
    }
    
    

    /**
     * Displays a form to edit an existing Stage entity.
     *
     * @Route("/{id}/edit", name="stage_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Stage $stage)
    {
        $deleteForm = $this->createDeleteForm($stage);
        $editForm = $this->createForm('AppBundle\Form\StageType', $stage);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($stage);
            $em->flush();
            
            $this->get('session')->getFlashBag()->add('success', 'Edited Successfully!');
            return $this->redirectToRoute('stage_edit', array('id' => $stage->getId()));
        }
        return $this->render('stage/edit.html.twig', array(
            'stage' => $stage,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    
    

    /**
     * Deletes a Stage entity.
     *
     * @Route("/{id}", name="stage_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Stage $stage)
    {
    
        $form = $this->createDeleteForm($stage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($stage);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'The Stage was deleted successfully');
        } else {
            $this->get('session')->getFlashBag()->add('error', 'Problem with deletion of the Stage');
        }
        
        return $this->redirectToRoute('stage');
    }
    
    /**
     * Creates a form to delete a Stage entity.
     *
     * @param Stage $stage The Stage entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Stage $stage)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('stage_delete', array('id' => $stage->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
    
    /**
     * Delete Stage by id
     *
     * @Route("/delete/{id}", name="stage_by_id_delete")
     * @Method("GET")
     */
    public function deleteByIdAction(Stage $stage){
        $em = $this->getDoctrine()->getManager();
        
        try {
            $em->remove($stage);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'The Stage was deleted successfully');
        } catch (Exception $ex) {
            $this->get('session')->getFlashBag()->add('error', 'Problem with deletion of the Stage');
        }

        return $this->redirect($this->generateUrl('stage'));

    }
    

    /**
    * Bulk Action
    * @Route("/bulk-action/", name="stage_bulk_action")
    * @Method("POST")
    */
    public function bulkAction(Request $request)
    {
        $ids = $request->get("ids", array());
        $action = $request->get("bulk_action", "delete");

        if ($action == "delete") {
            try {
                $em = $this->getDoctrine()->getManager();
                $repository = $em->getRepository('AppBundle:Stage');

                foreach ($ids as $id) {
                    $stage = $repository->find($id);
                    $em->remove($stage);
                    $em->flush();
                }

                $this->get('session')->getFlashBag()->add('success', 'stages was deleted successfully!');

            } catch (Exception $ex) {
                $this->get('session')->getFlashBag()->add('error', 'Problem with deletion of the stages ');
            }
        }

        return $this->redirect($this->generateUrl('stage'));
    }
    

}
