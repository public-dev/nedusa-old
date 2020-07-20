<?php
include "sys/main.inc.php";
$ctrl = new Sys();
$ctrl->init(2, "Home");
?>

<main>
        <h1>Hello, World!</h1>
</main>

<?php
$ctrl->end();
?>