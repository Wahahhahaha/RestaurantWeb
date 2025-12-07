
<div class="body2">
  <div class="login-wrapper">
    <div class="login-card">

      <img src="logo.png" alt="Chick Chi" class="logo" onerror="this.style.display='none'">

      <h1 class="login-title">Welcome Back</h1>

      <form action="/logindata" method="post">
        @csrf

        <div class="input-group">
          <label for="username">Username</label>
          <input type="text" id="username" name="u" class="input-field" required>
        </div>

        <div class="input-group">
          <label for="password">Password</label>
          <input type="password" id="password" name="p" class="input-field" required>
        </div>

        <button  class="btn-login" type="submit" onclick="LoginError">Log In</button>
      </form>

      <div class="divider1">
        <span>or continue with</span>
      </div>

      <p class="signup-link">
        Don’t have an account? 
        <a href="/register">Register</a>
      </p>
    </div>
  </div>
</div>


<div class="modal fade" id="login" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content custom-modal-content">
      <div class="modal-body custom-modal-body">
        {{ session('error') }}
      </div>
      <button class="btn custom-btn-close" data-bs-dismiss="modal">Ok</button>
    </div>
  </div>
</div>

@if(session('error'))
<script>
    LoginError();
</script>
@endif

<script>
  reload();
</script>

@stack('scripts')