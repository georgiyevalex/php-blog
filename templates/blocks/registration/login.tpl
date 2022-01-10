{if $message}
  <div class="alert alert-danger" role="alert">
      {$message}
  </div>
{/if}
<form action="/{Blog\CreateDestination::DESTINATION_LOGIN_PAGE}" class="col g-3 needs-validation" method="post" name="login-form">
  <div class="col-md-6 mt-3">
    <label for="validationCustomEmail" class="form-label">Email</label>
    <div class="input-group has-validation">
      <input type="email" class="form-control" id="validationCustomEmail" aria-describedby="inputGroupPrepend" name="email" value="{$form.email}">
    </div>
  </div>
  <div class="col-md-6 mt-3">
    <label for="validationPassword" class="form-label">Password</label>
    <input type="password" class="form-control" id="validationPassword" placeholder="******" name="password">
  </div>
  <div class="col-12 mt-5">
    <input class="btn btn-primary" type="submit" value="Log in">
  </div>
</form>