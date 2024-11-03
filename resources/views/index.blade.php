<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1, shrink-to-fit=no , initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta name="description" content />
    <meta name="author" content />
    <title>@lang('page.aquacare_laundry')</title>

    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="{{asset('images/pages/logo.png')}}" />
    <!-- Bootstrap icons-->

    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <x-shared-styles />
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

</head>

<body>
    <!-- Navigation-->
    <x-navbar />
    <x-cart />
    <x-floating-icons />
    <!-- Start of Carousel -->
    <div id="carouselExampleCaptions" class="carousel slide"
        data-bs-ride="carousel" data-bs-interval="5000">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleCaptions"
                data-bs-slide-to="0" class="active" aria-current="true"
                aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions"
                data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions"
                data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">

            <div class="carousel-item active">
                <img
                    src="{{ asset('images/pages/slider_2.jpeg') }}"
                    class="d-block w-100" alt="...">
                <div class="carousel-caption">
                    <h5>@lang('page.slider1_header')</h5>
                    <p>@lang('page.slider1_body')</p>

                    <div class="cta">
                        <a href="#categories-section" type="button" class="btn btn-primary">@lang('page.slider_button')</a>
                    </div>
                </div>
            </div>

            <div class="carousel-item">
                <img
                    src="{{ asset('images/pages/slider_4.jpeg') }}"
                    class="d-block w-100" alt="...">
                <div class="carousel-caption d-none-block">
                    <h5 class="text-xxl">@lang('page.slider2_header')</h5>
                    <p>@lang('page.slider2_body')</p>

                    <div class="cta">
                        <a href="#categories-section" type="button" class="btn btn-primary">@lang('page.slider_button')</a>
                    </div>
                </div>
            </div>

            <div class="carousel-item">
                <img
                    src="{{ asset('images/pages/slider_3.jpeg') }}"
                    class="d-block w-100" alt="...">
                <div class="carousel-caption d-md-block">
                    <h5>@lang('page.slider3_header')</h5>
                    <p>@lang('page.slider3_body')</p>

                    <div class="cta">
                        <a href="#categories-section" type="button" class="btn btn-primary">@lang('page.slider_button')</a>
                    </div>
                </div>
            </div>
            
                
        </div>

        <div class="carousel-control">
            <button class="carousel-control-prev" type="button"
                data-bs-target="#carouselExampleCaptions"
                data-bs-slide="prev">
                <span class="carousel-control-prev-icon"
                    aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button"
                data-bs-target="#carouselExampleCaptions"
                data-bs-slide="next">
                <span class="carousel-control-next-icon"
                    aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>

    <section class="services bg-dark py-5" id="services">
        <div class="container">
            <div class="row justify-content-center">

                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="service-box text-center content-block h-100">
                        <div class="box-bg grad-style-ab"></div>
                        <i class="fas fa-couch fa-3x"></i> <!-- Font Awesome icon -->
                        <h5 class="text-center">@lang('page.clothing_cleaning.title')</h5>
                        <p>@lang('page.clothing_cleaning.description')</p>
                    </div>
                    <!-- End of .service-box -->
                </div>

                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="service-box text-center content-block h-100">
                        <div class="box-bg grad-style-ab"></div>
                        <i class="fas fa-broom fa-3x"></i> <!-- Font Awesome icon -->
                        <h5 class="text-center">@lang('page.sofa_cleaning.title')</h5>
                        <p>@lang('page.sofa_cleaning.description')</p>
                    </div>
                    <!-- End of .service-box -->
                </div>

                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="service-box text-center content-block h-100">
                        <div class="box-bg grad-style-ab"></div>
                        <i class="fas fa-water fa-3x"></i> <!-- Font Awesome icon -->
                        <h5 class="text-center">@lang('page.carpet_cleaning.title')</h5>
                        <p>@lang('page.carpet_cleaning.description')</p>
                    </div>
                    <!-- End of .service-box -->
                </div>

            </div>
            <!-- End of .row -->
        </div>
        <!-- End of .container -->
    </section>




    <!-- Header-->
    <div class="content-container bg-dark py-6">
        <img
            src="{{ asset('images/pages/laundry2.webp') }}"
            alt="Responsive Image" class="responsive-image">
        <div class="text-content text-white">
            <h1>@lang('page.aquacare_laundry')</h1>
            <p>@lang("page.home.section2_body")

            </p>
            <div class="row">




            </div>
            <div class="row text-center text-dark">
                <div class="col">
                    <div class="counter ">
                        <i class="fa fa-calendar-alt fa-2x"></i>
                        <h2 class="timer count-title count-number" data-to="7" data-speed="1500"></h2>
                        <p class="count-text ">@lang('page.years_experience')</p>
                    </div>
                </div>
                <div class="col">
                    <div class="counter">
                        <i class="fa fa-shirt fa-2x"></i>
                        <h2 class="timer count-title count-number" data-to="76652" data-speed="1500"></h2>
                        <p class="count-text ">@lang('page.garments_cleaned')</p>
                    </div>
                </div>
                <div class="col">
                    <div class="counter">
                        <i class="fa fa-person fa-2x"></i>
                        <h2 class="timer count-title count-number" data-to="3508" data-speed="1500"></h2>
                        <p class="count-text ">@lang('page.happy_customers')</p>
                    </div>
                </div>
                <div class="col">
                    <div class="counter">
                        <i class="fa fa-car fa-2x"></i>
                        <h2 class="timer count-title count-number" data-to="21019" data-speed="1500"></h2>
                        <p class="count-text ">@lang('page.quick_turnaround')</p>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <!-- Modal -->
    <div class="modal fade" id="product-modal" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="product-modal-name"></h5>
                    <button type="button" class="btn-close"
                        data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card">
                        <!-- Image -->
                        <img
                            id="product-modal-img"
                            src="https://i.ibb.co/44nyd6r/Isolated-black-t-shirt-opened.jpg"
                            class="card-img-top" alt="Product Image">

                        <!-- Product Info -->
                        <div class="card-body text-center"
                            id="product-options">

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">@lang('page.close')</button>
                    <button type="button" class="btn btn-primary"
                        onclick="addToCart()" data-bs-dismiss="modal">@lang('page.add_to_cart')</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Section-->
    <section class="py-5 bg-white" id="categories-section">
        <div class="container px-4 px-lg-5 mt-5">
        <h2 class="text-center mb-4">@lang('page.categories')</h2>

            <div class="btn-toolbar btn-toolbar-categories" role="toolbar"
                aria-label="Toolbar with button groups">
                <div class="btn-group-categories me-2" role="group"
                    aria-label="First group" id="categories">

                </div>

            </div>


            <br>
            <div
                id="products"
                class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">

            </div>
        </div>
        <!-- Contact us section -->
        <div id="contact-us" class="content-container bg-white"
            style="padding: 0;margin: 0;">
            <iframe
                id="map"
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3606.978533108389!2d55.375070699999995!3d25.304925299999997!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3e5f5d163c580903%3A0x3f16fb9be6f008f3!2sAl%20Ragwah%20Al%20Naqiyah%20Laundry!5e0!3m2!1sar!2seg!4v1728949849801!5m2!1sar!2seg"
                style="border:0;" allowfullscreen
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"></iframe>
            <div class="text-content text-dark text-center">
                <h3
                    class=" italic">"@lang('page.contact_us_slogan')"</h3>
                <br><br>

                <h4 > <a href="tel:+971506689921"><i
                            class="contact-us-icon fa fa-phone "
                            style="color:rgb(5, 145,229)"
                            aria-hidden="true"></i>
                    </a> <span dir="ltr"> +971 506 689 921</span></h4>

                <h4><a href="https://wa.me/+971506689921"> <i
                            class="contact-us-icon fa fa-brands fa-whatsapp "
                            style="color:rgb(9, 217,9)"
                            aria-hidden="true"></i></a>
                            <span dir="ltr">  +971 506 689 921</span></h4>

                <h4> <i class="contact-us-icon fa fa-clock"
                        aria-hidden="true"></i>
                    @lang('page.working_hours')</h4>

            </div>
        </div>
    </section>

    <!-- Remove the container if you want to extend the Footer to full width. -->

    <footer class="text-white text-center text-lg-start bg-dark">

        <!-- Grid container -->
        <div class="container p-4">
            <!--Grid row-->
            <div class="row mt-4">
                <!--Grid column-->
                <div class="col-lg-4 col-md-12 mb-4 mb-md-0">
                    <h5 class="text-uppercase mb-4">@lang('page.about_company')</h5>

                    <p>
                        @lang('page.about_company_body')
                    </p>

                    <div class="mt-4">
                        <a href="tel:+971506689921" type="button" class="btn btn-floating btn-primary btn-lg"><i class="fa fa-phone"></i></a>
                        <a href="https://wa.me/+971506689921" type="button" class="btn btn-floating btn-primary btn-lg"><i class="fab fa-brands fa-whatsapp"></i></a>

                    <!-- Facebook -->
                        <!-- <a type="button" class="btn btn-floating btn-primary btn-lg"><i class="fab fa-facebook-f"></i></a> -->
                        <!-- Dribbble -->
                        <!-- <a type="button" class="btn btn-floating btn-primary btn-lg"><i class="fab fa-dribbble"></i></a> -->
                        <!-- Twitter -->
                        <!-- <a type="button" class="btn btn-floating btn-primary btn-lg"><i class="fab fa-twitter"></i></a> -->
                        <!-- Google + -->
                        <a href="mailto:support@aquacare-laundry.com"type="button" class="btn btn-floating btn-primary btn-lg"><i class="fa fa-envelope"></i></a>
                        <!-- Linkedin -->
                    </div>
                </div>
                <!--Grid column-->

                <!--Grid column-->
                <div class="col-lg-4 col-md-6 mb-4 mb-md-0">
                    <h5 class="text-uppercase mb-4">@lang('page.contacts')</h5>

                    <ul class="fa-ul" style="margin-left: 1.65em;">
                        <li class="mb-3">
                        <a href="https://maps.app.goo.gl/6G7vtwaT49Ta2kNQ7" target="_blank" style="text-decoration: none;">

                            <span class="fa-li"><i class="fas fa-home"></i></span><span class="ms-2">@lang('page.laundry_address')</span>
                        </a>
                        </li>
                        <li class="mb-3">
                        <a href="mailto:support@aquacare-laundry.com" target="_blank" style="text-decoration: none;">

                            <span class="fa-li"><i class="fas fa-envelope"></i></span><span class="ms-2">support@aquacare-laundry.com</span>
                        </a>
                        </li>
                        <li class="mb-3">
                            <a href="tel:+971506689921" style="text-decoration: none;">
                                <span class="fa-li"><i class="fas fa-phone"></i>
                            
                            </span><span dir="ltr" class="ms-2">+971 506 689 921</span>
                            </a>
                        </li>
                        <li class="mb-3">
                            <a href="https://wa.me/+971506689921" style="text-decoration: none;">
                                <span class="fa-li">
                                    <i style="color:rgb(9, 217,9)" class="fa-brands fa-whatsapp"></i></span>
                            
                            <span dir="ltr" class="ms-2">+971 506 689 921</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <!--Grid column-->

                <!--Grid column-->
                <div class="col-lg-4 col-md-6 mb-4 mb-md-0">
                    <h5 class="text-uppercase text-center mb-4">@lang('page.opening_hours')</h5>

                    <table class="table text-center text-white">
                        <tbody class="font-weight-normal">
                            <tr>

                                <td> <i class="fa fa-clock"></i> @lang('page.monday_to_sunday') @lang('page.24_hours') </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!--Grid column-->
            </div>
            <!--Grid row-->
        </div>
        <!-- Grid container -->

        <!-- Copyright -->
        <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
            © Copyright:
            <a class="text-white" href="https://onlysmart.net/" target="_blank">onlysmart.net</a>
        </div>
        <!-- Copyright -->
    </footer>

    <!-- End of .container -->
    <!-- Bootstrap core JS-->
    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script>
        let lang = "<?php echo app()->getLocale() ?>";
        // Create a JavaScript object to hold the categories data
        const categories = <?php echo json_encode($categories); ?>;
    </script>

    <script src="js/scripts.js"></script>
    <script src="js/index.js"></script>

</body>

</html>