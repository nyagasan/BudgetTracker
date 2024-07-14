<?php
class ExpenseModel {
    private $file = 'data/expenses.json';

    public function getExpenses() {
        if (file_exists($this->file)) {
            $data = file_get_contents($this->file);
            $expenses = json_decode($data, true);
            if (is_array($expenses)) {
                return $expenses;
            }
        }
        return [];
    }

    public function addExpense($expense) {
        $expenses = $this->getExpenses();
        $expenses[] = $expense;
        file_put_contents($this->file, json_encode($expenses));
    }
}