<?php
try
{
  // On se connecte à MySQL
  $bdd = new PDO('mysql:host=localhost;dbname=pret;charset=utf8', 'root', '');
}
catch(Exception $e)
{
  // En cas d'erreur, on affiche un message et on arrête tout
        die('Erreur : '.$e->getMessage());
}

// Si tout va bien, on peut continuer
//Ajour du nouveau modele
if(isset($_POST['submit'])){//bouton valider enclenché
  if(isset($_POST['categorie'], $_POST['materiel'], $_POST['retrait'], $_POST['retour'], $_POST['email'], $_POST['nom'], $_POST['prenom'], $_POST['formation'])){
    if($_POST['categorie']!='' && $_POST['materiel']!='' && $_POST['retrait']!='' && $_POST['retour']!='' && $_POST['email']!='' && $_POST['nom']!='' && $_POST['prenom']!='' && $_POST['formation']!=''){
      $type_materiel=$_POST['materiel'];
      $categorie=$_POST['categorie'];
      $retrait=$_POST['retrait'];
      $retour=$_POST['retour'];
      $email=$_POST['email'];

      $codecate=$bdd->query('SELECT');
      
  
      //Préparation de la requête d'insertion
      $insertion = "INSERT INTO demander(DateEmpSouhaite, DateRetourSouhaite, CodeCateMat, EmailEmp) VALUES ('$retrait','$retour','$code','$email')";
      $execute=$bdd->query($insertion);
      if($execute==true){
        $msgSucess="La demande a été enregistrée !";
      }else{
        $msgError="La demande n'as pas pu être effectué";
      }
    }
  }
}
if($_POST) {

  $message=$_POST['nom'];
  $message .=$_POST['prenom'];
  $expediteur=$_POST['email'];

  mail("ut.eleana@gmail.com", "Demande de prêt", $message, "From:'.$expediteur'");
}
function changedateusfr($dateus)
  {
    $datefr=$dateus{8}.$dateus{9}."/".$dateus{5}.$dateus{6}."/".$dateus{0}.$dateus{1}.$dateus{2}.$dateus{3};
    return $datefr;
  }
?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="style.css" />
<title>Demande de pret</title>
</head>
<body>
<?php

$users=$bdd->query('SELECT NomEmp, PrenomEmp From emprunteur' );
$users->execute();
$users=$users->fetchall();

?>
<div id="header">
    <img class="logo" src="images/logo.gif">
    <img class="logo" src="images/titre.png">
    <div id="">
    <?php 
      foreach($users as $row){
        echo"<p class='head-nav'>"."Bienvenue ".$row['PrenomEmp']." ".$row['NomEmp']." | <a href='acceuil.php'>Accueil</a> | Plan | Déconnexion </p>";
      }
    ?>
    </div>
    
    <ul id="nav">
      <a href='demande.php'><li style="background-color:#00FFFF;">Demande de prêt</li></a>
      <a href='retour.php'><li>Retour de matériel</li></a>
    </ul>
</div>
<div id="corps">
  <div id="disponibilite">
  <h1>Disponibilités</h1>
  <?php
  

  // On récupère tout le contenu de la table jeux_video

  $dispo = $bdd->query('SELECT Type, COUNT(*)  FROM materiel M, categorie_mat CM WHERE M.CodeCateMat=CM.CodeCateMat AND RAZ="OUI" GROUP BY Type');
  $table_bdd=$dispo->fetchall();
  if(empty($dispo)){
    echo"<p class='vide'>Aucun matériel disponible</p>";
  }else{
    echo "<table class='dispo' border>";
    echo "<tr>";
    echo "<th>Nom du Matériel</th>";
    echo "<th>Nombre disponible</th>";
    echo "</tr>\n";
    foreach($table_bdd as $row){
        echo '<tr>';
        echo '<td bgcolor="#FFFFFF">'.$row["Type"].'</td>';
        echo '<td bgcolor="#FFFFFF">'.$row["COUNT(*)"].'</td>';
        echo '</tr>'."\n";
    } 
    echo '</table>'."\n";// fin du tableau.
  }
  
  ?>
    
  </div>
  <div id='formulaire'>
    <form class="info" action="" method="post">
      <h1 class="info-title"> Demande de prêt</h1>

      
      <input type="radio" id="etudiant" name="categorie" value="etudiant" onclick="afficherCacher();" checked>
      <label for="etudiant">Etudiant</label>

      <input type="radio" id="personnel" name="categorie" value="personnel" onclick="afficherCacher();" checked>
      <label for="personnel">Personnel</label>

      <input type="radio" id="autres" name="categorie" value="autres" onclick="afficherCacher();" checked>
      <label for="autres">Autres</label>(*)</br>

      <label for="email">E-mail (*)</label>
      <input type="text" class="info-input" id="email" name="email" required /> 

      <label for="nom">Nom (*)</label>
      <input type="text" class="info-input" id="nom" name="nom" required/> 

      <label for="prenom">Prénom (*)</label>
      <input type="text" class="info-input" id="prenom" name="prenom" required /> 

      <div id="etudiantH">
      <label for="num_etu">Numéro étudiant</label>
      <input type="text" class="info-input" id="num_etu" name="num_etu" required /> 
      </div>

      <label for="formation">Formation (*)</label>
      <select name="formation" id="formation-select" class="info-select" required>
          <option value="">--Sélectionnez votre formation--</option>
          
          <?php 
          //requete
          $formations=$bdd->query('SELECT * From formation' );
          $formations->execute();
          $table_bdd=$formations->fetchall();
          //on ajoute toutes les formations exsistant de la base de donées
          foreach($table_bdd as $row){
      
            echo '<option value="'.$row["LibelleForma"].'">'.$row["LibelleForma"].'</option>';
    
          }       
          ?>
          <option value="autres">Autres</option>
      </select>

      <label for="informationplus">Préciser si autres </label>
      <input type="text" class="info-input" name="informationplus" /> 

      <label for="materiel">Matériel (*)</label><br>
      <select name="materiel" id="mat-select" class="info-select">
          <option value="">--Sélectionnez un matériel--</option>
          
          <?php 
          $materiels=$bdd->query('SELECT Type From categorie_mat Group BY Type' );
          $materiels->execute();
          $table_materiels=$materiels->fetchall();
          //on ajoute tous les matériels exsistant de la base de donées
          foreach($table_materiels as $row){
      
            echo '<option value="ordi">'.$row["Type"].'</option>';
    
          }       
          ?>
      </select>

      <label for="date_dispo">Date de retrait disponible (*)</label>
      <select name="date_dispo" id="date-select" class="info-select" required>       
        <?php 
        //requete
        $disponi=$bdd->query('SELECT * From calendrier_2' );
        $table_bdd=$disponi->fetchall();
        //on ajoute tous les dates de dispo de la gestionnaire exsistant de la base de donées
        if(empty($table_bdd)){
          echo '<option value="">Aucune disponnibilité</option>';
        }else{
          foreach($table_bdd as $row){
            echo '<option value="'.$row["DateDispo"].'">'.changedateusfr($row["DateDispo"]).'</option>';
            } 
        }    
          ?>
      </select>

      <label for="retrait">Date de retrait</label>
      <input type="date" class="info-input" name="retrait" required />

      <label for="retour">Date de retour prévue (*)</label>
      <input type="date" class="info-input" name="retour" value="" required /> 
      
      <label for='urgent'>Urgent</label>
      <input type='checkbox' name='urgent' id='urgent' value='urgent'><br>
      
      <div id='msg'>
      <?php
      if(isset($msgError)){
        echo $msgError;
      }elseif(isset($msgSucess)){
        echo $msgSucess;
      }else{
        echo'';
      } 
      ?>
      </div>
      
      <input type="submit" class="info-button" name="submit" value="Valider" >
      <input type="reset" class="info-button" value="Annuler">

      
      

      

      
        
    </form>
  </div>
</div>

<script type="text/javascript">
  function afficherCacher(){
    if(document.getElementById('etudiant').checked){
      document.getElementById('etudiantH').style.display="block";
    }else{
      if(document.getElementById('autres').checked){
        document.getElementById('etudiantH').style.display="none";
      }else{
        if(document.getElementById('personnel').checked){
          document.getElementById('etudiantH').style.display="none";
        }
      }
    }
  }
</script>
</body>
</html>