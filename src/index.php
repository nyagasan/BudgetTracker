<?php

use controllers\MainController;

include_once __DIR__ . "/controllers/MainController.php";

$controller = new MainController();
$controller->display();
?>
