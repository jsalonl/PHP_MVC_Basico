<?php

require_once 'models/usermodel.php';

class LoginModel extends Model{

  function __construct(){
    parent::__construct();
  }

  function login($identificacion, $password){
    try{
      $query = $this->prepare('SELECT * FROM usuario WHERE Identificacion=:identificacion');
      $query->execute(['identificacion'=>$identificacion]);

      if($query->rowCount() == 1){
        $item =  $query->fetch(PDO::FETCH_ASSOC);
        $user = new UserModel();
        $user->from($item);
        if(password_verify($password, $user->getPassword())){
          if($user->getEstado()==1){
            return $user;
          }else{
            error_log('LoginModel::login->Usuario '. $user->getNombre() . ' se encuentra suspendido');
            return $user;
          }
        }else{
          error_log('LoginModel::login->Password no es igual');
          return NULL;
        }
      }

    }catch (PDOException $e){
      error_log('LoginModel::login->exception: ' . $e);
      return NULL;
    }
  }
}

?>