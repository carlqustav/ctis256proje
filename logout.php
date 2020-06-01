<?php

session_destroy();
setcookie("PHPSESSID","", 1 , "/");

header("Location: index.php");
exit;

?>