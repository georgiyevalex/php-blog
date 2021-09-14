<header class="pt-3 pb-3">
  <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
    <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
      {include file="../menu/index.tpl"}
    </ul>

    <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3">
      <input type="search" class="form-control form-control-dark" placeholder="Search..." aria-label="Search">
    </form>
    {if !$user}
      <div class="text-end">
        <a href="/{Blog\Destination::DESTINATION_LOGIN}" class="btn btn-dark me-2">Login</a>
        <a href="/{Blog\Destination::DESTINATION_REGISTRATION}" class="btn btn-warning">Sign-up</a>
      </div>
    {else}
      <div class="text-end">
        <a href="/{Blog\Destination::DESTINATION_PROFILE}" class="btn btn-primary position-relative">
          Profile
          <span class="position-absolute top-0 start-100 translate-middle p-2 bg-danger border border-light rounded-circle">
            <span class="visually-hidden">New alerts</span>
          </span>
        </a>
        <a href="/{Blog\Destination::DESTINATION_LOGOUT}" class="btn btn-dark me-2">Logout</a>
      </div>
    {/if}
  </div>
</header>