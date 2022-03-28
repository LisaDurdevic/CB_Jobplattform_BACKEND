<?php
include("../utils/Profile.inc.php");
$profile = new Profile;
$profile->getPrivateAccount("sympathischerFisch6");

//$profile->setSkill("PL/SQL", 0); //skill
$profile->setSkill("NETZWERKADMIN", 1); //top skill
//$profile->setSkill("CSS", 0); //top skill
$profile->removeSkill("JAVASCRIPT");
$profile->setLanguage("ENGLISH");
$profile->setLanguage("GERMAN");
//$profile->setLanguage("SERBISCH");
//$profile->removeLanguage("GERMAN");

$profile->updateAccount();
?>