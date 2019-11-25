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
            showCartPage();
        })
    }

    /**
     * Display the listing and the checkout form for the products in the cart
     *
     * @param products
     */
    function show(products) {
        var checkout = $('.checkout');
        var content = $('.products-in-cart');

        content.find('.products-in-cart-table').remove();

        if (products.length === 0) {
            content.append('<div>There are no products</div>');

            checkout.addClass('d-none');

            return;

        }

        content.append($('<table class="table products-in-cart-table"></table>'));

        var productsTable = content.find('.products-in-cart-table');
        var html;

        products.forEach(function (product) {
            if (product.image === '') {
                product.image = '/img/missing-image.png';
            }

            var prodId = product.id;

            html += '<tr>';
            html += '<td class="align-middle">';
            html += '<img src="' + product.image + '"' + ' alt="">';
            html += '</td>';
            html += '<td class="align-middle">';
            html += '<h5 class="font-weight-bold mb-2">' + product.title + '</h5>';
            html += '<div class="font-weight-normal mb-2">' + (product.description || '') + '</div>';
            html += '<div class="font-italic">' + product.price + '</div>';
            html += '</td>';
            html += '<td class="text-center align-middle to-center">';
            html += '<buttton class="btn btn-primary mr-2 product-remove-btn" product="' + prodId + '">Remove from cart</buttton>';
            html += '</td>';
            html += '</tr>';
        });

        productsTable.html(html);

        productsTable.find('.product-remove-btn').click(function() {
            var prodId = $(this).attr('product');
            removeFromCart(prodId);
        });

        checkout.removeClass('d-none');
    }
});
