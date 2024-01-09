<?php

namespace App\Http\Controllers\Users;

use App\Http\Constants\AgentPermission;
use App\Http\Constants\Constant;
use App\Http\Constants\UserPermission;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Http\Resources\Users\RoleResource;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;


class RoleController extends Controller
{


    /**
     * Display a paginated listing of the users.
     */
    public function index(Request $request)
    {
        $query = Role::query();

        return response()->json($query->paginate($request->get('per_page', Constant::PER_PAGE)));
    }
    /**
     * Display a paginated listing of the users.
     */
    public function permissionList(Request $request)
    {
        return response()->json(Permission::query()->get(['id', 'name']));
    }

    /**
     * Display a lookup of the resource.
     */
    public function lookup()
    {
        return response()->json(Role::get(['id', 'name']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoleRequest $request)
    {
        $role = Role::create($request->all());

        return RoleResource::make($role)->additional([
            'message' => 'Role created successful'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        return response()->json($role);
    }

    /**
     * Display the specified resource.
     */
    public function generatePermissions(Role $role)
    {
        $userPermissions = UserPermission::getConstants();
        foreach ($userPermissions as $key => $value) {
            try {
                Permission::create([
                    'name' => $value,
                    'guard_name' => 'user-api',
                ]);
            } catch (\Throwable $th) {
                continue;
            }
        }
        $agentPermissions = AgentPermission::getConstants();
        foreach ($agentPermissions as $key => $value) {
            try {
                Permission::create([
                    'name' => $value,
                    'guard_name' => 'agent-api', 
                ]);
            } catch (\Throwable $th) {
                continue;
            }
        }
        return response()->json(['status'=>"successfully"]);
    }

    /**
     * Display the specified resource.
     */
    public function assignPermission(Role $role)
    {
        return response()->json($role);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoleRequest $request, Role $role)
    {
        $role->update($request->all());

        return response()->json(['message' => 'Agent type updated successfully', 'data' => $role]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        try {
            $role->delete();
            return response()->json([
                'message' => 'Role Remove Successfully'
            ]);
        } catch (QueryException $th) {
            return RoleResource::make($role)->additional([
                'message' => 'You cant remove this Role it has Relation'
            ]);
        }
    }
}
