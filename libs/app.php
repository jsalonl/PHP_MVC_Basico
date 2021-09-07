<?php

require_once 'controllers/errores.php';

class App{
 
  function __construct(){
    $url = isset($_GET['url']) ? $_GET['url'] : null;
    $url = rtrim($url, '/');
    $url = explode('/', $url);

    if(empty($url[0])){
      //error_log('App::construct-> No hay controlador especificado');
      $fileController = 'controllers/login.php';
      require_once $fileController;
      $controller = new Login();
      $controller->loadModel('login');
      $controller->render();
      //return false;
    }
    
    $fileController = 'controllers/' . $url[0] . '.php';

    if(file_exists($fileController)){ //Valida si existe Controlador
      require_once $fileController;
      
      $controller = new $url[0];
      $controller->loadModel($url[0]);

      if(isset($url[1])){ //Valida metodo crear,editar,remover
        if(method_exists($controller,$url[1])){
          if(isset($url[2])){
            //No de parametros
            $nparam = count($url)-2;
            //Array de parametros
            $params = [];

            for($i=0;$i<$nparam;$i++){
              array_push($params, $url[$i]+2);
            }

            $controller->{$url[1]}($params);
          }else{
            //Si no tiene parametros, se llama metodo tal cual
            $controller->{$url[1]}();
          }
        }else{
          //Metodo no existe 404
          $controller = new Errores();
          $controller->render();
        }
      }else{
        //Se carga metodo por default, carga vista
        $controller->render();
      }
    }else{
      $controller = new Errores();
      $controller->render();
    }

  }

}
?>