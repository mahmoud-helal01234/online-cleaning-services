@php
use App\Models\Region;

$regions = Region::all(); // Fetch all regions
@endphp

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
                <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="regionsDropdown" role="button" data-bs-toggle="dropdown">
                            @lang('page.regions')
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="regionsDropdown" style="z-index: 10503232;">
                            @foreach($regions as $region)
                            <li><a  class="region-item dropdown-item" href="#" data-value-ar="{{ $region->name_ar }}" data-value-en="{{ $region->name_en }}"> {{ app()->getLocale() == 'ar' ? $region->name_ar :  $region->name_en }}</a></li>
                            @endforeach
                        </ul>
                    </li>
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
<input type="hidden" id="selectedRegion" name="selectedRegion" value="">

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const dropdownItems = document.querySelectorAll('.region-item');
        const dropdownToggle = document.getElementById('regionsDropdown');
        const selectedRegionInput = document.getElementById('selectedRegion');

        // Get the current language from your backend
        const currentLang = "{{ app()->getLocale() }}";

        // Load saved region ID and language from localStorage
        const savedRegionId = localStorage.getItem('selectedRegionId');
        const savedRegionLang = localStorage.getItem('selectedRegionLang');

        // If a region is saved, display the correct name based on the current language
        if (savedRegionId) {
            dropdownItems.forEach(item => {
                if (item.dataset.valueAr === savedRegionId || item.dataset.valueEn === savedRegionId) {
                    const displayValue = currentLang === 'ar' 
                        ? item.getAttribute('data-value-ar') 
                        : item.getAttribute('data-value-en');
                    dropdownToggle.textContent = displayValue; // Set dropdown text
                    selectedRegionInput.value = savedRegionId; // Set hidden input value
                }
            });
        }

        // Attach click event listeners to dropdown items
        dropdownItems.forEach(item => {
            item.addEventListener('click', function (event) {
                event.preventDefault(); // Prevent default link behavior

                // Get the selected region ID and name based on the current language
                const selectedRegionId = currentLang === 'ar' 
                    ? this.getAttribute('data-value-ar') 
                    : this.getAttribute('data-value-en');
                const selectedRegionName = currentLang === 'ar'
                    ? this.getAttribute('data-value-ar')
                    : this.getAttribute('data-value-en');

                // Update the dropdown text and hidden input
                dropdownToggle.textContent = selectedRegionName;
                selectedRegionInput.value = selectedRegionId;

                // Save the selected region ID and language to localStorage
                localStorage.setItem('selectedRegionId', selectedRegionId);
                localStorage.setItem('selectedRegionLang', currentLang);
            });
        });
    });
</script>
