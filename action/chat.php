<?php
// เชื่อมต่อกับฐานข้อมูล
include '../config/connect.php';

// ตรวจสอบว่ามีการส่งคำขอ GET มาหรือไม่
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // ตรวจสอบว่ามีพารามิเตอร์ sender_id และ receiver_id ถูกส่งมาหรือไม่
    if (isset($_GET['sender_id']) && isset($_GET['receiver_id'])) {
        $sender_id = $_GET['sender_id'];
        $receiver_id = $_GET['receiver_id'];

        // สร้างคำสั่ง SQL เพื่อดึงข้อความระหว่าง sender_id และ receiver_id
        $sql = "SELECT * FROM messages WHERE (sender_id = $sender_id AND receiver_id = $receiver_id) OR (sender_id = $receiver_id AND receiver_id = $sender_id) ORDER BY sent_at ASC";

        // ทำการ query ข้อมูล
        $result = $conn->query($sql);

        // ตรวจสอบว่ามีข้อมูลหรือไม่
        if ($result->num_rows > 0) {
            // สร้าง array เพื่อเก็บข้อมูลข้อความ
            $messages = array();

            // วนลูปเพื่อดึงข้อมูลทุกแถว
            while ($row = $result->fetch_assoc()) {
                // เพิ่มข้อมูลข้อความลงใน array
                $messages[] = array(
                    'message_id' => $row['message_id'],
                    'sender_id' => $row['sender_id'],
                    'receiver_id' => $row['receiver_id'],
                    'message_text' => $row['message_text'],
                    'sent_at' => $row['sent_at']
                );
            }

            // แปลง array เป็น JSON และส่งกลับไปยัง client
            echo json_encode($messages);
        } else {
            // ถ้าไม่มีข้อความที่พบ
            echo json_encode(array('message' => 'No messages found'));
        }
    } else {
        // ถ้าไม่มีพารามิเตอร์ sender_id หรือ receiver_id ที่ถูกส่งมา
        echo json_encode(array('message' => 'Sender ID and receiver ID are required'));
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // ตรวจสอบว่ามีการส่งคำขอ POST มาหรือไม่
    // ตรวจสอบว่ามีข้อมูลที่จำเป็นสำหรับการสร้างข้อความหรือไม่
    if (isset($_POST['sender_id']) && isset($_POST['receiver_id']) && isset($_POST['message_text'])) {
        $sender_id = $_POST['sender_id'];
        $receiver_id = $_POST['receiver_id'];
        $message_text = $_POST['message_text'];

        // เพิ่มข้อความใหม่ลงในฐานข้อมูล
        $sql = "INSERT INTO messages (sender_id, receiver_id, message_text) VALUES ($sender_id, $receiver_id, '$message_text')";

        if ($conn->query($sql) === TRUE) {
            // ถ้าสำเร็จให้ส่งข้อความคำตอบกลับไปยัง client
            echo json_encode(array('message' => 'Message sent successfully'));
        } else {
            // ถ้าเกิดข้อผิดพลาดในการส่งข้อความ
            echo json_encode(array('message' => 'Failed to send message: ' . $conn->error));
        }
    } else {
        // ถ้าข้อมูลไม่ครบถ้วน
        echo json_encode(array('message' => 'Sender ID, receiver ID, and message text are required'));
    }
} else {
    // ถ้าไม่ใช่เมธอด GET หรือ POST
    echo json_encode(array('message' => 'Invalid request method'));
}

// ปิดการเชื่อมต่อกับฐานข้อมูล
$conn->close();
?>
