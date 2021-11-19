<?php
session_start();

require_once(ROOT_PATH .'Controllers/PlayerController.php');
$movie = new PlayerController();
$rows = $movie->index();


//エスケープ処理
function h($str) {
  return htmlspecialchars($str,ENT_QUOTES,"UTF-8");
}

if(empty($_SESSION['log_in'])){
  header('location: ./login.php');
}else {
  $_POST = $_SESSION['log_in'];
}


var_dump($_SESSION['log_in']);

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" type="text/css" href="/css/style.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="/js/index.js"></script>
  <title>メインページ</title>
</head>
<body>
  <div id="header_1">
  <?php include('../parts/header.php');?>
  </div>
 
  <section id="main_1">
    
    <h1>上映中の映画</h1>

    <div class="movie_table">

      <div class="movie_table_inner">

        <?php foreach($rows['movies'] as $row): ?>
        <div class="content_item">
          <div class="movie_id" style="display: none;"><?= h($row['id']); ?></div>
          <div class="movie_coming" style="display: none;"><?= h($row['coming']); ?></div>
          <div class="movie_country" style="display: none;"><?= h($row['country']); ?></div>
          <div class="movie_genre" style="display: none;"><?= h($row['genre']); ?></div>
          <div class="movie_story" style="display: none;"><?= h($row['story']); ?></div>
          <div class="movie_review" style="display: none;"><?= h($row['review']); ?></div>
          <div class="movie_title">
            <a href="movie.php?id=<?= h($row['id']); ?>">
              <h2 style="font-size: 0.7em;"><?= h($row['title']); ?></h2>
            </a>
          </div>
          <div class="movie_img">
          <a href="movie.php?id=<?= h($row['id']); ?>">
            <img src="<?php echo 'image/'. $row['file_name'];?>">
          </a>
          </div>
        </div>
        <?php endforeach; ?>

      </div>
    </div>

    <div class="paging">
      <?php 
        for($i = 0;$i <= h($rows['pages']);$i++) {
          if(isset($_GET['page']) && $_GET['page'] == $i) {
            echo $i+1;
          } else {
            echo "<a href='?page=".$i."'>".($i+1)."</a>";
          }
        }
      ?>
    </div>

  </section>

  <?php include('../parts/footer.php');?>
</body>
</html>