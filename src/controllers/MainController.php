<?php
require_once 'models/BudgetModel.php';
require_once 'models/ExpenseModel.php';

class MainController {
    private $budgetModel;
    private $expenseModel;

    public function __construct() {
        // モデルのインスタンスを作成
        $this->budgetModel = new BudgetModel();
        $this->expenseModel = new ExpenseModel();
    }

    public function home() {
        // ホームページに必要なデータを取得
        $budget = $this->budgetModel->getBudget();
        $isBudgetSet = $this->budgetModel->isBudgetSet();
        $expenses = $this->expenseModel->getExpenses();
        $dailyTotal = $this->calculateDailyTotal($expenses);
        $difference = $this->calculateDifference($budget, $dailyTotal);

        // ホームページをレンダリング
        $this->render('home', [
            'budget' => $budget,
            'expenses' => $expenses,
            'dailyTotal' => $dailyTotal,
            'difference' => $difference,
            'isBudgetSet' => $isBudgetSet
        ]);
    }

    public function setBudget() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // POSTデータのバリデーション
            if (isset($_POST['meal']) && isset($_POST['other'])) {
                $budget = [
                    'meal' => floatval($_POST['meal']),
                    'other' => floatval($_POST['other'])
                ];
                // 予算を保存
                $this->budgetModel->setBudget($budget);
                // 成功メッセージをセット
                $_SESSION['alert'] = [
                    'type' => 'success',
                    'message' => '予算が正常に設定されました。'
                ];
                header('Location: index.php');
                exit;
            } else {
                // エラーメッセージをセット
                $error = "予算の入力が不完全です。";
                $this->render('set_budget', ['error' => $error]);
                return;
            }
        }
        // GETリクエストの場合、予算設定フォームを表示
        $this->render('set_budget');
    }

    public function recordExpense() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // POSTデータのバリデーション
            if (isset($_POST['date']) && isset($_POST['type']) && isset($_POST['amount']) && isset($_POST['note'])) {
                $expense = [
                    'date' => $_POST['date'],
                    'type' => $_POST['type'],
                    'amount' => floatval($_POST['amount']),
                    'note' => $_POST['note']
                ];
                // 支出を記録
                $this->expenseModel->addExpense($expense);
                // 成功メッセージをセット
                $_SESSION['alert'] = [
                    'type' => 'success',
                    'message' => '支出が正常に記録されました。'
                ];
                header('Location: index.php');
                exit;
            } else {
                // エラーメッセージをセット
                $error = "支出の入力が不完全です。";
                $this->render('record_expense', ['error' => $error]);
                return;
            }
        }
        // GETリクエストの場合、支出記録フォームを表示
        $this->render('record_expense');
    }

    public function showAnalysis() {
        // 分析に必要なデータを取得
        $expenses = $this->expenseModel->getExpenses();
        $budget = $this->budgetModel->getBudget();
        $analysis = $this->analyzeExpenses($expenses, $budget);
        // 分析ページをレンダリング
        $this->render('analysis', ['analysis' => $analysis]);
    }

    public function about() {
        // アバウトページをレンダリング
        $this->render('about');
    }

    private function render($view, $data = []) {
        // データを変数として展開
        extract($data);
        // ビューファイルを読み込み
        require_once "views/layout.php";
    }

    private function calculateDailyTotal($expenses) {
        $today = date('Y-m-d');
        $total = 0;
        // 今日の支出合計を計算
        foreach ($expenses as $expense) {
            if ($expense['date'] === $today) {
                $total += $expense['amount'];
            }
        }
        return $total;
    }

    private function calculateDifference($budget, $dailyTotal) {
        // 1日の予算と実際の支出の差額を計算
        $dailyBudget = ($budget['meal'] * 3) + $budget['other'];
        return $dailyBudget - $dailyTotal;
    }

    private function analyzeExpenses($expenses, $budget) {
        $weeklyExpenses = [];
        $weeklyBudget = ($budget['meal'] * 3 + $budget['other']) * 7;

        // 週ごとの支出を集計
        foreach ($expenses as $expense) {
            $week = date('W', strtotime($expense['date']));
            if (!isset($weeklyExpenses[$week])) {
                $weeklyExpenses[$week] = 0;
            }
            $weeklyExpenses[$week] += $expense['amount'];
        }

        // 週ごとの分析結果を作成
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