<!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav align-items-center">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button" aria-label="Buka atau tutup menu">
          <i class="fas fa-bars"></i>
        </a>
      </li>
      @if(!empty($title))
        <li class="nav-item d-none d-sm-inline-flex align-items-center">
          <span class="nav-link page-heading">{{ $title }}</span>
        </li>
      @endif
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto align-items-center">

      <li class="nav-item">
        <button type="button" id="themeToggle" class="nav-link btn btn-link theme-toggle"
                aria-label="Ganti tema" aria-pressed="false" title="Mode gelap">
          <i class="fas fa-moon" id="themeToggleIcon"></i>
        </button>
      </li>

      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button" aria-label="Layar penuh">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>

      <li class="nav-item">
        <form action="/logout" method="POST" class="m-0">
          @csrf
          <button type="submit" class="nav-link btn btn-link" title="Logout">
            <i class="fas fa-sign-out-alt"></i>
          </button>
        </form>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->
