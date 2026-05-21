<nav class="navbar navbar-expand-lg navbar-dark bg-dark px-3">
    <a class="navbar-brand fw-bold" href="#">
        KasirApp
    </a>

    <div class="ms-auto d-flex align-items-center gap-3">

        <button class="btn btn-outline-light btn-sm" id="toggleMode">
            <i class="fa-solid fa-moon"></i>
        </button>

        <span class="text-white">
            <?= $_SESSION['nama']; ?>
        </span>

        <a href="../../auth/logout.php"
        class="btn btn-danger btn-sm">
            Logout
        </a>

    </div>
</nav>