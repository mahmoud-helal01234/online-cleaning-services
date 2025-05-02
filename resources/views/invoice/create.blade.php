<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Invoice</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/css/select2.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to bottom, #f0f4f8, #d9e2ec);
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: row;
            gap: 20px;
        }

        .left-panel {
            width: 40%;
            padding: 10px;
            background: #f9f9f9;
            border-radius: 12px;
            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        .right-panel {
            width: 60%;
        }

        .categories-row {
            display: flex;
            gap: 20px;
            padding: 10px;
            background-color: #f8f9fa;
            border-radius: 8px;
            overflow-x: auto;
            /* Allow horizontal scrolling */
            -webkit-overflow-scrolling: touch;
            /* Smooth scrolling on mobile */
        }

        .category-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            width: 120px;
            /* Fixed width */
            cursor: pointer;
        }

        .category-item img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 50%;
            /* Make images circular */
            margin-bottom: 8px;
        }

        .category-item.active {
            background-color: #0056b3;
        }

        .product-item {
            width: calc(33.33% - 10px);
            /* 3 products per row */
            background-color: #ffffff;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 10px;
            text-align: center;
            cursor: pointer;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .product-item img {
            width: 100%;
            height: 150px;
            /* Rectangular images */
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 10px;
        }

        .products-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-top: 20px;
        }

        .chosen-products {
            margin-top: 20px;
        }

        .chosen-product-item {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #ffffff;
            margin-bottom: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .popup-content {
            max-width: 600px;
            padding: 30px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            overflow-y: auto;
            max-height: 80vh;
        }

        .popup-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 999;
            padding: 20px;
        }

        .btn-close-popup {
            float: right;
            background: none;
            border: none;
            font-size: 20px;
            font-weight: bold;
            cursor: pointer;
            color: #333;
        }

        .form-check-label {
            display: inline-block;
            margin-right: 10px;
        }

        .quantity-input {
            width: 60px;
        }

        .price-input {
            width: 100px;
        }

        .quantity-price-container {
            display: flex;
            justify-content: space-between;
            gap: 10px;
        }

        .remove-product {
            cursor: pointer;
            color: red;
        }

        #loading-spinner {
            display: none;
            text-align: center;
        }

        table {
            width: 100%;
            margin-bottom: 20px;
            border-collapse: collapse;
        }

        table th,
        table td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }

        table th {
            background-color: #f8f9fa;
        }

        @media (max-width: 768px) {
            .container {
                flex-direction: column;
                padding: 10px;
            }

            .left-panel,
            .right-panel {
                width: 100%;
            }

            .categories-row {
                flex-direction: row;
                /* Ensure categories are displayed in a row */
                overflow-x: auto;
                /* Enable horizontal scrolling */
                -webkit-overflow-scrolling: touch;
                /* Smooth scrolling for iOS */
            }

            .category-item {
                width: 120px;
                /* Ensure each category has a fixed width */
            }

            .products-grid {
                display: flex;
                margin-top: 10px;
            }

            .product-item {
                /* width: 48%; 2 products per row */
                margin-bottom: 10px;
            }

            .chosen-product-item {
                flex-direction: column;
                align-items: flex-start;
            }

            .chosen-products table th,
            .chosen-products table td {
                padding: 8px;
            }

            .quantity-input,
            .price-input {
                width: 100%;
                margin-bottom: 10px;
            }

            .form-group {
                margin-bottom: 15px;
            }

            .btn {
                width: 100%;
            }

            .popup-content {
                width: 100%;
                padding: 20px;
            }
        }
    </style>
    <meta name="csrf-token" content="{{ csrf_token() }}">

</head>

<body>

    <div class="container">
        <!-- Left Panel -->
        <div class="left-panel">
            <h5>Client Information</h5>
            <div class="form-group mb-3">
                <label for="order_id" class="form-label">Order id</label>
                <input type="text" class="form-control" id="order_id" placeholder="Enter Order id">
            </div>
            <div class="form-group mb-3">
                <label for="client_name" class="form-label">Client Name</label>
                <input type="text" class="form-control" id="client_name" placeholder="Enter client name">
            </div>
            <div class="form-group mb-3">
                <label for="client_phone" class="form-label">Phone Number</label>
                <input type="text" class="form-control" id="client_phone" placeholder="Enter phone number">
            </div>
            <div class="form-group mb-3">
                <label for="client_address" class="form-label">Address</label>
                <textarea class="form-control" id="client_address" placeholder="Enter address"></textarea>
            </div>

            <h5>Chosen Products</h5>
            <div class="chosen-products" id="chosen-products">
                <p>No products selected.</p>
            </div>

            <div class="form-group mb-3">
                <label for="discount" class="form-label">Discount</label>
                <input type="number" class="form-control" id="discount" placeholder="Enter discount" min="0">
            </div>

            <h5>Total Price: <span id="total-price">0</span></h5>

            <!-- Submit Button -->
            <button id="submit-invoice" class="btn btn-success mt-3">Generate Invoice</button>
            <button id="clear-client-info" class="btn btn-secondary mt-3">Clear</button>
        </div>

        <!-- Right Panel -->
        <div class="right-panel">
            <h5>Categories</h5>
            <div class="categories-row" id="categories-row">
                <!-- Categories will be dynamically added here -->
            </div>

            <h5>Products</h5>
            <div class="products-grid" id="products-grid">
                <!-- Products will be dynamically added here -->
            </div>
        </div>
    </div>

    <!-- Popup for Product Options -->
    <div class="popup-overlay" id="popup-overlay">
        <div class="popup-content">
            <button class="btn-close-popup" id="btn-close-popup">&times;</button>
            <h5 id="popup-product-name"></h5>
            <div id="popup-options">
                <!-- Options will be dynamically added here -->
            </div>
            <button class="btn btn-primary w-100 mt-3" id="btn-add-to-cart">Add to Cart</button>
        </div>
    </div>

    <div id="loading-spinner">
        <img src="https://upload.wikimedia.org/wikipedia/commons/e/e0/Loading_spinner.gif" alt="Loading..." width="50">
        <p>Loading...</p>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        const categories = @json($categories);
        const preUrl = "{{url('/')}}"; // Base URL for images and other resources

        document.addEventListener('DOMContentLoaded', function() {
            const categoriesRow = document.getElementById("categories-row");
            const productsGrid = document.getElementById("products-grid");
            const chosenProducts = document.getElementById("chosen-products");
            const popupOverlay = document.getElementById("popup-overlay");
            const popupProductName = document.getElementById("popup-product-name");
            const popupOptions = document.getElementById("popup-options");
            const btnAddToCart = document.getElementById("btn-add-to-cart");
            const btnClosePopup = document.getElementById("btn-close-popup");
            const submitInvoiceButton = document.getElementById("submit-invoice");
            const clearClientButton = document.getElementById("clear-client-info");
            const discountInput = document.getElementById("discount");
            const totalPriceElement = document.getElementById("total-price");

            let selectedProducts = []; // Holds products added to the cart
            let currentProduct = null; // The currently selected product

            // Function to load categories dynamically
            categories.forEach(category => {
                const categoryItem = document.createElement("div");
                categoryItem.className = "category-item";
                categoryItem.textContent = category.name_en;

                const categoryImage = document.createElement("img");
                categoryImage.src = preUrl + "/" + (category.img_path);
                categoryItem.prepend(categoryImage);

                categoryItem.onclick = () => loadProducts(category.products);
                categoriesRow.appendChild(categoryItem);
            });

            // Load products for the selected category
            function loadProducts(products) {
                productsGrid.innerHTML = "";
                products.forEach(product => {
                    const productItem = document.createElement("div");
                    productItem.className = "product-item";
                    productItem.textContent = product.name_en;

                    const productImage = document.createElement("img");
                    productImage.src = preUrl + "/" + (product.img_path || 'default-product.jpg');
                    productItem.prepend(productImage);

                    productItem.onclick = () => openProductPopup(product);
                    productsGrid.appendChild(productItem);
                });
            }

            // Open the product options popup when a product is clicked
            function openProductPopup(product) {
                currentProduct = product;
                popupProductName.textContent = product.name_en;
                popupOptions.innerHTML = ""; // Clear previous options

                product.options.forEach(option => {
                    const optionCard = document.createElement("div");
                    optionCard.className = "card shadow-sm mb-3";

                    const cardBody = document.createElement("div");
                    cardBody.className = "card-body";

                    const label = document.createElement("h6");
                    label.className = "card-title mb-2 text-muted";
                    label.textContent = option.name_en;

                    const quantityInput = document.createElement("input");
                    quantityInput.type = "number";
                    quantityInput.className = "form-control quantity-input";
                    quantityInput.value = 0;
                    quantityInput.dataset.optionId = option.id;
                    quantityInput.min = 0;

                    const priceInput = document.createElement("input");
                    priceInput.type = "number";
                    priceInput.className = "form-control price-input";
                    priceInput.value = option.price;

                    cardBody.appendChild(label);
                    cardBody.appendChild(quantityInput);
                    cardBody.appendChild(priceInput);

                    optionCard.appendChild(cardBody);
                    popupOptions.appendChild(optionCard);
                });

                popupOverlay.style.display = "flex"; // Show the popup
            }

            // Close the product options popup
            btnClosePopup.onclick = () => popupOverlay.style.display = "none";

            // Close the popup if the user clicks outside of it
            popupOverlay.onclick = (e) => {
                if (e.target === popupOverlay) {
                    popupOverlay.style.display = "none";
                }
            };


            // Add selected product to the cart
            btnAddToCart.onclick = () => {
                const selectedOptions = Array.from(popupOptions.querySelectorAll(".quantity-input"))
                    .map(input => {
                        const quantity = parseInt(input.value) || 0; // Get the quantity, default to 0 if not valid
                        if (quantity > 0) {
                            const optionId = input.dataset.optionId;
                            const price = parseFloat(input.nextElementSibling.value); // Get price
                            const optionName = input.previousElementSibling.textContent; // Get option name
                            return {
                                productName: currentProduct.name_en,
                                optionName: optionName,
                                quantity: quantity,
                                price: price,
                                optionId: optionId
                            };
                        }
                        return null;
                    })
                    .filter(option => option !== null);

                if (selectedOptions.length > 0) {
                    selectedOptions.forEach(option => selectedProducts.push(option)); // Add the selected option(s) to the cart
                    updateChosenProducts(); // Update the cart display
                    popupOverlay.style.display = "none"; // Close the popup
                } else {
                    alert("Please select a quantity for the product.");
                }
            };

            // Update the cart display
            // Update the cart display when quantity or price changes
            function updateChosenProducts() {
                if (selectedProducts.length > 0) {
                    chosenProducts.innerHTML = `
            <table>
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    ${selectedProducts.map(product => `
                        <tr data-option-id="${product.optionId}">
                            <td>${product.productName} - ${product.optionName}</td>
                            
                            <td><input type="number" value="${product.quantity}" class="quantity-input" data-option-id="${product.optionId}" min="0"></td>
                            <td><input type="number" value="${product.price.toFixed(2)}" class="price-input" data-option-id="${product.optionId}" step="0.01" min="0"></td>
                            <td><span class="remove-product" onclick="removeProduct('${product.optionId}')">X</span></td>
                        </tr>
                    `).join('')}
                </tbody>
            </table>
        `;

                    // Add event listeners for quantity and price input changes
                    const quantityInputs = chosenProducts.querySelectorAll(".quantity-input");
                    quantityInputs.forEach(input => {
                        input.addEventListener("input", (e) => {
                            const optionId = e.target.dataset.optionId;
                            const quantity = parseInt(e.target.value) || 0;
                            const product = selectedProducts.find(p => p.optionId === optionId);
                            if (product) {
                                product.quantity = quantity; // Update the product quantity
                                updateTotalPrice(); // Recalculate the total price
                            }
                        });
                    });

                    const priceInputs = chosenProducts.querySelectorAll(".price-input");
                    priceInputs.forEach(input => {
                        input.addEventListener("input", (e) => {
                            const optionId = e.target.dataset.optionId;
                            const price = parseFloat(e.target.value) || 0;
                            const product = selectedProducts.find(p => p.optionId === optionId);
                            if (product) {
                                product.price = price; // Update the product price
                                updateTotalPrice(); // Recalculate the total price
                            }
                        });
                    });
                } else {
                    chosenProducts.innerHTML = "<p>No products selected.</p>";
                }

                updateTotalPrice(); // Recalculate and update total price
            }


            // Remove product from the cart


            window.removeProduct = function(optionId) {
                selectedProducts = selectedProducts.filter(product => product.optionId !== optionId);
                updateChosenProducts(); // Update cart display
            };

            // Clear client information and cart
            clearClientButton.onclick = () => {
                document.getElementById("client_name").value = '';
                document.getElementById("order_id").value = '';

                document.getElementById("client_phone").value = '';
                document.getElementById("client_address").value = '';
                selectedProducts = []; // Clear selected products
                updateChosenProducts(); // Update cart display
            };

            // Calculate the total price based on selected products and discount
            function calculateTotalPrice() {
                let total = selectedProducts.reduce((acc, product) => acc + (product.price * product.quantity), 0);
                const discountValue = parseFloat(discountInput.value) || 0;

                if (discountValue) {
                    if (discountValue <= 100) {
                        total -= (total * discountValue / 100); // Apply percentage discount
                    } else {
                        total -= discountValue; // Apply fixed discount
                    }
                }

                return total > 0 ? total : 0; // Ensure total is not negative
            }

            // Update the total price displayed
            function updateTotalPrice() {
                totalPriceElement.textContent = calculateTotalPrice().toFixed(2); // Format price with two decimals
            }

            // Handle form submission to generate the invoice
            document.getElementById('submit-invoice').onclick = () => {
                const orderId = document.getElementById("order_id").value;

                const clientName = document.getElementById("client_name").value;
                const clientPhone = document.getElementById("client_phone").value;
                const clientAddress = document.getElementById("client_address").value;
                const discount = document.getElementById("discount").value;

                if (!clientName || !clientPhone || !clientAddress || selectedProducts.length === 0) {
                    alert("Please provide client information, address, and select at least one product.");
                    return;
                }

                // Prepare the products for submission
                const products = selectedProducts.map(product => ({
                    item_name: product.productName + " - " +  product.optionName,
                    item_price: product.price,
                    item_quantity: product.quantity
                }));

                // Prepare the data to send
                const invoiceData = {
                    client_name: clientName,
                    id: orderId,

                    phone: clientPhone,
                    address: clientAddress,
                    discount: discount || 0, // Use 0 if no discount
                    items: products,
                    price: totalPriceElement.textContent
                };

                // Send data to Laravel using AJAX
                $.ajax({
                    url: "{{ route('invoice.generate') }}",
                    method: 'POST',
                    data: invoiceData,
                    beforeSend: function(xhr) {
                        // Get CSRF token from meta tag and add it to the request headers
                        var token = $('meta[name="csrf-token"]').attr('content');
                        xhr.setRequestHeader('X-CSRF-TOKEN', token);
                    },

                    success: function(response) {
                        window.open(response.pdf_url, '_blank','width=800,height=600,scrollbars=yes,resizable=yes');
                    },
                    error: function(error) {
                        alert("Error generating invoice. Please try again.");
                    }
                });
            };


            // Handle the discount input change
            discountInput.addEventListener("input", updateTotalPrice);
        });
    </script>
</body>

</html>