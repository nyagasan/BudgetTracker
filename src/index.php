<?php
session_start();
require_once 'controllers/MainController.php';

// メインコントローラーのインスタンスを作成
$controller = new MainController();

// GETパラメータからアクションを取得、デフォルトは'home'
$action = $_GET['action'] ?? 'home';

// アクションに基づいて適切なコントローラーメソッドを呼び出す
switch ($action) {
    case 'set_budget':
        $controller->setBudget();
        break;
    case 'record_expense':
        $controller->recordExpense();
        break;
    case 'analysis':
        $controller->showAnalysis();
        break;
    case 'about':
        $controller->about();
        break;
    default:
        $controller->home();
}