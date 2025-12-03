<?php
// application/user/profile.php - Личный кабинет пользователя
session_start();
require_once '../connect.php';
include 'logic/create_request.php';

// Проверка авторизации (и через SESSION, и через COOKIE)
if (!isset($_SESSION['user_id']) && !isset($_COOKIE['user_id'])) {
    header("Location: ../guest/login.php");
    exit;
}

// Используем SESSION как приоритет, если нет - берём из COOKIE
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : $_COOKIE['user_id'];
$name = isset($_SESSION['name']) ? $_SESSION['name'] : $_COOKIE['name'];
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Личный кабинет - DEKKO</title>
    <link rel="stylesheet" href="../../css/style.css">
</head>
<body>

<?php include '../../components/user_header.php'; ?>

<main>
    <section class="form_section">
        <div class="form_container" style="max-width: 800px;">
            <h2 class="form_title">Добро пожаловать, <?php echo htmlentities($name); ?>!</h2>
            
            <?php 
            if (isset($error_yavka)) {
                echo $error_yavka;
            }
            if (isset($_SESSION['success'])) {
                echo "<p style='color: green; text-align: center;'>" . $_SESSION['success'] . "</p>";
                unset($_SESSION['success']);
            }
            if (isset($_SESSION['error'])) {
                echo "<p style='color: red; text-align: center;'>" . $_SESSION['error'] . "</p>";
                unset($_SESSION['error']);
            }
            ?>
            
            <h3 style="text-align: center; margin-top: 30px;">Создать заявку</h3>
            <form class="main_form" method="POST">
                <div class="form_polya">
                    <label>Телефон:</label>
                    <input type="text" name="phone" placeholder="Введите телефон" required>
                </div>
                <div class="form_polya">
                    <label>Адрес:</label>
                    <input type="text" name="address" placeholder="Введите адрес" required>
                </div>
                <div class="form_polya">
                    <label>Тип мебели:</label>
                    <select name="furniture_type" required>
                        <option value="">Выберите тип</option>
                        <option value="Кухня">Кухня</option>
                        <option value="Спальня">Спальня</option>
                        <option value="Гостиная">Гостиная</option>
                        <option value="Прихожая">Прихожая</option>
                        <option value="Детская">Детская</option>
                        <option value="Кабинет">Кабинет</option>
                    </select>
                </div>
                <div class="form_polya">
                    <label>Материал:</label>
                    <select name="material" required>
                        <option value="">Выберите материал</option>
                        <option value="ДСП">ДСП</option>
                        <option value="МДФ">МДФ</option>
                        <option value="Массив дерева">Массив дерева</option>
                        <option value="Шпон">Шпон</option>
                    </select>
                </div>
                <div class="form_polya">
                    <label>Комментарий:</label>
                    <textarea name="comment" placeholder="Дополнительные пожелания"></textarea>
                </div>
                <button type="submit" class="form_button">Создать заявку</button>
            </form>
            
            <h3 style="text-align: center; margin-top: 50px;">Мои заявки</h3>
            <?php include 'logic/view_requests.php'; ?>
        </div>
    </section>
</main>

<?php include '../../components/footer.php'; ?>

</body>
</html>