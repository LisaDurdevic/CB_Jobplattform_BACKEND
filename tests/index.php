<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>

    <title>CB Jobplattform</title>
</head>
<body class="bg-dark text-light">

    <header>
        <h1 class='container ps-2 bg-warning text-dark'>CB Jobplattform DB INTERFACE</h1>
    </header>

    <main class="container clearfix">
        <hr>

        <!--input form for test data-->
        <?php
            //userName necessary to see all fields
            if (isset($_POST['userName'])) {
                //output terminal to observe the interface's behaviour

                //---------------THIS IS IMPORTANT!!!!----------------
                include("../utils/Profile.inc.php");
                $profile = new Profile;

                    if (isset($_GET['save'])) { //Data Transfer by $_POST
                        $profile->updateAccount($_POST);
                        $profile->updateRegistration($_POST);
                    } else {
                        //$profile->getPublicProfile($_POST['userName']);
                        $profile->getPrivateAccount($_POST['userName']);
                    }
                //----------------------------------------------------
                $fields = array(["userName", 'Username:', $profile->userName, '"text" required autofocus'],
                                        ['"password"', 'Password:', "", '"password" placeholder = "enter new password for reset"'],
                                        ['"mail"', 'Mailaddress:', $profile->mail, '"email" required'],
                                        ['"firstName"', 'First Name:', $profile->firstName, '"text"'],
                                        ['"lastName"', 'Last Name:', $profile->lastName, '"text"'],
                                        ['"phone"', 'Phone Number:', $profile->phone, '"text"'],
                                        ['"urlLinkedin"', 'URL LinkedIn:', $profile->linkedin, '"text"'],
                                        ['"urlXing"', 'URL Xing:', $profile->xing, '"text"'],
                                        ['"urlGithub"', 'URL Github:', $profile->git, '"text"'],
                                        ['"urlCustom"', 'URL Custom:', $profile->custom, '"text"'],
                                        ['"fullTime"', 'Working Fulltime:', $profile->fullTime, '"checkbox"'],
                                        ['"regionOne"', 'Preferred Working Region:', $profile->regionOne, '"text"'],
                                        ['"regionTwo"', 'Optional Working Region:', $profile->regionTwo, '"text"'],
                                        ['"preference"', 'Working Preference:', $profile->preference, '"text"'],
                                        ['"leaveDate"', 'Leave Date:', $profile->leave, '"date"']);

                if (isset($profile->mail)) { //userName exists

                
        ?>

            <form id='data-input' class='container' method='post' action='?save'>
                <hr>
                    <h2>
                        Data Input:
                    </h2>
                <hr>
                    <?php
                            for ($i = 0; $i < sizeOf($fields); $i++) {
                        ?>
                            <p class='row'>
                                <label for=<?php print $fields[$i][0]?> class='col-sm'>
                                    <?php print $fields[$i][1]?>
                                </label>
                                <input
                                    type= <?php print $fields[$i][3]?>
                                    id= <?php print $fields[$i][0]?>
                                    name= <?php print $fields[$i][0]?>
                                    class='col-sm'
                                    value='<?php print $fields[$i][2]?>'
                                    <?php ($profile->fullTime === 1)? print "checked" : "" ?>
                                    />
                            </p>
                        <?php
                            }
                        ?>

                        <hr>

                        <p class='row'>
                            <label for='skills' class='col-sm'>
                                Skills:
                            </label>
                            <select id='skills' name='skills[]' multiple='yes'>
                                <?php
                                    for ($i = 0; $i < sizeOf($profile->skills); $i++) {
                                        print "<option selected='selected'>" . $profile->skills[$i] . "</option>";
                                    }
                                ?>
                            </select>
                        </p>

                        <p class='row'>
                            <label for='topSkills' class='col-sm'>
                                Top Skills:
                            </label>
                            <select id='topSkills' name='topSkills[]' multiple='yes'>
                                <?php
                                    for ($i = 0; $i < sizeOf($profile->topSkills); $i++) {
                                        print "<option selected='selected'>" . $profile->topSkills[$i] . "</option>";
                                    }
                                ?>
                            </select>
                        </p>

                        <p class='row'>
                            <label for='languages' class='col-sm'>
                                Languages:
                            </label>
                            <select id='languages' name='languages[]' multiple='yes'>
                                <?php
                                    for ($i = 0; $i < sizeOf($profile->languages); $i++) {
                                        print "<option selected = 'selected'>" . $profile->languages[$i] . "</option>"; 
                                    }
                                ?>
                            </select>
                        </p>

                        <hr>
                    
                        <button id='send' type='submit' class='btn btn-success'>
                            Send to DB
                        </button>
            </form>

            <?php
                    //Reset page for new search
                        if (isset($_POST['userName'])) {
                    ?>
                        <hr>
                        <form id='restart' class='container'>
                            <button type='submit' class='btn btn-info'>
                                New Search
                            </button>
                        </form>
                    <?php
                        }
                    } else { //userName not found
                        header("Refresh:0");
                    }
                } else {
            ?>

            <form id='userName-input' class='container' method='post'>
                <p class='row'>
                    <label for='userName' class='col-sm fw-bold'>
                        userName:
                    </label>
                    <input
                        type='text'
                        id='userName'
                        name='userName'
                        class='col-sm'
                        value=''
                        required
                        autofocus/>
                </p>
                <button id='search' type='submit' class='btn btn-info'>
                    Search
                </button>
            </form>
            <hr>

            <?php        
                }
            ?>
    </main>

</body>
</html>
