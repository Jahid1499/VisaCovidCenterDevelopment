{{-- Navbar Starts  --}}
<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-white">
        <div class="container">
            <a class="navbar-brand" target="_blank" href="{{ route('frontend.index') }}">
                <img src="{{ asset(get_static_option('logo') ?? 'assets/center-part/image/logo.png') }}" alt="" class="header__logo">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('administrator.trustedMedicalAssistant.index') }}">Trusted Medical Assistants</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('administrator.registered.pcr') }}">Registered</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('administrator.premiumRegistered.pcr') }}">Premium Registered</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('administrator.price.index') }}">Pricing</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('administrator.regular.index') }}">Regular</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('administrator.premium.index') }}">Premium</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('administrator.centerVaccine.index') }}">Vaccine Name</a>
                    </li>
                </ul>
                <ul class="navbar-nav me-0 mb-2 mb-lg-0" style="line-height: 40px; height: 60px;">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle profile" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="profile__name">{{ Auth::user()->name }}</span>
                            <img class="profile__image" src="{{ asset(Auth::user()->image ?? get_static_option('no_image')) }}" alt="">
                            <br> <span class="text-capitalize profile__designation">{{ Auth::user()->user_type }}</span>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="{{ route('administrator.profile') }}">Profile</a></li>
                            <li><a class="dropdown-item" href="{{ route('administrator.centerModify') }}">Center Modify</a></li>
                           
                            <li><a class="dropdown-item logout-btn" href="#">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>
{{-- Navbar Ends  --}}
