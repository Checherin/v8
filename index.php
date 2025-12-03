<?php
// index.php - Роутер (перенаправление по ролям)
session_start();

// Если пользователь не авторизован (проверяем и SESSION, и COOKIE)
if (!isset($_SESSION['user_id']) && !isset($_COOKIE['user_id'])) {
    header("Location: application/guest/index.php");
    exit;
}

// Если пользователь авторизован
if (isset($_SESSION['user_id']) || isset($_COOKIE['user_id'])) {
    // Определяем is_admin (приоритет у SESSION)
    $is_admin = isset($_SESSION['is_admin']) ? $_SESSION['is_admin'] : (isset($_COOKIE['is_admin']) ? $_COOKIE['is_admin'] : 0);
    
    // Если админ - в админку
    if ($is_admin == 1) {
        header("Location: application/admin/dashboard.php");
        exit;
    } 
    // Если обычный пользователь - в профиль
    else {
        header("Location: application/user/profile.php");
        exit;
    }
}