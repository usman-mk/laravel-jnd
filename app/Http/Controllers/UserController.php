<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $models = User::all();
        return view('user.index', [
            'models' => $models
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('user.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $requestData = $request->all();
        $requestData['password'] = Hash::make($request->password);
        $query = User::create($requestData);

        return redirect()->route('user.user.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('user.edit', ['model' => $user]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $requestData = $request->all();
        if ($request->password) {
            $requestData['password'] = Hash::make($request->password);
        } else {
            unset($requestData['password']);
        }
        // set change password
        $requestData['is_new'] = (Auth::user()->id === $user->id) ? '0' : '1';
        $query = $user->update($requestData);

        return redirect()->route('user.user.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $query = $user->delete();

        return redirect()->route('user.user.index');
    }
}
