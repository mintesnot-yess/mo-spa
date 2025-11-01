<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        $hero = 'Complated';
        $transactions = Transaction::where('status', 0)
            ->with(['client', 'service', 'employee']) // Assuming these relationships exist
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy(function ($transaction) {
                return $transaction->client_id . '_' . $transaction->created_at->format('Y-m-d');
            });
        return view('Pages.transaction.index', compact('transactions', 'hero'));
    }
    public function show()
    {
        $transactions = Transaction::where('status', 0)->orderBy('created_at', 'desc')->paginate(10);
        $hero = 'Complated';
        return view('Pages.transaction.index', compact('transactions', 'hero'));
    }
    public function pending_index()
    {
        $transactions = Transaction::where('status', 1)
            ->with(['client', 'service', 'employee']) // Assuming these relationships exist
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy(function ($transaction) {
                return $transaction->client_id . '_' . $transaction->created_at->format('Y-m-d');
            });

        return view('Pages.transaction.pending', compact('transactions'));
    }
    public function pending_show()
    {
        $transactions = Transaction::where('status', 1)->orderBy('created_at', 'desc')->paginate(10);

        return view('Pages.transaction.pending', compact('transactions'));
    }
    public function destroy($id)
    {
        $transaction = Transaction::find($id);

        if (!$transaction) {
            return response()->json(['success' => false, 'message' => 'Transaction not found.'], 404);
        }

        $transaction->delete();

        return response()->json(['success' => true, 'message' => 'Transaction deleted successfully.']);
    }
    public function updateIsNew(Request $request, $id)
{
    $transaction = Transaction::find($id);
   
    if (!$transaction) {
        return response()->json(['success' => false, 'message' => 'Transaction not found.'], 404);
    }

    $transaction->is_new = $request->is_new ? 1 : 0;
    $transaction->save();

    return response()->json(['success' => true, 'message' => 'Status updated successfully.']);
}

}
