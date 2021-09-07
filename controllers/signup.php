<?php

require_once 'models/usermodel.php';

class SignUp extends SessionController{
  
  function __construct(){
    parent::__construct();
  }

  function render(){
    $this->view->render('login/signup', []);

  }

  function newUser(){
    if($this->existPOST(['identificacion', 'nombre', 'telefono', 'password'])){
        
        $identificacion = $this->getPost('identificacion');
        $nombre = $this->getPost('nombre');
        $telefono = $this->getPost('telefono');
        $password = $this->getPost('password');
        
        //validate data
        if($identificacion == '' || empty($identificacion) || $nombre == '' || empty($nombre) || $telefono == '' || empty($telefono) || $password == '' || empty($password)){
            $this->redirect('signup', ['error' => ErrorMessages::ERROR_SIGNUP_NEWUSER_EMPTY]);
        }else{
          $user = new UserModel();
          $user->setIdentificacion($identificacion);
          $user->setNombre($nombre);
          $user->setTelefono($telefono);
          $user->setPassword($password);
          $user->setRol('cobrador');
          $user->setEstado(0);
          $user->setCreated(date('Y-m-d h:i:s'));
          $user->setModified(date('Y-m-d h:i:s'));
          
          if($user->exists($identificacion)){
            $this->redirect('signup', ['error' => ErrorMessages::ERROR_SIGNUP_NEWUSER_EXISTS]);
          }else if($user->save()){
            $this->redirect('', ['success' => SuccessMessages::SUCCESS_SIGNUP_NEWUSER]);
          }else{
            $this->redirect('signup', ['error' => ErrorMessages::ERROR_SIGNUP_NEWUSER]);
          }
        }
    }else{
        $this->redirect('signup', ['error' => ErrorMessages::ERROR_SIGNUP_POST]);
    }
  }

}

?>