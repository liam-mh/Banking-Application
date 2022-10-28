<?php

function getUsers(){
    $db = new SQLITE3('/Applications/XAMPP/xamppfiles/htdocs/Data/StudentModule.db');
    $sql = "SELECT * FROM User";
    $stmt = $db->prepare($sql);
    $result = $stmt->execute();

    $arrayResult = []; 
    while ($row = $result->fetchArray()) {$arrayResult[] = $row;} return $arrayResult;
}

function getAdmin(){
    $db = new SQLITE3('/Applications/XAMPP/xamppfiles/htdocs/Data/StudentModule.db');
    $sql = "SELECT * FROM Admin";
    $stmt = $db->prepare($sql);
    $result = $stmt->execute();

    $arrayResult = []; 
    while ($row = $result->fetchArray()) {$arrayResult[] = $row;} return $arrayResult;
}

?>

