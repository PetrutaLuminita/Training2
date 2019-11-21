$(function () {
    showCartPage();

    /**
     * Get the products in the session for the cart page
     */
    function showCartPage() {
        $.ajax({
            type:'GET',
            url:'/get_cart',
            dataType: 'json'
        })
        .done(function(products) {
            show(products);
        });
    }

    /**
     * Removes the id of the product from the session and the associated row from cart page
     *
     * @param productId
     */
    function removeFromCart(productId) {
        $.ajax({
            type:'GET',
            url:'/remove_from_cart/' + productId,
        })
        .done(function() {
            $('.products-in-cart .products-in-cart-table .product-row[product="' + productId + '"]').remove();

            if ($('.products-in-cart .products-in-cart-table .product-row[product]').length === 0) {
                $('.checkout').remove();
            }
        })
    }

    /**
     * Display the listing and the checkout form for the products in the cart
     *
     * @param products
     */
    function show(products) {
        let productsTable = $('.products-in-cart .products-in-cart-table');

        productsTable.empty();

        if (products.length === 0) {
            productsTable.append('<div>There are no products</div>');
            return;
        }

        products.forEach(function (product) {
            if (product.image === '') {
                product.image = '/img/missing-image.png';
            }

            const prodId = product.id;

            let tableRow = $('<tr class="product-row" product="' + prodId + '">').append(
                '<td class="align-middle">' +
                    '<img src="' + product.image + '"' + ' alt="">' +
                '</td>' +
                '<td class="align-middle">' +
                    '<h5 class="font-weight-bold mb-2">' + product.title + '</h5>' +
                    '<div class="font-weight-normal mb-2">' + (product.description || '') + '</div>' +
                    '<div class="font-italic">' + product.price + '</div>' +
                '</td>' +
                '<td class="text-center align-middle to-center">' +
                    '<buttton class="btn btn-primary mr-2 product-remove-btn" product="' + prodId + '">Remove from cart</buttton>' +
                '</td>'
            );

            productsTable.append(tableRow);
        });

        $('.products-in-cart .products-in-cart-table .product-remove-btn').click(function() {
            let prodId = $(this).attr('product');
            removeFromCart(prodId);
        });

        $('.checkout').removeClass('d-none');

        $('.checkout .checkout-form').submit(function(e) {
            e.preventDefault();

            let token = $('.checkout .checkout-form [name="_token"]').val();

            $.ajax({
                url: '/cart_checkout',
                type: 'post',
                data: formData,
                dataType: 'json',
                contentType:false,
                processData: false,
                headers: {
                    'X-CSRF-TOKEN': token
                }
            })
            .done(function(response) {
                if (response.error) {
                    response.error.forEach(function (error) {
                        let msg = $('<div class="alert alert-danger d-none"></div>');

                        if (error.indexOf('name') !== -1) {
                            $('.checkout .checkout-form input[name="name"]').after(msg);
                        }

                        if (error.indexOf('email') !== -1) {
                            $('.checkout .checkout-form input[name="email"]').after(msg);
                        }

                        msg.append(error);
                        msg.removeClass('d-none');
                    })
                } else {
                    window.location.href = '/';
                }
            })
        });
    }
});
