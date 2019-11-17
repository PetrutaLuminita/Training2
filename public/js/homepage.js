$(function () {
    let productsTable = $('.products-table');

    showProductsPage();

    function addToCart(productId) {
        $.ajax({
            type: 'GET',
            url: '/add_to_cart/' + productId,
        })
        .done(function() {
            $('tr[productRow="' + productId + '"]').remove();
        })
        .fail(function(error) {
            console.log(error);
        });
    }

    function removeFromCart(productId) {
        $.ajax({
            type:'GET',
            url:'/remove_from_cart/' + productId,
        })
        .done(function() {
            $('tr[productRow="' + productId + '"]').remove();
        })
        .fail(function(error) {
            console.log(error);
        });
    }

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

    function showCartPage() {
        $.ajax({
            type:'GET',
            url:'/cart',
            dataType: 'json'
        })
        .done(function(products) {
            show(products, 'cart');
        });
    }

    function show(products, page) {
        let title = $('.title');
        title.empty();

        if (page === 'index') {
            title.append('Products');
        } else {
            title.append('Cart');
        }
        productsTable.empty();

        $('button[changePage="1"]').remove();

        setChangeBtn(page);

        if (products.length === 0) {
            productsTable.append('<div>There are no products</div>');

            return;
        }

        products.forEach(function (product) {
            if (product.image === '') {
                product.image = '/img/missing-image.png';
            }

            const prodId = product.id;
            const btnName = page === 'index' ? 'Add to cart' : 'Remove from cart';

            let tableRow = $('<tr productRow="' + prodId + '">').append(
                '<td class="align-middle">' +
                    '<img src="' + product.image + '"' + ' alt="">' +
                '</td>' +
                '<td class="align-middle">' +
                    '<h5 class="font-weight-bold mb-2">' + product.title + '</h5>' +
                    '<div class="font-weight-normal mb-2">' + product.description + '</div>' +
                    '<div class="font-italic">' + product.price + '</div>' +
                '</td>' +
                '<td class="text-center align-middle to-center">' +
                    '<buttton class="btn btn-primary" productBtn="' + prodId + '">' + btnName + '</buttton>' +
                '</td>'
            );

            productsTable.append(tableRow);
        });

        $('[productBtn]').click(function() {
            let prodId = $(this).attr('productBtn');

            if (page === 'index') {
                addToCart(prodId);
            } else {
                removeFromCart(prodId);
            }
        });
    }

    function setChangeBtn(page) {
        const goToBtn = page === 'index' ? 'Go to cart' : 'Show products';

        productsTable.after($('<button class="btn btn-primary" changePage="1">' + goToBtn + '</button>'));

        $('button[changePage="1"]').click(function() {
            if (page === 'index' ) {
                showCartPage();
            } else {
                showProductsPage();
            }
        });
    }
});

