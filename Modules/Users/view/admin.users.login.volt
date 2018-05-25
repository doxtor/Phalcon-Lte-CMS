<div class="container">
	<form class="form-horizontal" role="form" method="POST" action="/{{ config.admin.url }}/users/users/login">
		<div class="row">
			<div class="col-md-3"></div>
			<div class="col-md-6">
				<h2>Please Login</h2>
				<hr>
			</div>
		</div>
		<div class="row">
			<div class="col-md-3"></div>
			<div class="col-md-6">
				<div class="form-group has-danger">
					<label class="sr-only" for="email">E-Mail Address</label>
					<div class="input-group mb-2 mr-sm-2 mb-sm-0">
						<div class="input-group-addon" style="width: 2.6rem"><i class="fa fa-at"></i></div>
						<input type="text" name="login" class="form-control" id="login" placeholder="Login" required autofocus>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-3"></div>
			<div class="col-md-6">
				<div class="form-group">
					<label class="sr-only" for="password">Password</label>
					<div class="input-group mb-2 mr-sm-2 mb-sm-0">
						<div class="input-group-addon" style="width: 2.6rem"><i class="fa fa-key"></i></div>
						<input type="password" name="password" class="form-control" id="password" placeholder="Password" required>
					</div>
				</div>
			</div>
		<div class="row" style="padding-top: 1rem">
			<div class="col-md-3"></div>
			<div class="col-md-6">
				<button type="submit" class="btn btn-success"><i class="fa fa-sign-in"></i> Login</button>
			</div>
		</div>
	</form>
</div>
