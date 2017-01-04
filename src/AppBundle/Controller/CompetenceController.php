<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\View\TwitterBootstrap3View;

use AppBundle\Entity\Competence;

/**
 * Competence controller.
 *
 * @Route("/competence")
 */
class CompetenceController extends Controller
{
    /**
     * Lists all Competence entities.
     *
     * @Route("/", name="competence")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $queryBuilder = $em->getRepository('AppBundle:Competence')->createQueryBuilder('e');
        
        list($filterForm, $queryBuilder) = $this->filter($queryBuilder, $request);
        list($competences, $pagerHtml) = $this->paginator($queryBuilder, $request);
        
        return $this->render('competence/index.html.twig', array(
            'competences' => $competences,
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
        $filterForm = $this->createForm('AppBundle\Form\CompetenceFilterType');

        // Reset filter
        if ($request->get('filter_action') == 'reset') {
            $session->remove('CompetenceControllerFilter');
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
                $session->set('CompetenceControllerFilter', $filterData);
            }
        } else {
            // Get filter from session
            if ($session->has('CompetenceControllerFilter')) {
                $filterData = $session->get('CompetenceControllerFilter');
                
                foreach ($filterData as $key => $filter) { //fix for entityFilterType that is loaded from session
                    if (is_object($filter)) {
                        $filterData[$key] = $queryBuilder->getEntityManager()->merge($filter);
                    }
                }
                
                $filterForm = $this->createForm('AppBundle\Form\CompetenceFilterType', $filterData);
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
            return $me->generateUrl('competence', $requestParams);
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
     * Displays a form to create a new Competence entity.
     *
     * @Route("/new", name="competence_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
    
        $competence = new Competence();
        $form   = $this->createForm('AppBundle\Form\CompetenceType', $competence);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($competence);
            $em->flush();
            
            $editLink = $this->generateUrl('competence_edit', array('id' => $competence->getId()));
            $this->get('session')->getFlashBag()->add('success', "<a href='$editLink'>New competence was created successfully.</a>" );
            
            $nextAction=  $request->get('submit') == 'save' ? 'competence' : 'competence_new';
            return $this->redirectToRoute($nextAction);
        }
        return $this->render('competence/new.html.twig', array(
            'competence' => $competence,
            'form'   => $form->createView(),
        ));
    }
    

    /**
     * Finds and displays a Competence entity.
     *
     * @Route("/{id}", name="competence_show")
     * @Method("GET")
     */
    public function showAction(Competence $competence)
    {
        $deleteForm = $this->createDeleteForm($competence);
        return $this->render('competence/show.html.twig', array(
            'competence' => $competence,
            'delete_form' => $deleteForm->createView(),
        ));
    }
    
    

    /**
     * Displays a form to edit an existing Competence entity.
     *
     * @Route("/{id}/edit", name="competence_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Competence $competence)
    {
        $deleteForm = $this->createDeleteForm($competence);
        $editForm = $this->createForm('AppBundle\Form\CompetenceType', $competence);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($competence);
            $em->flush();
            
            $this->get('session')->getFlashBag()->add('success', 'Edited Successfully!');
            return $this->redirectToRoute('competence_edit', array('id' => $competence->getId()));
        }
        return $this->render('competence/edit.html.twig', array(
            'competence' => $competence,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    
    

    /**
     * Deletes a Competence entity.
     *
     * @Route("/{id}", name="competence_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Competence $competence)
    {
    
        $form = $this->createDeleteForm($competence);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($competence);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'The Competence was deleted successfully');
        } else {
            $this->get('session')->getFlashBag()->add('error', 'Problem with deletion of the Competence');
        }
        
        return $this->redirectToRoute('competence');
    }
    
    /**
     * Creates a form to delete a Competence entity.
     *
     * @param Competence $competence The Competence entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Competence $competence)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('competence_delete', array('id' => $competence->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
    
    /**
     * Delete Competence by id
     *
     * @Route("/delete/{id}", name="competence_by_id_delete")
     * @Method("GET")
     */
    public function deleteByIdAction(Competence $competence){
        $em = $this->getDoctrine()->getManager();
        
        try {
            $em->remove($competence);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'The Competence was deleted successfully');
        } catch (Exception $ex) {
            $this->get('session')->getFlashBag()->add('error', 'Problem with deletion of the Competence');
        }

        return $this->redirect($this->generateUrl('competence'));

    }
    

    /**
    * Bulk Action
    * @Route("/bulk-action/", name="competence_bulk_action")
    * @Method("POST")
    */
    public function bulkAction(Request $request)
    {
        $ids = $request->get("ids", array());
        $action = $request->get("bulk_action", "delete");

        if ($action == "delete") {
            try {
                $em = $this->getDoctrine()->getManager();
                $repository = $em->getRepository('AppBundle:Competence');

                foreach ($ids as $id) {
                    $competence = $repository->find($id);
                    $em->remove($competence);
                    $em->flush();
                }

                $this->get('session')->getFlashBag()->add('success', 'competences was deleted successfully!');

            } catch (Exception $ex) {
                $this->get('session')->getFlashBag()->add('error', 'Problem with deletion of the competences ');
            }
        }

        return $this->redirect($this->generateUrl('competence'));
    }
    

}
