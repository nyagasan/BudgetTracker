<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>家計簿アプリ</title>
    <!-- Bootstrapのスタイルシートを読み込み -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php
// セッションにアラートがある場合、表示して削除
if (isset($_SESSION['alert'])) {
    $alertType = $_SESSION['alert']['type'];
    $alertMessage = $_SESSION['alert']['message'];
    echo "<div class='alert alert-{$alertType} alert-dismissible fade show' role='alert'>
                {$alertMessage}
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
              </div>";
    unset($_SESSION['alert']);
}
?>
<!-- ナビゲーションバー -->
<nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
    <div class="container">
        <a class="navbar-brand" href="index.php">家計簿アプリ</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">ホーム</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?action=set_budget">予算設定</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?action=record_expense">支出記録</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?action=analysis">分析</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?action=about">アプリについて</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-4">
    <?php include $view . '.php'; ?>
</div>
<!-- BootstrapのJavaScriptを読み込み -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- Chart.jsを読み込み -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</body>
</html>