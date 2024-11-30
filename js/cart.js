let cartOptions = new Map();
let promoCode = null;
let preTotalPrice = 0;
let totalPrice = 0;

function trans(english = null, arabic = null) {
    return lang == 'en' ? english : arabic;
}

// Declare the ordering flag outside the function
let ordering = false;

function submitOrder() {

    // Check if the function is already running
    if (ordering) {
        // Optionally, alert the user
        alert(translate('Your order is being processed. Please wait.', 'يتم معالجة طلبك. الرجاء الانتظار.'));
        return;
    }

    // Set the flag to true to indicate the function is running
    ordering = true;

    // Helper function to get translated text
    const translate = (enText, arText) => lang === 'en' ? enText : arText;

    // Collect the cart data
    const cartData = [];
    document.querySelectorAll('.product-option').forEach(product => {
        const id = product.id.split('-')[2];
        const quantity = parseInt(product.querySelector('.quantity').textContent);

        cartData.push({
            id: id,
            quantity: quantity,
        });
    });

    if (cartData.length === 0) {
        alert(translate('Your cart is empty. Please add products before submitting your order.', 'سلة التسوق فارغة. يرجى إضافة منتجات قبل تقديم الطلب.'));
        ordering = false; // Reset the flag
        return;
    }

    // Collect form input values
    const name = document.querySelector('input[name="name"]').value;
    const phone = document.querySelector('input[name="phoneNumber"]').value;
    const address = document.querySelector('input[name="address"]').value;
    const date = document.querySelector('input[name="date"]').value;
    const time = document.querySelector('input[name="time"]').value;
    const promoCodeId = promoCode != null ? promoCode.id : null;

    // Validation checks
    if (name === "") {
        alert(translate('Please enter your name.', 'يرجى إدخال اسمك.'));
        ordering = false; // Reset the flag
        return;
    }

    const phoneRegex = /^[0-9]+$/;
    if (phone === "" || !phoneRegex.test(phone)) {
        alert(translate('Please enter a valid phone number.', 'يرجى إدخال رقم هاتف صحيح.'));
        ordering = false; // Reset the flag
        return;
    }

    if (address === "") {
        alert(translate('Please enter your address.', 'يرجى إدخال عنوانك.'));
        ordering = false; // Reset the flag
        return;
    }

    if (date === "") {
        alert(translate('Please select a date.', 'يرجى اختيار تاريخ.'));
        ordering = false; // Reset the flag
        return;
    }

    if (time === "") {
        alert(translate('Please select a preferred pickup time.', 'يرجى اختيار وقت استلام مفضل.'));
        ordering = false; // Reset the flag
        return;
    }

    // Create the order object to send
    const orderData = {
        client_name: name,
        phone: phone,
        address: address,
        preferred_pickup_time: date + " " + time,
        items: cartData,
        promo_code_id: promoCodeId
    };

    console.log(orderData);

    // Send data using fetch
    fetch('/api/order/client', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept-Language': lang === 'en' ? 'en' : 'ar',
            'api-token': 'gh-general',
        },
        body: JSON.stringify(orderData),
    })
    .then(response => {
        if (response.ok) {
            return response.json().then(data => {
                const orderDetailsList = document.getElementById('orderDetails');
                orderDetailsList.innerHTML = `
                    <li><strong>${translate('Phone:', 'الهاتف:')}</strong> ${phone}</li>
                    <li><strong>${translate('Address:', 'العنوان:')}</strong> ${address}</li>
                `;

                $('#cart-modal').modal('hide');
                $('#orderConfirmationModal').modal('show');
                cartOptions.clear();
                resetPromoCode();
                promoCode = null;

                localStorage.removeItem('cartOptions');
                localStorage.removeItem('promoCode');

                console.log(translate('Order submitted successfully!', 'تم تقديم الطلب بنجاح!'));

                // Redirect after a delay
                setTimeout(function () {
                    window.location.href = '/';
                    ordering = false; // Reset the flag after redirection
                }, 6000);
            });
        } else {
            ordering = false; // Reset the flag on failure
            throw new Error(translate('Failed to submit the order', 'فشل في تقديم الطلب'));
        }
    })
    .catch(error => {
        ordering = false; // Reset the flag on error
        console.error('Error:', error);
    });
}


function applyPromoCode() {
    // Get elements
    const promoCodeInput = document.getElementById("promo-code");
    const applyButton = document.getElementById("apply-promo-btn");
    const changeButton = document.getElementById("change-promo-btn");
    const promoMessage = document.getElementById("promo-message");

    // Get promo code entered
    const promoCodeValue = promoCodeInput.value.trim();

    fetch(`${preApiUrl}promo_code/code/${promoCodeValue}`, { // Replace with your API endpoint
        method: "GET",
        headers: {
            "Accept-Language": "ar",
            "api-token": "gh-general",
            "Content-Type": "application/json"
        }
    }) // Replace with your API endpoint
        .then(response => {
            if (response.ok) {
                return response.json();
            } else {
                throw new Error(trans("Invalid Promo Code", "كود خصم غير صحيح"));
            }
        })
        .then(data => {
            if (data.status && data.data.active === 1) {
                localStorage.setItem('promoCode', JSON.stringify(data.data));
                promoCode = data.data;
                fillPromoCodeUI();
            } else {
                alert(trans("Invalid Promo Code", "كود خصم غير صحيح"));
            }
        });
}


function fillPromoCodeUI() {
    if (promoCode == null)
        return;

    const promoCodeInput = document.getElementById("promo-code");
    const applyButton = document.getElementById("apply-promo-btn");
    const changeButton = document.getElementById("change-promo-btn");
    const promoMessage = document.getElementById("promo-message");

    console.log("promoCode : " + promoCode.discount_type);

    const discountType = promoCode.discount_type;
    const discountValue = promoCode.value;
    let discountPrice = 0;
    let discountedPrice;

    if (discountType === "percentage") {

        discountPrice = (preTotalPrice * (discountValue / 100));

    } else if (discountType === "fixed") {

        discountPrice = discountValue;

    }

    totalPrice = preTotalPrice - discountPrice;
    discountedPrice = Math.max(discountedPrice, 0); // Ensure price doesn't go below zero

    document.getElementById("pre-total").innerText = preTotalPrice.toFixed(2);

    document.getElementById("discount").style.display = "inline";

    document.getElementById("discount").innerText = discountPrice.toFixed(2);

    document.getElementById("total-price").innerText = totalPrice.toFixed(2);

    // Update UI: Disable input, hide apply button, show change button
    promoCodeInput.disabled = true;
    promoCodeInput.value = promoCode.code;
    applyButton.classList.add("d-none");
    changeButton.classList.remove("d-none");

    let changeButtonText = promoCode.value;
    changeButtonText += promoCode.discount_type == "percentage" ? " %" : " AED"
    changeButton.innerText = changeButtonText;

    // Show success message
    promoMessage.style.display = "block";
    promoMessage.innerText = trans("Promo Code Applied", "تم تطبيق الخصم");
}

function resetPromoCode() {
    // Get elements
    const promoCodeInput = document.getElementById("promo-code");
    const applyButton = document.getElementById("apply-promo-btn");
    const changeButton = document.getElementById("change-promo-btn");
    const promoMessage = document.getElementById("promo-message");


    // Reset promo code input and enable it
    promoCodeInput.value = "";
    promoCodeInput.disabled = false;

    // Show apply button, hide change button
    applyButton.classList.remove("d-none");
    changeButton.classList.add("d-none");

    // Hide success message and reset discounted price
    promoMessage.style.display = "none";
    console.log(JSON.stringify(localStorage.getItem('promoCode')));
    localStorage.removeItem('promoCode');
    promoCode = null;
    console.log(localStorage.getItem('promoCode'));

    document.getElementById("total-price").innerText = document.getElementById("pre-total").innerText;

    document.getElementById("discount").style.display = "none";
    ;


}

// Attach functions to buttons
document.getElementById("apply-promo-btn").onclick = applyPromoCode;
document.getElementById("change-promo-btn").onclick = resetPromoCode;
// });


function saveCartOptionsInLocalStorage() {
    const cartOptionsArray = Array.from(cartOptions.entries()); // Convert Map to array of key-value pairs
    localStorage.setItem('cartOptions', JSON.stringify(cartOptionsArray));
}

function loadCartDataFromLocalStorage() {
    getCartOptionsFromLocalStorage();
    getPromoCodeFromLocalStorage();
    fillCartUIByData();
}

function getCartOptionsFromLocalStorage() {

    const storedOptions = localStorage.getItem('cartOptions');
    if (storedOptions) {
        // Parse the JSON string back to an array or object
        const parsedOptions = JSON.parse(storedOptions);

        // If it's an array, convert it back to a Map
        cartOptions = new Map(parsedOptions); // Convert array of key-value pairs back to Map
    } else {
        cartOptions = new Map(); // Initialize to an empty Map if nothing in localStorage
    }


}

function getPromoCodeFromLocalStorage() {
    const storedPromoCode = localStorage.getItem('promoCode');

    if (storedPromoCode) {


        promoCode = JSON.parse(storedPromoCode);

    } else {
        promoCode = null;
    }

}

function addToCart() {

    for (const [optionId, optionDetails] of selectedProductOptions.entries()) {

        addOptionToCart(optionId, optionDetails.productName.ar, optionDetails.productName.en, optionDetails.optionName.ar,
            optionDetails.optionName.en, optionDetails.quantity, optionDetails.price);
    }
    console.log(cartOptions.size);
    selectedProductOptions.clear();

    // prepare cart UI with option
    fillCartUIByData();
    saveCartOptionsInLocalStorage();

}

function fillCartOptions() {
    let cartOptionsElements = "";
    if (cartOptions == null)
        return;
    preTotalPrice = 0;
    for (const [optionId, optionDetails] of cartOptions.entries()) {

        cartOptionsElements += `<div id="cart-product-${optionId}" class="product-option p-3 border rounded shadow-sm bg-light">
    <!-- Product Details and Quantity Controls -->
    <div class="row align-items-center" >
        <div class="col-4 text-start">
            <p class="mb-0 fw-bold">`;
        if (lang == 'en')
            cartOptionsElements += `${optionDetails.productName.en} - ${optionDetails.optionName.en}`;
        else
            cartOptionsElements += `${optionDetails.productName.ar} - ${optionDetails.optionName.ar}`;

        cartOptionsElements +=
            `</p>
        </div>
        <div class="col-2 text-center">
            <button onclick="decreaseCartOptionQuantity(${optionId})" id="decrease" class="btn btn-outline-secondary btn-sm">-</button>
        </div>
        <div class="col-2 text-center">
            <p class="quantity" class="mb-0">${optionDetails.quantity}</p>
        </div>
        <div class="col-2 text-center">
            <button onclick="increaseCartOptionQuantity(${optionId})" id="increase" class="btn btn-outline-secondary btn-sm">+</button>
        </div>
        <div class="col-2 text-center">
            <p class="mb-0 fw-bold"><span class="total-price">${optionDetails.price * optionDetails.quantity}</span> AED</p>
        </div>
    </div>
</div>
`;

        preTotalPrice += optionDetails.price * optionDetails.quantity;
        console.log(optionId, optionDetails.productName.ar, optionDetails.productName.en, optionDetails.optionName.ar,
            optionDetails.optionName.en, optionDetails.quantity, optionDetails.price);
    }

    document.getElementById("cart-size").innerHTML = cartOptions.size;

    document.getElementById("cart-options").innerHTML = cartOptionsElements;
    document.getElementById("pre-total").innerHTML = preTotalPrice;
    document.getElementById("total-price").innerHTML = preTotalPrice;

}
function fillCartUIByData() {

    fillCartOptions();
    fillPromoCodeUI();

}

function increaseCartOptionQuantity(cartOptionId) {

    // change in cartOptions variable and localStorage
    let cartOption = cartOptions.get(cartOptionId);
    cartOption.quantity++;

    fillCartUIByData();
    saveCartOptionsInLocalStorage();
}

function decreaseCartOptionQuantity(cartOptionId) {

    let cartOption = cartOptions.get(cartOptionId);

    if (cartOption.quantity == 1) {
        cartOptions.delete(cartOptionId);
    } else {
        cartOption.quantity--;

    }


    fillCartUIByData();
    saveCartOptionsInLocalStorage();
}


function displayCart() {
    for (const [optionId, optionDetails] of cartOptions.entries()) {

        console.log(optionId, optionDetails.productName.ar, optionDetails.productName.en, optionDetails.optionName.ar,
            optionDetails.optionName.en, optionDetails.quantity, optionDetails.price);

    }
}


// Function to add an option to the map or increase its quantity if it already exists
function addOptionToCart(optionId, productNameAr, productNameEn, optionNameAr, optionNameEn, quantity, price) {
    console.log('cartOptions:', cartOptions); // Check its value

    // Check if the option already exists in the map
    if (cartOptions.has(optionId)) {
        // Option exists, so we increase its quantity
        const optionDetails = cartOptions.get(optionId);
        optionDetails.quantity += quantity; // Increase the quantity by the incoming quantity
        console.log(`Increased quantity for option ID ${optionId}: ${optionDetails.quantity}`);
    } else {
        // Option does not exist, so we create a new entry
        const optionDetails = {
            productName: {
                ar: productNameAr,
                en: productNameEn
            },
            optionName: {
                ar: optionNameAr,
                en: optionNameEn
            },
            quantity: quantity, // Set initial quantity
            price: price
        };
        cartOptions.set(optionId, optionDetails); // Add the new option to the map
        console.log(`Added new option ID ${optionId} with quantity ${quantity}`);
    }
}