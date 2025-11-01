<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Imports\AttendanceImport;
use Maatwebsite\Excel\Facades\Excel;

class AttendanceController extends Controller
{
    public function index()
    {
        $attendances = Attendance::latest()->get();
        return view('Pages.attendance.index', compact('attendances'));
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048'
        ]);

        try {
            $import = new AttendanceImport;
            Excel::import($import, $request->file('file'));

            // Build success message
            if ($import->duplicateCount > 0) {
                $message = "{$import->duplicateCount} attendance record(s) already exist. ";
                $message .= "{$import->importedCount} new record(s) imported successfully.";
            } else {
                $message = "Attendance records imported successfully.";
            }

            return redirect()->route('attendance.index')
                ->with('success', $message);

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error importing file: ' . $e->getMessage());
        }
    }

    // Add other CRUD methods... 

    public function store(Request $request)
    {
        $request->validate([
            'person_id' => 'required|string',
            'date' => 'required|date|unique:attendances,person_id,NULL,id,date,' . $request->date,
            // But this is tricky because it's a composite key
        ]);

        // Better: use a custom rule or check manually
        if (
            Attendance::where('person_id', $request->person_id)
                ->whereRaw('DATE(`date`) = ?', [$request->date])
                ->exists()
        ) {
            return back()->withErrors(['person_id' => 'An attendance record for this person on this date already exists.']);
        }

        Attendance::create($request->all());

        return redirect()->route('attendance.index')->with('success', 'Record added successfully.');
    }

    // public function edit($id)
    // {
    //     $attendance = Attendance::findOrFail($id);
    //     return view('Pages.attendance.edit', compact('attendance'));
    // }

    // public function update(Request $request, $id)
    // {
    //     $request->validate([
    //         'person_id' => 'required|string',
    //         'date' => 'required|date',
    //     ]);

    //     $attendance = Attendance::findOrFail($id);
    //     $attendance->update($request->all());

    //     return redirect()->route('attendance.index')
    //         ->with('success', 'Attendance record updated successfully.');
    // }

    // public function destroy($id)
    // {
    //     $attendance = Attendance::findOrFail($id);
    //     $attendance->delete();

    //     return redirect()->route('attendance.index')
    //         ->with('success', 'Attendance record deleted successfully.');
    // }
}