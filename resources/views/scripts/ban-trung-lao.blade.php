@section('page-styles')
    <!-- Select2 CSS -->
    <style>
        .select2-container--bootstrap4 .select2-selection__rendered {
            color: #333 !important;
            line-height: 34px !important;
            padding-left: 10px !important;
        }
        .select2-container--bootstrap4 .select2-selection--single {
            height: 38px !important;
            border: 1px solid #ced4da !important;
            border-radius: 0.25rem !important;
        }
        .select2-container--bootstrap4 .select2-selection--single .select2-selection__placeholder {
            color: #6c757d !important;
        }
        .select2-container--bootstrap4 .select2-selection--single .select2-selection__arrow {
            height: 38px !important;
            top: 0 !important;
        }
        .select2-container--bootstrap4 .select2-selection--single .select2-selection__clear {
            margin-top: 0 !important;
            line-height: 38px !important;
        }
        .select2-container--bootstrap4 .select2-dropdown {
            border: 1px solid #ced4da !important;
        }
        .select2-container--bootstrap4 .select2-results__option {
            color: #333 !important;
        }
        /* Responsive adjustments for buttons */
        .button-container {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }
        .button-container .btn-group {
            flex: 1 1 auto;
        }
        .button-container .btn {
            white-space: normal;
            word-wrap: break-word;
            padding: 8px 12px;
            font-size: 14px;
            min-width: 120px;
            margin-bottom: 8px;
        }
        @media (max-width: 576px) {
            .button-container {
                flex-direction: column;
                align-items: stretch;
            }
            .button-container .btn-group {
                width: 100%;
            }
            .button-container .btn {
                width: 100%;
                min-width: unset;
                font-size: 16px;
                padding: 10px;
                margin-bottom: 10px;
            }
            .button-container .btn i {
                margin-right: 8px;
            }
        }
    </style>
@endsection

@section('page-scripts')
<script>
    $(document).ready(function () {
        // Xử lý dữ liệu cho modal chỉnh sửa chức vụ
        $('#modal-edit-chuc-vu').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var banId = button.data('ban-id');
            var ten = button.data('ten');
            var chucVu = button.data('chucvu');
            
            var modal = $(this);
            modal.find('#edit_tin_huu_id').val(id);
            modal.find('#edit_ban_nganh_id').val(banId);
            modal.find('#edit_ten_tin_huu').text(ten);
            modal.find('#edit_chuc_vu').val(chucVu);
        });
        
        // Xử lý dữ liệu cho modal xóa thành viên
        $('#modal-xoa-thanh-vien').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var banId = button.data('ban-id');
            var ten = button.data('ten');
            
            var modal = $(this);
            modal.find('#delete_tin_huu_id').val(id);
            modal.find('#delete_ban_nganh_id').val(banId);
            modal.find('#delete_ten_tin_huu').text(ten);
        });
    });
</script>
@endsection