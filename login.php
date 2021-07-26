<?php
// ini_set('display_errors',"On");
session_start();

try{
	$pdo = new PDO('mysql:dbname=mydb;host=localhost;charset=utf8', 'root', 'root');

    $stmt = $pdo->prepare('SELECT * FROM users WHERE users_id = :users_id');

    $stmt->execute(array(':users_id' => $_POST['users_id']));

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if(password_verify($_POST['pass'], $result['password'])){
        $_SESSION['users_id'] = $result['users_id'];
        header( "Location: blog_post.php" ); 
        exit;
    }
    else{
    } 

}catch(Exception $e){
    echo "データベースの接続に失敗しました：";
    echo $e->getMessage();
    die();
}

?>




<!DOCTYPE html>
<html>
<head>
    <title>ログイン</title>
    <link rel="stylesheet" type="text/css" href="login.css">
</head>
<body>



    <form action="" method="post">
        <h2></h2>
        <input type="text" name="users_id" placeholder="username"/>
        <input type="password" name="pass" placeholder="password"/>
        <table>
            <tr>
                <td><button id="submit" type="submit">ログイン</button></td>
                <td><button type="button" onclick="location.href='sign.php'">登録ページへ移動</button></td>
            </tr>
        </table>
    </form>



	
</body>
</html>




