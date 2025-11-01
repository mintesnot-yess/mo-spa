<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SMS;

class SMSController extends Controller
{
    public function index()
    {
        $messages = [
            ['id' => 1, 'to' => '+1234567890', 'body' => 'Test message 1', 'created_at' => '2025-01-01 10:00:00'],
            ['id' => 2, 'to' => '+1987654321', 'body' => 'Test message 2', 'created_at' => '2025-01-02 11:00:00'],
            ['id' => 3, 'to' => '+1122334455', 'body' => 'Test message 3', 'created_at' => '2025-01-03 12:00:00'],
            ['id' => 3, 'to' => '+1122334455', 'body' => 'Test message 3', 'created_at' => '2025-01-03 12:00:00'],
        ];
        return view('Pages.sms.index', compact('messages'));
    }

    // public function create()
    // {
    //     return view('sms.create');
    // }

    // public function store(Request $request)
    // {
    //     $data = $request->validate([
    //         'to' => 'required|string',
    //         'body' => 'required|string',
    //     ]);

    // SMS::create($data);

    //     return redirect()->route('sms.index')->with('success', 'SMS created.');
    // }

    // public function show(SMS $sms)
    // {
    //     return view('sms.show', compact('sms'));
    // }

    // public function edit(SMS $sms)
    // {
    //     return view('sms.edit', compact('sms'));
    // }

    // public function update(Request $request, SMS $sms)
    // {
    //     $data = $request->validate([
    //         'to'   => 'required|string',
    //         'body' => 'required|string',
    //     ]);

    //     $sms->update($data);

    //     return redirect()->route('sms.index')->with('success', 'SMS updated.');
    // }

    // public function destroy(SMS $sms)
    // {
    //     $sms->delete();

    //     return redirect()->route('sms.index')->with('success', 'SMS deleted.');
    // }
}
