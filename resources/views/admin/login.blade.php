<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Login Admin</title>
	<link rel="icon" type="image/png" href="{{ asset('img/logo.png') }}">
  	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  	<link href="{{ asset('font-awesome/css/all.css') }} " rel="stylesheet">
	<link href="{{ asset('material/assets/css/material-dashboard.css?v=2.1.0') }} " rel="stylesheet" />
</head>
<body>
	<div class="container" style="padding-top: 8rem;">
		<div class="card col-6 offset-3" style="border: 2px solid grey;">
			<div class="card-body">
				<div class="row">
					<div class="col-6" style="padding: 2rem; border-right: 1px solid #ededed;">
						<img src="{{ asset('img/logo.png') }}" alt="logo-dlijo" width="100%">
					</div>
					<div class="col-6">
						<h3 style="border-bottom: 1px dashed black; padding: 0.5rem 0;">Login Admin</h3>
						<form action="{{ route('dologin.admin') }}" method="post">
						{{csrf_field()}}
							<div class="form-group">
								<label for="password">Password : </label>
								<input type="password" name="password" class="form-control" placeholder="********" required="">
							</div>
							<div class="text-right">
								<br>
								<input type="submit" name="login" value="login" class="btn btn-rose btn-sm text-right">
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<div class="col-6 offset-3">
			@if ($message = Session::get('error'))
		        <div class="alert alert-warning alert-block">
		        	<a href="" class="close" data-dismiss="alert" aria-label="close">&times;</a>  
		                <strong>{{ $message }}</strong>
		        </div>
		    @endif
		</div>
	</div>
</body>
</html>