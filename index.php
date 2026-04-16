<?php
$dbHost = getenv('DB_HOST') ?: 'localhost';
$dbName = getenv('DB_NAME') ?: 'p-351366_php-docker';
$dbUser = getenv('DB_USER') ?: 'p-351366_php-docker';
$dbPass = getenv('DB_PASS') ?: 'Anna-140275';

try {
    $pdo = new PDO("mysql:host={$dbHost};dbname={$dbName};charset=utf8mb4", $dbUser, $dbPass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4',
    ]);
} catch (PDOException $e) {
    die('Database connection failed: ' . htmlspecialchars($e->getMessage()));
}

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['name']) && !empty($_POST['email'])) {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);

    $stmt = $pdo->prepare('INSERT INTO users (name, email) VALUES (:name, :email)');
    $stmt->execute([':name' => $name, ':email' => $email]);

    $message = 'Запись добавлена.';
}

$users = $pdo->query('SELECT id, name, email, created_at FROM users ORDER BY created_at DESC')->fetchAll();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>PHP-Docker</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 800px; margin: 40px auto; padding: 0 20px; }
        table { border-collapse: collapse; width: 100%; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background: #f5f5f5; }
        .message { margin: 20px 0; padding: 12px; background: #e6ffed; border: 1px solid #b7f2c4; }
        .error { background: #ffe6e6; border-color: #f2b7b7; }
    </style>
</head>
<body>
    <h1>PHP + MySQL минимальный пример на Hoster.kz и локально</h1>

    <?php if ($message): ?>
        <div class="message"><?= htmlspecialchars($message) ?></div>
    <?php endif ?>

    <form method="post">
        <div>
            <label>Имя:<br>
                <input type="text" name="name" required style="width: 100%; padding: 8px;">
            </label>
        </div>
        <div style="margin-top: 10px;">
            <label>Email:<br>
                <input type="email" name="email" required style="width: 100%; padding: 8px;">
            </label>
        </div>
        <button type="submit" style="margin-top: 12px; padding: 10px 18px;">Добавить</button>
    </form>

    <h2>Пользователи</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Имя</th>
                <th>Email</th>
                <th>Создано</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= htmlspecialchars($user['id']) ?></td>
                    <td><?= htmlspecialchars($user['name']) ?></td>
                    <td><?= htmlspecialchars($user['email']) ?></td>
                    <td><?= htmlspecialchars($user['created_at']) ?></td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>



</body>
</html>

