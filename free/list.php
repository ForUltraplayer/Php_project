<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/common.css">
    <link rel="stylesheet" type="text/css" href="../css/board.css">
    <title>자유게시판</title>
</head>
<body>
<?php
require_once("../lib/MYDB.php");
$pdo = db_connect();

if (isset($_REQUEST["mode"]))
    $mode = $_REQUEST["mode"];
else
    $mode = "";

if (isset($_REQUEST["search"]))
    $search = $_REQUEST["search"];
else
    $search = "";

if (isset($_REQUEST["find"]))
    $find = $_REQUEST["find"];
else
    $find = "";

if (isset($_GET["page"])) {
    $page = $_GET["page"];
} else {
    $page = 1;
}

$page = (int)$page;
if ($page < 1) {
    $page = 1;
}

$list = 10;
$list = (int)$list;
$block_cnt = 3;
$block_num = ceil($page / $block_cnt);
$block_start = (($block_num - 1) * $block_cnt) + 1;
$block_end = $block_start + $block_cnt - 1;

$total_sql = "SELECT COUNT(*) FROM project.free";
$total_result = $pdo->query($total_sql);
$total_record = $pdo->query($total_sql)->fetchColumn();
$count = $total_record;


$total_page = ceil($total_record / $list);
if ($block_end > $total_page) {
    $block_end = $total_page;
}
$total_block = ceil($total_page / $block_cnt);
$page_start = ($page - 1) * $list;

if ($mode == "search") {
    if (!$search) {
        ?>
        <script>
            alert('검색할 단어를 입력해 주세요!');
            history.back();
        </script>
        <?php
    } else {
        $sql = "SELECT * FROM project.free WHERE $find LIKE '%$search%' ORDER BY num DESC LIMIT $page_start, $list";
        $count_sql = "SELECT COUNT(*) FROM project.free WHERE $find LIKE '%$search%'";
        $count_result = $pdo->query($count_sql);
        $count = $count_result->fetchColumn();
    }
} else {
    $sql = "SELECT * FROM project.free ORDER BY num DESC LIMIT $page_start, $list";
}

try {
    $stmh = $pdo->query($sql);
} catch (PDOException $e) {
    echo "오류 발생: " . $e->getMessage();
    exit; // 오류 발생 시 코드 실행 중단
}
?>


<div id="wrap">
    <div id="header">
        <?php include "../lib/top_login2.php"; ?>
    </div>
    <div id="menu">
        <?php include "../lib/top_menu2.php"; ?>
    </div>
    <div id="content">
        <div id="col1">
            <div id="left_menu">
                <?php include "../lib/left_menu.php"; ?>
            </div>
        </div>
        <!-- end of col1 -->
        <div id="col2">
            <div id="title"><img src="../img/title_free.png"></div>
            <form name="board_form" method="post" action="list.php?mode=search">
                <div id="list_search">
                    <div id="list_search1">▷ 총 <?= $count ?>개의 게시물이 있습니다.</div>
                    <div id="list_search2"><img src="../img/select_search.gif"></div>
                    <div id="list_search3">
                        <select name="find">
                            <option value='subject'>제목</option>
                            <option value='content'>내용</option>
                            <option value='nick'>닉네임</option>
                        </select>
                    </div>
                    <!-- end of list_search3 -->
                    <div id="list_search4"><input type="text" name="search"></div>
                    <div id="list_search5"><input type="image" src="../img/list_search_button.gif"></div>
                </div>
                <!-- end of list_search -->
            </form>

            <div class="clear"></div>
            <div id="list_top_title">
                <ul>
                    <li id="list_title1"><img src="../img/list_title1.gif"></li>
                    <li id="list_title2"><img src="../img/list_title2.gif"></li>
                    <li id="list_title3"><img src="../img/list_title3.gif"></li>
                    <li id="list_title4"><img src="../img/list_title4.gif"></li>
                    <li id="list_title5"><img src="../img/list_title5.gif"></li>
                </ul>
            </div>
            <!-- end of list_top_title -->
            <div id="list_content">
                <?php
                // 글 목록 출력
                $num = $total_record - (($page - 1) * $list);// 글 번호를 순차적으로 표시하기 위해 count 변수를 사용
                while ($row = $stmh->fetch(PDO::FETCH_ASSOC)) {
                    $item_num = $row["num"];
                    $item_id = $row["id"];
                    $item_name = $row["name"];
                    $item_nick = $row["nick"];
                    $item_hit = $row["hit"];
                    $item_date = $row["regist_day"];
                    $item_date = substr($item_date, 0, 10);
                    $item_subject = str_replace(" ", "&nbsp;", $row["subject"]);

                    $sql = "select * from project.free_ripple where parent=$item_num";
                    $stmh1 = $pdo->query($sql);
                    $num_ripple = $stmh1->rowCount();
                    ?>
                    <div id="list_item">
                        <div id="list_item1"><?= $num ?></div>
                        <div id="list_item2">
                            <a href="view.php?num=<?= $item_num ?>"><?= $item_subject ?></a>
                            <?php
                            if ($num_ripple) {
                                echo "[<font color=red><b>$num_ripple</b></font>]";
                            }
                            ?>
                        </div>
                        <div id="list_item3"><?= $item_nick ?></div>
                        <div id="list_item4"><?= $item_date ?></div>
                        <div id="list_item5"><?= $item_hit ?></div>
                    </div>
                    <!-- end of list_item -->
                    <?php
                    $num--; // 글 번호를 감소시켜 순차적으로 표시
                }
                ?>
                <div id="write_button">
                    <a href="list.php"><img src="../img/list.png"></a>&nbsp;
                    <?php
                    if (isset($_SESSION["userid"])) {
                        ?>
                        <a href="write_form.php"><img src="../img/write.png"></a>
                        <?php
                    }
                    ?>
                </div>
                <!-- end of write_button -->

                <div id="page_button">
                    <div id="page_num">
                        <?php
                        if ($total_page >= 2 && $page >= 2) {
                            $new_page = $page - 1;
                            echo "<a href='list.php?page=$new_page'>[이전]</a> ";
                        } else {
                            echo "[이전] ";
                        }

                        for ($i = $block_start; $i <= $block_end; $i++) {
                            if ($page == $i) {
                                echo "<b> $i </b>";
                            } else {
                                echo "<a href='list.php?page=$i'> $i </a>";
                            }
                        }

                        if ($total_page >= $block_end + 1) {
                            $new_page = $page + 1;
                            echo "<a href='list.php?page=$new_page'>[다음]</a>";
                        } else {
                            echo "[다음]";
                        }
                        ?>
                    </div>
                    <!-- end of page_num -->
                    
                </div>
                <!-- end of page_button -->
            </div>
            <!-- end of list_content -->
        </div>
        <!-- end of col2 -->
    </div>
    <!-- end of content -->
</div>
    <footer>
    	<?php include "../lib/footer.php";?>
    </footer>
<!-- end of wrap -->

</body>
</html>
