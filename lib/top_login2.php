<div id="logo"><a href="../index.php"><img src="../img/logo.png" border="0"></a></div>
<div id="moto"><img src="../img/moto.png"></div>
<div id="top_login">
<?php
    if(!isset($_SESSION["userid"]))
	{
?>
    <a href="../login/login_form.php">로그인</a> | <a href="../member/insertForm.php">회원가입</a>
<?php
	}
	else
	{
        $level = $_SESSION["level"];
        $userType = "";

        if ($level == 1) {
            $userType = "[관리자]";
        } else if ($level == 9) {
            $userType = "[일반회원]";
        }
?>
    <?=$_SESSION["nick"]?> <?=$userType?> | 
    <a href="../login/logout.php">로그아웃</a> | <a href="../member/updateForm.php?id=<?=$_SESSION["userid"]?>">정보수정</a>
<?php
	}
?>
</div>
