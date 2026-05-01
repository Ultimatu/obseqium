<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $code }} — {{ $title }}</title>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --green: #1a7a4a;
            --green-light: #e8f5ee;
            --gray-50: #f8fafc;
            --gray-100: #f1f5f9;
            --gray-300: #cbd5e1;
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
            min-height: 100vh;
        }

        header {
            padding: 1.25rem 2rem;
            background: #fff;
            border-bottom: 1px solid var(--gray-100);
        }

        .brand {
            display: inline-flex;
            align-items: center;
            gap: .75rem;
            text-decoration: none;
        }

        .brand-logo {
            width: 36px;
            height: 36px;
            object-fit: contain;
        }

        .brand-name {
            font-size: 1rem;
            font-weight: 700;
            color: var(--green);
            line-height: 1;
        }

        main {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 3rem 1.5rem;
        }

        .card {
            max-width: 540px;
            width: 100%;
            text-align: center;
        }

        .code-badge {
            display: inline-block;
            font-size: 5rem;
            font-weight: 800;
            line-height: 1;
            color: var(--green);
            letter-spacing: -.04em;
            margin-bottom: .5rem;
        }

        .icon-wrap {
            width: 72px;
            height: 72px;
            border-radius: 1.25rem;
            background: var(--green-light);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
        }

        .icon-wrap svg {
            width: 36px;
            height: 36px;
            color: var(--green);
        }

        h1 {
            font-size: 1.6rem;
            font-weight: 700;
            color: var(--gray-900);
            margin-bottom: .65rem;
            line-height: 1.25;
        }

        p {
            font-size: 1rem;
            color: var(--gray-500);
            line-height: 1.65;
            max-width: 420px;
            margin: 0 auto 2rem;
        }

        .actions {
            display: flex;
            flex-wrap: wrap;
            gap: .75rem;
            justify-content: center;
        }

        .btn-primary {
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            background: var(--green);
            color: #fff;
            font-size: .9rem;
            font-weight: 600;
            padding: .65rem 1.4rem;
            border-radius: .6rem;
            text-decoration: none;
            transition: opacity .15s;
        }

        .btn-primary:hover { opacity: .88; }

        .btn-secondary {
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            background: #fff;
            color: var(--gray-700);
            font-size: .9rem;
            font-weight: 500;
            padding: .65rem 1.4rem;
            border-radius: .6rem;
            border: 1px solid var(--gray-300);
            text-decoration: none;
            transition: border-color .15s, color .15s;
        }

        .btn-secondary:hover { border-color: var(--green); color: var(--green); }

        .btn-primary svg, .btn-secondary svg { width: 16px; height: 16px; }

        footer {
            padding: 1.25rem 2rem;
            text-align: center;
            font-size: .78rem;
            color: var(--gray-400);
            border-top: 1px solid var(--gray-100);
            background: #fff;
        }

        @media (max-width: 480px) {
            .code-badge { font-size: 4rem; }
            h1 { font-size: 1.35rem; }
            .actions { flex-direction: column; align-items: center; }
        }
    </style>
</head>
<body>

<header>
    <a href="/" class="brand">
        <img class="brand-logo" src="/logos/Obsequium vert.png" alt="Obsequium">
        <span class="brand-name">Obsequium</span>
    </a>
</header>

<main>
    <div class="card">
        <div class="icon-wrap">{{ $icon }}</div>
        <div class="code-badge">{{ $code }}</div>
        <h1>{{ $title }}</h1>
        <p>{{ $description }}</p>
        <div class="actions">{{ $actions }}</div>
    </div>
</main>

<footer>
    © {{ date('Y') }} Obsequium — Tous droits réservés
</footer>

</body>
</html>
