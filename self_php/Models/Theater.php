<?php
require_once(ROOT_PATH .'/Models/Db.php');

class Theater extends Db {

  private $table = 'theaters';

  public function __construct($dbh = null) {
    parent::__construct($dbh);
  }

  // ミニシアター一覧

  public function findAll($page = 0) :Array {
    try {
      $sql = 'SELECT * FROM '.$this->table;
      $sql .= ' LIMIT 6 OFFSET '.(6 * $page);
      $sth = $this->dbh->prepare($sql);
      $sth->execute();
      $result = $sth->fetchAll(PDO::FETCH_ASSOC);
      return $result;
    } catch(PDOException $e) {
      echo 'データベースにアクセスできません:' . $e->getMessage();
    }
  }
  
  // ミニシアター詳細

  public function findById($id = 0) {
    try {
      $sql = 'SELECT * FROM theaters WHERE id = :id';
      $sth = $this->dbh->prepare($sql);
      $sth->bindParam(':id', $id, PDO::PARAM_INT);
      $sth->execute();
      $result = $sth->fetch(PDO::FETCH_ASSOC);
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

  // ミニシアターから上映中映画の表示
  
  public function findTheater() :Array {
    try {
      $sql = 'SELECT movies.title, movies.file_name AS movie_image, theaters_search.theater_id, theaters_search.movie_id FROM theaters LEFT JOIN theaters_search ON theaters.id = theaters_search.theater_id LEFT JOIN movies ON movies.id = theaters_search.movie_id WHERE theater_id='.$_SESSION['theater_id']."";
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
