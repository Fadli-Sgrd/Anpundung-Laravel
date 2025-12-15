<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ isset($title) ? $title . ' - ANPUNDUNG' : 'ANPUNDUNG' }}</title>
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background-color: #f8f9fa;
            color: #333;
        }

        html, body {
            height: 100%;
        }

        #app {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        main {
            flex: 1;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        @media (max-width: 768px) {
            main {
                padding: 15px;
            }
        }
    </style>
</head>
<body>
    <div id="app">
        <x-navbar />
        
        <main>
            <div class="container">
                {{ $slot }}
            </div>
        </main>
        
        <x-footer />
    </div>
</body>
</html>
