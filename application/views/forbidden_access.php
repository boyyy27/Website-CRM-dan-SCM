<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Access Denied</title>
    <style>
        body {
            background: #23272f;
            min-height: 100vh;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .forbidden-card {
            background: #fff;
            border-radius: 18px;
            box-shadow: 0 8px 32px rgba(231, 76, 60, 0.18), 0 1.5px 8px rgba(44,62,80,0.08);
            max-width: 400px;
            width: 100%;
            padding: 36px 32px 28px 32px;
            text-align: center;
            position: relative;
        }
        .forbidden-card .header {
            background: linear-gradient(135deg, #ff416c 0%, #ff4757 100%);
            color: #fff;
            border-radius: 12px 12px 0 0;
            padding: 18px 0 12px 0;
            font-size: 1.5rem;
            font-weight: 700;
            margin: -36px -32px 24px -32px;
            box-shadow: 0 2px 8px rgba(231, 76, 60, 0.08);
        }
        .forbidden-card p {
            color: #2c3e50;
            font-size: 1.08rem;
            margin-bottom: 32px;
        }
        .forbidden-card .btn-back {
            background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 12px 32px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            box-shadow: 0 2px 8px rgba(231, 76, 60, 0.12);
            transition: background 0.2s, transform 0.2s;
        }
        .forbidden-card .btn-back:hover {
            background: linear-gradient(135deg, #c0392b 0%, #a93226 100%);
            transform: translateY(-2px) scale(1.04);
        }
        @media (max-width: 500px) {
            .forbidden-card {
                padding: 24px 8px 18px 8px;
                max-width: 95vw;
            }
            .forbidden-card .header {
                font-size: 1.1rem;
                padding: 12px 0 8px 0;
                margin: -24px -8px 18px -8px;
            }
        }
    </style>
</head>
<body>
    <div class="forbidden-card">
        <div class="header">Access Denied</div>
        <p>You do not have access to this page. Please go back to the previous page or return to the homepage.</p>
        <button class="btn-back" onclick="window.location.href='<?= base_url('index.php/Welcome/landing') ?>'">Back to Home</button>
    </div>
</body>
</html> 