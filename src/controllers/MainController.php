<?php
require_once 'models/BudgetModel.php';
require_once 'models/ExpenseModel.php';

class MainController {
    private $budgetModel;
    private $expenseModel;

    public function __construct() {
        $this->budgetModel = new BudgetModel();
        $this->expenseModel = new ExpenseModel();
    }

    public function home() {
        $budget = $this->budgetModel->getBudget();
        $expenses = $this->expenseModel->getExpenses();
        $dailyTotal = $this->calculateDailyTotal($expenses);
        $difference = $this->calculateDifference($budget, $dailyTotal);
        $this->render('home', [
            'budget' => $budget,
            'expenses' => $expenses ?: [],
            'dailyTotal' => $dailyTotal,
            'difference' => $difference
        ]);
    }

    public function setBudget() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['meal']) && isset($_POST['other'])) {
                $budget = [
                    'meal' => floatval($_POST['meal']),
                    'other' => floatval($_POST['other'])
                ];
                $this->budgetModel->setBudget($budget);
                header('Location: index.php');
                exit;
            } else {
                $error = "予算の入力が不完全です。";
                $this->render('set_budget', ['error' => $error]);
                return;
            }
        }
        $this->render('set_budget');
    }

    public function recordExpense() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['date']) && isset($_POST['type']) && isset($_POST['amount']) && isset($_POST['note'])) {
                $expense = [
                    'date' => $_POST['date'],
                    'type' => $_POST['type'],
                    'amount' => floatval($_POST['amount']),
                    'note' => $_POST['note']
                ];
                $this->expenseModel->addExpense($expense);
                header('Location: index.php');
                exit;
            } else {
                $error = "支出の入力が不完全です。";
                $this->render('record_expense', ['error' => $error]);
                return;
            }
        }
        $this->render('record_expense');
    }

    public function showAnalysis() {
        $expenses = $this->expenseModel->getExpenses();
        $budget = $this->budgetModel->getBudget();
        $analysis = $this->analyzeExpenses($expenses, $budget);
        $this->render('analysis', ['analysis' => $analysis]);
    }

    private function render($view, $data = []) {
        extract($data);
        require_once "views/layout.php";
    }

    private function calculateDailyTotal($expenses) {
        $today = date('Y-m-d');
        $total = 0;
        foreach ($expenses as $expense) {
            if ($expense['date'] === $today) {
                $total += $expense['amount'];
            }
        }
        return $total;
    }

    private function calculateDifference($budget, $dailyTotal) {
        $dailyBudget = ($budget['meal'] * 3) + $budget['other'];
        return $dailyBudget - $dailyTotal;
    }

    private function analyzeExpenses($expenses, $budget) {
        $weeklyExpenses = [];
        $weeklyBudget = ($budget['meal'] * 3 + $budget['other']) * 7;

        foreach ($expenses as $expense) {
            $week = date('W', strtotime($expense['date']));
            if (!isset($weeklyExpenses[$week])) {
                $weeklyExpenses[$week] = 0;
            }
            $weeklyExpenses[$week] += $expense['amount'];
        }

        $analysis = [];
        foreach ($weeklyExpenses as $week => $total) {
            $difference = $weeklyBudget - $total;
            $analysis[$week] = [
                'total' => $total,
                'difference' => $difference,
                'status' => $difference >= 0 ? 'surplus' : 'deficit'
            ];
        }

        return $analysis;
    }
}