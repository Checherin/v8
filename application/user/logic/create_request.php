<?php
// application/user/logic/create_request.php - Логика создания заявки

// Используем SESSION как приоритет, если нет - берём из COOKIE
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : $_COOKIE['user_id'];
$name = isset($_SESSION['name']) ? $_SESSION['name'] : $_COOKIE['name'];

if (isset($_POST['phone']) && isset($_POST['address']) && isset($_POST['furniture_type']) && isset($_POST['material'])) {
    
    $dbh = $conn->prepare("SELECT * FROM requests WHERE address = :address AND user_id = :user_id");
    
    $dbh->execute([
        'address' => htmlentities($_POST['address']),
        'user_id' => htmlentities($user_id)
    ]);
    
    if ($dbh->rowCount() > 0) {
        $_SESSION['error'] = "Заявка на этот адрес уже существует!";
        $error_yavka = "<p style='color: red; text-align: center;'>Заявка на этот адрес уже существует!</p>";
    } else {
        
        $dbh = $conn->prepare("INSERT INTO requests (user_id, name, phone, address, furniture_type, material, comment, status) 
                               VALUES (:user_id, :name, :phone, :address, :furniture_type, :material, :comment, :status)");
        
        $dbh->execute([
            'user_id' => htmlentities($user_id),
            'name' => htmlentities($name),
            'phone' => htmlentities($_POST['phone']),
            'address' => htmlentities($_POST['address']),
            'furniture_type' => htmlentities($_POST['furniture_type']),
            'material' => htmlentities($_POST['material']),
            'comment' => htmlentities($_POST['comment']),
            'status' => 1
        ]);
        
        $_SESSION['success'] = "Заявка успешно создана!";
        header("Location: profile.php");
        exit;
    }
}