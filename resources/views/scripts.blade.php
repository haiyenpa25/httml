<!-- Meta CSRF để Ajax hoạt động -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>

<!-- Các thư viện cần thiết -->
<script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
<script src="{{ asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<script>$.widget.bridge('uibutton', $.ui.button);</script>
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<script src="{{ asset('dist/js/adminlte.js') }}"></script>

<!-- DataTables JS -->
<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>

<!-- Toastr notifications -->
<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<!-- CSRF setup cho Ajax -->
<script>
  $.ajaxSetup({
    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
  });
</script>

<!-- Helper functions -->
<script>
  // Format date using moment.js
  function formatDate(dateString) {
    return dateString ? moment(dateString).format('DD/MM/YYYY') : 'N/A';
  }
  
  // Debounce function to prevent multiple rapid calls
  function debounce(func, wait) {
    let timeout;
    return function (...args) {
      const context = this;
      clearTimeout(timeout);
      timeout = setTimeout(() => func.apply(context, args), wait);
    };
  }

  // Initialize Select2 elements if they exist on the page
  $(document).ready(function() {
    if ($('.select2bs4').length) {
      $('.select2bs4').select2({ theme: 'bootstrap4' });
    }
    
    // Initialize date pickers if they exist
    if ($('.date-picker').length) {
      $('.date-picker').datetimepicker({
        format: 'L'
      });
    }
  });
</script>

<!-- Include any page-specific scripts -->
@yield('page-scripts')