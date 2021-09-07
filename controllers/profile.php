<?php

require_once 'models/usermodel.php';

class Profile extends SessionController{
  
  private $user;

  function __construct(){
    parent::__construct();
    $this->user = $this->getUserSessionData();
    $this->users = new UserModel();
  }

  function render(){
    $this->view->render('profile/index',[
      'user'=>$this->user,
      'users'=>$this->users->get($this->user->getId())
    ]);
  }

  function updateUser(){
    if($this->existPOST(['id', 'nombre', 'telefono'])){
        
        $id = $this->getPost('id');
        $nombre = $this->getPost('nombre');
        $telefono = $this->getPost('telefono');
        
        //validate data
        if($id == '' || empty($id) || $nombre == '' || empty($nombre) || $telefono == '' || empty($telefono)){
            $this->redirect('profile', ['error' => ErrorMessages::ERROR_SIGNUP_NEWUSER_EMPTY]);
        }else{
          $user = new UserModel();
          $user->setId($id);
          $user->setNombre($nombre);
          $user->setTelefono($telefono);
          $user->setModified(date('Y-m-d h:i:s'));
          
          if($user->updateProfile()){
            $this->redirect('profile', ['success' => SuccessMessages::SUCCESS_USER_UPDATEUSER]);
          }else{
            $this->redirect('profile', ['error' => ErrorMessages::ERROR_SIGNUP_NEWUSER]);
          }
        }
    }else{
        $this->redirect('profile', ['error' => ErrorMessages::ERROR_SIGNUP_POST]);
    }
  }

  function updatePassword(){
    if($this->existPOST(['id', 'password', 'repeat_password'])){
        
        $id = $this->getPost('id');
        $password = $this->getPost('password');
        $repeat_password = $this->getPost('repeat_password');
        
        //validate data
        if($id == '' || empty($id) || $password == '' || empty($password) || $repeat_password == '' || empty($repeat_password)){
            $this->redirect('profile', ['error' => ErrorMessages::ERROR_SIGNUP_NEWUSER_EMPTY]);
        }else if($password != $repeat_password){
          $this->redirect('profile', ['error' => ErrorMessages::ERROR_PROFILE_VALIDATEPASSWORD]);
        }else{
          $user = new UserModel();
          $user->setId($id);
          $user->setPassword($password);
          $user->setModified(date('Y-m-d h:i:s'));
          
          if($user->updatePassword()){
            $this->redirect('profile', ['success' => SuccessMessages::SUCCESS_USER_UPDATEUSER]);
          }else{
            $this->redirect('profile', ['error' => ErrorMessages::ERROR_SIGNUP_NEWUSER]);
          }
        }
    }else{
        $this->redirect('profile', ['error' => ErrorMessages::ERROR_SIGNUP_POST]);
    }
  }

}

?>