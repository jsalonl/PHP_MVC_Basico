<?php

class LoanModel extends Model implements IModel{

  private $id;
  private $valor;
  private $porcentaje;
  private $valorTotal;
  private $valorPendiente;
  private $cuotas;
  private $estado;
  private $clienteId;
  private $nombreCliente;
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
    $this->valor=0;
    $this->porcentaje=0;
    $this->valorTotal=0;
    $this->valorPendiente=0;
    $this->cuotas=0;
    $this->estado=1;
    $this->clienteId=0;
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
      $query = $this->prepare('SELECT *, p.id id FROM prestamo p 
      LEFT JOIN cliente c ON(c.id=p.cliente_id)
      WHERE valor LIKE :valor LIMIT :pos, :n');
      $query->execute([
        ':valor'=> '%'.$this->term.'%',
        ':pos' => $this->indice,
        ':n' => $this->resultsPerPage
      ]);
    }else{
      $query = $this->prepare('SELECT *, p.id id FROM prestamo p 
      LEFT JOIN cliente c ON(c.id=p.cliente_id)
      LIMIT :pos, :n');
      $query->execute([':pos' => $this->indice, ':n' => $this->resultsPerPage]);
    }
    
    while($p=$query->fetch(PDO::FETCH_ASSOC)){
      $item = new LoanModel();
      $item->from($p);
      array_push($items,$item);
    }
    
    return $items;

  }

  function calculatePages(){
    $queryTotalResults = $this->query('SELECT COUNT(*) AS total FROM prestamo');
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
    $queryTotalResults = $this->query('SELECT COUNT(*) AS total FROM prestamo');
    $this->nResults = $queryTotalResults->fetch(PDO::FETCH_OBJ)->total;
    return $this->nResults;
  }

  public function save(){
    try{
      $query=$this->prepare('INSERT INTO prestamo(valor, porcentaje, valor_total, valor_pendiente, cuotas, estado, cliente_id, created, modified) values(:valor, :porcentaje, :valor_total, :valor_pendiente, :cuotas, :estado, :cliente_id, :created, :modified)');
      $query->execute([
        'valor'=>$this->valor,
        'porcentaje'=>$this->porcentaje,
        'valor_total'=>$this->valorTotal,
        'valor_pendiente'=>$this->valorPendiente,
        'cuotas'=>$this->cuotas,
        'estado'=>$this->estado,
        'cliente_id'=>$this->clienteId,
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
      $query=$this->query('SELECT * FROM prestamo');
      while($p=$query->fetch(PDO::FETCH_ASSOC)){
        $item = new ClientModel();
        $item->from($p);
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
      $query=$this->prepare('SELECT *, p.id id FROM prestamo p 
      LEFT JOIN cliente c ON(c.id=p.cliente_id) WHERE p.id=:id');
      $query->execute([
        'id'=>$id
      ]);
      
      $client=$query->fetch(PDO::FETCH_ASSOC);
      $this->from($client);
      
      return $this;

    }catch(PDOException $e){
      error_log('ClientModel::getId->PDOException '.$e);
      return false;
    }
  }

  public function delete($id){
    try{
      $query=$this->prepare('DELETE FROM prestamo WHERE id=:id');
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
      $query=$this->prepare('UPDATE prestamo SET valor=:valor, porcentaje=:porcentaje, valor_total=:valor_total, valor_pendiente=:valor_pendiente, modified=:modified WHERE id=:id');
      $query->execute([
        'id'=>$this->id,
        'valor'=>$this->valor,
        'porcentaje'=>$this->porcentaje,
        'valor_total'=>$this->valorTotal,
        'valor_pendiente'=>$this->valorPendiente,
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
    $this->valor = $array['valor'];
    $this->porcentaje = $array['porcentaje'];
    $this->valorTotal = $array['valor_total'];
    $this->valorPendiente = $array['valor_pendiente'];
    $this->cuotas = $array['cuotas'];
    $this->estado = $array['estado'];
    $this->clienteId = $array['cliente_id'];
    $this->nombreCliente = $array['nombre'];
    $this->created = $array['created'];
    $this->modified = $array['modified'];
  }

  public function exists($identificacion){
    try{
      $query=$this->prepare('SELECT identificacion FROM prestamo WHERE identificacion=:identificacion');
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

  private function getMoney($string){
    return number_format($string, 0, '', '.');
  }

  private function getPorcentajeToInt($string){
    return $string*100;
  }

  public function setId($id){
    $this->id=$id;
  }

  public function setValor($valor){
    $this->valor=$valor;
  }

  public function setPorcentaje($porcentaje){
    $this->porcentaje=$porcentaje;
  }

  public function setValorTotal($valorTotal){
    $this->valorTotal=$valorTotal;
  }

  public function setValorPendiente($valorPendiente){
    $this->valorPendiente=$valorPendiente;
  }

  public function setCuotas($cuotas){
    $this->cuotas=$cuotas;
  }

  public function setEstado($estado){
    $this->estado=$estado;
  }
  
  public function setClienteId($clienteId){
    $this->clienteId=$clienteId;
  }

  public function setNombreCliente($nombreCliente){
    $this->nombreCliente=$nombreCliente;
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

  public function getValor(){
    return $this->getMoney($this->valor);
  }

  public function getPorcentaje(){
    return $this->getPorcentajeToInt($this->porcentaje);
  }

  public function getValorTotal(){
    return $this->getMoney($this->valorTotal);
  }

  public function getValorPendiente(){
    return $this->getMoney($this->valorPendiente);
  }

  public function getCuotas(){
    return $this->cuotas;
  }

  public function getEstado(){
    return $this->estado;
  }

  public function getClienteId(){
    return $this->clienteId;
  }

  public function getNombreCliente(){
    return $this->nombreCliente;
  }

  public function getCreated(){
    return $this->created;
  }

  public function getModified(){
    return $this->modified;
  }
   
}

?>