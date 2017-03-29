<?php
//$file ="L3_2014_2015.xlsx";
require('XLSXReader-master/XLSXReader.php');

if (isset($_GET['file'])){
  $file=$_GET['file'];
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
            if($c==$colNom){$nom=$cell;echo "nom : ".$cell."<br>";}
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
      $url = 'http://robindelaporte.com/application_anem/web/app_dev.php/admin/import/new';
      foreach ($stages as $stage) {
       //echo "Stage -> ".$stage."<br>";

$myvars = 'nom=' . $stage['nom'] . '&prenom=' . $stage['prenom'] . '&titre=' . $stage['titre'] . '&entreprise=' . $stage['entreprise'] . '&adresse=' . $stage['adresse'] .  '&tel=' . $stage['tel'];

$ch = curl_init( $url );
curl_setopt( $ch, CURLOPT_POST, 1);
curl_setopt( $ch, CURLOPT_POSTFIELDS, $myvars);
curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt( $ch, CURLOPT_HEADER, 0);
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);

$response = curl_exec( $ch );
      }
      echo "\n";
    }
    $r++;
  }
}
?>
