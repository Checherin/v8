<?php
// application/admin/logic/get_statistics.php - Логика получения статистики

// Всего заявок
$stmt = $conn->prepare("SELECT COUNT(*) as total FROM requests");
$stmt->execute([]);
$total_requests = $stmt->fetch()['total'];

// На рассмотрении
$stmt = $conn->prepare("SELECT COUNT(*) as total FROM requests WHERE status = 1");
$stmt->execute([]);
$pending_requests = $stmt->fetch()['total'];

// Всего пользователей
$stmt = $conn->prepare("SELECT COUNT(*) as total FROM users WHERE is_admin = 0");
$stmt->execute([]);
$total_users = $stmt->fetch()['total'];
?>

<div style="display: flex; justify-content: space-around; margin: 30px 0; gap: 20px;">
    <div style="background: #f5f5f5; padding: 20px; border-radius: 10px; text-align: center; flex: 1;">
        <h3 style="margin-bottom: 10px;">Всего заявок</h3>
        <p style="font-size: 32px; font-weight: bold; color: #666;"><?php echo $total_requests; ?></p>
    </div>
    <div style="background: #f5f5f5; padding: 20px; border-radius: 10px; text-align: center; flex: 1;">
        <h3 style="margin-bottom: 10px;">На рассмотрении</h3>
        <p style="font-size: 32px; font-weight: bold; color: #666;"><?php echo $pending_requests; ?></p>
    </div>
    <div style="background: #f5f5f5; padding: 20px; border-radius: 10px; text-align: center; flex: 1;">
        <h3 style="margin-bottom: 10px;">Пользователей</h3>
        <p style="font-size: 32px; font-weight: bold; color: #666;"><?php echo $total_users; ?></p>
    </div>
</div>