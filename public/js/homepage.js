$(function () {
    showProductsPage();

    /**
     * Store in the session the id of the product and remove the associated row from index page
     *
     * @param productId
     */
    function addToCart(productId) {
        $.ajax({
            type: 'GET',
            url: '/add_to_cart/' + productId,
        })
        .done(function() {
            $('.products-list-table .products-table .product-row[product="' + productId + '"]').remove();
        })
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
            $('.products-list-table .products-table .product-row[product="' + productId + '"]').remove();
        })
    }

    /**
     * Get the products that are not in the session for the index page
     */
    function showProductsPage() {
        $.ajax({
            type:'GET',
            url:'/get_products',
            dataType: 'json'
        })
        .done(function(products) {
            show(products, 'index');
        });
    }

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
            show(products, 'cart');
        });
    }

    /**
     * Create the index and cart pages based on the parameters passed
     *
     * @param products
     * @param page
     */
    function show(products, page) {
        let title = $('.index-title');
        let content = $('.products-list-table');

        title.empty();
        content.empty();

        if (page === 'index') {
            title.html('Products');
        } else {
            title.html('Cart');
        }

        $('.index-cart-btn').remove();

        setChangeBtn(page);

        if (products.length === 0) {
            content.append('<div>There are no products</div>');

            return;
        }

        $('.products-list-table .products-table').remove();

        content.append($('<table class="table products-table"></table>'));

        products.forEach(function (product) {
            if (product.image === '') {
                product.image = '/img/missing-image.png';
            }

            const prodId = product.id;
            const btnName = page === 'index' ? 'Add to cart' : 'Remove from cart';

            let tableRow = $('<tr class="product-row" product="' + prodId + '">').append(
                '<td class="align-middle">' +
                    '<img src="' + product.image + '"' + ' alt="">' +
                '</td>' +
                '<td class="align-middle">' +
                    '<h5 class="font-weight-bold mb-2">' + product.title + '</h5>' +
                    '<div class="font-weight-normal mb-2">' + product.description + '</div>' +
                    '<div class="font-italic">' + product.price + '</div>' +
                '</td>' +
                '<td class="text-center align-middle to-center">' +
                    '<buttton class="btn btn-primary product-btn" product="' + prodId + '">' + btnName + '</buttton>' +
                '</td>'
            );

            $('.products-list-table .products-table').append(tableRow);
        });

        $('.products-table .product-btn').click(function() {
            let prodId = $(this).attr('product');

            if (page === 'index') {
                addToCart(prodId);
            } else {
                removeFromCart(prodId);
            }
        });
    }

    /**
     * Create the button to navigate between the two pages based on the parameter passed
     *
     * @param page
     */
    function setChangeBtn(page) {
        const goToBtn = page === 'index' ? 'Go to cart' : 'Show products';

        $('.products-list-table').after($('<button class="btn btn-primary index-cart-btn">' + goToBtn + '</button>'));

        $('.index-cart-btn').click(function() {
            if (page === 'index' ) {
                showCartPage();
            } else {
                showProductsPage();
            }
        });
    }
});

