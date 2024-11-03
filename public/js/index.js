// import * as constants from './constants.js';
const preImageUrl = "https://aquacare-laundry.com/";

const preApiUrl = "https://aquacare-laundry.com/api/";

// holding categories
// let categories;

// holding cart options
let cartOptions = new Map();
document.addEventListener('DOMContentLoaded', () => {
    let categoriesElements = '';
    let categoryIndex = 0;
    categories.forEach(category => {

        categoriesElements += `<button type="button"
                    class="btn-category btn btn-secondary" id="category-${categoryIndex}" 
                    onclick="changeSelectedCategory(${categoryIndex++})">
                    `;
        if (lang == 'en')
            categoriesElements +=
                `${category.name_en}</button>`;
        else
            categoriesElements +=
                `${category.name_ar}</button>`;
    });

    document.getElementById("categories").innerHTML = categoriesElements;
    if (categories.length >= 1)
        changeSelectedCategory(0);
});


function changeSelectedCategory(categoryIndex) {

    // remove bg-dark from the other categories
    const darkElements = document.querySelectorAll('#categories .bg-dark');

    // Loop through each element and remove the class
    darkElements.forEach(element => {
        element.classList.remove('bg-dark');
    });

    // add bg-dark to the selected category
    document.getElementById("category-" + categoryIndex).classList.add('bg-dark');

    let productsElements = "";
    let productIndex = 0;
    categories[categoryIndex].products.forEach(product => {
        let minPrice = 0; // Get min price
        let maxPrice = 0; // Get max price
        if (product.options.length > 0) {
            let prices = product.options.map(option => option.price); // Extract all prices
            minPrice = Math.min(...prices); // Get min price
            maxPrice = Math.max(...prices); // Get max price

            console.log(`    Min Price: ${minPrice}`);
            console.log(`    Max Price: ${maxPrice}`);
        } else {
            console.log('    No options available for this product');
        }
        let price = "";
        if (minPrice == maxPrice)
            price = maxPrice + " AED";
        else
            price = minPrice + " - " + maxPrice + " AED";
        productsElements += `<div class="col mb-5 product-card" id="product-${productIndex}" product-index="${productIndex}" >
            <div class="card h-100">
                <!-- Product image-->
                <img class="card-img-top"
                    src="${preImageUrl + product.img_path}" alt="`;
        if (lang == 'en')
            productsElements += `${product.name_en}`;
        else
            productsElements += `${product.name_ar}`;

        productsElements += `" />
                <!-- Product details-->
                <div class="card-body p-4">
                    <div class="text-center">
                        <!-- Product name-->
                        <h5 class="fw-bolder">`;
        if (lang == 'en')
            productsElements += `${product.name_en}`;
        else
            productsElements += `${product.name_ar}`;

        productsElements += `
                        </h5>
                        <!-- Product price-->
                        ${price}
                    </div>
                </div>
                <!-- Product actions-->
                <div
                    class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                    <div class="text-center"><button
                            class="btn btn-outline-dark mt-auto"
                            data-bs-toggle="modal"
                        data-bs-target="#product-modal" onclick="openProductModal(${categoryIndex},${productIndex})">`;
        if (lang == 'en')
            productsElements += `Add to cart`;
        else
            productsElements += "أضف إلى السلة";
        productsElements += `</button></div>
                </div>
            </div>
        </div>`;
        console.log(`  Product ID: ${product.id}`);
        console.log(`  Product Name (EN): ${product.name_en}`);
        console.log(`  Product Name (AR): ${product.name_ar}`);

        // Loop through the options within the product
        product.options.forEach(option => {
            console.log(`    Option ID: ${option.id}`);
            console.log(`    Option Name (EN): ${option.name_en}`);
            console.log(`    Price: ${option.price}`);
        });
        productIndex++;
    });
    document.getElementById("products").innerHTML = productsElements;

}
let modalProductOptions;

function openProductModal(categoryIndex, productIndex) {

    productOptionsModal = null;

    productOptionsElements = "";
    let optionIndex = 0;
    categories[categoryIndex].products[productIndex].options.forEach(option => {

        productOptionsElements += `<div id="product-option-${optionIndex}" >

                                    <!-- Quantity and Total Price -->
                                    <div class="row align-items-center">
                                        <div class="col-3 text-start ">
                                            <p class="mb-0">`;

        if (lang == 'en')
            productOptionsElements += `${option.name_en}`;
        else
            productOptionsElements += `${option.name_ar}`;
        productOptionsElements +=
            `</p>
                    </div>
                    <div class="col-1">
                        <button id="decrease"
                            class="btn btn-outline-secondary btn-sm" onClick="decreaseOptionQuantity(${categoryIndex},${productIndex},${optionIndex})" >-</button>
                    </div>
                    <div class="col-4 text-center">
                        <span class="quantity">0</span> * <span
                            class="price">${option.price}</span> AED
                    </div>
                    <div class="col-1">
                        <button id="increase"
                            class="btn btn-outline-secondary btn-sm" onClick="increaseOptionQuantity(${categoryIndex},${productIndex},${optionIndex})">+</button>
                    </div>
                    <div class="col-3 text-center">
                        <span class="total-price">0</span> AED
                    </div>
                </div>

            </div>`;
        optionIndex++;
    });

    document.getElementById("product-options").innerHTML = productOptionsElements;
    if (lang == 'en')
        document.getElementById("product-modal-name").innerHTML = categories[categoryIndex].products[productIndex].name_en;
    else
        document.getElementById("product-modal-name").innerHTML = categories[categoryIndex].products[productIndex].name_ar;
    document.getElementById("product-modal-img").src = preImageUrl + categories[categoryIndex].products[productIndex].img_path;


}

const selectedProductOptions = new Map();


function increaseOptionQuantity(categoryIndex, productIndex, optionIndex) {


    const optionElement = document.querySelector(`#product-option-${optionIndex}`);

    const quantityElement = optionElement.querySelector(`.quantity`);

    // Convert the current quantity to a number
    let currentQuantity = parseInt(quantityElement.innerHTML) || 0; // Fallback to 0 if not a number

    // Increase the quantity by 1
    currentQuantity += 1;

    // Update the quantity element with the new value
    quantityElement.innerHTML = currentQuantity;

    const totalPriceElement = optionElement.querySelector(`.total-price`);

    const priceElement = optionElement.querySelector(`.price`);

    let price = parseFloat(priceElement.innerHTML) || 0; // Fallback to 0 if not a number

    let totalPrice = parseFloat(totalPriceElement.innerHTML) || 0; // Fallback to 0 if not a number

    totalPrice += price;

    totalPriceElement.innerHTML = totalPrice;

    // on data level
    if (selectedProductOptions.has(categories[categoryIndex].products[productIndex].options[optionIndex].id)) {
        // Option exists, so we increase its quantity
        let optionDetails = selectedProductOptions.get(categories[categoryIndex].products[productIndex].options[optionIndex].id);
        optionDetails.quantity += 1; // Increase the quantity by the incoming quantity
        console.log(`Increased quantity for option ID ${categories[categoryIndex].products[productIndex].options[optionIndex].id}: ${optionDetails.quantity}`);
        selectedProductOptions.set(categories[categoryIndex].products[productIndex].options[optionIndex].id, optionDetails);
    } else {
        let product = categories[categoryIndex].products[productIndex];

        let option = categories[categoryIndex].products[productIndex].options[optionIndex];

        const optionDetails = {
            productName: {
                ar: product.name_ar,
                en: product.name_en
            },
            optionName: {
                ar: option.name_ar,
                en: option.name_en
            },
            quantity: 1, // Set initial quantity
            price: option.price
        };
        selectedProductOptions.set(categories[categoryIndex].products[productIndex].options[optionIndex].id, optionDetails);

        console.log(`Added new option ID ${categories[categoryIndex].products[productIndex].options[optionIndex].id} with quantity 1`);
    }

}

function decreaseOptionQuantity(categoryIndex, productIndex, optionIndex) {

    const optionElement = document.querySelector(`#product-option-${optionIndex}`);

    const quantityElement = optionElement.querySelector(`.quantity`);

    // Convert the current quantity to a number
    let currentQuantity = parseInt(quantityElement.innerHTML) || 0; // Fallback to 0 if not a number

    if (currentQuantity == 0)
        return;

    // decrease the quantity by 1
    currentQuantity -= 1;

    // Update the quantity element with the new value
    quantityElement.innerHTML = currentQuantity;

    const totalPriceElement = optionElement.querySelector(`.total-price`);

    const priceElement = optionElement.querySelector(`.price`);

    let price = parseFloat(priceElement.innerHTML) || 0; // Fallback to 0 if not a number

    let totalPrice = parseFloat(totalPriceElement.innerHTML) || 0; // Fallback to 0 if not a number

    totalPrice -= price;

    totalPriceElement.innerHTML = totalPrice;

    if (currentQuantity == 0) {
        selectedProductOptions.delete(categories[categoryIndex].products[productIndex].options[optionIndex].id);
    }

    // on data level
    // if (selectedProductOptions.has(categories[categoryIndex].products[productIndex].options[optionIndex].id)) {
    else {
        
        // Option exists, so we decrease its quantity
        let optionDetails = selectedProductOptions.get(categories[categoryIndex].products[productIndex].options[optionIndex].id);
        optionDetails.quantity -= 1; // Increase the quantity by the incoming quantity
        console.log(`Increased quantity for option ID ${categories[categoryIndex].products[productIndex].options[optionIndex].id}: ${optionDetails.quantity}`);
        selectedProductOptions.set(categories[categoryIndex].products[productIndex].options[optionIndex].id, optionDetails);

    }
}

function saveCartOptionsInLocalStorage() {
    const cartOptionsArray = Array.from(cartOptions.entries()); // Convert Map to array of key-value pairs
    localStorage.setItem('cartOptions', JSON.stringify(cartOptionsArray));
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


    fillCartUIByData();
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

function fillCartUIByData() {

    let cartOptionsElements = "";
    if (cartOptions == null)
        return;
    let totalPrice = 0;
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

        totalPrice += optionDetails.price * optionDetails.quantity;
        console.log(optionId, optionDetails.productName.ar, optionDetails.productName.en, optionDetails.optionName.ar,
            optionDetails.optionName.en, optionDetails.quantity, optionDetails.price);
    }

    document.getElementById("cart-size").innerHTML = cartOptions.size;

    document.getElementById("cart-options").innerHTML = cartOptionsElements;
    document.getElementById("total-price").innerHTML = totalPrice;

}

function increaseCartOptionQuantity(cartOptionId) {

    // increase quantity
    let quantityElement = document.querySelector(`#cart-product-${cartOptionId} .quantity`);
    let quantity = parseInt(quantityElement.innerHTML);
    quantityElement.innerHTML = quantity + 1;

    // increase price 
    // get price 
    let totalPriceElement = document.querySelector(`#cart-product-${cartOptionId} .total-price`);
    let totalPrice = parseFloat(totalPriceElement.innerHTML);
    let addedPrice = totalPrice / quantity;
    totalPrice += addedPrice;

    totalPriceElement.innerHTML = totalPrice;
    document.getElementById("total-price").innerHTML = parseFloat(document.getElementById("total-price").innerHTML) + addedPrice;

    // change in cartOptions variable and localStorage
    let cartOption = cartOptions.get(cartOptionId);
    cartOption.quantity++;

    saveCartOptionsInLocalStorage();
}

function decreaseCartOptionQuantity(cartOptionId) {

    // increase quantity
    let quantityElement = document.querySelector(`#cart-product-${cartOptionId} .quantity`);

    let quantity = parseInt(quantityElement.innerHTML);

    if (quantity == 1) {
        // remove from cartOptions object and from ui
        cartOptions.delete(cartOptionId);
        saveCartOptionsInLocalStorage();
        fillCartUIByData();
        return;
    }

    quantityElement.innerHTML = quantity - 1;

    // increase price 
    // get price 
    let totalPriceElement = document.querySelector(`#cart-product-${cartOptionId} .total-price`);
    let totalPrice = parseFloat(totalPriceElement.innerHTML);
    let subtractedPrice = totalPrice / quantity;
    totalPrice -= subtractedPrice;
    totalPriceElement.innerHTML = totalPrice;

    document.getElementById("total-price").innerHTML = parseFloat(document.getElementById("total-price").innerHTML) - subtractedPrice;

    // change in cartOptions variable and localStorage
    let cartOption = cartOptions.get(cartOptionId);
    cartOption.quantity--;

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

getCartOptionsFromLocalStorage();


var myCarousel = new bootstrap.Carousel('#carouselExampleCaptions', {
    interval: 3500, // Time between slides (5 seconds)
    ride: 'carousel' // Automatically starts the carousel
});



(function ($) {
    $.fn.countTo = function (options) {
        options = options || {};

        return $(this).each(function () {
            // set options for current element
            var settings = $.extend({}, $.fn.countTo.defaults, {
                from: $(this).data('from'),
                to: $(this).data('to'),
                speed: $(this).data('speed'),
                refreshInterval: $(this).data('refresh-interval'),
                decimals: $(this).data('decimals')
            }, options);

            // how many times to update the value, and how much to increment the value on each update
            var loops = Math.ceil(settings.speed / settings.refreshInterval),
                increment = (settings.to - settings.from) / loops;

            // references & variables that will change with each update
            var self = this,
                $self = $(this),
                loopCount = 0,
                value = settings.from,
                data = $self.data('countTo') || {};

            $self.data('countTo', data);

            // if an existing interval can be found, clear it first
            if (data.interval) {
                clearInterval(data.interval);
            }
            data.interval = setInterval(updateTimer, settings.refreshInterval);

            // initialize the element with the starting value
            render(value);

            function updateTimer() {
                value += increment;
                loopCount++;

                render(value);

                if (typeof (settings.onUpdate) == 'function') {
                    settings.onUpdate.call(self, value);
                }

                if (loopCount >= loops) {
                    // remove the interval
                    $self.removeData('countTo');
                    clearInterval(data.interval);
                    value = settings.to;

                    if (typeof (settings.onComplete) == 'function') {
                        settings.onComplete.call(self, value);
                    }
                }
            }

            function render(value) {
                var formattedValue = settings.formatter.call(self, value, settings);
                $self.html(formattedValue);
            }
        });
    };

    $.fn.countTo.defaults = {
        from: 0,               // the number the element should start at
        to: 0,                 // the number the element should end at
        speed: 1000,           // how long it should take to count between the target numbers
        refreshInterval: 100,  // how often the element should be updated
        decimals: 0,           // the number of decimal places to show
        formatter: formatter,  // handler for formatting the value before rendering
        onUpdate: null,        // callback method for every time the element is updated
        onComplete: null       // callback method for when the element finishes updating
    };

    function formatter(value, settings) {
        return value.toFixed(settings.decimals);
    }
}(jQuery));

jQuery(function ($) {
    // custom formatting example
    $('.count-number').data('countToOptions', {
        formatter: function (value, options) {
            return value.toFixed(options.decimals).replace(/\B(?=(?:\d{3})+(?!\d))/g, ',');
        }
    });

    // start all the timers
    $('.timer').each(count);

    function count(options) {
        var $this = $(this);
        options = $.extend({}, options || {}, $this.data('countToOptions') || {});
        $this.countTo(options);
    }
});

// product with sale price
/*
<div class="col mb-5">
                      <div class="card h-100">
                          <!-- Sale badge-->
                          <div
                              class="badge bg-dark text-white position-absolute"
                              style="top: 0.5rem; right: 0.5rem">Sale</div>
                          <!-- Product image-->
                          <img class="card-img-top"
                              src="https://dummyimage.com/450x300/dee2e6/6c757d.jpg"
                              alt="..." />
                          <!-- Product details-->
                          <div class="card-body p-4">
                              <div class="text-center">
                                  <!-- Product name-->
                                  <h5 class="fw-bolder">Special Item</h5>
                                  <!-- Product reviews-->
                                  <div
                                      class="d-flex justify-content-center small text-warning mb-2">
                                      <div class="bi-star-fill"></div>
                                      <div class="bi-star-fill"></div>
                                      <div class="bi-star-fill"></div>
                                      <div class="bi-star-fill"></div>
                                      <div class="bi-star-fill"></div>
                                  </div>
                                  <!-- Product price-->
                                  <span
                                      class="text-muted text-decoration-line-through">$20.00</span>
                                  $18.00
                              </div>
                          </div>
                          <!-- Product actions-->
                          <div
                              class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                              <div class="text-center"><a
                                      class="btn btn-outline-dark mt-auto"
                                      href="#">Add to cart</a></div>
                          </div>
                      </div>
                  </div>
*/
