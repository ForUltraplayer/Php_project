<?php
session_start();

$file_dir = 'C:\xampp\htdocs\project\data\\';

$num = $_REQUEST["num"];

require_once("../lib/MYDB.php");
$pdo = db_connect();

try {
    $sql = "SELECT * FROM project.download WHERE num=?";
    $stmh = $pdo->prepare($sql);
    $stmh->bindValue(1, $num, PDO::PARAM_STR);
    $stmh->execute();

    $row = $stmh->fetch(PDO::FETCH_ASSOC);

    $item_num = $row["num"];
    $item_id = $row["id"];
    $item_name = $row["name"];
    $item_nick = $row["nick"];
    $item_hit = $row["hit"];


    $item_date = $row["regist_day"];
    $item_date = substr($item_date, 0, 10);
    $item_subject = str_replace(" ", "&nbsp;", $row["subject"]);
    $item_content = $row["content"];
    $is_html = $row["is_html"];

    if ($is_html != "y") {
        $item_content = str_replace(" ", "&nbsp;", $item_content);
        $item_content = str_replace("\n", "<br>", $item_content);
    }

    $new_hit = $item_hit + 1;

    try {
        $pdo->beginTransaction();
        $sql = "UPDATE project.download SET hit=? WHERE num=?"; // 조회수 증가
        $stmh = $pdo->prepare($sql);
        $stmh->bindValue(1, $new_hit, PDO::PARAM_STR);
        $stmh->bindValue(2, $num, PDO::PARAM_STR);
        $stmh->execute();
        $pdo->commit();
    } catch (PDOException $Exception) {
        $pdo->rollBack();
        print "오류: " . $Exception->getMessage();
    }
} catch (PDOException $Exception) {
    print "오류: " . $Exception->getMessage();
}
?>

<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="../css/common.css">
<link rel="stylesheet" type="text/css" href="../css/board.css">
    <title>자료실</title>
<style>
    .download-link {
        color: blue;
        text-decoration: underline;
    }
</style>

<script>
function del(href) {
    if (confirm("한번 삭제한 자료는 복구할 방법이 없습니다.\n\n정말 삭제하시겠습니까?")) {
        document.location.href = href;
    }
}
</script>
</head>
<body>
<div id="wrap">
    <div id="header"><?php include "../lib/top_login2.php"; ?></div>
    <div id="menu"><?php include "../lib/top_menu2.php"; ?></div>
    <div id="content">
        <div id="col1">
            <div id="left_menu"><?php include "../lib/left_menu.php"; ?></div>
        </div>
        <div id="col2">
            <div id="title"><img src="../img/title_download.png"></div>
            <div id="view_comment">&nbsp;</div>
            <div id="view_title">
                <div id="view_title1"><?= $item_subject ?></div>
                <div id="view_title2"><?= $item_nick ?> | 조회 : <?= $item_hit ?> | <?= $item_date ?></div>
            </div>
            <div id="view_content">
                    <?php
                    $file_name[0] = $row["file_name_0"];
                    $file_name[1] = $row["file_name_1"];
                    $file_name[2] = $row["file_name_2"];

                    $file_copied[0] = $row["file_copied_0"];
                    $file_copied[1] = $row["file_copied_1"];
                    $file_copied[2] = $row["file_copied_2"];

                    for ($i = 0; $i < 3; $i++) {
                        if ($file_name[$i]) {
                            $file_path = $file_dir . $file_copied[$i]; // 파일 경로 수정
                            echo "첨부파일: <a href='download.php?num=$num&file=$i' class='download-link'>{$file_name[$i]}</a><br><br>";

                        }
                    }
                    ?>

                    <?= $item_content ?>
                </div>

        
            <div id="view_button">
                <a href="list.php"><img src="../img/list.png"></a>&nbsp;
                <?php
                if (isset($_SESSION["userid"])) {
                    if ($_SESSION["userid"] == $item_id || $_SESSION["userid"] == "admin" || $_SESSION["level"] == 1) {
                ?>
                        <a href="write_form.php?mode=modify&num=<?= $num ?>"><img src="../img/modify.png"></a>&nbsp;
                        <a href="javascript:del('delete.php?num=<?= $num ?>')"><img src="../img/delete.png"></a>&nbsp;
                <?php
                    }
                ?>
                    <a href="write_form.php"><img src="../img/write.png"></a>
                <?php
                }
                ?>
            </div>
            <div class="clear"></div>
        </div> <!-- end of col2 -->
    </div> <!-- end of content -->
</div> <!-- end of wrap -->
 <footer>
    	<?php include "../lib/footer.php";?>
    </footer>
</body>
</html>
