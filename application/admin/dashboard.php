<?php
// application/admin/dashboard.php - Админ-панель
session_start();
require_once '../connect.php';
include 'logic/manage_requests.php';

// Проверка авторизации и прав админа
if ((!isset($_SESSION['user_id']) && !isset($_COOKIE['user_id'])) || 
    (!isset($_SESSION['is_admin']) && !isset($_COOKIE['is_admin'])) ||
    ((isset($_SESSION['is_admin']) && $_SESSION['is_admin'] != 1) && 
     (isset($_COOKIE['is_admin']) && $_COOKIE['is_admin'] != 1))) {
    header("Location: ../guest/login.php");
    exit;
}

// Используем SESSION как приоритет, если нет - берём из COOKIE
$name = isset($_SESSION['name']) ? $_SESSION['name'] : $_COOKIE['name'];
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Админ-панель - DEKKO</title>
    <link rel="stylesheet" href="../../css/style.css">
</head>
<body>

<?php include '../../components/admin_header.php'; ?>

<main>
    <section class="form_section">
        <div class="form_container" style="max-width: 1200px;">
            <h2 class="form_title">Панель администратора</h2>
            <p style="text-align: center;">Добро пожаловать, <?php echo htmlentities($name); ?>!</p>
            
            <?php 
            if (isset($_SESSION['success'])) {
                echo "<p style='color: green; text-align: center;'>" . $_SESSION['success'] . "</p>";
                unset($_SESSION['success']);
            }
            ?>
            
            <?php include 'logic/get_statistics.php'; ?>
            
            <h3 style="text-align: center; margin-top: 40px;">Все заявки</h3>
            
            <?php
            // Получаем все заявки
            $stmt = $conn->prepare("SELECT r.*, u.email FROM requests r 
                                    LEFT JOIN users u ON r.user_id = u.id 
                                    ORDER BY r.created_at DESC");
            $stmt->execute([]);
            $requests = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            if (count($requests) > 0): 
            ?>
                <table>
                    <thead>
                        <tr>
                            <th>№</th>
                            <th>Имя</th>
                            <th>Телефон</th>
                            <th>Адрес</th>
                            <th>Тип мебели</th>
                            <th>Материал</th>
                            <th>Комментарий</th>
                            <th>Статус</th>
                            <th>Дата</th>
                            <th>Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($requests as $req): ?>
                        <tr>
                            <td><?php echo $req['id']; ?></td>
                            <td><?php echo $req['name']; ?></td>
                            <td><?php echo $req['phone']; ?></td>
                            <td><?php echo $req['address']; ?></td>
                            <td><?php echo $req['furniture_type']; ?></td>
                            <td><?php echo $req['material']; ?></td>
                            <td><?php echo $req['comment'] ?: '-'; ?></td>
                            <td>
                                <?php 
                                if ($req['status'] == 1) echo '<span style="color: orange;">На рассмотрении</span>';
                                elseif ($req['status'] == 2) echo '<span style="color: green;">Одобрено</span>';
                                elseif ($req['status'] == 3) echo '<span style="color: red;">Отклонено</span>';
                                ?>
                            </td>
                            <td><?php echo date('d.m.Y H:i', strtotime($req['created_at'])); ?></td>
                            <td>
                                <?php if ($req['status'] == 1): ?>
                                    <a href="?yavka_true=<?php echo $req['id']; ?>" style="color: green; text-decoration: underline;">Одобрить</a> | 
                                    <a href="?yavka_false=<?php echo $req['id']; ?>" style="color: red; text-decoration: underline;">Отклонить</a> | 
                                <?php endif; ?>
                                <a href="?yavka_delete=<?php echo $req['id']; ?>" style="color: #555; text-decoration: underline;" onclick="return confirm('Удалить заявку?')">Удалить</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p style="text-align: center; margin-top: 20px; color: #666;">Заявок пока нет.</p>
            <?php endif; ?>
        </div>
    </section>
</main>

<?php include '../../components/footer.php'; ?>

</body>
</html>