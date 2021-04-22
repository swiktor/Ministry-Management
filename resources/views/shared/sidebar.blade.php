<div class="sb-sidenav-menu-heading">Dashboard</div>
<nav class="sb-sidenav-menu-nested">
    <a class="nav-link" href="{{route('ministry.dashboard')}}">
        <div class="sb-nav-link-icon"><i class="fas fa-list"></i></div>
        Służby
    </a>
</nav>

<div class="sb-sidenav-menu-heading">Służby</div>
<nav class="sb-sidenav-menu-nested">
    <a class="nav-link" href="{{route('ministry.list')}}">
        <div class="sb-nav-link-icon"><i class="fas fa-list"></i></div>
        Lista
    </a>
    <a class="nav-link" href="{{route('ministry.add')}}">
        <div class="sb-nav-link-icon"><i class="fas fa-plus"></i></div>
        Umów
    </a>
</nav>

<div class="sb-sidenav-menu-heading">Współpracownicy</div>
<nav class="sb-sidenav-menu-nested">
    <a class="nav-link" href="{{route('coworker.list')}}">
        <div class="sb-nav-link-icon"><i class="fas fa-list"></i></div>
        Lista
    </a>
    <a class="nav-link" href="{{route('coworker.never')}}">
        <div class="sb-nav-link-icon"><i class="fas fa-list"></i></div>
        Ci co nigdy
    </a>
    <a class="nav-link" href="{{route('coworker.add')}}">
        <div class="sb-nav-link-icon"><i class="fas fa-plus"></i></div>
        Dodaj
    </a>
</nav>

<div class="sb-sidenav-menu-heading">Sprawozdania</div>
<nav class="sb-sidenav-menu-nested">
    <a class="nav-link" href="{{route('report.list')}}">
        <div class="sb-nav-link-icon"><i class="fas fa-list"></i></div>
        Lista
    </a>
</nav>