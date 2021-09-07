<?php

class ClientModel extends Model implements IModel{

  private $id;
  private $identificacion;
  private $nombre;
  private $telefono;
  private $direccion;
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
    $this->direccion='';
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
      $query = $this->prepare('SELECT * FROM cliente WHERE nombre LIKE :nombre OR telefono LIKE :telefono LIMIT :pos, :n');
      $query->execute([
        ':nombre'=> '%'.$this->term.'%',
        ':telefono'=> '%'.$this->term.'%',
        ':pos' => $this->indice,
        ':n' => $this->resultsPerPage
      ]);
    }else{
      $query = $this->prepare('SELECT * FROM cliente LIMIT :pos, :n');
      $query->execute([':pos' => $this->indice, ':n' => $this->resultsPerPage]);
    }
    
    while($p=$query->fetch(PDO::FETCH_ASSOC)){
      $item = new ClientModel();
      $item->setId($p['id']);
      $item->setIdentificacion($p['identificacion']);
      $item->setNombre($p['nombre']);
      $item->setTelefono($p['telefono']);
      $item->setDireccion($p['direccion']);
      $item->setCreated($p['created']);
      $item->setModified($p['modified']);
      array_push($items,$item);
    }
    
    return $items;

  }

  function calculatePages(){
    $queryTotalResults = $this->query('SELECT COUNT(*) AS total FROM cliente');
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
    $queryTotalResults = $this->query('SELECT COUNT(*) AS total FROM cliente');
    $this->nResults = $queryTotalResults->fetch(PDO::FETCH_OBJ)->total;
    return $this->nResults;
  }

  public function save(){
    try{
      $query=$this->prepare('INSERT INTO cliente(identificacion, nombre, telefono, direccion, created, modified) values(:identificacion, :nombre, :telefono, :direccion, :created, :modified)');
      $query->execute([
        'identificacion'=>$this->identificacion,
        'nombre'=>$this->nombre,
        'telefono'=>$this->telefono,
        'direccion'=>$this->direccion,
        'created'=>$this->created,
        'modified'=>$this->modified
      ]);
      return true;
    }catch(PDOException $e){
      error_log('ClientModel::save->PDOException '.$e);
      return false;
    }
  }

  public function getAll(){
    try{
      $items = [];
      $query=$this->query('SELECT * FROM cliente');
      while($p=$query->fetch(PDO::FETCH_ASSOC)){
        $item = new ClientModel();
        $item->setId($p['id']);
        $item->setIdentificacion($p['identificacion']);
        $item->setNombre($p['nombre']);
        $item->setTelefono($p['telefono']);
        $item->setDireccion($p['direccion']);
        $item->setCreated($p['created']);
        $item->setModified($p['modified']);
        array_push($items,$item);
      }
      
      return $items;

    }catch(PDOException $e){
      error_log('ClientModel::getAll->PDOException '.$e);
      return false;
    }
  }

  public function get($id){
    try{
      $items = [];
      $query=$this->prepare('SELECT * FROM cliente WHERE id=:id');
      $query->execute([
        'id'=>$id
      ]);
      
      $client=$query->fetch(PDO::FETCH_ASSOC);
      $this->setId($client['id']);
      $this->setIdentificacion($client['identificacion']);
      $this->setNombre($client['nombre']);
      $this->setTelefono($client['telefono']);
      $this->setDireccion($client['direccion']);
      $this->setCreated($client['created']);
      $this->setModified($client['modified']);
      
      return $this;

    }catch(PDOException $e){
      error_log('ClientModel::getId->PDOException '.$e);
      return false;
    }
  }

  public function delete($id){
    try{
      $query=$this->prepare('DELETE FROM cliente WHERE id=:id');
      $query->execute([
        'id'=>$id
      ]);

      return true;
    }catch(PDOException $e){
      error_log('ClientModel::delete->PDOException '.$e);
      return false;
    }
  }

  public function update(){
    try{
      $query=$this->prepare('UPDATE cliente SET identificacion=:identificacion, nombre=:nombre, telefono=:telefono, direccion=:direccion, modified=:modified WHERE id=:id');
      $query->execute([
        'id'=>$this->id,
        'identificacion'=>$this->identificacion,
        'nombre'=>$this->nombre,
        'telefono'=>$this->telefono,
        'direccion'=>$this->direccion,
        'modified'=>$this->modified
      ]);
      
      return true;

    }catch(PDOException $e){
      error_log('ClientModel::udpate->PDOException '.$e);
      return false;
    }
  }

  public function from($array){
    $this->id = $array['id'];
    $this->identificacion = $array['identificacion'];
    $this->nombre = $array['nombre'];
    $this->telefono = $array['telefono'];
    $this->direccion = $array['direccion'];
    $this->created = $array['created'];
    $this->modified = $array['modified'];
  }

  public function exists($identificacion){
    try{
      $query=$this->prepare('SELECT identificacion FROM cliente WHERE identificacion=:identificacion');
      $query->execute([
        'identificacion'=>$identificacion
      ]);
      if($query->rowCount()>0){
        return true;
      }else{
        return false;
      }
    }catch(PDOException $e){
      error_log('ClientModel::exists->PDOException '.$e);
      return false;
    }
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

  public function setDireccion($direccion){
    $this->direccion=$direccion;
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

  public function getDireccion(){
    return $this->direccion;
  }

  public function getCreated(){
    return $this->created;
  }

  public function getModified(){
    return $this->modified;
  }
   
}

?>