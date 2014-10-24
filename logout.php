<?php
session_start();
session_destroy();
//document.location.href="index.php?chlang='.$sesia.'";
header("Location: index.php");
?>
