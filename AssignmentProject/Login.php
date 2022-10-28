<?php require("NavBar.php");

function verifyUsers () {

    if (!isset($_POST['appID']) or !isset($_POST['postcode']) or !isset($_POST['lastName'])) {return;}   

    $db = new SQLite3('/Applications/XAMPP/xamppfiles/htdocs/Data/StudentModule.db');
    $stmt = $db->prepare('SELECT appID, postcode, lastName, firstName, ID, Status FROM User WHERE appID=:appID');
    $stmt->bindParam(':appID',    $_POST['appID'], SQLITE3_TEXT);
    $stmt->bindParam(':postcode', $_POST['postcode'], SQLITE3_TEXT);
    $stmt->bindParam(':lastName', $_POST['lastName'], SQLITE3_TEXT);
    $stmt->bindParam(':firstName',$_POST['firstName'], SQLITE3_TEXT);
    $stmt->bindParam(':status',   $_POST['Status'], SQLITE3_TEXT);
    $stmt->bindParam(':ID',       $_POST['ID'], SQLITE3_TEXT);

    $result = $stmt->execute();
    $rows_array = [];
    while ($row=$result->fetchArray()) {$rows_array[]=$row;}return $rows_array;
}   

//----- Login and errors ------------------------------------------------------------------------
//Setting error variables
$appIDErr = $postcodeErr = $lastnameErr = $invalidMesg = $withdrawn = ""; 

if (isset($_POST['submit'])) {

    if ($_POST["appID"]==null)    {$appIDErr = "Application ID is required";}
    if ($_POST["postcode"]==null) {$postcodeErr = "Postcode is required";}
    if ($_POST["lastName"]==null) {$lastnameErr = "Last name is required";}

    if($_POST['appID'] != null && $_POST["postcode"] != null && $_POST["lastName"] != null) {

        $array_user = verifyUsers(); 

        if ($array_user != null) {

            if ($array_user[0]['status']!="withdrawn") {

                //Updating AUDIT login 
                $blank = "-";
                $action = "login";
                $date  = new DateTime(); 
                $formatDate = $date->format('d/m/y H:i:s');
                $name = $array_user[0]['firstName'];
             
                $db = new SQLite3('/Applications/XAMPP/xamppfiles/htdocs/Data/StudentModule.db'); 
                $sql = 'INSERT INTO Audit(appID, firstName, lastName, ProductOld, Product, status, dateTime, action) 
                        VALUES (:appID, :fName, :lName, :oldProduct, :product, :status, :dateTime, :action)';
                $stmt = $db->prepare($sql); //prepare the sql statement
            
                //give the values for the parameters
                $stmt->bindParam(':appID',      $_POST['appID'], SQLITE3_TEXT);
                $stmt->bindParam(':fName',      $name, SQLITE3_TEXT);
                $stmt->bindParam(':lName',      $_POST['lastName'], SQLITE3_TEXT);
                $stmt->bindParam(':oldProduct', $blank, SQLITE3_TEXT);
                $stmt->bindParam(':product',    $blank, SQLITE3_TEXT);
                $stmt->bindParam(':status',     $blank, SQLITE3_TEXT);
                $stmt->bindParam(':dateTime',   $formatDate, SQLITE3_TEXT);
                $stmt->bindParam(':action',     $action, SQLITE3_TEXT);
                
                $stmt->execute();
                
                //begin user session
                session_start();
                $_SESSION['appID'] =         $array_user[0]['appID'];
                $_SESSION['userFirstName'] = $array_user[0]['firstName'];
                $_SESSION['userLastName'] =  $array_user[0]['lastName'];
                $_SESSION['ID'] =            $array_user[0]['ID'];
                $_SESSION["login_time_stamp"] = time();
                header("Location: userIndex.php");
                exit(); 

            } else {
                $withdrawn = "<br> Unfortunately your application may have been withdrawn. \n Please create a new account or contact support.";
            }
        }
    }            
}
?>


<div class="container bgColor">
    <main role="main" class="pb-3">

        <br>
        <div class="row">

            <!-- Login column -->
            <div class="row col-md-7">
                <div class="col-12">

                    <h2>Welcome to Internet Banking</h2>
                    <br>
                    <p><b>Want to login to your account?</b><br>
                        Please enter your details provided when registering your account below</p>
                    
                    <!-- withdrawn app error -->
                    <p class="text-danger"><?php echo nl2br($withdrawn); ?></p>
                    
                    <div class="row">
            
                        <form method="post">
                            <div class="form-group col-md-12">
                                <label class="control-label labelFont">Application ID</label>
                                <input class="form-control" type="text" name="appID">
                                <span class="text-danger"><?php echo $appIDErr; ?></span>
                            </div>
                            <div class="form-group col-md-12">
                                <label class="control-label labelFont">Postcode</label>
                                <input class="form-control" type="text" name="postcode">
                                <span class="text-danger"><?php echo $postcodeErr; ?></span>
                            </div>
                            <div class="form-group col-md-12">
                                <label class="control-label labelFont">Last Name</label>
                                <input class="form-control" type="text" name="lastName">
                                <span class="text-danger"><?php echo $lastnameErr; ?></span>
                            </div>
                            <br> 
                            <div class="form-group col-md-12">
                                <input class="btn btn-primary" type="submit" value="Login" name ="submit">
                            </div>
                        </form>
                    
                    </div>

                    <!-- Support text -->
                    <br>
                    <p><b>Forgotten your login details?</b><br>
                    Contact support on the numbers displayed under 'Contact and Support'</p>
                    <br>
                    <p><b>Don't have an account?</b><br>
                    If you don't already use Internet Banking, it's simple to <a href=<?php echo "createUser.php" ?>>register with us</a></p>

                </div>
            </div>    

            <!-- Blank column -->
            <div class="col-md-1"></div>    

            <!-- support column -->
            <div class="col-md-3"> 
                <!-- FSCS -->
                <div class="cream-box-no-height">
                    <p style="text-align:center"><img alt="User Icon" src="/AssignmentProject/fscs.png" class="centerimage" width="200" height="100"></p>
                    <p>Store Your Bread is protected by the FSCS</p>
                    <a href="https://www.fscs.org.uk" target="_blank">find out more</a>
                </div> 
                <br>
                <!-- Support -->
                <div class="cream-box-no-height">
                    <h5 style="text-align:center">Contact and Support</h5>
                    <hr style="height:1px; color:#b79557; background-color:#b79557">
                    <p><b>General banking and account queries</b><br>
                    0345 111 0111</p> 
                    <p><b>Internet Banking queries</b><br>
                    Technical queries about the internet Banking service<br>
                    0345 111 0001</p> 
                    <p>Open 7am - 11pm, seven days a week</p>
                </div> 
            </div>

        </div>

    </main>
</div>

<br><br><br>

<?php require("Footer.php");?>
