<?php
function db_connect(){  //DB연결을 함수로 정의
    $db_user ="root";    //추가한 계정이름(사용자명)
    $db_pass ="";     //비밀번호
    $db_host ="localhost";  
    $db_name ="project"; //DB이름
    $db_type ="mysql"; 
    $dsn ="$db_type:host=$db_host;db_name=$db_name;charset=utf8";

    try{ 
        $pdo=new PDO($dsn,$db_user,$db_pass);  
        $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);  
        $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES,FALSE);
        
    } catch (PDOException $Exception) {  
        die('오류:'.$Exception->getMessage());
    }
    return $pdo;
}
?>