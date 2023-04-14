<?php

if (empty($_POST['page'])) {
    $display_modal_window = 'no-modal-window';
    include("view_startpage.php");
    exit();
}

include("model.php");

$page = $_POST['page'];
if ($page == 'StartPage') {
    $command = $_POST['command'];
    switch($command) {
        case 'SignIn':
            $username = $_POST['username'];
            $password = $_POST['password'];
            if (user_valid($username, $password)) {
                setcookie('username', $username, time() + 24 * 60 * 60);
                session_start();
                $_SESSION['signedin'] = 'YES';
                $_SESSION['username'] = $username;
                $data = get_user_info($username);
                $_SESSION['home_country'] = $data['Hometown'];
                $_SESSION['countries_visited'] = $data['VisitedCountries'];
                include('view_mainpage.php');
            }
            else {
                $error_msg_signin_username = '* Wrong username, or';
                $error_msg_signin_password = '* Wrong password';
                $display_modal_window = 'signin';
                include('view_startpage.php');
            }
            break;
        case 'Join':
            if (user_exists($_POST['uname'])) {
                $error_msg_signup_username = '* Sorry, username is taken. Try again.';
                $display_modal_window = 'signup';
                include('view_startpage.php');
            }
            else {
                signup_user($_POST['uname'], $_POST['pword'], $_POST['email'], $_POST['homeCountry'], $_POST['countriesVisited']);
                $display_modal_window = 'signin';
                include('view_startpage.php');
            }
            exit();
    }
}
else if ($page == 'MainPage') {
    session_start();

    if (!isset($_SESSION['signedin'])) {
        $display_modal_window = 'none';
        include('view_startpage.php');
        exit();
    }

    $username = $_SESSION['username'];
    $command = $_POST['command'];
    switch ($command) {
        case 'GetTopics':
            $data = get_all_topics();
            echo json_encode($data);
            break;
        case 'GetReplies':
            $data = get_all_replies($_POST['topicId']);
            echo json_encode($data);
            break;
        case 'SignOut':
            session_unset();
            session_destroy();
            $display_modal_window = 'none';
            include('view_startpage.php');
            break;
        case 'EditAUser':
            $result = update_a_user($_POST['homeCountry'], $_POST['visitedCountries'], $_SESSION['username']);
            if ($result)
                echo $_POST['homeCountry'] . "<br>" . $_POST['visitedCountries'];
            else
                echo "Error<br>";
            break;
        case 'DeleteUser':
            delete_a_user($_SESSION['username']);
            break;
        case 'PostATopic':
            $data = post_a_topic($_POST['topic'], $_SESSION['username']);
            echo json_encode($data);
            break;
        case 'PostAReply':
            $data = post_a_reply($_POST['reply'], $_SESSION['username'], $_POST['topicId']);
            echo json_encode($data);
            break;
        case 'DeleteATopic':
            delete_a_topic($_POST['topicId']);
            break;
        case "DeleteAReply":
            delete_a_reply($_POST['replyId']);
            break;
        case 'EditATopic':
            $data = edit_a_topic($_POST['topicId'], $_POST['topic']);
            echo $_POST['topic'];
            break;
        case "EditAReply":
            $data = edit_a_reply($_POST['replyId'], $_POST['reply']);
            echo $_POST['reply'];
            break;
    }
}
?>
