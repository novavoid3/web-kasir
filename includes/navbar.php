<nav class="navbar navbar-expand-lg bg-white shadow-sm px-4 py-3 rounded">

<div class="container-fluid">

<button class="btn btn-dark d-lg-none"
id="toggleSidebar">

<i class="fa fa-bars"></i>

</button>

<h5 class="mb-0 fw-bold">
Web Kasir
</h5>

<div class="d-flex align-items-center gap-3">

<button class="btn btn-outline-dark"
id="darkModeToggle">

<i class="fa fa-moon"></i>

</button>

<div class="dropdown">

<button class="btn btn-light dropdown-toggle"
data-bs-toggle="dropdown">

<?= $_SESSION['nama']; ?>

</button>

<ul class="dropdown-menu dropdown-menu-end">

<li>
<a class="dropdown-item"
href="/web-kasir/pages/profile.php">

Profile
</a>
</li>

<li>
<a class="dropdown-item text-danger"
href="/web-kasir/auth/logout.php">

Logout
</a>
</li>

</ul>

</div>

</div>

</div>

</nav>