<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="robots" content="noindex, nofollow">
    <title>@yield('title', 'Admin Dashboard')</title>

    <link rel="icon" href="/modules/images/uploads/2025/08/16/68a0b857dbb20_favicon-beelike.png" type="image/x-icon">
    
    <!-- Plugins from old theme -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/dataTables.bootstrap4.min.css') }}">
    
    <!-- New theme CSS -->
    <link rel="stylesheet" href="https://cdn.hassbase.com/plugins/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.7.12/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/simple-notify@1.0.4/dist/simple-notify.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>        
    <link rel="stylesheet" href="/cmsbvq/template/frontend/fonts/inter/inter.css" id="main-font-link" />
    <link rel="stylesheet" href="/cmsbvq/template/frontend/fonts/phosphor/duotone/style.css" />
    <link rel="stylesheet" href="/cmsbvq/template/frontend/fonts/tabler-icons.min.css" />
    <link rel="stylesheet" href="/cmsbvq/template/frontend/fonts/feather.css" />
    <link rel="stylesheet" href="/cmsbvq/template/frontend/fonts/fontawesome.css" />
    <link rel="stylesheet" href="/cmsbvq/template/frontend/fonts/material.css" />
    <link rel="stylesheet" href="/cmsbvq/template/frontend/css/style.css" id="main-style-link" />
    <link rel="stylesheet" href="/cmsbvq/template/frontend/css/style-preset.css" />
    <link rel="stylesheet" href="/cmsbvq/template/frontend/css/custom.css" />
    


    @stack('css')
    @yield('head')
</head>
