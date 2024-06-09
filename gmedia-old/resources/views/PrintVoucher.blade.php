<!DOCTYPE html>
<html>
<head>
    <title>Cetak Voucher Hotspot</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        
        .voucher {
            width: 80mm;
            padding: 10px;
            border: 1px solid #000;
            text-align: center;
        }
        
        .logo {
            margin-bottom: 10px;
        }
        
        .title {
            font-size: 18px;
            margin-bottom: 10px;
        }
        
        .code {
            font-size: 18px;
            margin-bottom: 10px;
        }
        
        .expiry {
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="voucher">
        <div class="logo">
            <img src="{{ asset('template-dashboard') }}/assets/img/logo.png" alt="Logo" width="80">
        </div>
        <div class="title">Username : {{ $user['name']  ?? ''}}</div>
        <div class="code">Password : {{ $user['password'] ?? '' }}</div>
        <div class="expiry">{{ $user['profile'] ?? '' }} || {{ $user['limit-uptime'] ?? 'unlimited' }}</div>
    </div>
     <script type="text/javascript">
        window.print();
    </script>
</body>
</html>





