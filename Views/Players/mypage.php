<?php
session_start();

if(empty($_SESSION['log_in'])){
  header('location: ./login.php');
}else {
  $_POST = $_SESSION['log_in'];
}

require_once(ROOT_PATH.'Controllers/UserController.php');
$user = new UserController();
$row = $user->show();

//エスケープ処理
function h($str) {
  return htmlspecialchars($str,ENT_QUOTES,"UTF-8");
}



$id = $row['users']['id'];
$user_name = $row['users']['user_name'];
$email = $row['users']['email'];
$password = $row['users']['password'];
$role = $row['users']['role'];

var_dump($_SESSION['log_in']);
var_dump($row['users']);

?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" type="text/css" href="/css/style.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="/js/index.js"></script>
  <title>マイページ</title>
</head>
<body>
  <div id="header_1">
  <?php include('../parts/header.php');?>
  </div>

  <section id="profile_info">

    <h1>マイページ</h1>

    <div class="profile">
      
      <div class="profile_main">
  
        <div class="profile_body">
          <div class="profile_avator">
          
          </div>
          <div class="user_id" style="display: none;"><?= h($id); ?></div>
          <div class="profile_name">
            <p><?= h($user_name); ?></p>
          </div>
        </div>

        <div class="mybookmark">
          <a href="bookmarklist.php?id=<?= h($id); ?>">ブックマーク一覧</a>
        </div>
  
        <div class="profile_bottom">
          <div class="profile_edit">
            <a href="user_edit.php?id=<?= h($id); ?>">プロフィール編集</a>
          </div>
        </div>
      </div>

    </div>

  </section>

  <?php
  require_once(ROOT_PATH .'Controllers/PlayerController.php');
  $users_reviews = new PlayerController();
  $rows = $users_reviews->myreviewlist();

  // var_dump($rows['users_reviews'])
  ?>


  <section id="myreview_movies">

    <h1>マイレビュー</h1>

    <div class="content_list">

      <div class="content_list_innner">
        
        <?php foreach($rows['users_reviews'] as $row): ?>
          <div class="content_card">
            <div class="content_card_left">
              <div class="myreview_movie_title" style="padding-bottom: 20px;">
                <a href="movie.php?id=<?= h($row['movie_id']); ?>"><h3>タイトル：<?= h($row['movie_title']); ?></h3></a>
              </div>
              <div class="myreview_title" style="padding-bottom: 20px;">
                <h3>レビュータイトル：<?= h($row['review_title']); ?></h3>
              </div>
              <div class="myreview">
              <?= h($row['review']); ?>
              </div>
            </div>
            <div class="content_card_right">
            <a href="movie.php?id=<?= h($row['movie_id']); ?>">
              <img src="<?php echo 'image/'. h($row['movie_image']);?>" style="width:150px;height:200px;">
            </a>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>

  </section>
    <?php include('../parts/footer.php');?>
</body>
</html>