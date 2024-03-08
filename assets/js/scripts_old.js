if(alerta){
Swal.fire({
    title: titulo,
    text: text,
    icon: icon,
    confirmButtonText: button
  })}


  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });


    $('.select2').select2()

    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })

  });