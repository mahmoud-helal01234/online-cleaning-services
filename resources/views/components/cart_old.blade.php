<script src="js/cart.js"></script>
<div class="modal fade" id="cart-modal" tabindex="-1" aria-labelledby="cartModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Shopping Cart</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="card-body text-center">
                        <div class="cart-options mb-4" id="cart-options">
                            <!-- Dynamic cart options can be injected here -->
                        </div>

                        <!-- Form Inputs for Cart -->
                        <form>
                            <div class="row mb-3">
                                <label for="name" class="col-sm-4 col-form-label">Name</label>
                                <div class="col-sm-8">
                                    <input class="form-control" type="text" placeholder="Please enter your name" name="name" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="phone" class="col-sm-4 col-form-label">Phone Number</label>
                                <div class="col-sm-8">
                                    <input class="form-control" type="tel" placeholder="Please enter your phone number" name="phoneNumber" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="address" class="col-sm-4 col-form-label">Address</label>
                                <div class="col-sm-8">
                                    <input class="form-control" type="text" placeholder="Please enter your detailed address" name="address" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="pickup-time" class="col-sm-4 col-form-label">Preferred Pickup Time</label>
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
            <div class="modal-footer">
                <!-- <button type="button" class="btn " data-bs-dismiss="modal">Close</button> -->
                <button type="button" onclick="submitOrder()" class="btn btn-dark">Place Order now</button>
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
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
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
            <!-- <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div> -->
        </div>
    </div>
</div>
