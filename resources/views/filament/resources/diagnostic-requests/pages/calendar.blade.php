<x-filament-panels::page>
    @php
        $days = $this->getCalendarDays();
        $monthLabel = $this->getMonthLabel();
        $weekdays = ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'];
        $editRouteBase = \App\Filament\Resources\DiagnosticRequests\DiagnosticRequestResource::getUrl('edit', ['record' => 0]);

        $statusStyles = [
            'requested'   => 'background:#fef3c7;color:#92400e;border-color:#fde68a',
            'scheduled'   => 'background:#dbeafe;color:#1e40af;border-color:#bfdbfe',
            'in_progress' => 'background:#e0e7ff;color:#3730a3;border-color:#c7d2fe',
            'completed'   => 'background:#d1fae5;color:#065f46;border-color:#a7f3d0',
            'converted'   => 'background:#ede9fe;color:#5b21b6;border-color:#ddd6fe',
            'cancelled'   => 'background:#f3f4f6;color:#6b7280;border-color:#e5e7eb',
        ];
        $statusDots = [
            'requested'   => '#f59e0b',
            'scheduled'   => '#3b82f6',
            'in_progress' => '#6366f1',
            'completed'   => '#10b981',
            'converted'   => '#8b5cf6',
            'cancelled'   => '#9ca3af',
        ];
        $statusLabels = [
            'requested'   => 'Demandé',
            'scheduled'   => 'Planifié',
            'in_progress' => 'En cours',
            'completed'   => 'Terminé',
            'converted'   => 'Converti',
            'cancelled'   => 'Annulé',
        ];
    @endphp

    <style>
        .cal-wrap { background:#fff; border-radius:12px; box-shadow:0 1px 3px rgba(0,0,0,.1); border:1px solid #e5e7eb; overflow:hidden; }
        .cal-header { display:flex; flex-wrap:wrap; align-items:center; justify-content:space-between; gap:12px; padding:16px; border-bottom:1px solid #e5e7eb; }
        .cal-nav { display:flex; align-items:center; gap:8px; }
        .cal-nav-btn { display:inline-flex; align-items:center; justify-content:center; width:36px; height:36px; border-radius:8px; border:1px solid #e5e7eb; background:#fff; cursor:pointer; transition:background .15s; }
        .cal-nav-btn:hover { background:#f9fafb; }
        .cal-nav-btn svg { width:16px; height:16px; }
        .cal-month { font-size:1.1rem; font-weight:600; color:#111827; text-transform:capitalize; margin-left:8px; }
        .cal-legend { display:flex; flex-wrap:wrap; align-items:center; gap:12px; font-size:.75rem; }
        .cal-legend-dot { width:10px; height:10px; border-radius:50%; display:inline-block; }
        .cal-legend-item { display:inline-flex; align-items:center; gap:6px; color:#6b7280; }
        .cal-weekdays { display:grid; grid-template-columns:repeat(7,1fr); border-bottom:1px solid #e5e7eb; background:#f9fafb; }
        .cal-weekday { padding:8px 4px; text-align:center; font-size:.7rem; font-weight:600; color:#9ca3af; text-transform:uppercase; letter-spacing:.05em; }
        .cal-grid { display:grid; grid-template-columns:repeat(7,1fr); }
        .cal-cell { min-height:110px; border-bottom:1px solid #f3f4f6; border-right:1px solid #f3f4f6; padding:6px; background:#fff; }
        .cal-cell--empty { background:#fafafa; }
        .cal-cell--weekend { background:#fafafa; }
        .cal-day-num { display:inline-flex; align-items:center; justify-content:center; width:24px; height:24px; border-radius:50%; font-size:.75rem; font-weight:600; color:#374151; margin-bottom:4px; }
        .cal-day-num--today { background:#1a7a4a; color:#fff; }
        .cal-day-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:4px; }
        .cal-day-count { font-size:.65rem; color:#9ca3af; font-weight:500; }
        .cal-events { display:flex; flex-direction:column; gap:3px; }
        .cal-event { display:block; padding:2px 6px; border-radius:4px; border:1px solid; font-size:.7rem; line-height:1.4; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; text-decoration:none; transition:opacity .15s; }
        .cal-event:hover { opacity:.75; }
        .cal-event strong { font-weight:600; }
        .cal-event small { opacity:.7; }
    </style>

    <div class="cal-wrap">
        {{-- Header --}}
        <div class="cal-header">
            <div class="cal-nav">
                <button type="button" wire:click="prevMonth" class="cal-nav-btn">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                </button>
                <button type="button" wire:click="nextMonth" class="cal-nav-btn">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </button>
                <span class="cal-month">{{ $monthLabel }}</span>
            </div>

            <div class="cal-legend">
                @foreach ($statusLabels as $key => $label)
                    <span class="cal-legend-item">
                        <span class="cal-legend-dot" style="background:{{ $statusDots[$key] }}"></span>
                        {{ $label }}
                    </span>
                @endforeach
            </div>
        </div>

        {{-- Weekday headers --}}
        <div class="cal-weekdays">
            @foreach ($weekdays as $wd)
                <div class="cal-weekday">{{ $wd }}</div>
            @endforeach
        </div>

        {{-- Days grid --}}
        <div class="cal-grid">
            @foreach ($days as $cell)
                @if ($cell === null)
                    <div class="cal-cell cal-cell--empty"></div>
                @else
                    <div class="cal-cell {{ $cell['is_weekend'] ? 'cal-cell--weekend' : '' }}">
                        <div class="cal-day-header">
                            <span class="cal-day-num {{ $cell['is_today'] ? 'cal-day-num--today' : '' }}">{{ $cell['day'] }}</span>
                            @if (count($cell['events']) > 0)
                                <span class="cal-day-count">{{ count($cell['events']) }}</span>
                            @endif
                        </div>
                        <div class="cal-events">
                            @foreach ($cell['events'] as $event)
                                @php $style = $statusStyles[$event->status] ?? $statusStyles['cancelled']; @endphp
                                <a href="{{ str_replace('/0/edit', '/' . $event->id . '/edit', $editRouteBase) }}"
                                    class="cal-event"
                                    style="{{ $style }}"
                                    title="{{ $event->reference }} - {{ $event->client_name }}{{ $event->client_company ? ' (' . $event->client_company . ')' : '' }} - {{ $statusLabels[$event->status] ?? $event->status }}">
                                    <strong>{{ $event->client_company ?: $event->client_name }}</strong>
                                    @if ($event->consultant)
                                        <small> · {{ $event->consultant->name }}</small>
                                    @endif
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
</x-filament-panels::page>
