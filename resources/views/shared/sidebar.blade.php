<div class="sb-sidenav-menu-heading">Dashboard</div>
<nav class="sb-sidenav-menu-nested">
    <a class="nav-link" href="{{ route('dashboard.ministry') }}">
        <div class="sb-nav-link-icon"><i class="fas fa-list"></i></div>
        Służby
    </a>
</nav>
<nav class="sb-sidenav-menu-nested">
    <a class="nav-link" href="{{ route('dashboard.coworker') }}">
        <div class="sb-nav-link-icon"><i class="fas fa-list"></i></div>
        Współpracownicy
    </a>
</nav>
<nav class="sb-sidenav-menu-nested">
    <a class="nav-link" href="{{ route('dashboard.report') }}">
        <div class="sb-nav-link-icon"><i class="fas fa-list"></i></div>
        Sprawozdania
    </a>
</nav>
<div class="sb-sidenav-menu-heading">Służby</div>
<nav class="sb-sidenav-menu-nested">
    <a class="nav-link" href="{{ route('ministry.list') }}">
        <div class="sb-nav-link-icon"><i class="fas fa-list"></i></div>
        Lista
    </a>
    @if (!auth()->user()->googleAccounts->isEmpty())
        <a class="nav-link" href="{{ route('ministry.form.add') }}">
            <div class="sb-nav-link-icon"><i class="fas fa-plus"></i></div>
            Umów
        </a>
    @endif
</nav>

<div class="sb-sidenav-menu-heading">Współpracownicy</div>
<nav class="sb-sidenav-menu-nested">
    <a class="nav-link" href="{{ route('coworker.list') }}">
        <div class="sb-nav-link-icon"><i class="fas fa-list"></i></div>
        Lista
    </a>
    <a class="nav-link" href="{{ route('coworker.never') }}">
        <div class="sb-nav-link-icon"><i class="fas fa-list"></i></div>
        Ci co nigdy
    </a>
    <a class="nav-link" href="{{ route('coworker.add.form') }}">
        <div class="sb-nav-link-icon"><i class="fas fa-plus"></i></div>
        Dodaj
    </a>
</nav>

<div class="sb-sidenav-menu-heading">Zbory</div>
<nav class="sb-sidenav-menu-nested">
    <a class="nav-link" href="{{ route('congregation.list') }}">
        <div class="sb-nav-link-icon"><i class="fas fa-list"></i></div>
        Lista
    </a>

</nav>

<div class="sb-sidenav-menu-heading">Panel edytorski</div>
<a class="nav-link" href="{{ route('congregation.add.form') }}">
    <div class="sb-nav-link-icon"><i class="fas fa-plus"></i></div>
    Dodaj zbór
</a>
