<?php
$hostname = "localhost";
$database = "pet";
$username = "root";
$password = "0000";
$charset = 'utf8mb4';

$dsn = "mysql:host=$hostname;dbname=$database;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $username, $password, $options);
    // 연결 성공 메시지를 여기에 추가합니다.
    echo "";
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

try {
    $db = new PDO($dsn, $username, $password);
    echo '';
} catch (PDOException $e) {
    echo '접속 실패 : ' . $e->getMessage();
    exit; // 연결 실패 시 종료
}

function errMsg($msg){
    echo "<script>
        window.alert('$msg');
        history.back(1);
    </script>";
    exit;
}
?>