<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        // Fetch all categories from the database
        $categories = Category::orderBy('created_at', 'desc')->paginate(10);
        
        return view('Pages.categories.index', compact('categories'));
    }
    public function create()
    {
        $categories = Category::all();
        return view('Pages.categories.create',compact('categories'));
    }
    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'title' => 'required|max:255',
            'type' => 'required',
            'parent_category_id' => 'nullable|exists:categories,id'
        ]);
        Category::create([
            'title' => $request->title,
            'type' => $request->type,
            'parent_category_id' => $request->parent_category_id,
            'created_by' => auth()->user()->id,
        ]);
        return redirect()->route('category')->with('success', 'Category created successfully.');
    }
    public function edit($id){
        $category = Category::find($id);         
        $categories = Category::where('id', '!=', $id)->whereNull('parent_category_id')->get();      
        return view('Pages.categories.edit', compact('category','categories'));
    }
    public function update(Request $request, $id){
        // Validate the request data
        $request->validate([
            'title' =>'required|max:255',
            'type' =>'required',
            'parent_category_id' => 'nullable|exists:categories,id'
        ]);
        $category = Category::find($id);
        $category->update([
            'title' => $request->title,
            'type' => $request->type,
            'parent_category_id' => $request->parent_category_id,
            'updated_by' => auth()->user()->id,
        ]);
        return redirect()->route('category')->with('success', 'Category updated successfully.');
    }
    public function destroy($id){
        $category = Category::find($id);
        $category->delete();
        return redirect()->route('category')->with('success', 'Category deleted successfully.');
    }
}
