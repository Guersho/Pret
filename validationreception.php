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
 ?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="style.css" />
</head>
<body>
<?php

$users=$bdd->query('SELECT NomGes, PrenomGes From gestionnaire' );
$users->execute();
$users=$users->fetchall();

?>
<div id="header">
    <img class="logo" src="images/logo.gif">
    <img class="logo" src="images/titre.png">
    <div>
    <?php 
      foreach($users as $row){
        echo"<p class='head-nav'>"."Bienvenue ".$row['PrenomGes']." ".$row['NomGes']." | <a href='acceuil.php'>Accueil</a> | Plan | Déconnexion </p>";
      }
    ?>
    </div>
    <ul id="nav">
        <a href='demande.php'><li>Demande de prêt</li></a>
        <a href='retour.php'><li>Retour de matériel</li></a>
        <a href='validationreception.php'><li style="background-color:#00FFFF;">Validation reception</li></a>
        <a href='intervention.php'><li>Intervention</li></a>
    </ul>
</div>
<div id="corps">


</div>
</body>
</html>