<?php
    include("../utils/Profile.inc.php");
    $profile = new Profile;
    $profile->login("evil@mail.com", "1234");
?>