<?php

namespace controllers;

use model\DataModel;

require_once __DIR__ . "/../models/DataModel.php";

class MainController {
    public function display() {
        $model = new DataModel();
        $data = $model->getData();

        // ビューにデータを渡す
        require_once __DIR__ . "/../views/mainView.php";
    }
}

?>
