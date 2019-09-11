@extends('permission::layouts.app')

@section('styles')
<link rel="stylesheet" type="text/css" href="{{ permission_asset('dashboard/vendor/datatables/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ permission_asset('dashboard/css/sweetalert2.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ permission_asset('dashboard/css/app.css') }}">
@endsection
@section('content')

  <users-table add-action="{{ route('user.add') }}" edit-action="{{ route('user.update') }}" prefix="{{ permission_url_prefix() }}"></users-table>

@endsection

@section('scripts')
<!-- Page level plugins -->
  <script src="{{ permission_asset('dashboard/js/app.js') }}"></script>
  <script src="{{ permission_asset('dashboard/vendor/datatables/jquery.dataTables.min.js') }}"></script>
  <script src="{{ permission_asset('dashboard/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
  <script src="{{ permission_asset('dashboard/js/sweetalert2.min.js') }}"></script>
  
 @endsection