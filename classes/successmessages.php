<?php

class SuccessMessages{
  // SUCCESS_CONTROLLER_METHOD_ACTION
  const SUCCESS_USER_NEWUSER_EXIST = "s_u_ne_2021_400";
  const SUCCESS_SIGNUP_NEWUSER = "s_s_nu_2021_200";
  const SUCCESS_USER_UPDATEUSER = "s_u_uu_2021_200";
  const SUCCESS_USERS_REMOVEUSER = "s_u_ur_2021_200";
  const SUCCESS_CLIENTS_NEWCLIENT = "s_c_nu_2021_200";
  const SUCCESS_CLIENTS_UPDATECLIENT = "s_c_uc_2021_200";
  const SUCCESS_CLIENTS_REMOVECLIENT = "s_c_rc_2021_200";
  const SUCCESS_LOANS_NEWLOAN = "s_l_nl_2021_200";
  const SUCCESS_LOANS_UPDATELOAN = "s_l_ul_2021_200";
  const SUCCESS_LOANS_REMOVELOAN = "s_l_rl_2021_200";

  private $successList = [];
  public function __construct(){
    $this->successList=[
      SuccessMessages::SUCCESS_USER_NEWUSER_EXIST=>'Usuario creado satisfactoriamente',
      SuccessMessages::SUCCESS_SIGNUP_NEWUSER=>'Nuevo usuario creado satisfactoriamente',
      SuccessMessages::SUCCESS_USER_UPDATEUSER=>'Usuario actualizado satisfactoriamente',
      SuccessMessages::SUCCESS_USERS_REMOVEUSER=>'Usuario eliminado satisfactoriamente',
      SuccessMessages::SUCCESS_CLIENTS_NEWCLIENT=>'Cliente creado satisfactoriamente',
      SuccessMessages::SUCCESS_CLIENTS_UPDATECLIENT=>'Cliente actualizado satisfactoriamente',
      SuccessMessages::SUCCESS_CLIENTS_REMOVECLIENT=>'Cliente eliminado satisfactoriamente',
      SuccessMessages::SUCCESS_LOANS_NEWLOAN=>'Préstamo creado satisfactoriamente',
      SuccessMessages::SUCCESS_LOANS_UPDATELOAN=>'Préstamo actualizado satisfactoriamente',
      SuccessMessages::SUCCESS_LOANS_REMOVELOAN=>'Préstamo eliminado satisfactoriamente'
    ];
  }

  public function get($hash){
    return $this->successList[$hash];
  }

  public function existsKey($key){
    if(array_key_exists($key, $this->successList)){
      return true;
    }else{
      return false;
    }
  }
}

?>