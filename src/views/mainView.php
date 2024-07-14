<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>Sample Page</title>
</head>
<body>
<p><?php echo isset($data) ? htmlspecialchars($data) : 'No data provided'; ?></p>
<?php echo "<p>View loaded.</p>"; // デバッグ出力 ?>
</body>
</html>