<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!-- Latest compiled and minified CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Latest compiled JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <title>Travel Forum</title>
    <style>
        #grey-blanket {
            display: none;
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: Grey;
            opacity: 0.5;
            z-index: 2;
        }

        .my_modal {
            width: 550px;
            height: 380px;
            border: 1px blue solid;
            border-radius: 10px;
            background: white;
            display: none;
            position: fixed;
            top: calc(50vh - 250px);
            left: calc(50vw - 250px);
            z-index: 99;
        }

        #signin-modal-cancel-btn, #signup-modal-cancel-btn {
            position: absolute;
            bottom: 0;
            right: 0;
            padding: 5px;
            margin: 5px;
        }

        #signin-modal-submit-btn, #signup-modal-submit-btn {
            position: absolute;
            bottom: 0;
            left: 0;
            padding: 5px;
            margin: 5px;
        }

        label {
            display: inline-block;
            width: 150px;
            margin: 10px;
        }

        input {
            margin: 10px;
        }

    </style>
</head>
<body style="background: honeydew">
<div id='e2-layout-main' style='position:relative; height:500px;'>
    <div id='grey-blanket'>
    </div>
    <div>
        <h1 style='text-align:center;height:100px;background-color: rgba(71, 135, 120, 0.4);padding: 20px;color: white;margin-bottom: 0;'>
            Travel Forum</h1>
    </div>
    <div style="position: relative">
        <button id="signin_btn" class="btn btn-primary"
                style="display: block;padding:20px;width: 75%;margin: 120px auto;">Sign In
        </button>
        <button id="signup_btn" class="btn btn-primary"
                style="display: block;padding:20px;width: 75%;margin: 120px auto;">Sign Up
        </button>
    </div>
</div>

<div id='signin-modal' class="my_modal">
    <h4 style='text-align: center;padding: 10px'>Sign In</h4>
    <form action='controller.php' method='POST'>
        <input type='hidden' name='page' value='StartPage'>
        <input type='hidden' name='command' value='SignIn'>
        <label>Username</label>
        <input type='text'
               name='username'><?php if (!empty($error_msg_signin_username)) echo $error_msg_signin_username; ?>
        <label>Password</label>
        <input type='password'
               name='password'><?php if (!empty($error_msg_signin_password)) echo $error_msg_signin_password; ?>
        <input id="signin-modal-cancel-btn" type='button' value='Cancel' class="btn btn-secondary">
        <input id="signin-modal-submit-btn" type='submit' class="btn btn-primary">
    </form>
</div>

<div id='signup-modal' class="my_modal">
    <h1 style='text-align: center;padding: 10px'>Sign Up</h1>
    <form action='controller.php' method='POST'>
        <input type='hidden' name='page' value='StartPage'>
        <input type='hidden' name='command' value='Join'>
        <label>Username</label>
        <input type='text'
               name='uname' required><?php if (!empty($error_msg_signup_username)) echo $error_msg_signup_username; ?>
        <label>Password</label>
        <input type='password' name='pword' required>
        <label>Email</label>
        <input type='text' name='email' required>
        <label>Home Country</label>
        <input type="text" name='homeCountry'>
        <label>Countries Visited</label>
        <input type="text" name="countriesVisited">
        <input id="signup-modal-cancel-btn" type='button' value='Cancel' class="btn btn-secondary">
        <input id="signup-modal-submit-btn" type='submit' class="btn btn-primary">
    </form>
</div>
</body>
<script>
    $('#signin_btn').click(function () {
        $('#signin-modal').css("display", "block");
        $('#grey-blanket').css("display", "block");
    });

    $('#signin-modal-submit-btn').submit(function () {
        $.post('//cs.tru.ca/~f3kcarmichael/FinalProject/controller.php', {
                page: 'StartPage',
                command: 'SignIn'
            },
            function () {
                console.log("yo");
            });
    });

    $('#signin-modal-cancel-btn').click(function () {
        $('#grey-blanket').css("display", "none");
        $('#signin-modal').css("display", "none");
    });

    $('#grey-blanket').click(function () {
        $('#grey-blanket').css("display", "none");
        $('#signin-modal').css("display", "none");
        $('#signup-modal').css("display", "none");
    });

    $('#signup_btn').click(function () {
        $('#signup-modal').css("display", "block");
        $('#grey-blanket').css("display", "block");
    });

    $('#signup-modal-cancel-btn').click(function () {
        $('#grey-blanket').css("display", "none");
        $('#signup-modal').css("display", "none");
    });

    function show_signin() {
        $('#signin-modal').css("display", "block");
        $('#grey-blanket').css("display", "block");
    }

    function show_signup() {
        $('#signup-modal').css("display", "block");
        $('#grey-blanket').css("display", "block");
    }

    <?php
    if ($display_modal_window == 'no-modal-window') ;
    else if ($display_modal_window == 'signin') echo "show_signin();";
    else if ($display_modal_window == 'signup') echo "show_signup();";
    ?>
</script>
</html>
