function submitOrder() {
    // Determine language preference

    // Helper function to get translated text
    const translate = (enText, arText) => lang === 'en' ? enText : arText;

    // Collect the cart data
    const cartData = [];
    document.querySelectorAll('.product-option').forEach(product => {
        const id = product.id.split('-')[2];
        const quantity = parseInt(product.querySelector('.quantity').textContent);
        const total = parseFloat(product.querySelector('.total-price').textContent.replace('AED', ''));

        cartData.push({
            id: id,
            quantity: quantity,
        });
    });
    if (cartData.length === 0) {
        alert(translate('Your cart is empty. Please add products before submitting your order.', 'سلة التسوق فارغة. يرجى إضافة منتجات قبل تقديم الطلب.'));
        return;
    }

    // Collect form input values
    const name = document.querySelector('input[name="name"]').value;
    const phone = document.querySelector('input[name="phoneNumber"]').value;
    const address = document.querySelector('input[name="address"]').value;
    const date = document.querySelector('input[name="date"]').value;
    const time = document.querySelector('input[name="time"]').value;

    // Validation checks
    if (name === "") {
        alert(translate('Please enter your name.', 'يرجى إدخال اسمك.'));
        return;
    }

    const phoneRegex = /^[0-9]+$/;
    if (phone === "" || !phoneRegex.test(phone)) {
        alert(translate('Please enter a valid phone number.', 'يرجى إدخال رقم هاتف صحيح.'));
        return;
    }

    if (address === "") {
        alert(translate('Please enter your address.', 'يرجى إدخال عنوانك.'));
        return;
    }

    if (date === "") {
        alert(translate('Please select a date.', 'يرجى اختيار تاريخ.'));
        return;
    }

    if (time === "") {
        alert(translate('Please select a preferred pickup time.', 'يرجى اختيار وقت استلام مفضل.'));
        return;
    }

    // Create the order object to send
    const orderData = {
        client_name: name,
        phone: phone,
        address: address,
        preferred_pickup_time: date + " " + time,
        items: cartData
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
                const orderDetailsList = document.getElementById('orderDetails');
                orderDetailsList.innerHTML = `
                    <li><strong>${translate('Phone:', 'الهاتف:')}</strong> ${phone}</li>
                    <li><strong>${translate('Address:', 'العنوان:')}</strong> ${address}</li>
                `;

                $('#cart-modal').modal('hide');
                $('#orderConfirmationModal').modal('show');

                return response.json();
            }
            throw new Error(translate('Failed to submit the order', 'فشل في تقديم الطلب'));
        })
        .then(data => {
            cartOptions.clear();
            localStorage.removeItem('cartOptions');
            setTimeout(function () {
                window.location.href = '/';
            }, 6000);
        
            console.log(translate('Order submitted successfully!', 'تم تقديم الطلب بنجاح!'));
            console.log('Success:', data);
        })
        .catch(error => {
            console.error('Error:', error);
        });
}
