<?php
include_once("../../config/database.php");

session_start();

function isUser($username, $password, $pdo)
{
    $stmt = $pdo->prepare("SELECT * FROM tbl_user WHERE username = :username AND password = :password");
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $password);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (is_array($user)) {
        $_SESSION['isLoggedIn'] = true;
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
    }

    return $user !== false;
}

function loginUser($username, $password, $pdo)
{
    if (isUser($username, $password, $pdo)) {
        header("location: ../dashboard/index.php");
    } else {
        echo "Invalid Credentials";
    }
}

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $errors = [];
    if (empty($username)) {
        $errors[] = "Username Tidak Boleh Kosong";
    }
    if (empty($password)) {
        $errors[] = "Password Tidak Boleh Kosong";
    }
    if (empty($errors)) {

        loginUser($username, $password, $pdo);
    } else {
        foreach ($errors as $error) {
            echo "<script>alert('$error')</script>";
        }
    }
}

?>

<?php include_once("../inc/header.php") ?>
<section class="bg-white container p-5 rounded shadow-sm" style="margin-top: 10rem; ">
    <h1 class="text-center text-uppercase font-weight-bold fs-2 fw-bold mb-5">Registration Form</h1>
    <form action="" method="post" class="w-25 mx-auto">
        <div class="my-3">
            <label for="username">Username</label>
            <input type="text" name="username" id="username" class="form-control ">
        </div>

        <div class="my-3">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" class="form-control">
        </div>

        <p class="my-4">Dont Have Any Account? <a href="register.php">Click Here</a></p>

        <div class="my-4">
            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
</section>
<?php include_once("../inc/footer.php") ?>