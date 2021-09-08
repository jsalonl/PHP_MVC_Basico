<?php

require_once 'models/loanmodel.php';
require_once 'models/clientmodel.php';

class Loans extends SessionController{

  private $loan;

  function __construct(){
    parent::__construct();
    $this->user = $this->getUserSessionData();
    $this->client = new ClientModel();
    $this->loan = new LoanModel();
  }

  function render(){
    $term = '';
    if($this->existPOST(['term'])){
      $term = $this->getPost('term');
    }
    $this->view->render('loans/index',[
      'user'=>$this->user,
      'loans'=>$this->loan->paginate(5),
      'loans_paginate'=>$this->loan->showPages(),
      'term'=>$term
    ]);
  }

  function add(){
    $this->view->render('loans/add', [
      'user'=>$this->user,
      'clients'=>$this->client->getAll()
    ]);
  }

  function edit(){
    if($this->existGET(['id'])){
      $id = $this->getGet('id');
      $this->view->render('loans/edit',[
        'user'=>$this->user,
        'loan'=>$this->loan->get($id),
        'clients'=>$this->client->getAll()
      ]);
    }else{
      $this->redirect('loans', []);
    }
  }

  function createLoan(){
    if($this->existPOST(['clienteId', 'valor', 'cuotas', 'porcentaje'])){
        
        $clienteId = $this->getPost('clienteId');
        $valor = $this->getPost('valor');
        $cuotas = $this->getPost('cuotas');
        $porcentaje = $this->getPost('porcentaje');

        //validate data
        if($valor == '' || empty($valor) || $cuotas == '' || empty($cuotas)){
            $this->redirect('loans/add', ['error' => ErrorMessages::ERROR_SIGNUP_NEWUSER_EMPTY]);
        }else{
          $porcentaje = $porcentaje/100;
          $valorTotal = $valor+($valor*$porcentaje);
          $valorPendiente = $valorTotal;
          
          $loan = new LoanModel();
          $loan->setValor($valor);
          $loan->setPorcentaje($porcentaje);
          $loan->setValorTotal($valorTotal);
          $loan->setValorPendiente($valorPendiente);
          $loan->setCuotas($cuotas);
          $loan->setEstado(1);
          $loan->setClienteId($clienteId);
          $loan->setCreated(date('Y-m-d h:i:s'));
          $loan->setModified(date('Y-m-d h:i:s'));
          
          if($loan->save()){
            $this->redirect('loans', ['success' => SuccessMessages::SUCCESS_LOANS_NEWLOAN]);
          }else{
            $this->redirect('loans/add', ['error' => ErrorMessages::ERROR_SIGNUP_NEWUSER]);
          }
        }
    }else{
        $this->redirect('loans/add', ['error' => ErrorMessages::ERROR_SIGNUP_POST]);
    }
  }

  function update(){
    if($this->existPOST(['id', 'clienteId', 'valor', 'cuotas', 'porcentaje'])){
      
      $id = $this->getPost('id');
      $clienteId = $this->getPost('clienteId');
      $valor = $this->getPost('valor');
      $cuotas = $this->getPost('cuotas');
      $porcentaje = $this->getPost('porcentaje');

      //validate data
      if($valor == '' || empty($valor) || $cuotas == '' || empty($cuotas)){
          $this->redirect('loans/add', ['error' => ErrorMessages::ERROR_SIGNUP_NEWUSER_EMPTY]);
      }else{
        $porcentaje = $porcentaje/100;
        $valorTotal = $valor+($valor*$porcentaje);
        $loan = new LoanModel();
        $loan->setId($id);
        $loan->setvalor($valor);
        $loan->setporcentaje($porcentaje);
        $loan->setValorTotal($valorTotal);
        $loan->setValorPendiente($valor);
        $loan->setModified(date('Y-m-d h:i:s'));

        if($loan->update()){
          $this->redirect('loans', ['success' => SuccessMessages::SUCCESS_LOANS_UPDATELOAN]);
        }else{
          $this->redirect('loans/edit', ['error' => ErrorMessages::ERROR_SIGNUP_NEWUSER]);
        }
      }
    }else{
      $this->redirect('loans/edit', ['error' => ErrorMessages::ERROR_SIGNUP_POST]);
    }
  }

  function remove(){
    if($this->existGET(['id'])){
      $id = $this->getGet('id');
      
      if($this->loan->delete($id)){
        $this->redirect('loans', ['success' => SuccessMessages::SUCCESS_LOANS_REMOVELOAN]);
      }else{
        $this->redirect('loans', ['error' => ErrorMessages::ERROR_SIGNUP_NEWUSER]);
      }
    }else{
      $this->redirect('loans', ['error' => ErrorMessages::ERROR_SIGNUP_POST]);
    }

  }

}

?>