<header>
    <div class="container">
        <div class="title">RideShare@APU</div>

        <div class="desktopNavi">
            <ul>
                <li><a href="index.php#hero">Home</a></li>
                <li><a href="index.php#services">Our Advantages</a></li>
                <li><a href="index.php#workflow">User Guide</a></li>
                <li><a href="#">About Us</a>
                    <ul class="dropdown">
                        <li><a href="admin/adminAboutMe.php">Member 1</a></li>
                        <li><a href="">Member 2</a></li>
                        <li><a href="">Member 3</a></li>
                        <li><a href="s">Member 4</a></li>
                    </ul>
                </li>
            </ul>
            <button onclick="showLoginPopup()">Login</button>
        </div>

        <div onclick="showMenu('mobileNavi')" class="sideMenuIcon"><i class="fa-solid fa-bars"></i></div>
    </div>

    <div class="mobileNavi">
        <div class="closeMenuIcon" onclick="closeMenu('mobileNavi')"><i class="fa-solid fa-xmark"></i></div>
        <ul>
            <li><a href="index.php#hero">Home</a></li>
            <li><a href="index.php#services">Our Advantages</a></li>
            <li><a href="index.php#workflow">User Guide</a></li>
            <li><a href="#">About Us</a>
                <ul class="dropdown">
                    <li><a href="">Member 1</a></li>
                    <li><a href="">Member 2</a></li>
                    <li><a href="">Member 3</a></li>
                    <li><a href="">Member 4</a></li>
                </ul>
            </li>
        </ul>
        <button onclick="showLoginPopup()">Login</button>
    </div>
</header>
