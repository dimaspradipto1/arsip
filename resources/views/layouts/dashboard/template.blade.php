<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('dashboard/assets/img/uis.png') }}">
  <link rel="icon" type="image/png" href="{{ asset('dashboard/assets/img/uis.png') }}">
  <title>
    Dashboard
  </title>
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <!-- Nucleo Icons -->
  <link href="{{ asset('dashboard/assets/css/nucleo-icons.css') }}" rel="stylesheet" />
  <link href="{{ asset('dashboard/assets/css/nucleo-svg.css') }}" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link href="{{ asset('dashboard/assets/css/nucleo-svg.css') }}" rel="stylesheet" />
  <!-- CSS Files -->
  <link id="pagestyle" href="{{ asset('dashboard/assets/css/soft-ui-dashboard.css?v=1.0.3') }}" rel="stylesheet" />
  {{--  datatables CSS  --}}
  <link rel="stylesheet" href="https://cdn.datatables.net/2.3.4/css/dataTables.bootstrap5.css">
  {{--  Select2 CSS  --}}
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
  <style>
    :root {
      --primary-uis: #046B26;
      --primary-uis-hover: #03521D;
      --primary-uis-light: #E8F5E9;
    }
    html, body {
      overflow-x: hidden !important;
      max-width: 100vw !important;
    }
    body {
      font-family: 'Open Sans', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
      background-color: #f8fafc;
    }
    .main-content {
      overflow-x: hidden !important;
      min-height: 100vh;
    }
    /* Sembunyikan semua horizontal scrollbar track (PerfectScrollbar & browser) */
    .ps__rail-x,
    .main-content .ps__rail-x,
    body > .ps__rail-x,
    html > .ps__rail-x,
    .ps__thumb-x {
      display: none !important;
      visibility: hidden !important;
      opacity: 0 !important;
      pointer-events: none !important;
      height: 0 !important;
      width: 0 !important;
    }
    /* Hide scrollbar tracks attached to navbar */
    .navbar .ps__rail-x, .navbar .ps__rail-y, .navbar-collapse .ps__rail-x, .navbar-collapse .ps__rail-y {
      display: none !important;
    }
    .bg-gradient-primary, .btn-primary {
      background: linear-gradient(310deg, #046B26 0%, #0db846 100%) !important;
      border: none !important;
      box-shadow: 0 4px 12px rgba(4, 107, 38, 0.25);
    }
    .btn-primary:hover, .btn-primary:focus {
      background: linear-gradient(310deg, #03521D 0%, #089637 100%) !important;
      box-shadow: 0 6px 16px rgba(4, 107, 38, 0.35);
    }
    .card {
      border-radius: 14px;
      border: 1px solid rgba(0,0,0,0.04);
      box-shadow: 0 8px 24px rgba(149, 157, 165, 0.08);
      transition: box-shadow 0.2s ease;
    }
    @media (min-width: 1200px) {
      .g-sidenav-show .main-content {
        margin-left: 17.5rem !important;
        padding-right: 0.5rem !important;
      }
    }
    .main-content .container-fluid {
      padding-left: 1.5rem !important;
      padding-right: 1.5rem !important;
    }
    @media (max-width: 768px) {
      .main-content .container-fluid {
        padding-left: 0.75rem !important;
        padding-right: 0.75rem !important;
      }
    }
    /* Modal & Backdrop Layering */
    .modal-backdrop {
      z-index: 1065 !important;
    }
    .modal {
      z-index: 1070 !important;
    }
    /* Navbar & Dropdown Layering */
    #navbarBlur, .navbar-main {
      position: sticky !important;
      top: 0.5rem !important;
      z-index: 1040 !important;
    }
    .user-dropdown-menu {
      z-index: 1050 !important;
    }
    /* Mobile Sidebar & Backdrop */
    .sidenav-backdrop {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      width: 100vw;
      height: 100vh;
      background: rgba(15, 23, 42, 0.5);
      backdrop-filter: blur(2px);
      z-index: 1055;
      transition: opacity 0.3s ease;
    }
    body.g-sidenav-pinned .sidenav-backdrop {
      display: block !important;
    }
    @media (max-width: 1199.98px) {
      #sidenav-main.sidenav {
        position: fixed !important;
        top: 0 !important;
        left: 0 !important;
        bottom: 0 !important;
        width: 270px !important;
        max-width: 85vw !important;
        height: 100vh !important;
        max-height: 100vh !important;
        margin: 0 !important;
        border-radius: 0 16px 16px 0 !important;
        background-color: #ffffff !important;
        transform: translateX(-105%) !important;
        transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
        z-index: 1060 !important;
        box-shadow: 0 20px 40px rgba(0,0,0,0.25) !important;
        overflow-y: auto !important;
      }
      body.g-sidenav-pinned #sidenav-main.sidenav {
        transform: translateX(0) !important;
      }
      .main-content {
        margin-left: 0 !important;
      }
    }
    /* Responsive DataTables Modern Styling */
    div.dataTables_wrapper {
      padding: 0.25rem 0;
      width: 100% !important;
      box-sizing: border-box;
    }
    div.dataTables_wrapper > .row {
      margin-left: 0 !important;
      margin-right: 0 !important;
      padding-left: 0 !important;
      padding-right: 0 !important;
      align-items: center;
    }
    div.dataTables_wrapper > .row > * {
      padding-left: 0 !important;
      padding-right: 0 !important;
    }
    div.dataTables_wrapper .dataTables_length select {
      border-radius: 8px !important;
      padding: 5px 10px !important;
      border: 1px solid #d2d6da !important;
      font-size: 0.8125rem !important;
      display: inline-block;
      width: auto;
    }
    div.dataTables_wrapper div.dataTables_filter input {
      border-radius: 20px !important;
      padding: 6px 14px !important;
      border: 1px solid #d2d6da !important;
      font-size: 0.8125rem !important;
      max-width: 200px;
    }
    div.dataTables_wrapper div.dataTables_filter input:focus {
      border-color: #046B26 !important;
      outline: none !important;
      box-shadow: 0 0 0 3px rgba(4, 107, 38, 0.15) !important;
    }
    div.dataTables_wrapper .dataTables_info {
      font-size: 0.75rem !important;
      color: #64748b !important;
      padding-top: 0.75rem !important;
    }
    div.dataTables_wrapper .dataTables_paginate {
      padding-top: 0.5rem !important;
    }
    .page-item.active .page-link {
      background-color: #046B26 !important;
      border-color: #046B26 !important;
      color: #ffffff !important;
    }
    .page-link {
      font-size: 0.75rem !important;
      padding: 5px 10px !important;
      border-radius: 6px !important;
      margin: 0 2px !important;
    }
    /* Standardized DataTable Action & Document Buttons (Solid Colors) */
    .btn-action-edit, .btn-action-delete, .btn-action-view {
      display: inline-flex !important;
      align-items: center !important;
      justify-content: center !important;
      width: 34px !important;
      height: 34px !important;
      padding: 0 !important;
      border-radius: 8px !important;
      font-size: 15px !important;
      transition: all 0.2s ease-in-out !important;
      box-shadow: 0 2px 6px rgba(0,0,0,0.12) !important;
      border: none !important;
      text-decoration: none !important;
    }
    .btn-action-edit {
      background-color: #fb8c00 !important; /* Solid Warning (Orange/Amber) */
      color: #ffffff !important;
    }
    .btn-action-edit:hover {
      background-color: #f57c00 !important;
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(251, 140, 0, 0.4) !important;
      color: #ffffff !important;
    }
    .btn-action-delete {
      background-color: #ea0606 !important; /* Solid Danger (Red) */
      color: #ffffff !important;
    }
    .btn-action-delete:hover {
      background-color: #c60505 !important;
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(234, 6, 6, 0.4) !important;
      color: #ffffff !important;
    }
    .btn-action-view {
      background-color: #344767 !important; /* Solid Dark */
      color: #ffffff !important;
    }
    .btn-action-view:hover {
      background-color: #212529 !important;
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(52, 71, 103, 0.4) !important;
      color: #ffffff !important;
    }
    .btn-doc-link {
      display: inline-flex !important;
      align-items: center !important;
      gap: 6px !important;
      padding: 6px 14px !important;
      border-radius: 20px !important;
      font-size: 12px !important;
      font-weight: 700 !important;
      text-decoration: none !important;
      background-color: #17a2b8 !important; /* Solid Info */
      color: #ffffff !important;
      box-shadow: 0 3px 8px rgba(23, 162, 184, 0.25) !important;
      transition: all 0.2s ease-in-out !important;
    }
    .btn-doc-link:hover {
      background-color: #138496 !important;
      transform: translateY(-2px);
      box-shadow: 0 5px 12px rgba(23, 162, 184, 0.4) !important;
      color: #ffffff !important;
    }
    .btn-doc-link i {
      font-size: 14px !important;
    }
    .btn-action-edit i, .btn-action-delete i, .btn-action-view i {
      font-size: 14px !important;
    }
    /* Document Plain Text Wrapper */
    .doc-text-wrap {
      white-space: normal !important;
      word-wrap: break-word !important;
      word-break: break-all !important;
      max-width: 450px !important;
      min-width: 280px !important;
      width: 100% !important;
      display: block !important;
      text-align: center !important;
      user-select: all !important;
      line-height: 1.4 !important;
      font-size: 0.75rem !important;
      color: #344767 !important;
      margin: 4px auto 0 auto !important;
    }
    .table-responsive {
      overflow-x: auto !important;
      -webkit-overflow-scrolling: touch;
      border-radius: 8px;
    }
    .table-responsive::-webkit-scrollbar,
    .dataTables_scrollBody::-webkit-scrollbar {
      height: 6px;
      width: 6px;
    }
    .table-responsive::-webkit-scrollbar-thumb,
    .dataTables_scrollBody::-webkit-scrollbar-thumb {
      background: #cbd5e1;
      border-radius: 4px;
    }
    .table-responsive::-webkit-scrollbar-track,
    .dataTables_scrollBody::-webkit-scrollbar-track {
      background: #f1f5f9;
      border-radius: 4px;
    }
    div.dataTables_wrapper .dataTables_scroll {
      margin-top: 0.5rem;
      margin-bottom: 0.75rem;
      border: 1px solid #e2e8f0;
      border-radius: 8px;
      overflow: hidden;
      background: #ffffff;
      width: 100% !important;
    }
    div.dataTables_wrapper .dataTables_scrollHead {
      border-bottom: 1px solid #e2e8f0 !important;
      background: #f8fafc !important;
    }
    div.dataTables_wrapper .dataTables_scrollHeadInner {
      box-sizing: border-box !important;
      width: 100% !important;
      padding-right: 0 !important;
    }
    div.dataTables_wrapper .dataTables_scrollHeadInner table {
      width: 100% !important;
      margin-bottom: 0 !important;
      table-layout: auto !important;
    }
    div.dataTables_wrapper .dataTables_scrollBody {
      border-bottom: none !important;
      border-radius: 0 !important;
      width: 100% !important;
    }
    div.dataTables_wrapper .dataTables_scrollBody table {
      width: 100% !important;
      margin-bottom: 0 !important;
      border-top: none !important;
      table-layout: auto !important;
    }
    .table > :not(caption) > * > * {
      padding: 0.75rem 1rem !important;
      vertical-align: middle !important;
      box-sizing: border-box !important;
    }
    table.dataTable thead th {
      font-size: 0.75rem !important;
      font-weight: 700 !important;
      text-transform: uppercase !important;
      letter-spacing: 0.5px !important;
      color: #475569 !important;
      background: #f8fafc !important;
      border-bottom: 1px solid #e2e8f0 !important;
      vertical-align: middle !important;
      box-sizing: border-box !important;
      padding: 0.75rem 1rem !important;
    }
    table.dataTable tbody td {
      vertical-align: middle !important;
      box-sizing: border-box !important;
      padding: 0.75rem 1rem !important;
    }
    table.dataTable thead th.text-center,
    table.dataTable tbody td.text-center {
      text-align: center !important;
    }
    @media (max-width: 767.98px) {
      div.dataTables_wrapper .dataTables_length,
      div.dataTables_wrapper .dataTables_filter {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 0.5rem;
      }
      div.dataTables_wrapper div.dataTables_filter {
        justify-content: flex-end;
      }
      div.dataTables_wrapper .dataTables_info,
      div.dataTables_wrapper .dataTables_paginate {
        display: flex;
        justify-content: center;
        text-align: center;
      }
    }
    /* Select2 Custom UIS Theme */
    .select2-container--bootstrap-5 .select2-selection--single,
    .select2-container--default .select2-selection--single {
      border-radius: 8px !important;
      border: 1px solid #d2d6da !important;
      padding: 0.45rem 0.75rem !important;
      font-size: 0.875rem !important;
      min-height: 42px !important;
      display: flex !important;
      align-items: center !important;
      background-color: #ffffff !important;
    }
    .select2-container--bootstrap-5 .select2-selection--multiple,
    .select2-container--default .select2-selection--multiple {
      border-radius: 8px !important;
      border: 1px solid #d2d6da !important;
      padding: 6px 8px !important;
      font-size: 0.875rem !important;
      min-height: 44px !important;
      display: flex !important;
      flex-wrap: wrap !important;
      align-items: center !important;
      background-color: #ffffff !important;
      cursor: text !important;
    }
    .select2-container--bootstrap-5.select2-container--focus .select2-selection,
    .select2-container--bootstrap-5.select2-container--open .select2-selection,
    .select2-container--default.select2-container--focus .select2-selection,
    .select2-container--default.select2-container--open .select2-selection {
      border-color: #046B26 !important;
      box-shadow: 0 0 0 3px rgba(4, 107, 38, 0.15) !important;
    }
    .select2-container--bootstrap-5 .select2-selection--multiple .select2-selection__rendered,
    .select2-container--default .select2-selection--multiple .select2-selection__rendered {
      display: flex !important;
      flex-wrap: wrap !important;
      align-items: center !important;
      gap: 6px !important;
      padding: 0 !important;
      margin: 0 !important;
      width: 100% !important;
      list-style: none !important;
    }
    .select2-container--bootstrap-5 .select2-selection--multiple .select2-selection__choice,
    .select2-container--default .select2-selection--multiple .select2-selection__choice {
      background-color: #E8F5E9 !important;
      border: 1px solid #A5D6A7 !important;
      color: #046B26 !important;
      font-size: 0.8125rem !important;
      font-weight: 600 !important;
      border-radius: 6px !important;
      padding: 4px 10px !important;
      margin: 0 !important;
      display: inline-flex !important;
      align-items: center !important;
      box-shadow: 0 1px 2px rgba(4, 107, 38, 0.08) !important;
      line-height: 1.4 !important;
    }
    .select2-container--bootstrap-5 .select2-selection--multiple .select2-selection__choice__remove,
    .select2-container--default .select2-selection--multiple .select2-selection__choice__remove,
    .select2-container .select2-selection--multiple .select2-selection__choice__remove {
      border: none !important;
      background: rgba(4, 107, 38, 0.12) url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23046B26'%3e%3cpath d='M.293.293a1 1 0 0 1 1.414 0L8 6.586 14.293.293a1 1 0 1 1 1.414 1.414L9.414 8l6.293 6.293a1 1 0 0 1-1.414 1.414L8 9.414l-6.293 6.293a1 1 0 0 1-1.414-1.414L6.586 8 .293 1.707a1 1 0 0 1 0-1.414z'/%3e%3c/svg%3e") center/8px auto no-repeat !important;
      margin-right: 6px !important;
      cursor: pointer !important;
      padding: 0 !important;
      display: inline-block !important;
      width: 18px !important;
      height: 18px !important;
      min-width: 18px !important;
      min-height: 18px !important;
      border-radius: 50% !important;
      transition: all 0.2s ease !important;
      vertical-align: middle !important;
    }
    .select2-container--bootstrap-5 .select2-selection--multiple .select2-selection__choice__remove::before,
    .select2-container--default .select2-selection--multiple .select2-selection__choice__remove::before,
    .select2-container .select2-selection--multiple .select2-selection__choice__remove::before {
      display: none !important;
      content: "" !important;
    }
    .select2-container--bootstrap-5 .select2-selection--multiple .select2-selection__choice__remove:hover,
    .select2-container--default .select2-selection--multiple .select2-selection__choice__remove:hover,
    .select2-container .select2-selection--multiple .select2-selection__choice__remove:hover {
      background: #ef4444 url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23ffffff'%3e%3cpath d='M.293.293a1 1 0 0 1 1.414 0L8 6.586 14.293.293a1 1 0 1 1 1.414 1.414L9.414 8l6.293 6.293a1 1 0 0 1-1.414 1.414L8 9.414l-6.293 6.293a1 1 0 0 1-1.414-1.414L6.586 8 .293 1.707a1 1 0 0 1 0-1.414z'/%3e%3c/svg%3e") center/8px auto no-repeat !important;
      transform: scale(1.08) !important;
    }
    /* 4. Inline Search Item - ABSOLUTELY NO BORDER / NO BOX */
    .select2-container .select2-selection--multiple .select2-search,
    .select2-container .select2-selection--multiple .select2-search--inline,
    .select2-container--bootstrap-5 .select2-selection--multiple .select2-search,
    .select2-container--bootstrap-5 .select2-selection--multiple .select2-search--inline,
    .select2-container--default .select2-selection--multiple .select2-search,
    .select2-container--default .select2-selection--multiple .select2-search--inline {
      flex-grow: 1 !important;
      display: inline-flex !important;
      align-items: center !important;
      margin: 0 !important;
      padding: 0 !important;
      border: none !important;
      background: transparent !important;
      box-shadow: none !important;
      float: none !important;
    }
    .select2-container .select2-selection--multiple .select2-search__field,
    .select2-container--bootstrap-5 .select2-selection--multiple .select2-search__field,
    .select2-container--default .select2-selection--multiple .select2-search__field,
    .select2-container--bootstrap-5 .select2-selection--multiple .select2-search--inline .select2-search__field,
    .select2-container--default .select2-selection--multiple .select2-search--inline .select2-search__field {
      border: 0 none transparent !important;
      border-radius: 0 !important;
      outline: none !important;
      box-shadow: none !important;
      background: transparent !important;
      margin: 0 !important;
      padding: 4px 6px !important;
      height: 30px !important;
      min-height: 30px !important;
      line-height: 22px !important;
      font-size: 0.875rem !important;
      color: #344767 !important;
      min-width: 140px !important;
      width: auto !important;
      max-width: 100% !important;
      vertical-align: middle !important;
      box-sizing: border-box !important;
    }
    .select2-container--bootstrap-5 .select2-dropdown,
    .select2-container--default .select2-dropdown {
      border-radius: 10px !important;
      border: 1px solid #e2e8f0 !important;
      box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important;
      overflow: hidden !important;
      z-index: 1060 !important;
    }
    /* 5. Dropdown search ONLY (in dropdown menu) */
    .select2-dropdown .select2-search {
      padding: 8px !important;
    }
    .select2-dropdown .select2-search .select2-search__field {
      border-radius: 6px !important;
      border: 1px solid #d2d6da !important;
      padding: 6px 12px !important;
      width: 100% !important;
      box-sizing: border-box !important;
    }
    .select2-dropdown .select2-search .select2-search__field:focus {
      border-color: #046B26 !important;
      box-shadow: 0 0 0 2px rgba(4, 107, 38, 0.15) !important;
      outline: none !important;
    }
    .select2-container--bootstrap-5 .select2-results__option--highlighted.select2-results__option--selectable,
    .select2-container--default .select2-results__option--highlighted.select2-results__option--selectable {
      background-color: #046B26 !important;
      color: #ffffff !important;
    }
    .select2-container--bootstrap-5 .select2-results__option--selected,
    .select2-container--default .select2-results__option--selected {
      background-color: #E8F5E9 !important;
      color: #046B26 !important;
      font-weight: 600 !important;
    }
  </style>
</head>

<body class="g-sidenav-show bg-gray-100">
  <div class="sidenav-backdrop" id="sidenavBackdrop"></div>

  @include('layouts.dashboard.sidebar')
  
  <main class="main-content position-relative border-radius-lg">
    @include('layouts.dashboard.navbar')

    @include('sweetalert::alert')
    
    @yield('content')
  </main>

  <!--   Core JS Files   -->
  <script src="{{ asset('dashboard/assets/js/core/popper.min.js') }}"></script>
  <script src="{{ asset('dashboard/assets/js/core/bootstrap.min.js') }}"></script>
  <script src="{{ asset('dashboard/assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
  <script src="{{ asset('dashboard/assets/js/plugins/smooth-scrollbar.min.js') }}"></script>
  <script src="{{ asset('dashboard/assets/js/plugins/chartjs.min.js') }}"></script>
  <script src="{{ asset('dashboard/assets/js/soft-ui-dashboard.min.js?v=1.0.3') }}"></script>
  
  {{-- datatables --}}
  <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
  <script src="https://cdn.datatables.net/2.3.4/js/dataTables.js"></script>
  <script src="https://cdn.datatables.net/2.3.4/js/dataTables.bootstrap5.js"></script>

  {{-- Select2 JS --}}
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script>
    $(document).ready(function() {
      if ($.fn.select2) {
        $('.select2').each(function() {
          var isMultiple = $(this).prop('multiple');
          $(this).select2({
            theme: 'bootstrap-5',
            width: '100%',
            placeholder: $(this).data('placeholder') || '-- Pilih --',
            allowClear: Boolean($(this).data('allow-clear')),
            closeOnSelect: !isMultiple,
          });
        });
      }

      // Auto adjust DataTables header and column widths
      if ($.fn.dataTable) {
        $(document).on('draw.dt init.dt', function () {
          setTimeout(function() {
            $.fn.dataTable.tables({ visible: true, api: true }).columns.adjust();
          }, 50);
        });
        $(window).on('resize', function () {
          $.fn.dataTable.tables({ visible: true, api: true }).columns.adjust();
        });
      }
    });
  </script>
  @stack('script')
  @stack('style')

  <script>
    // Bulletproof Mobile Sidebar Toggle
    (function () {
      function openMobileSidenav() {
        document.body.classList.add('g-sidenav-pinned');
        var sidenav = document.getElementById('sidenav-main');
        if (sidenav) {
          sidenav.style.transform = 'translateX(0)';
        }
      }

      function closeMobileSidenav() {
        document.body.classList.remove('g-sidenav-pinned');
        var sidenav = document.getElementById('sidenav-main');
        if (sidenav) {
          sidenav.style.transform = '';
        }
      }

      function toggleMobileSidenav(e) {
        if (e) {
          e.preventDefault();
          e.stopPropagation();
        }
        if (document.body.classList.contains('g-sidenav-pinned')) {
          closeMobileSidenav();
        } else {
          openMobileSidenav();
        }
      }

      document.addEventListener('click', function (e) {
        var toggle = e.target.closest('#btnToggleMobileSidebar') || e.target.closest('#iconNavbarSidenav');
        if (toggle) {
          toggleMobileSidenav(e);
          return;
        }

        var close = e.target.closest('#iconSidenav') || e.target.closest('#sidenavBackdrop');
        if (close) {
          if (e) e.preventDefault();
          closeMobileSidenav();
          return;
        }
      });
    })();
  </script>

  <script>
    var chartBarEl = document.getElementById("chart-bars");
    if (chartBarEl) {
      var ctx = chartBarEl.getContext("2d");
      new Chart(ctx, {
        type: "bar",
        data: {
          labels: ["Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
          datasets: [{
            label: "Sales",
            tension: 0.4,
            borderWidth: 0,
            borderRadius: 4,
            borderSkipped: false,
            backgroundColor: "#fff",
            data: [450, 200, 100, 220, 500, 100, 400, 230, 500],
            maxBarThickness: 6
          }],
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: { display: false }
          },
          interaction: {
            intersect: false,
            mode: 'index',
          },
          scales: {
            y: {
              grid: { drawBorder: false, display: false, drawOnChartArea: false, drawTicks: false },
              ticks: { suggestedMin: 0, suggestedMax: 500, beginAtZero: true, padding: 15, font: { size: 14, family: "Open Sans", lineHeight: 2 }, color: "#fff" }
            },
            x: {
              grid: { drawBorder: false, display: false, drawOnChartArea: false, drawTicks: false },
              ticks: { display: false }
            }
          }
        }
      });
    }

    var chartLineEl = document.getElementById("chart-line");
    if (chartLineEl) {
      var ctx2 = chartLineEl.getContext("2d");
      var gradientStroke1 = ctx2.createLinearGradient(0, 230, 0, 50);
      gradientStroke1.addColorStop(1, 'rgba(203,12,159,0.2)');
      gradientStroke1.addColorStop(0.2, 'rgba(72,72,176,0.0)');
      gradientStroke1.addColorStop(0, 'rgba(203,12,159,0)');

      var gradientStroke2 = ctx2.createLinearGradient(0, 230, 0, 50);
      gradientStroke2.addColorStop(1, 'rgba(20,23,39,0.2)');
      gradientStroke2.addColorStop(0.2, 'rgba(72,72,176,0.0)');
      gradientStroke2.addColorStop(0, 'rgba(20,23,39,0)');

      new Chart(ctx2, {
        type: "line",
        data: {
          labels: ["Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
          datasets: [
            {
              label: "Mobile apps",
              tension: 0.4,
              borderWidth: 3,
              pointRadius: 0,
              borderColor: "#cb0c9f",
              backgroundColor: gradientStroke1,
              fill: true,
              data: [50, 40, 300, 220, 500, 250, 400, 230, 500],
              maxBarThickness: 6
            },
            {
              label: "Websites",
              tension: 0.4,
              borderWidth: 3,
              pointRadius: 0,
              borderColor: "#3A416F",
              backgroundColor: gradientStroke2,
              fill: true,
              data: [30, 90, 40, 140, 290, 290, 340, 230, 400],
              maxBarThickness: 6
            }
          ]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: { legend: { display: false } },
          interaction: { intersect: false, mode: 'index' },
          scales: {
            y: {
              grid: { drawBorder: false, display: true, drawOnChartArea: true, drawTicks: false, borderDash: [5, 5] },
              ticks: { display: true, padding: 10, color: '#b2b9bf', font: { size: 11, family: "Open Sans", lineHeight: 2 } }
            },
            x: {
              grid: { drawBorder: false, display: false, drawOnChartArea: false, drawTicks: false, borderDash: [5, 5] },
              ticks: { display: true, color: '#b2b9bf', padding: 20, font: { size: 11, family: "Open Sans", lineHeight: 2 } }
            }
          }
        }
      });
    }
  </script>
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = { damping: '0.5' };
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>
</body>

</html>