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
								<p class="navbar-text">Signed in as<b> <?php echo $_SESSION['usr_name']; ?></b></p>
								<a href="logout.php">Logout</a>
							</div>
						</form>
					</div>
				</div>
			</nav>
			
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

						<hr>

						<div class="form" name="form-update" style="padding-top: 10px">
							<form method="post" action="update.php">
								<div class="form-group">
									<label for="name">Kecamatan </label>
									<input type="text" name="kecamatan" readonly value="<?php if($q=1) echo 'LUBUK SIKARAH'; elseif($q=2) echo 'TANJUNG HARAPAN'; ?>" class="form-control"/>
								</div>
								<div class="form-group">
									<label for="name">Desa/Kelurahan </label>
									<input type="read-only" name="nama" readonly value="<?php echo $nama; ?>" class="form-control"/>
								</div>
								<div class="form-group">
									<label for="name">NJOP </label>
									<input type="email" name="email" readonly value="<?php echo $njop; ?>" class="form-control"/>
								</div>
								<div class="form-group">
									<input type="submit" name="update" class="btn btn-primary" value="Update"/>
								</div>
							</form>
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
										// marker=new google.maps.Marker({
										// 	position: newcenter, map: map, animation: google.maps.Animation.DROP
										// });
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