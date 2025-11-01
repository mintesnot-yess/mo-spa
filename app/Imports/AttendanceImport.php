<?php

namespace App\Imports;

use App\Models\Attendance;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class AttendanceImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */

    public $importedCount = 0;
    public $duplicateCount = 0;
    public function model(array $row)
    {
        $personId = $this->getValue($row, 'person_id');
        $date = $this->parseDate($this->getValue($row, 'date'));

        if (empty($personId) || empty($date)) {
            return null; // skip invalid
        }

        // Check for duplicate
        $dateString = $date instanceof \Carbon\Carbon ? $date->toDateString() : (string) $date;
        if (
            Attendance::where('person_id', $personId)
                ->whereRaw('DATE(`date`) = ?', [$dateString])
                ->exists()
        ) {
            $this->duplicateCount++;
            return null; // skip
        }

        $this->importedCount++;

        return new Attendance([
            'person_id' => $personId,
            'date' => $date,
            'check_in' => $this->getValue($row, 'check_in', '-'),
            'check_out' => $this->getValue($row, 'check_out', '-'),
            'late' => $this->getValue($row, 'late', '0 min'),
            'early_leave' => $this->getValue($row, 'early_leave', '0 min'),
            'attended' => $this->getValue($row, 'attended', '0 min'),
            'absent' => $this->getValue($row, 'absent', '0 min'),
            'worked' => $this->getValue($row, 'worked', '0 min'),
            'break' => $this->getValue($row, 'break', '0 min'),
            'leave_type' => $this->getValue($row, 'leave_type', '-'),
            'leave' => $this->getValue($row, 'leave', '0 min'),
            'ot1' => $this->getValue($row, 'ot1', '0 min'),
            'ot2' => $this->getValue($row, 'ot2', '0 min'),
            'ot3' => $this->getValue($row, 'ot3', '0 min'),
        ]);
    }
    /**
     * Get value from row with fallback
     */
    private function getValue(array $row, string $key, $default = null)
    {
        // Check multiple possible column names
        $possibleKeys = [
            $key,
            strtolower($key),
            str_replace(' ', '_', strtolower($key)),
            str_replace('_', ' ', strtolower($key))
        ];

        foreach ($possibleKeys as $possibleKey) {
            if (isset($row[$possibleKey])) {
                return $row[$possibleKey];
            }
        }

        return $default;
    }

    /**
     * Parse date from Excel format or string
     */
    private function parseDate($value)
    {
        if (empty($value)) {
            return null;
        }

        try {
            // If it's an Excel serial date
            if (is_numeric($value)) {
                return Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value));
            }

            // Try different date formats
            return Carbon::createFromFormat('Y-m-d', $value) ??
                Carbon::createFromFormat('d-m-y', $value) ??
                Carbon::createFromFormat('m/d/Y', $value) ??
                Carbon::parse($value);
        } catch (\Exception $e) {
            return null;
        }
    }
}