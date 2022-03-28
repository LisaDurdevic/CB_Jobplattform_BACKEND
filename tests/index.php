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

                if (isset($profile->mail)) { //userName exists

                
        ?>

            <form id='data-input' class='container' method='post' action='?save'>
                <hr>
                    <h2>
                        Data Input:
                    </h2>
                <hr>
                        <p class='row'>
                            <label for='userName' class='col-sm fw-bold'>
                                userName:
                            </label>
                            <input
                                type='text'
                                id='userName'
                                name='userName'
                                class='col-sm'
                                value='<?php echo $profile->userName?>'
                                required
                                autofocus/>
                        </p>

                        <p class='row'>
                            <label for='password' class='col-sm fw-bold'>
                                Password:
                            </label>
                            <input
                                type='password'
                                id='password'
                                name='password'
                                class='col-sm'
                                placeholder='enter new password to reset'
                                />
                        </p>

                        <p class='row'>
                            <label for='mail' class='col-sm fw-bold'>
                                Mailaddress:
                            </label>
                            <input
                                type='email'
                                id='mail'
                                name='mail'
                                class='col-sm'
                                value='<?php echo $profile->mail ?>'
                                />
                        </p>

                        <p class='row'>
                            <label for='firstName' class='col-sm'>
                                First Name:
                            </label>
                            <input
                                type='text'
                                id='firstName'
                                name='firstName'
                                value='<?php echo $profile->firstName ?>'
                                class='col-sm'
                                />
                        </p>

                        <p class='row'>
                            <label for='lastName' class='col-sm'>
                                Last Name:
                            </label>
                            <input
                                type='text'
                                id='lastName'
                                name='lastName'
                                value='<?php echo $profile->lastName ?>'
                                class='col-sm'
                                />
                        </p>

                        <p class='row'>
                            <label for='phone' class='col-sm'>
                                Phone Number:
                            </label>
                            <input
                                type='text'
                                id='phone'
                                name='phone'
                                class='col-sm'
                                value='<?php echo $profile->phone ?>'/>
                        </p>

                        <p class='row'>
                            <label for='urlLinkedin' class='col-sm'>
                                URL LinkedIn:
                            </label>
                            <input
                                type='text'
                                id='urlLinkedin'
                                name='urlLinkedin'
                                class='col-sm'
                                value='<?php echo $profile->linkedin ?>'/>
                        </p>
                        
                        <p class='row'>
                            <label for='urlXing' class='col-sm'>
                                URL Xing:
                            </label>
                            <input
                                type='text'
                                id='urlXing'
                                name='urlXing'
                                class='col-sm'
                                value='<?php echo $profile->xing ?>'/>
                        </p>

                        <p class='row'>
                            <label for='urlGithub' class='col-sm'>
                                URL GitHub:
                            </label>
                            <input
                                type='text'
                                id='urlGithub'
                                name='urlGithub'
                                class='col-sm'
                                value='<?php echo $profile->git ?>'/>
                        </p>

                        <p class='row'>
                            <label for='urlCustom' class='col-sm'>
                                Custom URL:
                            </label>
                            <input
                                type='text'
                                id='urlCustom'
                                name='urlCustom'
                                class='col-sm'
                                value='<?php echo $profile->custom ?>'/>
                        </p>

                        <p class='row'>
                            <label for='fullTime' class='col-sm'>
                                Full Time:
                            </label>
                            <input
                                type='checkbox'
                                id='fullTime'
                                name='fullTime'
                                class='col-sm'
                                <?php
                                if ($profile->fullTime === 1) {
                                ?> checked <?php
                                } ?>
                                />
                        </p>

                        <p class='row'>
                            <label for='regionOne' class='col-sm'>
                                Preferred Working Region:
                            </label>
                            <input
                                type='text'
                                id='regionOne'
                                name='regionOne'
                                class='col-sm'
                                value='<?php echo $profile->regionOne ?>'/>
                        </p>

                        <p class='row'>
                            <label for='regionTwo' class='col-sm'>
                                Optional Working Region:
                            </label>
                            <input
                                type='text'
                                id='regionTwo'
                                name='regionTwo'
                                class='col-sm'
                                value='<?php echo $profile->regionTwo ?>'/>
                        </p>

                        <p class='row'>
                            <label for='preference' class='col-sm'>
                                Working Preference:
                            </label>
                            <input
                                type='text'
                                id='preference'
                                name='preference'
                                class='col-sm'
                                value='<?php echo $profile->preference ?>'/>
                        </p>

                        <hr>

                        <p class='row'>
                            <label for='leaveDate' class='col-sm'>
                                Leave Date:
                            </label>
                            <input
                                type='date'
                                id='leaveDate'
                                name='leaveDate'
                                class='col-sm'
                                value='<?php echo $profile->leave ?>'/>
                        </p>

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