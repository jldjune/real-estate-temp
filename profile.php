<?php 
    include 'includes/authenticate.php';

    require_once('conn/connApts.php');     
    // query images table to see if this user has an image where isMainPic=1

    $query_mainPic = "SELECT * FROM images WHERE foreignID='$IDmbr' AND isMainPic=1 AND catID=3";

    $result_mainPic = mysqli_query($conn, $query_mainPic);

    if(mysqli_num_rows($result_mainPic) > 0) {
        $row_mainPic = mysqli_fetch_array($result_mainPic);
        $imgName = $row_mainPic['imgName'];
        $userPic = "members/$user/images/$imgName";
    } else { // there is no user main pic in the images table
        // so use the generic coming soon image for the time being
        $userPic = "images/pic-coming-soon.jpg";
    }

    // a second query for all pics to display as thumbs
    $query_all = "SELECT * FROM images WHERE foreignID='$IDmbr' 
    AND catID=3";

    $result_all = mysqli_query($conn, $query_all);

    // load profile pic as uploaded by user. IF user has NOT uploaded a profile pic (WHERE isMainPic=1) default to Coming Soon pic
    $title = 'My Profile'; 
    include 'includes/head.php'; 
    include 'includes/header.php'; 
?>

<main>
    
    <h1><?php echo $user; ?>'s Profile</h1>
    
    <div id="thumbs" style="background-color:#333; overflow-x:scroll; max-height:100px; margin:15px">
        
       <!-- all user-uploaded pics here as thumbs -->
       <?php
         while($row_all=mysqli_fetch_array($result_all)) {
            // make image after image
            $img = $row_all['imgName'];
            $IDimg = $row_all['IDimg'];
            echo "<img src='members/$user/images/$img' height='90px' style='margin:5px; cursor:pointer' onclick='swapImg()' id='$IDimg'>";
         }
       ?>
        
    </div>
    
    <h4 id="server-resp" style="color:maroon">&nbsp;</h4>
    
    <br/>
    <!-- button calls function to update Main/Profile Pic -->
    <button id="update-btn" onclick="updateMainPic()" style="font-size:1rem; padding:5px; background-color:#DFD; margin:5px; display:none">
        Make this My Main Profile Pic
    </button>
    
    <br/>
    <!-- big main profile pic -->
    <img src="<?php echo $userPic; ?>" width="350px" height="auto; margin:15px" id="big-pic">

</main>

<aside>
    <h2>My Profile CMS</h2>
    <h3>Upload Image:</h3>
    
    <form method="post" action="upload-proc.php" enctype="multipart/form-data">
        <p><input type="file" name="myPic" id="myPic"></p>
        <p><input type="checkbox" name="isMainPic" id="isMainPic">
            <label for="isMainPic">My Main Profile Pic</label>
        </p>
        <p><input type="submit" name="submit-pic" id="submit-pic" value="Upload"></p>
        
    </form>
      
</aside>

<script>
    
    // runs on click of any thumb pic
    const bigPic = document.getElementById('big-pic')
    const updateBtn = document.getElementById('update-btn')
    var IDimg = 0; // for storing ID of preview pic (the most recently clicked thumb, now temporarily acting as big pic)
    var serverResp = document.getElementById('server-resp')
    
    function swapImg() {
        // take src of thumb and "copy it" to bigPic
        bigPic.src = event.target.src
        IDimg = event.target.id // ID of new temp big pic
        updateBtn.style.display = "inline-block"
    }
    
    // runs when user clicks Make This My New Main Pic btn
    function updateMainPic() {
        // pass the $IDmbr from PHP to JS
        let IDmbr = <?php echo $IDmbr; ?>
        // get the ID of the preview big pic
        // ajax call to php page to update main pic
        let xhr = new XMLHttpRequest();
        xhr.onload = function() {
            // alert whatever we get back from server
            serverResp.innerHTML = xhr.responseText
            setTimeout(function() { 
                serverResp.innerHTML = "&nbsp;" 
            }, 5000)
            updateBtn.style.display = "none"
        }
        let url = "update-main-pic-proc.php?IDimg=" + IDimg + "&IDmbr=" + IDmbr
        xhr.open("GET", url, true)
        xhr.send()
    } // end func updateMainPic()

</script>

<?php include 'includes/footer.php'; ?>

