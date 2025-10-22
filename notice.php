<?php
session_start();

$file = "notice.txt";

// 로그인 여부 확인 (login.htm → main.htm 넘어올 때 세션 처리 추가 필요)
if (!isset($_SESSION['id'])) {
    http_response_code(403);
    echo "로그인 필요";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 관리자만 저장 가능
    if ($_SESSION['id'] === 'admin') {
        $content = $_POST['content'] ?? "";
        file_put_contents($file, $content);
        echo "저장 완료";
    } else {
        http_response_code(403);
        echo "권한 없음";
    }
} else {
    // 읽기 (누구나 가능)
    if (file_exists($file)) {
        echo file_get_contents($file);
    } else {
        echo "공지 없음";
    }
}
?>