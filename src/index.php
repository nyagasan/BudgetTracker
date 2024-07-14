<?php
session_start();
require_once 'controllers/MainController.php';

$controller = new MainController();
$action = $_GET['action'] ?? 'home';

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
    default:
        $controller->home();
}