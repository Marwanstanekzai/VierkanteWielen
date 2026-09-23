<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Fout - Sneakerness Rotterdam</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            background-color: #0d0e12;
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 20px;
        }

        .error-wrapper {
            max-width: 520px;
            width: 100%;
            text-align: center;
        }

        .brand-header {
            margin-bottom: 30px;
        }

        .brand-title {
            font-size: 24px;
            font-weight: 900;
            letter-spacing: 2px;
            color: #ffffff;
            text-transform: uppercase;
        }

        .brand-subtitle {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 3px;
            color: #ff3b30;
            display: block;
            margin-top: 4px;
        }

        .error-card {
            background-color: #16181e;
            border: 1px solid #ff3b30;
            border-radius: 16px;
            padding: 40px 30px;
            box-shadow: 0 20px 40px rgba(255, 59, 48, 0.15);
        }

        .error-icon {
            font-size: 54px;
            margin-bottom: 20px;
            display: inline-block;
            line-height: 1;
        }

        .error-heading {
            font-size: 20px;
            font-weight: 700;
            color: #ff3b30;
            margin-bottom: 12px;
        }

        .error-message {
            font-size: 15px;
            color: #a0a5b5;
            line-height: 1.6;
        }

        .error-footer {
            margin-top: 30px;
            font-size: 12px;
            color: #505565;
        }
    </style>
</head>
<body>
    <div class="error-wrapper">
        <div class="brand-header">
            <span class="brand-title">SNEAKERNESS</span>
            <span class="brand-subtitle">ROTTERDAM</span>
        </div>

        <div class="error-card">
            <div class="error-icon">⚠️</div>
            <h1 class="error-heading">Database Verbindingsfout</h1>
            <p class="error-message">
                Er is een probleem opgetreden bij het verbinden met de database.<br>
                Probeer het later opnieuw.
            </p>
        </div>

        <div class="error-footer">
            <p>&copy; Sneakerness Rotterdam - VierkanteWielen</p>
        </div>
    </div>
</body>
</html>
