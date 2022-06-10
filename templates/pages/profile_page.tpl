<link rel="stylesheet" href="/static/css/profile.css">
<div class="container emp-profile">
    <div class="row">
      <div class="col-md-4">
        <div class="profile-image">
          <img src="https://dummyimage.com/300x200/c0bfd6/2e2f3d&text=Dummy+image" alt="profile-image">
        </div>
      </div>
      <div class="col-md-8">
        <div class="profile-head">
          <h5>
            {$user.first_name|capitalize|escape} {$user.last_name|capitalize|escape}
          </h5>
          <h6>
              {$user.role|capitalize|escape}
          </h6>
        </div>
      </div>
    </div>
</div>
