<?php
$user = $this->d['user'];
$clients = $this->d['clients'];
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
          <h4 class="page-title">Agregar Préstamo</h4>
        </div>
      </div>
    </div>
    
    <div class="row mt-4">
      <div class="col-lg-12 grid-margin stretch-card">
        
        <div class="card">
          <div class="card-body">

            <form action="<?php echo constant('URL');?>/loans/createLoan" method="POST" class="row">
              <div class="form-group col-md-6">
                <label for="clienteId">Cliente</label>
                <select name="clienteId" class="form-control">
                  <option value="">Seleccione el cliente</option>
                  <?php foreach($clients as $c):?>
                    <option value="<?php echo $c->getId(); ?>"><?php echo $c->getNombre(); ?></option>
                  <?php endforeach?>
                </select>
              </div>
              <div class="form-group col-md-6">
                <label for="valor">Valor préstamo</label>
                <div class="input-group">
                  <input type="tel" class="form-control" required placeholder="100000" name="valor">
                  <div class="input-group-append">
                    <span class="input-group-text">.00</span>
                  </div>
                </div>
              </div>
              <div class="form-group col-md-6">
                <label for="cuotas">Cuotas</label>
                <div class="input-group">
                  <input type="tel" class="form-control" required placeholder="30" name="cuotas">
                  <div class="input-group-append">
                    <span class="input-group-text">días</span>
                  </div>
                </div>
              </div>
              <div class="form-group col-md-6">
                <label for="porcentaje">Porcentaje préstamo </label>
                <div class="input-group">
                  <input type="tel" class="form-control" required placeholder="10" name="porcentaje">
                  <div class="input-group-append">
                    <span class="input-group-text">%</span>
                  </div>
                </div>
              </div>
              <div class="col-md-12 justify-content-center text-center mt-2">
                <button type="submit" class="btn btn-lg btn-block btn-success">Guardar</button>
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