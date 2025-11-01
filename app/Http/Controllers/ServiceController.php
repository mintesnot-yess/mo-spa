<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Category;
use App\Models\Transaction;
use App\Models\Service;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Events\ServiceStatusChange;
use App\Models\Item;
use App\Models\Client;
use App\Models\Employee;
use App\Models\ServiceItems;

class ServiceController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
        $this->middleware('permission:show_service', ['only' => ['index']]);
        $this->middleware('permission:add_service', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit_service', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete_service', ['only' => ['destroy']]);

        $this->middleware('permission:show_item', ['only' => ['item_index']]);
        $this->middleware('permission:add_item', ['only' => ['item_create', 'item_store']]);
        $this->middleware('permission:edit_item', ['only' => ['item_edit', 'item_update']]);
        $this->middleware('permission:delete_item', ['only' => ['item_destroy']]);

        $this->middleware('permission:show_branch', ['only' => ['branch_index']]);
        $this->middleware('permission:add_branch', ['only' => ['branch_create', 'branch_store']]);
        $this->middleware('permission:edit_branch', ['only' => ['branch_edit', 'branch_update']]);
        $this->middleware('permission:delete_branch', ['only' => ['branch_destroy']]);
    }
    public function index()
    {
        $services = Service::with('itemServices.item')->orderBy('created_at', 'desc')->get();
        
        return view('Pages.services.index', compact('services'));
    }

    public function create()
    {
        $categories = Category::all();
        $items = Item::all();
        return view('Pages.services.create', compact('categories', 'items'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:services',
            'title' => 'required',
            'price' => 'required',
            'need_item' => 'required',
            'type' => 'required',
            'items' => 'nullable|array',
            'items.*' => 'exists:items,id'
        ]);
       $service = Service::create([
            'code' => $request->code,
            'title' => $request->title,
            'price' => $request->price,
            'type' => $request->type,
            'category' => $request->category,
            'have_items' => $request->need_item,
            'created_by' => auth()->user()->id,
            'status' => $request->status ?? 1,
        ]);
        // dd($request->all(),$service);
        if($request->items && $request->need_item == 'yes'){
            foreach($request->items as $item){
                $serviceItems = ServiceItems::create([
                    'service_id' => $service->id,
                    'item_id' => $item,
                    'created_by' => auth()->user()->id,
                ]);
            }
        }
        return redirect()->route('service')->with('success', 'Service created successfully');
    }
    public function edit($id)
    {
        $service = Service::find($id);
        $categories = Category::all();        
        $items = Item::all();
        $serviceItems = ServiceItems::where('service_id', $id)->pluck('item_id')->toArray();
        return view('Pages.services.edit', compact('service','items','serviceItems', 'categories'));
    }
    public function update(Request $request, $id)
    {
        
        $request->validate([
            'code' => 'required|unique:services,code,' . $id,
            'title' => 'required',
            'need_item' => 'required',
            'type' => 'required',
            'price' => 'required',
            'items' => 'nullable|array',
            'items.*' => 'exists:items,id'
        ]);
        $service = Service::find($id)->update([
            'code' => $request->code,
            'title' => $request->title,
            'price' => $request->price,
            'type' => $request->type,
            'category' => $request->category,
            'updated_by' => auth()->user()->id,
            'have_items' => $request->need_item,
            'status' => $request->status ?? 1,
        ]);
        if($request->items && $request->need_item == 'yes' ){
            ServiceItems::where('service_id', $id)->delete();
            foreach($request->items as $item){
                $serviceItems = ServiceItems::create([
                    'service_id' => $id,
                    'item_id' => $item,
                    'created_by' => auth()->user()->id,
                ]);
            }
        }
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
        // In your controller (or config if reused in multiple places)
$groupMappings = [
    'ስፓ' => 1,
    'ጸጉር ቆራጭ' => 2,
    'የውስጥ ስራዎች' => 3,
];

foreach ($groupMappings as $serviceGroup => $groupId) {
    $services = Service::where('status', 1)
        ->where('type', $serviceGroup)
        ->with(['categories', 'itemServices.item'])
        ->get()
        ->map(function ($service) {
            if ($service->have_items === 'yes') {
                $service->items_list = $service->itemServices
                    ->map(fn($itemService) => $itemService->item)
                    ->filter()
                    ->unique('id')
                    ->values();
            } else {
                $service->items_list = collect();
            }
            unset($service->itemServices);
            return $service;
        })
        ->toArray();

    broadcast(new ServiceStatusChange($services, $groupId)); // Pass the group ID instead of name or hash
}

// dd($services);
            broadcast(new ServiceStatusChange($services, $serviceGroup));

        return response()->json(['success' => true, 'message' => 'Service status updated successfully!']);
    }

    public function destroy($id)
    {
        $trnasaction = Transaction::where('service_id',$id)->count();
        if ($trnasaction > 0) {
        return redirect()->back()->with('error', "The service cannot be deleted because it is currently Associated to {$trnasaction} transaction(s).");
    }
        $serviceItem = ServiceItems::where('service_id',$id)->count();
        if ($serviceItem > 0) {
        return redirect()->back()->with('error', "The service cannot be deleted because it is currently Associated to {$serviceItem} service Items(s).");
    }
        Service::find($id)->delete();
        ServiceItems::where('service_id', $id)->delete();
        return redirect()->route('service')->with('success', 'Service deleted successfully');
    }
    public function complateServeice(Request $request)
    {
        $transactions = json_decode($request->transactions, true);

        foreach ($transactions as $transactionData) {
            $transaction = Transaction::find($transactionData['id']);
            $transaction->status = 0;
            $transaction->is_new = $transactionData['is_new'];
            $transaction->save();
        }
    $client = Client::find($request->cleint_id);
    $client->status = 0;
    $client->save();
        return redirect()->back()->with('success', 'Service completed successfully');
    }
    public function branch_index()
    {
        $branches = Branch::orderBy('created_at', 'desc')->get();
        return view('Pages.branch.index', compact('branches'));
    }
    public function branch_store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);
        $user_id = Auth::user()->id;
        Branch::create([
            'name' => $request->name,
            'created_by' => $user_id,
        ]);

        return redirect()->route('branch')->with('success', 'Branch created successfully');
    }
    public function branch_update(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);
        $id = $request->id;
        $user_id = Auth::user()->id;
        Branch::find($id)->update([
            'name' => $request->name,
            'created_by' => $user_id,
        ]);

        return redirect()->route('branch')->with('success', 'Branch created successfully');
    }
    public function branch_destroy($id)
    {
         $trnasaction = Transaction::where('branch_id',$id)->count();
        if ($trnasaction > 0) {
        return redirect()->back()->with('error', "The branch cannot be deleted because it is currently Associated to {$trnasaction} transaction(s).");
    }
         $employee = Employee::where('branch_id',$id)->count();
        if ($employee > 0) {
        return redirect()->back()->with('error', "The branch cannot be deleted because it is currently Associated to {$employee} employee(s).");
    }
         $client = Client::where('branch_id',$id)->count();
        if ($client > 0) {
        return redirect()->back()->with('error', "The branch cannot be deleted because it is currently Associated to {$client} customer(s).");
    }
        Branch::find($id)->delete();
        return redirect()->route('branch')->with('success', 'Branch deleted successfully');
    }
    public function item_index()
    {

        $items = Item::orderBy('created_at', 'desc')->get();
        return view('Pages.item.index', compact('items'));
    }
    public function item_store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);
        $user_id = Auth::user()->id;
        Item::create([
            'name' => $request->name,
            'created_by' => $user_id,
        ]);

        return redirect()->route('item')->with('success', 'Item created successfully');
    }
    public function item_update(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);
        $id = $request->id;
        $user_id = Auth::user()->id;
        Item::find($id)->update([
            'name' => $request->name,
            'created_by' => $user_id,
        ]);

        return redirect()->route('item')->with('success', 'Item created successfully');
    }
    public function item_destroy($id)
    {
        $serviceItem = ServiceItems::where('item_id',$id)->count();
        if ($serviceItem > 0) {
        return redirect()->back()->with('error', "The item cannot be deleted because it is currently Associated to {$serviceItem} service Items(s).");
    }
        Item::find($id)->delete();
        return redirect()->route('item')->with('success', 'Item deleted successfully');
    }
}
