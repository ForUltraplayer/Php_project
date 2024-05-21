<?php
session_start();
?>

<meta charset="utf-8">

<?php
if (!isset($_SESSION["userid"])) {
?>

<script>
    alert('로그인 후 이용해 주세요.');
    history.back();
</script>

<?php
}

if (isset($_REQUEST["num"])) {
    $num = $_REQUEST["num"];
} else {
    $num = "";
}

require_once("../lib/MYDB.php");

$pdo = db_connect();

try {
    $pdo->beginTransaction();
    $sql = "DELETE FROM project.qna WHERE num=?";
    $stmh = $pdo->prepare($sql);
    $stmh->bindValue(1, $num, PDO::PARAM_STR);
    $stmh->execute();
    $pdo->commit();
    header("Location: http://localhost/project/qna/list.php");
} catch (PDOException $Exception) {
    $pdo->rollBack();
    print "오류: " . $Exception->getMessage();
}
?>
