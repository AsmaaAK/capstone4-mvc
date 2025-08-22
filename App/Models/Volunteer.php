<?php
require 'db.php';

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    $stmt = $pdo->query("SELECT * FROM volunteers");
    echo json_encode(['status'=>'success','data'=>$stmt->fetchAll(PDO::FETCH_ASSOC)]);
    exit;
}

if ($method === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    if (!$data || !isset($data['name']) || !isset($data['skills'])) {
        http_response_code(400);
        echo json_encode(['status'=>'error','message'=>'بيانات ناقصة']);
        exit;
    }
    $stmt = $pdo->prepare("INSERT INTO volunteers (name, skills, location, available_time) VALUES (?,?,?,?)");
    $stmt->execute([$data['name'], $data['skills'], $data['location'], $data['available_time']]);
    echo json_encode(['status'=>'success','message'=>'تم إضافة المتطوع']);
    exit;
}

if ($method === 'DELETE') {
    if (!isset($_GET['id'])) {
        http_response_code(400);
        echo json_encode(['status'=>'error','message'=>'رقم المتطوع مطلوب']);
        exit;
    }
    $stmt = $pdo->prepare("DELETE FROM volunteers WHERE id=?");
    $stmt->execute([$_GET['id']]);
    echo json_encode(['status'=>'success','message'=>'تم حذف المتطوع']);
    exit;
}
