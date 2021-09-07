<?php
$user = $this->d['user'];
$users = $this->d['users'];
$users_paginate = $this->d['users_paginate'];
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
          <h4 class="page-title">Módulo Usuarios</h4>
        </div>
      </div>
    </div>

    <div class="row mt-4">
      <div class="col col-md-12">
        <form method="POST" action="<?php echo constant('URL');?>/users">
          <div class="input-group">
            <div class="input-group-prepend">
              <button type="button" onclick="add()" class="btn btn-md btn-primary">Agregar Usuario</button>
            </div>
            <input type="text" name='term' class="form-control form-control-lg" placeholder="Buscar">
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
                    <th>Nombre</th>
                    <th>Teléfono</th>
                    <th>Estado</th>
                    <th>Rol</th>
                    <th>Accion</th>
                  </tr>
                </thead>
                <tbody>
                <?php if(!empty($users)): ?>
                  <?php foreach($users as $row):?>
                    <tr>
                      <td><?php echo $row->getNombre()?></td>
                      <td><?php echo $row->getTelefono()?></td>
                      <td>
                        <?php if($row->getEstado()==0):?>
                          <span class="badge badge-danger">Inactivo</span>
                        <?php else:?>
                          <span class="badge badge-success">Activo</span>
                        <?php endif?>
                      </td>
                      <td><?php echo $row->getRol()?></td>
                      <td>
                        <a href="<?php echo constant('URL').'/users/edit?id='.$row->getId();?>"><i class="mdi mdi-pencil text-warning icon-sm"></i></a>
                        <a href="#" onclick="remove(<?php echo $row->getId() ?>);return false;"><i class="mdi mdi-close-circle text-danger icon-sm"></i></a>
                      </td>
                    </tr>
                  <?php endforeach?>
                <?php endif?>
                </tbody>
                <tfoot>
                  <tr>
                    <th colspan="5">
                      <?php echo $users_paginate ?>
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
      window.location.href = 'users/add';
    }

    function remove(id){
      if (window.confirm("¿Seguro desea eliminar este registro?, se eliminará también los pagos recibidos")) {
        window.location.href = 'users/remove?id='+id;
      }
    }
  </script>
  <?php
  include('views/footer.php');
  include('views/scripts.php');
  ?>