<?php

namespace controllers;

use model\DataModel;

include_once __DIR__ . "/../models/DataModel.php";
include_once __DIR__ . "/../views/mainView.php";

class MainController {
    public function display() {
        echo "Controller before getting data.<br>"; // デバッグ出力
        $model = new DataModel();
        global $data;
        $data = $model->getData();
        echo "Controller after getting data: $data<br>"; // デバッグ出力
        include_once(__DIR__ . "/../views/mainView.php");
    }
}

?>
