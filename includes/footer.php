<footer>
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="member-Join-Login.php">Join-Login</a></li>
            <li><a href="blog.php">Blog</a></li>
            <li><a href="privacy.php">Privacy&nbsp;Policy</a></li>
        </ul>
    </nav>
</footer>

</div><!-- close container -->

<script src="js/scripts.js"></script>
<script>
	// if isAdmin =1, show the Admin Tools/CMS menu
	// pass on PHP var to JS
	const adminMenu = document.getElementById('admin-menu')
	const isAdmin = <?php echo $isAdmin; ?> // 1  or a 0
	if(isAdmin == 1){
		adminMenu.style.display = "inline-block";
	}
	
	function goToCMS(){
		// event.target is menu choice that called function
		let cms = event.target.value
		if(cms == 1){
			window.location = "blogCMS.php"
		} else if (cms == 2){
			window.location = "CMS-searchApts.php"
		} else if(cms == 3){
			window.location = "CMS-add-apt-bldg-hood.php"
		}
	}

</script>
    
</body>
    
</html>