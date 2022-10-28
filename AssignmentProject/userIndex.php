<?php 
require("userNavBar.php");
include("session.php");

//User session
$path = "Login.php"; 
session_start(); 
 if (!isset($_SESSION['appID'])) {
     session_unset();
     session_destroy();
     header("Location:".$path);
 }
$firstName = $_SESSION['userFirstName']; 
$userAppID = $_SESSION['appID']; 
$user = $_SESSION['ID'];
checkSession ($path); 

//Getting user info from database
$db = new SQLite3('/Applications/XAMPP/xamppfiles/htdocs/Data/StudentModule.db');
$sql = "SELECT Product, status, ID, appID, firstName, lastName FROM User WHERE ID = :ID";
$stmt = $db->prepare($sql);
$stmt->bindParam(':ID', $user, SQLITE3_TEXT); 
$result = $stmt->execute();
$arrayResult = [];
while($row=$result->fetchArray(SQLITE3_NUM)){
    $arrayResult [] = $row;
}

//Variables for AUDIT
$date  = new DateTime(); 
$formatDate = $date->format('d/m/y H:i:s');
$oldProduct = $arrayResult[0][0];
$lastName = $arrayResult[0][5];

//-------------------------------------------------------------------------------------------------------
//----- UPDATE BUTTON -----------------------------------------------------------------------------------

//Updating AUDIT product with 'update' button
if (isset($_POST['submit'])){

    $blank = "-";
    $action = "update";

    $db = new SQLite3('/Applications/XAMPP/xamppfiles/htdocs/Data/StudentModule.db'); 
    $sql = 'INSERT INTO Audit(appID, firstName, lastName, ProductOld, Product, status, dateTime, action) 
            VALUES (:appID, :fName, :lName, :oldProduct, :product, :status, :dateTime, :action)';
    $stmt = $db->prepare($sql); //prepare the sql statement
  
    //give the values for the parameters
    $stmt->bindParam(':appID',      $_SESSION['appID'], SQLITE3_TEXT);
    $stmt->bindParam(':fName',      $_SESSION['userFirstName'], SQLITE3_TEXT);
    $stmt->bindParam(':lName',      $lastName, SQLITE3_TEXT);
    $stmt->bindParam(':oldProduct', $oldProduct, SQLITE3_TEXT);
    $stmt->bindParam(':product',    $_POST['product'], SQLITE3_TEXT);
    $stmt->bindParam(':status',     $blank, SQLITE3_TEXT);
    $stmt->bindParam(':dateTime',   $formatDate, SQLITE3_TEXT);
    $stmt->bindParam(':action',     $action, SQLITE3_TEXT);
    
    $stmt->execute();
}

//Updating USER database product with 'update' button
if (isset($_POST['submit'])){

    //Updating Lucky draw entries with new product selection
    $luckyDraw = 0;
    if ($_POST['product'] == '100')    { $luckyDraw = 10;}
    if ($_POST['product'] == '300')    { $luckyDraw = 15;}
    if ($_POST['product'] == '500')    { $luckyDraw = 25;}
    if ($_POST['product'] == '800')    { $luckyDraw = 35;}
    if ($_POST['product'] == '1000')   { $luckyDraw = 45;}
    if ($_POST['product'] == '5000')   { $luckyDraw = 55;}
    if ($_POST['product'] == '10,000') { $luckyDraw = 60;}
    if ($_POST['product'] == '15,000') { $luckyDraw = 65;}

    $db = new SQLite3('/Applications/XAMPP/xamppfiles/htdocs/Data/StudentModule.db');
    $sql = "UPDATE User SET Product = :product, luckyDraw = :luckydraw WHERE ID = :ID";

    $stmt = $db->prepare($sql);
    $stmt->bindParam(':product',   $_POST['product'], SQLITE3_TEXT);
    $stmt->bindParam(':luckydraw', $luckyDraw, SQLITE3_TEXT);
    $stmt->bindParam(':ID',        $user, SQLITE3_TEXT);
    $stmt->execute();

    header('Location:userIndex.php?updated=true"');
}

//-------------------------------------------------------------------------------------------------------
//----- WITHDRAW BUTTON ---------------------------------------------------------------------------------

//Updating AUDIT with 'withdraw' button
if (isset($_POST['withdraw'])){

    $blank = "-";
    $status = "withdrawn";
    $action = "withdraw";

    $db = new SQLite3('/Applications/XAMPP/xamppfiles/htdocs/Data/StudentModule.db'); 
    $sql = 'INSERT INTO Audit(appID, firstName, lastName, ProductOld, Product, status, dateTime, action) 
            VALUES (:appID, :fName, :lName, :oldProduct, :product, :status, :dateTime, :action)';
    $stmt = $db->prepare($sql); //prepare the sql statement
  
    //give the values for the parameters
    $stmt->bindParam(':appID',      $_SESSION['appID'], SQLITE3_TEXT);
    $stmt->bindParam(':fName',      $_SESSION['userFirstName'], SQLITE3_TEXT);
    $stmt->bindParam(':lName',      $lastName, SQLITE3_TEXT);
    $stmt->bindParam(':oldProduct', $blank, SQLITE3_TEXT);
    $stmt->bindParam(':product',    $blank, SQLITE3_TEXT);
    $stmt->bindParam(':status',     $status, SQLITE3_TEXT);
    $stmt->bindParam(':dateTime',   $formatDate, SQLITE3_TEXT);
    $stmt->bindParam(':action',     $action, SQLITE3_TEXT);
    
    $stmt->execute();
}

//Updating USER database status with 'withdraw' button
if (isset($_POST['withdraw'])){

    $status = "withdrawn";

    $db = new SQLite3('/Applications/XAMPP/xamppfiles/htdocs/Data/StudentModule.db');
    $sql = "UPDATE User SET status = :status WHERE ID = :ID";

    $stmt = $db->prepare($sql);
    $stmt->bindParam(':ID',     $user, SQLITE3_TEXT);
    $stmt->bindParam(':status', $status, SQLITE3_TEXT);
    $stmt->execute();

    header('Location:withdrawApplicationSummary.php?');
}

//-------------------------------------------------------------------------------------------------------

//Updating webpage if 'yes' button is pressed
if (isset($_POST['yes'])) {header('Location:userIndex.php?yes=true"');}
//Updating webpage if 'no' button is pressed
if (isset($_POST['no'])) {header('Location:userIndex.php?');}
?>


<div class="container bgColor">
    <main role="main" class="pb-3">
        
        <br>
        <p style="text-align:center"><img alt="User Icon" src="/AssignmentProject/bread-icon.png" class="centerimage" width="60" height="60"></p>
        <h1 style="text-align:center">Store Your Bread</h1><br>    

        <div style="text-align:center">
            <br>
            <h3>Hello there, <?php echo ucfirst($firstName);?></h3>
            <p>What would you like to do today?<p>
            <br>
        </div> 

        <div class="row"> 

            <!-- Blank 3 space -->        
            <div class="col-md-2"></div> 
            <!-- Update Chosen Product BOX -->
            <div class="col-md-4">  
                <div class="cream-box-no-height">
                    <h5 style="text-align:center">Update Chosen Product</h5>
                    <hr style="height:1px; color:#b79557; background-color:#b79557">
                    
                    <form method="post">

                        <p style="text-align:center">Your current chosen product is:<br>
                            <b><?php echo $arrayResult[0][0];?></b></p>
                        <br>
                        <p style="text-align:center">Select a new product below if you would like to update it:    
                        
                        <div class="form-group">
                            <select name="product" class="form-control"> 
                                <option value="100"    <?php echo($arrayResult[0][0]=="100")    ? "selected" : ""; ?> >£100</option>
                                <option value="300"    <?php echo($arrayResult[0][0]=="300")    ? "selected" : ""; ?> >£300</option>
                                <option value="500"    <?php echo($arrayResult[0][0]=="500")    ? "selected" : ""; ?> >£500</option>
                                <option value="800"    <?php echo($arrayResult[0][0]=="800")    ? "selected" : ""; ?> >£800</option>
                                <option value="1000"   <?php echo($arrayResult[0][0]=="1000")   ? "selected" : ""; ?> >£1000</option>
                                <option value="5000"   <?php echo($arrayResult[0][0]=="5000")   ? "selected" : ""; ?> >£5000</option>
                                <option value="10,000" <?php echo($arrayResult[0][0]=="10,000") ? "selected" : ""; ?> >£10,000</option>
                                <option value="15,000" <?php echo($arrayResult[0][0]=="15,000") ? "selected" : ""; ?> >£15,000</option>
                            </select>
                        </div>
                        <!-- Update button -->
                        <div style="text-align:center">                         
                            <input type="hidden" name="ID" value = "<?php echo $_GET['ID'] ?>"><br>
                            <input type="submit" value="Update" class="btn btn-primary" name="submit">
                        </div>

                    </form>

                    <!-- Updated alert -->
                    <?php if(isset($_GET['updated'])): ?>
                        <br>
                        <div class="alert alert-success alert-dismissible showcol-10" role="alert" style="font-weight: bold;">
                            Product has been updated
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php endif; ?>

                </div> 
            </div>
            
            <!-- Withdraw Application BOX -->
            <div class="col-md-4"> 
                <div class="cream-box-no-height">
                    <h5 style="text-align:center">Withdraw Application</h5>
                    <hr style="height:1px; color:#b79557; background-color:#b79557">
                    <p style="text-align:center">Would you like to withdraw your application? This means you will be logged out.</p>

                    <form method="post">
                        <div class="row">

                            <!-- empty 2 column -->
                            <div class="col-md-2"></div> 
                            <!-- Yes button -->    
                            <div class="col-md-4" style="text-align:center">                         
                                <input type="hidden" name="ID" value = "<?php echo $_GET['ID'] ?>"><br>
                                <input type="submit" value="Yes" class="btn btn-primary" name="yes">
                            </div>
                            <!-- No button --> 
                            <div class="col-md-4" style="text-align:center">                          
                                <input type="hidden" name="ID" value = "<?php echo $_GET['ID'] ?>"><br>
                                <input type="submit" value="No" class="btn btn-primary" name="no">
                            </div>

                        </div>
                    </form>   

                    <br>

                    <!-- Show withdraw if yes is selected -->
                    <?php if(isset($_GET['yes'])): ?>
                        <form method="post">
                            <p class="text-danger" style="text-align:center">Are you sure? After pressing 'withdraw' this action cannot be undone.</p>
                            <div class="d-flex justify-content-center"> 
                                <input type="hidden" name="ID" value ="<?php echo $_GET['ID'] ?>"><br>                           
                                <input type="submit" value="Withdraw" class="btn btn-danger" name="withdraw">
                            </div>
                        </form>
                    <?php endif; ?>

                </div> 
            </div>

        </div>    

    </main>
</div>

<br><br><br>

<?php require("Footer.php");?>