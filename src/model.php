<?php
$conn = mysqli_connect('localhost', 'f3kcarmichael', 'f3kcarmichael136', 'C354_f3kcarmichael');

function user_valid($u, $p) {
    global $conn;
    $sql = "SELECT * FROM ForumUsers WHERE Username = '$u' AND Password = '$p'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        return true;
    }
    else {
        return false;
    }
}

function user_exists($u) {
    global $conn;
    $sql = "SELECT * FROM ForumUsers WHERE Username = '$u'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0){
        return true;
    }
    else {
        return false;
    }
}

function signup_user($u, $p, $e, $h, $v) {
    global $conn;
    $current_date = date('Ymd');
    $sql = "INSERT INTO ForumUsers (Id, Email, Password, Username, Date, Hometown, VisitedCountries) VALUES (NULL, '$e', '$p', '$u', '$current_date', '$h', '$v')";
    return mysqli_query($conn, $sql);
}

function get_user_info($u) {
    global $conn;
    $sql = "SELECT Hometown, VisitedCountries FROM ForumUsers WHERE Username = '$u' LIMIT 1";
    $result = mysqli_query($conn, $sql);

    return mysqli_fetch_assoc($result);
}

function update_a_user($h, $v, $u) {
    global $conn;
    $sql = "UPDATE ForumUsers SET Hometown = '$h', VisitedCountries = '$v' WHERE Username = '$u'";
    return mysqli_query($conn, $sql);
}

function delete_a_user($u) {
    global $conn;
    $sql = "DELETE FROM ForumUsers WHERE Username = '$u'";
    return mysqli_query($conn, $sql);
}

function post_a_topic($t, $u) {
    global $conn;
    $current_date = date("Ymd");
    $sql = "INSERT INTO Topics (Id, Topic, Username, Date) VALUES (NULL, '$t', '$u', '$current_date');";
    mysqli_query($conn, $sql);

    $id = mysqli_insert_id($conn);
    $sql = "SELECT * FROM Topics WHERE Id = '$id' LIMIT 1";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_assoc($result);
}

function post_a_reply($r, $u, $t) {
    global $conn;
    $current_date = date("Ymd");
    $sql = "INSERT INTO Replies (Id, Reply, Username, Date, TopicId) VALUES (NULL, '$r', '$u', '$current_date', '$t');";
    mysqli_query($conn, $sql);

    $id = mysqli_insert_id($conn);
    $sql = "SELECT * FROM Replies WHERE Id = '$id' LIMIT 1";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_assoc($result);
}

function delete_a_topic($id) {
    global $conn;
    $sql = "DELETE FROM Topics WHERE Id = '$id';";
    return mysqli_query($conn, $sql);
}

function delete_a_reply($id) {
    global $conn;
    $sql = "DELETE FROM Replies WHERE Id = '$id'";
    return mysqli_query($conn, $sql);
}

function edit_a_topic($id, $t) {
    global $conn;
    $sql = "UPDATE Topics SET Topic = '$t' WHERE Id = '$id'";
    return mysqli_query($conn, $sql);
}

function edit_a_reply($id, $r) {
    global $conn;
    $sql = "UPDATE Replies SET Reply = '$r' WHERE Id = '$id'";
    return mysqli_query($conn, $sql);
}

function get_all_topics() {
    global $conn;
    $sql = "SELECT * FROM Topics";
    $result = mysqli_query($conn, $sql);

    $data = array();
    while ($row = mysqli_fetch_assoc($result))
        $data[] = $row;
    return $data;
}

function get_all_replies($id) {
    global $conn;
    $sql = "SELECT * FROM Replies WHERE TopicId = '$id'";
    $result = mysqli_query($conn, $sql);

    $data = array();
    while ($row = mysqli_fetch_assoc($result))
        $data[] = $row;
    return $data;
}
?>
