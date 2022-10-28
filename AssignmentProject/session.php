<?php

function checkSession ($path) {

    $expireAfter = 5; //this value is in minutes

    //Check the interval since "last action" session
    if(isset($_SESSION['last_action'])){
        
        //Figure out how many seconds have passed
        //since the user was last active.
        $secondsInactive = time() - $_SESSION['last_action'];
        
        //Convert our minutes into seconds.
        $expireAfterSeconds = $expireAfter * 10;
        
        //Check to see if they have been inactive for too long.
        if($secondsInactive >= $expireAfterSeconds){
            //User has been inactive for too long.
            //Kill their session.
            session_unset();
            session_destroy();
            header("Location:".$path);//return to the login page
        }
    }
    $_SESSION['last_action'] = time(); //this variable is set for the very first time upon login
    $url=$_SERVER['REQUEST_URI'];//to obtain the current page
    $timeOut = ($expireAfter*60)+1; //1 second after the max session allowed. 
    header("Refresh: $timeOut; URL=$url"); //refresh the screen
}

?>