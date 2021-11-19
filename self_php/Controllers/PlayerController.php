<?php
require_once(ROOT_PATH .'/Models/Movie.php');
require_once(ROOT_PATH .'/Models/Theater.php');
require_once(ROOT_PATH .'/Models/Review.php');
require_once(ROOT_PATH .'/Models/Bookmark.php');


class PlayerController {

  private $Movie;
  private $Theater;
  private $Review;
  private $Bookmark;


  public function __construct() {
    $this->request['get'] = $_GET;
    $this->request['post'] = $_POST;

    $this->Movie = new Movie();
    $dbh = $this->Movie->get_db_handler();
    $this->Theater = new Theater($dbh);
    $this->Review = new Review($dbh);
    $this->Bookmark = new Bookmark($dbh);

  }
  
  public function upload(){
    $result = $this->Movie->upLoad($this->request['post']);
    return $result;
  }

  public function index() {
    $page = 0;
    if(isset($this->request['get']['page'])) {
      $page = $this->request['get']['page'];
    }

    $theaters = $this->Theater->findAll($page);
    $movies   = $this->Movie->findAll($page);
    $movies_count = $this->Movie->countAll();
    
    $rows = [
      'theaters' => $theaters,
      'movies'   => $movies,
      'pages'    => $movies_count / 10
    ];
    return $rows;
  }
  
  public function show() {
    if(empty($this->request['get']['id'])) {
      echo '指定のパラメーターが不正です。このページを表示できません。';
      exit;
    }

    $theater = $this->Theater->findById($this->request['get']['id']);
    $movie = $this->Movie->findMovieId($this->request['get']['id']);
    
    $row = [
      'theater' => $theater,
      'movie'   => $movie
    ];
    return $row;
  }
  
  public function update() {
    if (empty($this->request['get']['id'])) {
      echo '指定のパラメータが不正です。このページを表示できません。';
      exit();
    }
    $this->Movie->updateMovie($this->request['post']);
  }
  
  public function delete() {
    if (empty($this->request['get']['id'])) {
      echo '指定のパラメータが不正です。このページを表示できません。';
      exit();
    }
    $this->Movie->deleteById($this->request['get']['id']);
    $this->Bookmark->deleteById($this->request['get']['id']);
  }
  
  public function review(){
    $result = $this->Review->reView($this->request['post']);
    return $result;
  }
  
  public function myreviewlist() {
    
    $users_reviews = $this->Review->findAll();
    
    $rows = [
      'users_reviews' => $users_reviews
    ];
    return $rows;
  }

  public function reviewlist() {
    
    $users_reviews = $this->Review->findAllReview();
  
    $rows = [
      'users_reviews' => $users_reviews,
    ];
    return $rows;
  }

  public function findtheater() {
    
    $theaters = $this->Theater->findTheater();
  
    $rows = [
      'theaters' => $theaters,
    ];
    return $rows;
  }

  public function loadmovie() {
    
    $movies = $this->Movie->loadMovie();
  
    $rows = [
      'movies' => $movies,
    ];
    return $rows;
  }

  public function bookmark(){
    $result = $this->Bookmark->BookMark($this->request['post']);
    return $result;
  }

  public function mybookmark() {
    
    $bookmark = $this->Bookmark->findAll();
    
    $rows = [
      'bookmark' => $bookmark
    ];
    return $rows;
  }



}      
?>