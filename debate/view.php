<?php
session_start();

$file_dir = 'C:\xampp\htdocs\project\data\\';

$num = $_REQUEST["num"];

require_once("../lib/MYDB.php");
$pdo = db_connect();

try {
    $sql = "SELECT * FROM project.debate WHERE num=?";
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
        $sql = "UPDATE project.debate SET hit=? WHERE num=?"; // 조회수 증가
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
  <title>토론게시판</title>
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
            <div id="title"><img src="../img/title_debate.png"></div>
            <div id="view_comment">&nbsp;</div>
            <div id="view_title">
                <div id="view_title1"><?= $item_subject ?></div>
                <div id="view_title2"><?= $item_nick ?> | 조회 : <?= $item_hit ?> | <?= $item_date ?></div>
            </div>
            <div id="view_content">
                
                
                <?= $item_content ?>
            </div>
            <div id="view_button">
                <a href="list.php"><img src="../img/list.png"></a>&nbsp;
                <?php
                if (isset($_SESSION["userid"])) {
                    if ($_SESSION["userid"] == $item_id || $_SESSION["userid"] == "admin" || $_SESSION["level"] == 1) {
                ?>
                        
                        <a href="javascript:del('delete.php?num=<?= $num ?>')"><img src="../img/delete.png"></a>&nbsp;
                <?php
                    }
                ?>
                    <a href="write_form.php"><img src="../img/write.png"></a>
                <?php
                }
                ?>
            </div>
                <div id="ripple">
                    <?php

                try {
                    $sql = "select * from project.debate_ripple where parent='$item_num'";
                    $stmh1 = $pdo->query($sql); // ripple PDOStatement 변수명을 다르게
                } catch (PDOException $Exception) {
                    print "오류: " . $Exception->getMessage();
                }

                while ($row_ripple = $stmh1->fetch(PDO::FETCH_ASSOC)) {
                    $ripple_num = $row_ripple["num"];
                    $ripple_id = $row_ripple["id"];
                    $ripple_nick = $row_ripple["nick"];
                    $ripple_content = str_replace("\n", "<br>", $row_ripple["content"]);
                    $ripple_content = str_replace(" ", "&nbsp;", $ripple_content);
                    $ripple_date = $row_ripple["regist_day"];
                ?>

                <div id="ripple_writer_title">
                    <ul>
                        <li id="writer_title1"><?= $ripple_nick ?></li>
                        <li id="writer_title2"><?= $ripple_date ?></li>
                        &nbsp; &nbsp;
                        <?php
                            if (isset($_SESSION["userid"])) {
                                if ($_SESSION["userid"] == "admin" || $_SESSION["userid"] == $ripple_id) {
                                    echo "<a href='delete_ripple.php?num=$item_num&ripple_num=$ripple_num' onclick=\"alert('삭제되었습니다.');\">[삭제]</a>";
                                }
                            }
                            ?>

                    </ul>
                </div>

                <div id="ripple_content"><?= $ripple_content ?></div>
                <div class="hor_line_ripple"></div>

                <?php
                } // while문의 끝
                ?>

                <form name="ripple_form" method="post" action="insert_ripple.php?num=<?= $item_num ?>">
                    <div id="ripple_box">
                        <div id="ripple_box1"><img src="../img/title_comment.gif"></div>
                        <div id="ripple_box2"><textarea rows="5" cols="65" name="ripple_content" required></textarea></div>
                        <div id="ripple_box3"><input type="image" src="../img/ok_ripple.gif"></div>
                    </div>
                </form>
            </div> <!-- end of ripple -->        
            <div class="clear"></div>
        </div> <!-- end of col2 -->
    </div> <!-- end of content -->
</div> <!-- end of wrap -->
 <footer>
    	<?php include "../lib/footer.php";?>
    </footer>
</body>
</html>
