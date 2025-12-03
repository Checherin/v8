<?php
// application/guest/logic/auth_login.php - Обработка авторизации

if (isset($_POST['login']) && isset($_POST['password'])) {
    
    $dbh = $conn->prepare("SELECT * FROM users WHERE login = :login AND password = :password");
    
    $dbh->execute([
        'login' => htmlentities($_POST['login']),
        'password' => htmlentities($_POST['password'])
    ]);
    
    if ($dbh->rowCount() > 0) {
        $m = $dbh->fetch(PDO::FETCH_ASSOC);
        
        // Устанавливаем SESSION (безопасные данные на сервере)
        $_SESSION['user_id'] = $m['id'];
        $_SESSION['login'] = $m['login'];
        $_SESSION['name'] = $m['name'];
        $_SESSION['is_admin'] = $m['is_admin'];
        
        // Устанавливаем COOKIE (для удобного доступа)
        setcookie("login", $m["login"]);
        setcookie("name", $m["name"]);
        setcookie("is_admin", $m["is_admin"]);
        setcookie("user_id", $m["id"]);
        
        header("Location: ../../../index.php");
        exit;
    } else {
        $error_auth = "<p style='color: red; text-align: center;'>Неправильный логин или пароль!</p>";
    }
} else {
    $error_auth = '';
}