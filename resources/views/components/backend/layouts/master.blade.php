<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <title>{{ $pageTitle ?? '' }}</title>
        <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
        <link href="{{ asset('ui/css/styles.css') }}" rel="stylesheet" />
        <link rel="stylesheet" href="{{ asset('ui/css/resolving.css') }}">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
        
        
    </head>
    <body class="sb-nav-fixed">
        <x-backend.layouts.partials.top_bar></x-backend.layouts.partials.top_bar>
        <div id="layoutSidenav">
            <x-backend.layouts.partials.sidebar></x-backend.layouts.partials.sidebar>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                    {{ $breadCrumb ?? '' }}
                    {{ $slot ?? '' }}
                    </div>
                </main>
                <x-backend.layouts.partials.footer></x-backend.layouts.partials.footer>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="{{ asset('ui/js/scripts.js') }}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="{{ asset('ui/assets/demo/chart-area-demo.js') }}"></script>
        <script src="{{ asset('ui/assets/demo/chart-bar-demo.js') }}"></script>
        <script src="{{ asset('ui/assets/demo/chart-pie-demo.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>
        <script>
          const makeSeen = (notiId, userId) => {
              const base_url = 'http://127.0.0.1:8000';
              const check = base_url+`/api/make-notification-seen/${notiId}/${userId}`;
              fetch(base_url+`/api/make-notification-seen/${notiId}/${userId}`)
          }
        </script>

        <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
    </body>
</html>









{{--<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

    <title>{{ $pageTitle ?? '' }}</title>
  </head>
  <body class="container">
    
    {{ $breadCrumb ?? '' }}
    {{ $slot ?? '' }}

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>  

  </body>
</html>--}}