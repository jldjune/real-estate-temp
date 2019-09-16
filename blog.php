<?php

    require_once("conn/connApts.php");

    // load the 11 most recent blogs: 1 for main and 10 for archive
    // load the newest blog first (catID = 3 = members)
    $query = "SELECT * FROM blogs, members 
			WHERE blogs.mbrID = members.IDmbr
    		ORDER BY blogDateTime DESC LIMIT 11";

    $result = mysqli_query($conn, $query);

    // set aside the first result for prominent display in main
    $row = mysqli_fetch_array($result);

	// second query to load the author's main profile pic
	$query2 = "SELECT * FROM images, members
			WHERE images.foreignID = members.IDmbr
			AND catID=3 AND isMainPic=1";
	$result2 = mysqli_query($conn, $query2);
	$row2 = mysqli_fetch_array($result2)
 
?>
<?php 
    $title = 'Blog'; 
    include 'includes/head.php'; 
    include 'includes/header.php'; 
?>

<main>
    <h1>Welcome to LoftyHeights Blog</h1>
	<h2><?php echo $row['blogTitle']; ?></h2>
    <h3><?php echo $row['blogBlurb']; ?></h3>
            
    <img src="members/<?php echo $row['user']; ?>/images/<?php echo $row2['imgName']; ?>" 
    style="float:left; margin:10px; width:100px; height:100px; border-radius:50%"
    onerror="this.src='images/default-profile.png';"
    >
            
    <h4>Author: <?php echo $row['firstName'] . ' ' . $row['lastName']; ?></h4>
    <h4>Posted: <?php echo date('D. M. d, Y - H:m', strtotime($row['blogDateTime'])); ?></h4>
    <hr/>
    <p><?php echo $row['blogEntry']; ?></p>
</main>

<aside>
    <h2>Blog Archive</h2>
	
	<?php while($row = mysqli_fetch_array($result)) { ?>
            
             <a href="blogArchive.php?IDblog=<?php echo $row['IDblog']; ?>">
                <h4><?php echo $row['blogTitle']; ?></h4>
             </a>
            
             <img src="members/<?php echo $row['user']; ?>/images/<?php echo $row2['imgName']; ?>" 
             style="float:left; margin:10px; width:50px; height:50px; border-radius:50%"
             onerror="this.src='images/default-profile.png';"
             >
            
             <p>Author: <?php echo $row['firstName'] . ' ' . $row['lastName']; ?><br/>
              Posted: <?php echo date('D. M. d, Y - H:m', strtotime($row['blogDateTime'])); ?></p>
              <hr/>
            
      <?php } ?>
</aside>

<?php include 'includes/footer.php'; ?>