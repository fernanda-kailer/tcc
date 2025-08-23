<?php
session_start();
require '../config/config.php';
require '../src/Auth.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $auth = new Auth($pdo);
    $email = $_POST['email'];
    $password = $_POST['password'];

    if ($auth->login($email, $password)) {
        header('Location: study_plan.php');
        exit;
    } else {
        echo 'Credenciais inválidas!';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/forms.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
<form method="POST">
    
    Email: <input type="email" class="form-control"  name="email" required><br>
    Password: <input type="password" class="form-control" id="inputPassword" name="password" required><br>
    <div class="d-grid gap-2 col-5 mx-auto">
    <button type="submit" class="btn btn-outline-primary">Login</button>
</div>
</form>  


</body>
</html>

