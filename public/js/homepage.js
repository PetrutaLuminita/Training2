$(function () {
    var navigateBtn = $('.navigate-buttons');
    var page;

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
            showProductsPage();
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
            showCartPage();
        })
    }

    /**
     * Get the products that are not in the session for the index page
     */
    function showProductsPage() {
        page = 'index';

        $.ajax({
            type:'GET',
            url:'/get_products',
            dataType: 'json'
        })
        .done(function(products) {
            show(products, page);
        });
    }

    /**
     * Get the products in the session for the cart page
     */
    function showCartPage() {
        page = 'cart';
        $.ajax({
            type:'GET',
            url:'/get_cart',
            dataType: 'json'
        })
        .done(function(products) {
            show(products, page);
        });
    }

    /**
     * Create the index and cart pages based on the parameters passed
     *
     * @param products
     * @param page
     */
    function show(products, page) {
        var content = $('.products-list-table');
        var title = $('.index-title');

        title.empty();
        content.empty();

        if (page === 'index') {
            title.html('Products');
        } else {
            title.html('Cart');
        }

        navigateBtn.find('.index-cart-btn').remove();
        setNavigateBtn(page);

        if (products.length === 0) {
            content.append('<div>There are no products</div>');

            return;
        }

        content.find('products-table').remove();
        content.append($('<table class="table products-table"></table>'));

        var productsTable = content.find('.products-table');
        var html = '';

        products.forEach(function (product) {
            if (product.image === '') {
                product.image = '/img/missing-image.png';
            }

            var btnName = page === 'index' ? 'Add to cart' : 'Remove from cart';

            html += '<tr>';
            html +=     '<td class="align-middle">';
            html +=         '<img src="' + product.image + '"' + ' alt="">';
            html +=     '</td>';
            html +=     '<td class="align-middle">';
            html +=         '<h5 class="font-weight-bold mb-2">' + product.title + '</h5>';
            html +=         '<div class="font-weight-normal mb-2">' + (product.description || '') + '</div>';
            html +=         '<div class="font-italic">' + product.price + '</div>';
            html +=     '</td>';
            html +=     '<td class="text-center align-middle to-center">';
            html +=         '<buttton class="btn btn-primary mr-2 product-btn" product="' + product.id + '">' + btnName + '</buttton>';
            html +=     '</td>';
            html += '</tr>';
        });

        productsTable.html(html);
    }

    /**
     * Create the button to navigate between the two pages based on the parameter passed
     *
     * @param page
     */
    function setNavigateBtn(page) {
        var goToBtn = page === 'index' ? 'Go to cart' : 'Show products';

        navigateBtn.append($('<button class="btn btn-primary index-cart-btn">' + goToBtn + '</button>'));
    }

    $(document).on('click', '.products-table .product-btn', function () {
        var prodId = $(this).attr('product');

        if (page === 'index') {
            addToCart(prodId);
        } else {
            removeFromCart(prodId);
        }
    });

    $(document).on('click', '.navigate-buttons .index-cart-btn', function () {
        if (page === 'index' ) {
            showCartPage();
        } else {
            showProductsPage();
        }
    });
});

