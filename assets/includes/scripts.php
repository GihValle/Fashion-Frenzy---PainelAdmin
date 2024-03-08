


<!-- jQuery -->
<script src="<?php echo $comp?>../vendor/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?php echo $comp?>../vendor/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="<?php echo $comp?>../vendor/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="<?php echo $comp?>../vendor/plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="<?php echo $comp?>../vendor/plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="<?php echo $comp?>../vendor/plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="<?php echo $comp?>../vendor/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="<?php echo $comp?>../vendor/plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="<?php echo $comp?>../vendor/plugins/moment/moment.min.js"></script>
<script src="<?php echo $comp?>../vendor/plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="<?php echo $comp?>../vendor/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="<?php echo $comp?>../vendor/plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="<?php echo $comp?>../vendor/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- DataTables  & Plugins -->
<script src="<?php echo $comp?>../vendor/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo $comp?>../vendor/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo $comp?>../vendor/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo $comp?>../vendor/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="<?php echo $comp?>../vendor/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?php echo $comp?>../vendor/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="<?php echo $comp?>../vendor/plugins/jszip/jszip.min.js"></script>
<script src="<?php echo $comp?>../vendor/plugins/pdfmake/pdfmake.min.js"></script>
<script src="<?php echo $comp?>../vendor/plugins/pdfmake/vfs_fonts.js"></script>
<script src="<?php echo $comp?>../vendor/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="<?php echo $comp?>../vendor/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="<?php echo $comp?>../vendor/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<!-- Bootstrap Switch -->
<script src="<?php echo $comp?>../vendor/plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo $comp?>../vendor/dist/js/adminlte.js"></script>
<!-- AdminLTE for demo purposes -->
<!-- <script src="../vendor/dist/js/demo.js"></script> -->
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="<?php echo $comp?>../vendor/dist/js/pages/dashboard.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.9.0/dist/sweetalert2.all.min.js"></script>

<?php 

  


  if (isset($_GET['msg']) && isset($_GET['status']) || isset($status) && isset($msg)){

    $alert = true;
    $status = isset($_GET['status']) ? $_GET['status'] : $status ;
    $msg = isset($_GET['msg']) ? $_GET['msg'] : $msg ;
    if ($status == "success"){
      $icon = "success";
      $titulo = "Sucesso";
    }else{
      $icon = "error";
      $titulo = "Falha";
    }
  }else{
    $alert = false;
    $status="";
    $titulo="";
    $msg="";
    $icon="";
  }

?>
<script> 
  let alerta = "<?php echo $alert ?>"
  let titulo = "<?php echo $titulo ?>";
  let text = "<?php echo $msg ?>";
  let icon = "<?php echo $icon ?>";
  let buttom = "Continuar";
</script>

<script src="<?php echo $comp?>../assets/js/scripts.js"></script> <!-- Scripts personalizados -->

