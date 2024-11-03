<script>
        // let lang = "<?php echo app()->getLocale() ?>";
</script>

<script src="js/cart.js"></script>

<link rel="stylesheet" href="{{ asset('css/cart.css') }}">

<div class="modal fade" id="cart-modal" tabindex="-1" aria-labelledby="cartModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('page.shopping_cart')</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="@lang('page.close')"></button>
            </div>
            
<div class="modal-body">
                <div class="card">
                    <div class="card-body text-center">
                        <div class="cart-options mb-4" id="cart-options">
                            <!-- Dynamic cart options can be injected here -->
                        </div>
                        <div id="cart-product-22" class="text-center">
                            <!-- Product Details and Quantity Controls -->
                            <div class=" text-center">
                                <p class="mb-0 fw-bold">@lang('page.total_price') : <span id="total-price"></span> AED</p>
                            </div>
                        </div>
                        <!-- Form Inputs for Cart -->
                        <form>
                            <div class="row mb-3">
                                <label for="name" class="col-sm-4 col-form-label">@lang('page.name')</label>
                                <div class="col-sm-8">
                                    <input class="form-control" type="text" placeholder="@lang('page.enter_name')" name="name" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="phone" class="col-sm-4 col-form-label">@lang('page.phone_number')</label>
                                <div class="col-sm-8">
                                    <input class="form-control" type="text" placeholder="@lang('page.enter_phone')" name="phoneNumber" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="address" class="col-sm-4 col-form-label">@lang('page.address')</label>
                                <div class="col-sm-8">
                                    <input class="form-control" type="text" placeholder="@lang('page.enter_address')" name="address" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="pickup-time" class="col-sm-4 col-form-label">@lang('page.preferred_pickup_time')</label>
                                <div class="col-sm-4">
                                    <input class="form-control" type="date" name="date" required>
                                </div>
                                <div class="col-sm-4">
                                    <input class="form-control" type="time" name="time" required>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer d-flex justify-content-center py-4" style="border-top: 1px solid #eaeaea; background-color: #f9f9f9;">
                <button type="button" onclick="submitOrder()" class="btn btn-lg btn-dark rounded-pill px-5 py-3" style="font-size: 1.25rem; transition: background-color 0.3s ease;"><i class="fas fa-shopping-cart fa-lg"></i> @lang('page.place_order')</button>
            </div>
        </div>
    </div>
</div>

<!-- Order Confirmation Modal -->
<div class="modal fade" id="orderConfirmationModal" tabindex="-1" role="dialog" aria-labelledby="orderConfirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="orderConfirmationModalLabel">@lang('page.order_confirmation')</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="@lang('page.close')">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <p>@lang('page.thank_you_for_your_order') <strong id="customerName"></strong>!</p>
                <p>@lang('page.order_added') <strong id="pickupTime"></strong>.</p>
                <p>@lang('page.order_details'):</p>
                <ul style="list-style: none; padding: 0;" id="orderDetails"></ul>
                <p style="font-weight: bold;">@lang('page.appreciation_to_order')</p>
            </div>
        </div>
    </div>
</div>