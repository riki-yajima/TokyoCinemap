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
  isset($_SESSION['log_in']);
}

var_dump($_SESSION['log_in']);

// データの代入
$id = $row['movie']['id'];
$title = $row['movie']['title'];
$coming = $row['movie']['coming'];
$country = $row['movie']['country'];
$genre = $row['movie']['genre'];
$story = $row['movie']['story'];
$file_name = $row['movie']['file_name'];

if(!empty($_POST) && empty($_SESSION['review'])){
  
  //POSTのValidate

  if(empty($_POST['title'])){
    $err['title'] = 'レビュータイトルを入力してください。';
  }
  if(empty($_POST['review'])){
    $err['review'] = '本文を入力してください。';
  }

  if(empty($err)){
    $review = new PlayerController();
    $review->review();
    $_SESSION['review'] = $_POST;
      header('Location: ./review_complete.php');
      exit();
  }
}elseif(!empty($_SESSION['review'])){
  header('Location: ./review_complete.php');
}

var_dump($_SESSION['id']);

?>


<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" type="text/css" href="/css/style.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="/js/index.js"></script>
  <title>映画のレビュー</title>
</head>
<body>
  <div id="header_1">
  <?php include('../parts/header.php');?>
  </div>
  
  <section id="main_content">

    <h1>映画のレビュー</h1>

    <div class="content_detail">

      <div class="content_detail_header">
        <ul class="back">
          <li><a href="index.php">トップページ</a></li>
          <li><a href="movie.php?id=<?= h($id); ?>"><?= h($title); ?></a>の映画情報</li>
          <li>レビュー</li>
        </ul>
      </div>
      
      <div class="content_detail_inner">
        
      <div class="movie_id" style="display: none;"><?= h($row['id']); ?></div>
      
        <div class="content_detail_left">
        <img src="<?php echo 'image/'. h($file_name);?>">
        </div>
    
        <div class="content_detail_main">
          <h2 class="detail_title"><?= h($title); ?></h2>

          <div class="review_title">
            <h3><?= h($title); ?>のレビューを書く</h3>
          </div>

          <form action="" method="POST">
            <div class="review_area">
            <input type="hidden" name="user_id" value ="<?= h($_SESSION['id']); ?>" checked>
            <input type="hidden" name="movie_id" value ="<?= h($id); ?>" checked>
            <input type="text" name="title" placeholder="レビュータイトル" value="<?php echo isset($_POST['title']) ? h($_POST['title']) : ''; ?>">
            <textarea class="text-area" placeholder="本文　/　500文字以内" name="review" cols="40" rows="10"><?php echo isset($_POST['review']) ? h($_POST['review']) : ''; ?></textarea>
            </div>
            <p class="err_message" style="font-size: 0.7em;"><?php if(isset($err['title'])){echo $err['title'];} ?></p>
            <p class="err_message" style="font-size: 0.7em;"><?php if(isset($err['review'])){echo $err['review'];} ?></p>
            <button type="submit" style="font-size:0.8em;margin-top:initial;">投稿する</button>
          </form>
                 
        </div>
      </div>
      
    </div>
  </section>
  
  <?php include('../parts/footer.php');?>
</body>
</html>