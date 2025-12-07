<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap');

.navbar-soft {
  font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
  background: rgba(255, 255, 255, 0.95);
  backdrop-filter: blur(10px);
  border-bottom: 1px solid rgba(233, 215, 199, 0.4);
  box-shadow: 0 2px 12px rgba(220, 200, 180, 0.12);
  padding-top: 8px;
  padding-bottom: 8px;
}

.navbar-brand {
  font-weight: 600;
  color: #7a5e4b !important;
  font-size: 18px;
  letter-spacing: -0.2px;
}

.navbar-hamburger {
  font-size: 24px;
  color: #7a5e4b;
  line-height: 1;
}

.nav-link {
  color: #7a5e4b !important;
  font-weight: 500;
  font-size: 15px;
  transition: color 0.2s;
}

.nav-link:hover {
  color: #d9bfa5 !important;
}

/* Dropdown */
.dropdown-menu {
  border: none;
  border-radius: 14px;
  box-shadow: 0 6px 20px rgba(220, 200, 180, 0.2);
  padding: 8px 0;
  font-size: 14px;
}

.dropdown-item {
  color: #7a5e4b;
  padding: 10px 16px;
  transition: background 0.2s;
}

.dropdown-item:hover {
  background: #fdf8f4;
}

.dropdown-item.text-danger:hover {
  background: #fff0ed;
}

.dropdown-divider {
  margin: 6px 0;
  border-color: #e9d7c7;
}

/* Offcanvas */
.offcanvas-soft {
  background: #fdf9f5;
  width: 280px;
}

.offcanvas-header {
  padding: 20px 24px;
  border-bottom: 1px solid #e9d7c7;
}

.offcanvas-title {
  color: #7a5e4b;
  font-size: 20px;
}

.btn-close-soft {
  width: 24px;
  height: 24px;
  background: none;
  opacity: 1;
  filter: invert(50%) sepia(20%) saturate(200%) hue-rotate(340deg);
  transition: filter 0.2s;
}

.btn-close-soft:hover {
  filter: invert(30%) sepia(30%) saturate(300%) hue-rotate(340deg);
}

/* Offcanvas List */
.list-group-item-action {
  color: #7a5e4b;
  font-weight: 500;
  border: none;
  border-radius: 12px;
  margin-bottom: 8px;
  transition: all 0.2s ease;
}

.list-group-item-action:hover {
  background: #f8f4f0;
  transform: translateX(4px);
}

.list-group-item-action i {
  color: #d9bfa5;
  font-size: 16px;
}

/* Responsif */
@media (max-width: 992px) {
  .navbar-brand {
    font-size: 17px;
  }
}
</style>

<nav class="navbar navbar-expand-lg navbar-soft fixed-top">
  <div class="container-fluid px-3">
    <?php if (session('levelid')==1 || session('levelid')==2) { ?>
      <a href="#" class="navbar-brand me-2" data-bs-toggle="offcanvas" data-bs-target="#demo" role="button">
        <span class="navbar-hamburger">☰</span>
      </a>
    <?php } ?>
   <a href="/home" class="navbar-brand">
  <img src="/logo.png" 
     height="40" 
     alt="Chick Chi"
     class="me-2"
     onerror="this.onerror=null; this.src='logo-default.png';">
  Chick Chi
</a>
    <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
      <span class="navbar-toggler-icon"></span>
      
    </button>

    <div class="collapse navbar-collapse" id="navbarCollapse">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0"></ul>
      <ul class="navbar-nav d-flex align-items-center">
        <?php if (session('userid')<1) { ?>
          <li class="nav-item me-3">
            <a class="nav-link" href="/login">Login</a>
          </li>
        <?php } ?>

        <?php if (session('levelid')==2) { ?>
          <li class="nav-item me-3">
            <a href="/cart" class="nav-link p-0">
              <img src="cart.png" height="30" class="align-middle" id="Cart">
            </a>
          </li>
        <?php } ?>

        <?php if (session('userid')>0) { ?>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle fw-medium" href="#" role="button" data-bs-toggle="dropdown">
              <i class="bi bi-person-circle me-1"></i>
              Hi, <?= session('username'); ?>
            </a>
            <ul class="dropdown-menu dropdown-menu-end shadow">
              <li><a class="dropdown-item" href="/profile"><i class="bi bi-person"></i> Profile</a></li>
<!--               <li><a class="dropdown-item" href="#"><i class="bi bi-gear me-2"></i> Settings</a></li> -->
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item text-danger" href="/logout"><i class="bi bi-box-arrow-right me-2"></i> Logout</a></li>
            </ul>
          </li>
        <?php } ?>
      </ul>
    </div>
  </div>
</nav>

<!-- Offcanvas -->
<div class="offcanvas offcanvas-start offcanvas-soft" tabindex="-1" id="demo">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title fw-bold">Menu</h5>
  </div>
  <div class="offcanvas-body">
    <div class="list-group list-group-flush">
      <?php if (session('roleid')==1 || session('levelid')==2) { ?>
        <a href="/menu" class="list-group-item list-group-item-action py-3">
          <i class="bi bi-book me-2"></i> Menu
        </a>
        <a href="/promotions" class="list-group-item list-group-item-action py-3">
          <i class="bi bi-megaphone me-2"></i> Promotion
        </a>
      <?php } ?>

      <?php if (session('roleid')==2) { ?>
        <a href="/courier/orders" class="list-group-item list-group-item-action py-3">
          <i class="bi bi-signpost me-2"></i> Order
        </a>
      <?php } ?>

      <?php if (session('roleid')==1) { ?>
        <a href="/userdata" class="list-group-item list-group-item-action py-3">
          <i class="bi bi-people me-2"></i> User Data
        </a>
      <?php } ?>

      <?php if (session('levelid')==2) { ?>
      <a href="/historytransaction" class="list-group-item list-group-item-action py-3">
        <i class="bi bi-clock-history me-2"></i> History
      </a>
      <?php } ?>

      <?php if (session('roleid')==4) { ?>
        <a href="/report" class="list-group-item list-group-item-action py-3">
          <i class="bi bi-file-earmark-bar-graph me-2"></i> Monthly Report
        </a>
        <a href="/daily" class="list-group-item list-group-item-action py-3">
          <i class="bi bi-file-earmark-bar-graph me-2"></i> Daily Report
        </a>
      <?php } ?>
    </div>
  </div>
</div>

<br><br><br>