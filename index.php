<?php
require_once "includes/functions.php";
header("Location: " . (empty($_SESSION["user"]) ? "login.php" : "dashboard.php"));
exit;
