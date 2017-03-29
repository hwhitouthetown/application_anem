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
require('Ressources/XLSXReader-master/XLSXReader.php');


/**
 * @Route("/import")
 */
class ImportController extends Controller
{
  /**
   *
   * @Route("/", name="import")
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

    public function NewStageAction(String $nom, String $prenom, String $titre, String $entreprise, String $adresse, String $tel, String $promo, String $annee){
      $em = $this->getDoctrine()->getManager();
      $entreprise = NewEntrepriseAction($entreprise, $radresse, $tel);
      $etudiant = NewEtudiantAction($prenom, $nom);
      $promotion = $em->getRepository('AppBundle:Promotion')->findOneBy(
        array('titre' => $promo, 'anneeDebut' => $annee)
      );
      //$stage = $em->getRepository('AppBundle:Stage')->findOneById(intval($request->post('id')));
      if (!isset($stage)) {
        $stage = new Stage();
      }
      $stage->setIntitule($titre);
      $stage->setDescription('');
      $stage->setEtat('en cours');
      $stage->setIdentreprise($entreprise);
      $stage->setIdetudiant($etudiant);
      $em->persist($stage);
      $em->flush();
      $serializer = $this->container->get('serializer');
      return new Response($serializer->serialize($stage, 'json', SerializationContext::create()->enableMaxDepthChecks()));
    }
    /**
     * Create new stage.
     *
     * @Route("/import/new", name="import")
     * @Method("POST")
     */
    public function NewImport(Request $request){
        $file=$request->post('fichier');
        $xlsx = new XLSXReader($file);

        $sheets = $xlsx->getSheetNames();
        print_r($sheets);
        $data = $xlsx->getSheetData($sheets[1]);
        $r=0;
        foreach ($data as $row) {

          if (!isset($rowT)){
              $c=0;
            foreach ($row as $cell) {
              if($cell!=""){
                if(stristr($cell, 'nom') != '' && !isset($colNom)){echo $cell;$colNom=$c;$rowT=$r;}
                elseif(stristr($cell, 'prenom') != '' && !isset($colPrenom)){echo $cell;$colPrenom=$c;}
                elseif(stristr($cell, 'titre') != '' && !isset($colTitre)){echo $cell;$colTitre=$c;}
                elseif(stristr($cell, 'entreprise') != '' && !isset($colEntreprise)){echo $cell;$colEntreprise=$c;}
                elseif(stristr($cell, 'adresse') != '' && !isset($colAdresse)){echo $cell;$colAdresse=$c;}
                  elseif(stristr($cell, 'tel') != '' && !isset($colTel)){echo $cell;$colTel=$c;}
                }
                $c++;
              }
              echo "<br>";
            }

            else{
                $c=0;
              foreach ($row as $cell) {
                  if($c==$colNom){$nom=$cell;}
                  if($c==$colPrenom){$prenom=$cell;}
                  if($c==$colTitre){$titre=$cell;}
                  if($c==$colEntreprise){$entreprise=$cell;}
                  if($c==$colAdresse){$adresse=$cell;}
                  if($c==$colTel){$tel=$cell;}
                  if(isset($nom) && isset($prenom) && isset($titre) && isset($entreprise) && isset($adresse) && isset($tel)){
                    $stages = array('nom'=>$nom, 'prenom'=>$prenom, 'titre'=>$titre, 'entreprise'=>$entreprise, 'adresse'=>$adresse, 'tel'=>$tel);
                  }
              $c++;
            }
            foreach ($stages as $stage) {
             NewStageAction($stage['nom'], $stage['prenom'], $stage['titre'], $stage['entreprise'], $stage['adresse'], $stage['tel'], $request->post('promo'), $request->post('annee'));
            }
          }
          $r++;
        }
    }
}
