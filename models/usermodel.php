<?php

class UserModel extends Model implements IModel{

  private $id;
  private $identificacion;
  private $nombre;
  private $telefono;
  private $password;
  private $estado;
  private $rol;
  private $created;
  private $modified;

  private $actualPage;
  private $totalPages;
  private $nResults;
  private $resultsPerPage;
  private $indice;
  private $term;

  public function __construct(){
    parent::__construct();
    $this->identificacion=0;
    $this->nombre='';
    $this->telefono='';
    $this->password='';
    $this->estado=0;
    $this->rol='';
    $this->created='';
    $this->modified='';
  }

  function paginate($nPerPage){
    $items = [];
    $this->resultsPerPage = $nPerPage;
    $this->indice = 0;
    $this->actualPage = 1;
    $this->calculatePages();
    if(isset($_POST['term'])){
      $this->term = $_POST['term'];
      $query = $this->prepare('SELECT * FROM usuario WHERE nombre LIKE :nombre OR telefono LIKE :telefono LIMIT :pos, :n');
      $query->execute([
        ':nombre'=> '%'.$this->term.'%',
        ':telefono'=> '%'.$this->term.'%',
        ':pos' => $this->indice,
        ':n' => $this->resultsPerPage
      ]);
    }else{
      $query = $this->prepare('SELECT * FROM usuario LIMIT :pos, :n');
      $query->execute([':pos' => $this->indice, ':n' => $this->resultsPerPage]);
    }
    
    while($p=$query->fetch(PDO::FETCH_ASSOC)){
      $item = new userModel();
      $item->setId($p['id']);
      $item->setIdentificacion($p['identificacion']);
      $item->setNombre($p['nombre']);
      $item->setTelefono($p['telefono']);
      $item->setPassword($p['password']);
      $item->setEstado($p['estado']);
      $item->setRol($p['rol']);
      $item->setCreated($p['created']);
      $item->setModified($p['modified']);
      array_push($items,$item);
    }
    
    return $items;

  }

  function calculatePages(){
    $queryTotalResults = $this->query('SELECT COUNT(*) AS total FROM usuario');
    $this->nResults = $queryTotalResults->fetch(PDO::FETCH_OBJ)->total; 
    $this->totalPages = $this->nResults / $this->resultsPerPage;

    if(isset($_POST['page'])){
        $this->actualPage = $_POST['page'];
        $this->indice = ($this->actualPage - 1) * $this->resultsPerPage;
    }
  }

  function showPages(){
    $actual = '';
    $contenido = '<form method="post">
    <nav aria-label="Page navigation example">
    <ul class="pagination justify-content-center">
    ';
    for($i=0; $i < $this->totalPages; $i++){
        if(($i + 1) == $this->actualPage){
            $actual = 'active';
        }else{
            $actual = '';
        }
        $contenido .= '<li class="page-item '.$actual.'"><input type="submit" name="page" value="' . ($i + 1) . '" class="page-link" /></li>';
    }
    $contenido .= "</ul></nav></form>";
    return $contenido;
  }

  function totalRegisters(){
    $queryTotalResults = $this->query('SELECT COUNT(*) AS total FROM usuario');
    $this->nResults = $queryTotalResults->fetch(PDO::FETCH_OBJ)->total;
    return $this->nResults;
  }

  public function save(){
    try{
      $query=$this->prepare('INSERT INTO usuario(identificacion, nombre, telefono, password, estado, rol, created, modified) values(:identificacion, :nombre, :telefono, :password, :estado, :rol, :created, :modified)');
      $query->execute([
        'identificacion'=>$this->identificacion,
        'nombre'=>$this->nombre,
        'telefono'=>$this->telefono,
        'password'=>$this->password,
        'estado'=>$this->estado,
        'rol'=>$this->rol,
        'created'=>$this->created,
        'modified'=>$this->modified
      ]);
      return true;
    }catch(PDOException $e){
      error_log('userModel::save->PDOException '.$e);
      return false;
    }
  }

  public function getAll(){
    try{
      $items = [];
      $query=$this->query('SELECT * FROM usuario');
      while($p=$query->fetch(PDO::FETCH_ASSOC)){
        $item = new userModel();
        $item->setId($p['id']);
        $item->setIdentificacion($p['identificacion']);
        $item->setNombre($p['nombre']);
        $item->setTelefono($p['telefono']);
        $item->setPassword($p['password']);
        $item->setEstado($p['estado']);
        $item->setRol($p['rol']);
        $item->setCreated($p['created']);
        $item->setModified($p['modified']);
        array_push($items,$item);
      }
      
      return $items;

    }catch(PDOException $e){
      error_log('userModel::getAll->PDOException '.$e);
      return false;
    }
  }

  public function get($id){
    try{
      $items = [];
      $query=$this->prepare('SELECT * FROM usuario WHERE id=:id');
      $query->execute([
        'id'=>$id
      ]);
      
      $user=$query->fetch(PDO::FETCH_ASSOC);
      $this->setId($user['id']);
      $this->setIdentificacion($user['identificacion']);
      $this->setNombre($user['nombre']);
      $this->setTelefono($user['telefono']);
      $this->setPassword($user['password']);
      $this->setEstado($user['estado']);        
      $this->setRol($user['rol']);
      $this->setCreated($user['created']);
      $this->setModified($user['modified']);
      
      return $this;

    }catch(PDOException $e){
      error_log('userModel::getId->PDOException '.$e);
      return false;
    }
  }

  public function delete($id){
    try{
      $query=$this->prepare('DELETE FROM usuario WHERE id=:id');
      $query->execute([
        'id'=>$id
      ]);

      return true;
    }catch(PDOException $e){
      error_log('userModel::delete->PDOException '.$e);
      return false;
    }
  }

  public function update(){
    try{
      $query=$this->prepare('UPDATE usuario SET identificacion=:identificacion, nombre=:nombre, telefono=:telefono, estado=:estado, rol=:rol, modified=:modified WHERE id=:id');
      $query->execute([
        'id'=>$this->id,
        'identificacion'=>$this->identificacion,
        'nombre'=>$this->nombre,
        'telefono'=>$this->telefono,
        'estado'=>$this->estado,
        'rol'=>$this->rol,
        'modified'=>$this->modified
      ]);
      
      return true;

    }catch(PDOException $e){
      error_log('userModel::udpate->PDOException '.$e);
      return false;
    }
  }

  public function updateProfile(){
    try{
      $query=$this->prepare('UPDATE usuario SET nombre=:nombre, telefono=:telefono, modified=:modified WHERE id=:id');
      $query->execute([
        'id'=>$this->id,
        'nombre'=>$this->nombre,
        'telefono'=>$this->telefono,
        'modified'=>$this->modified
      ]);
      
      return true;

    }catch(PDOException $e){
      error_log('userModel::udpate->PDOException '.$e);
      return false;
    }
  }

  public function updatePassword(){
    try{
      $query=$this->prepare('UPDATE usuario SET password=:password, modified=:modified WHERE id=:id');
      $query->execute([
        'id'=>$this->id,
        'password'=>$this->password,
        'modified'=>$this->modified
      ]);
      
      return true;

    }catch(PDOException $e){
      error_log('userModel::udpate->PDOException '.$e);
      return false;
    }
  }

  public function from($array){
    $this->id = $array['id'];
    $this->identificacion = $array['identificacion'];
    $this->nombre = $array['nombre'];
    $this->telefono = $array['telefono'];
    $this->password = $array['password'];
    $this->estado = $array['estado'];
    $this->rol = $array['rol'];
    $this->created = $array['created'];
    $this->modified = $array['modified'];
  }

  public function exists($identificacion){
    try{
      $query=$this->prepare('SELECT identificacion FROM usuario WHERE identificacion=:identificacion');
      $query->execute([
        'identificacion'=>$identificacion
      ]);
      if($query->rowCount()>0){
        return true;
      }else{
        return false;
      }
    }catch(PDOException $e){
      error_log('userModel::exists->PDOException '.$e);
      return false;
    }
  }

  public function verifyPassword($password, $id){
    try{

      $user =$this->get($id);
      return password_verify($password, $user->getPassword());

    }catch(PDOException $e){
      error_log('userModel::verifyPassword->PDOException '.$e);
      return false;
    }
  }

  private function getHashPassword($password){
    return password_hash($password, PASSWORD_DEFAULT, ['cost' => 10]);
  }

  private function getUpperCase($string){
    return strtoupper($string);
  }

  private function getLowerCase($string){
    return strtolower($string);
  }

  public function setId($id){
    $this->id=$id;
  }

  public function setIdentificacion($identificacion){
    $this->identificacion=$identificacion;
  }

  public function setNombre($nombre){
    $this->nombre=$this->getUpperCase($nombre);
  }

  public function setTelefono($telefono){
    $this->telefono=$telefono;
  }

  public function setPassword($password){
    $this->password=$this->getHashPassword($password);
  }

  public function setEstado($estado){
    $this->estado=$estado;
  }

  public function setRol($rol){
    $this->rol=$rol;
  }  

  public function setCreated($created){
    $this->created=$created;
  }

  public function setModified($modified){
    $this->modified=$modified;
  }

  public function getId(){
    return $this->id;
  }

  public function getIdentificacion(){
    return $this->identificacion;
  }

  public function getNombre(){
    return $this->nombre;
  }

  public function getTelefono(){
    return $this->telefono;
  }

  public function getPassword(){
    return $this->password;
  }

  public function getEstado(){
    return $this->estado;
  }

  public function getrol(){
    return $this->rol;
  }
  
  public function getCreated(){
    return $this->created;
  }

  public function getModified(){
    return $this->modified;
  }
   
}

?>