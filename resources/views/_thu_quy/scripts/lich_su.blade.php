<script>
    $(document).ready(function () {
        $('#lichSuTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route("_thu_quy.lich_su.data") }}',
            columns: [
                { data: 'nguoi_dung', name: 'nguoi_dung' },
                { data: 'hanh_dong', name: 'hanh_dong' },
                { data: 'bang_tac_dong', name: 'bang_tac_dong' },
                { data: 'created_at', name: 'created_at' }
            ],
            language: {
                url: 'dist/js/Vietnamese.json'
            }
        });
    });
</script>