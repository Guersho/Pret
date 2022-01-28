<?php
   
     //Tu recuperes l'id du contact
     $id = $_GET["id"];
     //Requete SQL pour supprimer le contact dans la base
     mysql_query("DELETE FROM contact WHERE id = ".$id );
     //Et la tu rediriges vers ta page contacts.php pour rafraichir la liste
?>