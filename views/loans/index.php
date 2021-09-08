<?php
$user = $this->d['user'];
$loans = $this->d['loans'];
$loans_paginate = $this->d['loans_paginate'];
$term = $this->d['term'];
?>
<?php 
  include('views/head.php');
  include('views/header.php');
  include('views/sidebar.php');
?>
  <div class="row-fluid text-center">
    <?php $this->showMessages();?>
  </div>
  <div class="content-wrapper">
    <div class="row page-title-header">
      <div class="col-12">
        <div class="page-header">
          <h4 class="page-title">Módulo Préstamos</h4>
        </div>
      </div>
    </div>

    <div class="row mt-4">
      <div class="col col-md-12">
        <form method="POST" action="<?php echo constant('URL');?>/loans">
          <div class="input-group">
            <div class="input-group-prepend">
              <button type="button" onclick="add()" class="btn btn-md btn-primary">Agregar Préstamo</button>
            </div>
            <input type="text" name='term' class="form-control form-control-lg" placeholder="Buscar" value="<?php echo $term?>">
            <div class="input-group-append bg-primary border-primary">
              <button class="btn btn-success" type="submit"><i class="mdi mdi-magnify text-white icon-md"></i></button>
            </div>
          </div>
        </form>
        <!-- -->
      </div>
    </div>
    
    <div class="row mt-4">
      <div class="col-lg-12 grid-margin stretch-card">
        
        <div class="card">
          <div class="card-body">

            <div id="no-more-tables">
              <table class="col-sm-12 table table-hover table-striped table-condensed cf" width="100%">
                <thead class="cf">
                  <tr>
                    <th>Cliente</th>
                    <th>Valor Préstamo</th>
                    <th>Valor a pagar</th>
                    <th>Cuotas</th>
                    <th>Valor pendiente</th>
                    <th>Fecha</th>
                    <th>Ultimo pago</th>
                    <th>Accion</th>
                  </tr>
                </thead>
                <tbody>
                <?php if(!empty($loans)): ?>
                  <?php foreach($loans as $row):?>
                    <tr>
                      <td data-title="Cliente"><?php echo $row->getNombreCliente()?></td>
                      <td data-title="Valor Préstamo"><?php echo $row->getValor()?></td>
                      <td data-title="Valor a pagar"><?php echo $row->getValorTotal()?></td>
                      <td data-title="Cuotas"><?php echo $row->getCuotas()?></td>
                      <td data-title="Valor pendiente"><?php echo $row->getValorPendiente()?></td>
                      <td data-title="Fecha"><?php echo $row->getCreated()?></td>
                      <td data-title="Ultimo pago"><?php echo $row->getModified()?></td>
                      <td data-title="Accion">
                        <a href="<?php echo constant('URL').'/loans/edit?id='.$row->getId();?>"><i class="mdi mdi-pencil text-warning icon-sm"></i></a>
                        <a href="#" onclick="remove(<?php echo $row->getId() ?>);return false;"><i class="mdi mdi-close-circle text-danger icon-sm"></i></a>
                      </td>
                    </tr>
                  <?php endforeach?>
                <?php endif?>
                </tbody>
              </table>
              <div class="col-md-12 mt-2">
                <?php echo $loans_paginate ?>
              </div>
              <!-- -->
            </div>

          </div>
        </div>

      </div>
    </div>
    
  </div>
  <script>
    function add(){
      window.location.href = 'loans/add';
    }

    function remove(id){
      if (window.confirm("¿Seguro desea eliminar este registro?, se eliminará también los pagos recibidos")) {
        window.location.href = 'loans/remove?id='+id;
      }
    }
  </script>
  <?php
  include('views/footer.php');
  include('views/scripts.php');
  ?>