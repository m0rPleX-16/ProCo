<?php
include "page_css.php";

// Assume you have a $conn variable for database connection
include_once('DbConnection.php');

// Create a new instance of the DbConnection class
$dbConnection = new DbConnection();
$conn = $dbConnection->getConnection();
// Fetch the profile picture URL from the residents_tb using the foreign key Res_ID and matching email
$sql = "SELECT r.Res_Img 
        FROM residents_tb r 
        INNER JOIN staff_tb s ON r.id = s.Res_ID 
        WHERE s.email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $_SESSION['staff_email']); // Assuming email is stored in $_SESSION['email']
$stmt->execute();
$stmt->bind_result($profilePicture);
$stmt->fetch();
$stmt->close();

echo '
    <nav class="navbar navbar-expand px-4 py-1">
        <div class="container-fluid justify-content-between">
            <div class="navbar-logo d-none d-sm-block">
                <img src="./images/procoLogo.png" class="navbarLogo" alt="Profile Connect logo">
            </div>
            <!-- hamburger menu starts here -->
            <button class="btn d-block d-sm-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasSidebar" aria-controls="sidebar" >
                <i class="fa-solid fa-bars"></i>
            </button>
            <!-- hamburger menu ends here -->
            <div class="d-flex align-items-center">
                <div class="username me-auto">
                    <span>Hello, ' . $_SESSION['staff_role'] . ' ' . $_SESSION['staff_username'] . '</span>
                </div>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-icon pe-md-0">
                            <img src="../../resImg/' . $profilePicture . '" class="avatar img-fluid" alt="Profile Picture">
                        </a>
                        <div class="dropdown-menu dropdown-menu-end rounded">
                            <a href="../profile/profile.php" class="dropdown-item">
                                <i class="lni lni-friendly"></i>
                                <span>Profile</span>
                            </a>
                            <a href="../logout.php" class="dropdown-item">
                                <i class="lni lni-exit"></i>
                                <span>Log-Out</span>
                            </a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    
    <!-- Offcanvas content -->
    <div class="offcanvas offcanvas-start offcanvas-md" data-bs-backdrop="static" tabindex="-1" id="offcanvasSidebar" aria-labelledby="sidebar-label" style="width: 220px;">
        <div class="offcanvas-header" style="background-color: #0C3B2E; height: 120px; margin-left:">
            <h1 class="offcanvas-logo">
                <img src="../../images/pcLogo.png" class="navbarLogo" alt="Profile Connect logo" id="sidebar-label"style="max-width: 100%; max-height: 100%; height: 80px; margin-left: 50px;">
            </h1>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close" style="background-color: #FDF7EF;"></button>
        </div>
        <div class="offcanvas-body" style="background-color: #0C3B2E; font-size: 50px;">
            <div id="sidebar">
            <ul class="sidebar-nav">
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse" data-bs-target="#records" aria-expanded="false" aria-controls="records">
                        <i class="lni lni-files"></i>
                        <span>Records</span>
                    </a>
                    <div class="dropdown">
                        <ul id="records" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                            <li class="sidebar-item">
                                <a href="../resident/resident.php" class="sidebar-link">
                                    <span>Resident</span>
                                </a>
                            </li>
                            <li class="sidebar- item">
                                <a href="../family/families.php" class="sidebar-link">
                                    <span>Families</span>
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <a href="../household/household.php" class="sidebar-link">
                                    <span>Household</span>
                                </a>
                            </li>
                        </ul>
                    </div>  

                <li class="sidebar-item">
                    <a href="../certificates/certificates.php" class="sidebar-link">
                        <i class="lni lni-printer"></i>
                        <span>Transaction</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="../events/events.php" class="sidebar-link">
                        <i class="lni lni-calendar"></i>
                        <span>Events</span>
                    </a>
                </li>
                <li class="sidebar-item">
                <a href="../officials/officials.php" class="sidebar-link">
                    <i class="lni lni-briefcase"></i>
                    <span>Officials</span>
                </a>
                </li>
                <li class="sidebar-item">
                    <a href="../logout.php" class="sidebar-link">
                        <i class="lni lni-arrow-left-circle"></i>
                        <span>Sign out</span>
                    </a>
                </li>
            </ul>
            <div class="sidebar-footer">
                <p>Profile Connect © 2024</p>
            </div>


            </div>

        </div>
    </div>';
