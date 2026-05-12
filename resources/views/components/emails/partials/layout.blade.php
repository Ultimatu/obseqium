<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>{{ $subject ?? config('app.name') }}</title>
<style>
  body{font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;background:#f8fafc;margin:0;padding:0;color:#1e293b}
  .wrapper{max-width:600px;margin:40px auto;background:#fff;border-radius:12px;overflow:hidden;box-shadow:0 1px 3px rgba(0,0,0,.08)}
  .header{background:{{ $headerColor ?? '#7c9131' }};padding:28px 40px}
  .header h1{color:#fff;margin:0;font-size:20px;font-weight:700}
  .header p{color:{{ $headerSubColor ?? '#e4edc5' }};margin:4px 0 0;font-size:13px}
  .body{padding:36px 40px}
  .body p{line-height:1.7;color:#475569;margin:0 0 14px;font-size:14px}
  .meta{background:#f1f5f9;border-radius:8px;padding:18px 22px;margin:22px 0}
  .meta table{width:100%;border-collapse:collapse}
  .meta td{padding:5px 0;font-size:13px;color:#475569}
  .meta td:first-child{font-weight:600;color:#1e293b;width:38%}
  .btn{display:inline-block;background:{{ $btnColor ?? '#7c9131' }};color:#fff!important;text-decoration:none;padding:13px 28px;border-radius:8px;font-weight:600;font-size:14px;margin:8px 0}
  .alert{padding:12px 16px;border-radius:6px;font-size:13px;margin:16px 0}
  .alert-info{background:#eff6ff;border-left:3px solid #3b82f6;color:#1e40af}
  .alert-warning{background:#fffbeb;border-left:3px solid #f59e0b;color:#92400e}
  .footer{padding:20px 40px;border-top:1px solid #e2e8f0;text-align:center}
  .footer p{font-size:11px;color:#94a3b8;margin:0}
</style>
</head>
<body>
<div class="wrapper">
  <div class="header">
    <h1>{{ config('app.name') }}</h1>
    <p>Conseil & Formation QHSE</p>
  </div>
  <div class="body">
    {{ $slot }}
  </div>
  <div class="footer">
    <p>{{ config('app.name') }} · {{ config('mail.from.address') }}</p>
  </div>
</div>
</body>
</html>
