@extends('permission::layouts.app')

@section('styles')
<link rel="stylesheet" type="text/css" href="{{ permission_asset('dashboard/vendor/datatables/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ permission_asset('dashboard/css/sweetalert2.min.css') }}">
@endsection
@section('content')

<div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">
      		<a href="#" class="btn btn-success btn-icon-split" data-toggle="modal" data-target="#addRoleModal">
                <span class="icon text-white-50"><i class="fas fa-plus"></i></span>
                <span class="text">Add Role</span>
            </a>
        </h6>
    </div>
    <div class="card-body">
      <div class="table-responsive">
		    <table class="table table-bordered dataTable" id="role_table" width="100%" cellspacing="0" role="grid" aria-describedby="dataTable_info" style="width: 100%;">
          	<thead>
	            <tr role="row">
	            	<th class="sorting_asc" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending" style="width: 165px;">Role Name</th>
	            	<th class="sorting_asc" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending" style="width: 165px;">Action</th>
	            </tr>
          	</thead>
          	<tbody>
  	      		@forelse( $roles as $key => $role )             
  	          	<tr role="row" class="{{ (($key + 1) % 2 == 0) ? 'even' : 'odd' }}" data-row="{{ $key }}" id="row_{{ $role->id }}">
  		            <td class="sorting_1">{{ $role->name }}</td>
  		            <td class="sorting_1">
  		            	<a href="#" class="view_role btn btn-warning" title="View" data-id="{{ $role->id }}" data-toggle="modal" data-target="#viewRoleModal">View</a>
  		            	<a href="#" class="edit_role btn btn-info" data-id="{{ $role->id }}" data-action="{{ route('role.get',['id' => $role->id]) }}" title="Edit" data-toggle="modal" data-target="#editRoleModal">Edit</a>
  		            	<a href="#" class="delete_role btn btn-danger" title="Delete" data-id="{{ $role->id }}">Delete</a>
  		            </td>
  	            </tr>
  	            @empty
  	            <tr>
  	            	<td>There is no Role</td>
  	            </tr>
  	            @endforelse
  	    	</tbody>
        </table>
      </div>
    </div>
  </div>

  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">
          <a href="#" class="btn btn-success btn-icon-split" data-toggle="modal" data-target="#addPermissionModal">
                <span class="icon text-white-50"><i class="fas fa-plus"></i></span>
                <span class="text">Add Permission</span>
            </a>
        </h6>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered dataTable" id="permission_table" width="100%" cellspacing="0" role="grid" aria-describedby="dataTable_info" style="width: 100%;">
            <thead>
              <tr role="row">
                <th class="sorting_asc" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending" style="width: 165px;">Permission Name</th>
                <th class="sorting_asc" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending" style="width: 165px;">Action</th>
              </tr>
            </thead>
            <tbody>
              @forelse( $permissions as $key => $permission )             
                <tr role="row" class="{{ (($key + 1) % 2 == 0) ? 'even' : 'odd' }}" data-row="{{ $key }}" id="row_{{ $permission->id }}">
                  <td class="sorting_1">{{ $permission->name }}</td>
                  <td class="sorting_1">
                    <a href="#" class="view_permission btn btn-warning" title="View" data-id="{{ $permission->id }}" data-toggle="modal" data-target="#viewPermissionModal">View</a>
                    <a href="#" class="edit_permission btn btn-info" data-id="{{ $permission->id }}" data-action="{{ route('permission.get',['id' => $permission->id]) }}" title="Edit" data-toggle="modal" data-target="#editPermissionModal">Edit</a>
                    <a href="#" class="delete_permission btn btn-danger" title="Delete" data-id="{{ $permission->id }}">Delete</a>
                  </td>
                </tr>
                @empty
                <tr>
                  <td>There is no Role</td>
                </tr>
                @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!--
  * Role Modals 
  -->

<!-- Add Role Modal -->
<div class="modal fade" id="addRoleModal" tabindex="-1" role="dialog" aria-labelledby="addRoleLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addRoleLabel">Add New Role</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="post" action="{{ route('role.add') }}" id="add_role_form">
        @csrf
        <div class="modal-body">
          <div class="form-group">
            <label for="role_name">Name</label>
            <input type="text" name="role_name" id="role_name" class="form-control" placeholder="Role Name">
          </div>
          <div class="form-group">
            <label>Permissions</label>
            @if( count($permissions) > 0 )
            <ul class="permission-list">
              @foreach( $permissions as $permission )
              <li>
                <input type="checkbox" name="permissions[]" class="permissions" value="{{ $permission->id }}">
                <label>{{ $permission->name }}</label>
              </li>
              @endforeach
            </ul>
            @endif
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" id="add_role_submit_btn">Add</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- View Role Modal -->
<div class="modal fade" id="viewRoleModal" tabindex="-1" role="dialog" aria-labelledby="viewRoleLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="viewRoleLabel">View Role</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <div class="modal-body">
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
    </div>
  </div>
</div>
<!-- Edit Role Modal -->
<div class="modal fade" id="editRoleModal" tabindex="-1" role="dialog" aria-labelledby="editRoleLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editRoleLabel">Edit Role</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="post" action="{{ route('role.edit') }}" id="edit_role_form">
        @method('PUT')
        @csrf
        <input type="hidden" name="role_id" id="role_id" value="">
        <div class="modal-body">
          <div class="form-group">
            <label for="role_name">Name</label>
            <input type="text" name="role_name" id="role_name" class="form-control" placeholder="Role Name">
          </div>
          <div class="form-group">
            <label>Permissions</label>
            @if( count($permissions) > 0 )
            <ul class="permission-list">
              @foreach( $permissions as $permission )
              <li>
                <input type="checkbox" name="permissions[]" class="permissions edit_permissions" value="{{ $permission->id }}">
                <label>{{ $permission->name }}</label>
              </li>
              
              @endforeach
            </ul>
            @endif
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" id="edit_role_submit_btn">Update</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!--
* Permission Modals
-->
<div class="modal fade" id="addPermissionModal" tabindex="-1" role="dialog" aria-labelledby="addPermissionLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addPermissionLabel">Add New Permission</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="post" action="{{ route('permission.add') }}" id="add_permission_form">
        @csrf
        <div class="modal-body">
          <div class="form-group">
            <label for="role_name">Name</label>
            <input type="text" name="permission_name" id="permission_name" class="form-control" placeholder="Permission Name">
          </div>
          <div class="form-group">
            <label>Roles</label>
            @if( count($roles) > 0 )
            <ul class="permission-list">
              @foreach( $roles as $role )
              <li>
                <input type="checkbox" name="roles[]" class="roles edit_roles" value="{{ $role->id }}">
                <label>{{ $role->name }}</label>
              </li>
              @endforeach
            </ul>
            @endif
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" id="add_permission_submit_btn">Add</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- View Role Modal -->
<div class="modal fade" id="viewPermissionModal" tabindex="-1" role="dialog" aria-labelledby="viewPermissionLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="viewPermissionLabel">View Permission</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <div class="modal-body">
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
    </div>
  </div>
</div>
<!-- Edit Role Modal -->
<div class="modal fade" id="editPermissionModal" tabindex="-1" role="dialog" aria-labelledby="editPermissionLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editPermissionLabel">Edit Permission</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="post" action="{{ route('permission.edit') }}" id="edit_permission_form">
        @method('PUT')
        @csrf
        <input type="hidden" name="permission_id" id="permission_id" value="">
        <div class="modal-body">
          <div class="form-group">
            <label for="role_name">Name</label>
            <input type="text" name="permission_name" id="permission_name" class="form-control" placeholder="Permission Name">
          </div>
          <div class="form-group">
            <label>Roles</label>
            @if( count($roles) > 0 )
            <ul class="permission-list">
              @foreach( $roles as $role )
              <li>
                <input type="checkbox" name="roles[]" class="edit_roles" value="{{ $role->id }}">
                <label>{{ $role->name }}</label>
              </li>
              
              @endforeach
            </ul>
            @endif
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" id="edit_permission_submit_btn">Update</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<!-- Page level plugins -->
  <script src="{{ permission_asset('dashboard/vendor/datatables/jquery.dataTables.min.js') }}"></script>
  <script src="{{ permission_asset('dashboard/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
  <script src="{{ permission_asset('dashboard/js/sweetalert2.min.js') }}"></script>
  <script type="text/javascript">
  	// Call the dataTables jQuery plugin
	$(document).ready(function() {
	  $('#role_table').DataTable({
      order: [[1,'desc']]
    });

    $("#permission_table").DataTable({
      order: [[1,'desc']]
    });
	});
  </script>
 @endsection