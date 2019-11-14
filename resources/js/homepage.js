$(function () {
    let $products_table = $('#products-table');

    showProductsPage();

    function addToCart(productId) {
        $.ajax({
            type:'GET',
            url:'/add_to_cart/' + productId
        })
        .done( function (response) {
            console.log(response)
        })
    }

    function removeFromCart(productId) {
        $.ajax({
            type:'GET',
            url:'/remove_from_cart/' + productId,
        })
        .done(function (response) {
            console.log(response)
        })
    }

    function showProductsPage() {
        $.ajax({
            type:'GET',
            url:'/get_products'
        })
        .done( function (products) {
            let page = 'index';
            show(products, page);
        });
    }

    function showCartPage() {
        $.ajax({
            type:'GET',
            url:'/cart'
        })
        .done( function (products) {
            let page = 'cart';
            show(products, page);
        });
    }

    function show(products, page) {
        $products_table.empty();
        $('#change-page').remove();

        if (products.length === 0) {
            $products_table.append(`
                <div>There are no products</div>
            `)
        }

        products.forEach(function (product) {
            if (product.image === '') {
                product.image = '/img/missing-image.png'
            }

            let $table_row = $('<tr>').append(`
                <td class="align-middle">
                    <img src="${product.image}" alt="-">
                </td>
                        
                <td class="align-middle">
                    <h5 class="font-weight-bold mb-2">${product.title}</h5>

                    <div class="font-weight-normal mb-2">${product.description}</div>

                    <div class="font-italic">${product.price}</div>
                </td>
            `);

            let $btn = $('<buttton class="btn btn-primary">')
                .html(page === 'index' ? 'Add to cart' : 'Remove from cart')
                .on('click', function () {
                    page === 'index' ? addToCart(product.id) : removeFromCart(product.id);
                    $table_row.remove();
            });

            $table_row.append($('<td class="text-center align-middle to-center">').append($btn));

            $products_table.append($table_row);
        });

        setChangeBtn(page);
    }

    function setChangeBtn(page) {
        $products_table.after($('<button id="change-page" class="btn btn-primary">')
            .html(page === 'index' ? "Go to cart" : 'Show products')
        );

        $('#change-page').on('click', function() {
            if (page === 'index' ) {
                showCartPage();
            } else {
                showProductsPage();
            }
        });
    }
});
