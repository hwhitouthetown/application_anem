<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\View\TwitterBootstrap3View;

use AppBundle\Entity\Entreprise;

/**
 * Entreprise controller.
 *
 * @Route("/entreprise")
 */
class EntrepriseController extends Controller
{
    /**
     * Lists all Entreprise entities.
     *
     * @Route("/", name="entreprise")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $queryBuilder = $em->getRepository('AppBundle:Entreprise')->createQueryBuilder('e');
        
        list($filterForm, $queryBuilder) = $this->filter($queryBuilder, $request);
        list($entreprises, $pagerHtml) = $this->paginator($queryBuilder, $request);
        
        return $this->render('entreprise/index.html.twig', array(
            'entreprises' => $entreprises,
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
        $filterForm = $this->createForm('AppBundle\Form\EntrepriseFilterType');

        // Reset filter
        if ($request->get('filter_action') == 'reset') {
            $session->remove('EntrepriseControllerFilter');
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
                $session->set('EntrepriseControllerFilter', $filterData);
            }
        } else {
            // Get filter from session
            if ($session->has('EntrepriseControllerFilter')) {
                $filterData = $session->get('EntrepriseControllerFilter');
                
                foreach ($filterData as $key => $filter) { //fix for entityFilterType that is loaded from session
                    if (is_object($filter)) {
                        $filterData[$key] = $queryBuilder->getEntityManager()->merge($filter);
                    }
                }
                
                $filterForm = $this->createForm('AppBundle\Form\EntrepriseFilterType', $filterData);
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
            return $me->generateUrl('entreprise', $requestParams);
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
     * Displays a form to create a new Entreprise entity.
     *
     * @Route("/new", name="entreprise_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
    
        $entreprise = new Entreprise();
        $form   = $this->createForm('AppBundle\Form\EntrepriseType', $entreprise);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entreprise);
            $em->flush();
            
            $editLink = $this->generateUrl('entreprise_edit', array('id' => $entreprise->getId()));
            $this->get('session')->getFlashBag()->add('success', "<a href='$editLink'>New entreprise was created successfully.</a>" );
            
            $nextAction=  $request->get('submit') == 'save' ? 'entreprise' : 'entreprise_new';
            return $this->redirectToRoute($nextAction);
        }
        return $this->render('entreprise/new.html.twig', array(
            'entreprise' => $entreprise,
            'form'   => $form->createView(),
        ));
    }
    

    /**
     * Finds and displays a Entreprise entity.
     *
     * @Route("/{id}", name="entreprise_show")
     * @Method("GET")
     */
    public function showAction(Entreprise $entreprise)
    {
        $deleteForm = $this->createDeleteForm($entreprise);
        return $this->render('entreprise/show.html.twig', array(
            'entreprise' => $entreprise,
            'delete_form' => $deleteForm->createView(),
        ));
    }
    
    

    /**
     * Displays a form to edit an existing Entreprise entity.
     *
     * @Route("/{id}/edit", name="entreprise_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Entreprise $entreprise)
    {
        $deleteForm = $this->createDeleteForm($entreprise);
        $editForm = $this->createForm('AppBundle\Form\EntrepriseType', $entreprise);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entreprise);
            $em->flush();
            
            $this->get('session')->getFlashBag()->add('success', 'Edited Successfully!');
            return $this->redirectToRoute('entreprise_edit', array('id' => $entreprise->getId()));
        }
        return $this->render('entreprise/edit.html.twig', array(
            'entreprise' => $entreprise,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    
    

    /**
     * Deletes a Entreprise entity.
     *
     * @Route("/{id}", name="entreprise_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Entreprise $entreprise)
    {
    
        $form = $this->createDeleteForm($entreprise);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($entreprise);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'The Entreprise was deleted successfully');
        } else {
            $this->get('session')->getFlashBag()->add('error', 'Problem with deletion of the Entreprise');
        }
        
        return $this->redirectToRoute('entreprise');
    }
    
    /**
     * Creates a form to delete a Entreprise entity.
     *
     * @param Entreprise $entreprise The Entreprise entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Entreprise $entreprise)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('entreprise_delete', array('id' => $entreprise->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
    
    /**
     * Delete Entreprise by id
     *
     * @Route("/delete/{id}", name="entreprise_by_id_delete")
     * @Method("GET")
     */
    public function deleteByIdAction(Entreprise $entreprise){
        $em = $this->getDoctrine()->getManager();
        
        try {
            $em->remove($entreprise);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'The Entreprise was deleted successfully');
        } catch (Exception $ex) {
            $this->get('session')->getFlashBag()->add('error', 'Problem with deletion of the Entreprise');
        }

        return $this->redirect($this->generateUrl('entreprise'));

    }
    

    /**
    * Bulk Action
    * @Route("/bulk-action/", name="entreprise_bulk_action")
    * @Method("POST")
    */
    public function bulkAction(Request $request)
    {
        $ids = $request->get("ids", array());
        $action = $request->get("bulk_action", "delete");

        if ($action == "delete") {
            try {
                $em = $this->getDoctrine()->getManager();
                $repository = $em->getRepository('AppBundle:Entreprise');

                foreach ($ids as $id) {
                    $entreprise = $repository->find($id);
                    $em->remove($entreprise);
                    $em->flush();
                }

                $this->get('session')->getFlashBag()->add('success', 'entreprises was deleted successfully!');

            } catch (Exception $ex) {
                $this->get('session')->getFlashBag()->add('error', 'Problem with deletion of the entreprises ');
            }
        }

        return $this->redirect($this->generateUrl('entreprise'));
    }
    

}
