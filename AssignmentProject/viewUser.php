<?php 
require("adminNavBar.php");
include_once("viewTableSQL.php");
include("session.php");
require_once("filterUser.php");

//Admin session
$path = "adminLogin.php"; 
session_start(); 
 if (!isset($_SESSION['username'])) {
     session_unset();
     session_destroy();
     header("Location:".$path);
 }
$admin = $_SESSION['username'];
checkSession ($path); 

//Getting user info
$db = new SQLite3('/Applications/XAMPP/xamppfiles/htdocs/Data/StudentModule.db');
$sql = "SELECT * FROM User WHERE ID = :ID";
$stmt = $db->prepare($sql);
$stmt->bindParam(':ID', $_GET['ID'], SQLITE3_INTEGER); 
$result = $stmt->execute();
$arrayResult = [];
while($row=$result->fetchArray(SQLITE3_NUM)){$arrayResult [] = $row;}

//-----------------------------------------------------------------------------------------------
//----- Delete ----------------------------------------------------------------------------------

//Variable and update for test delete
$testDelete = FALSE;
if (isset($_POST['testDelete'])) $testDelete = TRUE;
if (isset($_POST['no'])) $testDelete = FALSE;

//Delete user if confirmed
if (isset($_POST['yes'])){

    $db = new SQLite3('/Applications/XAMPP/xamppfiles/htdocs/Data/StudentModule.db');

    $stmt = "DELETE FROM User WHERE ID = :ID";
    $sql = $db->prepare($stmt);
    $sql->bindParam(':ID', $_POST['ID'], SQLITE3_TEXT);

    $sql->execute();
    header("Location:viewUser.php?deleted=true");
}

//-----------------------------------------------------------------------------------------------
//----- Update ----------------------------------------------------------------------------------

//Variable and update for update
$testUpdate = FALSE;
if (isset($_POST['update'])) $testUpdate = TRUE;

//Updating database with 'apply' button
if (isset($_POST['apply'])){

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
    $sql = "UPDATE User SET firstName = :fname, lastName = :lname, postcode = :postcode, contactNumber = :contactNumber,
                            dob = :dob, mob = :mob, Product = :product, status = :status, luckyDraw = :luckydraw WHERE ID = :ID";

    $stmt = $db->prepare($sql);
    $stmt->bindParam(':ID',            $_POST['ID'], SQLITE3_TEXT);
    $stmt->bindParam(':fname',         $_POST['fname'], SQLITE3_TEXT);
    $stmt->bindParam(':lname',         $_POST['lname'], SQLITE3_TEXT);
    $stmt->bindParam(':postcode',      $_POST['postcode'], SQLITE3_TEXT);
    $stmt->bindParam(':contactNumber', $_POST['contactNumber'], SQLITE3_TEXT);
    $stmt->bindParam(':dob',           $_POST['dob'], SQLITE3_INTEGER);
    $stmt->bindParam(':mob',           $_POST['mob'], SQLITE3_INTEGER);
    $stmt->bindParam(':product',       $_POST['product'], SQLITE3_TEXT);
    $stmt->bindParam(':status',        $_POST['status'], SQLITE3_TEXT);
    $stmt->bindParam(':luckydraw',     $luckyDraw, SQLITE3_TEXT);
    
    $stmt->execute();
    header('Location:viewUser.php?updated=true"');
}

//-----------------------------------------------------------------------------------------------
//----- Filter ----------------------------------------------------------------------------------

//Filter users by status
$level = array("all","new","in-process","on-hold","complete","withdrawn");
$array_users = filterUser();

//Variable and update for test withdraw
$testWithdraw = FALSE;
if (isset($_POST['testWithdraw'])) $testWithdraw = TRUE;
if (isset($_POST['no'])) $testWithdraw = FALSE;

//DELETE ALL WITHDRAWN STATUS USER
if (isset($_POST['withdrawAll'])){

    $withdrawn = "withdrawn";

    $db = new SQLite3('/Applications/XAMPP/xamppfiles/htdocs/Data/StudentModule.db');

    $stmt = "DELETE FROM User WHERE status = :status";
    $sql = $db->prepare($stmt);
    $sql->bindParam(':ID',     $_POST['ID'], SQLITE3_TEXT);
    $sql->bindParam(':status', $withdrawn, SQLITE3_TEXT);

    $sql->execute();
    header("Location:viewUser.php?withdrawn=true");   
}
?>


<div class="container bgColor">
    <main role="main" class="pb-3">
        
        <br>
        <h2>View User</h2><br>   

        <div class="row">
            <div class="col-md-9"> 
                
                <div class="row">

                    <!-- Filter by application status -->
                    <div class="col-md-5">
                        <div class="cream-box-no-height">
                            <form method="post">

                                <label class="control-label labelFont"><b>Filter by Application Status :</b></label>
                                <div class="row">

                                    <!-- Filter options -->
                                    <div class="form-group col-md-8">
                                        <select type="text" name="filterLevel" class="form-control">
                                            <?php for ($i=0; $i<count($level); $i++): ?>
                                            <option <?php if (isset($_POST['filterLevel']) && ($level[$i]==$_POST['filterLevel'])) echo "selected"; ?> ><?php echo $level[$i];?></option>
                                            <?php endfor; ?>
                                        </select>
                                    </div>
                                    <!-- Filter button -->
                                    <div class="form-group">
                                        <button type="submit" name="submit" value="filter" class="btn btn-primary">Filter</button>
                                    </div>

                                </div>

                            </form>
                        </div>
                    </div> 

                    <!-- Delete all withdrawn status -->
                    <div class="col-md-7">
                        <div class="cream-box">

                            <label class="control-label labelFont"><b>Delete all users with 'withdrawn' Application status</b></label>
                            <div class="row">

                                <!-- test delete button -->
                                <div class="col">
                                    <form method="post">
                                        <input type="submit" value="Delete" class="btn btn-danger" name="testWithdraw">
                                    </form>
                                </div>
                                
                                <!-- Delete User Option and Confirmation -->
                                <?php if($testWithdraw == TRUE): ?>
                                    <div class="row">

                                        <p class="text-danger">Are you sure? </p>
                                        <!-- Yes button -->
                                        <div class="col-3"> 
                                            <form method="post">
                                                <input type="hidden" name="ID" value = "<?php echo $_GET['ID'] ?>">
                                                <input type="submit" value="Yes" class="btn btn-danger" name="withdrawAll">
                                            </form>
                                        </div>
                                        <!-- No button -->
                                        <div class="col-3"> 
                                            <form method="post">                          
                                                <input type="submit" value="No" class="btn btn-primary" name="no">
                                            </form>
                                        </div>
                                        
                                    </div>    
                                <?php endif; ?> 
                                
                            </div>

                        </div>
                    </div> 

                </div> 

                <br>  

                <!--------------------------------------------------------------------------------------------------------->
                <!----- User Table ---------------------------------------------------------------------------------------->

                <!-- view user table -->
                <div class="cream-box-no-height">
                    <table class="styled-table table-responsive">
                        <thead>
                            <th>Select User</th>
                            <th>Application ID</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>D.o.B</th>
                            <th>Postcode</th>
                            <th>Contact</th>
                            <th>Status</th>
                            <th>Product</th>
                            <th>Luckydraw</th>
                            <th>Application Date</th>
                        </thead>

                        <tbody>
                            <?php 
                            $user = filterUser();
                            for ($i=0; $i<count($user); $i++):     
                            ?>
                                <tr> 
                                    <td style="text-align:center"><a href="viewUser.php?ID=<?php echo $user[$i]['ID'];?>"><button class="btn-select">select</button></a></td>
                                    <td><?php echo $user[$i]['appID']?></td>
                                    <td><?php echo $user[$i]['firstName']?></td>
                                    <td><?php echo $user[$i]['lastName']?></td>
                                    <td><?php echo $user[$i]['dob']?>
                                        <a>/</a>
                                        <?php echo $user[$i]['mob']?></td>
                                    <td><?php echo $user[$i]['postcode']?></td>    
                                    <td><?php echo $user[$i]['contactNumber']?></td>    

                                    <td><?php echo $user[$i]['status']?></td>
                                    <td>£<?php echo $user[$i]['Product']?></td>
                                    <td><?php echo $user[$i]['luckyDraw']?></td>
                                    <td><?php echo $user[$i]['appDate']?></td>
                                </tr>
                            <?php endfor; ?>
                        </tbody>

                    </table>
                     
                    <br>
                    <!-- Create PDF report -->
                    <div style="text-align:right"><a href=userPdf.php target="_blank">Generate Users PDF</a></div>
                </div>
            </div>

            <!--------------------------------------------------------------------------------------------------------->
            <!----- User Selection ------------------------------------------------------------------------------------>

            <!-- User Selection column -->
            <div class="col-md-3">
                <div class="cream-box-no-height">

                    <h4 style="text-align:center">User Selection</h4>
                    
                    <?php if($_GET['ID']!=""): ?>

                        <hr style="height:1px; color:#b79557; background-color:#b79557">
                        <h5 style="text-align:center"><b><?php echo ucfirst($arrayResult[0][2]), " ", ucfirst($arrayResult[0][3]) ;?></b><br>
                            <?php echo $arrayResult[0][11]; ?></h5>

                        <!-- Hide Update/Delete and text during actions -->
                        <?php if($testDelete || $testUpdate == FALSE): ?>

                            <br>
                            <p style="text-align:center">What action would you like to perform with this user?</p>

                            <div class="row">
                                <!-- Update button -->
                                <div class="col-md-6">  
                                    <form method="post">                       
                                        <input type="submit" value="Update" class="btn btn-primary" name="update">
                                    </form>    
                                </div>
                                <!-- Delete button -->
                                <div class="col-md-6">
                                    <form method="post">
                                        <input type="submit" value="Delete" class="btn btn-danger" name="testDelete">
                                    </form>
                                </div>
                            </div>

                        <?php endif ?>

                        <!-- Delete User Option and Confirmation -->
                        <?php if($testDelete == TRUE): ?>
                            <br><br>
                            <p class="text-danger" style="text-align:center">Are you sure? This action cannot be undone.</p>
                            
                            <div class="row">

                                <!-- Yes button -->
                                <div class="col-md-6" style="text-align:center"> 
                                    <form method="post">
                                        <input type="hidden" name="ID" value = "<?php echo $_GET['ID'] ?>">
                                        <input type="submit" value="Yes" class="btn btn-danger" name="yes">
                                    </form>
                                </div>
                                <!-- No button -->
                                <div class="col-md-6" style="text-align:center"> 
                                    <form method="post">                          
                                        <input type="submit" value="No" class="btn btn-primary" name="no">
                                    </form>
                                </div>

                            </div>    
                        <?php endif; ?> 

                        
                        <!-- Update User Option and Confirmation -->
                        <?php if($testUpdate == TRUE): ?>

                            <br>
                            
                            <form method="post">
                                <div>
                                    <label class="control-label labelFont">First Name</label>
                                    <input class="form-control" type="text" name ="fname" value="<?php echo $arrayResult[0][2]; ?>">
                                </div>
                                <div>
                                    <label class="control-label labelFont">Last Name</label>
                                    <input class="form-control" type="text" name ="lname" value="<?php echo $arrayResult[0][3]; ?>">
                                </div>

                                <label class="control-label labelFont">Date Of Birth</label>
                                <div class="row">

                                    <div class="col-md-5">
                                        <select name="dob" class="form-control">
                                            <option value="<?php echo($arrayResult[0][8])?>"><?php echo($arrayResult[0][8])?></option>
                                            <?php for ($i=1; $i<32; $i++): ?>
                                            <option value="<?php echo $i; ?>" ><?php echo $i; ?></option> 
                                            <?php endfor; ?>   
                                        </select>
                                    </div> 
                                    <div>
                                        <select name="mob" class="form-control">
                                            <option value="1"  <?php echo($arrayResult[0][6]=="1")  ? "selected" : ""; ?> >January</option>
                                            <option value="2"  <?php echo($arrayResult[0][6]=="2")  ? "selected" : ""; ?> >February</option>
                                            <option value="3"  <?php echo($arrayResult[0][6]=="3")  ? "selected" : ""; ?> >March</option>
                                            <option value="4"  <?php echo($arrayResult[0][6]=="4")  ? "selected" : ""; ?> >April</option>
                                            <option value="5"  <?php echo($arrayResult[0][6]=="5")  ? "selected" : ""; ?> >May</option>
                                            <option value="6"  <?php echo($arrayResult[0][6]=="6")  ? "selected" : ""; ?> >June</option>
                                            <option value="7"  <?php echo($arrayResult[0][6]=="7")  ? "selected" : ""; ?> >July</option>
                                            <option value="8"  <?php echo($arrayResult[0][6]=="8")  ? "selected" : ""; ?> >August</option>
                                            <option value="9"  <?php echo($arrayResult[0][6]=="9")  ? "selected" : ""; ?> >September</option>
                                            <option value="10" <?php echo($arrayResult[0][6]=="10") ? "selected" : ""; ?> >October</option>
                                            <option value="11" <?php echo($arrayResult[0][6]=="11") ? "selected" : ""; ?> >November</option>
                                            <option value="12" <?php echo($arrayResult[0][6]=="12") ? "selected" : ""; ?> >December</option>
                                        </select>
                                    </div>

                                </div>     
                                <div>
                                    <label class="control-label labelFont">Postcode</label>
                                    <input class="form-control" type="text" name ="postcode" value="<?php echo $arrayResult[0][1]; ?>">
                                </div>
                                <div>
                                    <label class="control-label labelFont">Contact Number</label>
                                    <input class="form-control" type="text" name ="contactNumber" value="<?php echo $arrayResult[0][4]; ?>">
                                </div>
                                <div>
                                    <label class="control-label labelFont">Application Status</label>
                                    <select name="status" class="form-control" multiple="multiple" size=5> 
                                        <option value="new"        <?php echo($arrayResult[0][5]=="new")        ? "selected" : ""; ?> >New</option> 
                                        <option value="in-process" <?php echo($arrayResult[0][5]=="in-process") ? "selected" : ""; ?> >In-process</option> 
                                        <option value="on-hold"    <?php echo($arrayResult[0][5]=="on-hold")    ? "selected" : ""; ?> >On-hold</option> 
                                        <option value="complete"   <?php echo($arrayResult[0][5]=="compete")    ? "selected" : ""; ?> >Complete</option> 
                                        <option value="withdrawn"  <?php echo($arrayResult[0][5]=="withdrawn")  ? "selected" : ""; ?> >Withdrawn</option> 
                                    </select>
                                </div>
                                <div>
                                    <label class="control-label labelFont">Product</label>
                                    <select name="product" class="form-control"> 
                                        <option value="100"    <?php echo($arrayResult[0][7]=="£100")    ? "selected" : ""; ?> >£100</option>
                                        <option value="300"    <?php echo($arrayResult[0][7]=="£300")    ? "selected" : ""; ?> >£300</option>
                                        <option value="500"    <?php echo($arrayResult[0][7]=="£500")    ? "selected" : ""; ?> >£500</option>
                                        <option value="800"    <?php echo($arrayResult[0][7]=="£800")    ? "selected" : ""; ?> >£800</option>
                                        <option value="1000"   <?php echo($arrayResult[0][7]=="£1000")   ? "selected" : ""; ?> >£1000</option>
                                        <option value="5000"   <?php echo($arrayResult[0][7]=="£5000")   ? "selected" : ""; ?> >£5000</option>
                                        <option value="10,000" <?php echo($arrayResult[0][7]=="£10,000") ? "selected" : ""; ?> >£10,000</option>
                                        <option value="15,000" <?php echo($arrayResult[0][7]=="£15,000") ? "selected" : ""; ?> >£15,000</option>
                                    </select>
                                </div>

                                <!-- Update and no button -->
                                <br>
                                <div class="row">
                                    
                                    <!-- Apply button -->
                                    <div class="col-md-6" style="text-align:center"> 
                                        <form method="post">
                                            <input type="hidden" name="ID" value ="<?php echo $_GET['ID'] ?>">   
                                            <input type="submit" value="Apply" class="btn btn-primary" name="apply">
                                        </form>
                                    </div>
                                    <!-- No button -->
                                    <div class="col-md-6" style="text-align:center"> 
                                        <form method="post">                          
                                            <input type="submit" value="No" class="btn btn-danger" name="no">
                                        </form>
                                    </div>

                                </div> 
                            </form>     
                        <?php endif; ?> 
                    <?php endif; ?>      
                </div> 
                
                <!--------------------------------------------------------------------------------------------------------->
                <!----- Alerts -------------------------------------------------------------------------------------------->
                
                <!-- User DELETED confirmation alert -->
                <?php if(isset($_GET['deleted'])): ?>
                    <br>
                    <div class="alert alert-danger alert-dismissible showcol-10" role="alert" style="font-weight: bold;">
                        User has been deleted
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php endif; ?>

                <!-- User UPDATED confirmation alert -->
                <?php if(isset($_GET['updated'])): ?>
                    <br>
                    <div class="alert alert-success alert-dismissible showcol-10" role="alert" style="font-weight: bold;">
                        User has been updated
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php endif; ?>

                <!-- WITHDRAWN status users deleted confirmation alert -->
                <?php if(isset($_GET['withdrawn'])): ?>
                    <br>
                    <div class="alert alert-danger alert-dismissible showcol-10" role="alert" style="font-weight: bold;">
                        All users with 'withdrawn' Application status have been deleted
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                 <?php endif; ?>

            </div>
            
        </div>
        
    </main>
</div>

<br><br><br>

<?php require("Footer.php"); ?>
