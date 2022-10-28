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

//----- Pagination -----
//Variables
$table_name = "Audit";
$rows_per_page = 15;
//Current Page
$page = (isset($_GET['page'])) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $rows_per_page;
// DB Query
$db = new SQLite3('/Applications/XAMPP/xamppfiles/htdocs/Data/StudentModule.db');
$sql = "SELECT * FROM $table_name ORDER BY rowid DESC LIMIT $start, $rows_per_page "; $result = $db->query($sql);
//Total pages
$count_rows = $db->query("SELECT COUNT(*) FROM $table_name ")->fetchArray()[0]; 
$total_pages = ceil($count_rows / $rows_per_page);

?>


<div class="container bgColor">
    <main role="main" class="pb-3">
        
        <br>
        <h2>User Audit Trail</h2><br>   

        <div class="row">
            <div class="col">
                <div class="cream-box-no-height">

                    <!-- PAGINATION BUTTONS -->
                    <?php if ($total_pages > 1) : ?>
                        <div class="row">
                            <div class="col-md-12">
                                <nav aria-label="Page navigation example">
                                    <ul class="pagination">

                                        <!-- Previous Page button -->
                                        <?php if ($page > 1) : ?>
                                            <li class="page-item">
                                                <a href="viewAuditTrail.php?page=<?php echo $page - 1; ?>"  class="page-link">Previous</a>
                                            </li>
                                            <?php else: ?>
                                                <li class="page-item disabled">
                                                    <span class="page-link">Previous</span>
                                                </li>
                                        <?php endif; ?>
                                        
                                        <!-- Number pages buttons -->
                                        <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
                                            <?php if ($i == $page) : ?>
                                                <li class="page-item active">
                                                    <span class="page-link"><?php echo $i; ?></span>
                                                </li>
                                                <?php else: ?>
                                                    <li class="page-item">
                                                        <a href="viewAuditTrail.php?page=<?php echo $i; ?>" class="page-link"><?php echo $i; ?></a>
                                                    </li>
                                            <?php endif; ?>
                                        <?php endfor; ?>

                                        <!-- Next Page button -->
                                        <?php if ($page < $total_pages) : ?>
                                            <li class="page-item">
                                                <a href="viewAuditTrail.php?page=<?php echo $page + 1; ?>" class="page-link">Next</a>
                                            </li>
                                            <?php else: ?>
                                                <li class="page-item disabled">
                                                    <span class="page-link">Next</span>
                                                </li>
                                        <?php endif; ?>

                                    </ul>
                                </nav>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- view user table -->                            
                    <table class="styled-table table-responsive">
                        <thead>
                            <tr>
                                <th>Application ID</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Old Product (GBP)</th>
                                <th>New Product (GBP)</th>
                                <th>Status</th>
                                <th>Time stamp</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $result->fetchArray(SQLITE3_ASSOC)) : ?>
                            <tr>
                                <?php foreach ($row as $key => $value) : ?>
                                    <td><?php echo $value; ?></td>
                                <?php endforeach; ?>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>

                    <br>
                    <!-- Create PDF report -->
                    <div style="text-align:right"><a href=auditPdf.php target="_blank">Generate Audit Trail PDF</a></div>

                </div>
            </div>       
        
            <div class="col"> </div>
        
        </div>    
        
    </main>
</div>

<br><br><br>

<?php require("Footer.php"); ?>
