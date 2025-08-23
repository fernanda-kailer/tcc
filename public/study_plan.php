<?php
session_start();
require '../config/config.php';
require '../src/Auth.php';
require '../src/StudyPlan.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $studyPlan = new StudyPlan($pdo);
    $subject = $_POST['subject'];
    $content = $_POST['content'];
    $studyTime = $_POST['study_time'];

    $plan = $studyPlan->generatePlan($subject, $content, $studyTime);
    echo "<pre>$plan</pre>";
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
    Disciplina: <input type="text" class="form-control" name="subject" required><br>
    Conteúdo: <textarea name="content" class="form-control" required></textarea><br>
    Tempo para estudos (em minutos): <input type="number" class="form-control" name="study_time" required><br>
    <div class="d-grid gap-2 col-5 mx-auto">
    <button type="submit" class="btn btn-outline-primary">Gerar plano</button>
</div>
</form>  
</body>
</html>

