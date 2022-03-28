<?php

/**
 * provides all necessary methods for using the database
 * no direct use, approach only over the Profile class
 */
    class DB {

        //-CONNECT---------------------------------------------------------------------------------------------
            /**
             * creates a new MySQLi connection
             *
             * @return null|MySQLi
             * 
             */
            function connect() {
                include("../auth/auth.inc.php");
                $this->con = new MySQLi($host, $user, $pw, $db);

                if ($this->con->connect_errno) {
                    exit();
                } 
            }

        //-CREATE/INSERT---------------------------------------------------------------------------------------------
            /**
             * INSERT statement adds new account data to the database, prints errormessage if fails
             *
             * @param Profile $profile provides the new profile data including hashed password, first name, 
             * last name, mail and leave date
             * 
             * @return none
             * 
             */
            function insertAccount($profile) {
                try {
                    $this->getUsername($profile); //creates unique username for identification
                    $this->checkMail($profile); //checks if mail address already exists within the database

                    if (isset($profile->new)) { //mail free to use
                        $this->connect();
                            $sql = "INSERT INTO user (userName, pw, firstName, lastName, mail, leaveDate) VALUES (?, ?, ?, ?, ?, ?)";
                            $statement = $this->con->prepare($sql);
                            $statement->bind_param('ssssss', $profile->userName, $profile->password, $profile->firstName, 
                                            $profile->lastName, $profile->mail, $profile->leave);
                            $statement->execute();
                        $this->con->close();
                    } else {
                        print $error_message = "Mail is already used for another userName.";
                    }
                } catch (Exception $e) {
                    print $error_message = "Creating new account failed.";
                }
            }

            /**
             * uses class Username to create a random unique username, 
             * SELECT statement validates availability,
             * prints errormessage if fails
             * 
             * @param Profile $profile stores new account data, at least first name, last name, mail, hashed password
             * 
             * @return Profile including userName
             * 
             */
            function getUsername($profile) {
                include("userName.inc.php");
                
                $userName = new Username();

                try {
                    $this->connect();
                        do {
                            $userName->create();
                                $sql = "SELECT userName FROM user WHERE userName = ?";
                                $statement = $this->con->prepare($sql);
                                $statement->bind_param("s", $userName->name);
                                $statement->execute();
                                $result = $statement->get_result();
                                $account = $result->fetch_assoc();
                        } while ($account !== null); //until new userName found
                    $this->con->close();

                    $profile->userName = $userName->name; //setting new userName

                } catch (Exception $e) {
                    print $error_message = "Mailcheck failed";
                }
            }

        //-SELECT---------------------------------------------------------------------------------------------
            /**
             * SELECT statement gets either all data or only public (anonymous) data from the database, including skills and languages,
             * prints errormessage if fails
             *
             * @param int $limit 1 defines that all data (including private) should be selected, any other int delivers only public data
             * @param Profile $profile stores account data, at least userName, further data gets overwritten
             * 
             * @var result $resultUser delivers data attached to userName according to $limit, at least public data
             * @var result $resultSkills delivers all skills attached to userName
             * @var result $resultLanguages delivers all languages attached to userName
             * @var object $account contains all pulled data, needed for methods of Profile
             * 
             * @return Profile containing all freshly pulled account data
             * 
             */
            function selectAccount($limit, $profile) { 
                try {
                    $this->connect();
                        if ($limit === 1) { //incl. private data
                            $sql = "SELECT * FROM user WHERE userName = ?";
                        } else { //only public data
                            $sql = "SELECT userName, leaveDate, fullTime, regionOne, regionTwo, preference FROM user WHERE userName = ?";
                        }

                        $statement = $this->con->prepare($sql);
                        $statement->bind_param("s", $profile->userName);
                        $statement->execute();
                        $resultUser = $statement->get_result();

                        $sql = "SELECT userName, skills.skill_id, topSkill, definition FROM userskills LEFT JOIN skills ON userskills.skill_id = skills.skill_id WHERE userName = ?";
                        $statement = $this->con->prepare($sql);
                        $statement->bind_param("s", $profile->userName);
                        $statement->execute();
                        $resultSkills = $statement->get_result();

                        $sql = "SELECT userName, languages.lang_id, definition FROM userlang LEFT JOIN languages ON userlang.lang_id = languages.lang_id WHERE userName = ?";
                        $statement = $this->con->prepare($sql);
                        $statement->bind_param("s", $profile->userName);
                        $statement->execute();
                        $resultLanguages = $statement->get_result();

                        $account = $resultUser->fetch_assoc();
                        
                        if ($account === null) {
                            return false; //userName not found
                        } else {
                            //reading in skills
                            while ($skill = $resultSkills->fetch_assoc()) {
                                $profile->setSkill($skill['definition'], $skill['topSkill']);
                            }

                            //reading in languages
                            while ($lang = $resultLanguages->fetch_assoc()) {
                                $profile->setLanguage($lang['definition']);
                            }

                            $profile->setProfile($account);
                        }
                    $this->con->close();

                } catch (Exception $e) {
                    print $error_message = "Select failed.";
                }
            }

            /**
             * SELECT statement gets all public (anonymous) data from the database,
             * prints errormessage if fails 
             *
             * @return array[Profile] with all pulled Profile objects
             * 
             */
            function selectAll() {
                try {
                    $this->connect();
                        $sql = "SELECT userName, leaveDate, fullTime, regionOne, regionTwo, preference FROM user";
                        $resultUser = $this->con->query($sql);

                        $sql = "SELECT userName, topSkill, definition FROM userskills LEFT JOIN skills ON userskills.skill_id = skills.skill_id";
                        $resultSkills = $this->con->query($sql);

                        $sql = "SELECT userName, definition FROM userlang LEFT JOIN languages ON userlang.lang_id = languages.lang_id";
                        $resultLanguages = $this->con->query($sql);

                    return $this->resultToArray($resultUser, $resultSkills, $resultLanguages);

                } catch (Exception $e) {
                    print $error_message = "Select failed.";
                } finally {
                    $this->con->close();
                }
            }

        //-UPDATE---------------------------------------------------------------------------------------------
            /**
             * UPDATE statement to overwrite account data in the database,
             * prints errormessage if fails
             *
             * @param Profile $profile delivers all profile data, including userName, phone number, different urls, leave date, working full time yes/no, working regions and working preference,
             * skill-array and language-array gets updated if provided
             * 
             * @return null
             * 
             */
            function updateAccountData($profile) {
                try {
                    $this->connect();
                        $sql = "UPDATE user SET phone = ?, urlLinkedin = ?, urlXing = ?, urlGithub = ?, urlCustom = ?, leaveDate = ?, fullTime = ?, regionOne = ?, regionTwo = ?, preference = ? WHERE userName = ?";
                        $statement = $this->con->prepare($sql);
                        $statement->bind_param('ssssssdssss', $profile->phone, $profile->linkedin, $profile->xing, 
                                                $profile->git, $profile->custom, $profile->leave, $profile->fullTime, 
                                                $profile->regionOne, $profile->regionTwo, $profile->preference, $profile->userName);
                        $statement->execute();                    
                    $this->con->close();

                    
                    if (isset($profile->skills)) {
                        $this->updateUserSkills($profile);
                    }
                    if (isset($profile->languages)) {
                        $this->updateUserLanguages($profile);
                    }

                } catch (Exception $e) {
                    print $error_message = "Profile update failed.";
                }
            }

            /**
             * UPDATE statement for sensitive registration data (admin rights required), 
             * prints errormessage if fails or the used mail already exists for another userName.
             * it is not possible to change the userName itself.
             *
             * @param Profile $profile delivers updated account data, at least first name, last name, mail, userName
             * 
             * @return null
             * 
             */
            function updateRegistrationData($profile) {
                try {
                        if (isset($profile->password)) {
                            $this->resetPassword($profile);
                        }

                        $this->checkMail($profile);

                        if (isset($profile->update) || isset($profile->new)) {
                            $this->connect();
                                $sql = "UPDATE user SET firstName = ?, lastName = ?, mail = ? WHERE userName = ?";
                                $statement = $this->con->prepare($sql);
                                $statement->bind_param('ssss', $profile->firstName, $profile->lastName, $profile->mail, $profile->userName);
                                $statement->execute();

                                
                            $this->con->close();
                        } else {
                            print $error_message = "This mail already exists.";
                        }
                } catch (Exception $e) {
                    print $error_message = "Registration update failed.";
                }
            }

            /**
             * UPDATE statement to reset a user's password,
             * prints errormessage if fails
             *
             * @param Profile $profile delivers account data, at least userName and hashed password
             * 
             * @return null
             * 
             */
            private function resetPassword($profile) {
                try {
                    $this->connect();
                        $sql = "UPDATE user SET pw = ? WHERE userName = ?";
                        $statement = $this->con->prepare($sql);
                        $statement->bind_param('ss', $profile->password, $profile->userName);
                        $statement->execute();
                        $profile->password = ""; //for security
                    $this->con->close();

                } catch (Exception $e) {
                    print $error_message = "Password reset failed.";
                }
            }

            /**
             * DROP and INSERT statement to drop the current skill-package and attach the updated one
             *
             * @param Profile $profile delivers account data, at least userName, skill and topSkills
             * 
             * @var int $skill_id stores the internal skill_id from the database for correct insertion
             * @var int $topSkill delivers 1=true | 0=false for the database
             * 
             * @return null
             * 
             */
            private function updateUserSkills($profile) {
                //deleting all entries in table userskills for user = ? and adding all current skills from $profile->skills
                $this->dropAllSkills($profile);
    
                $this->connect();
                    $sql = "INSERT INTO userskills (userName, skill_id, topSkill) VALUES (?, ?, ?)";
    
                    for ($i = 0; $i < sizeOf($profile->skills); $i++) { //for each skill
                        $statement = $this->con->prepare($sql);
                        $skill_id = $this->getSkillIDByName($profile->skills[$i]);
                        $topSkill = 0; //standard
                        for ($j = 0; $j < sizeOf($profile->topSkills); $j++) { //check for top Skill
                            if ($profile->skills[$i] === $profile->topSkills[$j]) {
                                $topSkill = 1;
                                break;
                            }
                        }
                        $statement->bind_param("sdd", $profile->userName, $skill_id, $topSkill);
                        $statement->execute();
                    }
                $this->con->close();
            }
    
            /**
             * DROP and INSERT statement to drop the current language-package and attach the updated one
             *
             * @param Profile $profile delivers account data, at least userName and languages
             * 
             * @var string $lang_id stores the internal lang_id (shortage) from the database for correct insertion
             * 
             * @return null
             * 
             */
            private function updateUserLanguages($profile) {
                //deleting all entries in table userlang for user = ? and adding all current languages from $profile->languages
                $this->dropAllLanguages($profile);
     
                $this->connect();
                    $sql = "INSERT INTO userlang (userName, lang_id) VALUES (?, ?)";
    
                    for ($i = 0; $i < sizeOf($profile->languages); $i++) { //for each language
                        $statement = $this->con->prepare($sql);
                        $lang_id = $this->getLanguageIDByName($profile->languages[$i]);
                        $statement->bind_param("ss", $profile->userName, $lang_id);
                        $statement->execute();
                    }
                $this->con->close();
            }

        //-DROP/DELETE---------------------------------------------------------------------------------------------
            /**
             * DROP statement for deleting an account,
             * for private data security the account data gets randomly overwritten before final drop,
             * prints errormessage if fails
             *
             * @internal gets triggered each time during Profile method 'setProfile'
             * 
             * @param Profile $profile delivers account data, at least userName
             * 
             * @return null
             * 
             */
            function dropAccount($profile) {
                try {
                    $this->randomOverwrite($profile);

                    $this->connect();
                        $sql = "DELETE FROM user WHERE userName = ?";
                        $statement = $this->con->prepare($sql);
                        $statement->bind_param('s', $profile->userName);
                        $statement->execute();
                        
                        if ($statement->error !== "") {
                            print $statement->error;
                        }
                    $this->con->close();

                } catch (Exception $e) {
                    print $error_message = "Account could not be deleted.";
                }
            }

            /**
             * DROP statement for deleting the attached skill-package in the database
             *
             * @internal gets triggered during updateAccountData
             * 
             * @param Profile $profile delivers account data, at least userName
             * 
             * @return null
             * 
             */
            private function dropAllSkills($profile) {
                $this->connect();
                    $sql = "DELETE FROM userskills WHERE userName = ?";
                    $statement = $this->con->prepare($sql);
                    $statement->bind_param("s", $profile->userName);
                    $statement->execute();
                $this->con->close();
            }
    
            /**
             * DROP statement for deleting the attached language-package in the database
             * 
             * @internal gets triggered during updateAccountData
             * 
             * @param Profile $profile delivers account data, at least userName
             * 
             * @return null
             * 
             */
            private function dropAllLanguages($profile) {
                $this->connect();
                    $sql = "DELETE FROM userlang WHERE userName = ?";
                    $statement = $this->con->prepare($sql);
                    $statement->bind_param("s", $profile->userName);
                    $statement->execute();
                $this->con->close();
            }

        //-TOOLS---------------------------------------------------------------------------------------------
            //CHECK
                /**
                 * tool to ensure the used mail doesn't already exist, the database attribute is set unique,
                 * prints errormessage if fails, further errormessages come with the parent method
                 *
                 * @internal 
                 * 
                 * @param Profile $profile delivers account data, at least mail (for login) | mail + userName (for update)
                 * 
                 * @var object $account contains the pulled userName and stored hashed password if the mail was found
                 * @return Profile including 'new' | 'password' + 'userName' | 'update'
                 * 
                 */
                private function checkMail ($profile) {
                    try {
                        $this->connect();
                            $sql = "SELECT userName, pw FROM user WHERE mail = ?";
                            $statement = $this->con->prepare($sql);
                            $statement->bind_param("s", $profile->mail);
                            $statement->execute();
                            $result = $statement->get_result();
                            $account = $result->fetch_assoc();
    
                            if ($account === null) { //mail not found
                                $profile->new = true; //new insert possible
                            } else { // mail found
                                if (isset($profile->userName) && $profile->userName === $account['userName']) {
                                    $profile->update = true; //mail only exists for the account which is to update, OK
                                } else {
                                    $profile->userName = $account['userName']; //mail for login is found, OK
                                    $profile->password = $account['pw']; //sending pw for further check
                                } // all further cases: user cannot use this mail
                            }
    
                        $this->con->close();
    
                    } catch (Exception $e) {
                        print $error_message = "Mailcheck failed";
                    }
                }
    
                /**
                 * tool to ensure the provided mail and password are correct, 
                 * prints message if login succeeded of failed
                 *
                 * @param Profile $profile delivers account data, at least mail
                 * @param string $password delivers entered (unhashed) password 
                 * 
                 * @return Profile including private + public data
                 * 
                 */
                function checkLogin($profile, $password) {
                    $this->checkMail($profile);
    
                    if ($profile->mail !== null && isset($profile->userName) && password_verify($password, $profile->password)) { //mail found, pw hashed vs unhashed
                        $this->selectAccount(1, $profile);
                        print "Login succeed.";
                    } else {
                        $profile = null;
                        print $error_message = "Mail or password is not correct.";
                    }
                }

            //GET
                /**
                 * SELECT statement to get additional information about a certain skill
                 *
                 * @internal 
                 * 
                 * @param string $skillName must match the spelling used in the database
                 * 
                 * @return int $skill_id for further using
                 * 
                 */
                private function getSkillIDByName($skillName) {
                    $sql = "SELECT * FROM skills WHERE definition = ?";
                    $statement = $this->con->prepare($sql);
                    $statement->bind_param("s", $skillName);
                    $statement->execute();
                    $result = $statement->get_result();
                    $skill = $result->fetch_assoc();
                    return $skill['skill_id'];
                }

                /**
                 * SELECT statement to get additional information about a certain language
                 * 
                 * @internal
                 *
                 * @param string $langName must match the spelling used in the database
                 * 
                 * @return string $lang_id for further using
                 * 
                 */
                private function getLanguageIDByName($langName) {
                    $sql = "SELECT * FROM languages WHERE definition = ?";
                    $statement = $this->con->prepare($sql);
                    $statement->bind_param("s", $langName);
                    $statement->execute();
                    $result = $statement->get_result();
                    $language = $result->fetch_assoc();
                    return $language['lang_id'];
                }

            //MODIFY
                /**
                 * tool to transalte result-package into array with Profile objects
                 *
                 * @internal 
                 * 
                 * @param result $resultUser contains account data with | without private data
                 * @param result $resultSkills contains current skill-package
                 * @param result $resultLanguages contains current language-package
                 * 
                 * @return boolean|array[Profile]
                 * 
                 */
                private function resultToArray($resultUser, $resultSkills, $resultLanguages) {
                    if ($resultUser === null) {
                        return false;
                    } else {
                        //reading in all basic data
                            while ($account = $resultUser->fetch_assoc()) {
                                $profile = new Profile;
                                $profile->setProfile($account);
                                $array []= $profile;
                            }

                        //reading in all skills
                            while ($skill = $resultSkills->fetch_assoc()) {
                                for ($i = 0; $i < sizeOf($array); $i++) {
                                    if ($skill['userName'] === $array[$i]->userName) {
                                        $array[$i]->setSkill($skill['definition'], $skill['topSkill']);
                                        break;
                                    }
                                }
                            }

                        //reading in all languages
                            while ($lang = $resultLanguages->fetch_assoc()) {
                                for ($i = 0; $i < sizeOf($array); $i++) {
                                    if ($lang['userName'] === $array[$i]->userName) {
                                        $array[$i]->setLanguage($lang['definition']);
                                        break;
                                    }
                                }
                            }

                        return $array;
                    }
                }

            //RANDOM DSGVO OVERWRITE
                /**
                 * overwrites profile data in the database 10 times randomly to make sure no private data can be restored
                 *
                 * @internal 
                 * 
                 * @param Profile $profile stores (overwritten) account data for further methods
                 * 
                 * @return null
                 * 
                 */
                private function randomOverwrite($profile) {
                        for ($i = 0; $i < 10; $i++) {
                            $profile->firstName = random_int(1000000000, 2147483647) . "abcdefghijklmnopqrstuvwxyz"; //min. 20 steps
                            $profile->lastName = random_int(1000000000, 2147483647) . "abcdefghijklmnopqrstuvwxyz"; //min. 20 steps
                            $profile->mail = random_int(1000000000, 2147483647) . "abcdefghijklmnopqrstuvwxyz"; //min. 30 steps
                            $profile->phone = random_int(1000000000, 2147483647) . "abcdefghijklmnopqrstuvwxyz"; //min. 20 steps
                            $profile->linkedin = "abcdefghijklmnopqrstuvwxyz" . random_int(1000000000, 2147483647) . "abcdefghijklmnopqrstuvwxyz"; //min. 60 steps
                            $profile->xing = "abcdefghijklmnopqrstuvwxyz" . random_int(1000000000, 2147483647) . "abcdefghijklmnopqrstuvwxyz"; //min. 60 steps
                            $profile->git = "abcdefghijklmnopqrstuvwxyz" . random_int(1000000000, 2147483647) . "abcdefghijklmnopqrstuvwxyz"; //min. 60 steps
                            $profile->custom = "abcdefghijklmnopqrstuvwxyz" . random_int(1000000000, 2147483647) . "abcdefghijklmnopqrstuvwxyz"; //min. 60 steps

                            $this->updateRegistrationData($profile);
                            $this->updateProfileData($profile);                  
                        }
                }
    }
?>