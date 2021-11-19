<?php
require_once(ROOT_PATH .'Controllers/PlayerController.php');
$theater = new PlayerController();
$rows = $theater->index();
session_start();

//エスケープ処理
function h($str) {
  return htmlspecialchars($str,ENT_QUOTES,"UTF-8");
}

var_dump($rows['theaters']);

?>


<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" type="text/css" href="/css/style.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="/js/index.js"></script>
  <title>劇場一覧</title>
</head>
<body>

  <div id="header_1">
    <?php include('../parts/header.php');?>
  </div>

  <section id="cinema_post">

    <h1>都内のミニシアター</h1>

    <div class="theater_area">
      <?php foreach($rows['theaters'] as $row): ?>
        <div class="cinema">
          <div class="cinema_id" style="display: none;"><?= h($row['id']) ?></div>
          <div class="cinema_name">
            <a href="theaters_movies.php?id=<?= h($row['id']); ?>" title=""><?= h($row['name']) ?></a>
          </div>
          <div class="cinema_address"><?= h($row['address']) ?></div>
        </div>
      <?php endforeach; ?>
    </div>
  </section>

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

  <?php include('../parts/footer.php');?>

</body>
</html>