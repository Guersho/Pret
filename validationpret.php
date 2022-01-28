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
<div id="header">
    <img class="logo" src="images/logo.gif">
    <img class="logo" src="images/titre.png">
    <div>
    <?php
      $users=$bdd->query('SELECT NomGes, PrenomGes From gestionnaire' );
      $users->execute();
      $users=$users->fetchall(); 
      foreach($users as $row){
        echo"<p class='head-nav'>"."Bienvenue ".$row['PrenomGes']." ".$row['NomGes']." | <a href='acceuil.php'>Accueil</a> | Plan | Déconnexion </p>";
      }
    ?>
    </div>
    <ul id="nav">
        <a href='horaires.php'><li >MAJ plage horaire</li></a>
        <a href='receptionmateriel.php'><li>Réception Matériel</li></a>
        <a href='validationpret.php'><li style="background-color:#00FFFF;">Validation prêt</li></a>
        <a href='ajout.php'><li>Ajout matériel</li></a>
        <a href='ajoutmodele.php'><li>Ajout modèle</li></a>
    </ul>
</div>
<div id="corpsVP">
    

<?php


// Si tout va bien, on peut continuer


//on récupère les données pour le tableau demande
//on prends donc  
$allusers = $bdd->query('SELECT * 
FROM materiel M, emprunter Em, emprunteur E, contrat C, formation F, categorie_mat Ca, demander D
WHERE Em.EmailEmp=E.EmailEmp 
AND M.NumMat=Em.NumMat 
AND C.NumCont=Em.NumCont 
AND E.CodeForma=F.CodeForma 
AND D.NumCont=C.NumCont
AND Ca.CodeCateMat=M.CodeCateMat');

if(empty($allusers)){
    echo"<div class='vide'>Aucune nouvelle demande de prêt</div>";
}
else{
    echo"<h1>DEMANDE</h1>";
    echo'<form method="GET">';
        echo"<input type='search' class='info-input' name='s' placeholder='Rechercher un emprunteur'>";
        echo"<input type='submit' class='search_' name='envoyer'>
    </form>
    <section class=afficher_users>";
        
        echo "<table class='demande' border='1'>\n";
        echo "<tr>\n";
        echo "<th><strong>Numéro du Contrat</strong></th>\n";
        echo "<th><strong>Identifiant demandeur</strong></th>\n";
        echo "<th><strong>Nom</strong></th>\n";
        echo "<th><strong>Prénom</strong></th>\n";
        echo "<th><strong>Formation</strong></th>\n";
        echo "<th><strong>Matériel demandé</strong></th>\n";
        echo "<th><strong>Date de la demande</strong></th>\n";
        echo "<th><strong>Date de retour prévu</strong></th>\n";

        echo "</tr>\n";
      
        if($allusers->rowCount()>0){
            while ($user = $allusers->fetch()) {
                echo '<tr class="select">';
                echo"<td>".$user['C.NumComt']."</td>";
                echo"<td>".$user['E.EmailEmp']."</td>";
                echo"<td>".$user['E.NomEmp']."</td>";
                echo"<td>".$user['E.PrenomEmp']."</td>";
                echo"<td>".$user['F.LibelleForma']."</td>";
                echo"<td>".$user['EmailEmp']."</td>";
                echo '</tr>'."\n";
              
              
            }
        }
        else{
          
          echo"<p>Aucune demande à ce nom trouvé</p>";
          
        }
        echo '</table>'."\n";// fin du tableau.
       
    echo"</section>";   
    
    echo"<input type='submit' class='valid-button' value='SELECTIONNER'>";
    
    echo"<h1>MATERIEL</h1>";
    echo"<label for='identifiant'>Numéro du matériel </label>";
    echo"<input type='text' class='' name='identifiant' placeholder='Numéro du matériel'>";
    

    $materiel = $bdd->query('SELECT NumMat, Type, Marque, Modele, Stockage, RAM, CarteGraphique, DateReception FROM materiel M, categorie_mat C WHERE M.CodeCateMat=C.CodeCateMat');
    $table_materiel=$materiel->fetchall();
    //entete
    echo "<table class='materiel' border='1'>\n";
    echo "<tr>\n";
    echo "<th><strong>Numéro</strong></th>\n";
    echo "<th><strong>Type</strong></th>\n";
    echo "<th><strong>Marque</strong></th>\n";
    echo "<th><strong>Modèle</strong></th>\n";
    echo "<th><strong>Capacité de stockage</strong></th>\n";
    echo "<th><strong>Memoire RAM</strong></th>\n";
    echo "<th><strong>Mémoire graphique demandé</strong></th>\n";
    echo "<th><strong>Année d'acquisition</strong></th>\n";

    echo "</tr>\n";
    
    foreach($table_materiel as $row){
        echo '<tr class="select">';
        echo '<td>'.$row["NumMat"].'</td>';
        echo '<td>'.$row["Type"].'</td>';
        echo '<td>'.$row["Marque"].'</td>';
        echo '<td>'.$row["Modele"].'</td>';
        echo '<td>'.$row["Stockage"].'</td>';
        echo '<td>'.$row["RAM"].'</td>';
        echo '<td>'.$row["CarteGraphique"].'</td>';
        echo '<td>'.$row["DateReception"].'</td>';
        echo '</tr>'."\n";
    } 
    echo '</table>'."\n";// fin du tableau.
    
    echo"<input type='submit' class='valid-button' value='SELECTIONNER'>";

    echo"<h1>RESUME</h1>";

    

    $resume = $bdd->query('SELECT NumMat, RAZ FROM materiel');
    $resume->execute();
    $table_resume=$resume->fetchall();
    echo "<table class='resume' border='1'>\n";
    echo "<tr>\n";
    echo "<th><strong>Numéro du matériel</strong></th>\n";
    echo "<th><strong>Type</strong></th>\n";
    echo "<th><strong>Numéro de la demande</strong></th>\n";
    echo "<th><strong>Nom de l'emprunteur</strong></th>\n";
    echo "<th><strong>Prénom de l'emprunteur</strong></th>\n";
    echo "<th><strong>Gestionnaire</strong></th>\n";
    echo "<th><strong>Date de retrait</strong></th>\n";

    echo "</tr>\n";
    
    foreach($table_resume as $row){
        echo '<tr class="select">';
        echo '</tr>'."\n";
    } 
    echo '</table>'."\n";// fin du tableau.
    
    
    echo"<input type='submit' class='valid-button' value='VALIDER'>";
    echo"<input type='reset' class='valid-button' value='RETOUR'>";
}
?>
</div>
<script>
    /* * Selectionne la ligne via un click sur une des cellules
    * @param Event oEvent
    */
    function selecteLigne(oEvent){ 
    var sClass ="selectedLigne",
        oTr = oEvent.currentTarget;
    // voir classList.toggle
    if(oTr.classList.contains(sClass)){
        oTr.classList.remove(sClass);
    }else{
        oTr.classList.add(sClass);
    }//else
    }//fct

    /**
    * Selectionne la ligne et parcours ses cellules
    * @param Event oEvent
    */
    function getCelluleLigne(oEvent){ 
        var sMg= ""
        /* je récupère l'objtet TR*/
        oTr = oEvent.currentTarget, 
        /* je récupère les cellules du TD */
        oTds = oTr.cells,
        iNbTds = oTr.cells.length ;
    for(var i = 0 ;i < iNbTds; i++){
        sMg +=oTds[i].innerText+"\n";
    }//for
    //selecteLigne(oTr);
    alert(sMg); 
    }//
    
</script>
</body>
</html>