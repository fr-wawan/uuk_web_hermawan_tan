<?php
session_start();

if (!isset($_SESSION['isLoggedIn'])) {
    header("location:../auth/login.php");
}
?>
<?php include_once("../inc/header.php")

?>


<section>
    <nav class="navbar navbar-expand-lg bg-body-tertiary" data-bs-theme="dark">
        <div class="container-fluid ">
            <a class="navbar-brand" href="#">DASHBOARD</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav" style="margin-left: auto;">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="../logout.php">Logout</a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <h1 class="fs-3 mt-5">Welcome <?= $_SESSION['username'] ?></h1>
        <p class=" ">Your role are <?= $_SESSION['role'] ?></p>
    </div>
</section>

<?php include_once("../inc/footer.php")

?>