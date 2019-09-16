<!-- this comes right after opening of <div id="container"> --><header>
<!-- this file gets included into template.php -->
    <nav>
        
        <!-- search form w mag glass submit btn -->
        <!--<form method="get" action="search-proc.php">
            <input type="search" name="search" id="search" placeholder="Search">
            <button class="btn"><!-- Font Awesome search magnifying glass icon
                <i class="fa fa-search"></i>
            </button>
        </form>-->
        
        <!-- burger btn to toggle nav link view -->
        <button class="btn btn-burger" id="burger-btn"><!-- Font Awesome responsive layout media query hamburger -->
            <i class="fa fa-bars"></i>
        </button>
        
        <!-- nav links -->
        <ul class="nav-ul" id="navUL">
            <li><a href="index.php">Home</a></li>
            <li><a href="member-Join-Login.php">Join-Login</a></li>
            <li><a href="profile.php">My Profile</a></li>
            <li><a href="blog.php">Blog</a></li>
			<li><a href="search.php">Search</a></li>
			<li>
				<select name="admin-menu" id="admin-menu" style="display:none;"
						onchange="goToCMS()">
					<option value="-1">Admin CMS Tools</option>
					<option value="1">Add-a-Blog</option>
					<option value="2">Update Property</option>
					<option value="3">Add Property</option>
				</select>
			</li>
        </ul>
        
        <?php 
            // output Welcome and Logout link. This var was concatenated in authenticate.php
            echo $welcome_msg; 
        ?>
        
    </nav>
    
</header>