<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DiagnosticRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DiagnosticCalendarController extends Controller
{
    public function __invoke(Request $request): View
    {
        $year = (int) $request->query('year', Carbon::now()->year);
        $month = (int) $request->query('month', Carbon::now()->month);

        $firstDay = Carbon::create($year, $month, 1);
        $daysInMonth = $firstDay->daysInMonth;
        $startDow = ($firstDay->dayOfWeek + 6) % 7;
        $today = Carbon::today();

        $start = $firstDay->copy()->startOfDay();
        $end = $firstDay->copy()->endOfMonth()->endOfDay();

        $diagnostics = DiagnosticRequest::query()
            ->with('consultant')
            ->where(function ($q) use ($start, $end) {
                $q->whereBetween('scheduled_date', [$start, $end])
                    ->orWhere(function ($q2) use ($start, $end) {
                        $q2->whereNull('scheduled_date')
                            ->whereBetween('requested_date', [$start, $end]);
                    });
            })
            ->get()
            ->groupBy(function (DiagnosticRequest $d) {
                $date = $d->scheduled_date ?? $d->requested_date;

                return $date ? Carbon::parse($date)->format('Y-m-d') : null;
            });

        $days = [];
        for ($i = 0; $i < $startDow; $i++) {
            $days[] = null;
        }
        for ($d = 1; $d <= $daysInMonth; $d++) {
            $date = Carbon::create($year, $month, $d);
            $key = $date->format('Y-m-d');
            $days[] = [
                'day' => $d,
                'date' => $key,
                'is_today' => $date->isSameDay($today),
                'is_weekend' => $date->isWeekend(),
                'events' => ($diagnostics[$key] ?? collect())->all(),
            ];
        }

        $monthLabel = $firstDay->locale('fr')->isoFormat('MMMM YYYY');

        $prev = $firstDay->copy()->subMonth();
        $next = $firstDay->copy()->addMonth();

        return view('admin.diagnostic-calendar', compact(
            'days', 'monthLabel', 'year', 'month', 'prev', 'next'
        ));
    }
}
