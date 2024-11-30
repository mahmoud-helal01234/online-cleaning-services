<!-- Styles -->
<link rel="stylesheet" href="{{ asset('css/cart.css') }}">

<!-- Shopping Cart Modal -->
<div class="modal fade" id="cart-modal" tabindex="-1" aria-labelledby="cartModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content shadow-lg rounded-4">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title">@lang('page.shopping_cart')</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="@lang('page.close')"></button>
            </div>

            <div class="modal-body p-4" >
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body text-center">
                        <!-- Cart Options -->
                        <div id="cart-options" class="cart-options mb-4">
                            <!-- Dynamic cart options will be injected here -->
                        </div>

                        <!-- Promo Code Section -->
                        <div class="row mb-4">
                            <label for="promo-code" class="col-sm-4 col-form-label">@lang('page.promo_code')</label>
                            <div class="col-sm-5">
                                <input class="form-control" type="text" placeholder="@lang('page.enter_promo_code')" id="promo-code">
                            </div>
                            <div class="col-sm-3 d-flex">
                                <button type="button" id="apply-promo-btn" class="btn btn-primary flex-grow-1 me-2" onclick="applyPromoCode()">@lang('page.apply')</button>
                                <button type="button" class="btn btn-secondary flex-grow-1 d-none" id="change-promo-btn" onclick="resetPromoCode()">@lang('page.change')</button>
                            </div>
                        </div>
                        <p id="promo-message" class="text-success mt-2" style="display: none;">@lang('page.discount_applied_successfully')</p>

                        <!-- Pricing Details -->
                        <div  class="text-start mb-4 text-center">
                            <p class="fw-bold mb-2">@lang('page.pre_total'): <span id="pre-total">0.00</span> AED</p>
                            <p class="fw-bold mb-2">@lang('page.discount'): <span id="discount">0.00</span> AED <span id="discount-value"></span></p>
                            <p class="fw-bold text-primary">@lang('page.total_price'): <span id="total-price">0.00</span> AED</p>
                        </div>

                        <!-- Cart Details Form -->
                        <form class="mt-4">
                            <div class="row mb-3">
                                <label for="name" class="col-sm-4 col-form-label">@lang('page.name')</label>
                                <div class="col-sm-8">
                                    <input class="form-control" type="text" name="name" placeholder="@lang('page.enter_name')" id="name" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="phone" class="col-sm-4 col-form-label">@lang('page.phone_number')</label>
                                <div class="col-sm-8">
                                    <input class="form-control" type="text" placeholder="@lang('page.enter_phone')" id="phone" name="phoneNumber" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="address" class="col-sm-4 col-form-label">@lang('page.address')</label>
                                <div class="col-sm-8">
                                    <input class="form-control" type="text" placeholder="@lang('page.enter_address')" id="address" name="address" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="pickup-time" class="col-sm-4 col-form-label">@lang('page.preferred_pickup_time')</label>
                                <div class="col-sm-4">
                                    <input class="form-control" type="date" id="date" name="date" required>
                                </div>
                                <div class="col-sm-4">
                                    <input class="form-control" type="time" id="time" name="time" required>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="modal-footer d-flex justify-content-center py-4">
                <button type="button" onclick="submitOrder()" class="btn btn-lg btn-dark rounded-pill px-5 py-3">
                    <i class="fas fa-shopping-cart fa-lg"></i> @lang('page.place_order')
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Order Confirmation Modal -->
<div class="modal fade" id="orderConfirmationModal" tabindex="-1" role="dialog" aria-labelledby="orderConfirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content shadow-lg rounded-4">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title">@lang('page.order_confirmation')</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="@lang('page.close')"></button>
            </div>
            <div class="modal-body text-center">
                <p>@lang('page.thank_you_for_your_order') <strong id="customerName"></strong>!</p>
                <p>@lang('page.order_added') <strong id="pickupTime"></strong>.</p>
                <p>@lang('page.order_details'):</p>
                <ul class="list-unstyled" id="orderDetails"></ul>
                <p class="fw-bold">@lang('page.appreciation_to_order')</p>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="js/cart.js?v=1.0.0"></script>
