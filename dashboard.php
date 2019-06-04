<?php
  require_once('config.php');
	@session_start();
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Peta Zona Nilai Tanah Kota Solok</title>

		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="description" content="">
		<meta name="author" content="">

		<!-- Custom fonts for this template-->
		<link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

		<!-- Page level plugin CSS-->
		<link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">

		<!-- Custom styles for this template-->
		<link href="css/sb-admin.css" rel="stylesheet">
		
		<!-- Bootstrap dan CSS untuk tampilan -->
		<link rel="stylesheet" type="text/css" href="style.css">
		<script type="text/javascript" src="js/bootstrap.js"></script>
    <script data-require="jquery@*" data-semver="2.2.0" src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <link data-require="bootstrap@3.3.6" data-semver="3.3.6" rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
		<script data-require="bootstrap@3.3.6" data-semver="3.3.6" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
		<link href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.css" rel="stylesheet"/>
		<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.js"></script>
		<script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.js"></script>
		
		<style>
			/* Icon when the collapsible content is shown */
			.btn:after {
				font-family: "Glyphicons Halflings";
				content: "\e114";
				float: right;
				margin-left: 15px;
			}
			/* Icon when the collapsible content is hidden */
			.btn.collapsed:after {
				content: "\e080";
			}
		</style>

		<!-- Javascript untuk modal form -->
		<script src="script.js"></script>

		<!-- API Google Maps -->
		<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&key=AIzaSyAxgh83y8vSI1-91nTOTDiUfQUmWmpcfRU&libraries=geometry&callback=fnToRunWhenAPILoaded"></script>
		
		<!-- API terraformer untuk generate geom ke lat-lng-->
		<script src="https://underscorejs.org/underscore.js"></script>
		<script src="https://unpkg.com/terraformer@1.0.8"></script>
		<script src="https://unpkg.com/terraformer-arcgis-parser@1.0.5"></script>
		<script src="https://unpkg.com/terraformer-wkt-parser@1.1.2"></script>
	</head>

	<body onload="up206b.initialize()">
		<div class="wrap" style="1000px">
			<nav class="navbar-dark navbar-expand" role="navigation" style="background-color: #5cb85c">
				<div class="container-fluid">
					<div class="navbar-header">
						<a class="navbar-brand" href="index.php"><b>Peta Zona Nilai Tanah Kota Solok</b></a>
					</div>
					<ul class="navbar-nav navbar-right ml-auto ml-md-0">
					<?php if (isset($_SESSION['usr_name'])) { ?>
						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Selamat Datang <b><?php echo $_SESSION['usr_name']; ?></b>!
								<i class="fas fa-user-circle fa-fw"></i>
							</a>
							<div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
								<a class="dropdown-item" href="logout.php">Logout</a>
							</div>
						</li>
					<?php } else { header('Location:main.php'); } ?>
					</ul>
				</div>
			</nav>
			
			<div class="body-content">
				<ul class="sidebar navbar-nav" style="width:100%; height: 100%; overflow:auto;">
					<div class="container" style="width:100%; height: 100%; overflow:auto; float:left; padding-right:10px;">
						<button type="button" class="btn" data-toggle="collapse" data-target="#znt_desa">Zona Tanah tiap Kelurahan</button>
						<div id="znt_desa" class="collapse">
							<div class="form" name="form-update" >
								<form method="post" target="blank" action="update.php">
									<div class="cari-nama">
										<div style="overflow: hidden; ">
										<br>
											<b>Kecamatan :</b>
											<select id="inputname" style="width: 70%;" required>
												<option value="" selected disabled>Pilih Kecamatan</option>
												<option value="LUBUK SIKARAH">LUBUK SIKARAH</option>
												<option value="TANJUNG HARAPAN">TANJUNG HARAPAN</option>
											</select>
										</div>
									</div>
									
									<div style="padding-top: 8px; padding-bottom: 8px">
										<div style="overflow: hidden; ">
											<b>Desa/Kelurahan :</b>
											<select id="starts" required>
												<option value="" disabled>Pilih Kecamatan terlebih dahulu</option>
											</select>
										</div>
									</div>

									<input id="form-gid" type="hidden" name="gid" value=""/>
									<input id="form-kec" type="hidden" name="kecamatan" value="" class="form-control"/>
									<input id="form-desa" type="hidden" name="nama" value="" class="form-control"/>
									<div class="form-group">
										<label for="name">NJOP (Rp)</label>
										<input id="form-njop" type="text" name="njop" value="" class="form-control input-sm"/>
									</div>
									<div class="form-group">
										<label for="name">Luas Tanah (m<sup>2</sup>)</label>
										<input id="form-tanah" type="text" name="tanah" required value="" class="form-control input-sm"/>
									</div>
									<div class="form-group">
										<label for="name">Luas Bangunan (m<sup>2</sup>)</label>
										<input id="form-bgn" type="text" name="bgn" value="" class="form-control input-sm"/>
									</div>
									<div class="form-group">
										<input type="submit" name="bphtb" class="btn btn-info btn-xs" value="Lihat BPHTB" />
										<input type="submit" name="pbb" class="btn btn-info btn-xs" value="Lihat PBB" />
										<input type="submit" name="pph" class="btn btn-info btn-xs" value="Lihat PPH" />
									</div>
								</form>
							</div>
							<div id="leftsideMenu" style="list-style-type:none">
								<li>
									<div class="input-color">
										<button class="btn-success btn-clr btn-xs" type="text" style="width:100%" value="0">Nilai sampai 100.000</button>
										<div class="color-box" style="background-color: #d4ffd2;"></div>
									</div>
								</li>
								<li>
									<div class="input-color">
										<button class="btn-success btn-clr btn-xs" type="text" style="width:100%" value="1">Nilai 100.000 - 200.000</button>
										<div class="color-box" style="background-color: #d3ffa8;"></div>
									</div>
								</li>
								<li>
									<div class="input-color">
										<button class="btn-success btn-clr btn-xs" type="text" style="width:100%" value="2">Nilai 200.000 - 500.000</button>
										<div class="color-box" style="background-color: #abfd5d;"></div>
									</div>
								</li>
								<li>
									<div class="input-color">
										<button class="btn-success btn-clr btn-xs" type="text" style="width:100%" value="3">Nilai 500.000 - 1.000.000</button>
										<div class="color-box" style="background-color: #88ac2e;"></div>
									</div>
								</li>
								<li>
									<div class="input-color">
										<button class="btn-success btn-clr btn-xs" type="text" style="width:100%" value="4">Nilai 1.000.000 - 2.000.000</button>
										<div class="color-box" style="background-color: #60a93e;"></div>
									</div>
								</li>
								<li>
									<div class="input-color">
										<button class="btn-success btn-clr btn-xs" type="text" style="width:100%" value="5">Nilai 2.000.000 - 5.000.000</button>
										<div class="color-box" style="background-color: #5b8436;"></div>
									</div>
								</li>
								<li>
									<div class="input-color">
										<button class="btn-success btn-clr btn-xs" type="text" style="width:100%" value="6">Nilai 5.000.000 - 10.000.000</button>
										<div class="color-box" style="background-color: #315c2f;"></div>
									</div>
								</li>
								<li>
									<div class="input-color">
										<button class="btn-success btn-clr btn-xs" type="text" style="width:100%" value="7">Nilai 10.000.000 - 20.000.000</button>
										<div class="color-box" style="background-color: #5b5930;"></div>
									</div>
								</li>
								<li>
									<div class="input-color">
										<button class="btn-success btn-clr btn-xs" type="text" style="width:100%" value="8">Nilai lebih dari 20.000.000</button>
										<div class="color-box" style="background-color: #5a3334;"></div>
									</div>
								</li>
							</div>
						</div>

						<br>
						<button type="button" class="btn" data-toggle="collapse" data-target="#znt_persil">Zona Tanah Persil</button>
						<div id="znt_persil" class="collapse">
							<div class="form" name="form-update" >
								<form method="post" target="blank" action="update_p.php">
									<div class="cari-nama">
										<div style="overflow: hidden; ">
										<br>
											<b>Kecamatan :</b>
											<select id="inputname2" style="width: 70%;" required>
												<option value="" selected disabled>Pilih Kecamatan</option>
												<option value="LUBUK SIKARAH" disabled>LUBUK SIKARAH</option>
												<option value="TANJUNG HARAPAN">TANJUNG HARAPAN</option>
											</select>
										</div>
									</div>
									
									<div style="padding-top: 8px; padding-bottom: 8px">
										<div style="overflow: hidden; ">
											<b>Desa/Kelurahan :</b>
											<select id="starts2" required>
												<option value="" disabled>Pilih Kecamatan terlebih dahulu</option>
											</select>
										</div>
									</div>

									<input id="form-gid2" type="hidden" name="gid" value=""/>
									<input id="form-kec2" type="hidden" name="kecamatan" value="" class="form-control"/>
									<input id="form-desa2" type="hidden" name="nama" value="" class="form-control"/>
									<input id="form-nir2" type="hidden" name="nir" value="" class="form-control"/>
									<div class="form-group">
										<label for="name">NJOP (Rp)</label>
										<input id="form-njop2" type="text" name="njop" readonly value="" class="form-control input-sm"/>
									</div>
									<div class="form-group">
										<label for="name">Luas Tanah (m<sup>2</sup>)</label>
										<input id="form-tanah2" type="text" name="tanah" required value="" class="form-control input-sm"/>
									</div>
									<div class="form-group">
										<label for="name">Luas Bangunan (m<sup>2</sup>)</label>
										<input id="form-bgn2" type="text" name="bgn" value="" class="form-control input-sm"/>
									</div>
									<div class="form-group">
										<input type="submit" name="bphtb" class="btn btn-info btn-xs" value="Lihat BPHTB" />
										<input type="submit" name="pbb" class="btn btn-info btn-xs" value="Lihat PBB" />
										<input type="submit" name="pph" class="btn btn-info btn-xs" value="Lihat PPH" />
									</div>
								</form>
							</div>
							<div id="leftsideMenu" style="list-style-type:none">
								<li>
									<div class="input-color">
										<button class="btn-success btn-clr-p btn-xs" type="text" style="width:100%" value="0">Nilai sampai 100.000</button>
										<div class="color-box" style="background-color: #d4ffd2;"></div>
									</div>
								</li>
								<li>
									<div class="input-color">
										<button class="btn-success btn-clr-p btn-xs" type="text" style="width:100%" value="1">Nilai 100.000 - 200.000</button>
										<div class="color-box" style="background-color: #d3ffa8;"></div>
									</div>
								</li>
								<li>
									<div class="input-color">
										<button class="btn-success btn-clr-p btn-xs" type="text" style="width:100%" value="2">Nilai 200.000 - 500.000</button>
										<div class="color-box" style="background-color: #abfd5d;"></div>
									</div>
								</li>
								<li>
									<div class="input-color">
										<button class="btn-success btn-clr-p btn-xs" type="text" style="width:100%" value="3">Nilai 500.000 - 1.000.000</button>
										<div class="color-box" style="background-color: #88ac2e;"></div>
									</div>
								</li>
								<li>
									<div class="input-color">
										<button class="btn-success btn-clr-p btn-xs" type="text" style="width:100%" value="4">Nilai 1.000.000 - 2.000.000</button>
										<div class="color-box" style="background-color: #60a93e;"></div>
									</div>
								</li>
								<li>
									<div class="input-color">
										<button class="btn-success btn-clr-p btn-xs" type="text" style="width:100%" value="5">Nilai 2.000.000 - 5.000.000</button>
										<div class="color-box" style="background-color: #5b8436;"></div>
									</div>
								</li>
								<li>
									<div class="input-color">
										<button class="btn-success btn-clr-p btn-xs" type="text" style="width:100%" value="6">Nilai 5.000.000 - 10.000.000</button>
										<div class="color-box" style="background-color: #315c2f;"></div>
									</div>
								</li>
								<li>
									<div class="input-color">
										<button class="btn-success btn-clr-p btn-xs" type="text" style="width:100%" value="7">Nilai 10.000.000 - 20.000.000</button>
										<div class="color-box" style="background-color: #5b5930;"></div>
									</div>
								</li>
								<li>
									<div class="input-color">
										<button class="btn-success btn-clr-p btn-xs" type="text" style="width:100%" value="8">Nilai lebih dari 20.000.000</button>
										<div class="color-box" style="background-color: #5a3334;"></div>
									</div>
								</li>
							</div>
						</div>
					</div>
				</ul>

			<div id="map" style="width: 75%;">
				Map here
			</div>

			<script>
				
				$('.btn-clr').click(function(){
					getArea($(this).attr('value'));
				});

				$('.btn-clr-p').click(function(){
					getAreaP($(this).attr('value'));
				});

				$('.select2').select2({
					templateResult: function (data) {    
						// We only really care if there is an element to pull classes from
						if (!data.element) {
							return data.text;
						}

						var $element = $(data.element);

						var $wrapper = $('<span></span>');
						$wrapper.addClass($element[0].className);

						$wrapper.text(data.text);

						return $wrapper;
					}
				});
				
				var fillIdx = 0;
				var fills = [
				'#d4ffd2',
				'#d3ffa8',
				'#abfd5d',
				'#88ac2e',
				'#60a93e',
				'#5b8436',
				'#315c2f',
				'#5b5930',
				'#5a3334',
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

				// 	console.log(JSON.stringify(geojson, undefined, 2));
					var bounds = new google.maps.LatLngBounds();
					
					var paths = _.map(multipolygon, function(entry) {
						return _.reduce(entry, function(list, polygon) {
						// This map() only transforms the data.
							_.each(_.map(polygon, function(point) {
							// Important: the lat/lng are vice-versa in GeoJSON
							
							return new google.maps.LatLng(point[1], point[0]);
						}), function(point) {
							list.push(point);
						});

						return list;
						}, []);
					});

					// console.log(njop);

					if(njop<=100000){
						fillIdx = 0;
					}
					else if(njop>100000 && njop<=200000){
						fillIdx = 1;
					}
					else if(njop>200000 && njop<=500000){
						fillIdx = 2;
					}
					else if(njop>500000 && njop<=1000000){
						fillIdx = 3;
					}
					else if(njop>1000000 && njop<=2000000){
						fillIdx = 4;
					}
					else if(njop>2000000 && njop<=5000000){
						fillIdx = 5;
					}
					else if(njop>5000000 && njop<=10000000){
						fillIdx = 6;
					}
					else if(njop>10000000 && njop<=20000000){
						fillIdx = 7;
					}
					else if(njop>=20000000){
						fillIdx = 8;
					}

					
					var polygon = new google.maps.Polygon({
						paths: paths,
						strokeWeight: 1,
						fillColor: fills[fillIdx],
						fillOpacity: 0.90
					});

					var bounds = new google.maps.LatLngBounds();
					for (var i=0; i< paths[0].length; i++) {
						bounds.extend(paths[0][i]);
					}

					var myLatlng = bounds.getCenter();
					createInfoWindow(polygon, nama, q, njop, gid, myLatlng);
					return polygon;
				};

				var transform_p = function(multipolygon, map, nama, q, njop, gid, nir, tanah, bgn) {

				// 	console.log(JSON.stringify(geojson, undefined, 2));
					var bounds = new google.maps.LatLngBounds();
					
					var paths = _.map(multipolygon, function(entry) {
						return _.reduce(entry, function(list, polygon) {
						// This map() only transforms the data.
							_.each(_.map(polygon, function(point) {
							// Important: the lat/lng are vice-versa in GeoJSON
							
							return new google.maps.LatLng(point[1], point[0]);
						}), function(point) {
							list.push(point);
						});

						return list;
						}, []);
					});

					// console.log(njop);

					if(njop<=100000){
						fillIdx = 0;
					}
					else if(njop>100000 && njop<=200000){
						fillIdx = 1;
					}
					else if(njop>200000 && njop<=500000){
						fillIdx = 2;
					}
					else if(njop>500000 && njop<=1000000){
						fillIdx = 3;
					}
					else if(njop>1000000 && njop<=2000000){
						fillIdx = 4;
					}
					else if(njop>2000000 && njop<=5000000){
						fillIdx = 5;
					}
					else if(njop>5000000 && njop<=10000000){
						fillIdx = 6;
					}
					else if(njop>10000000 && njop<=20000000){
						fillIdx = 7;
					}
					else if(njop>=20000000){
						fillIdx = 8;
					}

					
					var polygon = new google.maps.Polygon({
						paths: paths,
						strokeWeight: 1,
						fillColor: fills[fillIdx],
						fillOpacity: 0.90
					});

					var bounds = new google.maps.LatLngBounds();
					for (var i=0; i< paths[0].length; i++) {
						bounds.extend(paths[0][i]);
					}

					var myLatlng = bounds.getCenter();
					createInfoWindow_p(polygon, nama, q, njop, gid, myLatlng, nir, tanah, bgn);
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

				//info window wilayah
				var createInfoWindow = function(polygon, nama, q, njop, gid, myLatlng){
					infowindow = new google.maps.InfoWindow();
					google.maps.event.addListener(polygon, 'click', function(event){
						infowindow.close();
						infowindow.setContent("<b>Desa/Kelurahan</b> : "+nama+"<br><b>Kecamatan</b> : "+inputname.value+"<br><b>NJOP</b> : Rp "+njop);
						// infowindow.setPosition(myLatlng);
						infowindow.setPosition(event.latLng);
						infowindow.open(map);
						document.getElementById("form-gid").value = gid;
						document.getElementById("form-kec").value = q;
						document.getElementById("form-desa").value = nama;
						document.getElementById("form-njop").value = njop;
					});
				}

				//info window persil
				var createInfoWindow_p = function(polygon, nama, q2, njop, gid, myLatlng, nir, tanah, bgn){
					infowindow = new google.maps.InfoWindow();
					google.maps.event.addListener(polygon, 'click', function(event){
						infowindow.close();
						infowindow.setContent("<b>Desa/Kelurahan</b> : "+nama+"<br><b>Kecamatan</b> : "+inputname2.value+"<br><b>NJOP</b> : Rp "+njop+"<br><b>NIR</b> : Rp "+nir+"<br><b>Luas Tanah</b> : "+tanah+" m<sup>2</sup><br><b>Luas Bangunan</b> : "+bgn+" m<sup>2</sup>");
						// infowindow.setPosition(myLatlng);
						infowindow.setPosition(event.latLng);
						infowindow.open(map);
						document.getElementById("form-gid2").value = gid;
						document.getElementById("form-kec2").value = q2;
						document.getElementById("form-desa2").value = nama;
						document.getElementById("form-njop2").value = njop;
						document.getElementById("form-nir2").value = nir;
						document.getElementById("form-tanah2").value = tanah;
						document.getElementById("form-bgn2").value = bgn;
					});
				}

				//Function that gets run when the document loads
				up206b.initialize = function()
				{
					var myOptions = {
						center: {lat: -0.7900853, lng: 100.6488506}, zoom: 14
					};
					map = new google.maps.Map(document.getElementById("map"), myOptions);
				}

				var getArea = function(color=''){
					var markers = [];
					var infowindow = [];
					console.log(color);
					$.ajax({
							url: "common.php?q="+inputname.value+"&desa="+starts.value+"&zona="+color,
							dataType: 'json',
							method: 'GET',
							error: function(data){
								alert('Data does not exist!');
								return;
							},
							success: function(data){
								up206b.initialize();
								mydata = data;
								console.log(mydata);
								var i;
								
								if(data['list'].length==0){
									console.log('range kosong');
									alert('Data does not exist!');
								}
								else{
									for(i = 0; i < data['list'].length; i++) {
										var polygon=transform(data['list'][i]['area'], map, data['list'][i]['nama'], inputname.value, data['list'][i]['njop'], data['list'][i]['gid']);
										polygon.setMap(map);
									}
									map.fitBounds(polygon.getBounds());
								}
							}
						});
					}

				var getAreaP = function(color=''){
					var markers = [];
					var infowindow = [];
					console.log(color);
					$.ajax({
							url: "common.php?q2="+inputname2.value+"&desa2="+starts2.value+"&zona2="+color,
							dataType: 'json',
							method: 'GET',
							error: function(data){
								alert('Data does not exist!');
								return;
							},
							success: function(data){
								up206b.initialize();
								mydata = data;
								console.log(mydata);
								var i;
								
								if(data['list'].length==0){
									console.log('range kosong');
									alert('Data does not exist!');
								}
								else{
									for(i = 0; i < data['list'].length; i++) {
										var polygon=transform_p(data['list'][i]['area'], map, data['list'][i]['nama'], inputname2.value, data['list'][i]['njop'], data['list'][i]['gid'], data['list'][i]['nir'], data['list'][i]['tanah'], data['list'][i]['bgn']);
										polygon.setMap(map);
									}
									map.fitBounds(polygon.getBounds());
								}
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
									document.getElementById("starts").innerHTML = "";
									document.getElementById("starts").value = "";
									var i;
									for(i = 0; i < data['list'].length; i++) {
										var polygon=transform(data['list'][i]['area'], map, data['list'][i]['nama'], inputname.value, data['list'][i]['njop'], data['list'][i]['gid']);
										polygon.setMap(map);
									}

									document.getElementById("starts").innerHTML += "<option value='' selected disabled>-- PILIH DESA --</option>";
									for (i=0; i<data['nama'].length; i++) {
										nama=data['nama'][i].nama;
										document.getElementById("starts").innerHTML += "<option value='"+nama+"'>"+nama+"</option>";
									}
									map.fitBounds(polygon.getBounds());
								}
							});
						}
					}

					//load persil
					function findnameP(){
						for (var i = 0; i < resultmarker.length; i++){
							resultmarker[i].setMap(null);
						}
						resultmarker = [];

						if(inputname2.value==''){
							alert("The column should not be blank!");
						}
						else{
							document.getElementById("starts2").innerHTML = "";
							document.getElementById("starts2").value = "";
							$.ajax({
								url: "common.php?q2="+inputname2.value,
								dataType: 'json',
								method: 'GET',
								error: function(data){
									alert('Data does not exist!');
									return;
								},
								success: function(data){
									up206b.initialize();
									document.getElementById("starts2").innerHTML = "";
									document.getElementById("starts2").value = "";
									var i;
									for(i = 0; i < data['list'].length; i++) {
										var polygon=transform_p(data['list'][i]['area'], map, data['list'][i]['nama'], inputname2.value, data['list'][i]['njop'], data['list'][i]['gid'], data['list'][i]['nir'], data['list'][i]['tanah'], data['list'][i]['bgn']);
										polygon.setMap(map);
									}

									document.getElementById("starts2").innerHTML += "<option value='' selected disabled>-- PILIH DESA --</option>";
									for (i=0; i<data['nama'].length; i++) {
										nama=data['nama'][i].nama;
										document.getElementById("starts2").innerHTML += "<option value='"+nama+"'>"+nama+"</option>";
									}
									map.fitBounds(polygon.getBounds());
								}
							});
						}
					}

					document.getElementById("inputname").addEventListener("change", findname);
					$("#starts").change(function(){
						getArea('');
					});

					//fungsi persil
					document.getElementById("inputname2").addEventListener("change", findnameP);
					$("#starts2").change(function(){
						getAreaP('');
					});
				}
				google.maps.event.addDomListener(window, 'load', initialize);
			</script>
		</div>
	</body>
</html>