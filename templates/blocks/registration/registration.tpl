{if $message}
    <div class="alert alert-danger" role="alert">
        {$message}
    </div>
{/if}
<form action="/{Blog\Destination::DESTINATION_REGISTER}" class="col g-3 needs-validation" method="post" name="form">
  <div class="col-md-6 mt-2">
    <label for="validationCustom01" class="form-label">First name</label>
    <input type="text" class="form-control" placeholder="Mark" name="first_name" value="{$form.first_name}">
  </div>
  <div class="col-md-6 mt-3">
    <label for="validationCustom02" class="form-label">Last name</label>
    <input type="text" class="form-control" id="validationCustom02" placeholder="Otto" name="last_name" value="{$form.last_name}">
  </div>
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
  <div class="col-md-6 mt-3">
    <label for="validationPassword2" class="form-label">Confirm password</label>
    <input type="password" class="form-control" id="validationPassword2" placeholder="******" name="confirm_password">
  </div>
  <div class="col-12 mt-3">
    <div class="form-check">
      <input class="form-check-input" type="checkbox" value="" id="invalidCheck">
      <label class="form-check-label" for="invalidCheck">
        Agree to terms and conditions
      </label>
    </div>
  </div>
  <div class="col-12 mt-5">
    <input class="btn btn-primary" type="submit" value="Submit form">
  </div>
</form>