<?php
$user = $this->d['user'];
$clients = $this->d['clients'];
$clients_paginate = $this->d['clients_paginate'];
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
          <h4 class="page-title">Módulo Clientes</h4>
        </div>
      </div>
    </div>

    <div class="row mt-4">
      <div class="col col-md-12">
        <form method="POST" action="<?php echo constant('URL');?>/clients">
          <div class="input-group">
            <div class="input-group-prepend">
              <button type="button" onclick="add()" class="btn btn-md btn-primary">Agregar Cliente</button>
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

            <div class="col-md-12">
              <table class="table table-hover table-striped table-responsive-sm" width="100%">
                <thead>
                  <tr>
                    <th>Identificación</th>
                    <th>Nombre</th>
                    <th>Teléfono</th>
                    <th>Dirección</th>
                    <th>Accion</th>
                  </tr>
                </thead>
                <tbody>
                <?php if(!empty($clients)): ?>
                  <?php foreach($clients as $row):?>
                    <tr>
                      <td><?php echo $row->getIdentificacion()?></td>
                      <td><?php echo $row->getNombre()?></td>
                      <td><?php echo $row->getTelefono()?></td>
                      <td><?php echo $row->getDireccion()?></td>
                      <td>
                        <a href="<?php echo constant('URL').'/clients/edit?id='.$row->getId();?>"><i class="mdi mdi-pencil text-warning icon-sm"></i></a>
                        <a href="#" onclick="remove(<?php echo $row->getId() ?>);return false;"><i class="mdi mdi-close-circle text-danger icon-sm"></i></a>
                      </td>
                    </tr>
                  <?php endforeach?>
                <?php endif?>
                </tbody>
                <tfoot>
                  <tr>
                    <th colspan="5">
                      <?php echo $clients_paginate ?>
                    </th>
                  </tr>
                </tfoot>
              </table>
              <!-- -->
            </div>

          </div>
        </div>

      </div>
    </div>
    
  </div>
  <script>
    function add(){
      window.location.href = 'clients/add';
    }

    function remove(id){
      if (window.confirm("¿Seguro desea eliminar este registro?, se eliminará también los pagos recibidos")) {
        window.location.href = 'clients/remove?id='+id;
      }
    }
  </script>
  <?php
  include('views/footer.php');
  include('views/scripts.php');
  ?>