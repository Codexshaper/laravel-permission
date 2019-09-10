<?php

namespace CodexShaper\Permission\Http\Controllers;

use CodexShaper\Permission\Http\Controllers\Controller;
use CodexShaper\Permission\Models\Role;
use CodexShaper\Permission\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
	public function index() {
		// dd( Role::where('slug', 'admin')->first()->permissions);
		$roles = Role::orderBy('updated_at', 'desc')->get();
		$users = User::orderBy('updated_at', 'desc')->get();
		return view('permission::users.index', compact('roles', 'users'));
	}

	public function all( Request $request )
	{
		$users = User::orderBy('updated_at', 'desc')->get();
		return response()->json([
			'success' => true,
			'users' => $users
		]);
	}

	public function addUser( Request $request ) {
		$validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        if( $validator->fails() ){
        	return response()->json([
				'success' => false,
				'errors' => $validator->messages()
			]);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        if( $user ) {
        	if( count( $request->checkedRoles ) > 0 ) {
        		$user->assignRoles($request->checkedRoles);
        		return response()->json([
        			'success' => true,
        			'user' => $user
        		]);
        	}
        }
		return response()->json([
			'success' => false,
		]);
	}

	public function getUser( Request $request ) {
	    if( $request->ajax() && isset($request->id) ) {
	        $user = User::find( $request->id );
	        $roles = $user->roles;
	        return response()->json([
	            'success' => true,
                'user' => $user,
                'userRoles' => $roles
            ]);
        }

	    return response()->json([
	        'success' => false
        ]);
    }

    public function allRoles()
    {
    	return response()->json([
    		'success' => true,
    		'roles' => Role::all()
    	]);
    }

    public function editUser( Request $request ) {
	    if( $request->ajax() && isset($request->id) ) {
	        $user = User::find( $request->id );
	        $roles = $user->roles->pluck('id');
	        return response()->json([
	            'success' => true,
                'user' => $user,
                'userRoles' => $roles
            ]);
        }

	    return response()->json([
	        'success' => false
        ]);
    }

    public function updateUser( Request $request )
    {
    	if( isset( $request->id ) && $user = User::find($request->id) ) {
    		$validator = Validator::make($request->all(), [
            	'name' => 'required|string|max:255',
	            'email' => 'required|string|email|max:255|unique:users,email,'.$request->id,
	        ]);
	        if( $validator->fails() ){
	        	return response()->json([
					'success' => false,
					'errors' => $validator->messages()
				]);
	        }

    		$user->name = $request->name;
    		$user->email = $request->email;
    		$user->updated_at = now();
    		if( $user->update() ) {
    			$user->syncRoles($request->checkedRoles);
    		}
    		return response()->json([
    			'success' => true,
    			'user' => $request->all()
    		]);
    	}
    	return response()->json([
			'success' => false
		]);
    }

    public function deleteUser( Request $request )
    {
    	if(isset($request->id) && $user = User::find($request->id)){
    		$user->revokeRoles();
    		if( $user->delete() ){
    			return response()->json([
	    			'success' => true
	    		]);
			}
    	}

    	return response()->json([
			'success' => false,
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
}
