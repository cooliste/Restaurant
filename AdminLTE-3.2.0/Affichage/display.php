<?php
include 'action.php';  
?>
<style>
     table,th,td {
        padding: 10px;
        border: 2px solid black;
        border-collapse: collapse;
      }
      body{
        background-image:url('Images/tab.jpg');
        justify-content:justify;
        margin-left:38%;
        background-size:cover;
        color:white;
        height:30px;
       }
       h1{
        color:white;
       }
</style>
<?php   

    $host = 'localhost';
	$username = 'root';
	$password = '';
	$dbname = 'test';

    // Créer une connexion et sélectionnez la base de données
    $dsn ="mysql:host=$host; dbname=$dbname";
   
    //Récupérer les données à partir de la base de données
    
   $sql = "SELECT * FROM crud ";

    try{
        $pdo = new PDO ($dsn, $username, $password);
        $stmt= $pdo->query($sql);
        if($stmt === false){
            die("Erreur");
        }
    }catch (PDOException $e){
        echo $e->getMessage();
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Récupération de données</title>
</head>
<body>
    <h1> Liste des Plats</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Categorie</th>
                <th>Description</th>
                <th>Photo</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) : ?>
                <tr>
                   <td><?php echo htmlspecialchars($row['id']) ;?></td>
                    <td><?php echo htmlspecialchars($row['name']) ;?></td>
                    <td><?php echo htmlspecialchars($row['email']) ;?></td>
                    <td><?php echo htmlspecialchars($row['phone']) ;?></td>
                    <td><img src="<?= $row['photo']; ?>" width="90" height="90"></td>
                    
                </tr>
                <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>