<?php

namespace App\Http\Controllers\Users;

use App\Http\Constants\Constant;
use App\Http\Controllers\Controller;
use App\Http\Requests\Users\RegisterUserRequest;
use App\Http\Requests\Users\UpdateUserRequest;
use App\Http\Resources\Users\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a paginated listing of the users.
     */
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }
        $query->orderBy('created_at', 'desc');
        return UserResource::collection($query->paginate($request->get('per_page', Constant::PER_PAGE)));
    }


    public function store(RegisterUserRequest $registerUserRequest)
    {

        $user = User::create($registerUserRequest->all());
        return UserResource::make($user)->additional([
            'message' => 'user registered successfully'
        ]);
    }

    public function assignRole(Request $request, User $user)
    {
        $userGuardRoles = Role::whereIn('name', $request->input('roles'))->get();

        $user->syncRoles($userGuardRoles);
        return response()->json(['message' => 'Roles assigned successfully']);
    }

    public function show(User $user)
    {
        return  UserResource::make($user);
    }
    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update($request->all());
        return UserResource::make($user)->additional([
            'message' => 'User updated Successfully',
        ]);
    }

    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(null, 204);
    }
}
