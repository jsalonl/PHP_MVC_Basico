<?php
$user = $this->d['user'];
$users = $this->d['users'];
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
          <h4 class="page-title">Editar Usuario</h4>
        </div>
      </div>
    </div>
    
    <div class="row mt-4">
      <div class="col-lg-12 grid-margin stretch-card">
        
        <div class="card">
          <div class="card-body">

            <form action="<?php echo constant('URL');?>/users/updateUser" method="POST" class="row">
              <input type="hidden" name="id" value="<?php echo $users->getId()?>">
              <div class="form-group col-md-6">
                <label for="identificacion">Identificación</label>
                <input type="tel" class="form-control" value="<?php echo $users->getIdentificacion()?>" required name="identificacion">
              </div>
              <div class="form-group col-md-6">
                <label for="nombre">Nombre completo</label>
                <input type="text" class="form-control" value="<?php echo $users->getNombre()?>" required name="nombre">
              </div>
              <div class="form-group col-md-6">
                <label for="telefono">Teléfono</label>
                <input type="tel" class="form-control" value="<?php echo $users->getTelefono()?>" required name="telefono">
              </div>
              <div class="form-group col-md-6">
                <label for="estado">Estado</label>
                <select name="estado" class="form-control">
                  <option <?php if($users->getEstado() == 0){ echo 'selected';} ?> value="0">Inactivo</option>
                  <option <?php if($users->getEstado() == 1){ echo 'selected';} ?> value="1">Activo</option>
                </select>
              </div>
              <div class="form-group col-md-6">
                <label for="rol">Rol</label>
                <select name="rol" class="form-control">
                  <option <?php if($users->getRol() == 'cobrador'){ echo 'selected';} ?> value="cobrador" selected>Cobrador</option>
                  <option <?php if($users->getRol() == 'admin'){ echo 'selected';} ?> value="admin">Administrador</option>
                </select>
              </div>
              <div class="col-md-12 justify-content-center text-center mt-2">
                <button type="submit" class="btn btn-lg btn-block btn-success">Actualizar</button>
              </div>
            </form>

          </div>
        </div>

      </div>
    </div>
    
  </div>
  
  <?php
  include('views/footer.php');
  include('views/scripts.php');
  ?>