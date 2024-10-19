<?php
include "page_css.php";
echo '
<body>
    <aside id="sidebar" class="d-none d-sm-block">
        <div class="d-flex">
            <div class="sidebar-logo">
                <img src="images/pcLogo.png" class="mx-auto d-block" alt="Profile Connect Logo">
            </div>
        </div>
        <ul class="sidebar-nav">
        <li class="sidebar-item">
        <a href="../dashboard/dashboard.php" class="sidebar-link">
            <i class="lni lni-grid-alt"></i>
            <span>Dashboard</span>
        </a>
        </li>
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
                    <span>Log out</span>
                </a>
            </li>
        </ul>
        <div class="sidebar-footer">
            <p>Profile Connect © 2024</p>
        </div>
    </aside>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>';
