<?php
session()->getFlashdata('error');
service('validation')->listErrors();

    $fields = array(["userName", 'Username:', $user['userName'], '"text" required autofocus'],
                    ['"password"', 'Password:', "", '"password" placeholder = "enter new password for reset"'],
                    ['"mail"', 'Mailaddress:', $user['mail'], '"email" required'],
                    ['"firstName"', 'First Name:', $user['firstName'], '"text"'],
                    ['"lastName"', 'Last Name:', $user['lastName'], '"text"'],
                    ['"phone"', 'Phone Number:', $user['phone'], '"text"'],
                    ['"urlLinkedin"', 'URL LinkedIn:', $user['urlLinkedin'], '"text"'],
                    ['"urlXing"', 'URL Xing:', $user['urlXing'], '"text"'],
                    ['"urlGithub"', 'URL Github:', $user['urlGithub'], '"text"'],
                    ['"urlCustom"', 'URL Custom:', $user['urlCustom'], '"text"'],
                    ['"fullTime"', 'Working Fulltime:', $user['fullTime'], '"checkbox" style="height:20px"'],
                    ['"regionOne"', 'Preferred Working Region:', $user['regionOne'], '"text"'],
                    ['"regionTwo"', 'Optional Working Region:', $user['regionTwo'], '"text"'],
                    ['"preference"', 'Working Preference:', $user['preference'], '"text"'],
                    ['"leaveDate"', 'Leave Date:', $user['leaveDate'], '"date"'],
                    ['"newSkill"', 'Add Skill:', "", '"text" class="col-sm bg-warning"'],
                    ['"newTopSkill"', 'Add Top Skill:', "", '"text" class="col-sm bg-warning"'],
                    ['"newLanguage"', 'Add Language:', "", '"text" class="col-sm bg-warning"']);

?>
<article class="container">
    <form id='data-input' class='container' method='post' action='/user/update'>
        <?= csrf_field() ?>
<?php
        for ($i = 0; $i < sizeOf($fields); $i++) {
?>
            <p class='row'>
                <label for=<?php echo $fields[$i][0]?> class='col-sm'>
                    <?php echo $fields[$i][1]?>
                </label>
                <input
                    type= <?php echo $fields[$i][3]?>
                    id= <?php echo $fields[$i][0]?>
                    name= <?php echo $fields[$i][0]?>
                    class='col-sm'
                    value='<?php echo $fields[$i][2]?>'
                    <?php echo $user['fullTime'] === 1? "checked" : "";?>
                    />
            </p>
<?php
        }
?>
            <hr>
            <p class='row bg-primary'>
                Hold CRTL and deselect options you want to drop.
            </p>
            <p class='row'>
                <label for='skills' class='col-sm'>
                    Skills:
                </label>
                <select id='skills' name='skills[]' multiple='yes'>
                    <?php
                    if (isset($user['skills']) && isarray($user['skills'])) {
                        for ($i = 0; $i < sizeOf($user['skills']); $i++) {
                            print "<option selected='selected'>" . $user['skills'][$i] . "</option>";
                        }
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
                    if (isset($user['topSkills']) && isarray($user['topSkills'])) {
                        for ($i = 0; $i < sizeOf($user['topSkills']); $i++) {
                            print "<option selected='selected'>" . $user['topSkills'][$i] . "</option>";
                        }
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
                    if (isset($user['languages']) && isarray($user['languages'])) {
                        for ($i = 0; $i < sizeOf($user['languages']); $i++) {
                            print "<option selected = 'selected'>" . $user['languages'][$i] . "</option>"; 
                        }
                    }
                    ?>
                </select>
            </p>

            <hr>
            <button id='send' type='submit' class='btn btn-success'>
                Send to DB
            </button>

            <a class='text-decoration-none text-light' href='#'>
                <button id='drop' type='button' class='btn btn-secondary'>
                    Delete Account
                </button>
            </a>
    </form>
</article>