<?php
    include("../utils/Profile.inc.php");
    $profile = new Profile;
    echo "<pre>";
    print_r($profile->getAllProfiles());
    echo"</pre>";
?>
