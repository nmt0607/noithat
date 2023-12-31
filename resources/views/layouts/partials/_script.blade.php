<!-- jQuery -->
<!-- <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script> -->
<!-- jQuery UI 1.11.4 -->
<!-- <script src="{{ asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script> -->
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  // $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="https://kit.fontawesome.com/a656ea2bb9.js" crossorigin="anonymous"></script>
<!-- ChartJS -->
<script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>
<script src="{{ asset('js/qlsp.js') }}"></script>
<!-- Sparkline -->
<!-- <script src="{{ asset('plugins/sparklines/sparkline.js') }}"></script> -->
<!-- JQVMap -->
<!-- <script src="{{ asset('plugins/jqvmap/jquery.vmap.min.js') }}"></script> -->
<!-- <script src="{{ asset('plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script> -->
<!-- jQuery Knob Chart -->
<!-- <script src="{{ asset('plugins/jquery-knob/jquery.knob.min.js') }}"></script> -->
<!-- daterangepicker -->
<script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<!-- <script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script> -->
<!-- Summernote -->
<script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>
<!-- overlayScrollbars -->
<script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('dist/js/adminlte.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<!-- <script src="{{ asset('dist/js/demo.js') }}"></script> -->
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<!-- <script src="{{ asset('dist/js/pages/dashboard.js') }}"></script> -->

<!-- <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/jszip/jszip.min.js') }}"></script> -->

<!-- <script src="{{ asset('plugins/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('plugins/pdfmake/vfs_fonts.js') }}"></script> -->

<!-- <script src="{{ asset('plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script> -->

<!-- <script>
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
  });
</script> -->


<!-- <script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script> -->
<!-- Toastr -->
<script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>

<script>
  window.addEventListener('show-toast', event => {
        if (event.detail.type == "success") {
            toastr.success(event.detail.message);
        } else if (event.detail.type == "error") {
            toastr.error(event.detail.message);
        }
    });
</script>

{{-- select2 --}}
<script src="{{asset('plugins/select2/js/select2.min.js')}}"></script>
<script src="{{asset('js/helper.js')}}"></script>
{{-- js tree --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/jstree.min.js"></script>
<script src="https://kit.fontawesome.com/a656ea2bb9.js" crossorigin="anonymous"></script>
<script>
  toastr.options = {
    "closeButton": false,
    "debug": false,
    "progressBar": true,
    "positionClass": "toast-top-right",
    "onclick": null,
    "showDuration": "300",
    "hideDuration": "1000",
    "timeOut": "3000",
    "extendedTimeOut": "1000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
  }
</script>
<!-- Hiển thị thông báo thành công  -->
@if ( Session::has('success'))
    <script>
        toastr.success("{{ Session::get('success') }}");
    </script>
@endif
<!-- Hiển thị thông báo lỗi  -->
@if ( Session::has('error'))
    <script>
        toastr.error("{{ Session::get('error') }}");
    </script>
@endif

@if ( Session::has('errorVersion2'))
    <script>
        toastr.error("{{ Str::limit(Session::get('errorVersion2'),200) }}"); 
    </script>   
    <button type="button" style='display: none;' data-target="#modal-download-error" data-toggle="modal" id='btn-download-error'>download</button>  
    <?php
        session()->forget('errorVersion2');
    ?>
@endif