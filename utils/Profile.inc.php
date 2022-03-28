<?php

include("../utils/DB.inc.php");

    class Profile {

        //-LOGIN---------------------------------------------------------------------------------------------
            /**
             * validates login data for existing accounts, returns account data if login matched, 
             * further method prints additional message
             *
             * @param string $mail
             * @param string $password unhashed
             * 
             * @return null|Profile if login fails, Profile will be null
             * 
             */
            function login($mail, $password) { //if login fails, $profile = null
                $this->mail = $mail;
                $db = new DB;
                $db->checkLogin($this, $password);
            }

        //-CREATE---------------------------------------------------------------------------------------------
            /**
             * creates completely new account (new registration) 
             *
             * @param string $firstName
             * @param string $lastName
             * @param string $mail must be unique, gets validated
             * @param string $pw gets hashed
             * 
             * @return Profile including provided registration data
             * 
             */
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
            /**
             * merges this profile with another object (resultSet | $_POST | etc) and sends only registration data
             * to the database, prints errormessage if fails
             *
             * @param object $account must contain at least firstName, lastName and mail. optional: password for reset
             * 
             * @return Profile including provided registration data
             * 
             */
            function updateRegistration($account) {
                if ($account['password'] !== "") {
                    $this->password = password_hash($account['password'], PASSWORD_BCRYPT);
                }

                if (isset($account['mail']) && isset($account['firstName']) && isset($account['lastName'])) {
                    $this->firstName = $account['firstName'];
                    $this->lastName = $account['lastName'];
                    $this->mail = $account['mail'];   
                    
                    $db = new DB;
                    $db->updateRegistrationData($this);
                } else {
                    print $error_message = "Mail, First Name and Last Name required."
                }
            }

            /**
             * merges this profile with another object (resultset | $_POST | etc) and sends the Profile to the db,
             * prints errormessage if there is no userName provided.
             *
             * @param object $account must contain phone, linkedin, xing, git, custom, fullTime, regionOne, regionTwo, preference, skills, topSkills and languages.
             * otherwise values could be overwritten. optional: leave date
             * 
             * @var int $account['fullTime'] 1 = working full time | 0 = working part time
             * 
             * @return Profile including all provided data
             * 
             */
            function updateAccount($account) {

                if (isset($account['userName'])) {
                    if (isset($account['fullTime'])) {
                        $account['fullTime'] = 1;
                    } else {
                        $account['fullTime'] = 0;
                    }

                    $this->setProfile($account);
                    
                    $db = new DB;
                    $db->updateAccountData($this);
                } else {
                    print $error_message = "Username required.";
                }
            }

        //-DROP---------------------------------------------------------------------------------------------
            /**
             * randomly overwrites and finally drops this Profile's account irreversible if userName exists,
             * gets automatically triggered during every select if leave date is older than n days
             *
             * @return Profile without any further data except the old userName
             * 
             */
            function dropAccount() {
                $db = new DB;
                $db->dropAccount($this);
            }

        //-SELECT---------------------------------------------------------------------------------------------
            /**
             * pulls only public (anonymous) data from one specific account, if exists
             *
             * @param string $userName
             * 
             * @return Profile
             * 
             */
            function getPublicProfile($userName) { //fills object array with public data
                $this->userName = $userName;
                $db = new DB;
                $db->selectAccount(0, $this);
            }

            /**
             * pulls complete account data from one specific account for admin purposes, if exists, no password
             *
             * @param string $userName
             * 
             * @return Profile
             * 
             */
            function getPrivateAccount($userName) { //fills object array incl. private data
                $this->userName = $userName;
                $db = new DB;
                $db->selectAccount(1, $this);
            }

            /**
             * pulls all public profiles from the database into an array with Profile objects, if exists
             *
             * @return null|array[Profile]
             * 
             */
            static function getAllProfiles() {
                $db = new DB;
                $array = array();
                $array = $db->selectAll();
                return $array;
            }

        //-TOOLS---------------------------------------------------------------------------------------------
            /**
             * subconstructor, merges this Profile with the provided data from another object (resultset | $_POST | etc),
             * adds all provided data | uses empty value to prepare yet unused variables for further usage
             *
             * @internal 
             * 
             * @param object $account provides data from the database or entered data from frontend
             * 
             * @var string $userName must be provided
             * @var date $delete automatically drops account if leave date is older than 180 days (6 months) 
             * @var int $fullTime 1 = working full time | 0 = working part time
             * @var string $regionOne shows the mostly preferred working region, can also be 'everywhere' or 'home office'
             * @var string $regionTwo shows an optional other working region
             * @var string $preference shows in which proffessional area the person wants to work (Backend, Frontend, SAP...)
             * 
             * @return null
             * 
             */
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

            /**
             * adds a new skill to the skill-package, 
             * requires updateAccount to set changes in the database.
             * the update can be done collectively
             * 
             * @internal
             *
             * @param string $skill must match the spelling used in the database
             * @param int $topSkill 1=topSkill
             * 
             * @return null
             * 
             */
            function setSkill($skill, $topSkill) {
                $this->skills [] = $skill;

                if ($topSkill === 1) {
                    $this->topSkills [] = $skill;
                }
            }

            /**
             * adds a new language to the language-package, 
             * requires updateAccount to set changes in the database.
             * the update can be done collectively
             *
             * @internal
             * 
             * @param string $language must match the spelling used in the database
             * 
             * @return null
             * 
             */
            function setLanguage($language) {
                $this->languages [] = $language;;
            }

            /**
             * replaces a specific skill from Profile attributes with empty value, 
             * simply unsetting could cause problems during the following update,
             * requires updateAccount to set changes in the database.
             * the update can be done collectively
             * 
             * @internal
             *
             * @param string $skill must match the spelling used in the database
             * 
             * @return null
             * 
             */
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

            /**
             * replaces a specific language from Profile attributes with empty value, 
             * simply unsetting could cause problems during the following update,
             * requires updateAccount to set changes in the database.
             * the update can be done collectively
             * 
             * @internal
             *
             * @param string $language must match the spelling used in the database
             * 
             * @return null
             * 
             */
            function removeLanguage($language) {
                for ($i = 0; $i < sizeOf($this->languages); $i++) {
                    if ($this->languages[$i] === $language) {
                        $this->languages[$i] = ""; //unset would cause problems while updating
                    }
                }
            }
    }
?>