<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::all();
        return response()->json(['data' => $blogs]);
    }

    public function show($id)
    {
        $blog = Blog::findOrFail($id);
        return response()->json(['data' => $blog]);
    }

    public function store(Request $request)
    {
         $request->validate([
            'title' => 'required',
            'description' => 'required',
            'image' => 'required|image|mimes:jpg,png,webp', // Validasi ekstensi gambar
        ]);
        
        $imagePath = $request->file('image')->store('blog_images', 'public');

        $blog = Blog::create([
            'uuid' => \Ramsey\Uuid\Uuid::uuid4()->toString(),
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'image' => $imagePath,
        ]);

        return response()->json(['data' => $blog], 201);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'image' => 'sometimes|image|mimes:jpg,png,webp',
        ]);

        $blog = Blog::findOrFail($id);

        if ($request->hasFile('image')) {
            // Hapus gambar lama sebelum menyimpan yang baru
            Storage::disk('public')->delete($blog->image);

            $imagePath = $request->file('image')->store('blog_images', 'public');
            $blog->image = $imagePath;
        }

        $blog->title = $request->input('title');
        $blog->description = $request->input('description');
        $blog->save();

        return response()->json(['data' => $blog]);
    }

    public function destroy($id)
    {
        $blog = Blog::findOrFail($id);
        Storage::disk('public')->delete($blog->image);
        $blog->delete();

        return response()->json(['message' => 'Blog deleted successfully']);
    }
}
