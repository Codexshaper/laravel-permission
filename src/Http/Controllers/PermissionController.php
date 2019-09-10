<?php

namespace CodexShaper\Permission\Http\Controllers;

use CodexShaper\Permission\Http\Controllers\Controller;
use CodexShaper\Permission\Models\Permission;
use CodexShaper\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;

class PermissionController extends Controller 
{
	public function index() {
		// dd( Role::where('slug', 'admin')->first()->permissions);
		$roles = Role::orderBy('updated_at', 'desc')->get();
		$permissions = Permission::orderBy('updated_at', 'desc')->get();
		return view('permission::permissions.index', compact('roles', 'permissions'));
	}

	public function addPermission(Request $request)
	{
		if( $request->ajax() ) {
			if( !Permission::where('slug', slug($request->permission_name))->exists() ){

				$permission = new Permission;
				$permission->name = $request->permission_name;
				$permission->slug = slug($request->permission_name);
				if($permission->save()){
					$permission->givePermissionToRoles( $request->roles );
					return response()->json([
						'success' => true,
						'permission' => $permission,
						'roles' => $permission->permission_roles
					]);
				}
			}else {
				return response()->json([
					'success' => false,
					'message' => 'Permission Already Exists'
				]);
			}
		}

		return response()->json(['success' => false]);
	}

	public function getPermission( Request $request )
	{
		if( $request->ajax() ) {
			if( $request->id ) {
				if( $permission = Permission::find( $request->id ) ){
					$roles = $permission->permission_roles;
					return response()->json([
						'success' => true,
						'permission' => $permission,
						'roles' => $roles
					]);
				}
			}
		}

		return response()->json([
			'success' => false,
			'message' => 'There is no ajax request'
		]);
	}

	public function updatePermission( Request $request )
	{
		if($request->ajax()){
			if( isset( $request->permission_id ) && $permission = Permission::find( $request->permission_id ) ) {
				$permission->name = $request->permission_name;
				$permission->slug = slug( $request->permission_name );
				if( $permission->update() ) {
					if( count( $request->roles ) > 0 ) {
						$permission->syncPermissionToRoles( $request->roles );
						return response()->json([
							'success' => true,
							'permission' => $permission
						]);
					}
				}
			}
		}

		return response()->json([
			'success' => false,
			'data' => $request->all()
		]);
	}

	public function deletePermission( Request $request )
	{
		if($request->ajax()){
			if( isset( $request->permission_id ) && $permission = Permission::find( $request->permission_id ) ) {
				$permission->revokePermissionsFromRoles();
				if( $permission->delete() ) {
					return response()->json([
						'success' => true,
						'permission' => $permission
					]);
				}
			}
		}

		return response()->json([
			'success' => false,
			'data' => $request->all()
		]);
	}

	public function addRole(Request $request)
	{
		if( $request->ajax() ) {
			if( !Role::where('slug', slug($request->role_name))->exists() ){

				$role = new Role;
				$role->name = $request->role_name;
				$role->slug = slug($request->role_name);
				if($role->save()){
					if( count( $request->permissions ) > 0 ) {
						$role->assignPermissions( $request->permissions );
						return response()->json([
							'success' => true,
							'role' => $role
						]);
					}
				}
			}else {
				return response()->json([
					'success' => false,
					'message' => 'Role Already Exists'
				]);
			}
		}

		return response()->json(['success' => false]);
	}

	public function getRole( Request $request )
	{
		if( $request->ajax() ) {
			if( $request->id ) {
				if( $role = Role::find( $request->id ) ){
					$permissions = $role->permissions;
					return response()->json([
						'success' => true,
						'role' => $role,
						'permissions' => $permissions
					]);
				}
			}
		}

		return response()->json([
			'success' => false,
			'message' => 'There is no ajax request'
		]);
	}

	public function updateRole( Request $request )
	{
		if($request->ajax()){
			if( isset( $request->role_id ) && $role = Role::find( $request->role_id ) ) {
				$role->name = $request->role_name;
				$role->slug = slug( $request->role_name );
				if( $role->update() ) {
					if( count( $request->permissions ) > 0 ) {
						$role->updatePermissions( $request->permissions );
						return response()->json([
							'success' => true,
							'role' => $role
						]);
					}
				}
			}
		}

		return response()->json([
			'success' => false,
			'data' => $request->all()
		]);
	}

	public function deleteRole( Request $request )
	{
		if($request->ajax()){
			if( isset( $request->role_id ) && $role = Role::find( $request->role_id ) ) {
				$role->revokePermissions();
				if( $role->delete() ) {
					return response()->json([
						'success' => true,
						'role' => $role
					]);
				}
			}
		}

		return response()->json([
			'success' => false,
			'data' => $request->all()
		]);
	}

	public function assets(Request $request)
    {
        $file = base_path(config('permission.resources_path').urldecode($request->path));

        if (File::exists($file)) {
            
            switch ( $extension = pathinfo($file, PATHINFO_EXTENSION) ) {
                case 'js':
                    $mimeType = 'text/javascript';
                    break;
                case 'css':
                    $mimeType = 'text/css';
                    break;
                default:
                    $mimeType = File::mimeType($file);
                    break;
            }

            $response = Response::make(File::get($file), 200);
            $response->header('Content-Type', $mimeType);
            $response->setSharedMaxAge(31536000);
            $response->setMaxAge(31536000);
            $response->setExpires(new \DateTime('+1 year'));
            
            return $response;
        }

        return response('', 404);
    }
}