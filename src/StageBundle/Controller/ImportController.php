<?php

namespace StageBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use JMS\Serializer\SerializationContext;
use AppBundle\Entity\Entreprise;
use AppBundle\Entity\Stage;



/**
 * @Route("/import")
 */
class ImportController extends Controller
{

  /**
   *
   * @Route("/", name="user")
   * @Method("GET")
   */
    public function indexAction()
    {
        return $this->render('StageBundle:Import:import.html.twig');
    }


    public function NewEntrepriseAction(Request $request){
      $em = $this->getDoctrine()->getManager();
      $entreprise = $em->getRepository('AppBundle:Entreprise')->findOneByNom(intval($request->get('nom')));
      if (!isset($entreprise)) {
        $entreprise = new Entreprise();
        $entreprise->setNom($request->get('nom'));
        $entreprise->setAdresse($request->get('adresse'));
        $entreprise->setNumtel($request->get('tel'));
        $em->persist($entreprise);
        $em->flush();
        $serializer = $this->container->get('serializer');
      }
      return new Response($serializer->serialize($entreprise, 'json', SerializationContext::create()->enableMaxDepthChecks()));
    }

    public function NewEtudiantAction(Request $request){
      $em = $this->getDoctrine()->getManager();
      $etudiant = $em->getRepository('AppBundle:Etudiant')->findOneBy(
        array('nom' => intval($request->get('nom')), 'prenom' => intval($request->get('nom')))
      );
      if (!isset($etudiant)) {
        $etudiant = new Etudiant();

      $etudiant->setNom('');
      $etudiant->setPrenom($request->get('prenom'));
      $etudiant->setEnabled(0);
      $em->persist($etudiant);
      $em->flush();
      $serializer = $this->container->get('serializer');
      }
      return new Response($serializer->serialize($etudiant, 'json', SerializationContext::create()->enableMaxDepthChecks()));
    }


    /**
     * Lists all User entities.
     *
     * @Route("/import/new", name="import")
     * @Method("POST")
     */
    public function NewStageAction(Request $request){
      $em = $this->getDoctrine()->getManager();
      $stage = $em->getRepository('AppBundle:Stage')->findOneById(intval($request->get('id')));
      if (!isset($stage)) {
        $stage = new Stage();
      }
      $stage->setIntitule($request->get('intitule'));
      $stage->setDescription($request->get('description'));
      $stage->setEtat($request->get('etat'));
      $stage->setIdentreprise($em->getRepository('AppBundle:Entreprise')->findOneById(intval($request->get('entreprise'))));
      $stage->setIdetudiant($em->getRepository('AppBundle:User')->findOneById(intval($request->get('user'))));
      foreach ($request->get('competences') as $competence) {
        $stage->addCompetences($em->getRepository('AppBundle:Competence')->findOneById($competence));
      }
      $em->persist($stage);
      $em->flush();
      $serializer = $this->container->get('serializer');
      return new Response($serializer->serialize($stage, 'json', SerializationContext::create()->enableMaxDepthChecks()));
    }
}
