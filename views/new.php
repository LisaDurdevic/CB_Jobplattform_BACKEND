<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
    <title>New Registration</title>
</head>
<body class="bg-dark text-light">
    <header>
        <h1 class='container ps-2 bg-warning text-dark'>Add new registration data</h1>
    </header>

    <main class="container clearfix">
        <?php
            include("../utils/Profile.inc.php");
            $profile = new Profile();

            if (isset($_GET['push'])) { //pushing new account
        ?>
                <p class='row bg-info text-dark'>
        <?php
                    $profile->createAccount($_POST['firstName'], $_POST['lastName'], $_POST['mail'], $_POST['password']);
        ?>
                </p>
        <?php
            }

            $fields = array(['"mail"', 'Mailaddress:', '"email" required'],
                            ['"password"', 'Password:', '"password" required placeholder = "enter new password for reset"'],
                            ['"firstName"', 'First Name:', '"text" required'],
                            ['"lastName"', 'Last Name:', '"text" required']);

            for ($i = 0; $i < sizeOf($fields); $i++) {
        ?>
                <form id='new-data-input' class='container' method='post' action='?push'>

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
                    <button id='send' type='submit' class='btn btn-success'>
                        Set new account
                    </button>
                </form>

            <hr>
            <a class='text-decoration-none text-light' href='./index.php'>
                <button id='new' type='submit' class='btn btn-info'>
                    Back to Dashboard
                </button>
            </a>
    </main>
</body>
</html>