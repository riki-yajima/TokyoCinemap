<?php
require_once(ROOT_PATH .'Controllers/PlayerController.php');
$theater = new PlayerController();
$row = $theater->show();
session_start();

//エスケープ処理
function h($str) {
  return htmlspecialchars($str,ENT_QUOTES,"UTF-8");
}

// データの代入
$id = $row['theater']['id'];
$name = $row['theater']['name'];
$address = $row['theater']['address'];

$_SESSION['theater_id'] = $id;

if(!isset($_SESSION['theater_id'])) {
  isset($_SESSION['theater_id']);
}

$theaters = new PlayerController();
$rows = $theaters->findtheater();

var_dump($rows['theaters']);



?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" type="text/css" href="/css/style.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="/js/index.js"></script>
  <title>シアター公開中映画一覧ページ</title>
</head>

<body>
  <div id="header_1">
  <?php include('../parts/header.php');?>
  </div>
 
  <section id="main_1">
    
    <h1>上映中の映画</h1>

    <div class="theater_area"> 

      <div class="content_detail_header">
        <ul class="back">
          <li><a href="theaters.php">劇場一覧ページ</a></li>
          <li><?= h($name); ?>の情報</li>
        </ul>
      </div>

      <div class="cinema">
        <div class="cinema_id" style="display: none;"><?= h($id) ?></div>
        <div class="cinema_name">
          <a href="theaters.php?id=<?= h($id); ?>" title="" id="view"><?= h($name) ?></a>
        </div>
        <div class="cinema_address"><?= h($address) ?></div>
      </div>

      <?php foreach($rows['theaters'] as $row): ?>
      <div class="cinema_2">
        <div class="cinema_name" style="display: flex;align-items: center;">
        <a href="movie.php?id=<?= h($row['movie_id']); ?>">
        <img src="<?php echo 'image/'. $row['movie_image'];?>" style="width: auto;height:100px;">
        </a>
        <a href="movie.php?id=<?= h($row['movie_id']); ?>" style="padding-left:30px;"><?= h($row['title']); ?></a>
        </div>
      </div>
      <?php endforeach; ?>
        
    </div>

  </section>

  <?php include('../parts/footer.php');?>
</body>
</html>