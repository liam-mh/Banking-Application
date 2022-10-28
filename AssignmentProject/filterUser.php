<?php

function filterUser () {

    $db = new SQLite3('/Applications/XAMPP/xamppfiles/htdocs/Data/StudentModule.db');

    if (!isset($_POST['filterLevel'])) {
        
        $rows = $db->query('SELECT * FROM User');

        while ($row=$rows->fetchArray()) {$rows_array[]=$row;} return $rows_array;
    }
    else
    {
        if ($_POST['filterLevel']!="all")//3,4,5,6,7
        {
            $stmt = $db->prepare('SELECT * FROM User WHERE status=:status');
            $stmt->bindParam(':status', $_POST['filterLevel'], SQLITE3_TEXT);

            $result = $stmt->execute();
            
            $rows_array = [];//need this because the array can be empty
            while ($row=$result->fetchArray())
            {
                $rows_array[]=$row;
            }
            return $rows_array;
        }
        else //all
        {
            $rows = $db->query('SELECT * FROM User');

            while ($row=$rows->fetchArray())
            {
                $rows_array[]=$row;
            }
            return $rows_array;
        }
    }
}
?>