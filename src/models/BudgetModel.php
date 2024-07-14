<?php
class BudgetModel {
    private $file = 'data/budget.json';

    public function getBudget() {
        if (file_exists($this->file)) {
            $data = file_get_contents($this->file);
            $budget = json_decode($data, true);
            if (is_array($budget)) {
                return $budget;
            }
        }
        return ['meal' => 0, 'other' => 0];
    }

    public function setBudget($budget) {
        file_put_contents($this->file, json_encode($budget));
    }
}