  <title>Profile</title>

<div class="body1">
<div class="main-container1">
  <div class="profile-card">
    <div class="profile-header">
      <h1>User Profile</h1>
      <p>Your account information</p>
    </div>

          <div class="edit-profile-body">
        <!-- Tombol Back -->
        <a href="/home" class="btn-back1">
          <i class="bi bi-arrow-left"></i> Back to home
        </a>

    <div class="profile-body">
      <!-- Username -->
      <div class="profile-item">
        <label class="profile-label">Username</label>
        <div class="profile-value">
          <?= htmlspecialchars($data->username) ?>
        </div>
      </div>

      <!-- Email -->
      <div class="profile-item">
        <label class="profile-label">Email</label>
        <div class="profile-value">
          <?= htmlspecialchars($data->email) ?>
        </div>
      </div>

      <!-- Phone -->
      <div class="profile-item">
        <label class="profile-label">Phone Number</label>
        <div class="profile-value">
          <?= htmlspecialchars($data->phonenumber) ?>
        </div>
      </div>

      <!-- Tombol Edit -->
      <div class="d-grid mt-4">
        <a href="/editusers/<?= $data->userid ?>" class="btn-edit-profile">
          <i class="bi bi-pencil-square"></i> Edit Profile
        </a>
      </div>
    </div>
  </div>
</div>
</div>