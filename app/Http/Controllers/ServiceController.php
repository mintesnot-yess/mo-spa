<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index(){
        $services = Service::orderBy('created_at', 'desc')->paginate(10);
        return view('Pages.services.index', compact('services'));
    }
    
    public function create(){
        $categories = Category::all();
        return view('Pages.services.create', compact('categories'));
    }
    
    public function store(Request $request){
        $request->validate([
            'code' =>'required|unique:services',
            'title' =>'required',
            'price' =>'required',
            'type' =>'required',        
        ]);
        Service::create([
            'code' => $request->code,
            'title' => $request->title,
            'category' => $request->category,
            'price' => $request->price,
            'type' => $request->type,
            'created_by' => auth()->user()->id,
            'status' => $request->status ?? 1,          
        ]);
        return redirect()->route('service')->with('success', 'Service created successfully');
    }
    public function edit($id){
        $service = Service::find($id);
        $categories = Category::all();
        return view('Pages.services.edit', compact('service', 'categories'));
    }
    public function update(Request $request, $id){
        $request->validate([
            'code' =>'required|unique:services,code,'.$id,
            'title' =>'required',
            'category' =>'required',
            'price' =>'required',
            'type' =>'required',        
        ]);
        Service::find($id)->update([
            'code' => $request->code,
            'title' => $request->title,
            'category' => $request->category,
            'price' => $request->price,
            'type' => $request->type,
            'updated_by' => auth()->user()->id,
            'status' => $request->status ?? 1,          
        ]);
        return redirect()->route('service')->with('success', 'Service updated successfully');
    }
    public function updateStatus(Request $request)
{
    $service = Service::find($request->id);

    if (!$service) {
        return response()->json(['success' => false, 'message' => 'Service not found'], 404);
    }

    $service->status = $request->status;
    $service->save();

    return response()->json(['success' => true, 'message' => 'Service status updated successfully!']);
}

    public function destroy($id){
        Service::find($id)->delete();
        return redirect()->route('service')->with('success', 'Service deleted successfully');
    }
}
