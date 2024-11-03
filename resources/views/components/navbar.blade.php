<!-- Navigation-->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark text-white">
    <div class="container px-4 px-lg-7">
        <img src="{{ asset('images/pages/logo.png') }}" alt="Logo" class="logo" style="float: left;height:3rem;width:3rem">
        <a class="navbar-brand" href="#!">&nbsp; @lang('page.aquacare_laundry')</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                <!-- <li class="nav-item"><a class="nav-link active" aria-current="page" href="/">@lang('page.home')</a></li> -->
                <!-- <li class="nav-item"><a class="nav-link" href="/what-we-do">@lang('page.what_we_do')</a></li> -->
                <!-- <li class="nav-item"><a class="nav-link" href="#!">@lang('page.about')</a></li> -->
                <li class="nav-item"><a class="nav-link" href="tel:+971506689921"><i class="fa fa-phone" style="color:rgb(5, 145,229)"></i> <span dir="ltr">+971 506 689 921</span></a></li>
                <li class="nav-item"><a class="nav-link" href="https://wa.me/+971506689921"><i class="fa-brands fa-whatsapp" style="color:rgb(9, 217,9)"></i> <span dir="ltr">+971 506 689 921</span></a></li>
            </ul>
                      <!-- Language Switcher -->
                      <div class="btn-group ms-2">
                @if (app()->getLocale() == 'en')
                    <a href="{{ url('lang/ar') }}" class="btn btn-outline-light" style="border-radius: 20px; padding: 0.5rem 1rem;">
                        <i class="fa fa-language" ></i> اللغة العربية
                    </a>
                @else
                    <a href="{{ url('lang/en') }}" class="btn btn-outline-light" style="border-radius: 20px; padding: 0.5rem 1rem;">
                    <i class="fa fa-language" ></i> English
                    </a>
                @endif
            </div>
            <span>&nbsp;&nbsp;</span>


            <button class="btn btn-light btn-outline-white" data-bs-toggle="modal" data-bs-target="#cart-modal">
                <i class="bi-cart-fill me-1"></i> @lang('page.cart')
                <span class="badge bg-dark ms-1 rounded-pill" id="cart-size">0</span>
            </button>
        </div>
    </div>
</nav>