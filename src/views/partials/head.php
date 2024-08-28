<html>
    <head>
        <title><?= null !== getenv('APP_NAME') ? getenv('APP_NAME') : 'TOTP';?></title>
        <link rel="stylesheet" href="assets/pico.min.css">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="color-scheme" content="light dark">

        <style>
        
        h1 {
            text-align: center;
            font-size: 3rem;
            margin-top: 1rem;
        }
        
        :root {
            --pico-form-element-spacing-vertical: 0.5rem;
            --pico-form-element-spacing-horizontal: 1rem;
        }
        
        .center {
            text-align: center;
        }

        .mb {
            margin-bottom: 1rem;
        }

        article {
            position: relative;
        }
        .float-end {
            position: absolute;
            top: 1rem;
            right: 1rem;

        }
    
        .progressbar {
            margin-top: 1rem;
            width: 100%;
            background-color: var(--pico-secondary-background);
        }
        .progressbar > div {
            height: 3px;
            background-color: var(--pico-primary-background);
        }
        
        </style>
    </head>
    <body>
        <div class="container">
            <h1><?=null !== getenv('APP_NAME') ? getenv('APP_NAME') : 'TOTP';?></h1>
