<header>

  <?php
  $role = $_SESSION['log_in']['role'];
  $user_id = $_SESSION['log_in']['id'];
  ?>
  
  <nav>
    <div class="g_nav">
      <div class="logo" id="logo"><a href="index.php"><h1>Tokyo Cinemap</h1></a></div>

      <div class="menu" id="menu_1"><a href="theaters.php">劇場一覧</a></div>
      <div class="menu" id="menu_2"><a href="mypage.php?id=<?= h($user_id); ?>">マイページ</a></div>
      <div class="menu" id="menu_3"><a href="./logout.php" onClick="return logout();">ログアウト</a></div>
      <?php if($role == "0"){ ?>
      <div class="menu" id="menu_4"><a href="./manage.php">管理者はこちら</a></div>
      <?php } ?>
    </div>
  </nav>
</header>