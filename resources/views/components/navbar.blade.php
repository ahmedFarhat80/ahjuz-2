<!-- Toggle button -->
<button class="navbar-toggler" type="button" data-mdb-toggle="collapse"
    data-mdb-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
    aria-label="Toggle navigation">
    <i class="fas fa-bars"></i>
</button>

<!-- Collapsible wrapper -->
<div class="collapse navbar-collapse" id="navbarSupportedContent">
    <!-- Navbar brand -->
    <a class="navbar-brand mt-2 mt-lg-0" href="/">
        <img src="{{ asset('frontend/img/logo.png') }}" height="60" />
    </a>
    <!-- Left links -->
    <ul class="navbar-nav me-auto ms-auto mb-2 mb-lg-0 pe-0 ps-0">
        <li class="nav-item me-4">
            <a class="nav-link" aria-current="page" href="/" {{ $attributes->merge(['style' => 'color:rgba(0, 0, 0, 0.55)']) }}> الرئيسية </a>
        </li>
        <li class="nav-item me-4">
            <a class="nav-link" href="{{ route('search') }}" {{ $attributes->merge(['style' => 'color:rgba(0, 0, 0, 0.55)']) }}> الوحدات </a>
        </li>
        <li class="nav-item me-4">
            <a class="nav-link" href="{{ route('about-us') }}" {{ $attributes->merge(['style' => 'color:rgba(0, 0, 0, 0.55)']) }}> نبذة عنا </a>
        </li>
        <li class="nav-item me-4">
            <a class="nav-link" href="{{ route('owner.properties.create') }}" {{ $attributes->merge(['style' => 'color:rgba(0, 0, 0, 0.55)']) }}> أضف وحدة </a>
        </li>
        <li class="nav-item me-4">
            <a class="nav-link" href="{{ route('contact-us') }}" {{ $attributes->merge(['style' => 'color:rgba(0, 0, 0, 0.55)']) }}> اتصل بنا </a>
        </li>
    </ul>
    <!-- Left links -->
</div>
<!-- Collapsible wrapper -->