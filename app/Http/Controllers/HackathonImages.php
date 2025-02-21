<?php

namespace App\Http\Controllers;

use App\Models\HackathonImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HackathonImages extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        $validatedData = $request->validate([
            'title' => 'required',
            'description' => 'required|string',
            'image' => 'required|mimes:jpeg,png,jpg,gif|mimetypes:image/jpeg,image/png,image/jpg,image/gif|max:8192',
        ]);

        // Handle file upload
        if ($request->hasFile('image')) {
            // Store the image and get the file path
            $path = $request->file('image')->store('hackathon-winners', 'public'); // Store in storage/app/public/events

            // Generate the full public URL of the image
            $validatedData['image'] = asset('storage/' . $path);  // Use asset to generate the accessible URL
        }

        HackathonImage::create($validatedData);

        return redirect()->back()->with('success', 'Hackathon Image Created Successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(HackathonImage $hackathonImage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(HackathonImage $hackathonImage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, HackathonImage $hackathonImage)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $hackathonImage = HackathonImage::find($id);

        if (!$hackathonImage) {
            Log::error("Hackathon image not found with ID: {$id}");
            return back()->with('error', 'Image not found.');
        }

        Log::info("Deleting image with ID: {$hackathonImage->id}");
        
        $hackathonImage->delete(); // Soft delete

        Log::info("After delete: " . json_encode($hackathonImage->toArray()));

        return back()->with('success', 'Image deleted successfully');
    }

    public function restore($id)
    {
        $image = HackathonImage::withTrashed()->find($id);

        if ($image && $image->trashed()) {
            $image->restore();
            return back()->with('success', 'Image restored successfully');
        }

        return back()->with('error', 'Image not found or not deleted.');
    }

}
