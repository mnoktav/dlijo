<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Welcome</title>
	<link rel="icon" type="image/png" href="{{ asset('img/logo.png') }}">
  	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
	<link href="{{ asset('material/assets/css/material-dashboard.css?v=2.1.0') }} " rel="stylesheet" />
	<link href="https://fonts.googleapis.com/css?family=Material+Icons|Amatic+SC" rel="stylesheet">
</head>
<body>
	<nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top">
	  <a class="navbar-brand ml-4" href=""><img src="{{ asset('img/logo.png') }}" alt="" width="40" height="40"></a>
	  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
	    <span class="navbar-toggler-icon"></span>
	  </button>

	  <div class="collapse navbar-collapse" id="navbarSupportedContent">
	    <ul class="navbar-nav mr-auto">
	      
	    </ul>
	    <button class="btn btn-warning my-2 my-sm-0 mr-3" type="submit">Logout</button>
	  </div>
	</nav>
	<div class="container text-center" style="padding: 2% 5%;">
		<div class="row">
			<div class="col">
				<img src="{{ asset('img/logo.png') }}" alt="" height="90%" width="80%">
			</div>
			<div class="col">
				<p style="font-size: 70px; text-align: right;line-height: normal; text-transform: capitalize; font-family: 'Amatic SC', cursive;"><b>"Harga pas dikantong, kualitas supermarket dong!"</b></p>
			</div>
		</div>
		<div class="row" style="margin-top: 2%;">
			<div class="col-3">
				<div id="menus">
					<i class="material-icons" style="font-size: 110px; margin-top: 10px;">store</i><br>
					<a href="{{ route('dashboard.kasir') }}" class="btn btn-warning" target="_blank">kasir</a>
				</div>
			</div>
			<div class="col-3">
				<div id="menus">
					<i class="material-icons" style="font-size: 110px; margin-top: 10px;">domain</i><br>
					<a href="{{ route('dashboard.admin') }}" class="btn btn-info" target="_blank">admin</a>
				</div>
			</div>
		</div>
	</div>
	<style>
		#menus{
			padding:3%; background-color: white; border-radius: 5px; border:2px solid #bcbcbc;
		}
	</style>
</body>
</html>