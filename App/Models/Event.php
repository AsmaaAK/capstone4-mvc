<?php
require 'db.php';

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    $stmt = $pdo->query("SELECT * FROM events");
    echo json_encode(['status'=>'success','data'=>$stmt->fetchAll(PDO::FETCH_ASSOC)]);
    exit;
}

if ($method === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    if (!$data || !isset($data['name']) || !isset($data['required_skills'])) {
        http_response_code(400);
        echo json_encode(['status'=>'error','message'=>'بيانات ناقصة']);
        exit;
    }
    $stmt = $pdo->prepare("INSERT INTO events (name, required_skills, location, event_time) VALUES (?,?,?,?)");
    $stmt->execute([$data['name'], $data['required_skills'], $data['location'], $data['event_time']]);
    echo json_encode(['status'=>'success','message'=>'تم إضافة الفعالية']);
    exit;
}

if ($method === 'DELETE') {
    if (!isset($_GET['id'])) {
        http_response_code(400);
        echo json_encode(['status'=>'error','message'=>'رقم الفعالية مطلوب']);
        exit;
    }
    $stmt = $pdo->prepare("DELETE FROM events WHERE id=?");
    $stmt->execute([$_GET['id']]);
    echo json_encode(['status'=>'success','message'=>'تم حذف الفعالية']);
    exit;
}
