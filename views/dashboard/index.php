<?php
$user = $this->d['user'];
$total_users = $this->d['total_users'];
$total_clients = $this->d['total_clients'];
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
          <h4 class="page-title">Dashboard</h4>
        </div>
      </div>
    </div>

    <div class="row">
      
      <div class="col-md-4 grid-margin stretch-card average-price-card">
        <div class="card text-white">
          <div class="card-body">
            <div class="d-flex justify-content-between pb-2 align-items-center">
              <h2 class="font-weight-semibold mb-0"><?php echo $total_users ?></h2>
              <div class="icon-holder">
                <i class="mdi mdi-briefcase-outline"></i>
              </div>
            </div>
            <div class="d-flex justify-content-between">
              <h5 class="font-weight-semibold mb-0">Total Usuarios</h5>
              <p class="text-white mb-0">Actualizado hoy</p>
            </div>
          </div>
        </div>
      </div>
      
      <div class="col-md-4 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">
                <div class="d-flex align-items-center pb-2">
                  <div class="dot-indicator bg-danger mr-2"></div>
                  <p class="mb-0">Total Sales</p>
                </div>
                <h4 class="font-weight-semibold">$7,590</h4>
                <div class="progress progress-md">
                  <div class="progress-bar bg-danger" role="progressbar" style="width: 78%" aria-valuenow="78" aria-valuemin="0" aria-valuemax="78"></div>
                </div>
              </div>
              <div class="col-md-6 mt-4 mt-md-0">
                <div class="d-flex align-items-center pb-2">
                  <div class="dot-indicator bg-success mr-2"></div>
                  <p class="mb-0">Active Users</p>
                </div>
                <h4 class="font-weight-semibold">$5,460</h4>
                <div class="progress progress-md">
                  <div class="progress-bar bg-success" role="progressbar" style="width: 45%" aria-valuenow="45" aria-valuemin="0" aria-valuemax="45"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-4 grid-margin stretch-card average-price-card">
        <div class="card text-white">
          <div class="card-body">
            <div class="d-flex justify-content-between pb-2 align-items-center">
              <h2 class="font-weight-semibold mb-0"><?php echo $total_clients ?></h2>
              <div class="icon-holder">
                <i class="mdi mdi-briefcase-outline"></i>
              </div>
            </div>
            <div class="d-flex justify-content-between">
              <h5 class="font-weight-semibold mb-0">Total Clientes</h5>
              <p class="text-white mb-0">Actualizado hoy</p>
            </div>
          </div>
        </div>
      </div>
      
    </div>
  </div>
  
  <?php
  include('views/footer.php');
  include('views/scripts.php');
  ?>