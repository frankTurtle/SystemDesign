<?php
    include("Config.php");
    
    //get search term
    $searchTerm = $_GET['term'];
    
    //get matched data from skills table
    $query = $dataBase->query("SELECT * FROM User WHERE firstName LIKE '%".$searchTerm."%' ORDER BY name ASC");
    $data = [];
    while ($row = $query->fetch_assoc()) {
        $data[] = $row['firstName'];
    }
    
    //return json data
    echo json_encode($data);
?>
