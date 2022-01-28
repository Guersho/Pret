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
<link rel="stylesheet" href="style.css" />
</head>
<body>
<div id="header">
    <img class="logo" src="images/logo.gif">
    <img class="logo" src="images/titre.png">
    <ul id="nav">
      
    <a href='demande.php'><li>Demande de prêt</li></a>
      <a href='retour.php'><li>Retour de matériel</li></a>
      <a href='validationreception.php'><li>Validation reception</li></a>
      <a href='intervention.php'><li style="background-color:#00FFFF;">Intervention</li></a>
    </ul>
</div>
<div id="corps">


</div>
</body>
</html>