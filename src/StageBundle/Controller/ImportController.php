<?php

namespace StageBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
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
   * @Route("/")
   * @Method("GET")
   */
    public function indexAction()
    {
        return $this->render('StageBundle:Import:import.html.twig');
    }


    public function NewEntrepriseAction(String $nom, String $adresse, String $tel){
      $em = $this->getDoctrine()->getManager();
      $entreprise = $em->getRepository('AppBundle:Entreprise')->findOneByNom($nom);
      if (!isset($entreprise)) {
        $entreprise = new Entreprise();
        $entreprise->setNom($nom);
        $entreprise->setAdresse($adresse);
        $entreprise->setNumtel($tel);
        $em->persist($entreprise);
        $em->flush();
        $serializer = $this->container->get('serializer');
      }
      return new Response($serializer->serialize($entreprise, 'json', SerializationContext::create()->enableMaxDepthChecks()));
    }

    public function NewEtudiantAction(String $prenom, String $nom){
      $em = $this->getDoctrine()->getManager();
      $etudiant = $em->getRepository('AppBundle:Etudiant')->findOneBy(
        array('nom' => $nom, 'prenom' => $prenom)
      );
      if (!isset($etudiant)) {
        $etudiant = new Etudiant();

      $etudiant->setNom('');
      $etudiant->setPrenom($prenom);
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
      $entreprise = NewEntrepriseAction($request->post('entreprise'), $request->post('adresse'), $request->post('tel'));
      $etudiant = NewEtudiantAction($request->post('prenom'),$request->post('nom'));
      $stage = $em->getRepository('AppBundle:Stage')->findOneById(intval($request->post('id')));
      if (!isset($stage)) {
        $stage = new Stage();
      }
      $stage->setIntitule($request->post('intitule'));
      $stage->setDescription($request->post('description'));
      $stage->setEtat($request->post('etat'));
      $stage->setIdentreprise($em->getRepository('AppBundle:Entreprise')->findOneById(intval($request->post('entreprise'))));
      $stage->setIdetudiant($em->getRepository('AppBundle:User')->findOneById(intval($request->post('user'))));
      foreach ($request->post('competences') as $competence) {
        $stage->addCompetences($em->getRepository('AppBundle:Competence')->findOneById($competence));
      }
      $em->persist($stage);
      $em->flush();
      $serializer = $this->container->get('serializer');
      return new Response($serializer->serialize($stage, 'json', SerializationContext::create()->enableMaxDepthChecks()));
    }
}
