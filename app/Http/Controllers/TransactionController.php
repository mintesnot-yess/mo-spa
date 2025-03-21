<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        $hero = 'Complated';
        $transactions = Transaction::where('status', 1)->orderBy('created_at', 'desc')->paginate(10);

        return view('Pages.transaction.index', compact('transactions', 'hero'));
    }
    public function show()
    {
        $transactions = Transaction::where('status', 1)->orderBy('created_at', 'desc')->paginate(10);
        $hero = 'Complated';
        return view('Pages.transaction.index', compact('transactions', 'hero'));
    }
    public function pending_index()
    {
        $transactions = Transaction::where('status', 0)->orderBy('created_at', 'desc')->paginate(10);
        $hero = 'Pending';
        return view('Pages.transaction.index', compact('transactions', 'hero'));
    }
    public function pending_show()
    {
        $transactions = Transaction::where('status', 0)->orderBy('created_at', 'desc')->paginate(10);
        $hero = 'Pending';
        return view('Pages.transaction.index', compact('transactions', 'hero'));
    }
}
