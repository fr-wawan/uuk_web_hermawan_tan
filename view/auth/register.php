<?php
include_once("../../config/database.php");

session_start();


function isDuplicate($username, $pdo)
{
    $stmt = $pdo->prepare("SELECT * FROM tbl_user WHERE username = :username");
    $stmt->bindParam(":username", $username);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    return $user !== false;
}

function registerUser($username, $fullname, $password, $role, $pdo)
{
    if (isDuplicate($username, $pdo)) {
        echo "Username Already Taken";
    } else {
        $stmt = $pdo->prepare("INSERT INTO tbl_user (username,fullname,password,role) VALUES (:username,:fullname,:password,:role)");

        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':fullname', $fullname);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':role', $role);
        $stmt->execute();

        $stmt = $pdo->prepare("SELECT * FROM tbl_user WHERE username = :username");
        $stmt->bindParam(":username", $username);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);


        if (is_array($user)) {
            $_SESSION['isLoggedIn'] = true;
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
        }

        header("location: ../dashboard/index.php");
    }
}

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $fullname = $_POST['fullname'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    if (empty($username)) {
        $errors[] = "Username Tidak Boleh Kosong";
    }
    if (empty($fullname)) {
        $errors[] = "Nama Lengkap Tidak Boleh Kosong";
    }
    if (empty($password)) {
        $errors[] = "Password Tidak Boleh Kosong";
    }
    if (empty($errors)) {

        registerUser($username, $fullname, $password, $role, $pdo);
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
    <form action="" method="post" class="w-25 mx-auto ">
        <div class="my-3">
            <label for="username">Username</label>
            <input type="text" name="username" id="username" class="form-control ">
        </div>
        <div class="my-3">
            <label for="fullname">Full Name</label>
            <input type="text" name="fullname" id="fullname" class="form-control">
        </div>
        <div class="my-3">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" class="form-control">
        </div>
        <div class="my-4">
            <select name="role" id="role" class="form-select">
                <option value="admin">Admin</option>
                <option value="vendor">Vendor</option>
            </select>
        </div>

        <p class="my-4">Already Have An Account <a href="login.php">Click Here</a></p>
        <div class="my-4">
            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
</section>

<?php include_once("../inc/footer.php") ?>