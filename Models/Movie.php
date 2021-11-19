<?php
require_once(ROOT_PATH.'/Models/Db.php');

class Movie extends Db {

  private $table = 'movies';

  public function __construct($dbh = null) {
    parent::__construct($dbh);
  }
  
  // 映画のアップロード

  public function upLoad($post) {

    $upload_dir = '/Applications/MAMP/self_php/Views/Players/image/';
    if (is_uploaded_file($_FILES["image"]["tmp_name"])) {
      if (move_uploaded_file($_FILES["image"]["tmp_name"], "$upload_dir" . $_FILES["image"]["name"])) {
        chmod("$upload_dir" . $_FILES["image"]["name"], 0644);
      } else {   
      }
    } else {
    }

    $title = $post['title'];
    $coming = $post['coming'];
    $country = $post['country'];
    $genre = $post['genre'];
    $story = $post['story'];
    $file_name = $_FILES['image']['name'];
    $sql = "INSERT INTO movies (title , coming, country, genre, story, file_name) VALUE(:title, :coming, :country, :genre, :story, :file_name)";

    $this->dbh -> beginTransaction();
    try {
      $sth = $this->dbh->prepare($sql);
      $sth->bindParam(':title', $title, PDO::PARAM_STR);
      $sth->bindParam(':coming', $coming, PDO::PARAM_STR);
      $sth->bindParam(':country', $country, PDO::PARAM_STR);
      $sth->bindParam(':genre', $genre, PDO::PARAM_STR);
      $sth->bindParam(':story', $story, PDO::PARAM_STR);
      $sth->bindParam(':file_name', $file_name, PDO::PARAM_STR);
      $sth->execute();
      $this->dbh->commit();
    } catch (PDOException $e) {
      echo 'データベースにアクセスできません:' .$e->getMessage();
      $this->dbh->rollBack();
      exit;
    }

  }

  // トップページ映画一覧表示

  public function findAll($page = 0) :Array {
    try {
      $sql = 'SELECT * FROM movies ORDER BY created_at DESC' ;
      $sql .= ' LIMIT 10 OFFSET '.(10 * $page);
      $sth = $this->dbh->prepare($sql);
      $sth->execute();
      $result = $sth->fetchAll(PDO::FETCH_ASSOC);
      return $result;
    } catch(PDOException $e) {
      echo 'データベースにアクセスできません:' . $e->getMessage();
    }
  }


  public function countAll():Int {
    $sql = 'SELECT count(*) as count FROM '.$this->table;
    $sth = $this->dbh->prepare($sql);
    $sth->execute();
    $count = $sth->fetchColumn();
    return $count;
  }

  // 映画の詳細表示

  public function findMovieId($id = 0) {
    try {
      $sql = 'SELECT * FROM movies WHERE id = :id';
      $sth = $this->dbh->prepare($sql);
      $sth->bindParam(':id', $id, PDO::PARAM_INT);
      $sth->execute();
      $result = $sth->fetch(PDO::FETCH_ASSOC);
      return $result;
    } catch(PDOException $e) {
      echo 'データベースにアクセスできません:' . $e->getMessage();
    }
  }

  // 映画の編集
  
  public function updateMovie($post) {
    $sql = "UPDATE movies SET
              title = :title, coming = :coming, country = :country, genre = :genre, story = :story
            WHERE id = :id";
      $this->dbh->beginTransaction();
      try {

      $sth = $this->dbh->prepare($sql);
      $sth->bindParam(':id', $post['id'], PDO::PARAM_INT);
      $sth->bindParam(':title', $post['title'], PDO::PARAM_STR);
      $sth->bindParam(':coming', $post['coming'], PDO::PARAM_STR);
      $sth->bindParam(':country', $post['country'], PDO::PARAM_STR);
      $sth->bindParam(':genre', $post['genre'], PDO::PARAM_STR);
      $sth->bindParam(':story', $post['story'], PDO::PARAM_STR);
      $sth->execute();
      $this->dbh->commit();
    } catch(PDOException $e) {
      echo 'データベースにアクセスできません:' . $e->getMessage();
      $this->dbh->rollBack();
      exit();
    }
  }

  // 映画の削除

  public function deleteById($id) {
    $sql = "DELETE FROM movies WHERE id = :id";

    $this->dbh->beginTransaction();
    try {

      $sth = $this->dbh->prepare($sql);
      $sth->bindParam(':id', $id, PDO::PARAM_INT);

      $sth->execute();
      $this->dbh->commit();
    } catch(PDOException $e) {
      echo 'データベースにアクセスできません:' . $e->getMessage();
      $this->dbh->rollBack();
      exit();
    }
  }

  // 上映中ミニシアターの表示

  public function loadMovie() :Array {
    try {
      $sql = 'SELECT theaters.name, theaters_search.movie_id, theaters_search.theater_id FROM movies LEFT JOIN theaters_search ON movies.id = theaters_search.movie_id LEFT JOIN theaters ON theaters.id = theaters_search.theater_id WHERE movie_id=' .$_SESSION['movie_id']."";
      $sth = $this->dbh->prepare($sql);
      $sth->execute();
      $result = $sth->fetchAll(PDO::FETCH_ASSOC);
      return $result;
    } catch(PDOException $e) {
      echo 'データベースにアクセスできません:' . $e->getMessage();
    }
  }

}
?>