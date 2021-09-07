<?php

require_once 'models/clientmodel.php';

class Clients extends SessionController{

  private $client;

  function __construct(){
    parent::__construct();
    $this->user = $this->getUserSessionData();
    $this->client = new ClientModel();
  }

  function render(){
    $term = '';
    if($this->existPOST(['term'])){
      $term = $this->getPost('term');
    }
    $this->view->render('clients/index',[
      'user'=>$this->user,
      'clients'=>$this->client->paginate(5),
      'clients_paginate'=>$this->client->showPages(),
      'term'=>$term
    ]);
  }

  function add(){
    $this->view->render('clients/add', [
      'user'=>$this->user
    ]);
  }

  function edit(){
    if($this->existGET(['id'])){
      $id = $this->getGet('id');
      $this->view->render('clients/edit',[
        'user'=>$this->user,
        'clients'=>$this->client->get($id)
      ]);
    }else{
      $this->redirect('clients', []);
    }
  }

  function createClient(){
    if($this->existPOST(['identificacion', 'nombre', 'telefono', 'direccion'])){
        
        $identificacion = $this->getPost('identificacion');
        $nombre = $this->getPost('nombre');
        $telefono = $this->getPost('telefono');
        $direccion = $this->getPost('direccion');
        
        //validate data
        if($identificacion == '' || empty($identificacion) || $nombre == '' || empty($nombre) || $telefono == '' || empty($telefono) || $direccion == '' || empty($direccion)){
            $this->redirect('clients/add', ['error' => ErrorMessages::ERROR_SIGNUP_NEWUSER_EMPTY]);
        }else{
          $password = $identificacion;
          $client = new ClientModel();
          $client->setIdentificacion($identificacion);
          $client->setNombre($nombre);
          $client->setTelefono($telefono);
          $client->setDireccion($direccion);
          $client->setCreated(date('Y-m-d h:i:s'));
          $client->setModified(date('Y-m-d h:i:s'));
          
          if($client->exists($identificacion)){
            $this->redirect('clients/add', ['error' => ErrorMessages::ERROR_SIGNUP_NEWUSER_EXISTS]);
          }else if($client->save()){
            $this->redirect('clients', ['success' => SuccessMessages::SUCCESS_CLIENTS_NEWCLIENT]);
          }else{
            $this->redirect('clients/add', ['error' => ErrorMessages::ERROR_SIGNUP_NEWUSER]);
          }
        }
    }else{
        $this->redirect('clients/add', ['error' => ErrorMessages::ERROR_SIGNUP_POST]);
    }
  }

  function updateClient(){
    if($this->existPOST(['id', 'identificacion', 'nombre', 'telefono', 'direccion'])){
      
      $id = $this->getPost('id');
      $identificacion = $this->getPost('identificacion');
      $nombre = $this->getPost('nombre');
      $telefono = $this->getPost('telefono');
      $direccion = $this->getPost('direccion');
      
      if($id == '' || empty($id) ||$identificacion == '' || empty($identificacion) || $nombre == '' || empty($nombre) || $telefono == '' || empty($telefono) || $direccion == '' || empty($direccion)){
        $this->redirect('clients/add', ['error' => ErrorMessages::ERROR_SIGNUP_NEWUSER_EMPTY]);
      }else{
        $client = new ClientModel();
        $client->setId($id);
        $client->setIdentificacion($identificacion);
        $client->setNombre($nombre);
        $client->setTelefono($telefono);
        $client->setDireccion($direccion);
        $client->setCreated(date('Y-m-d h:i:s'));
        $client->setModified(date('Y-m-d h:i:s'));

        if($client->update()){
          $this->redirect('clients', ['success' => SuccessMessages::SUCCESS_CLIENTS_UPDATECLIENT]);
        }else{
          $this->redirect('clients/edit', ['error' => ErrorMessages::ERROR_SIGNUP_NEWUSER]);
        }
      }
    }else{
      $this->redirect('clients/edit', ['error' => ErrorMessages::ERROR_SIGNUP_POST]);
    }
  }

  function remove(){
    if($this->existGET(['id'])){
      $id = $this->getGet('id');
      
      if($this->client->delete($id)){
        $this->redirect('clients', ['success' => SuccessMessages::SUCCESS_USERS_REMOVEUSER]);
      }else{
        $this->redirect('clients', ['error' => ErrorMessages::ERROR_SIGNUP_NEWUSER]);
      }
    }else{
      $this->redirect('clients', ['error' => ErrorMessages::ERROR_SIGNUP_POST]);
    }

  }

}

?>