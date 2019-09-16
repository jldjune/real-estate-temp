<?php
      // set only if user clicked I Forgot My Pswd link
    $forgot_msg = "";
    if(isset($_GET['forgot'])) {
          // ???
          $forgot_msg = '<p>Please Enter the Email Associated with this Account:</p>';
          $forgot_msg .= '<form method="post" action="join-login/forgot-pswd-proc.php">';
          $forgot_msg .= '<input type="lostEmail" name="lostEmail" id="lostEmail" placeholder="Email" required>';
          $forgot_msg .= '<input type="submit" style="width:100px" name="submit" id="submit"></form><br><br>';

      }
?>

<?php 
    $title = 'Join or Login'; 
    include 'includes/head.php'; 
    include 'includes/header.php'; 
?>

<main>
    <h1>CONTENT THAT IS UNIQUE TO THIS PAGE GOES HERE.</h1>
</main>

<aside>
    <h2 id="join-now">Join Now -- It's FREE!</h2>
      
    <h3 id="already-mbr">Already a member? Please 
        <button onclick="showLogin()" style="font-size:1.1rem; background-color:#DDD; font-weight:bold">Log in</button>
    </h3>
      
    <!-- help the user recover their password -->
    <a href="<?php echo $_SERVER['PHP_SELF']; ?>?forgot=true" >
        I Forgot my Username and/or Password</a><br/><br/>
    
    <!-- this div is only visible if user clicks Forgot Pswd -->
    <div style="background-color:#FEE; padding:5px">
        <?php echo $forgot_msg; ?>
    </div>
      
    <div id="login-div" style="padding:10px; background-color:papayawhip; display:none">
        
        <button onclick="hideLogin()" style="font-size:1.1rem; background-color:#FFF; font-weight:bold; float:right">X </button>
        
        <form method="post" action="join-login/login-Proc.php">
            
            <h3>Please Log in:</h3>
            
            <p><input type="text" name="user" required placeholder="User Name"></p>

            <p><input type="password" name="pswd" required placeholder="Password"></p>
            
            <p><button style="width:200px; padding:5px; font-size:1rem; font-weight:bold">Log In</button></p>
            
        </form>
        
    </div>
    
    <div id="join-div" style="padding:10px; background-color:peachpuff">
        
        <form method="post" action="join-login/memberJoin-Proc.php" onsubmit="return validatePasswords()">

            <p><input type="text" name="firstName" id="firstName" required placeholder="First Name"></p>

            <p><input type="text" name="lastName" id="lastName" required placeholder="Last Name"></p>

            <p><input type="email" name="email" id="email" required placeholder="Email"></p>

            <p><input type="text" name="user" id="user" required placeholder="User Name"></p>

            <p><input type="password" name="pswd" id="pswd" required placeholder="Password"></p>

            <p><input type="password" name="pswd2" id="pswd2" required placeholder="Re-type Password"></p>

            <p><button style="width:200px; padding:5px; font-size:1rem; font-weight:bold">Submit</button></p>

        </form>
      
      </div><!-- close login-div -->
</aside>

<script>
    
    function validatePasswords() {
        //check to see if the passwords match
        var pswd = document.getElementById("pswd").value;
        var pswd2 = document.getElementById("pswd2").value;
        if(pswd != pswd2) {
            alert("Passwords do not match!");
            return false;
        } // end if
    } // end function
    
</script>

<script>
     
    const loginDiv = document.getElementById('login-div');
    const joinDiv = document.getElementById('join-div');
    
    // click the Log In button to show the login div
    function showLogin() { 
        loginDiv.style.display = "block";
        joinDiv.style.display = "none";
    }
     
    // click the X button in login div to hide login div
    function hideLogin() { 
        loginDiv.style.display = "none";
        joinDiv.style.display = "block";
    }

    function hideJoin(){
        joinDiv.style.display = "none";
    }
     
  </script>

    
   <?php

    // calls hideJoin function to hide join div if 'forgot' is set
        if(isset($_GET['forgot'])) {
            echo "<script>hideJoin()</script>";
        }
      // Are we landing on this page fresh, or due to a redirect to try again after a failed login attempt?

      // set only if redirected after failed login attempt
      if(isset($_GET['tryagain'])) { 
        // show the login form
        echo '<script>showLogin();</script>';
      }

    ?>

<?php include 'includes/footer.php'; ?>