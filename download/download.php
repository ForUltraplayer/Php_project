<?php
session_start();

$file_dir = 'C:\xampp\htdocs\project\data\\';

$num = $_GET["num"];
$file_index = $_GET["file"];

require_once("../lib/MYDB.php");
$pdo = db_connect();

try {
    $sql = "SELECT * FROM project.download WHERE num=?";
    $stmh = $pdo->prepare($sql);
    $stmh->bindValue(1, $num, PDO::PARAM_STR);
    $stmh->execute();

    $row = $stmh->fetch(PDO::FETCH_ASSOC);

    $file_name = $row["file_name_$file_index"];
    $file_copied = $row["file_copied_$file_index"];

    $file_path = $file_dir . $file_copied;

    // 파일 다운로드 처리
    if (file_exists($file_path)) {
        header("Content-Type: application/octet-stream");
        header("Content-Disposition: attachment; filename=\"$file_name\"");
        header("Content-Length: " . filesize($file_path));

        readfile($file_path);
    } else {
        echo "파일을 찾을 수 없습니다.";
    }

} catch (PDOException $Exception) {
    print "오류: " . $Exception->getMessage();
}
?>
