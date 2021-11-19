<?php
require_once(ROOT_PATH.'/Models/Db.php');

class User extends Db {
  
  // サインアップ

  public function SignUp($post){
    $email = $post['email'];
    $password = md5 ($post['password'] , $binary = false );

    $checkSQL = "SELECT COUNT(*) as count FROM users WHERE email = :email";
    $stmt = $this->dbh->prepare($checkSQL);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch();

    if($result['count'] > 0){
      $result = 'このメールアドレスは既に使用されています。';
      return $result;
    }else{

      $name = $post['user_name'];
      $role = $post['role'];
      $sql = "INSERT INTO users (user_name ,email, password, role) VALUE(:user_name, :email, :password, :role)";

      $this->dbh -> beginTransaction();
      try {
        $sth = $this->dbh->prepare($sql);
        $sth->bindParam(':user_name', $name, PDO::PARAM_STR);
        $sth->bindParam(':email', $email, PDO::PARAM_STR);
        $sth->bindParam(':password', $password, PDO::PARAM_STR);
        $sth->bindParam(':role', $role, PDO::PARAM_INT);
        $sth->execute();
        $this->dbh->commit();
      }catch (PDOException $e){
        echo $e->getMessage();
        $this->dbh->rollBack();
        exit;
      }
    }
  }

  // ログイン

  public function LogIn($post){
    $user_name = $post['user_name'];
    $email = $post['email'];
    $password = md5 ($post['password'] , $binary = false );

    $sql = 'SELECT id, role, count(*) as count FROM users where email = :email and password = :password and user_name = :user_name GROUP BY id';
    $sth = $this->dbh->prepare($sql);
    $sth->bindParam(':user_name', $user_name, PDO::PARAM_STR);
    $sth->bindParam(':email', $email, PDO::PARAM_STR);
    $sth->bindParam(':password', $password, PDO::PARAM_STR);
    $sth->execute();
    $result = $sth->fetch(); //0か1

    if(empty($result)){
      $result = "アカウントが見つかりません!";
      return $result;
    }elseif($result['count'] == "1"){
      $_SESSION['id'] = $result['id'];
      $_SESSION['role'] = $result['role'];
      header('location: /Players/login_complete.php');
      }
  }

  // マイページ表示

  public function findById($id = 0) {
    try {
      $sql = "SELECT * FROM users WHERE id= :id";
      $sth = $this->dbh->prepare($sql);
      $sth->bindParam(':id', $id, PDO::PARAM_INT);
      $sth->execute();
      $result = $sth->fetch(PDO::FETCH_ASSOC);
      return $result;
    } catch(PDOException $e) {
      echo 'データベースにアクセスできません:' . $e->getMessage();
    }
  }

  // アカウント編集

  public function UpdateAccount($post) {
    $sql = "UPDATE users SET
              user_name = :user_name, email = :email
            WHERE id = :id";
      $this->dbh->beginTransaction();
      try {

      $sth = $this->dbh->prepare($sql);
      $sth->bindParam(':id', $post['id'], PDO::PARAM_INT);
      $sth->bindParam(':user_name', $post['user_name'], PDO::PARAM_STR);
      $sth->bindParam(':email', $post['email'], PDO::PARAM_STR);
      $sth->execute();
      $this->dbh->commit();
    } catch(PDOException $e) {
      echo 'データベースにアクセスできません:' . $e->getMessage();
      $this->dbh->rollBack();
      exit();
    }
  }

  // アカウント削除

  public function deleteById($id) {
    $sql = "DELETE FROM users WHERE id = :id";

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