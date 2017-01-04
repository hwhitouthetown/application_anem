<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\View\TwitterBootstrap3View;

use AppBundle\Entity\Etudiant;

/**
 * Etudiant controller.
 *
 * @Route("/etudiant")
 */
class EtudiantController extends Controller
{
    /**
     * Lists all Etudiant entities.
     *
     * @Route("/", name="etudiant")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $queryBuilder = $em->getRepository('AppBundle:Etudiant')->createQueryBuilder('e');
        
        list($filterForm, $queryBuilder) = $this->filter($queryBuilder, $request);
        list($etudiants, $pagerHtml) = $this->paginator($queryBuilder, $request);
        
        return $this->render('etudiant/index.html.twig', array(
            'etudiants' => $etudiants,
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
        $filterForm = $this->createForm('AppBundle\Form\EtudiantFilterType');

        // Reset filter
        if ($request->get('filter_action') == 'reset') {
            $session->remove('EtudiantControllerFilter');
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
                $session->set('EtudiantControllerFilter', $filterData);
            }
        } else {
            // Get filter from session
            if ($session->has('EtudiantControllerFilter')) {
                $filterData = $session->get('EtudiantControllerFilter');
                
                foreach ($filterData as $key => $filter) { //fix for entityFilterType that is loaded from session
                    if (is_object($filter)) {
                        $filterData[$key] = $queryBuilder->getEntityManager()->merge($filter);
                    }
                }
                
                $filterForm = $this->createForm('AppBundle\Form\EtudiantFilterType', $filterData);
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
            return $me->generateUrl('etudiant', $requestParams);
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
     * Displays a form to create a new Etudiant entity.
     *
     * @Route("/new", name="etudiant_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
    
        $etudiant = new Etudiant();
        $form   = $this->createForm('AppBundle\Form\EtudiantType', $etudiant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($etudiant);
            $em->flush();
            
            $editLink = $this->generateUrl('etudiant_edit', array('id' => $etudiant->getId()));
            $this->get('session')->getFlashBag()->add('success', "<a href='$editLink'>New etudiant was created successfully.</a>" );
            
            $nextAction=  $request->get('submit') == 'save' ? 'etudiant' : 'etudiant_new';
            return $this->redirectToRoute($nextAction);
        }
        return $this->render('etudiant/new.html.twig', array(
            'etudiant' => $etudiant,
            'form'   => $form->createView(),
        ));
    }
    

    /**
     * Finds and displays a Etudiant entity.
     *
     * @Route("/{id}", name="etudiant_show")
     * @Method("GET")
     */
    public function showAction(Etudiant $etudiant)
    {
        $deleteForm = $this->createDeleteForm($etudiant);
        return $this->render('etudiant/show.html.twig', array(
            'etudiant' => $etudiant,
            'delete_form' => $deleteForm->createView(),
        ));
    }
    
    

    /**
     * Displays a form to edit an existing Etudiant entity.
     *
     * @Route("/{id}/edit", name="etudiant_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Etudiant $etudiant)
    {
        $deleteForm = $this->createDeleteForm($etudiant);
        $editForm = $this->createForm('AppBundle\Form\EtudiantType', $etudiant);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($etudiant);
            $em->flush();
            
            $this->get('session')->getFlashBag()->add('success', 'Edited Successfully!');
            return $this->redirectToRoute('etudiant_edit', array('id' => $etudiant->getId()));
        }
        return $this->render('etudiant/edit.html.twig', array(
            'etudiant' => $etudiant,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    
    

    /**
     * Deletes a Etudiant entity.
     *
     * @Route("/{id}", name="etudiant_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Etudiant $etudiant)
    {
    
        $form = $this->createDeleteForm($etudiant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($etudiant);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'The Etudiant was deleted successfully');
        } else {
            $this->get('session')->getFlashBag()->add('error', 'Problem with deletion of the Etudiant');
        }
        
        return $this->redirectToRoute('etudiant');
    }
    
    /**
     * Creates a form to delete a Etudiant entity.
     *
     * @param Etudiant $etudiant The Etudiant entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Etudiant $etudiant)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('etudiant_delete', array('id' => $etudiant->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
    
    /**
     * Delete Etudiant by id
     *
     * @Route("/delete/{id}", name="etudiant_by_id_delete")
     * @Method("GET")
     */
    public function deleteByIdAction(Etudiant $etudiant){
        $em = $this->getDoctrine()->getManager();
        
        try {
            $em->remove($etudiant);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'The Etudiant was deleted successfully');
        } catch (Exception $ex) {
            $this->get('session')->getFlashBag()->add('error', 'Problem with deletion of the Etudiant');
        }

        return $this->redirect($this->generateUrl('etudiant'));

    }
    

    /**
    * Bulk Action
    * @Route("/bulk-action/", name="etudiant_bulk_action")
    * @Method("POST")
    */
    public function bulkAction(Request $request)
    {
        $ids = $request->get("ids", array());
        $action = $request->get("bulk_action", "delete");

        if ($action == "delete") {
            try {
                $em = $this->getDoctrine()->getManager();
                $repository = $em->getRepository('AppBundle:Etudiant');

                foreach ($ids as $id) {
                    $etudiant = $repository->find($id);
                    $em->remove($etudiant);
                    $em->flush();
                }

                $this->get('session')->getFlashBag()->add('success', 'etudiants was deleted successfully!');

            } catch (Exception $ex) {
                $this->get('session')->getFlashBag()->add('error', 'Problem with deletion of the etudiants ');
            }
        }

        return $this->redirect($this->generateUrl('etudiant'));
    }
    

}
