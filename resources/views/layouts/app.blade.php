<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>Permission</title>

  <!-- Custom fonts for this template-->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.2/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="{{ permission_asset('dashboard/css/admin.css') }}" rel="stylesheet">
  <link href="{{ permission_asset('dashboard/css/custom.css') }}" rel="stylesheet">

  @yield('styles')

</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
      @include('permission::layouts.partials.sidebar')
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
    <div id="content">

        <!-- Topbar -->
         
         @include('permission::layouts.partials.topbar')
       
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
         @yield('content')
        
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

   @include('permission::layouts.partials.footer')