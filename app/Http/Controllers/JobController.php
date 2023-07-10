<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\User;
use Illuminate\Http\Request;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $jobs = Job::select('*')->offset(intval($request->offset))->limit(intval($request->limit))->get();;
        return response()->json($jobs);
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
        $job = Job::create($request->all());
        $data = [
            'message' => 'Job created successfully',
            'job' => $job
        ];
        return response()->json($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $job = Job::find($id);
        $message = $job == null ? 'Job not found' : 'Job found';
        $data = [
            'message' => $message,
            'job' => $job
        ];
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
        $job = Job::find($id);
        $message = 'Job not found';
        if ($job != null) {
            $job->update($request->all());
            $message = 'Job found';
        }
        $data = [
            'message' => $message,
            'job' => $job
        ];
        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Job $job)
    {
        $job->delete();
        $data = [
            'message' => 'Job deleted successfully',
            'job' => $job
        ];
        return response()->json($data);
    }
}
