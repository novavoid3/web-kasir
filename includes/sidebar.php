<div class="bg-dark text-white p-3 sidebar"
style="width:250px; min-height:100vh;">

    <h5 class="mb-4">MENU</h5>

    <ul class="nav flex-column">

        <li class="nav-item mb-2">
            <a href="/web-kasir/pages/home.php"
            class="nav-link text-white">
                Dashboard
            </a>
        </li>

        <?php if($_SESSION['role'] == 'admin'){ ?>

        <li class="nav-item mb-2">
            <a href="/web-kasir/modules/produk/index.php"
            class="nav-link text-white">
                Produk
            </a>
        </li>

        <li class="nav-item mb-2">
            <a href="/web-kasir/modules/kategori/index.php"
            class="nav-link text-white">
                Kategori
            </a>
        </li>

        <li class="nav-item mb-2">
            <a href="/web-kasir/modules/supplier/index.php"
            class="nav-link text-white">
                Supplier
            </a>
        </li>

        <li class="nav-item mb-2">
            <a href="/web-kasir/modules/user/index.php"
            class="nav-link text-white">
                User
            </a>
        </li>

        <?php } ?>

        <li class="nav-item mb-2">
            <a href="/web-kasir/modules/transaksi/index.php"
            class="nav-link text-white">
                Transaksi
            </a>
        </li>

        <li class="nav-item mb-2">
            <a href="/web-kasir/modules/laporan/index.php"
            class="nav-link text-white">
                Laporan
            </a>
        </li>

    </ul>

</div>