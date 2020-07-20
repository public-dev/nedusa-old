<?php

include "../sys/main.inc.php";

$ctrl = new Sys();
$ctrl->init(2, "Support");

if(!$ctrl->isLoggedIn())
{
        header("Location: contact.php");
}

?>

<form method="POST" class="form"></form>

<?php

$ctrl->end();
?>