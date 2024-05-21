<?php

$num = $_REQUEST["num"];
$ripple_num = $_REQUEST["ripple_num"];

require_once("../lib/MYDB.php");
$pdo = db_connect();

try {
    $pdo->beginTransaction();

    $sql = "DELETE FROM project.debate_ripple WHERE num = ?";
    $stmh = $pdo->prepare($sql);
    $stmh->bindValue(1,$ripple_num,PDO::PARAM_STR);
    $stmh->execute();

    $pdo->commit();

    header("Location:http://localhost/project/debate/view.php?num=$num");
} catch (Exception $ex) {
    $pdo->rollBack();
    print "오류: " . $Exception->getMessage();
}
?>
