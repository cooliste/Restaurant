<?php
if(!empty($_GET['id'])){

    $host     = 'localhost';
    $username = 'root';
    $password = ' ';
    $db     = 'test';
    
    //Créer une connexion et sélectionner la base de données
    $db = new mysqli($host, $username, $password, $db);
    
    // Vérifier la connexion
    if($db->connect_error){
        die("Erreur de connexion: " . $db->connect_error);
    }
    
    //Récupérer l'image à partir du base de données
    $res = $db->query("SELECT image FROM gallery WHERE id = {$_GET['id']}");
    
    if($res->num_rows > 0){
        $img = $res->fetch_assoc();
        
        //Rendre l'image
        header("Content-type: image/jpg"); 
        echo $img['image']; 
    }else{
        echo 'Image non trouvée...';
    }
}
?>