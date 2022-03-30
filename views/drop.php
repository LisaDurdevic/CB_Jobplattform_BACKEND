<?php
    include("../utils/Profile.inc.php");
    $profile = new Profile;
    $profile->userName = $_GET['userName'];
    $profile->dropAccount();
    header("Location: index.php")
?>