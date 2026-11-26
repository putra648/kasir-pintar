<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ isset($title) ? $title . ' · Kasir Pintar' : 'Kasir Pintar · Sistem POS' }}</title>

  <script>
    (function () {
      try {
        if (localStorage.getItem('kp-theme') === 'dark') {
          document.documentElement.classList.add('dark');
        }
      } catch (e) { /* storage unavailable */ }
    })();
  </script>

  <meta name="theme-color" content="#4f46e5" id="metaThemeColor">

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap">

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="/vendor/admin/plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="/vendor/admin/dist/css/adminlte.min.css">
  <!-- Kasir Pintar theme (must load after AdminLTE) -->
  <link rel="stylesheet" href="/assets/css/theme.css">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
