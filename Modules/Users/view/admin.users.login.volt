<div class="container">
<div class="card card-login mx-auto mt-5">
  <div class="card-header">{{ get_title('') }}</div>
  <div class="card-body">
    <form method="POST" action="/{{ config.admin.url }}/users/users/login">
      <div class="form-group">
        <label for="InputLogin">Login</label>
        <input class="form-control" name="login" id="InputLogin" type="text" placeholder="Login">
      </div>
      <div class="form-group">
        <label for="InputPassword">Password</label>
        <input class="form-control" name="password" id="InputPassword" type="password" placeholder="Password">
      </div>
	  <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-sign-in"></i> Login</button>
    </form>
  </div>
</div>
</div>
