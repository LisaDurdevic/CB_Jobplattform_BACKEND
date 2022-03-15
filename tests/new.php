<?php
    include("../utils/Profile.inc.php");
    $profile = new Profile;
    $profile->createAccount("Randall", "Boggs", "evil@mail.com", "1234");
?>