<?php
// application/user/logic/view_requests.php - Логика просмотра своих заявок

// Используем SESSION как приоритет, если нет - берём из COOKIE
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : $_COOKIE['user_id'];

$dbh = $conn->prepare("SELECT * FROM requests WHERE user_id = :user_id ORDER BY created_at DESC");
$dbh->execute(['user_id' => htmlentities($user_id)]);

if ($dbh->rowCount() > 0) {
    $requests = $dbh->fetchAll(PDO::FETCH_ASSOC);
    
    echo '<table>';
    echo '<thead>
            <tr>
                <th>№</th>
                <th>Тип мебели</th>
                <th>Адрес</th>
                <th>Статус</th>
                <th>Дата</th>
            </tr>
          </thead>';
    echo '<tbody>';
    
    foreach ($requests as $req) {
        echo '<tr>';
        echo '<td>' . $req['id'] . '</td>';
        echo '<td>' . $req['furniture_type'] . '</td>';
        echo '<td>' . $req['address'] . '</td>';
        
        if ($req['status'] == 1) {
            echo '<td style="color: orange;">На рассмотрении</td>';
        } else if ($req['status'] == 2) {
            echo '<td style="color: green;">Одобрено</td>';
        } else if ($req['status'] == 3) {
            echo '<td style="color: red;">Отклонено</td>';
        }
        
        echo '<td>' . date('d.m.Y', strtotime($req['created_at'])) . '</td>';
        echo '</tr>';
    }
    
    echo '</tbody>';
    echo '</table>';
} else {
    echo '<p style="text-align: center; margin-top: 20px; color: #666;">У вас пока нет заявок.</p>';
}