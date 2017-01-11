<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\View\TwitterBootstrap3View;

use AppBundle\Entity\Faireparti;

/**
 * Faireparti controller.
 *
 * @Route("/faireparti")
 */
class FairepartiController extends Controller
{
    /**
     * Lists all Faireparti entities.
     *
     * @Route("/", name="faireparti")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $queryBuilder = $em->getRepository('AppBundle:Faireparti')->createQueryBuilder('e');
        
        list($filterForm, $queryBuilder) = $this->filter($queryBuilder, $request);
        list($fairepartis, $pagerHtml) = $this->paginator($queryBuilder, $request);
        
        return $this->render('faireparti/index.html.twig', array(
            'fairepartis' => $fairepartis,
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
        $filterForm = $this->createForm('AppBundle\Form\FairepartiFilterType');

        // Reset filter
        if ($request->get('filter_action') == 'reset') {
            $session->remove('FairepartiControllerFilter');
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
                $session->set('FairepartiControllerFilter', $filterData);
            }
        } else {
            // Get filter from session
            if ($session->has('FairepartiControllerFilter')) {
                $filterData = $session->get('FairepartiControllerFilter');
                
                foreach ($filterData as $key => $filter) { //fix for entityFilterType that is loaded from session
                    if (is_object($filter)) {
                        $filterData[$key] = $queryBuilder->getEntityManager()->merge($filter);
                    }
                }
                
                $filterForm = $this->createForm('AppBundle\Form\FairepartiFilterType', $filterData);
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
            return $me->generateUrl('faireparti', $requestParams);
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
     * Displays a form to create a new Faireparti entity.
     *
     * @Route("/new", name="faireparti_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
    
        $faireparti = new Faireparti();
        $form   = $this->createForm('AppBundle\Form\FairepartiType', $faireparti);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($faireparti);
            $em->flush();
            
            $editLink = $this->generateUrl('faireparti_edit', array('id' => $faireparti->getId()));
            $this->get('session')->getFlashBag()->add('success', "<a href='$editLink'>New faireparti was created successfully.</a>" );
            
            $nextAction=  $request->get('submit') == 'save' ? 'faireparti' : 'faireparti_new';
            return $this->redirectToRoute($nextAction);
        }
        return $this->render('faireparti/new.html.twig', array(
            'faireparti' => $faireparti,
            'form'   => $form->createView(),
        ));
    }
    

    /**
     * Finds and displays a Faireparti entity.
     *
     * @Route("/{id}", name="faireparti_show")
     * @Method("GET")
     */
    public function showAction(Faireparti $faireparti)
    {
        $deleteForm = $this->createDeleteForm($faireparti);
        return $this->render('faireparti/show.html.twig', array(
            'faireparti' => $faireparti,
            'delete_form' => $deleteForm->createView(),
        ));
    }
    
    

    /**
     * Displays a form to edit an existing Faireparti entity.
     *
     * @Route("/{id}/edit", name="faireparti_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Faireparti $faireparti)
    {
        $deleteForm = $this->createDeleteForm($faireparti);
        $editForm = $this->createForm('AppBundle\Form\FairepartiType', $faireparti);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($faireparti);
            $em->flush();
            
            $this->get('session')->getFlashBag()->add('success', 'Edited Successfully!');
            return $this->redirectToRoute('faireparti_edit', array('id' => $faireparti->getId()));
        }
        return $this->render('faireparti/edit.html.twig', array(
            'faireparti' => $faireparti,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    
    

    /**
     * Deletes a Faireparti entity.
     *
     * @Route("/{id}", name="faireparti_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Faireparti $faireparti)
    {
    
        $form = $this->createDeleteForm($faireparti);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($faireparti);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'The Faireparti was deleted successfully');
        } else {
            $this->get('session')->getFlashBag()->add('error', 'Problem with deletion of the Faireparti');
        }
        
        return $this->redirectToRoute('faireparti');
    }
    
    /**
     * Creates a form to delete a Faireparti entity.
     *
     * @param Faireparti $faireparti The Faireparti entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Faireparti $faireparti)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('faireparti_delete', array('id' => $faireparti->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
    
    /**
     * Delete Faireparti by id
     *
     * @Route("/delete/{id}", name="faireparti_by_id_delete")
     * @Method("GET")
     */
    public function deleteByIdAction(Faireparti $faireparti){
        $em = $this->getDoctrine()->getManager();
        
        try {
            $em->remove($faireparti);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'The Faireparti was deleted successfully');
        } catch (Exception $ex) {
            $this->get('session')->getFlashBag()->add('error', 'Problem with deletion of the Faireparti');
        }

        return $this->redirect($this->generateUrl('faireparti'));

    }
    

    /**
    * Bulk Action
    * @Route("/bulk-action/", name="faireparti_bulk_action")
    * @Method("POST")
    */
    public function bulkAction(Request $request)
    {
        $ids = $request->get("ids", array());
        $action = $request->get("bulk_action", "delete");

        if ($action == "delete") {
            try {
                $em = $this->getDoctrine()->getManager();
                $repository = $em->getRepository('AppBundle:Faireparti');

                foreach ($ids as $id) {
                    $faireparti = $repository->find($id);
                    $em->remove($faireparti);
                    $em->flush();
                }

                $this->get('session')->getFlashBag()->add('success', 'fairepartis was deleted successfully!');

            } catch (Exception $ex) {
                $this->get('session')->getFlashBag()->add('error', 'Problem with deletion of the fairepartis ');
            }
        }

        return $this->redirect($this->generateUrl('faireparti'));
    }
    

}
