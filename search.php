<?php
    require_once("conn/connApts.php");
    // load the buildings for the select menu
    $query = "SELECT IDbldg, bldgName FROM buildings ORDER BY bldgName ASC";
    $result = mysqli_query($conn, $query);
    echo mysqli_error($conn); // check to see if we have any errors yet
?>
<?php include("includes/search-proc.php"); ?>
<?php 
    $title = 'Search'; 
    include 'includes/head.php'; 
    include 'includes/header.php'; 
?>

<main>
    <h1>Search Results</h1>
	
	<?php include("includes/search-results.php"); ?>
	
</main>

<aside>
    <h2>Search Apartments</h2>
	
	<form method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>" onchange="doAjaxSearch()" onsubmit="return validateMinMaxRent()">
            
            <!-- keyword search -->
			<?php if(!isset($search)){
					$search = '';
			} ?>
            <p>Search: <input type="search" name="search" id="search" value="<?php echo $search; ?>"></p>
            
            <p>Building: 
                <select name="bldgID" id="bldgID">
                    <option value="-1">Any</option>
                    <?php
                        while($row=mysqli_fetch_array($result)) {
							if(isset($_GET['bldgID']) && $row['IDbldg'] == $_GET['bldgID']){
							// if user submitted form with building selected, and that building matches the current row
								$selected = 'selected';
							} else {
								$selected = '';
							}
                            echo '<option value="' . $row['IDbldg'] . '" ' . $selected . '>'  . $row['bldgName'] . '</option>';  
                        }
                    ?>
                </select>
            </p>

            <p>Min Rent: 

              <select name="minRent" id="minRent">
                <option value="0">Any</option>

                <?php 

                  $i = 1000;

                  while($i <= 5000) {
					if(isset($_GET['minRent']) && $i == $_GET['minRent']){
							// if user submitted form with building selected, and that building matches the current row
								$selected = 'selected';
					} else {
								$selected = '';
					}
                    echo '<option value="' . $i . '" ' . $selected . '>$' . number_format($i) . '</option>';
                    $i += 250;
                  }

                ?>

              </select>

            </p>

            <p>Max Rent: 
                <select name="maxRent" id="maxRent">
                  <option value="99999">Any</option>
                  <?php 
                    $i = 2000;
                    while($i <= 7500){
						if(isset($_GET['maxRent']) && $i == $_GET['maxRent']){
							// if user submitted form with building selected, and that building matches the current row
								$selected = 'selected';
						} else {
								$selected = '';
						}
                      echo '<option value="' . $i . '" ' . $selected . '>$' . number_format($i) . '</option>';
                      $i += 500;
                    }
                  ?>
                </select>
            </p>

            <p>Bedrooms: 
				<?php
					if(!isset($_GET['bdrms'])){
						$bdrms = -1;
					} else {
						$bdrms = $_GET['bdrms'];
					}
				?>
                <select name="bdrms" id="bdrms">
                    <option value="-1" <?php if($bdrms == -1) echo 'selected'; ?>>Any</option>
                    <option value="0" <?php if($bdrms == 0) echo 'selected'; ?>>Studio</option>
                    <option value="1" <?php if($bdrms == 1) echo 'selected'; ?>>1 bedroom</option>
                    <option value="1.1" <?php if($bdrms == 1.1) echo 'selected'; ?>>1+ bedroom</option>
                    <option value="2" <?php if($bdrms == 2) echo 'selected'; ?>>2 bedrooms</option>
                    <option value="2.1" <?php if($bdrms == 2.1) echo 'selected'; ?>>2+ bedrooms</option>
                    <option value="3" <?php if($bdrms == 3) echo 'selected'; ?>>3 bedrooms</option>
                </select>
            </p>
            
            <p>Baths:
				<?php
					if(!isset($_GET['baths'])){
						$baths = -1;
					} else {
						$baths = $_GET['baths'];
					}
				?>
              <select name="baths" id="baths">
                <option value="-1" <?php if($baths == 0) echo 'selected'; ?>>Any</option>  
                <option value="1" <?php if($baths == 1) echo 'selected'; ?>>1 Bath</option>
                <option value="1.5" <?php if($baths == 1.5) echo 'selected'; ?>>1 1/2 Baths</option>
                <option value="1.6" <?php if($baths == 1.6) echo 'selected'; ?>>1 1/2+ Baths</option>
                <option value="2" <?php if($baths == 2) echo 'selected'; ?>>2 Baths</option>
                <option value="2.1" <?php if($baths == 2.1) echo 'selected'; ?>>2+ Baths</option>
                <option value="2.5" <?php if($baths == 2.5) echo 'selected'; ?>>2 1/2 Baths</option>
              </select>
            </p>
			<p>
				<input type="checkbox" name="isAvail" id="isAvail" value="isAvail" class="cbW">
            	<label>Show Only Available</label>
            
			</p>

            <h2>Building Amenities</h2>

            <input type="checkbox" name="doorman" value="doorman" id="doorman" class="cbW"
			<?php if(isset($_GET['isDoorman'])) echo 'checked'; ?>>
            <label for="doorman" >Doorman</label>
            
            <input type="checkbox" name="pets" value="pets" id="pets" class="cbW"
			<?php if(isset($_GET['pets'])) echo 'checked'; ?>> 
            <label for="pets">Pet-friendly</label>
            <br/><br/>
            <input type="checkbox" name="parking" value="parking" id="parking" class="cbW"
			<?php if(isset($_GET['parking'])) echo 'checked'; ?>> <label>Parking</label>
            
            <input type="checkbox" name="gym" id="gym" value="gym" class="cbW"
			<?php if(isset($_GET['gym'])) echo 'checked'; ?>>
            <label>Gym</label>
		
            <!-- let user choose how results are ordered -->
            <p>Sort by: 
                <select name="orderBy" id="orderBy" style="width:80px">
                    <option value="bdrms" <?php if($orderBy == 'bdrms') echo 'selected'; ?>>Bedrooms</option>
                    <option value="bldgName" <?php if($orderBy == 'bldgName') echo 'selected'; ?>>Building</option>
                    <option value="rent" <?php if($orderBy == 'rent') echo 'selected'; ?>>Rent</option>
                    <option value="sqft" <?php if($orderBy == 'sqft') echo 'selected'; ?>>Square Feet</option>
                </select>
                
                &nbsp; &ensp; Results Per Page: 
                <!-- let user specify num results per pg -->
                <select name="rowsPerPg" id="rowsPerPg" style="width:80px">
                    <option value="5" <?php if($rowsPerPg == 5) echo 'selected'; ?>>5</option>
                    <option value="10" <?php if($rowsPerPg == 10) echo 'selected'; ?>>10</option>
                    <option value="25" <?php if($rowsPerPg == 25) echo 'selected'; ?>>25</option>
                    <option value="50" <?php if($rowsPerPg == 50) echo 'selected'; ?>>50</option>
                </select>
            
            <!-- let user choose ASC or DESC order of results -->
                <br/>
                <input type="radio" name="ascDesc" class="cbW" value="ASC" id="asc" <?php if($ascDesc == 'ASC') echo 'selected'; ?>>
                <label for="asc">Ascending</label>
                
                <input type="radio" name="ascDesc" class="cbW" value="DESC" id="desc"<?php if($ascDesc == 'DESC') echo 'selected'; ?>> 
                <label for="desc">Descending</label>
            </p>
            
            <p><button style="width:100%; padding:5px; font-size:1rem; color:#363; font-weight:800; background-color:#8C8; letter-spacing:10px; text-transform:uppercase">Submit</button></p>

        </form>
</aside>

<script>
        
      function validateMinMaxRent(){
        let minRent = Number(document.querySelector('#minRent').value);
        let maxRent = Number(document.querySelector('#maxRent').value);
        
        if(minRent >= maxRent){
          alert('Please choose a min rent value that is less than the max rent value');
          return false;
        }
      
      
      }
	// 1.) get form inputs to pass values
	const bldgID = document.getElementById('bldgID')
	const orderBy = document.getElementById('orderBy')
    const rowsPerPg = document.getElementById('rowsPerPg')
    const asc = document.getElementById('asc')
    const minRent = document.getElementById('minRent')
    const maxRent = document.getElementById('maxRent')
	const bdrms = document.getElementById('bdrms')
    const baths = document.getElementById('baths')
    const isAvail = document.getElementById('isAvail')

    
    
	
	function doAjaxSearch(){
		// 2.) concat querystring of variables appended to URL
        let url = "searchAjaxProc.php?"
		url += "bldgID=" + bldgID.value
		url += "&orderBy=" + orderBy.value
		url += "&rowsPerPg=" + rowsPerPg.value
		url += "&ascDesc=" + (asc.checked ? 'ASC': 'DESC')
		url += "&minRent=" + minRent.value
		url += "&maxRent=" + maxRent.value
		url += "&bdrms=" + bdrms.value
		url += "&baths=" + baths.value
		if(isAvail.checked) url += "&isAvail=yes" 

		
		
		 // 3.) Make an AJAX call, sending vars to named url
        let xhr = new XMLHttpRequest()
        xhr.onreadystatechange = function() {
            if(xhr.readyState == 4 && xhr.status == 200) {
               //we got new table response, use to replace current table
				document.querySelector('table').remove();//remove current table
                document.querySelector('main').innerHTML += xhr.responseText;
				
            }
        }
        xhr.open("GET", url, true)
        xhr.send()
	}
    
    </script>

<?php include 'includes/footer.php'; ?>