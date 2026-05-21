<?php
session_start();

if(isset($_SESSION['login'])){
    header("Location: ../pages/dashboard.php");
}
?>

<!DOCTYPE html>
<html>
<head>

    <title>Login</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light">

<div class="container">

    <div class="row justify-content-center align-items-center vh-100">

        <div class="col-md-4">

            <div class="card shadow p-4">

                <h3 class="text-center mb-4">
                    Login Kasir
                </h3>

                <form action="proses_login.php" method="POST">

                    <div class="mb-3">
                        <label>Username</label>

                        <input type="text"
                        name="username"
                        class="form-control"
                        required>
                    </div>

                    <div class="mb-3">
                        <label>Password</label>

                        <input type="password"
                        name="password"
                        class="form-control"
                        required>
                    </div>

                    <button type="submit"
                    name="login"
                    class="btn btn-dark w-100">
                        Login
                    </button>

                </form>

            </div>

        </div>

    </div>

</div>

</body>
</html>