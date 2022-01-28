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

if(isset($_POST['submit'])){
  if(isset($_POST['identifiant'], $_POST['anneeA'])){
    if($_POST['identifiant']!='' && $_POST['anneeA']!=''){
      $identifiant=$_POST['identifiant'];
      $anneeA=$_POST['anneeA'];
      $modele=$bdd->query('SELECT CodeCateMat FROM categorie_mat WHERE Modele='.$_POST['modele'].'');
      $modele=$modele->fetch();
      //Préparation de la requête d'insertion
      $insertion = "INSERT INTO materiel (NumMat, DateReception, RAZ, Commentaire, CodeCateMat) VALUES ('$identifiant','$anneeA','OUI','','$code')";
      $execute=$bdd->query($insertion);
      if($execute==true){
        $msgSucess="Le matériel a été enregistrée !";
      }else{
        $msgError="Le modèle n'as pas pu être enregistrer";
      }
    }else{
      $msgError="Veuillez renseigner tous les champs obligatoires (*)";
    }
  }
}   
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="style.css" />
</head>
<body>
<div id="header">
    <img class="logo" src="images/logo.gif">
    <img class="logo" src="images/titre.png">
    <div>
    <?php
      $users=$bdd->query('SELECT NomGes, PrenomGes From gestionnaire' );
      $users=$users->fetchall(); 
      foreach($users as $row){
        echo"<p class='head-nav'>"."Bienvenue ".$row['PrenomGes']." ".$row['NomGes']." | <a href='acceuil.php'>Accueil</a> | Plan | Déconnexion </p>";
      }
    ?>
    </div>
    
    <ul id="nav">
        <a href='horaires.php'><li>MAJ plage horaire</li></a>
        <a href='receptionmateriel.php'><li>Réception Matériel</li></a>
        <a href='validationpret.php'><li>Validation prêt</li></a>
        <a href='ajout.php'><li style="background-color:#00FFFF;">Ajout matériel</li></a>
      <a href='ajoutmodele.php'><li>Ajout modèle</li></a>
        
    </ul>
</div>
<div id="corps">
    <div id="nouveaumodele">
      <form action='ajout.php' method='POST'>
        <label for="typemat">Type</label>
        <select name="typemat" class="info-select" id="type-select" required>
          <option value="">--Sélectionnez un matériel--</option>
          <option value="PC">Ordinateur portable</option>
          <option value="tablette">Tablette</option>
          <option value="cle">Clé 4G</option>
        </select> 

        

        <label for="modele">Modèle</label>
        <select name="modele" class="info-select" id="modele-select" required>
          <option value="">--Sélectionnez un modele--</option>
          <?php
            //requete
          $modele=$bdd->query('SELECT * From categorie_mat');
          $table_bdd=$modele->fetchall();
          //on ajoute touts les modèles exsistant de la base de donées
          foreach($table_bdd as $row){
      
            echo '<option value="'.$row["Modele"].'">'.$row["Marque"].' '.$row["Modele"].'</option>';
    
          }
        
          ?>
        </select>
        
        <label for="quantite">Quantité</label>
        <input type="number" class="info-input" name="quantite" id="quantite" required>

        <label for="bondecommande">Bon de commande</label>
        <input type="file" class="info-input" name="bondecommande">

        <label for="annee">Année d'acquisition</label>
        <input type="year" class="info-input" name="annee" id="annee" required>

        <input type='button' class='add-button' value='VALIDER' name='valider_modele' onclick="compteur()">
        <input type="button" value="NOUVEAU MODELE" class='add-button' onClick="window.location.href='ajoutmodele.php'">
      </form>
    </div>
    <div id="nouveaumateriel">
      <input type="number" class="compt-input" name="compteur1" id="compteur1">/
      <input type="number" class="compt-input" name="compteur" id="compteur"></br>
        
      <form action='ajout.php' method='POST'>
           
        <label for="identifiant">Identifiant du matériel</label>
        <input type="text" class="info-input" name="identifiant" id="identifiant" required>

        <label for="annee">Année d'acquisition</label>
        <input type="year" class="info-input" name="anneeA" id="anneeA">

        <label for="stockage">Stockage</label>
        <input type="text" class="info-input" name="stockage">

        <label for="ram">RAM</label>
        <input type="text" class="info-input" name="ram">

        <label for="cg">Carte Graphique</label>
        <input type="text" class="info-input" name="cg">

        <input type='button' class='info-button' value='VALIDER' name='addmat' onclick='ajoutermat()'>
        <input type="reset" value="ANNULER" class='info-button'>
        </form>
    </div>
</div>
<script>
function compteur(){
  if (document.getElementById('quantite').value) {

  document.getElementById('compteur1').value=1
  document.getElementById('compteur').value=document.getElementById('quantite').value

  document.getElementById('anneeA').value=document.getElementById('annee').value
  }
  else{
    alert('saisir une quantité à insérer')
  }
}
function ajoutermat(){
  if(document.getElementById('compteur1').value<document.getElementById('compteur').value){
    if(document.getElementById('identifiant').value){
      document.getElementById('compteur1').value=parseInt(document.getElementById('compteur1').value)+1
      document.getElementById('identifiant').value=''
    }else{
      alert("Renseignez l'identifiant du matériel")
    }
  }else{
    alert("Quantité maximale atteinte");
  }
  
}
</script>
</body>
</html>