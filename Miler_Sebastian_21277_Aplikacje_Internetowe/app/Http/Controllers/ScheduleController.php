<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Care;
use App\Models\User;
use App\Models\Role;
use App\Models\Subspecies;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ScheduleController extends Controller
{
    public function index(Request $request)
    {
        $date = $request->has('month') ? Carbon::parse($request->input('month')) : Carbon::now();

        $startOfMonth = $date->copy()->startOfMonth();
        $endOfMonth = $date->copy()->endOfMonth();
        $startDayOfWeek = $startOfMonth->dayOfWeekIso; 
        $daysInMonth = $date->daysInMonth;
        $prevMonth = $date->copy()->subMonth()->format('Y-m');
        $nextMonth = $date->copy()->addMonth()->format('Y-m');

        $cares = Care::where('user_id', Auth::id())
            ->whereBetween('care_date', [$startOfMonth, $endOfMonth])
            ->with('subspecies')
            ->get()
            ->groupBy(function ($care) {
                return Carbon::parse($care->care_date)->day;
            });

        return view('schedule.index', compact(
            'date', 
            'startDayOfWeek', 
            'daysInMonth', 
            'cares',
            'prevMonth',
            'nextMonth'
        ));
    }
    public function managerIndex(Request $request)
    {
        $date = $request->has('week') 
            ? Carbon::parse($request->input('week'))->startOfWeek() 
            : Carbon::now()->startOfWeek();

        $endOfWeek = $date->copy()->endOfWeek();
        $weekDates = [];
        $tempDate = $date->copy();
        for ($i = 0; $i < 7; $i++) {
            $weekDates[] = $tempDate->copy();
            $tempDate->addDay();
        }

        $employees = User::whereHas('role', function($q) {
            $q->where('name', 'employee');
        })->orderBy('last_name')->get();

        $cares = Care::whereBetween('care_date', [$date->format('Y-m-d'), $endOfWeek->format('Y-m-d')])
            ->with(['user', 'subspecies'])
            ->get();

        $schedule = [];
        foreach ($cares as $care) {
            $d = $care->care_date->format('Y-m-d');
            $u = $care->user_id;
            
            if (!isset($schedule[$u])) $schedule[$u] = [];
            if (!isset($schedule[$u][$d])) $schedule[$u][$d] = collect();
            
            $schedule[$u][$d]->push($care);
        }
        $prevWeek = $date->copy()->subWeek()->format('Y-m-d');
        $nextWeek = $date->copy()->addWeek()->format('Y-m-d');
        return view('schedule.manager', compact(
            'date', 
            'weekDates', 
            'employees',
            'schedule', 
            'prevWeek', 
            'nextWeek'
        ));
    }
    public function getDayData($date)
    {
        $targetDate = Carbon::parse($date)->format('Y-m-d');
        $subspecies = Subspecies::orderBy('common_name')->get(['id', 'common_name']);

        $employees = User::whereHas('role', function($q) {
            $q->where('name', 'employee');
        })->orderBy('last_name')->get(['id', 'name', 'last_name']);

        $assignments = Care::whereDate('care_date', $targetDate)
            ->get(['subspecies_id', 'user_id', 'shift']);

        return response()->json([
            'date' => $targetDate,
            'subspecies' => $subspecies,
            'employees' => $employees,
            'assignments' => $assignments
        ]);
    }
    public function saveDayData(Request $request)
    {
        $data = $request->validate([
            'date' => 'required|date',
            'shifts' => 'array',
        ]);

        $targetDate = $data['date'];

        DB::transaction(function () use ($targetDate, $data) {
            Care::whereDate('care_date', $targetDate)->delete();

            if (!empty($data['shifts'])) {
                $insertData = [];
                foreach ($data['shifts'] as $shift) {
                    if (empty($shift['user_id'])) continue;

                    $insertData[] = [
                        'care_date' => $targetDate,
                        'subspecies_id' => $shift['subspecies_id'],
                        'user_id' => $shift['user_id'],
                        'shift' => $shift['shift'],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
                
                if (count($insertData) > 0) {
                    Care::insert($insertData);
                }
            }
        });

        return response()->json(['message' => 'Grafik zapisany pomyślnie!']);
    }
}
