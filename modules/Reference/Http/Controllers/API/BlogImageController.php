<?php

namespace Modules\Reference\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Modules\Reference\Http\Controllers\Controller;

class BlogImageController extends Controller
{
    /**
     * Display a listing of the resources..
     */
    public function store(Request $request)
    {
        // Check if the request has a file named 'filepond'
        if ($request->hasFile('file')) {
            $file = $request->file('file');

            // Validate the file (optional)
            $request->validate([
                'file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            // Create a unique filename
            $filename = uniqid() . '.' . $file->getClientOriginalExtension();

            // Save the original image to storage
            $path = $file->storeAs('blogs', $filename, 'public');

            // Return the URL of the uploaded file
            return response()->json([
                'path' => Storage::url($path),
                'real' => $path
            ], 200);
        }

        // Return an error response if no file is uploaded
        return response()->json(['error' => 'No file uploaded'], 400);
    }
}
