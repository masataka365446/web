<?php

try{

    

	$pdo = new PDO('mysql:dbname=mydb;host=localhost;charset=utf8', 'root', 'root');


    $stmt = $pdo->prepare("INSERT INTO users (users_id, password) VALUES (:users_id, :password)");

    $stmt->execute(array(':users_id' => $_POST['users_id'],':password' => password_hash($_POST['pass'], PASSWORD_DEFAULT)));
    
    // header('Location: login.php');
    // exit();
    

}catch(Exception $e){
    echo "データベースの接続に失敗しました：";
    echo $e->getMessage();
    die();
    
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>会員登録</title>
    <link rel="stylesheet" type="text/css" href="login.css">
</head>
<body>

    <form action="" method="post">
        <h2></h2>
        <input type="text" name="users_id" placeholder="username"/>
        <input type="password" name="pass" placeholder="password"/>
        <table>
            <tr>
                <td><button id="submit" type="submit">会員登録</button></td>
                <td><button type="button" onclick="location.href='login.php'">ログインページへ移動</button></td>
            </tr>
        </table>
    </form>


</body>
</html>