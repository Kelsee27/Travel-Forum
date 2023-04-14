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

        #top_btns > button {
            margin: 15px;
            width: 30%;
        }

        label {
            display: inline-block;
            width: 150px;
            margin: 10px;
        }

        input {
            margin: 10px;
        }

        .topic {
            border: 2px black solid;
            border-radius: 2% 10%;
            background: bisque;
            margin: 20px;
        }

        .topic > p {
            padding: 5px;
            margin: 10px;
        }

        .topic button {
            margin: 15px;
        }

        .reply {
            border: 2px black solid;
            border-radius: 10% 2%;
            background: lightblue;
            margin: 20px 20px 20px 100px;
        }

        .reply > p {
            padding: 5px;
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
        <h2 style='text-align:center;height:50px;background-color: lightblue;padding: 10px;margin-bottom: 0;margin-top: 0;'>
            Hello <?php echo $username; ?></h2>
        <h4 id="user_home_country"
            style='height:50px;background-color: lightblue;padding: 10px;margin-bottom: 0;margin-top: 0'>My Home
            Country: <?php echo $_SESSION['home_country']; ?></h4>
        <h4 id="user_countries_visited"
            style='height:50px;background-color: lightblue;padding: 10px;margin-bottom: 0;margin-top: 0'>My Visited
            Countries: <?php echo $_SESSION['countries_visited']; ?></h4>
    </div>
    <div id="top_btns">
        <button id="edit_profile_btn" class="btn btn-primary">Edit Profile</button>
        <button id="create_post_btn" class="btn btn-primary">Create a Post</button>
        <button id="logout_btn" class="btn btn-primary">Logout</button>
    </div>
    <div id="topics_pane"></div>
</div>

<form id='signout-form' method='POST' action='controller.php' style='display:none'>
    <input type='hidden' name='page' value='MainPage'>
    <input type='hidden' name='command' value='SignOut'>
</form>

<!-- Edit User Profile Modal -->
<div class="modal" id="edit-user-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit User Profile</h5>
            </div>
            <div class="modal-body">
                <label>Home Country</label>
                <input id='edit-user-home-country-input' type='text' name='user-home-country'
                       value="<?php echo $_SESSION['home_country']; ?>">
                <label>Countries Visited</label>
                <input id='edit-user-visited-countries-input' type='text' name='user-visited-countries'
                       value="<?php echo $_SESSION['countries_visited']; ?>">
            </div>
            <div class="modal-footer">
                <button id="delete-user-btn" type="button" class="btn btn-danger">Delete My Account</button>
                <button id="edit-user-modal-cancel-btn" type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    Close
                </button>
                <button id="edit-user-submit-btn" type="button" class="btn btn-primary" data-bs-dismiss="modal">Submit
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Post a Topic Modal -->
<div class="modal" id="post-topic-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Post a Topic</h5>
            </div>
            <div class="modal-body">
                <input id='post-topic-input' type='text' name='topic' placeholder='Topic'>
            </div>
            <div class="modal-footer">
                <button id="topic-modal-cancel-btn" type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    Close
                </button>
                <button id="post-topic-submit-btn" type="button" class="btn btn-primary" data-bs-dismiss="modal">
                    Submit
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Post Reply Modal -->
<div class="modal" id="post-reply-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Post a Reply</h5>
            </div>
            <div class="modal-body">
                <input id='post-reply-input' type='text' name='reply' placeholder='Reply'>
            </div>
            <div class="modal-footer">
                <button id="post-reply-cancel-btn" type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    Close
                </button>
                <button id="post-reply-submit-btn" type="button" class="btn btn-primary" data-bs-dismiss="modal">
                    Submit
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Edit a Topic Modal -->
<div class="modal" id="edit-topic-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit a Topic</h5>
            </div>
            <div class="modal-body">
                <input id='edit-topic-input' type='text' name='topic' placeholder='Topic'>
            </div>
            <div class="modal-footer">
                <button id="edit-topic-cancel-btn" type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    Close
                </button>
                <button id="edit-topic-submit-btn" type="button" class="btn btn-primary" data-bs-dismiss="modal">
                    Submit
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Edit a Reply Modal -->
<div class="modal" id="edit-reply-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit a Reply</h5>
            </div>
            <div class="modal-body">
                <input id='edit-reply-input' type='text' name='reply' placeholder='Reply'>
            </div>
            <div class="modal-footer">
                <button id="edit-reply-cancel-btn" type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    Close
                </button>
                <button id="edit-reply-submit-btn" type="button" class="btn btn-primary" data-bs-dismiss="modal">
                    Submit
                </button>
            </div>
        </div>
    </div>
</div>

</body>
<?php
if (empty($_SESSION['signedin'])) {
    $display_modal_window = 'none';
    include('view_startpage.php');
    exit();
}
?>
<script>
    //Load initial topic data
    $(document).ready(function () {
        $.post('//cs.tru.ca/~f3kcarmichael/FinalProject/controller.php', {
            page: 'MainPage',
            command: 'GetTopics'
        }, function (data) {
            arr = JSON.parse(data);
            $.each(arr, function (key, value) {
                createPost(value);
                getReplies(value.Id);
            });
        })
    });

    //Load initial reply data
    function getReplies(id) {
        $.post('//cs.tru.ca/~f3kcarmichael/FinalProject/controller.php', {
            page: 'MainPage',
            command: 'GetReplies',
            topicId: id
        }, function (data) {
            arr = JSON.parse(data);
            $.each(arr, function (key, value) {
                createReply(value);
            });
        })
    }

    //timeout
    document.getElementById("logout_btn").addEventListener('click', timeout);

    var timer2 = setTimeout(timeout, 20 * 10000);
    window.addEventListener('mousemove', event_listener_mousemove);

    function event_listener_mousemove() {
        clearTimeout(timer2);
        timer = setTimeout(timeout, 20 * 10000);
    }

    function timeout() {
        clearTimeout(timer2);
        window.removeEventListener('mousemove', event_listener_mousemove);
        document.getElementById('signout-form').submit();
    }

    //Edit User Functionality
    $('#edit_profile_btn').click(function () {
        $('#edit-user-modal').css("display", "block");
        $('#grey-blanket').css("display", "block");
    });

    $('#edit-user-modal-cancel-btn').click(function () {
        $('#edit-user-modal').css("display", "none");
        $('#grey-blanket').css("display", "none");
    });

    $('#edit-user-submit-btn').click(function () {
        $.post('//cs.tru.ca/~f3kcarmichael/FinalProject/controller.php', {
            page: 'MainPage',
            command: 'EditAUser',
            homeCountry: $('#edit-user-home-country-input').val(),
            visitedCountries: $('#edit-user-visited-countries-input').val()
        }, function (data) {
            const response = data.split("<br>");
            $('#user_home_country').html("My Home Country: " + response[0]);
            $('#user_countries_visited').html("My Visited Countries: " + response[1]);
            $('#edit-user-modal').css("display", "none");
            $('#grey-blanket').css("display", "none");
        })
    });

    $('#delete-user-btn').click(function () {
        $.post('//cs.tru.ca/~f3kcarmichael/FinalProject/controller.php', {
            page: 'MainPage',
            command: 'DeleteUser'
        }, function () {
            timeout();
        })
    });

    //Create a post
    $('#create_post_btn').click(function () {
        $('#post-topic-modal').css("display", "block");
        $('#grey-blanket').css("display", "block");
    });

    $('#topic-modal-cancel-btn').click(function () {
        $('#post-topic-modal').css("display", "none");
        $('#grey-blanket').css("display", "none");
    });

    $('#post-topic-submit-btn').click(function () {
        $.post('//cs.tru.ca/~f3kcarmichael/FinalProject/controller.php', {
            page: 'MainPage',
            command: 'PostATopic',
            topic: $('#post-topic-input').val()
        }, function (data) {
            const obj = JSON.parse(data);
            createPost(obj);
            $('#post-topic-modal').css("display", "none");
            $('#grey-blanket').css("display", "none");
        })
    });

    function createPost(obj) {
        const div = document.createElement("div");
        div.id = "Topic_" + obj.Id;
        div.className = "topic";
        const topic = document.createElement("p");
        topic.innerHTML = obj.Topic;
        topic.style.fontWeight = "bold";
        const username = document.createElement("p");
        username.innerHTML = "Username: " + obj.Username;
        const date = document.createElement("p");
        date.innerHTML = "Date: " + obj.Date;
        date.style.fontSize = ".8em";
        const replyBtn = document.createElement("button");
        replyBtn.className = "btn btn-primary";
        var replyText = document.createTextNode("Reply");
        replyBtn.appendChild(replyText);
        replyBtn.type = "button";
        replyBtn.setAttribute("reply-topic-btn-id", obj.Id);

        div.appendChild(topic);
        div.append(username);
        div.append(date);
        div.append(replyBtn);

        const user = '<?php echo $username;?>';
        if (user === obj.Username) {
            const deleteBtn = document.createElement("button");
            deleteBtn.type = "button";
            deleteBtn.className = "btn btn-danger";
            var deleteText = document.createTextNode("Delete");
            deleteBtn.appendChild(deleteText);
            deleteBtn.setAttribute("delete-topic-btn-id", obj.Id);
            const editBtn = document.createElement("button");
            editBtn.className = "btn btn-primary";
            editBtn.type = "button";
            var editText = document.createTextNode("Edit");
            editBtn.appendChild(editText);
            editBtn.setAttribute("edit-topic-btn-id", obj.Id);

            div.append(deleteBtn);
            div.append(editBtn);
        }

        $('#topics_pane').prepend(div);
        deletePostListener();
        createReplyListener();
        editPostListener();
    }

    function deletePostListener() {
        $('button[delete-topic-btn-id]').click(function () {
            const topic_id = $(this).attr('delete-topic-btn-id');
            $.post('//cs.tru.ca/~f3kcarmichael/FinalProject/controller.php', {
                page: 'MainPage',
                command: 'DeleteATopic',
                topicId: $(this).attr('delete-topic-btn-id')
            }, function () {
                const topicSelector = '#Topic_' + topic_id;
                $(topicSelector).remove();
            })
        });
    }

    function editPostListener() {
        $('button[edit-topic-btn-id]').click(function () {
            $('#edit-topic-modal').css("display", "block");
            $('#grey-blanket').css("display", "block");
            $('#edit-topic-submit-btn').attr("edit-topic-submit-btn-id", $(this).attr('edit-topic-btn-id'));
        });
    }

    $('#edit-topic-submit-btn').click(function () {
        const topic_id = $(this).attr('edit-topic-submit-btn-id');
        $.post('//cs.tru.ca/~f3kcarmichael/FinalProject/controller.php', {
            page: 'MainPage',
            command: 'EditATopic',
            topicId: topic_id,
            topic: $('#edit-topic-input').val()
        }, function (data) {
            const topicSelector = '#Topic_' + topic_id + ' > p:first-of-type';
            $(topicSelector).html(data);
            $('#edit-topic-modal').css("display", "none");
            $('#grey-blanket').css("display", "none");
        })
    });

    $('#edit-topic-cancel-btn').click(function () {
        $('#edit-topic-modal').css("display", "none");
        $('#grey-blanket').css("display", "none");
    });

    function createReplyListener() {
        $('button[reply-topic-btn-id]').click(function () {
            $('#post-reply-modal').css("display", "block");
            $('#grey-blanket').css("display", "block");
            $('#post-reply-submit-btn').attr("reply-submit-btn-id", $(this).attr('reply-topic-btn-id'));
        });
    }

    //Create Reply
    function createReply(obj) {
        const div = document.createElement("div");
        div.id = "Reply_" + obj.Id;
        div.className = "reply";
        const reply = document.createElement("p");
        reply.innerHTML = obj.Reply;
        reply.style.fontWeight = "bold";
        const username = document.createElement("p");
        username.innerHTML = "Username: " + obj.Username;
        const date = document.createElement("p");
        date.innerHTML = "Date: " + obj.Date;
        date.style.fontSize = ".8em";

        div.appendChild(reply);
        div.append(username);
        div.append(date);

        const user = '<?php echo $username;?>';
        if (user === obj.Username) {
            const deleteBtn = document.createElement("button");
            deleteBtn.type = "button";
            deleteBtn.className = "btn btn-danger";
            var deleteText = document.createTextNode("Delete");
            deleteBtn.appendChild(deleteText);
            deleteBtn.setAttribute("delete-reply-btn-id", obj.Id);
            const editBtn = document.createElement("button");
            editBtn.className = "btn btn-primary";
            editBtn.type = "button";
            var editText = document.createTextNode("Edit");
            editBtn.appendChild(editText);
            editBtn.setAttribute("edit-reply-btn-id", obj.Id);

            div.append(deleteBtn);
            div.append(editBtn);
        }

        const topic = '#Topic_' + obj.TopicId;
        $(topic).append(div);
        deleteReplyListener();
        editReplyListener();
    }

    function deleteReplyListener() {
        $('button[delete-reply-btn-id]').click(function () {
            const reply_id = $(this).attr('delete-reply-btn-id');
            $.post('//cs.tru.ca/~f3kcarmichael/FinalProject/controller.php', {
                page: 'MainPage',
                command: 'DeleteAReply',
                replyId: $(this).attr('delete-reply-btn-id')
            }, function () {
                const replySelector = '#Reply_' + reply_id;
                $(replySelector).remove();
            })
        });
    }

    function editReplyListener() {
        $('button[edit-reply-btn-id]').click(function () {
            $('#edit-reply-modal').css("display", "block");
            $('#grey-blanket').css("display", "block");
            $('#edit-reply-submit-btn').attr("edit-reply-submit-btn-id", $(this).attr('edit-reply-btn-id'));
        });
    }

    $('#edit-reply-submit-btn').click(function () {
        const replyId = $(this).attr('edit-reply-submit-btn-id');
        $.post('//cs.tru.ca/~f3kcarmichael/FinalProject/controller.php', {
            page: 'MainPage',
            command: 'EditAReply',
            replyId: replyId,
            reply: $('#edit-reply-input').val()
        }, function (data) {
            const replySelector = '#Reply_' + replyId + ' > p:first-of-type';
            $(replySelector).html(data);
            $('#edit-reply-modal').css("display", "none");
            $('#grey-blanket').css("display", "none");
        })
    });

    $('#edit-reply-cancel-btn').click(function () {
        $('#edit-reply-modal').css("display", "none");
        $('#grey-blanket').css("display", "none");
    });

    $('#post-reply-submit-btn').click(function () {
        const topicId = $(this).attr('reply-submit-btn-id');
        $.post('//cs.tru.ca/~f3kcarmichael/FinalProject/controller.php', {
            page: 'MainPage',
            command: 'PostAReply',
            topicId: topicId,
            reply: $('#post-reply-input').val()
        }, function (data) {
            const obj = JSON.parse(data);
            createReply(obj);
            $('#post-reply-modal').css("display", "none");
            $('#grey-blanket').css("display", "none");
        })
    });

    $('#post-reply-cancel-btn').click(function () {
        $('#post-reply-modal').css("display", "none");
        $('#grey-blanket').css("display", "none");
    });

</script>
</html>