<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Care;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

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
}
