<?php
// application/guest/logic/auth_register.php - Обработка регистрации

if (isset($_POST['login']) && isset($_POST['password'])) {
    
    $dbh = $conn->prepare("SELECT * FROM users WHERE login = :login");
    
    $dbh->execute([
        'login' => htmlentities($_POST['login'])
    ]);
    
    if ($dbh->rowCount() > 0) {
        $error_reg = "<p style='color: red; text-align: center;'>Пользователь с таким логином уже существует!</p>";
    } else {
        
        $dbh = $conn->prepare("INSERT INTO users (login, password, name, email, phone) 
                               VALUES (:login, :password, :name, :email, :phone)");
        
        $dbh->execute([
            'login' => htmlentities($_POST['login']),
            'password' => htmlentities($_POST['password']),
            'name' => htmlentities($_POST['name']),
            'email' => htmlentities($_POST['email']),
            'phone' => htmlentities($_POST['phone'])
        ]);
        
        // Устанавливаем SESSION
        $_SESSION['success'] = "Регистрация успешна! Теперь вы можете войти.";
        
        header("Location: login.php");
        exit;
    }
} else {
    $error_reg = '';
}