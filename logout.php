<?php
// logout.php - Выход из системы (общий для всех ролей)
session_start();

// Очищаем SESSION
session_destroy();

// Очищаем COOKIE
setcookie("login", "", time() - 3600);
setcookie("name", "", time() - 3600);
setcookie("is_admin", "", time() - 3600);
setcookie("user_id", "", time() - 3600);

header('Location: index.php');
exit;