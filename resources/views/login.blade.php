
  <title>Login — Chick Chi</title>

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

        <button type="submit" class="btn-login">Sign In</button>
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