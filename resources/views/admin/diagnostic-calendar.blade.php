<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendrier des diagnostics — {{ $monthLabel }}</title>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #f1f5f9;
            color: #1e293b;
            min-height: 100vh;
        }

        /* ── Header ── */
        .page-header {
            background: #fff;
            border-bottom: 1px solid #e2e8f0;
            padding: 14px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            flex-wrap: wrap;
            position: sticky;
            top: 0;
            z-index: 10;
            box-shadow: 0 1px 4px rgba(0,0,0,.06);
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .header-logo {
            width: 32px;
            height: 32px;
            background: #1a7a4a;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .header-logo svg { width: 18px; height: 18px; color: #fff; stroke: #fff; }

        .header-title {
            font-size: 1rem;
            font-weight: 700;
            color: #0f172a;
        }

        .header-sub {
            font-size: .8rem;
            color: #64748b;
            margin-top: 1px;
        }

        .nav-group {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 7px 14px;
            border-radius: 8px;
            font-size: .8rem;
            font-weight: 600;
            text-decoration: none;
            border: 1px solid transparent;
            cursor: pointer;
            transition: background .15s, border-color .15s;
            white-space: nowrap;
        }

        .btn svg { width: 15px; height: 15px; }

        .btn-ghost {
            background: #fff;
            border-color: #e2e8f0;
            color: #475569;
        }
        .btn-ghost:hover { background: #f8fafc; border-color: #cbd5e1; }

        .btn-primary {
            background: #1a7a4a;
            color: #fff;
        }
        .btn-primary:hover { background: #15623b; }

        .month-label {
            font-size: 1rem;
            font-weight: 700;
            color: #0f172a;
            text-transform: capitalize;
            min-width: 160px;
            text-align: center;
        }

        /* ── Legend ── */
        .legend {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            align-items: center;
            padding: 10px 24px;
            background: #fff;
            border-bottom: 1px solid #f1f5f9;
            font-size: .75rem;
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 6px;
            color: #64748b;
        }

        .legend-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            flex-shrink: 0;
        }

        /* ── Calendar wrapper ── */
        .cal-outer {
            padding: 20px 24px 40px;
            max-width: 1400px;
            margin: 0 auto;
        }

        .cal-card {
            background: #fff;
            border-radius: 14px;
            border: 1px solid #e2e8f0;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,.05);
        }

        /* ── Weekday row ── */
        .cal-weekdays {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            background: #f8fafc;
            border-bottom: 1px solid #e2e8f0;
        }

        .cal-weekday {
            padding: 10px 6px;
            text-align: center;
            font-size: .7rem;
            font-weight: 700;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: .06em;
        }

        .cal-weekday.weekend { color: #cbd5e1; }

        /* ── Days grid ── */
        .cal-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
        }

        .cal-cell {
            min-height: 120px;
            border-bottom: 1px solid #f1f5f9;
            border-right: 1px solid #f1f5f9;
            padding: 8px 6px 6px;
            background: #fff;
            vertical-align: top;
            transition: background .1s;
        }

        .cal-cell:nth-child(7n) { border-right: none; }

        .cal-cell--empty {
            background: #fafafa;
        }

        .cal-cell--weekend {
            background: #fdfcfb;
        }

        .cal-cell--today {
            background: #f0fdf4;
        }

        .cal-day-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 6px;
        }

        .cal-day-num {
            width: 26px;
            height: 26px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            font-size: .78rem;
            font-weight: 600;
            color: #475569;
        }

        .cal-day-num--today {
            background: #1a7a4a;
            color: #fff;
        }

        .cal-day-count {
            font-size: .65rem;
            font-weight: 600;
            color: #94a3b8;
            background: #f1f5f9;
            border-radius: 10px;
            padding: 1px 6px;
        }

        .cal-events {
            display: flex;
            flex-direction: column;
            gap: 3px;
        }

        .cal-event {
            display: block;
            padding: 3px 7px;
            border-radius: 5px;
            border-left: 3px solid;
            font-size: .7rem;
            line-height: 1.4;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            text-decoration: none;
            transition: opacity .15s, transform .1s;
        }

        .cal-event:hover {
            opacity: .85;
            transform: translateX(1px);
        }

        .cal-event strong { font-weight: 700; }
        .cal-event small  { opacity: .65; font-size: .68rem; }

        /* Add button */
        .cal-add-btn {
            display: none;
            align-items: center;
            justify-content: center;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: #e2e8f0;
            color: #475569;
            font-size: 15px;
            line-height: 1;
            text-decoration: none;
            flex-shrink: 0;
            transition: background .15s, color .15s;
        }
        .cal-add-btn:hover { background: #1a7a4a; color: #fff; }
        .cal-cell:hover .cal-add-btn { display: inline-flex; }

        /* Status colors */
        .status-requested   { background: #fffbeb; color: #92400e; border-color: #f59e0b; }
        .status-scheduled   { background: #eff6ff; color: #1d4ed8; border-color: #3b82f6; }
        .status-in_progress { background: #eef2ff; color: #3730a3; border-color: #6366f1; }
        .status-completed   { background: #f0fdf4; color: #065f46; border-color: #10b981; }
        .status-converted   { background: #f5f3ff; color: #5b21b6; border-color: #8b5cf6; }
        .status-cancelled   { background: #f8fafc; color: #64748b; border-color: #cbd5e1; }

        /* ── Print ── */
        @media print {
            .page-header { position: static; box-shadow: none; }
            .btn { display: none; }
            body { background: #fff; }
        }

        /* ── Responsive ── */
        @media (max-width: 768px) {
            .cal-outer { padding: 12px; }
            .cal-cell { min-height: 80px; padding: 4px 3px; }
            .cal-event { font-size: .62rem; }
            .month-label { min-width: auto; }
        }
    </style>
</head>
<body>

    {{-- Header --}}
    <div class="page-header">
        <div class="header-left">
            <div class="header-logo">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <div>
                <div class="header-title">Calendrier des diagnostics</div>
                <div class="header-sub">Vue mensuelle — Cabinet QHSE</div>
            </div>
        </div>

        <div class="nav-group">
            <a href="{{ route('admin.diagnostic-calendar', ['year' => $prev->year, 'month' => $prev->month]) }}"
               class="btn btn-ghost" target="_blank">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>

            <span class="month-label">{{ $monthLabel }}</span>

            <a href="{{ route('admin.diagnostic-calendar', ['year' => $next->year, 'month' => $next->month]) }}"
               class="btn btn-ghost" target="_blank">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                </svg>
            </a>

            <a href="{{ route('admin.diagnostic-calendar') }}" class="btn btn-ghost" target="_blank">
                Aujourd'hui
            </a>

            <a href="{{ route('filament.admin.resources.diagnostic-requests.index') }}" class="btn btn-primary" target="_blank">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                </svg>
                Vue liste
            </a>
        </div>
    </div>

    {{-- Legend --}}
    <div class="legend">
        <span style="font-size:.7rem;font-weight:600;color:#94a3b8;margin-right:4px;">STATUTS :</span>
        @foreach ([
            'requested'   => ['#f59e0b', 'Demandé'],
            'scheduled'   => ['#3b82f6', 'Planifié'],
            'in_progress' => ['#6366f1', 'En cours'],
            'completed'   => ['#10b981', 'Terminé'],
            'converted'   => ['#8b5cf6', 'Converti'],
            'cancelled'   => ['#cbd5e1', 'Annulé'],
        ] as $key => [$color, $label])
            <span class="legend-item">
                <span class="legend-dot" style="background:{{ $color }}"></span>
                {{ $label }}
            </span>
        @endforeach
    </div>

    {{-- Calendar --}}
    <div class="cal-outer">
        <div class="cal-card">
            {{-- Weekday headers --}}
            <div class="cal-weekdays">
                @foreach (['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'] as $i => $wd)
                    <div class="cal-weekday {{ $i >= 5 ? 'weekend' : '' }}">{{ $wd }}</div>
                @endforeach
            </div>

            {{-- Days grid --}}
            <div class="cal-grid">
                @foreach ($days as $cell)
                    @if ($cell === null)
                        <div class="cal-cell cal-cell--empty"></div>
                    @else
                        <div class="cal-cell
                            {{ $cell['is_today'] ? 'cal-cell--today' : '' }}
                            {{ $cell['is_weekend'] && !$cell['is_today'] ? 'cal-cell--weekend' : '' }}">

                            @php
                                $createUrl = route('filament.admin.resources.diagnostic-requests.create') . '?date=' . $cell['date'];
                            @endphp
                            <div class="cal-day-header">
                                <span class="cal-day-num {{ $cell['is_today'] ? 'cal-day-num--today' : '' }}">
                                    {{ $cell['day'] }}
                                </span>
                                <div style="display:flex;align-items:center;gap:6px;">
                                    @if (count($cell['events']) > 0)
                                        <span class="cal-day-count">{{ count($cell['events']) }}</span>
                                    @endif
                                    <a href="{{ $createUrl }}" target="_blank" class="cal-add-btn" title="Ajouter un diagnostic le {{ $cell['date'] }}">+</a>
                                </div>
                            </div>

                            <div class="cal-events">
                                @foreach ($cell['events'] as $event)
                                    @php
                                        $editUrl = route('filament.admin.resources.diagnostic-requests.edit', ['record' => $event->id]);
                                    @endphp
                                    <a href="{{ $editUrl }}"
                                       target="_blank"
                                       class="cal-event status-{{ $event->status }}"
                                       title="{{ $event->client_name }}{{ $event->client_company ? ' — ' . $event->client_company : '' }}">
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
    </div>

</body>
</html>
