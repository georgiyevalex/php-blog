<link rel="stylesheet" href="/static/css/profile.css">
<div class="container emp-profile">
  <form method="post">
    <div class="row">
      <div class="col-md-4">
        <div class="profile-img">
          <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS52y5aInsxSm31CvHOFHWujqUx_wWTS9iM6s7BAm21oEN_RiGoog" alt=""/>
          <div class="file btn btn-lg btn-primary">
            Change Photo
            <input type="file" name="file"/>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="profile-head">
          <h5>
            {$user.first_name|capitalize} {$user.last_name|capitalize}
          </h5>
          <h6>
              {$user.role|capitalize}
          </h6>
          <p class="profile-rating">RANKINGS : <span>8/10</span></p>
          <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
              <button  class="nav-link active" id="home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">About</button >
            </li>
            <li class="nav-item" role="presentation">
              <button  class="nav-link" id="posts-tab" data-bs-toggle="pill" data-bs-target="#pills-posts" type="button" role="tab" aria-controls="pills-posts" aria-selected="false">Posts</button >
            </li>
          </ul>
        </div>
      </div>
      <div class="col-md-2">
        <input type="submit" class="profile-edit-btn" name="btnAddMore" value="Edit Profile"/>
      </div>
    </div>
    <div class="row">
      <div class="col-md-4">
        <div class="profile-work">
          <p>WORK LINK</p>
          <a href="">Website Link</a><br/>
          <a href="">Bootsnipp Profile</a><br/>
          <a href="">Bootply Profile</a>
          <p>SKILLS</p>
          <a href="">Web Designer</a><br/>
          <a href="">Web Developer</a><br/>
          <a href="">WordPress</a><br/>
          <a href="">WooCommerce</a><br/>
          <a href="">PHP, .Net</a><br/>
        </div>
      </div>
      <div class="col-md-8">
        <div class="tab-content profile-tab" id="myTabContent">
          <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home">
            <div class="row">
              <div class="col-md-6">
                <label>First name</label>
              </div>
              <div class="col-md-6">
                <p> {$user.first_name|capitalize}</p>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <label>Last name</label>
              </div>
              <div class="col-md-6">
                <p> {$user.last_name|capitalize}</p>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <label>Email</label>
              </div>
              <div class="col-md-6">
                <p>{$user.email}</p>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <label>Phone</label>
              </div>
              <div class="col-md-6">
                {if $user.phone}
                  <p>{$user.phone}</p>
                {else}
                  <p>not filled</p>
                {/if}
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <label>Profession</label>
              </div>
              <div class="col-md-6">
                  {if $user.profession}
                    <p>{$user.profession}</p>
                  {else}
                    <p>not filled</p>
                  {/if}
              </div>
            </div>
          </div>
          <div class="tab-pane fade" id="pills-posts" role="tabpanel" aria-labelledby="pills-posts">
            <div class="row">
              <div class="col-md-6">
                <label>Experience</label>
              </div>
              <div class="col-md-6">
                <p>Expert</p>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <label>Hourly Rate</label>
              </div>
              <div class="col-md-6">
                <p>10$/hr</p>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <label>Total Projects</label>
              </div>
              <div class="col-md-6">
                <p>230</p>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <label>English Level</label>
              </div>
              <div class="col-md-6">
                <p>Expert</p>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <label>Availability</label>
              </div>
              <div class="col-md-6">
                <p>6 months</p>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <label>Your Bio</label><br/>
                <p>Your detail description</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </form>
</div>