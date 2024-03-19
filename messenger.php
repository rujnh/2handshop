<?php

include 'config/connect.php';

session_start();

?>
<html>

<head>
    <meta charset="utf-8">


    <title>chat app</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style type="text/css">
    body {
        background-color: #f4f7f6;
        margin-top: 20px;
    }

    .card {
        background: #fff;
        transition: .5s;
        border: 0;
        margin-bottom: 30px;
        border-radius: .55rem;
        position: relative;
        width: 100%;
        box-shadow: 0 1px 2px 0 rgb(0 0 0 / 10%);
    }

    .chat-app .people-list {
        width: 280px;
        position: absolute;
        left: 0;
        top: 0;
        padding: 20px;
        z-index: 7
    }

    .chat-app .chat {
        margin-left: 280px;
        border-left: 1px solid #eaeaea
    }

    .people-list {
        -moz-transition: .5s;
        -o-transition: .5s;
        -webkit-transition: .5s;
        transition: .5s
    }

    .people-list .chat-list li {
        padding: 10px 15px;
        list-style: none;
        border-radius: 3px
    }

    .people-list .chat-list li:hover {
        background: #efefef;
        cursor: pointer
    }

    .people-list .chat-list li.active {
        background: #efefef
    }

    .people-list .chat-list li .name {
        font-size: 15px
    }

    .people-list .chat-list img {
        width: 45px;
        border-radius: 50%
    }

    .people-list img {
        float: left;
        border-radius: 50%
    }

    .people-list .about {
        float: left;
        padding-left: 8px
    }

    .people-list .status {
        color: #999;
        font-size: 13px
    }

    .chat .chat-header {
        padding: 15px 20px;
        border-bottom: 2px solid #f4f7f6
    }

    .chat .chat-header img {
        float: left;
        border-radius: 40px;
        width: 40px
    }

    .chat .chat-header .chat-about {
        float: left;
        padding-left: 10px
    }

    .chat .chat-history {
        padding: 20px;
        border-bottom: 2px solid #fff
    }

    .chat .chat-history ul {
        padding: 0
    }

    .chat .chat-history ul li {
        list-style: none;
        margin-bottom: 30px
    }

    .chat .chat-history ul li:last-child {
        margin-bottom: 0px
    }

    .chat .chat-history .message-data {
        margin-bottom: 15px
    }

    .chat .chat-history .message-data img {
        border-radius: 40px;
        width: 40px
    }

    .chat .chat-history .message-data-time {
        color: #434651;
        padding-left: 6px
    }

    .chat .chat-history .message {
        color: #444;
        padding: 18px 20px;
        line-height: 26px;
        font-size: 16px;
        border-radius: 7px;
        display: inline-block;
        position: relative
    }

    .chat .chat-history .message:after {
        bottom: 100%;
        left: 7%;
        border: solid transparent;
        content: " ";
        height: 0;
        width: 0;
        position: absolute;
        pointer-events: none;
        border-bottom-color: #fff;
        border-width: 10px;
        margin-left: -10px
    }

    .chat .chat-history .my-message {
        background: #efefef
    }

    .chat .chat-history .my-message:after {
        bottom: 100%;
        left: 30px;
        border: solid transparent;
        content: " ";
        height: 0;
        width: 0;
        position: absolute;
        pointer-events: none;
        border-bottom-color: #efefef;
        border-width: 10px;
        margin-left: -10px
    }

    .chat .chat-history .other-message {
        background: #e8f1f3;
        text-align: right
    }

    .chat .chat-history .other-message:after {
        border-bottom-color: #e8f1f3;
        left: 93%
    }

    .chat .chat-message {
        padding: 20px
    }

    .online,
    .offline,
    .me {
        margin-right: 2px;
        font-size: 8px;
        vertical-align: middle
    }

    .online {
        color: #86c541
    }

    .offline {
        color: #e47297
    }

    .me {
        color: #1d8ecd
    }

    .float-right {
        float: right
    }

    .clearfix:after {
        visibility: hidden;
        display: block;
        font-size: 0;
        content: " ";
        clear: both;
        height: 0
    }

    @media only screen and (max-width: 767px) {
        .chat-app .people-list {
            height: 465px;
            width: 100%;
            overflow-x: auto;
            background: #fff;
            left: -400px;
            display: none
        }

        .chat-app .people-list.open {
            left: 0
        }

        .chat-app .chat {
            margin: 0
        }

        .chat-app .chat .chat-header {
            border-radius: 0.55rem 0.55rem 0 0
        }

        .chat-app .chat-history {
            height: 300px;
            overflow-x: auto
        }
    }

    @media only screen and (min-width: 768px) and (max-width: 992px) {
        .chat-app .chat-list {
            height: 650px;
            overflow-x: auto
        }

        .chat-app .chat-history {
            height: 600px;
            overflow-x: auto
        }
    }

    @media only screen and (min-device-width: 768px) and (max-device-width: 1024px) and (orientation: landscape) and (-webkit-min-device-pixel-ratio: 1) {
        .chat-app .chat-list {
            height: 480px;
            overflow-x: auto
        }

        .chat-app .chat-history {
            height: calc(100vh - 350px);
            overflow-x: auto
        }
    }
    </style>
</head>

<body>

    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
    <div class="container">
        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card chat-app">
                    <div id="plist" class="people-list">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-search"></i></span>
                            </div>
                            <input type="text" class="form-control" placeholder="Search...">
                        </div>
                        <br />
                        <?php
// Include database connection
include 'config/connect.php';
$user_id = $_SESSION['user_id'];
$query = "SELECT m.*, u.fullname AS sender_name 
          FROM messages m 
          INNER JOIN users u ON m.sender_id = u.id 
          WHERE m.receiver_id = $user_id 
          ORDER BY m.sent_at DESC"; 

// Perform the query
$result = mysqli_query($conn, $query);

// Check if query was successful
if ($result) {
    // Loop through each row of the result set
    while ($row = mysqli_fetch_assoc($result)) {
        // Check if 'sender_id' key exists in the row array
        if (isset($row['sender_id'])) {
            // Output HTML for each message
            echo '<li class="clearfix">';
            echo '<a href="messenger.php?receiver_id='.$row['sender_id'].'">'; // แก้เป็น sender_id

            echo '<img width="40" src="https://static-00.iconduck.com/assets.00/user-icon-1024x1024-dtzturco.png" alt="avatar">';
            echo '<div class="about">';
            echo '<div class="name">' . $row['sender_name'] . '</div>';
            echo '<div class="status"> <i class="fa fa-circle online"></i> online </div>';
            echo '</div>';
            echo '</a>';
            
            echo '</li>';
        } else {
            // Handle the case where 'sender_id' is not set
            echo '<li>sender_id is not set in the row</li>';
            echo '<li>';
            print_r($row); // แสดงข้อมูลทั้งหมดในแถว
            echo '</li>';
        }
    }
} else {
    // Error handling if query fails
    echo '<li>Error retrieving messages</li>';
}



// Close database connection
mysqli_close($conn);

?>

                    </div>
                    <div class="chat">

                        <div class="chat-header clearfix">

                            <div class="row">

                                <div class="col-lg-6">
                                    <a href="javascript:void(0);" data-toggle="modal" data-target="#view_info">
                                        <img src="https://static-00.iconduck.com/assets.00/user-icon-1024x1024-dtzturco.png"
                                            alt="avatar">
                                    </a>

                                    <?php
include 'config/connect.php';

// ดึงชื่อผู้ใช้จากฐานข้อมูลโดยใช้ receiver_id
if(isset($_GET['receiver_id'])) {
    $receiver_id = $_GET['receiver_id'];
    $sqlz = "SELECT fullname FROM users WHERE id = $receiver_id";
    $result2 = $conn->query($sqlz);

    if ($result2->num_rows > 0) {
        $row = $result2->fetch_assoc();
        $receiver_fullname = $row['fullname'];
    } else {
        $receiver_fullname = "Unknown User";
    }

    // ปิดการเชื่อมต่อฐานข้อมูล
    $result2->close();
} else {
    // กรณีไม่ได้รับ receiver_id มาจาก URL
    echo "Receiver ID is not set!";
}
?>

                                    <div class="chat-about">
                                        <h6 class="m-b-0"><?php echo $receiver_fullname; ?></h6>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="chat-history">
                            <ul class="m-b-0">
                                <?php if(!empty($_GET['receiver_id'])){  ?>

                                
                                <?php } ?>

                            </ul>
                        </div>
                        <div class="chat-message clearfix">
                            <div class="input-group mb-0">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-send"></i></span>
                                </div>
                                <input id="message-input" type="text" class="form-control"
                                    placeholder="Enter text here...">
                                <div class="input-group-append">
                                    <button id="send-button" class="btn btn-primary" type="button">Send</button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(document).ready(function() {







        getMessages("<?php echo $_SESSION["user_id"]; ?>", "<?php echo $_GET["receiver_id"]; ?>");

        setInterval(function() {
            getMessages("<?php echo $_SESSION["user_id"]; ?>", "<?php echo $_GET["receiver_id"]; ?>");

        }, 3000);
        // ฟังก์ชันสำหรับดึงข้อมูลข้อความ
        function getMessages(sender_id, receiver_id) {
            $.ajax({
                type: 'GET',
                url: 'action/chat.php', // เปลี่ยนเป็น URL ของ API ที่สร้างขึ้น
                data: {
                    sender_id: sender_id,
                    receiver_id: receiver_id

                },
                success: function(response) {
                    // กระตุ้นฟังก์ชันสำหรับแสดงข้อความที่ได้รับ

                    displayMessages(response, sender_id);
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        }

        // ฟังก์ชันสำหรับแสดงข้อความ
        function displayMessages(messages, sender_id) {
            console.log(messages)
            // แปลงข้อมูล JSON เป็น array
            var messageArray = JSON.parse(messages);
            // ตรวจสอบว่ามีข้อความหรือไม่
            if (messageArray.length > 0) {
                // ล้างข้อมูลเก่าที่มีอยู่ในช่องแสดงข้อความ
                $('.chat-history ul').empty();

                // วนลูปเพื่อสร้างแถวของข้อความ
                messageArray.forEach(function(message) {
                    console.log(message)
                    // สร้าง HTML สำหรับแถวข้อความ
                    var messageHtml = '<li class="clearfix">';
                    messageHtml += '<div class="message-data text-' + (message.sender_id == sender_id ?
                        'right' : 'left') + '">';
                    messageHtml += '<span class="message-data-time">' + message.sent_at + '</span>';
                    messageHtml +=
                        '<img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="avatar">';
                    messageHtml += '</div>';
                    messageHtml += '<div class="message ' + (message.sender_id == sender_id ?
                            'my-message float-right' : 'other-message float-left') + '">' + message
                        .message_text + '</div>';
                    messageHtml += '</li>';

                    // เพิ่มแถวข้อความลงในแสดงข้อความ
                    $('.chat-history ul').append(messageHtml);
                });
            }
        }

        $('#send-button').click(function() {
            // รับค่าจากฟอร์ม
            var sender_id = '<?php echo $_SESSION["user_id"]; ?>';
            var receiver_id = '<?php echo $_GET["receiver_id"]; ?>';
            var message_text = $('#message-input').val();

            // เรียกใช้งานฟังก์ชันส่งข้อความ
            sendMessage(sender_id, receiver_id, message_text);

            // เคลียร์ค่าใน input
            $('#message-input').val('');
        });

        function sendMessage(sender_id, receiver_id, message_text) {
            $.ajax({
                type: 'POST',
                url: 'action/chat.php', // เปลี่ยนเป็น URL ของ API ที่สร้างขึ้น
                data: {
                    sender_id: sender_id,
                    receiver_id: receiver_id,
                    message_text: message_text
                },
                success: function(response) {
                    // กระตุ้นฟังก์ชันสำหรับดึงข้อมูลข้อความใหม่หลังจากส่งข้อความเสร็จสมบูรณ์
                    getMessages(sender_id, receiver_id);
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        }

        // // เรียกใช้งานฟังก์ชันเพื่อดึงข้อความเมื่อหน้าเว็บโหลดเสร็จสมบูรณ์
        // getMessages(sender_id, receiver_id);

        // // ฟังก์ชันสำหรับการส่งข้อความเมื่อกดปุ่ม Enter ในช่องกรอกข้อความ
        // $('.chat-message input').keypress(function(event) {
        //     if (event.which === 13) {
        //         // ส่งข้อความเมื่อกดปุ่ม Enter
        //         sendMessage(sender_id, receiver_id, $(this).val());
        //         // เคลียร์ข้อความในช่องกรอกข้อความ
        //         $(this).val('');
        //     }
        // });
    });
    </script>
    // <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript">

    </script>
</body>

</html>