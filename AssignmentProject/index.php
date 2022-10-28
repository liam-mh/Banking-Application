<!----------------------------------------------------------------------------------->
<!-- Databases and The Web Assignment: DBWCoursework_c1022456                      -->
<!-- Name: Liam Hammond   Student ID: c1022456                                     -->
<!-- Last revised: 22/12/2021                                                      -->
<!----------------------------------------------------------------------------------->

<?php require("NavBar.php");?>

<div class="container bgColor">
    <main role="main">

        <!-- Logo -->   
        <div style="text-align:center">
            <br>
            <p><img alt="User Icon" src="/AssignmentProject/bread-icon.png" class="centerimage" width="60" height="60"></p>
            <h1>Store Your Bread</h1><br>
        </div>

        <div class="row">

            <!-- New account -->
            <div class="col-md-9" style="text-align:center">  
                <div class="cream-box">
                    <h3>Why not open an account with us?</h3>
                    <hr style="height:1px; color:#b79557; background-color:#b79557">
                    <p>Join us between the 2nd of January 2020, and the 30th of January 2022 to enjoy the following benefits:</p>
                    <br>
                    <p>* A free £15 voucher, upon successful placement *<br>
                       * An interest rate of 2.88% AER p.a *<br>
                       * A chance of winning £10,000! *</p>
                    <br>
                    <button class="btn btn-primary" onclick="document.location='createUser.php'">Click me to open an account!</button>
                </div> 
            </div>
            <!-- Existing User -->
            <div class="col-md-3" style="text-align:center"> 
                <div class="cream-box">
                    <h4>Already a User?</h4>
                    <hr style="height:1px; color:#b79557; background-color:#b79557">
                    <p>Welcome back!</p>
                    <p>Need to alter your chose product or application status? Login below to update your details</p>
                    <br>
                    <button class="btn btn-primary" onclick="document.location='Login.php'">Click me to login</button>
                </div> 
            </div>

        </div>  

        <br>

        <div class="row"> 

            <!-- OUR PRODUCT BOX -->
            <div class="col-md-3">  
                <div class="cream-box">
                    <h5 style="text-align:center">Our Products</h5>
                    <hr style="height:1px; color:#b79557; background-color:#b79557">
                    <ul>
                        <li>Current accounts</li>
                        <li>Credit cards</li>
                        <li>Loans</li>
                        <li>Car finance</li>
                        <li>Savings</li>
                    </ul>
                </div> 
            </div>
            <!-- HELP & SUPPORT BOX -->
            <div class="col-md-3"> 
                <div class="cream-box">
                    <h5 style="text-align:center">Help and Support</h5>
                    <hr style="height:1px; color:#b79557; background-color:#b79557">
                    <ul>
                        <li>Coronavirus help</li>
                        <li>Lost or stolen cards</li>
                        <li>Trouble logging in?</li>
                        <li>Rates and charges</li>
                        <li>Customer support</li>
                    </ul>
                </div> 
            </div>
            <!-- INTERNET BANKING BOX -->
            <div class="col-md-3"> 
                <div class="cream-box">
                    <h5 style="text-align:center">Internet Banking</h5>
                    <hr style="height:1px; color:#b79557; background-color:#b79557">
                    <ul>
                        <li>Online help</li>
                        <li>Mobile banking</li>
                        <li>Self service</li>
                        <li>Online statements</li>
                        <li>Card freezes</li>
                    </ul>                    
                </div> 
            </div>
            <!-- WAYS TO BANK BOX -->
            <div class="col-md-3"> 
                <div class="cream-box">
                    <h5 style="text-align:center">Ways to Bank</h5>
                    <hr style="height:1px; color:#b79557; background-color:#b79557">
                    <ul>
                        <li>Internet banking</li>
                        <li>Mobile banking</li>
                        <li>Phone bank</li>
                        <li>Find a branch</li>
                        <li>Find a mobile branch</li>
                    </ul> 
                </div> 
            </div>

        </div>  

    </main>
</div>

<br><br><br><br>

<?php require("Footer.php");?>



