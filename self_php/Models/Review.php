<?php
require_once(ROOT_PATH.'/Models/Db.php');

class Review extends Db {

  private $table = 'users_reviews';

  public function __construct($dbh = null) {
    parent::__construct($dbh);
  }

  // レビュー投稿

  public function reView($post) {

    $title = $post['title'];
    $review = $post['review'];
    $user_id = $post['user_id'];
    $movie_id = $post['movie_id'];
    $sql = "INSERT INTO users_reviews (title, user_id, movie_id, review) VALUE (:title, :user_id, :movie_id, :review)";
    
    $this->dbh -> beginTransaction();
    try {
      $sth = $this->dbh->prepare($sql);
      $sth->bindParam(':title', $title, PDO::PARAM_STR);
      $sth->bindParam(':user_id', $user_id, PDO::PARAM_INT);
      $sth->bindParam(':movie_id', $movie_id, PDO::PARAM_INT);
      $sth->bindParam(':review', $review, PDO::PARAM_STR);
      $sth->execute();
      $this->dbh->commit();
    } catch (PDOException $e) {
      echo 'データベースにアクセスできません:' .$e->getMessage();
      $this->dbh->rollBack();
      exit;
    }
  }

  // マイレビューの表示

  public function findAll() :Array {
    try {
      $sql = 'SELECT users_reviews.title AS review_title, users_reviews.review AS review, movies.title AS movie_title, movies.file_name AS movie_image, movies.id AS movie_id FROM users_reviews LEFT JOIN users ON users_reviews.user_id = users.id LEFT JOIN movies ON movies.id = users_reviews.movie_id  WHERE user_id =' .$_SESSION['id']. "";
      $sth = $this->dbh->prepare($sql);
      $sth->execute();
      $result = $sth->fetchAll(PDO::FETCH_ASSOC);
      return $result;
    } catch(PDOException $e) {
      echo 'データベースにアクセスできません:' . $e->getMessage();
    }
  }

  // 投稿済みレビューの表示
  
  public function findAllReview() :Array {
    try {
      $sql = 'SELECT users_reviews.title AS review_title, users_reviews.review AS review, users_reviews.created_at AS review_at, users.user_name AS review_user, users_reviews.movie_id FROM users_reviews LEFT JOIN users ON users_reviews.user_id = users.id LEFT JOIN movies ON movies.id = users_reviews.movie_id WHERE movie_id =' .$_SESSION['movie_id']."";
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