<!-- Scripts and Styles -->
<link rel="stylesheet" href="{{ asset('css/cart.css') }}">

<!-- Shopping Cart Modal -->
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

                        <!-- Promo Code Section -->
                        <div class="row mb-4">
                            <label for="promo-code" class="col-sm-4 col-form-label">@lang('page.promo_code')</label>
                            <div class="col-sm-5">
                                <input class="form-control" type="text" placeholder="@lang('page.enter_promo_code')" id="promo-code">
                            </div>
                            <div class="col-sm-3">
                                <button type="button" id="apply-promo-btn" class="btn btn-primary w-100" onclick="applyPromoCode()">@lang('page.apply')</button>
                                <button type="button" class="btn btn-secondary w-100 d-none" id="change-promo-btn" onclick="resetPromoCode()">@lang('page.change')</button>

                            </div>
                            
                        </div>
                        <p id="promo-message" class="text-success mt-2" style="display: none;">@lang('page.discount_applied_successfully')</p>

                        <!-- Discounted Price Display -->
                        <p class="mb-2 fw-bold">@lang('page.pre_total'): <span id="pre-total"></span> AED</p>

                        <p class="mb-2 fw-bold">@lang('page.discount'): <span id="discount"></span> AED <span id="discount-value"></span></p>

                        <!-- Total Price Display -->
                        <p class="mb-0 fw-bold">@lang('page.total_price'): <span id="total-price"></span> AED</p>

                        <!-- Cart Details Form -->
                        <form class="mt-4">
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
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('page.order_confirmation')</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="@lang('page.close')">
                    <span aria-hidden="true">&times;</span>
                </button>
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


<script src="js/cart.js"></script>
