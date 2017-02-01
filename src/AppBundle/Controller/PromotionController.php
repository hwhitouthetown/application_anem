<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\View\TwitterBootstrap3View;

use AppBundle\Entity\Promotion;

/**
 * Promotion controller.
 *
 * @Route("/promotion")
 */
class PromotionController extends Controller
{
    /**
     * Lists all Promotion entities.
     *
     * @Route("/", name="promotion")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $queryBuilder = $em->getRepository('AppBundle:Promotion')->createQueryBuilder('e');
        
        list($filterForm, $queryBuilder) = $this->filter($queryBuilder, $request);
        list($promotions, $pagerHtml) = $this->paginator($queryBuilder, $request);
        
        return $this->render('promotion/index.html.twig', array(
            'promotions' => $promotions,
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
        $filterForm = $this->createForm('AppBundle\Form\PromotionFilterType');

        // Reset filter
        if ($request->get('filter_action') == 'reset') {
            $session->remove('PromotionControllerFilter');
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
                $session->set('PromotionControllerFilter', $filterData);
            }
        } else {
            // Get filter from session
            if ($session->has('PromotionControllerFilter')) {
                $filterData = $session->get('PromotionControllerFilter');
                
                foreach ($filterData as $key => $filter) { //fix for entityFilterType that is loaded from session
                    if (is_object($filter)) {
                        $filterData[$key] = $queryBuilder->getEntityManager()->merge($filter);
                    }
                }
                
                $filterForm = $this->createForm('AppBundle\Form\PromotionFilterType', $filterData);
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
            return $me->generateUrl('promotion', $requestParams);
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
     * Displays a form to create a new Promotion entity.
     *
     * @Route("/new", name="promotion_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
    
        $promotion = new Promotion();
        $form   = $this->createForm('AppBundle\Form\PromotionType', $promotion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($promotion);
            $em->flush();
            
            $editLink = $this->generateUrl('promotion_edit', array('id' => $promotion->getId()));
            $this->get('session')->getFlashBag()->add('success', "<a href='$editLink'>New promotion was created successfully.</a>" );
            
            $nextAction=  $request->get('submit') == 'save' ? 'promotion' : 'promotion_new';
            return $this->redirectToRoute($nextAction);
        }
        return $this->render('promotion/new.html.twig', array(
            'promotion' => $promotion,
            'form'   => $form->createView(),
        ));
    }
    

    /**
     * Finds and displays a Promotion entity.
     *
     * @Route("/{id}", name="promotion_show")
     * @Method("GET")
     */
    public function showAction(Promotion $promotion)
    {
        $deleteForm = $this->createDeleteForm($promotion);
        return $this->render('promotion/show.html.twig', array(
            'promotion' => $promotion,
            'delete_form' => $deleteForm->createView(),
        ));
    }
    
    

    /**
     * Displays a form to edit an existing Promotion entity.
     *
     * @Route("/{id}/edit", name="promotion_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Promotion $promotion)
    {
        $deleteForm = $this->createDeleteForm($promotion);
        $editForm = $this->createForm('AppBundle\Form\PromotionType', $promotion);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($promotion);
            $em->flush();
            
            $this->get('session')->getFlashBag()->add('success', 'Edited Successfully!');
            return $this->redirectToRoute('promotion_edit', array('id' => $promotion->getId()));
        }
        return $this->render('promotion/edit.html.twig', array(
            'promotion' => $promotion,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    
    

    /**
     * Deletes a Promotion entity.
     *
     * @Route("/{id}", name="promotion_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Promotion $promotion)
    {
    
        $form = $this->createDeleteForm($promotion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($promotion);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'The Promotion was deleted successfully');
        } else {
            $this->get('session')->getFlashBag()->add('error', 'Problem with deletion of the Promotion');
        }
        
        return $this->redirectToRoute('promotion');
    }
    
    /**
     * Creates a form to delete a Promotion entity.
     *
     * @param Promotion $promotion The Promotion entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Promotion $promotion)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('promotion_delete', array('id' => $promotion->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
    
    /**
     * Delete Promotion by id
     *
     * @Route("/delete/{id}", name="promotion_by_id_delete")
     * @Method("GET")
     */
    public function deleteByIdAction(Promotion $promotion){
        $em = $this->getDoctrine()->getManager();
        
        try {
            $em->remove($promotion);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'The Promotion was deleted successfully');
        } catch (Exception $ex) {
            $this->get('session')->getFlashBag()->add('error', 'Problem with deletion of the Promotion');
        }

        return $this->redirect($this->generateUrl('promotion'));

    }
    

    /**
    * Bulk Action
    * @Route("/bulk-action/", name="promotion_bulk_action")
    * @Method("POST")
    */
    public function bulkAction(Request $request)
    {
        $ids = $request->get("ids", array());
        $action = $request->get("bulk_action", "delete");

        if ($action == "delete") {
            try {
                $em = $this->getDoctrine()->getManager();
                $repository = $em->getRepository('AppBundle:Promotion');

                foreach ($ids as $id) {
                    $promotion = $repository->find($id);
                    $em->remove($promotion);
                    $em->flush();
                }

                $this->get('session')->getFlashBag()->add('success', 'promotions was deleted successfully!');

            } catch (Exception $ex) {
                $this->get('session')->getFlashBag()->add('error', 'Problem with deletion of the promotions ');
            }
        }

        return $this->redirect($this->generateUrl('promotion'));
    }
    

}
