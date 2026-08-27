<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="refresh" content="0;url={{ auth()->check() ? url('/') : route('login') }}">
    <script>
        window.location.replace("{{ auth()->check() ? url('/') : route('login') }}");
    </script>
</head>
<body></body>
</html>
