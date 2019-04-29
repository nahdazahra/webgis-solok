<?php
@session_start();
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Zona Nilai Tanah Kota Solok</title>
		<meta content="width=device-width, initial-scale=1.0" name="viewport" >
		<link rel="stylesheet" type="text/css" href="style.css">
		<script type="text/javascript" src="js/bootstrap.js"></script>
    <script data-require="jquery@*" data-semver="2.2.0" src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <link data-require="bootstrap@3.3.6" data-semver="3.3.6" rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script data-require="bootstrap@3.3.6" data-semver="3.3.6" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
		<script src="script.js"></script>
		<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&key=AIzaSyAxgh83y8vSI1-91nTOTDiUfQUmWmpcfRU&libraries=geometry&callback=fnToRunWhenAPILoaded"></script>

	</head>
	<body onload="up206b.initialize()">
		<div class="wrap" style="height: 1000px">
			<nav class="navbar-default" role="navigation">
				<div class="container-fluid">
					<div class="navbar-header">
						<a class="navbar-brand" href="#"><b>Zona Nilai Tanah Kota Solok</b></a>
					</div>
					<div class="collapse navbar-collapse">
						<form class="navbar-form navbar-right">
							<div id="my_modal" class="btn-group">
								<?php if (isset($_SESSION['usr_id'])) { ?>
									<p class="navbar-text">Signed in as <?php echo $_SESSION['usr_name']; ?></p>
									<a href="logout.php">Logout</a>
								<?php } else { ?>
									<button data-toggle="modal" data-target="#id01" class="btn btn-primary modal-btn">Login</button>
									<button data-toggle="modal" data-target="#id02" class="btn btn-primary modal-btn">Register</button>
								<?php } ?>
							</div>
						</form>
					</div>
				</div>
			</nav>
	
			<div id="id01" class="modal fade" aria-labelledby="myModalLabel" aria-hidden="true" tabindex="-1" role="dialog">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
								<h4 class="modal-title">Login Form</h4>
						</div>
						<div class="modal-body" id="myModalBody1">
							<form role="form" method="post" action="login_content.php">
								<fieldset>
									<div class="form-group">
										<label for="name">Email</label>
										<input type="text" name="email" placeholder="Masukkan Email" required class="form-control"/>
									</div>
									<div class="form-group">
										<label for="name">Password</label>
										<input type="password" name="password" placeholder="Masukkan Password" required class="form-control"/>
									</div>
									<div class="form-group">
										<input type="submit" name="login_user" class="btn btn-primary" value="Login"/>
									</div>
								</fieldset>
							</form>
						</div>
					</div>
				</div>
			</div>
	
			<div id="id02" class="modal fade" aria-labelledby="myModalLabel" aria-hidden="true" tabindex="-1" role="dialog">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
							<h4 class="modal-title">Registration Form</h4>
						</div>
						<div class="modal-body" id="myModalBody2">
							<form method="post" action="register_content.php">
								<div class="form-group">
									<label for="name">NIP </label>
									<input type="text" name="nip" placeholder="Masukkan NIP" required value="<?php if($error) echo $nip; ?>" class="form-control"/>
									<span class="text-danger"><?php if (isset($regnip_error)) echo $regnip_error; ?></span>
								</div>
								<div class="form-group">
									<label for="name">Nama </label>
									<input type="nama" name="nama" placeholder="Nama Lengkap" required value="<?php if($error) echo $nama; ?>" class="form-control"/>
									<span class="text-danger"><?php if (isset($name_error)) echo $name_error; ?></span>
								</div>
								<div class="form-group">
									<label for="name">Email </label>
									<input type="email" name="email" placeholder="Email" required value="<?php if($error) echo $email; ?>" class="form-control"/>
									<span class="text-danger"><?php if (isset($email_error)) echo $email_error; ?></span>
								</div>
								<div class="form-group">
									<label for="name">Password </label>
									<input type="password" name="password_1" placeholder="Password" required class="form-control" />
								</div>
								<div class="form-group">
									<label for="name">Konfirmasi password </label>
									<input type="password" name="password_2" placeholder="Konfirmasi Password" required class="form-control" />
									<span class="text-danger"><?php if (isset($cpassword_error)) echo $cpassword_error; ?></span>
								</div>
								<div class="form-group">
									<input type="submit" name="reg_user" class="btn btn-primary" value="Register"/>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
	
			<script>
			// Get the modal
			var modal1 = document.getElementById('id01');
			var modal2 = document.getElementById('id02');
	
			// When the user clicks anywhere outside of the modal, close it
			window.onclick = function(event) {
				if (event.target == modal1) {
					modal1.style.display = "none";
				}
			}
			window.onclick = function(event) {
				if (event.target == modal2) {
					modal2.style.display = "none";
				}
			}
			</script>
	
			<div class="body-content">
				<div class="sidebar" >
					<div class="container" style="width:100%; height: 100%; overflow:auto; float:left; padding-left:10px; padding-right:10px;">
						<br>
						<div class="cari-nama">
							<input type="submit" value="Search" style="float: right; width: 24%" id="btnfind" name="" class="btn-success form-control">
							<div style="overflow: hidden; ">
								<input type="text" style="width: 98%;" list="find" id="inputname" name="" class="form-control" placeholder="Nama Kecamatan...">
								<datalist id="find">
									<option value="LUBUK SIKARAH"></option>
									<option value="TANJUNG HARAPAN"></option>
								</datalist>
							</div>
						</div>
						<div id="listdata" style="background:white; height: auto; overflow: auto;"></div>

						<hr>

						<div class="form-check">
							<input type="checkbox" class="form-check-input" id="zona_tanah">
							<label class="form-check-label">Lihat seluruh zona tanah</label>
						</div>

						<hr>

						<div>
							<div style="padding-top: 10px">
								<b>Desa/Kelurahan :</b>
								<input list="start" id="starts" class="form-control">
									<datalist id="start">
									</datalist>
							</div>
							<div style="padding-top: 15px; float: right;">
								<input type="submit" id="submit" class="btn-primary form-control" style="width: 100%">
							</div>
						</div>
					</div>
				</div>

			<div id="map" style="width: 75%;">
				Map here
			</div>

			<script type="text/javascript">
				//declare namespace
				var up206b = {};

				//declare map
				var map;

				//set the geocoder
				var geocoder = new google.maps.Geocoder();

				function trace(message) 
				{
					if (typeof console != 'undefined') 
					{
						console.log(message);
					}
				}

				//Function that gets run when the document loads
				up206b.initialize = function()
				{
					var myOptions = {
						center: {lat: -0.7900853, lng: 100.6488506}, zoom: 15
					};
					map = new google.maps.Map(document.getElementById("map"), myOptions);
				}
				function initialize() {
					function show_zona_tanah(){
						zona_tanah = new google.maps.Data();
						zona_tanah.addGeoJson('geojson.php');
						zona_tanah.setMap(map);
					}
					function toggle_zona_tanah(){
						if (typeof zona_tanah.setMap == 'function') {
							if (document.getElementById("zona_tanah").checked == true) {
								zona_tanah.setMap(map);
							}
							else {
								zona_tanah.setMap(null);
							}
						}
						else{
							if (document.getElementById("zona_tanah").checked == true) {
								show_zona_tanah();
							}
						}
					}
					document.getElementById("zona_tanah").addEventListener("change", toggle_zona_tanah);

					resultmarker = [];
					
					function findname(){
						for (var i = 0; i < resultmarker.length; i++){
							resultmarker[i].setMap(null);
						}
						resultmarker = [];

						if(inputname.value==''){
							alert("The column should not be blank!");
						}
					
						else{
							document.getElementById("listdata").innerHTML = "";
							var xmlhttp = new XMLHttpRequest();
							var url = "findname.php?q="+inputname.value;
							xmlhttp.onreadystatechange = function() {
								if (this.readyState == 4 && this.status == 200) {
									var arr = JSON.parse(this.responseText);
									if(arr == null){
										alert('Data does not exist!');
										return;
									}
									var i;

									for(i = 0; i < arr.length; i++) {
										gid=arr[i].gid,
										nama=arr[i].nama,
										luas=arr[i].luas,
										// newcenter=new google.maps.LatLng(latitude, longitude);
										marker=new google.maps.Marker({
											position: newcenter, map: map, animation: google.maps.Animation.DROP
										});
										// resultmarker.push(marker);
										// map.setZoom(13);
										// map.setCenter(newcenter);
										// createInfoWindow(marker, gid, nama);
										document.getElementById("listdata").innerHTML += "<li id="+gid+" onclick='showdetail(this.id)'>"+nama+"</li>";
									}
								}
							};
							xmlhttp.open("GET", url, true);
							xmlhttp.send();
						}
					}
					
					function createInfoWindow(marker, gid, nama){
						infowindow = new google.maps.InfoWindow();
						google.maps.event.addListener(marker, 'click', function(){
							infowindow.close();
							infowindow.setContent("<b>Desa/Kelurahan</b> : "+kel+"<br><b>Kecamatan : </b>"+kec+"<br><b>NJOP : </b>"+njop);
							infowindow.open(map, marker);
						});
					}

					document.getElementById("btnfind").addEventListener("click", findname);
					document.getElementById("inputname").addEventListener("keyup", function(event){
						if (event.keyCode==13){
							btnfindname();
						}
					});

					var directionsService = new google.maps.DirectionsService;
					var directionsDisplay = new google.maps.DirectionsRenderer;
					directionsDisplay.setMap(map);
				}
				google.maps.event.addDomListener(window, 'load', initialize);
			</script>
		</div>
	</body>
</html>