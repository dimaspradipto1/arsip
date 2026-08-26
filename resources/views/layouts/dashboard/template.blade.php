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
      overflow-x: hidden;
      max-width: 100vw;
    }
    body {
      font-family: 'Open Sans', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
      background-color: #f8fafc;
    }
    .main-content {
      overflow-x: hidden !important;
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
    /* Mobile Sidebar & Backdrop */
    .sidenav-backdrop {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: rgba(15, 23, 42, 0.45);
      backdrop-filter: blur(2px);
      z-index: 1045;
      transition: opacity 0.3s ease;
    }
    body.g-sidenav-pinned .sidenav-backdrop {
      display: block;
    }
    @media (max-width: 1199.98px) {
      .sidenav {
        position: fixed !important;
        top: 0 !important;
        left: 0 !important;
        bottom: 0 !important;
        height: 100vh !important;
        max-height: 100vh !important;
        margin: 0 !important;
        border-radius: 0 16px 16px 0 !important;
        transform: translateX(-100%);
        transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
        z-index: 1050 !important;
        box-shadow: 0 20px 40px rgba(0,0,0,0.2) !important;
      }
      body.g-sidenav-pinned .sidenav {
        transform: translateX(0) !important;
      }
      .main-content {
        margin-left: 0 !important;
      }
    }
    /* Responsive DataTables */
    div.dataTables_wrapper div.dataTables_filter input {
      border-radius: 20px !important;
      padding: 6px 14px !important;
      border: 1px solid #e2e8f0 !important;
    }
    div.dataTables_wrapper div.dataTables_filter input:focus {
      border-color: #046B26 !important;
      outline: none !important;
      box-shadow: 0 0 0 3px rgba(4, 107, 38, 0.15) !important;
    }
    .page-item.active .page-link {
      background-color: #046B26 !important;
      border-color: #046B26 !important;
    }
    .table > :not(caption) > * > * {
      padding: 0.75rem 1rem;
    }
    /* Select2 Custom UIS Theme */
    .select2-container--bootstrap-5 .select2-selection {
      border-radius: 8px !important;
      border: 1px solid #d2d6da !important;
      padding: 0.45rem 0.75rem !important;
      font-size: 0.875rem !important;
      min-height: 40px !important;
      display: flex !important;
      align-items: center !important;
    }
    .select2-container--bootstrap-5.select2-container--focus .select2-selection,
    .select2-container--bootstrap-5.select2-container--open .select2-selection {
      border-color: #046B26 !important;
      box-shadow: 0 0 0 3px rgba(4, 107, 38, 0.15) !important;
    }
    .select2-container--bootstrap-5 .select2-dropdown {
      border-radius: 10px !important;
      border: 1px solid #e2e8f0 !important;
      box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important;
      overflow: hidden !important;
      z-index: 1060 !important;
    }
    .select2-container--bootstrap-5 .select2-search .select2-search__field {
      border-radius: 6px !important;
      border: 1px solid #d2d6da !important;
      padding: 6px 12px !important;
    }
    .select2-container--bootstrap-5 .select2-search .select2-search__field:focus {
      border-color: #046B26 !important;
      box-shadow: 0 0 0 2px rgba(4, 107, 38, 0.15) !important;
      outline: none !important;
    }
    .select2-container--bootstrap-5 .select2-results__option--highlighted.select2-results__option--selectable {
      background-color: #046B26 !important;
      color: #ffffff !important;
    }
    .select2-container--bootstrap-5 .select2-results__option--selected {
      background-color: #E8F5E9 !important;
      color: #046B26 !important;
      font-weight: 600 !important;
    }
  </style>
</head>

<body class="g-sidenav-show bg-gray-100">
  <div class="sidenav-backdrop" id="sidenavBackdrop"></div>

  @include('layouts.dashboard.sidebar')
  
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
    @include('layouts.dashboard.navbar')

    @include('sweetalert::alert')
    
    <div class="px-2 px-md-3">
      @yield('content')
    </div>
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
        $('.select2').select2({
          theme: 'bootstrap-5',
          width: '100%',
          placeholder: function() {
            return $(this).data('placeholder') || $(this).find('option:first').text() || '-- Pilih --';
          },
          allowClear: false
        });
      }
    });
  </script>
  @stack('script')
  @stack('style')

  <script>
    document.addEventListener("DOMContentLoaded", function () {
      const toggleBtn = document.getElementById("iconNavbarSidenav");
      const closeBtn = document.getElementById("iconSidenav");
      const backdrop = document.getElementById("sidenavBackdrop");
      const body = document.body;

      if (toggleBtn) {
        toggleBtn.addEventListener("click", function (e) {
          e.preventDefault();
          e.stopPropagation();
          body.classList.toggle("g-sidenav-pinned");
        });
      }

      if (closeBtn) {
        closeBtn.addEventListener("click", function (e) {
          e.preventDefault();
          body.classList.remove("g-sidenav-pinned");
        });
      }

      if (backdrop) {
        backdrop.addEventListener("click", function () {
          body.classList.remove("g-sidenav-pinned");
        });
      }
    });
  </script>

  <script>
    var ctx = document.getElementById("chart-bars").getContext("2d");

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
        }, ],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            display: false,
          }
        },
        interaction: {
          intersect: false,
          mode: 'index',
        },
        scales: {
          y: {
            grid: {
              drawBorder: false,
              display: false,
              drawOnChartArea: false,
              drawTicks: false,
            },
            ticks: {
              suggestedMin: 0,
              suggestedMax: 500,
              beginAtZero: true,
              padding: 15,
              font: {
                size: 14,
                family: "Open Sans",
                style: 'normal',
                lineHeight: 2
              },
              color: "#fff"
            },
          },
          x: {
            grid: {
              drawBorder: false,
              display: false,
              drawOnChartArea: false,
              drawTicks: false
            },
            ticks: {
              display: false
            },
          },
        },
      },
    });


    var ctx2 = document.getElementById("chart-line").getContext("2d");

    var gradientStroke1 = ctx2.createLinearGradient(0, 230, 0, 50);

    gradientStroke1.addColorStop(1, 'rgba(203,12,159,0.2)');
    gradientStroke1.addColorStop(0.2, 'rgba(72,72,176,0.0)');
    gradientStroke1.addColorStop(0, 'rgba(203,12,159,0)'); //purple colors

    var gradientStroke2 = ctx2.createLinearGradient(0, 230, 0, 50);

    gradientStroke2.addColorStop(1, 'rgba(20,23,39,0.2)');
    gradientStroke2.addColorStop(0.2, 'rgba(72,72,176,0.0)');
    gradientStroke2.addColorStop(0, 'rgba(20,23,39,0)'); //purple colors

    new Chart(ctx2, {
      type: "line",
      data: {
        labels: ["Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
        datasets: [{
            label: "Mobile apps",
            tension: 0.4,
            borderWidth: 0,
            pointRadius: 0,
            borderColor: "#cb0c9f",
            borderWidth: 3,
            backgroundColor: gradientStroke1,
            fill: true,
            data: [50, 40, 300, 220, 500, 250, 400, 230, 500],
            maxBarThickness: 6

          },
          {
            label: "Websites",
            tension: 0.4,
            borderWidth: 0,
            pointRadius: 0,
            borderColor: "#3A416F",
            borderWidth: 3,
            backgroundColor: gradientStroke2,
            fill: true,
            data: [30, 90, 40, 140, 290, 290, 340, 230, 400],
            maxBarThickness: 6
          },
        ],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            display: false,
          }
        },
        interaction: {
          intersect: false,
          mode: 'index',
        },
        scales: {
          y: {
            grid: {
              drawBorder: false,
              display: true,
              drawOnChartArea: true,
              drawTicks: false,
              borderDash: [5, 5]
            },
            ticks: {
              display: true,
              padding: 10,
              color: '#b2b9bf',
              font: {
                size: 11,
                family: "Open Sans",
                style: 'normal',
                lineHeight: 2
              },
            }
          },
          x: {
            grid: {
              drawBorder: false,
              display: false,
              drawOnChartArea: false,
              drawTicks: false,
              borderDash: [5, 5]
            },
            ticks: {
              display: true,
              color: '#b2b9bf',
              padding: 20,
              font: {
                size: 11,
                family: "Open Sans",
                style: 'normal',
                lineHeight: 2
              },
            }
          },
        },
      },
    });
  </script>
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>
</body>

</html>