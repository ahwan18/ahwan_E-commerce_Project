<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item me-4">
          <a class="nav-link" href="../adminpanel">Home</a>
        </li>
        <li class="nav-item me-4">
          <a class="nav-link" href="../adminpanel/kategori.php">Category</a>
        </li>
        <li class="nav-item me-4">
          <a class="nav-link" href="../adminpanel/produk.php">Product</a>
        </li>
        <li class="nav-item me-4">
          <a class="nav-link" id="logout-link" href="../adminpanel/logout.php">Log Out</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<script>
  document.getElementById('logout-link').addEventListener('click', function(event) {
    if (!confirm('Are you sure?')) {
      event.preventDefault(); // Prevents the default action (navigating to logout.php)
    }
  });
</script>
