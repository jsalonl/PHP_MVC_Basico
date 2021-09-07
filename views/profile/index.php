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
          <h4 class="page-title">Mi perfil</h4>
        </div>
      </div>
    </div>
    
    <div class="row mt-4">
      <div class="col-lg-12 grid-margin stretch-card">
        
        <div class="card">
          <div class="card-body">

            <form action="<?php echo constant('URL');?>/profile/updateUser" method="POST" class="row">
              <input type="hidden" name="id" value="<?php echo $users->getId()?>">
              <div class="form-group col-md-6">
                <label for="identificacion">Identificación</label>
                <input type="tel" class="form-control" disabled value="<?php echo $users->getIdentificacion()?>" name="identificacion">
              </div>
              <div class="form-group col-md-6">
                <label for="nombre">Nombre completo</label>
                <input type="text" class="form-control" value="<?php echo $users->getNombre()?>" required name="nombre">
              </div>
              <div class="form-group col-md-6">
                <label for="telefono">Teléfono</label>
                <input type="tel" class="form-control" value="<?php echo $users->getTelefono()?>" required name="telefono">
              </div>
              <div class="col-md-12 justify-content-center text-center mt-2">
                <button type="submit" class="btn btn-lg btn-block btn-success">Actualizar</button>
              </div>
            </form>

          </div>
        </div>

      </div>
    </div>

    <div class="row page-title-header">
      <div class="col-12">
        <div class="page-header">
          <h4 class="page-title">Cambiar contraseña</h4>
        </div>
      </div>
    </div>

    <div class="row mt-4">
      <div class="col-lg-12 grid-margin stretch-card">
        
        <div class="card">
          <div class="card-body">

            <form action="<?php echo constant('URL');?>/profile/updatePassword" method="POST" class="row">
              <input type="hidden" name="id" value="<?php echo $users->getId()?>">
              <div class="form-group col-md-6">
                <label for="password">Contraseña nueva</label>
                <input type="password" class="form-control" required name="password">
              </div>
              <div class="form-group col-md-6">
                <label for="repeat_password">Repita la contraseña</label>
                <input type="repeat_password" class="form-control" required name="repeat_password">
              </div>
              <div class="col-md-12 justify-content-center text-center mt-2">
                <button type="submit" class="btn btn-lg btn-block btn-info">Cambiar Contraseña</button>
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