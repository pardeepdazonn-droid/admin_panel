<?php
session_start();
include('../header/header.php');
include('../conn.php');

$name = $_SESSION['user']['name'] ?? '';
$email = $_SESSION['user']['email'] ?? '';
 
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['credential'])) {
    $id_token = $_POST['credential'];
    $clientID = "451297895339-qhuur4oh5cu29c80u5nmu70jab61sj1b.apps.googleusercontent.com";

    $response = file_get_contents("https://oauth2.googleapis.com/tokeninfo?id_token=" . $id_token);
    $user = json_decode($response, true);
    if ($user && isset($user['email'])) {
        $_SESSION['user'] = [
            'name' => $user['name'],
            'email' => $user['email'],
            'picture' => $user['picture']
        ];
        $email_verified=$_SESSION['email_verified'] = true; 
        var_dump($_SESSION['email_verified']);
        $name = $user['name'];
        $email = $user['email'];
    } else {
        echo "<p class='text-danger'>Invalid Google login.</p>";
    }
}
?>

<form method="post" action="../venders-auth/vendor_register_process.php">
     
    <div class="mb-3">
        <input type="text" class="form-control" value="<?= htmlspecialchars($name) ?>" name="name" readonly>
    </div>
    <div class="mb-3">
        <input type="email" class="form-control" value="<?= htmlspecialchars($email) ?>" name="email" readonly>
    </div>
    <div class="mb-3">
        <input type="text" class="form-control" placeholder="Phone number" name="phone" required>
    </div>
    <div class="mb-3">
        <input type="text" class="form-control" placeholder="Company name" name="company_name" required>
    </div>
    <div class="mb-3">
        <input type="password" class="form-control" placeholder="Create password" name="password" required>
    </div>
    <button class="btn btn-primary" type="submit">Submit</button>
</form>