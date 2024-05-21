<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./css/common.css">
    <title>픽셀존 - 대한민국 하드웨어 커뮤니티</title>
</head>
<body>
    <div id="wrap">
        <div id="header">
            <?php include "./lib/top_login1.php"; ?>
        </div> <!-- end of header -->

        <div id="menu">
            <?php include "./lib/top_menu1.php"; ?>
        </div> <!-- end of menu -->

        <div id="content">
            <div id="main_img"><img src="./img/main_img.jpg"></div>
            <?php include "./lib/func.php"; ?>
            <div id="latest">
                <div id="latest1">
                    <div id="title_latest1"><img src="./img/title_latest1.png"></div>
                    <div class="latest_box">
                        <?php latest_article("debate", 7, 45); ?>
                    </div>
                </div>
                <div id="latest2">
                    <div id="title_latest2"><img src="./img/title_latest2.png"></div>
                    <div class="latest_box">
                        <?php latest_article("product", 7, 45); ?>
                    </div>
                </div>
            </div>
        </div> <!-- end of content -->
       
    
    </div> <!-- end of wrap -->
    <footer>
    	<?php include "./lib/footer.php";?>
    </footer>
</body>
</html>
