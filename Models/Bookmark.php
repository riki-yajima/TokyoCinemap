<?php
require_once(ROOT_PATH.'/Models/Db.php');

class Bookmark extends Db {

  private $table = 'bookmark';

  public function __construct($dbh = null) {
    parent::__construct($dbh);
  }

  // ブックマーク追加

  public function BookMark($post) {

    $user_id = $post['user_id'];
    $id = $post['movie_id'];
    $sql = "INSERT INTO bookmark (user_id, movie_id) VALUE (:user_id, :movie_id)";
    
    $this->dbh -> beginTransaction();
    try {
      $sth = $this->dbh->prepare($sql);
      $sth->bindParam(':user_id', $user_id, PDO::PARAM_INT);
      $sth->bindParam(':movie_id', $id, PDO::PARAM_INT);
      $sth->execute();
      $this->dbh->commit();
    } catch (PDOException $e) {
      echo 'データベースにアクセスできません:' .$e->getMessage();
      $this->dbh->rollBack();
      exit;
    }
  }

  // ブックマーク表示

  public function findAll() :Array {
    try {
      $sql = 'SELECT bookmark.id, bookmark.user_id, bookmark.movie_id, movies.title, movies.file_name FROM bookmark LEFT JOIN users ON users.id = bookmark.user_id LEFT JOIN movies ON movies.id = bookmark.movie_id WHERE user_id =' .$_SESSION['id']. "";
      $sth = $this->dbh->prepare($sql);
      $sth->execute();
      $result = $sth->fetchAll(PDO::FETCH_ASSOC);
      return $result;
    } catch(PDOException $e) {
      echo 'データベースにアクセスできません:' . $e->getMessage();
    }
  }

  // ブックマーク削除

  public function deleteById($id) {
    $sql = "DELETE FROM bookmark WHERE id = :id";

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

}
?>