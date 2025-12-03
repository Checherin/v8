<?php
// application/guest/register.php
session_start();
require_once '../connect.php';
include 'logic/auth_register.php';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация - DEKKO</title>
    <link rel="stylesheet" href="../../css/style.css">
</head>
<body>

<?php include '../../components/guest_header.php'; ?>

<main>
    <section class="form_section">
        <div class="form_container">
            <h2 class="form_title">Создайте аккаунт DEKKO</h2>
            <p class="form_voda_for_form">
                Заполните поля ниже, чтобы создать свой профиль и начать пользоваться нашими услугами.
            </p>
            
            <?php 
            if (isset($error_reg)) {
                echo $error_reg;
            }
            if (isset($_SESSION['error'])) {
                echo "<p style='color: red; text-align: center;'>" . $_SESSION['error'] . "</p>";
                unset($_SESSION['error']);
            }
            ?>
            
            <form class="main_form" method="POST">
                <div class="form_polya">
                    <label>Логин:</label>
                    <input type="text" name="login" placeholder="Придумайте логин" required>
                </div>
                <div class="form_polya">
                    <label>Пароль:</label>
                    <input type="password" name="password" placeholder="Введите пароль" required>
                </div>
                <div class="form_polya">
                    <label>Имя:</label>
                    <input type="text" name="name" placeholder="Введите ваше имя" required>
                </div>
                <div class="form_polya">
                    <label>Email:</label>
                    <input type="email" name="email" placeholder="Введите email" required>
                </div>
                <div class="form_polya">
                    <label>Телефон:</label>
                    <input type="text" name="phone" placeholder="Введите телефон">
                </div>
                <button type="submit" class="form_button">Зарегистрироваться</button>
            </form>
            <p class="form_transport_text">Уже есть аккаунт? <a href="login.php">Войти!</a></p>
        </div>
    </section>
</main>

<?php include '../../components/footer.php'; ?>

</body>
</html>