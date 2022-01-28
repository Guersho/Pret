<?php
try
{
  // On se connecte à MySQL
  $bdd = new PDO('mysql:host=localhost;dbname=pret_old;charset=utf8', 'root', '');
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
    <div>
    <?php
      $users=$bdd->query('SELECT NomEmp, PrenomEmp From EMPRUNTEUR' );
      $users->execute();
      $users=$users->fetchall(); 
      foreach($users as $row){
        echo"<p class='head-nav'>"."Bienvenue ".$row['PrenomEmp']." ".$row['NomEmp']." | <a href='acceuil.php'>Accueil</a> | Plan | Déconnexion </p>";
      }
    ?>
    </div>
    <ul id="nav">
      <a href='demande.php'><li>Demande de prêt</li></a>
      <a href='retour.php'><li style="background-color:#00FFFF;">Retour de matériel</li></a>
    </ul>
</div>
<div id="corpsVP">
    
    <?php 
      $allusers=$bdd->query('SELECT C.Type, M.NumMat, E.Dateretrait
      FROM CATEGORIE_MAT C, MATERIEL M, EMPRUNTER E, EMPRUNTEUR EM
      WHERE E.NumMat = M.NumMat 
      AND M.CodeCateMat = C.CodeCateMat 
      AND E.EmailEmp = EM.EmailEmp 
      AND E.emailemp="andre.michaux@ut-capitole.com" ');
      if(empty($allusers))
      {
        echo"<div class='vide'>Aucun prêt en cours</div>";
      }
      else
      {
        echo"<h1>Liste de vos prêts en cours</h1>";
        echo"<p>Date</p>";
        echo'<form method="GET">';
        echo"<input type='date' class='info-input' name='s' placeholder='Date de retrait'>";
        echo"<input type='submit' class='search_' name='Rechercher'>
    </form>
    <section class=afficher_users>";
        
        echo "<table class='encours' border='1'>\n";
        echo "<tr>\n";
        echo "<th><strong>Type de matériel</strong></th>\n";
        echo "<th><strong>Numéro du matériel</strong></th>\n";
        echo "<th><strong>Date de retrait</strong></th>\n";
        echo "<th></th>\n";
        echo "</tr>\n";
      
        if($allusers->rowCount()>0){
            while ($user = $allusers->fetch()) {
  
              echo"<td>".$user['Type']."</td>";
              echo"<td>".$user['NumMat']."</td>";
              echo"<td>".$user['Dateretrait']."</td>";
              echo"<td><input type='radio' name='selection' value='Ticket' checked id='id_paiement'></td>";
              echo "</tr>\n";
            }

        }
        else{
          
          echo"<p>Aucun prêt en cours</p>";
          
        }
          }
      
    ?>

     <?php 
      $allusers=$bdd->query('SELECT C.Type, M.NumMat, E.Dateretrait
      FROM CATEGORIE_MAT C, MATERIEL M, EMPRUNTER E, EMPRUNTEUR EM
      WHERE E.NumMat = M.NumMat 
      AND M.CodeCateMat = C.CodeCateMat 
      AND E.EmailEmp = EM.EmailEmp 
      AND E.emailemp="andre.michaux@ut-capitole.com" ');
        echo '</table>'."\n";// fin du tableau.
         echo "<br>";
         echo "<br>";
         echo "<br>";
            echo "<table border='1'>";
            echo "<tr>";
            echo    "<th>";
            echo    "<span>Type de matériel </span>";
            echo    "</th>";
            echo    "<th>Numéro du matériel</th>";
            echo    "<th>";
            echo    "<span>Date de retrait </span>";
            echo    "</th>";
            echo    "<th>Date de retour dispo</th>";
            echo    "</th>";
            echo    "<th>Date de retour souhaitée</th>";
            echo  "</tr>";
            echo "<tr>";
            echo    "<th>";
            echo    "<span></span>";
            echo    "</th>";
            echo    "<th></th>";
            echo    "<th>";
            echo    "<span></span>";
            echo    "</th>";
            echo    "<th></th>";
            echo    "</th>";
            echo    "<th></th>";
            echo  "</tr>";
            echo "</table>";
        echo"</section>";   
       
    ?>
</div>
</div>
</body>
</html>