<?php

namespace CodexShaper\Permission\Http\Controllers;

use CodexShaper\Permission\Http\Controllers\Controller;
use CodexShaper\Permission\Models\Role;
use CodexShaper\Permission\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller 
{
	public function index() {
		// dd( Role::where('slug', 'admin')->first()->permissions);
		$roles = Role::orderBy('updated_at', 'desc')->get();
		$users = User::orderBy('updated_at', 'desc')->get();
		return view('permission::users.index', compact('roles', 'users'));
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
}