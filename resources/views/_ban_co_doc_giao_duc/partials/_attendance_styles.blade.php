<style>
    .card {
        border-radius: 10px;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.05);
        border: none;
    }

    .card-header {
        background-color: #fff;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        padding: 15px 20px;
    }

    .card-title {
        font-weight: 600;
        color: #3c4b64;
    }

    .btn-primary {
        background-color: #4e73df;
        border-color: #4e73df;
    }

    .btn-primary:hover {
        background-color: #3a5ccc;
        border-color: #3a5ccc;
    }

    .btn-success {
        background-color: #1cc88a;
        border-color: #1cc88a;
    }

    .btn-success:hover {
        background-color: #17a673;
        border-color: #17a673;
    }

    .select2-container--bootstrap4 .select2-selection--single {
        height: calc(2.25rem + 2px);
        padding: .375rem .75rem;
    }

    .attendance-checkbox {
        width: 20px;
        height: 20px;
        cursor: pointer;
    }

    .stat-card {
        border-left: 4px solid;
        border-radius: 8px;
        transition: transform 0.2s;
    }

    .stat-card:hover {
        transform: translateY(-5px);
    }

    .stat-card .stat-icon {
        font-size: 2rem;
        opacity: 0.3;
        position: absolute;
        right: 20px;
        top: 15px;
    }

    .stat-card .stat-value {
        font-size: 1.8rem;
        font-weight: 700;
    }

    .stat-card .stat-label {
        text-transform: uppercase;
        font-size: 0.9rem;
        font-weight: 500;
        color: #6c757d;
    }

    .table th {
        background-color: #f8f9fc;
        color: #5a5c69;
        font-weight: 600;
        border: none;
    }

    .table td {
        vertical-align: middle;
        border-color: #f3f3f3;
    }

    .table-hover tbody tr:hover {
        background-color: #f8f9ff;
    }

    .table-responsive {
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.03);
    }

    .breadcrumb {
        background-color: transparent;
        padding: 0;
    }

    .breadcrumb-item a {
        color: #4e73df;
    }

    .attendance-toggle {
        position: relative;
        display: inline-block;
        width: 48px;
        height: 24px;
    }

    .attendance-toggle input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .attendance-slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        transition: .4s;
        border-radius: 24px;
    }

    .attendance-slider:before {
        position: absolute;
        content: "";
        height: 18px;
        width: 18px;
        left: 3px;
        bottom: 3px;
        background-color: white;
        transition: .4s;
        border-radius: 50%;
    }

    input:checked+.attendance-slider {
        background-color: #1cc88a;
    }

    input:checked+.attendance-slider:before {
        transform: translateX(24px);
    }

    .modal-content {
        border-radius: 10px;
        border: none;
    }

    .modal-header {
        background-color: #4e73df;
        color: white;
        border-radius: 10px 10px 0 0;
        border-bottom: none;
    }

    .modal-title {
        font-weight: 600;
    }

    .modal-header .close {
        color: white;
        opacity: 0.8;
    }

    .modal-footer {
        border-top: 1px solid rgba(0, 0, 0, 0.05);
    }

    .border-left-success {
        border-left-color: #1cc88a !important;
    }

    .border-left-danger {
        border-left-color: #e74a3b !important;
    }

    .border-left-info {
        border-left-color: #36b9cc !important;
    }

    .text-highlight {
        animation: highlight 0.5s ease-in-out;
    }

    @keyframes highlight {
        0% {
            color: inherit;
        }

        50% {
            color: #4e73df;
        }

        100% {
            color: inherit;
        }
    }
</style>