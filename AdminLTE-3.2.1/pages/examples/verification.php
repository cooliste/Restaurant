<?php

session_start();
if(isset($_POST['mail']) && isset($_POST['password']))
{
    // connexion à la base de données
    $db_username = 'root';
    $db_password = 'mot_de_passe_bdd';
    $db_name     = 'test';
    $db_host     = 'localhost';
    $db = mysqli_connect($db_host, $db_username, $db_password,$db_name) or die('could not connect to database');
    
    $db = "INSERT INTO 'utilisateurs' (mail, password) VALUES ($_POST['mail'], $_POST['password'])";
if (mysqli_query($conn, $db)) {
      echo "Nouveau enregistrement créé avec succès";
} else {
      echo "Erreur : " . $db . "<br>" . mysqli_error($conn);
}
    // on applique les deux fonctions mysqli_real_escape_string et htmlspecialchars
    // pour éliminer toute attaque de type injection SQL et XSS
    $mail = mysqli_real_escape_string($db,htmlspecialchars($_POST['mail'])); 
    $password = mysqli_real_escape_string($db,htmlspecialchars($_POST['password']));

  /*  $db = "INSERT INTO 'utilisateurs' (mail, password) VALUES ($_POST['mail'], $_POST['password'])";
if (mysqli_query($conn, $db)) {
      echo "Nouveau enregistrement créé avec succès";
} else {
      echo "Erreur : " . $db . "<br>" . mysqli_error($conn);
}*/
    
    if($mail !== "" && $password !== "")
    {
        $requete = "SELECT count(*) FROM utilisateur where 
              mail = '".$mail."' and password = '".$password."' ";
        $exec_requete = mysqli_query($db,$requete);
        $reponse = mysqli_fetch_array($exec_requete);
        $count = $reponse['count(*)'];
        if($count!=0) // mail et mot de passe correctes
        {
           $_SESSION['mail'] = $mail;
           header('Location: principale.php');
        }
        else
        {
           header('Location: login.php?erreur=1'); // utilisateur ou mot de passe incorrect
        }
    }
    else
    {
       header('Location: login.php?erreur=2'); // utilisateur ou mot de passe vide
    }
}
else
{
   header('Location: login.php');
}
mysqli_close($db); // fermer la connexion


?>