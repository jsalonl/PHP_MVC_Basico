<?php

class ErrorMessages{
  // ERROR_CONTROLLER_METHOD_ACTION
  const ERROR_SIGNUP_POST = "e_s_p_2021_400";
  const ERROR_SIGNUP_NEWUSER = "e_s_nu_2021_400";
  const ERROR_SIGNUP_NEWUSER_EMPTY = "e_s_nu_e_2021_400";
  const ERROR_SIGNUP_NEWUSER_EXISTS = "e_u_ne_2021_400";
  const ERROR_LOGIN_AUTHENTICATE_POST = "e_l_a_p_2021_400";
  const ERROR_LOGIN_AUTHENTICATE_EMPTY = "e_l_a_e_2021_400";
  const ERROR_LOGIN_AUTHENTICATE_DATA = "e_l_a_d_2021_400";
  const ERROR_LOGIN_AUTHENTICATE_STATUS = "e_l_a_S_2021_400";
  const ERROR_USER_NEWUSER_EXIST = "e_u_ne_2021_400";
  const ERROR_PROFILE_VALIDATEPASSWORD = "e_p_vp_2021_400";
  const ERROR_CLIENTS_NEWCLIENT_EXISTS = "e_c_nc_e_2021_400";

  private $errorList = [];

  public function __construct(){
    $this->errorList=[
      ErrorMessages::ERROR_SIGNUP_POST=>'No se recibieron datos post',
      ErrorMessages::ERROR_SIGNUP_NEWUSER=>'Hubo un error al intentar procesar la solicitud',
      ErrorMessages::ERROR_SIGNUP_NEWUSER_EMPTY=>'Llene los campos solicitados',
      ErrorMessages::ERROR_SIGNUP_NEWUSER_EXISTS=>'La identificacion del usuario ya esta en sistema',
      ErrorMessages::ERROR_LOGIN_AUTHENTICATE_POST=>'No se recibieron datos post',
      ErrorMessages::ERROR_LOGIN_AUTHENTICATE_EMPTY=>'Llene los campos de usuario y password',
      ErrorMessages::ERROR_LOGIN_AUTHENTICATE_DATA=>'Usuario y/o password incorrecto',
      ErrorMessages::ERROR_LOGIN_AUTHENTICATE_STATUS=>'Usuario inactivo, por favor contacte con el administrador',
      ErrorMessages::ERROR_USER_NEWUSER_EXIST=>'La identificacion del usuario ya esta en sistema',
      ErrorMessages::ERROR_PROFILE_VALIDATEPASSWORD=>'Passwords son diferentes',
      ErrorMessages::ERROR_CLIENTS_NEWCLIENT_EXISTS=>'Cliente ya existente en sistema'
    ];
  }

  public function get($hash){
    return $this->errorList[$hash];
  }

  public function existsKey($key){
    if(array_key_exists($key, $this->errorList)){
      return true;
    }else{
      return false;
    }
  }

}

?>