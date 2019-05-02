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
		
		<script src="https://underscorejs.org/underscore.js"></script>
		<script src="https://unpkg.com/terraformer@1.0.8"></script>
		<script src="https://unpkg.com/terraformer-arcgis-parser@1.0.5"></script>
		<script src="https://unpkg.com/terraformer-wkt-parser@1.1.2"></script>
	</head>

	<body onload="up206b.initialize()">
		<div class="wrap" style="height: 800px">
			<nav class="navbar-inverse" role="navigation">
				<div class="container-fluid">
					<div class="navbar-header">
						<a class="navbar-brand" href="#"><b>Zona Nilai Tanah Kota Solok</b></a>
					</div>
					<ul class="nav navbar-nav navbar-right">
					<?php if (isset($_SESSION['usr_id'])) { ?>
						<li><p class="navbar-text">Signed in as <b><?php echo $_SESSION['usr_name']; ?></b>!</p></li>
						<li><a href="logout.php">Logout</a></li>
					<?php } else { header('Location:index.php'); } ?>
					</ul>
				</div>
			</nav>
	
			<div class="body-content">
				<div class="sidebar" >
					<div class="container" style="width:100%; height: 100%; overflow:auto; float:left; padding-left:10px; padding-right:10px;">
						<br>
						<div class="cari-nama">
							<input type="submit" value="Search" style="float: right; width: 24%" id="btnfind" name="" class="btn-primary form-control">
							<div style="overflow: hidden; ">
								<input type="text" style="width: 98%;" list="find" id="inputname" name="" class="form-control" placeholder="Nama Kecamatan...">
								<datalist id="find">
									<option value="LUBUK SIKARAH"></option>
									<option value="TANJUNG HARAPAN"></option>
								</datalist>
							</div>
						</div>

						<hr>

						<div>
							<div style="padding-top: 10px">
								<b>Desa/Kelurahan :</b>
								<input list="listdata" id="starts" class="form-control" value="" onchange="getArea()">
									<datalist id="listdata">
									</datalist>
							</div>
							<div style="padding-top: 15px; float: right;">
								<input type="submit" id="submit" value="Submit" style="float: right; width: 100%" class="btn-primary form-control">
							</div>
						</div>

						<hr>

						<div class="form" name="form-update" style="padding-top: 10px">
							<form method="post" action="update.php">
								<div class="form-group">
									<input type="hidden" id="form-gid" name="gid" value=""/>
									<label for="name">Kecamatan </label>
									<input id="form-kec" type="text" name="kecamatan" readonly value="" class="form-control"/>
								</div>
								<div class="form-group">
									<label for="name">Desa/Kelurahan </label>
									<input id="form-desa" type="text" name="nama" readonly value="" class="form-control"/>
								</div>
								<div class="form-group">
									<label for="name">NJOP </label>
									<input id="form-njop" type="text" name="njop" value="" class="form-control"/>
								</div>
								<div class="form-group">
									<input type="submit" name="bphtb" class="btn btn-info" value="Lihat BPHTB" />
									<input type="submit" name="pph" class="btn btn-info" value="Lihat PPH" />
									<input type="submit" name="update" class="btn btn-success" value="Update" style="float: right"/>
								</div>
							</form>
						</div>
					</div>
				</div>

			<div id="map" style="width: 75%;">
				Map here
			</div>

			<script>
				var fillIdx = 0;
				var fills = [
				'#22A164',
				'#00005E',
				'#3C0D68',
				'#FB3837',
				'#22A164',
				];
				
				google.maps.Polygon.prototype.getBounds = function() {
					var bounds = new google.maps.LatLngBounds();
					var paths = this.getPaths();
					var path;        
					for (var i = 0; i < paths.getLength(); i++) {
						path = paths.getAt(i);
						for (var ii = 0; ii < path.getLength(); ii++) {
							bounds.extend(path.getAt(ii));
						}
					}
					return bounds;
				}

				var transform = function(multipolygon, map, nama, q, njop, gid) {
					var geojson = ''
					try {
						var geojson = Terraformer.WKT.parse(multipolygon)
						geojson = geojson.toGeographic()
					}
					catch (e) {
						geojson = e;
						console.log('except');
					}
					
					// console.log(JSON.stringify(geojson, undefined, 2));
					var bounds = new google.maps.LatLngBounds();
					
					var paths = _.map(geojson.coordinates, function(entry) {
						return _.reduce(entry, function(list, polygon) {
						// This map() only transforms the data.
							_.each(_.map(polygon, function(point) {
							// Important: the lat/lng are vice-versa in GeoJSON
							return new google.maps.LatLng(point[1]-66.9168471248, point[0]+94.5075762852);
						}), function(point) {
							list.push(point);
						});

						return list;
						}, []);
					});

					fillIdx = (fillIdx >= fills.length) ? 0 : fillIdx + 1;
					var polygon = new google.maps.Polygon({
						paths: paths,
						strokeWeight: 0,
						fillColor: fills[fillIdx],
						fillOpacity: 0.90
					});

					var bounds = new google.maps.LatLngBounds();
					for (var i=0; i< paths[0].length; i++) {
						bounds.extend(paths[0][i]);
					}

					var myLatlng = bounds.getCenter();

					marker=new google.maps.Marker({
						position: myLatlng, map: map, animation: google.maps.Animation.DROP
					});
					resultmarker.push(marker);
					createInfoWindow(marker, nama, q, njop, gid);
					return polygon;
				};

				$(function() {
					$(this).on('click', '#sample-wkt', function(e) {
						$.get('https://s3-us-west-2.amazonaws.com/s.cdpn.io/44521/sample_wkt_1.txt', function(data) {
						$('#wkt')
							.val(data)
							.trigger('change');      
						})
					})
				})
			</script>
			
			<script type="text/javascript">
				//declare namespace
				var up206b = {};

				//declare map
				var map;
				var mydata;
				var resultmarker = [];

				function trace(message) 
				{ 
					if (typeof console != 'undefined') 
					{
						console.log(message);
					}
				}

				var createInfoWindow = function(marker, nama, q, njop, gid){
						infowindow = new google.maps.InfoWindow();
						google.maps.event.addListener(marker, 'click', function(){
							infowindow.close();
							infowindow.setContent("<b>Desa/Kelurahan</b> : "+nama+"<br><b>Kecamatan</b> : "+inputname.value+"<br><b>NJOP</b> : Rp "+njop);
							infowindow.open(map, marker);
							document.getElementById("form-gid").value = gid;
							document.getElementById("form-kec").value = q;
							document.getElementById("form-desa").value = nama;
							document.getElementById("form-njop").value = njop;
						});
					}

				//Function that gets run when the document loads
				up206b.initialize = function()
				{
					var myOptions = {
						center: {lat: -0.7900853, lng: 100.6488506}, zoom: 15
					};
					map = new google.maps.Map(document.getElementById("map"), myOptions);
				}

				var getArea = function(){
					var markers = [];
					var infowindow = [];
					$.ajax({
							url: "common.php?q="+inputname.value+"&desa="+starts.value,
							dataType: 'json',
							method: 'GET',
							error: function(data){
								alert('Data does not exist!');
								return;
							},
							success: function(data){
								up206b.initialize();
								mydata = data;
								// console.log(mydata);
								var i;
								for(i = 0; i < data['list'].length; i++) {
									var polygon=transform(data['list'][i]['area'], map, data['list'][i]['nama'], inputname.value, data['list'][i]['njop'], data['list'][i]['gid']);
									polygon.setMap(map);
								}
								map.fitBounds(polygon.getBounds());
							}
						});
					}

				function initialize() {
					
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
							document.getElementById("listdata").value = "";
							document.getElementById("starts").innerHTML = "";
							document.getElementById("starts").value = "";
							$.ajax({
								url: "common.php?q="+inputname.value,
								dataType: 'json',
								method: 'GET',
								error: function(data){
									alert('Data does not exist!');
									return;
								},
								success: function(data){
									up206b.initialize();
									document.getElementById("listdata").innerHTML = "";
									document.getElementById("listdata").value = "";
									document.getElementById("starts").innerHTML = "";
									document.getElementById("starts").value = "";
									var i;
									for(i = 0; i < data['list'].length; i++) {
										var polygon=transform(data['list'][i]['area']);
										polygon.setMap(map);
									}

									for (i=0; i<data['nama'].length; i++) {
										nama=data['nama'][i].nama;
										document.getElementById("listdata").innerHTML += "<option value='"+nama+"'>";
									}
									map.fitBounds(polygon.getBounds());
								}
							});
						}
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