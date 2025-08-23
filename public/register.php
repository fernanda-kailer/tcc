<?php
session_start();
require '../config/config.php';
require '../src/Auth.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $auth = new Auth($pdo);
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    if ($auth->register($name, $email, $password)) {
        header('Location: login.php');
        exit;
    } else {
        echo 'Erro ao registrar!';
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
    Nome: <input type="text" class="form-control" id="exampleFormControlInput1" name="name" required><br>
    Email: <input type="email" class="form-control" id="exampleFormControlInput1" name="email" required><br>
    Senha: <input type="password" name="password" class="form-control" id="exampleFormControlInput1" required><br>
    <div class="d-grid gap-2 col-5 mx-auto"><button type="submit" class="btn btn-outline-primary">Cadastrar</button></div>
</form>

 <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
 
</body>
 </html>

