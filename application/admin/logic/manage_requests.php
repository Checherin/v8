<?php
// application/admin/logic/manage_requests.php - Логика управления заявками

// Одобрить заявку
if (isset($_GET['yavka_true'])) {
    $dbh = $conn->prepare("UPDATE requests SET status = 2 WHERE id = :id");
    $dbh->execute(['id' => htmlentities($_GET['yavka_true'])]);
    $_SESSION['success'] = "Заявка одобрена!";
    header("Location: dashboard.php");
    exit;
}

// Отклонить заявку
if (isset($_GET['yavka_false'])) {
    $dbh = $conn->prepare("UPDATE requests SET status = 3 WHERE id = :id");
    $dbh->execute(['id' => htmlentities($_GET['yavka_false'])]);
    $_SESSION['success'] = "Заявка отклонена!";
    header("Location: dashboard.php");
    exit;
}

// Удалить заявку
if (isset($_GET['yavka_delete'])) {
    $dbh = $conn->prepare("DELETE FROM requests WHERE id = :id");
    $dbh->execute(['id' => htmlentities($_GET['yavka_delete'])]);
    $_SESSION['success'] = "Заявка удалена!";
    header("Location: dashboard.php");
    exit;
}