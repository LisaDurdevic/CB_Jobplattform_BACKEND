<?php
    $fields = array(['"mail"', 'Mailaddress:', '"email" required'],
                    ['"password"', 'Password:', '"password" required placeholder = "enter new password for reset"']);

    for ($i = 0; $i < sizeOf($fields); $i++) {
?>
        <form id='login-input' class='container' method='post' action='?login'>
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
            <button id='login' type='submit' class='btn btn-secondary'>
                Try
            </button>
        </form>
<hr>
<a class='text-decoration-none text-light' href='./'>
    <button id='new' type='submit' class='btn btn-info'>
        Back to Dashboard
    </button>
</a>