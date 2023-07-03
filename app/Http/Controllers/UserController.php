<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $users = User::select('*')->offset(intval($request->offset))->limit(intval($request->limit))->get();;
        return response()->json($users);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = User::create($request->all());
        $data = [
            'message' => 'User created successfully',
            'user' => $user
        ];
        return response()->json($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::find($id);
        if ($user == null)
            $data = [
                'message' => 'User not found'
            ];
        else {
            $data = [
                'message' => 'User found',
                'user' => $user,
                'jobs' => $user->jobs,
            ];
        }
        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::find($id);
        $message = 'User not found';
        if ($user != null) {
            $user->update($request->all());
            $message = 'successfully modified user';
        }
        $data = [
            'message' => $message,
            'job' => $user
        ];
        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        $data = [
            'message' => 'User deleted successfully',
            'user' => $user
        ];
        return response()->json($data);
    }

    public function attach(string $id, Request $request)
    {
        $user = User::find($id);
        if ($user == null) {
            $data = [
                'message' => 'Jobs no attached because user not exist',
            ];
        } else {
            foreach ($request->jobs as $job)
                if (!$user->jobs()->find($job))
                    $user->jobs()->attach($job);
            $data = [
                'message' => 'Job attached successfully',
                'jobs' => $user->jobs,
            ];
        }
        return response()->json($data);
    }

    public function detach(string $id, Request $request)
    {
        $user = User::find($id);
        if ($user == null) {
            $data = [
                'message' => 'Jobs no detached because user not exist',
            ];
        } else {
            foreach ($request->jobs as $job)
                if ($user->jobs()->find($job))
                    $user->jobs()->detach($job);
            $data = [
                'message' => 'Jobs detached successfully',
                'jobs' => $user->jobs,
            ];
        }
        return response()->json($data);
    }
}
