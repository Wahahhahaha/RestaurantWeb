
  <title>Edit Profile</title>

<div class="body1">
<div class="main-container1">
  <form action="/updateuser/<?= $data->userid ?>" method="post">
    @csrf

    <div class="edit-profile-card">
      <div class="edit-profile-header">
        <h1>Edit Profile</h1>
        <p>Update your account details</p>
      </div>

      <div class="edit-profile-body">
        <!-- Tombol Back -->
        <a href="/profile" class="btn-back1">
          <i class="bi bi-arrow-left"></i> Back to Profile
        </a>

        <!-- Username -->
        <div class="form-group">
          <label for="name" class="form-label">Username</label>
          <input type="text"
            class="form-input"
            name="name"
            id="name"
            placeholder="Enter new username"
value="<?= htmlspecialchars($data->username) ?>"
            required>
        </div>

        <!-- Email -->
        <div class="form-group">
          <label for="email" class="form-label">Email</label>
          <input type="email"
            class="form-input"
            name="email"
            id="email"
            placeholder="Enter new email"
            value="<?= htmlspecialchars($data->email) ?>" 
            >
        </div>

        <!-- Phone Number -->
        <div class="form-group">
          <label for="phonenumber" class="form-label">Phone Number</label>
          <input type="text"
            class="form-input"
            name="phonenumber"
            id="phonenumber"
            placeholder="Enter new phone number"
            value="<?= htmlspecialchars($data->phonenumber) ?>"
            required>
        </div>

        <div class="form-group">
          <label for="password" class="form-label">Password</label>
          <input type="text"
            class="form-input"
            name="password"
            id="password"
            placeholder="Enter new password"
            >
        </div>

        <!-- Tombol Save -->
        <div class="d-grid mt-4">
          <button type="submit" class="btn-save">
            Save Changes
          </button>
        </div>
      </div>
    </div>
  </form>
</div>
</div>