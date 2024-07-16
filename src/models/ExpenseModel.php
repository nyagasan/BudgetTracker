<?php
class ExpenseModel {
    private $file = 'data/expenses.json';

    public function getExpenses() {
        // 支出データをJSONファイルから読み込む
        if (file_exists($this->file)) {
            $data = file_get_contents($this->file);
            $expenses = json_decode($data, true);
            if (is_array($expenses)) {
                return $expenses;
            }
        }
        // ファイルが存在しない場合やデータが不正な場合は空の配列を返す
        return [];
    }

    public function addExpense($expense) {
        // 新しい支出を既存のデータに追加
        $expenses = $this->getExpenses();
        $expenses[] = $expense;
        // 更新されたデータをJSONファイルに保存
        file_put_contents($this->file, json_encode($expenses));
    }
}