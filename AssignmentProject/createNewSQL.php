<?php

function createUser(){

    //----- Creating some inputs for the new user -----------------------------------------------------
    $status = "new";

    //current date 
    $date  = new DateTime(); 
    $formatDate = $date->format('d/m/y');

    //Generating an application ID
    $FirstNameTwo = strtoupper(substr($_POST['fname'], 0,2));
    $LastNameTwo = strtoupper(substr($_POST['lname'], 0,2));
    $PostcodeTwo = strtoupper(substr($_POST['postcode'], -2));
    $DateTwo = substr($formatDate, 0,2);
    $RandomFive = rand(0,99999);
    $applicationID = $FirstNameTwo.$LastNameTwo.$PostcodeTwo.$DateTwo.$RandomFive;

    //Generating Lucy draw entries
    $luckyDraw = 0;
    if ($_POST['product'] == '100')    { $luckyDraw = 10;}
    if ($_POST['product'] == '300')    { $luckyDraw = 15;}
    if ($_POST['product'] == '500')    { $luckyDraw = 25;}
    if ($_POST['product'] == '800')    { $luckyDraw = 35;}
    if ($_POST['product'] == '1000')   { $luckyDraw = 45;}
    if ($_POST['product'] == '5000')   { $luckyDraw = 55;}
    if ($_POST['product'] == '10,000') { $luckyDraw = 60;}
    if ($_POST['product'] == '15,000') { $luckyDraw = 65;}

    //-------------------------------------------------------------------------------------------------
    //----- Passing inputs into the database ---------------------------------------------------------- 

    $created = false;
    $db = new SQLite3('/Applications/XAMPP/xamppfiles/htdocs/Data/StudentModule.db');  
    $sql = 'INSERT INTO User(postcode, firstName, lastName, contactNumber, dob, mob, Product, appDate, appID, status, luckyDraw) 
            VALUES (:postcode, :fName, :lName, :contactNumber, :dob, :mob, :product, :appDate, :appID, :status, :luckyDraw)';
    $stmt = $db->prepare($sql); //prepare the sql statement
  
    //give the values for the parameters
    $stmt->bindParam(':postcode',      $_POST['postcode'], SQLITE3_TEXT); 
    $stmt->bindParam(':fName',         $_POST['fname'], SQLITE3_TEXT);
    $stmt->bindParam(':lName',         $_POST['lname'], SQLITE3_TEXT);
    $stmt->bindParam(':contactNumber', $_POST['contactNumber'], SQLITE3_TEXT);
    $stmt->bindParam(':dob',           $_POST['dob'], SQLITE3_INTEGER);
    $stmt->bindParam(':mob',           $_POST['mob'], SQLITE3_INTEGER);
    $stmt->bindParam(':product',       $_POST['product'], SQLITE3_TEXT);
    $stmt->bindParam(':appDate',       $formatDate, SQLITE3_TEXT);
    $stmt->bindParam(':appID',         $applicationID, SQLITE3_TEXT);
    $stmt->bindParam(':status',        $status, SQLITE3_TEXT);
    $stmt->bindParam(':luckyDraw',     $luckyDraw, SQLITE3_TEXT);

    //execute the sql statement
    $stmt->execute();
    if($stmt) {$created = true;} return $created;
}


function createAdmin() {

    $created = false;
    $db = new SQLite3('/Applications/XAMPP/xamppfiles/htdocs/Data/StudentModule.db');
    $sql = 'INSERT INTO Admin (username, password) VALUES (:username, :password)';
    $stmt = $db->prepare($sql); 
    
    $stmt->bindParam(':username', $_POST['username'], SQLITE3_TEXT);
    $stmt->bindParam(':password', $_POST['password'], SQLITE3_TEXT);
    $stmt->execute();

    if($stmt) {$created = true;} return $created;
}

?>