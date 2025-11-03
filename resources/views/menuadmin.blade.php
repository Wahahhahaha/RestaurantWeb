<nav class="navbar navbar-expand-sm navbar-light bg-light fixed-top">
    <div class="container-fluid">
        <a href="" class="navbar-brand" data-bs-toggle="offcanvas" data-bs-target="#demo" role= "button">
            <img src="menu.png" height="30" >
        </a>
        <a href="/homeadmin" class="navbar-brand">
            <img src="logo.png" height="50" alt="Chick Chi" >
        </a>
        <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav">
                <a href="#" class="nav-item nav-link active">Chick Chi</a>
                <a href="#" class="nav-item nav-link">Data</a>
                <a href="#" class="nav-item nav-link">Carts</a>
                <a href="/usertransaction" class="nav-item nav-link" tabindex="-1">Transaction</a>
            </div>
            <div class="navbar-nav ms-auto">
                <a href="/cart" class="navbar-brand">
            <img src="cart.png" height="40" alt="Chick Chi" >
        </a>
               <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Profile</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="/profile">User data</a></li>
            <li><a class="dropdown-item" href="#">Setting</a></li>
            <li><a class="dropdown-item" href="/logout">Log Out</a></li>
          </ul>
        </li>
            </div>
        </div>
    </div>
</nav>


<div class="offcanvas offcanvas-start" id="demo">
  <div class="offcanvas-header">
    <h3 class="offcanvas-title">Selamat datang, <?= session('username'); ?></h3>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
  </div>
  <div class="offcanvas-body">
    <a href="/profile" class="nav-item nav-link active"><p>Data</p></a>
    <a href="/amenu" class="nav-item nav-link active"><p>Menu</p></a>
    <a href="/transaction" class="nav-item nav-link active"><p>Transaction</p></a>
  </div>
</div>
