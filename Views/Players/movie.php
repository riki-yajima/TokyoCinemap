<?php
require_once(ROOT_PATH .'Controllers/PlayerController.php');
$movie = new PlayerController();
$row = $movie->show();

session_start();

//エスケープ処理
function h($str) {
  return htmlspecialchars($str,ENT_QUOTES,"UTF-8");
}

if(empty($_SESSION['log_in'])){
  header('location: ./login.php');
}else {
  $_POST = $_SESSION['log_in'];
}

var_dump($_SESSION['log_in']['id']);


// データの代入
$id = $row['movie']['id'];
$title = $row['movie']['title'];
$coming = $row['movie']['coming'];
$country = $row['movie']['country'];
$genre = $row['movie']['genre'];
$story = $row['movie']['story'];
$file_name = $row['movie']['file_name'];

$_SESSION['movie_id'] = $id;

if(!isset($_SESSION['movie_id'])) {
  isset($_SESSION['movie_id']);
}

$movies = new PlayerController();
$rows = $movies->loadmovie();
?>

<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="/css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="/js/index.js"></script>
    <script src="/js/bookmark.js"></script>
    <title>映画の詳細</title>
  </head>
  <body>
    <div id="header_1">
      <?php include('../parts/header.php');?>
    </div>
    
    <section id="main_content">
      
      <h1>映画の詳細</h1>
      
      <div class="content_detail">
        
        <div class="content_detail_header">
          <ul class="back">
            <li><a href="index.php">トップページ</a></li>
            <li><?= h($title); ?>の映画情報</li>
          </ul>
        </div>
        
        <div class="content_detail_inner">
          
          <div class="movie_id" style="display: none;"><?= h($id); ?></div>
          
          <div class="content_detail_left">
            <img src="<?php echo 'image/'. h($file_name);?>">
          </div>
          
          <div class="content_detail_main">
            <h2 class="detail_title"><?= h($title); ?></h2>
            
            <div class="content_detail_info">
              <h3 class="detail_info_title">公開日：<?= h($coming); ?></h3>
              <h3 class="detail_info_title">制作国：<?= h($country); ?></h3>
              <h3 class="detail_info_title">ジャンル：<?= h($genre); ?></h3>
            </div>
            
            
            <div class="content_detail_story">
              <h3 style="padding-bottom: 10px;">あらすじ</h3>
              <p style="font-size: smaller;"><?= (h($story)); ?></p>
            </div>
            
            <div class="loadmovie">
              <h3 style="padding-bottom: 10px;">〜公開中の映画館〜</h3>
              <?php foreach($rows['movies'] as $row): ?>
                <a href="theaters_movies.php?id=<?= h($row['theater_id']); ?>"><?= h($row['name']); ?></a>||
                <?php endforeach; ?>
              </div>
              
            <div class="bookmark">
              <form action="bookmark.php" method="POST">
                <input type="hidden" name="user_id" value="<?= h($_SESSION['log_in']['id']); ?>">
                <input type="hidden" name="movie_id" value="<?= h($id); ?>">
                <button id="submit" class="btn_bookmark">ブックマーク</button>
              </form>
            </div>
              
            </div>
          </div>
          
        </div>
      </section>
      
      <?php 
    $review = new PlayerController();
    $rows = $review->reviewlist();
    ?>
    
  <section id="review">
    
    <div class="media">
      <div class="media_review">
        <h1><a href="review.php?id=<?= h($id); ?>" class="movie_review">レビューを書く</a></h1>
      </div>
    </div>
    
    <h1>「<?= h($title); ?>」に投稿されたレビュー</h1>
    
    <?php foreach($rows['users_reviews'] as $row): ?>
      <div class="review_list">
        <div class="media">
          <div class="media_innner">
            <div class="review_title_view" style="padding-bottom: 10px;">
              <h4><?= h($row['review_title']); ?></h4>
            </div>
            <div class="review_view" style="padding-bottom: 10px;">
              <p style="font-weight: bold;font-size:1em;"><?= h($row['review']); ?></p>
            </div>
            <div class="review_info">
              <p>ユーザー名：<?= h($row['review_user']); ?> / <?= h($row['review_at']); ?></p>
            </div>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </section>
  
  <?php include('../parts/footer.php');?>
  
</body>
</html>


