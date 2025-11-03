<title>Register</title>

<div class="auth-wrapper">
  <div class="register-card-container">
    <div class="register-card">
      
      <div class="text-center mb-4">
        <div class="mb-2">
          <span class="fs-2"><img src="logo.png" height="75" alt="Chick Chi"></span>
        </div>
        <h4 class="fw-bold">Register</h4>
      </div>

      <form action="/registerdata" method="post" class="was-validated">
        @csrf

        <div class="mb-3">
          <input type="text" class="form-control form-control-lg" name="u" placeholder="Username" required>
        </div>

        <div class="mb-3">
          <input type="email" class="form-control form-control-lg" name="e" placeholder="Email" required>
        </div>

        <div class="mb-3">
          <input type="password" class="form-control form-control-lg" name="p" placeholder="Password" required>
        </div>

        <div class="mb-4">
          <input type="text" class="form-control form-control-lg" name="t" placeholder="Phone number" required>
        </div>

        <div class="d-grid">
          <button type="submit" class="btn btn-dark btn-lg fw-medium rounded-2 py-2">
            Register
          </button>
        </div>
      </form>

      <div class="text-center mt-4 pt-3 border-top">
        <p class="mb-0">
          Have an account? 
          <a href="/login" class="fw-medium">
            Login
          </a>
        </p>
      </div>
    </div>
  </div>
</div>
