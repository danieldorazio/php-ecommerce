<?php 
$serverName = "localhost";
$userName = "root";
$password = "root";

try {
    $conn = new PDO("mysql:host=$serverName;dbname=php_ecommerce_db", $userName, $password);
    // settare l'attibuto dell'errore di PDO 
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully";

    // preparate la query
    $stmt = $conn->prepare("SELECT * FROM product");
    // Eseguire la query
    $stmt->execute();

    // Recuperare i risultati
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    var_dump($results);
    //Visualizzare i risultati
    // foreach ($results as $row) {
        
    //     echo "ID: " . $row['id'] . " - Name: " . $row['name'] . " - Description: " . $row['description'] . " - Price: " . $row['price'] . " - Category_id: " . $row['category_id'] . "<br>";
    // }


}
catch(PDOException $e)
{
    echo "Connection failed:" . $e->getMessage();
}

?> 