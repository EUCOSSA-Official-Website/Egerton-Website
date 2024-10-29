<?php

namespace App\Http\Controllers;

use App\Models\Speaker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SpeakersController extends Controller
{
    /**
     * Returning Data For the People Who Have Applied.
     */
    public function index()
    {
        // The Dashboards  Data
        $speakers = Speaker::select('name', 'year_of_study', 'topic', 'email', 'id')->get();

        return $speakers;

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia('Speakers');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'email' => 'required|email',
            'name' => 'required|string',
            'year_of_study' => 'required|string',
            'other_year' => 'nullable|string',
            'topic' => 'required|string',
            'description' => 'required|string',
            'stack' => 'required|string',
            'skill' => 'required|string',
            'phone' => 'required|min:10|max:13'
        ]);

        $validatedData['creator_id'] = Auth::id();

        Speaker::create($validatedData);

        return redirect()->route('call-for-speakers.create')->with('success', 'Your Application Has been submited Successfully. ');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
