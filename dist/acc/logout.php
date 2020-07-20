<?php

include "../sys/main.inc.php";

$ctrl = new Sys();
$ctrl->init(0, "Logout");

$ctrl->logout();

header("Location: ..");

?>