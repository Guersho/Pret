<?php
?><?php
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
 ?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="style2.css">

<script type="text/javascript" src="index.js"></script>
</head>
<body onload="cacher();">

<div id="header">
    <img class="logo" src="images/logo.gif">
    <img class="logo" src="images/titre.png">
    <div>
    <?php
      $users=$bdd->query('SELECT NomGes, PrenomGes From gestionnaire');
      $users->execute();
      $users=$users->fetchall();
      foreach($users as $row){
        echo"<p class='head-nav'>"."Bienvenue ".$row['PrenomGes']." ".$row['NomGes']." | <a href='acceuil.php'>Accueil</a> | Plan | Déconnexion </p>";
      }
    ?>
    </div>
    <ul id="nav">
        <a href='horaires.php'><li >MAJ plage horaire</li></a>
        <a href='receptionmateriel.php'><li style="background-color:#00FFFF;">Réception Matériel</li></a>
        <a href='validationpret.php'><li>Validation prêt</li></a>
        <a href='ajout.php'><li>Ajout matériel</li></a>
        <a href='ajoutmodele.php'><li>Ajout modèle</li></a>
    </ul>
</div>

<div id="big">
<div id="rdvNormal">


<table>
  <h2>Liste des rendez-vous</h2>
  <tr>
<form method="get">
  <input type='search' class='info-input' name='s' placeholder='Rechercher un emprunteur'>
  <input type='submit' class='valid-button' name='envoyer'>

</form>
  </tr>
  <tr class="type_button">
    <label for="type-select" class="listeChoix">Type de matériel</label>

    <select name="materiel" id="list_materiel">
        <option value="dog">Ordinateur portable</option>
        <option value="cat">Clé 3g</option>
        <option value="hamster">Tablette</option>
        <option value="parrot">Caméra</option>
    </select>
  </tr>

</table>
<?php
//Préparation requête
$pret=$bdd->prepare('SELECT NumCont, NumMat, EmailEmp, DateRetourSouhaite, DateRetourReel, NomEmp FROM demnder D, emprunteur Em WHERE Em.EmailEmp=E.EmailEmp');
$pret->execute();
$table_pret=$pret->fetchall();

//Entete tableau
echo "<table class='listerdv' border='1'>\n";
echo "<tr>\n";
echo "<th><strong>Numéro de prêt</strong></th>\n";
echo "<th><strong>Numéro matériel</strong></th>\n";
echo "<th><strong>E-mail emprunteur</strong></th>\n";
echo "<th><strong>Nom emprunteur</strong></th>\n";
echo "<th><strong>Date de retrait</strong></th>\n";
echo "<th><strong>Date du RDV</strong></th>\n";

echo "</tr>\n";

//Boucle pour tableau
foreach ($table_pret as $row) {
  echo '<tr>';
  echo '<td>'.$row["NumCont"].'</td>';
  echo '<td>'.$row["NumMat"].'</td>';
  echo '<td>'.$row["EmailEmp"].'</td>';
  echo '<td>'.$row["NomEmp"].'</td>';
  echo '<td>'.$row["DateRetourSouhaite"].'</td>';
  echo '<td>'.$row["DateRetourReel"].'</td>';
  echo '</tr>'."\n";
}
echo '</table>'."\n";// fin du tableau.
echo"<input type='submit' class='valid-button' value='SELECTIONNER' id='boutton'>";

 ?>

</div>

<!--javascript pour le bouton -->
<div id="boutton">
    <button type="button" id="cache_button" class="valid-button" onclick="return afficher_cacher();">Retour urgent</button>
</div>

<div id="rdvUrgent" class="hide">
  <table>
    <h2>Liste des rendez-vous</h2>
    <tr>
  <form method="get">
    <input type='search' class='info-input' name='s' placeholder='Rechercher un emprunteur'>
    <input type='submit' class='valid-button'>
  </form>
    </tr>
    <tr class="type_button">
      <label for="type-select">Type de matériel</label>

      <select name="materiel" id="list_materiel">
          <option value="dog">Ordinateur portable</option>
          <option value="cat">Clé 3g</option>
          <option value="hamster">Tablette</option>
          <option value="parrot">Caméra</option>
      </select>
    </tr>

  </table>

  <?php
  //Préparation requête
  $pret=$bdd->prepare('SELECT NumCont, NumMat, EmailEmp, DateRetourSouhaite, DateRetourReel, NomEmp FROM emprunter E, emprunteur Em WHERE Em.EmailEmp=E.EmailEmp');
  $pret->execute();
  $table_pret=$pret->fetchall();

  //Entete tableau
  echo "<table class='listerdv' border='1'>\n";
  echo "<tr>\n";
  echo "<th><strong>Numéro de prêt</strong></th>\n";
  echo "<th><strong>Numéro matériel</strong></th>\n";
  echo "<th><strong>E-mail emprunteur</strong></th>\n";
  echo "<th><strong>Nom emprunteur</strong></th>\n";
  echo "<th><strong>Date de retrait</strong></th>\n";
  echo "<th><strong>Date du RDV</strong></th>\n";

  echo "</tr>\n";

  //Boucle pour tableau
  foreach ($table_pret as $row) {
    echo '<tr>';
    echo '<td>'.$row["NumCont"].'</td>';
    echo '<td>'.$row["NumMat"].'</td>';
    echo '<td>'.$row["EmailEmp"].'</td>';
    echo '<td>'.$row["NomEmp"].'</td>';
    echo '<td>'.$row["DateRetourSouhaite"].'</td>';
    echo '<td>'.$row["DateRetourReel"].'</td>';
    echo '</tr>'."\n";
  }
  echo '</table>'."\n";// fin du tableau.
  echo"<input type='submit' class='valid-button' value='SELECTIONNER'>";

   ?>
</div>

<div id="end_resume">
  <?php
  //Entête tableau
  echo "<table class=resume border='1'>\n";
  echo "<tr>\n";
  echo "<th><strong>Numéro de prêt</strong></th>\n";
  echo "<th><strong>Numéro matériel</strong></th>\n";
  echo "<th><strong>E-mail emprunteur</strong></th>\n";
  echo "<th><strong>Nom emprunteur</strong></th>\n";
  echo "<th><strong>Date de retrait</strong></th>\n";
  echo "<th><strong>Date de retour effectif</strong></th>\n";

  echo "</tr>\n";
  ?>
</div>


<div id="end_button">
  <?php
  echo "<input type='button' class='valid-button' value='Imprimer'>";
  echo "<input type='submit' class='valid-button' value='SELECTIONNER'>";
  echo "<input type='reset' class='valid-button' value='RETOUR'>";
   ?>
</div>
</div>
</body>
</html>