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
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" type="text/css" href="/css/style.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="/js/index.js"></script>
  <title>映画一覧ページ</title>
</head>
<body>

  <div id="header_1">
  <?php include('../parts/header.php');?>
  </div>
 
  <div id="movie_list">

    <h1>映画一覧</h1>

    <div class="movie_list">
      
      <table border="1">
      <tr>
      </tr>
      <?php foreach($rows['movies'] as $row): ?>
        <tr>
          <td style="display: none;"><?= h($row['id']); ?></td>
          <td style="display: none;"><?= h($row['coming']); ?></td>
          <td style="display: none;"><?= h($row['country']); ?></td>
          <td style="display: none;"><?= h($row['genre']); ?></td>
          <td style="display: none;"><?= h($row['story']); ?></td>
          <td style="width: 70px;"><img src="<?php echo 'image/'. $row['file_name'];?>" style="width: auto;height:100px;"></td>
          <td><?= h($row['title']); ?></td>
          <td><a href="movie_edit.php?id=<?= h($row['id']); ?>" class="movie_edit">編集</a></td>
          <td><a href="movie_delete.php?id=<?= h($row['id']); ?>" class="delete">削除</a></td>
        </tr>
      <?php endforeach; ?>
      </table>
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
  </div>


  <?php include('../parts/footer.php');?>
</body>
</html>