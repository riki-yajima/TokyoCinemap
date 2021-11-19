<?php
session_start();

if(empty($_SESSION['log_in'])){
  header('location: ./login.php');
}else {
  $_POST = $_SESSION['log_in'];
}

require_once(ROOT_PATH.'Controllers/PlayerController.php');
$bookmark = new PlayerController();
$rows = $bookmark->mybookmark();

//エスケープ処理
function h($str) {
  return htmlspecialchars($str,ENT_QUOTES,"UTF-8");
}


$id = $_SESSION['id'];
$user_name = $_SESSION['log_in']['user_name'];

var_dump($user_name);
var_dump($id);

?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" type="text/css" href="/css/style.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="/js/index.js"></script>
  <title>ブックマークページ</title>
</head>
<body>
  <div id="header_1">
  <?php include('../parts/header.php');?>
  </div>

  <section id="profile_info">

    <h1>ブックマーク一覧</h1>

    <div class="content_detail_header" style="margin-left: 300px;margin-top: 50px;padding:0;">
      <ul class="back">
        <li><a href="mypage.php?id=<?= h($id); ?>"><?= h($user_name); ?>さんのマイページ</a></li>
        <li><?= h($user_name); ?>さんのブックマーク</li>
      </ul>
    </div>


      

    <div class="movie_list" style="padding-top: 40px;">
      <table border="1">
      <tr>
      </tr>
      <?php foreach($rows['bookmark'] as $row): ?>
        <tr>
          <td style="width: 70px;">
            <a href="movie.php?id=<?= h($row['movie_id']); ?>">
            <img src="<?php echo 'image/'. $row['file_name'];?>" style="width: auto;height:100px;">
            </a>
          </td>
          <td><a href="movie.php?id=<?= h($row['movie_id']); ?>"><?= h($row['title']); ?></a></td>
          <td><a href="bookmark_delete.php?id=<?= h($row['id']); ?>" class="delete">削除</a></td>
        </tr>
      <?php endforeach; ?>
      </table>
    </div>

  </section>

    <?php include('../parts/footer.php');?>
</body>
</html>