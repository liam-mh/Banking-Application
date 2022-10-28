<?php 
require("adminNavBar.php");
include("session.php");

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
?>


<div class="container bgColor">
    <main role="main" class="pb-3">

        <br>
        <p style="text-align:center"><img alt="User Icon" src="/AssignmentProject/bread-icon.png" class="centerimage" width="60" height="60"></p>
        <h1 style="text-align:center">Store Your Bread</h1><br>    

        <div style="text-align:center">
            <br>
            <h3>Hello there, <?php echo ucfirst($admin);?></h3>
            <p>What would you like to do today?<p>
            <br>
        </div> 

        <div class="row">

            <!-- view user --> 
            <div class="col"> 
                <div class="cream-box">
                    <h4 style="text-align:center">View Users </h4>
                    <hr style="height:1px; color:#b79557; background-color:#b79557">
                    <p>View a table of current users of Store Your Bread, Update/Delete users.</p>
                    <div style="text-align:center">
                        <button class="btn btn-primary" onclick="document.location='viewUser.php'">View Users</button>
                    </div>
                </div> 
            </div>
            <!-- Generate PDF -->
            <div class="col">  
                <div class="cream-box">
                    <h4 style="text-align:center">Generate PDFs</a></h4>
                    <hr style="height:1px; color:#b79557; background-color:#b79557">
                    <p>Create a PDF of current users of Store Your Bread.</p>
                    <div class="row">
                        <div style="text-align:center" class="col">
                            <button class="btn btn-primary" onclick="document.location='userPdf.php'">Current Users</button>
                        </div>
                        <div style="text-align:center" class="col">
                            <button class="btn btn-primary" onclick="document.location='auditPdf.php'">Audit Trail</button>
                        </div>
                    </div>    
                </div> 
            </div>
            <!-- Audit Trails --> 
            <div class="col"> 
                <div class="cream-box">
                    <h4 style="text-align:center">Audit Trails</a></h4>
                    <hr style="height:1px; color:#b79557; background-color:#b79557">
                    <p>View an Audit Trail for user updates to their account.</p>
                    <div style="text-align:center" class="col">
                            <button class="btn btn-primary" onclick="document.location='viewAuditTrail.php'">Audit Trails</button>
                    </div>
                </div> 
            </div>
            
        </div>
   
    </main>
</div>

<?php require("Footer.php");?>