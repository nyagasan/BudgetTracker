<?php
class BudgetModel {
    private $file = 'data/budget.json';

    public function getBudget() {
        // 予算データをJSONファイルから読み込む
        if (file_exists($this->file)) {
            $data = file_get_contents($this->file);
            $budget = json_decode($data, true);
            if (is_array($budget)) {
                return $budget;
            }
        }
        // ファイルが存在しない場合やデータが不正な場合のデフォルト値
        return ['meal' => 0, 'other' => 0];
    }

    public function setBudget($budget) {
        // 予算データをJSONファイルに保存
        file_put_contents($this->file, json_encode($budget));
    }

    public function isBudgetSet() {
        // 予算が設定されているかどうかをチェック
        $budget = $this->getBudget();
        return ($budget['meal'] > 0 || $budget['other'] > 0);
    }
}