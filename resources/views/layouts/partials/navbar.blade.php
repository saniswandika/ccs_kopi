<header class="p-3 bg-dark text-white">
  <div class="container">
    <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
      <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
        <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap"><use xlink:href="#bootstrap"/></svg>
      </a>

      <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
        <li><a href="{{ route('home.index') }}" class="nav-link px-2 text-white">Home</a></li>
        @auth
            @php
              $Userid = Auth::user()->id;
              $usersWithRole = DB::table('users')
                  ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                  ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
                  ->where('model_has_roles.model_id', $Userid)
                  ->select('roles.*')
                  ->first();
            @endphp
            @if (
               $usersWithRole->name == 'admin' || $usersWithRole->name == 'Superadmin' )
                <li><a href="{{ route('users.index') }}" class="nav-link px-2 text-white">Users</a></li>
                <li><a href="{{ route('roles.index') }}" class="nav-link px-2 text-white">Roles</a></li>
            @endif
            <li><a href="{{ route('posts.index') }}" class="nav-link px-2 text-white">Posts</a></li>
        @endauth
      </ul>
      <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3">
        <input type="search" class="form-control form-control-dark" placeholder="Search..." aria-label="Search">
      </form>

      @auth
        <div class="d-flex align-items-center">
          <span class="me-2">{{ auth()->user()->name }}</span>
          <div class="text-end">
            <a href="{{ route('logout.perform') }}" class="btn btn-outline-light me-2">Logout</a>
          </div>
        </div>
      @endauth

      @guest
        <div class="text-end">
          <a href="{{ route('login.perform') }}" class="btn btn-outline-light me-2">Login</a>
          <a href="{{ route('register.perform') }}" class="btn btn-warning">Sign-up</a>
        </div>
      @endguest
    </div>
  </div>
</header>
