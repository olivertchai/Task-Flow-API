<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserValidateRequest;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = User::all();
        return response()->json(['data' => $user], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserValidateRequest $request)
    {
        // Usando o validate direto do Request!
        $data = $request->validated();

        $user = User::create($data);
        
        return response()->json(['data' => $user], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::find($id);
        return response()->json(['data' => $user], 200);
    }

    // /**
    //  * Show the form for editing the specified resource.
    //  */
    // public function edit(string $id)
    // {
    //     //
    // }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $rules = [
            'email' => 'email|unique:users,email,' . $id, // Ignora o email do usuário atual
            'password' => 'min:6',
            'admin' => 'in:' . User::ADMIN_USER . ',' . User::REGULAR_USER,
        ];

        $request->validate($rules);

        $user = User::find($id);
        
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        if ($request->has('name')) {
            $user->name = $request->name;
        }

        if ($request->has('email') && $request->email !== $user->email) {
            $user->email = $request->email;
            $user->verified = User::UNVERIFIED_USER;
            $user->verification_token = User::generateVerificationToken();
        }

        if ($request->has('password')) {
            $user->password = bcrypt($request->password);
        }

        if ($request->has('admin')) {
            if (!$user->isVerified()) {
                return response()->json(['message' => 'Only verified users can be admins'], 409);
            }
            $user->admin = $request->admin;
        }

        if (!$user->isDirty()) {
            return response()->json(['message' => 'At least one different value must be specified to update'], 422);
        }

        $user->update($request->all());


        return response()->json(['data' => $user], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);
        
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $user->delete();
        return response()->json(['message' => 'User deleted successfully'], 200);
    }
}
