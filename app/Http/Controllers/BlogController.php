<?php

namespace App\Http\Controllers;

use App\Http\Resources\BlogResource;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BlogController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->sendResponse(BlogResource::collection(Blog::all()), 'Blogs retrieved successfully');
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
    public function store(Request $request)
    {
        $validator = Validator::make([
            'title' => 'required',
            'description' => 'required',
        ]);
        if($validator->fails()) {
            return $this->sendError("Validation Error", $validator->errors(), 400);
        }
        $blog = Blog::create([
            'title' => $request->title,
            'description' => $request->description,
        ]);
        return $this->sendResponse(new BlogResource($blog), "Blog created succesfully");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $blog = Blog::find($id);
        if(is_null($blog)) {
            return $this->sendError("Blog not found");
        }
        return $this->sendResponse(new BlogResource($blog), "Blog retrieved successfully");
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
        $validator = Validator::make([
            'title' => 'required',
            'description' => 'required'
        ]);
        if($validator->fails()) {
            return $this->sendError("Validation Error");
        }
        $blog = Blog::find($id)->update([
                'title' => $request->title,
                'description' => $request->description,
            ]);
            return $this->sendResponse(new BlogResource($blog), "Blog Updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $blog = Blog::find($id);
        if(is_null($blog)) {
            return $this->sendError("Blog not found");
        }
        $blog->delete();
        return $this->sendResponse(new BlogResource($blog), "Blog deleted successfully");
    }
}
