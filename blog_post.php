<!-- ブログ記事投稿ファイル -->
<?php session_start(); ?>


<?php


if (isset($_SESSION['users_id'])) {
  if (isset ($_POST['blog_title']) && isset ($_POST['text']) && isset ($_POST['name']) ) {
      $blog_title = $_POST['blog_title'];
      $text = $_POST['text'];
      $name = $_POST['name'];

      //データベース接続
      require("bd.php");
      
      try {
          $res = $db->query("SELECT COUNT(*) FROM class WHERE name = '" . $name . "'");
          if ($res->fetchColumn() == 0) {
              $statement = $db->prepare("INSERT INTO class (name) VALUES (:name)");
              $statement->bindValue(':name', $name, PDO::PARAM_STR);
              $statement->execute();
              $statement = null;
              echo "追加しました。";
          }
      }
      catch (Exception $error) {
          echo "登録失敗：" . $error->getMessage();
      }

      //記事を登録
      try {
          $statement = $db->prepare("INSERT INTO blog (blog_title, text, date, name_id) VALUES (:blog_title, :text, NOW(), (SELECT id FROM class WHERE name = :name))");
          $statement->bindValue(':blog_title', $blog_title, PDO::PARAM_STR);
          $statement->bindValue(':text', $text, PDO::PARAM_STR);
          $statement->bindValue(':name', $name, PDO::PARAM_STR);
          $statement->execute();
          $statement = null;
          }
      catch (Exception $error) {
          echo "記事の登録失敗：" . $error->getMessage();
      }
  }

}
else{
  header( "Location: login.php" ); 
  exit;
}
?>



<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="blog_post.css">
<title>ブログ</title>
</head>
<body>


<h1><?php echo $g; ?></h1>
<?php echo $l; ?>

<form id="contact" action="blog_post.php" method="post">
  <div class="container">
    <div class="head">
      <h2><?php echo $_SESSION['users_id'] ; ?>さん,こんにちは。</h2>
    </div>
    <input class="username" type="hidden" name="name"  value="<?php echo $_SESSION['users_id'] ; ?>" /><br />
    <input  type="text" name="blog_title" placeholder="タイトル" /><br />
    <textarea type="text" name="text" placeholder="Message"></textarea><br />
    <div class="message">Message Sent</div>
    <button id="submit" type="submit">
      投稿
    </button>
    <button type="button" onclick="location.href='logout.php'">
      ログアウト
    </button>
  </div>
</form>




<?php
//データベース接続
require("bd.php");

$statement = $db->prepare("SELECT id, (SELECT name FROM class WHERE name_id = id) AS name, blog_title, text, date FROM blog ORDER BY id DESC");
$statement->execute();
?>
<!-- 投稿を表示 -->
<?php while ($row = $statement->fetch()):?>
    <div class='toukou'>
      <div class="u">
        <p> <?php echo "投稿者：" . $row['name'];?></p>
      </div>
      <div class="e">
        <p> <?php echo $row['blog_title'];?></p>
      </div>
      <div class="d">
        <p> <?php echo $row['text'];?></p>
      </div>
      <div class="f">
        <p> <?php echo "投稿日時：" . $row['date'];?></p>
      </div>
    </div>
<?php endwhile; ?>

<?php
$statement = null;
?>

</body>
</html>
