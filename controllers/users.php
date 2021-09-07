<?php

class Users extends SessionController{
  
  private $user;

  function __construct(){
    parent::__construct();
    $this->user = $this->getUserSessionData();
    $this->users = new UserModel();
  }

  function render(){
    $this->view->render('users/index',[
      'user'=>$this->user,
      'users'=>$this->user->paginate(5),
      'users_paginate'=>$this->user->showPages()
    ]);
  }

  function add(){
    $this->view->render('users/add',[
      'user'=>$this->user,
    ]);
  }

  function edit(){
    if($this->existGET(['id'])){
      $id = $this->getGet('id');
      $this->view->render('users/edit',[
        'user'=>$this->user,
        'users'=>$this->users->get($id)
      ]);
    }else{
      $this->redirect('users', []);
    }
  }

  function createUser(){
    if($this->existPOST(['identificacion', 'nombre', 'telefono', 'rol'])){
        
        $identificacion = $this->getPost('identificacion');
        $nombre = $this->getPost('nombre');
        $telefono = $this->getPost('telefono');
        $rol = $this->getPost('rol');
        
        //validate data
        if($identificacion == '' || empty($identificacion) || $nombre == '' || empty($nombre) || $telefono == '' || empty($telefono) || $rol == '' || empty($rol)){
            $this->redirect('users/add', ['error' => ErrorMessages::ERROR_SIGNUP_NEWUSER_EMPTY]);
        }else{
          $password = $identificacion;
          $user = new UserModel();
          $user->setIdentificacion($identificacion);
          $user->setNombre($nombre);
          $user->setTelefono($telefono);
          $user->setPassword($password);
          $user->setRol($rol);
          $user->setEstado(1);
          $user->setCreated(date('Y-m-d h:i:s'));
          $user->setModified(date('Y-m-d h:i:s'));
          
          if($user->exists($identificacion)){
            $this->redirect('users/add', ['error' => ErrorMessages::ERROR_SIGNUP_NEWUSER_EXISTS]);
          }else if($user->save()){
            $this->redirect('users', ['success' => SuccessMessages::SUCCESS_SIGNUP_NEWUSER]);
          }else{
            $this->redirect('users/add', ['error' => ErrorMessages::ERROR_SIGNUP_NEWUSER]);
          }
        }
    }else{
        $this->redirect('users/add', ['error' => ErrorMessages::ERROR_SIGNUP_POST]);
    }
  }

  function updateUser(){
    if($this->existPOST(['id','identificacion', 'nombre', 'telefono', 'estado', 'rol'])){
        
        $id = $this->getPost('id');
        $identificacion = $this->getPost('identificacion');
        $nombre = $this->getPost('nombre');
        $telefono = $this->getPost('telefono');
        $estado = $this->getPost('estado');
        $rol = $this->getPost('rol');
        
        //validate data
        if($id == '' || empty($id) || $identificacion == '' || empty($identificacion) || $nombre == '' || empty($nombre) || $telefono == '' || empty($telefono)){
            $this->redirect('users/edit', ['error' => ErrorMessages::ERROR_SIGNUP_NEWUSER_EMPTY]);
        }else{
          $user = new UserModel();
          $user->setId($id);
          $user->setIdentificacion($identificacion);
          $user->setNombre($nombre);
          $user->setTelefono($telefono);
          $user->setRol($rol);
          $user->setEstado($estado);
          $user->setModified(date('Y-m-d h:i:s'));
          
          if($user->update()){
            $this->redirect('users', ['success' => SuccessMessages::SUCCESS_USER_UPDATEUSER]);
          }else{
            $this->redirect('users/edit', ['error' => ErrorMessages::ERROR_SIGNUP_NEWUSER]);
          }
        }
    }else{
        $this->redirect('users/edit', ['error' => ErrorMessages::ERROR_SIGNUP_POST]);
    }
  }

  function remove(){
    if($this->existGET(['id'])){
      $id = $this->getGet('id');
      
      if($this->users->delete($id)){
        $this->redirect('users', ['success' => SuccessMessages::SUCCESS_USERS_REMOVEUSER]);
      }else{
        $this->redirect('users', ['error' => ErrorMessages::ERROR_SIGNUP_NEWUSER]);
      }
    }else{
      $this->redirect('users', ['error' => ErrorMessages::ERROR_SIGNUP_POST]);
    }

  }
}

?>