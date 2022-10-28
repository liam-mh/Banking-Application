<?php 
require("NavBar.php");
include_once("createNewSQL.php"); 

//Setting error variables
$errorfname = $errorlname = $errorpostcode = $errorcontactnumber = ""; 
$allFields = "yes";

//Sending new user inputs to User table once submitted
if (isset($_POST['submit'])) {

    if ($_POST['fname']=="")    {$errorfname = "Please enter your First name";  $allFields = "no";}
    if ($_POST['lname']=="")    {$errorlname = "Please enter your Last name";   $allFields = "no";}
    if ($_POST['postcode']=="") {$errorpostcode = "Please enter your Postcode"; $allFields = "no";}
    if ($_POST['contactNumber']=="" || strlen($_POST['contactNumber'])!=11) {
        $errorcontactnumber = "A 11 digit Contact Number is required"; $allFields = "no";}

    if($allFields == "yes") {$createUser = createUser(); header('Location: userCreationSummary.php?createUser='.$createUser);}    
}
?>

<div class="container pb-5">
    <main role="main" class="pb-3">

        <br>
        <div class="row">

            <!-- Create new account column -->
            <div class="row col-md-6">
                <div class="col-12">

                    <h2 style="text-align:center">Create a new account</h2>
                    <p style="text-align:center">It only takes a few minutes to register for Internet Banking.<br>
                       First we'll need a few simple details about you.</p>
                    <br>

                    <form method="post">

                        <div class="form-group">
                            <label class="control-label labelFont">First Name</label>
                            <input class="form-control" type="text" name="fname">
                            <span class="text-danger"><?php echo $errorfname; ?></span>
                        </div>
                        <div class="form-group">
                            <label class="control-label labelFont">Last Name</label>
                            <input class="form-control" type="text" name="lname">
                            <span class="text-danger"><?php echo $errorlname; ?></span>
                        </div>
                        <div class="form-group">
                            <label class="control-label labelFont">Postcode</label>
                            <input class="form-control" type="text" name="postcode">
                            <span class="text-danger"><?php echo $errorpostcode; ?></span>
                        </div>
                        <div class="form-group">
                            <label class="control-label labelFont">Contact Number</label>
                            <input class="form-control" type="text" name="contactNumber">
                            <span class="text-danger"><?php echo $errorcontactnumber; ?></span>
                        </div>

                        <div class="form-group">
                            <label class="control-label labelFont">Product</label>
                            <select name="product" class="form-control">
                                <option value="100">£100</option>
                                <option value="300">£300</option>
                                <option value="500">£500</option>
                                <option value="800">£800</option>
                                <option value="1000">£1000</option>
                                <option value="5000">£5000</option>
                                <option value="10,000">£10,000</option>
                                <option value="15,000">£15,000</option>
                            </select>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="control-label labelFont">Date Of Birth</label>
                                <select name="dob" class="form-control">
                                    <?php for ($i=1; $i<32; $i++): ?>
                                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option> 
                                    <?php endfor; ?>   
                                </select>
                            </div>        

                            <div class="form-group col-md-6">
                                <label class="control-label labelFont">Month Of Birth</label>
                                <select name="mob" class="form-control">
                                    <option value="1">January</option>
                                    <option value="2">February</option>
                                    <option value="3">March</option>
                                    <option value="4">April</option>
                                    <option value="5">May</option>
                                    <option value="6">June</option>
                                    <option value="7">July</option>
                                    <option value="8">August</option>
                                    <option value="9">September</option>
                                    <option value="10">October</option>
                                    <option value="11">November</option>
                                    <option value="12">December</option>
                                </select>
                            </div>
                        </div>

                        <br>
                        <div class="form-group col-md-12" style="text-align:center">
                            
                            <input class="btn btn-primary" type="submit" value="Create User" name ="submit">
                        </div>
                    </form>

                </div>
            </div>    

            <!-- Fraud guarantee column -->
            <div class="col-md-6"> 
                <div class="cream-box">
                    <h5 style="text-align:center">Our Fraud Guarantee</h5>
                    <hr style="height:1px; color:#b79557; background-color:#b79557">
                    <p>We guarantee to refund your money (including charges and interest that you've paid or not received as a result) in the unlikely event that you experience fraud with our Internet Banking service. We will take steps to protect you 24/7, using technology and safeguards that meet or exceed industry standards, but you must also use our online banking services carefully.</p>  
                    <p>Being careful when you use our services includes, for example, that you:</p>
                    <ul>
                        <li>Do all that you reasonably can to keep your Security Details (such as online and mobile User ID, password, and memorable information) secure, and you log off after each Internet Banking session.</li>
                        <li>Don't let anyone else have access to your account or Security Details, or transact using them, even if they share a joint account with you through our Internet Banking services.</li>
                        <li>Tell us, as soon as you can if you think your Security Details have been lost, stolen, damaged or are being misused; or think someone may be accessing your accounts without your authority, or has discovered your Security Details.</li>
                        <li>Carry out regular virus checks on your devices.</li>
                    </ul> 
                    <p>If you've been grossly negligent, we will not refund any money taken from your account before you have told us your Security Details have been lost, stolen or could be misused.</p>               
                </div> 
            </div>
            
        </div>
                

    </main>
</div>

<br>

<?php require("Footer.php");?>



