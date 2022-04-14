<?php
    session()->getFlashdata('error');
    service('validation')->listErrors();

    $fields = array(['"mail"', 'Mailaddress:', '"email" required'],
                    ['"password"', 'Password:', '"password" required placeholder = "enter new password for reset"'],
                    ['"firstName"', 'First Name:', '"text" required'],
                    ['"lastName"', 'Last Name:', '"text" required']);
?>
    <form id='new-data-input' class='container' method='post' action='/user/create'>
        <?= csrf_field() ?>
<?php
        for ($i = 0; $i < sizeOf($fields); $i++) {
?>
            <p class='row'>
                <label for=<?php echo $fields[$i][0]?> class='col-sm'>
                    <?php echo $fields[$i][1]?>
                </label>
                <input
                    type= <?php echo $fields[$i][2]?>
                    id= <?php echo $fields[$i][0]?>
                    name= <?php echo $fields[$i][0]?>
                    class='col-sm'
                    />
            </p>
<?php
        }
?>
        <button id='send' type='submit' class='btn btn-secondary'>
            Set new account
        </button>
    </form>
<hr>
<a class='text-decoration-none text-light' href='./'>
    <button id='new' type='submit' class='btn btn-info'>
        Back to Dashboard
    </button>
</a>