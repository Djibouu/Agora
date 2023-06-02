<?php
session_start();
session_destroy();

header('Location: \GitVisio/Agora-1/home.php');
exit();
?>