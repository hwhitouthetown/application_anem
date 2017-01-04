<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\View\TwitterBootstrap3View;

use AppBundle\Entity\Personnel;

/**
 * Personnel controller.
 *
 * @Route("/personnel")
 */
class PersonnelController extends Controller
{
    /**
     * Lists all Personnel entities.
     *
     * @Route("/", name="personnel")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $queryBuilder = $em->getRepository('AppBundle:Personnel')->createQueryBuilder('e');
        
        list($filterForm, $queryBuilder) = $this->filter($queryBuilder, $request);
        list($personnels, $pagerHtml) = $this->paginator($queryBuilder, $request);
        
        return $this->render('personnel/index.html.twig', array(
            'personnels' => $personnels,
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
        $filterForm = $this->createForm('AppBundle\Form\PersonnelFilterType');

        // Reset filter
        if ($request->get('filter_action') == 'reset') {
            $session->remove('PersonnelControllerFilter');
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
                $session->set('PersonnelControllerFilter', $filterData);
            }
        } else {
            // Get filter from session
            if ($session->has('PersonnelControllerFilter')) {
                $filterData = $session->get('PersonnelControllerFilter');
                
                foreach ($filterData as $key => $filter) { //fix for entityFilterType that is loaded from session
                    if (is_object($filter)) {
                        $filterData[$key] = $queryBuilder->getEntityManager()->merge($filter);
                    }
                }
                
                $filterForm = $this->createForm('AppBundle\Form\PersonnelFilterType', $filterData);
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
            return $me->generateUrl('personnel', $requestParams);
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
     * Displays a form to create a new Personnel entity.
     *
     * @Route("/new", name="personnel_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
    
        $personnel = new Personnel();
        $form   = $this->createForm('AppBundle\Form\PersonnelType', $personnel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($personnel);
            $em->flush();
            
            $editLink = $this->generateUrl('personnel_edit', array('id' => $personnel->getId()));
            $this->get('session')->getFlashBag()->add('success', "<a href='$editLink'>New personnel was created successfully.</a>" );
            
            $nextAction=  $request->get('submit') == 'save' ? 'personnel' : 'personnel_new';
            return $this->redirectToRoute($nextAction);
        }
        return $this->render('personnel/new.html.twig', array(
            'personnel' => $personnel,
            'form'   => $form->createView(),
        ));
    }
    

    /**
     * Finds and displays a Personnel entity.
     *
     * @Route("/{id}", name="personnel_show")
     * @Method("GET")
     */
    public function showAction(Personnel $personnel)
    {
        $deleteForm = $this->createDeleteForm($personnel);
        return $this->render('personnel/show.html.twig', array(
            'personnel' => $personnel,
            'delete_form' => $deleteForm->createView(),
        ));
    }
    
    

    /**
     * Displays a form to edit an existing Personnel entity.
     *
     * @Route("/{id}/edit", name="personnel_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Personnel $personnel)
    {
        $deleteForm = $this->createDeleteForm($personnel);
        $editForm = $this->createForm('AppBundle\Form\PersonnelType', $personnel);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($personnel);
            $em->flush();
            
            $this->get('session')->getFlashBag()->add('success', 'Edited Successfully!');
            return $this->redirectToRoute('personnel_edit', array('id' => $personnel->getId()));
        }
        return $this->render('personnel/edit.html.twig', array(
            'personnel' => $personnel,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    
    

    /**
     * Deletes a Personnel entity.
     *
     * @Route("/{id}", name="personnel_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Personnel $personnel)
    {
    
        $form = $this->createDeleteForm($personnel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($personnel);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'The Personnel was deleted successfully');
        } else {
            $this->get('session')->getFlashBag()->add('error', 'Problem with deletion of the Personnel');
        }
        
        return $this->redirectToRoute('personnel');
    }
    
    /**
     * Creates a form to delete a Personnel entity.
     *
     * @param Personnel $personnel The Personnel entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Personnel $personnel)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('personnel_delete', array('id' => $personnel->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
    
    /**
     * Delete Personnel by id
     *
     * @Route("/delete/{id}", name="personnel_by_id_delete")
     * @Method("GET")
     */
    public function deleteByIdAction(Personnel $personnel){
        $em = $this->getDoctrine()->getManager();
        
        try {
            $em->remove($personnel);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'The Personnel was deleted successfully');
        } catch (Exception $ex) {
            $this->get('session')->getFlashBag()->add('error', 'Problem with deletion of the Personnel');
        }

        return $this->redirect($this->generateUrl('personnel'));

    }
    

    /**
    * Bulk Action
    * @Route("/bulk-action/", name="personnel_bulk_action")
    * @Method("POST")
    */
    public function bulkAction(Request $request)
    {
        $ids = $request->get("ids", array());
        $action = $request->get("bulk_action", "delete");

        if ($action == "delete") {
            try {
                $em = $this->getDoctrine()->getManager();
                $repository = $em->getRepository('AppBundle:Personnel');

                foreach ($ids as $id) {
                    $personnel = $repository->find($id);
                    $em->remove($personnel);
                    $em->flush();
                }

                $this->get('session')->getFlashBag()->add('success', 'personnels was deleted successfully!');

            } catch (Exception $ex) {
                $this->get('session')->getFlashBag()->add('error', 'Problem with deletion of the personnels ');
            }
        }

        return $this->redirect($this->generateUrl('personnel'));
    }
    

}
