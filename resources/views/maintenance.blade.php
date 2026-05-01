<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Maintenance — {{ $settings->get('brand_name', 'Obsequium') }}</title>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --green: #1a7a4a;
            --green-light: #e8f5ee;
            --green-mid: #2d9e62;
            --gray-50: #f8fafc;
            --gray-100: #f1f5f9;
            --gray-400: #94a3b8;
            --gray-500: #64748b;
            --gray-700: #334155;
            --gray-900: #0f172a;
        }

        html, body {
            min-height: 100vh;
            font-family: ui-sans-serif, system-ui, -apple-system, sans-serif;
            background: var(--gray-50);
            color: var(--gray-700);
            -webkit-font-smoothing: antialiased;
        }

        body {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
            gap: 0;
        }

        .card {
            background: #fff;
            border-radius: 1.25rem;
            box-shadow: 0 4px 24px rgba(0,0,0,.07), 0 1px 4px rgba(0,0,0,.04);
            padding: 3rem 2.5rem;
            max-width: 520px;
            width: 100%;
            text-align: center;
        }

        .logo-wrap {
            width: 80px;
            height: 80px;
            margin: 0 auto 1.75rem;
        }

        .logo-wrap img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            background: var(--green-light);
            color: var(--green);
            font-size: .75rem;
            font-weight: 600;
            letter-spacing: .05em;
            text-transform: uppercase;
            padding: .35rem .85rem;
            border-radius: 99px;
            margin-bottom: 1.25rem;
        }

        .badge svg {
            width: 14px;
            height: 14px;
            flex-shrink: 0;
        }

        h1 {
            font-size: 1.65rem;
            font-weight: 700;
            color: var(--gray-900);
            line-height: 1.2;
            margin-bottom: .75rem;
        }

        .message {
            font-size: 1rem;
            color: var(--gray-500);
            line-height: 1.65;
            margin-bottom: 2rem;
        }

        .divider {
            height: 1px;
            background: var(--gray-100);
            margin: 0 0 1.5rem;
        }

        .contact-row {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: .5rem;
            font-size: .9rem;
            color: var(--gray-500);
        }

        .contact-row a {
            color: var(--green);
            text-decoration: none;
            font-weight: 500;
        }

        .contact-row a:hover { text-decoration: underline; }

        .contact-row svg {
            width: 16px;
            height: 16px;
            color: var(--gray-400);
            flex-shrink: 0;
        }

        .progress {
            width: 120px;
            height: 3px;
            background: var(--gray-100);
            border-radius: 99px;
            margin: 2rem auto 0;
            overflow: hidden;
        }

        .progress-bar {
            height: 100%;
            width: 40%;
            background: linear-gradient(90deg, var(--green), var(--green-mid));
            border-radius: 99px;
            animation: slide 2s ease-in-out infinite alternate;
        }

        @keyframes slide {
            from { transform: translateX(-60px); }
            to   { transform: translateX(100px); }
        }

        footer {
            margin-top: 2rem;
            font-size: .75rem;
            color: var(--gray-400);
        }

        @media (max-width: 480px) {
            .card { padding: 2rem 1.5rem; }
            h1 { font-size: 1.4rem; }
        }
    </style>
</head>
<body>

    <div class="card">

        <div class="logo-wrap">
            <img src="/logos/Obsequium vert.png" alt="{{ $settings->get('brand_name', 'Obsequium') }}">
        </div>

        <div class="badge">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17L17.25 21A2.652 2.652 0 0021 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 11-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 004.486-6.336l-3.276 3.277a3.004 3.004 0 01-2.25-2.25l3.276-3.276a4.5 4.5 0 00-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085m-1.745 1.437L5.909 7.5H4.5L2.25 3.75l1.5-1.5L7.5 4.5v1.409l4.26 4.26m-1.745 1.437l1.745-1.437m6.615 8.206L15.75 15.75M4.867 19.125h.008v.008h-.008v-.008z"/>
            </svg>
            Maintenance en cours
        </div>

        <h1>Nous revenons très bientôt</h1>

        <p class="message">
            {{ $message }}
        </p>

        @if($settings->get('contact_email'))
            <div class="divider"></div>
            <div class="contact-row">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/>
                </svg>
                Besoin d'aide ?
                <a href="mailto:{{ $settings->get('contact_email') }}">{{ $settings->get('contact_email') }}</a>
            </div>
        @endif

        <div class="progress"><div class="progress-bar"></div></div>
    </div>

    <footer>
        © {{ date('Y') }} {{ $settings->get('brand_name', 'Obsequium') }} — Tous droits réservés
    </footer>

</body>
</html>
