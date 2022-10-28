<?php require("NavBar.php");

function verifyAdmins () {

    if (!isset($_POST['username']) or !isset($_POST['password'])) {return;}   

    $db = new SQLite3('/Applications/XAMPP/xamppfiles/htdocs/Data/StudentModule.db');
    $stmt = $db->prepare('SELECT username, password FROM Admin WHERE username=:username');
    $stmt->bindParam(':username', $_POST['username'], SQLITE3_TEXT);
    $stmt->bindParam(':password', $_POST['password'], SQLITE3_TEXT);
 
    $result = $stmt->execute();
    $rows_array = [];
    while ($row=$result->fetchArray()) {$rows_array[]=$row;} return $rows_array;
}   

//Setting error messages
$usernameErr = $passwordErr  = $invalidMesg = ""; 

if (isset($_POST['submit'])) {

    if ($_POST["username"]==null) {$usernameErr = "A username is required";}
    if ($_POST["password"]==null) {$passwordErr = "Password is required";}

    if($_POST['username'] != null && $_POST["password"] != null) {

        $array_admin = verifyAdmins(); 

        if ($array_admin != null) {
            session_start();
            $_SESSION['username'] = $array_admin[0]['username'];
            $_SESSION["login_time_stamp"] = time();
            header("Location: adminIndex.php");
            exit(); 
        }
    }            
}
?>


<div class="container bgColor">
    <main role="main" class="pb-3">

        <br>
        <!-- Login -->
        <div class="row">
            <div class="col">

                <h2>Welcome to Administration Login</h2>
                <br>
                <p class="text-danger"><b>This is a restricted access area</b><br>
                If you are a Store Your Bread user please click <a href=<?php echo "index.php" ?>>here to go home.</a></p>
                <br>

                <div class="row">

                    <!-- User input Login -->
                    <form method="post">
                        <div class="form-group col-md-12 ">
                            <label class="control-label labelFont">Username</label>
                            <input class="form-control" type="text" name="username">
                            <span class="text-danger"><?php echo $usernameErr; ?></span>
                        </div>
                        <div class="form-group col-md-12">
                            <label class="control-label labelFont">Password</label>
                            <input class="form-control" type="text" name="password">
                            <span class="text-danger"><?php echo $passwordErr; ?></span>
                        </div>
                        <br> 
                        <div class="form-group col-md-12">
                            <input class="btn btn-primary" type="submit" value="Login" name ="submit">
                        </div>
                    </form>

                </div>

                <br>
                <p><b>Want to create a new admin account?</b><br>
                <a href=<?php echo "createAdmin.php" ?>>Click here to create a new admin account</a></p>
                
            </div>
        </div>

    </main>
</div>

<?php require("Footer.php");?>
