<?php
session_start();

if (!isset($_SESSION["userid"])) {
    echo "<script>
            alert('로그인 후 이용해 주세요.');
            history.back();
          </script>";
    exit;
}

$page = isset($_REQUEST["page"]) ? $_REQUEST["page"] : "";
$mode = isset($_REQUEST["mode"]) ? $_REQUEST["mode"] : "";
$num = isset($_REQUEST["num"]) ? $_REQUEST["num"] : "";

$html_ok = isset($_REQUEST["html_ok"]) ? $_REQUEST["html_ok"] : "";
$subject = $_REQUEST["subject"];
$content = $_REQUEST["content"];

require_once("../lib/MYDB.php");
$pdo = db_connect();

if ($mode == "modify") {
    try {
        $pdo->beginTransaction();
        $sql = "UPDATE project.qna SET subject=?, content=?, is_html=? WHERE num=?";
        $stmh = $pdo->prepare($sql);
        $stmh->bindValue(1, $subject, PDO::PARAM_STR);
        $stmh->bindValue(2, $content, PDO::PARAM_STR);
        $stmh->bindValue(3, $html_ok, PDO::PARAM_STR);
        $stmh->bindValue(4, $num, PDO::PARAM_STR);
        $stmh->execute();
        $pdo->commit();

        header("Location: http://localhost/project/qna/list.php?page=$page");
        exit;
    } catch (PDOException $Exception) {
        $pdo->rollBack();
        print "오류: " . $Exception->getMessage();
    }
} else {
    if ($html_ok == "y") {
        $is_html = "y";
    } else {
        $is_html = "";
        $content = htmlspecialchars($content);
    }

    if ($mode == "response") {
        try {
            $sql = "SELECT * FROM project.qna WHERE num = ?";
            $stmh = $pdo->prepare($sql);
            $stmh->bindValue(1, $num, PDO::PARAM_STR);
            $stmh->execute();

            $row = $stmh->fetch(PDO::FETCH_ASSOC);
            $group_num = $row["group_num"];
            $depth = $row["depth"] + 1;
            $ord = $row["ord"] + 1;

            $pdo->beginTransaction();
            $sql = "UPDATE project.qna SET ord = ord + 1 WHERE group_num = ? AND ord > ?";
            $stmh = $pdo->prepare($sql);
            $stmh->bindValue(1, $row["group_num"], PDO::PARAM_STR);
            $stmh->bindValue(2, $row["ord"], PDO::PARAM_STR);
            $stmh->execute();
            $pdo->commit();

            $pdo->beginTransaction();
            $sql = "INSERT INTO project.qna(group_num, depth, ord, id, name, nick, subject, content, regist_day, hit, is_html) ";
            $sql .= "VALUES(?, ?, ?, ?, ?, ?, ?, ?, now(), 0, ?)";
            $stmh = $pdo->prepare($sql);
            $stmh->bindValue(1, $group_num, PDO::PARAM_STR);
            $stmh->bindValue(2, $depth, PDO::PARAM_STR);
            $stmh->bindValue(3, $ord, PDO::PARAM_STR);
            $stmh->bindValue(4, $_SESSION["userid"], PDO::PARAM_STR);
            $stmh->bindValue(5, $_SESSION["name"], PDO::PARAM_STR);
            $stmh->bindValue(6, $_SESSION["nick"], PDO::PARAM_STR);
            $stmh->bindValue(7, $subject, PDO::PARAM_STR);
            $stmh->bindValue(8, $content, PDO::PARAM_STR);
            $stmh->bindValue(9, $is_html, PDO::PARAM_STR);
            $stmh->execute();
            $pdo->commit();

            header("Location: http://localhost/project/qna/list.php?page=$page");
            exit;
        } catch (PDOException $Exception) {
            $pdo->rollBack();
            print "오류: " . $Exception->getMessage();
        }
    } else {
        $depth = 0;
        $ord = 0;

        try {
            $pdo->beginTransaction();
            $sql = "INSERT INTO project.qna(depth, ord, id, name, nick, subject, content, regist_day, hit, is_html)
                    VALUES(?, ?, ?, ?, ?, ?, ?, now(), 0, ?)";
            $stmh = $pdo->prepare($sql);
            $stmh->bindValue(1, $depth, PDO::PARAM_STR);
            $stmh->bindValue(2, $ord, PDO::PARAM_STR);
            $stmh->bindValue(3, $_SESSION["userid"], PDO::PARAM_STR);
            $stmh->bindValue(4, $_SESSION["name"], PDO::PARAM_STR);
            $stmh->bindValue(5, $_SESSION["nick"], PDO::PARAM_STR);
            $stmh->bindValue(6, $subject, PDO::PARAM_STR);
            $stmh->bindValue(7, $content, PDO::PARAM_STR);
            $stmh->bindValue(8, $is_html, PDO::PARAM_STR);
            $stmh->execute();
            $lastId = $pdo->lastInsertId();
            $pdo->commit();

            $pdo->beginTransaction();
            $sql = "UPDATE project.qna SET group_num = ? WHERE num=?";
            $stmh1 = $pdo->prepare($sql);
            $stmh1->bindValue(1, $lastId, PDO::PARAM_STR);
            $stmh1->bindValue(2, $lastId, PDO::PARAM_STR);
            $stmh1->execute();
            $pdo->commit();

            header("Location: http://localhost/project/qna/list.php?page=$page");
            exit;
        } catch (PDOException $Exception) {
            $pdo->rollBack();
            print "오류: " . $Exception->getMessage();
        }
    }
}
?>
