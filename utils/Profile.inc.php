<?php

//-------------------------README--------------------------
//LOGIN...
    //$profile = new Profile();
    //$profile->login("myMail@gmail.com", "myPassword");

//CREATE ONE...
    //...USER ACCOUNT:
        //$profile = new Profile();
        //$profile->createAccount("FirstName", "LastName", "myMail@mail.com", "myPassword")

//SELECT ONE...
    //...USER ACCOUNT including all private data, no password:
        //$profile = new Profile;
        //$profile->getPrivateAccount(<userName>);

    //...PUBLIC PROFILE without any private data:
        //$profile = new Profile;
        //$profile->getPublicProfile(<userName>);

//UPDATE ONE...
    //--> !!! make sure $_POST or $profile contains all necessary fields and correct field-names!!!
    //--> !!! otherwise empty-left field-names my get overwritten !!!
    //it is no problem if you set skills several times, they will be added only one time. 
    //if a skill has at least one time int 1 it will become a top skill too

    //...USER REGISTRATION (fields: firstName, lastName, mail, optional: pw) 
        //$profile->updateRegistration();

    //...USER PROFILE (fields: phone, linkedin, xing, git, custom, fullTime, regionOne, regionTwo, preference, skills, topSkills, languages, optional: leaveDate)
        //--> use $profile->setSkill("definition", int) and $profile->setLanguage("definition", int) to add entries into the arrays before updating
        //--> use $profile->removeSkill("definition") and $profile->removeLanguage("definition") to remove entries from the arrays before updating

        //$profile->updateProfile(); 

//DROP ONE...
    //...AUTOMATICALLY while selecting depending on leaveDate + 180 days

//SELECT ALL...
    //...PUBLIC PROFILES without any private data as an array:
        //$profile = new Profile;
        //$array = array();
        //$array = $profile->getAllProfiles();
//----------------------------------------------------------

include("../utils/DB.inc.php");

    class Profile {

        //-LOGIN---------------------------------------------------------------------------------------------
            function login($mail, $password) { //if login fails, $profile = null
                $this->mail = $mail;
                $db = new DB;
                $db->checkLogin($this, $password);
            }

        //-CREATE---------------------------------------------------------------------------------------------
            function createAccount($firstName, $lastName, $mail, $pw) {
                $this->firstName = $firstName;
                $this->lastName = $lastName;
                $this->mail = $mail;
                $this->password = password_hash($pw, PASSWORD_BCRYPT); //crypted
                $leave = time() + 13148715; //150 days
                $this->leave = date("Y-m-d", $leave);

                $db = new DB;
                $db->insertAccount($this);
            }

        //-UPDATE---------------------------------------------------------------------------------------------
            function updateRegistration() {
                if ($_POST['password'] !== "") {
                    $this->password = password_hash($_POST['password'], PASSWORD_BCRYPT);
                }

                if (isset($_POST['mail'])) {
                    $this->firstName = $_POST['firstName'];
                    $this->lastName = $_POST['lastName'];
                    $this->mail = $_POST['mail'];    
                }

                $db = new DB;
                $db->updateRegistrationData($this);
            }

            function updateAccount() {

                if (isset($_POST['username']))
                if (isset($_POST['fullTime'])) {
                    $_POST['fullTime'] = 1;
                } else {
                    $_POST['fullTime'] = 0;
                }

                if (isset($_POST['userName'])) {
                    $this->setProfile($_POST);
                }

                $db = new DB;
                $db->updateAccountData($this);
            }

        //-DROP---------------------------------------------------------------------------------------------
            function dropAccount() {
                $db = new DB;
                $db->dropAccount($this);
            }

        //-SELECT---------------------------------------------------------------------------------------------
            function getPublicProfile($userName) { //fills object array with public data
                $this->userName = $userName;
                $db = new DB;
                $db->selectAccount(0, $this);
            }

            function getPrivateAccount($userName) { //fills object array incl. private data
                $this->userName = $userName;
                $db = new DB;
                $db->selectAccount(1, $this);
            }

            static function getAllProfiles() {
                $db = new DB;
                $array = array();
                $array = $db->selectAll();
                return $array;
            }

        //-TOOLS---------------------------------------------------------------------------------------------
            function setProfile($account) {
                $this->userName = $account['userName'];
                $this->leave = (isset($account['leaveDate'])) ? $account['leaveDate'] : "";

                $delete = strtotime($this->leave) + 15778458; //180 days
                if (isset($account['leaveDate']) && $delete < time()) {
                    $this->dropAccount();
                } else {
                    $this->firstName = (isset($account['firstName'])) ? $account['firstName'] : "";
                    $this->lastName = (isset($account['lastName'])) ? $account['lastName'] : "";
                    $this->phone = (isset($account['phone'])) ? $account['phone'] : "";
                    $this->mail = (isset($account['mail'])) ? $account['mail'] : "";
                    $this->linkedin = (isset($account['urlLinkedin'])) ? $account['urlLinkedin'] : "";
                    $this->xing = (isset($account['urlXing'])) ? $account['urlXing'] : "";
                    $this->git = (isset($account['urlGithub'])) ? $account['urlGithub'] : "";
                    $this->custom = (isset($account['urlCustom'])) ? $account['urlCustom'] : "";
                    $this->fullTime = (isset($account['fullTime'])) ? $account['fullTime'] : "";
                    $this->regionOne = (isset($account['regionOne'])) ? $account['regionOne'] : "";
                    $this->regionTwo = (isset($account['regionTwo'])) ? $account['regionTwo'] : "";
                    $this->preference = (isset($account['preference'])) ? $account['preference'] : "";

                    if (!isset($this->topSkills) && !isset($account['topSkills'])) {
                        $this->topSkills = array();
                    } else if (isset($account['topSkills'])) {
                        $this->topSkills = $account['topSkills'];
                    }
                    
                    if (!isset($this->skills) && !isset($account['skills'])) {
                        $this->skills = array();
                    } else if (isset($account['skills'])) {
                        $this->skills = $account['skills'];
                    }

                    if (!isset($this->languages) && !isset($account['languages'])) {
                        $this->languages = array();
                    } else if (isset($account['languages'])) {
                        $this->languages = $account['languages'];
                    }
                }
            }

            function setSkill($skill, $topSkill) {
                $this->skills [] = $skill;

                if ($topSkill === 1) {
                    $this->topSkills [] = $skill;
                }
            }

            function setLanguage($language) {
                $this->languages [] = $language;;
            }

            function removeSkill($skill) {
                for ($i = 0; $i < sizeOf($this->skills); $i++) {
                    if ($this->skills[$i] === $skill) {
                        $this->skills[$i] = ""; //unset would cause problems while updating
                    }
                }

                for ($i = 0; $i < sizeOf($this->topSkills); $i++) {
                    if ($this->topSkills[$i] === $skill) {
                        $this->topSkills[$i] = ""; //unset would cause problems while updating
                    }
                }
            }

            function removeLanguage($language) {
                for ($i = 0; $i < sizeOf($this->languages); $i++) {
                    if ($this->languages[$i] === $language) {
                        $this->languages[$i] = ""; //unset would cause problems while updating
                    }
                }
            }
    }
?>