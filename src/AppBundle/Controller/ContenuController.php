<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\View\TwitterBootstrap3View;

use AppBundle\Entity\Contenu;

/**
 * Contenu controller.
 *
 * @Route("/contenu")
 */
class ContenuController extends Controller
{
    /**
     * Lists all Contenu entities.
     *
     * @Route("/", name="contenu")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $queryBuilder = $em->getRepository('AppBundle:Contenu')->createQueryBuilder('e');
        
        list($filterForm, $queryBuilder) = $this->filter($queryBuilder, $request);
        list($contenus, $pagerHtml) = $this->paginator($queryBuilder, $request);
        
        return $this->render('contenu/index.html.twig', array(
            'contenus' => $contenus,
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
        $filterForm = $this->createForm('AppBundle\Form\ContenuFilterType');

        // Reset filter
        if ($request->get('filter_action') == 'reset') {
            $session->remove('ContenuControllerFilter');
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
                $session->set('ContenuControllerFilter', $filterData);
            }
        } else {
            // Get filter from session
            if ($session->has('ContenuControllerFilter')) {
                $filterData = $session->get('ContenuControllerFilter');
                
                foreach ($filterData as $key => $filter) { //fix for entityFilterType that is loaded from session
                    if (is_object($filter)) {
                        $filterData[$key] = $queryBuilder->getEntityManager()->merge($filter);
                    }
                }
                
                $filterForm = $this->createForm('AppBundle\Form\ContenuFilterType', $filterData);
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
            return $me->generateUrl('contenu', $requestParams);
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
     * Displays a form to create a new Contenu entity.
     *
     * @Route("/new", name="contenu_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
    
        $contenu = new Contenu();
        $form   = $this->createForm('AppBundle\Form\ContenuType', $contenu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($contenu);
            $em->flush();
            
            $editLink = $this->generateUrl('contenu_edit', array('id' => $contenu->getId()));
            $this->get('session')->getFlashBag()->add('success', "<a href='$editLink'>New contenu was created successfully.</a>" );
            
            $nextAction=  $request->get('submit') == 'save' ? 'contenu' : 'contenu_new';
            return $this->redirectToRoute($nextAction);
        }
        return $this->render('contenu/new.html.twig', array(
            'contenu' => $contenu,
            'form'   => $form->createView(),
        ));
    }
    

    /**
     * Finds and displays a Contenu entity.
     *
     * @Route("/{id}", name="contenu_show")
     * @Method("GET")
     */
    public function showAction(Contenu $contenu)
    {
        $deleteForm = $this->createDeleteForm($contenu);
        return $this->render('contenu/show.html.twig', array(
            'contenu' => $contenu,
            'delete_form' => $deleteForm->createView(),
        ));
    }
    
    

    /**
     * Displays a form to edit an existing Contenu entity.
     *
     * @Route("/{id}/edit", name="contenu_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Contenu $contenu)
    {
        $deleteForm = $this->createDeleteForm($contenu);
        $editForm = $this->createForm('AppBundle\Form\ContenuType', $contenu);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($contenu);
            $em->flush();
            
            $this->get('session')->getFlashBag()->add('success', 'Edited Successfully!');
            return $this->redirectToRoute('contenu_edit', array('id' => $contenu->getId()));
        }
        return $this->render('contenu/edit.html.twig', array(
            'contenu' => $contenu,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    
    

    /**
     * Deletes a Contenu entity.
     *
     * @Route("/{id}", name="contenu_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Contenu $contenu)
    {
    
        $form = $this->createDeleteForm($contenu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($contenu);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'The Contenu was deleted successfully');
        } else {
            $this->get('session')->getFlashBag()->add('error', 'Problem with deletion of the Contenu');
        }
        
        return $this->redirectToRoute('contenu');
    }
    
    /**
     * Creates a form to delete a Contenu entity.
     *
     * @param Contenu $contenu The Contenu entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Contenu $contenu)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('contenu_delete', array('id' => $contenu->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
    
    /**
     * Delete Contenu by id
     *
     * @Route("/delete/{id}", name="contenu_by_id_delete")
     * @Method("GET")
     */
    public function deleteByIdAction(Contenu $contenu){
        $em = $this->getDoctrine()->getManager();
        
        try {
            $em->remove($contenu);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'The Contenu was deleted successfully');
        } catch (Exception $ex) {
            $this->get('session')->getFlashBag()->add('error', 'Problem with deletion of the Contenu');
        }

        return $this->redirect($this->generateUrl('contenu'));

    }
    

    /**
    * Bulk Action
    * @Route("/bulk-action/", name="contenu_bulk_action")
    * @Method("POST")
    */
    public function bulkAction(Request $request)
    {
        $ids = $request->get("ids", array());
        $action = $request->get("bulk_action", "delete");

        if ($action == "delete") {
            try {
                $em = $this->getDoctrine()->getManager();
                $repository = $em->getRepository('AppBundle:Contenu');

                foreach ($ids as $id) {
                    $contenu = $repository->find($id);
                    $em->remove($contenu);
                    $em->flush();
                }

                $this->get('session')->getFlashBag()->add('success', 'contenus was deleted successfully!');

            } catch (Exception $ex) {
                $this->get('session')->getFlashBag()->add('error', 'Problem with deletion of the contenus ');
            }
        }

        return $this->redirect($this->generateUrl('contenu'));
    }
    

}
