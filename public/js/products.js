$(function () {

    showProductsPage();

    /**
     * Get all the products from the database
     */
    function showProductsPage() {
        $.ajax({
            type:'GET',
            url:'/get_all_products',
            dataType: 'json'
        })
        .done(function(products) {
            show(products);
        });
    }

    /**
     * Delete the selected product
     *
     * @param productId
     */
    function deleteProduct(productId) {
        let token = $('[name="_token"]').val();

        $.ajax({
            type:'DELETE',
            data: {
                "_token": token,
            },
            url:'/products/' + productId
        })
        .done(function() {
            showProductsPage();
        });
    }

    /**
     * Show the products listing
     *
     * @param products
     */
    function show(products) {
        let title = $('.admin-title');
        let productsTable = $('.all-products-table');

        title.html('All products');

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

            let tableRow = $('<tr>').append(
                '<td class="align-middle">' +
                    '<img src="' + product.image + '"' + ' alt="">' +
                '</td>' +
                '<td class="align-middle">' +
                    '<h5 class="font-weight-bold mb-2">' + product.title + '</h5>' +
                    '<div class="font-weight-normal mb-2">' + (product.description || '') + '</div>' +
                    '<div class="font-italic">' + product.price + '</div>' +
                '</td>' +
                '<td class="text-center align-middle to-center">' +
                    '<buttton class="btn btn-primary mr-2 product-edit-btn" product="' + prodId + '">Edit</buttton>' +
                    '<buttton class="btn btn-primary product-delete-btn" product="' + prodId + '">Delete</buttton>' +
                '</td>'
            );

            productsTable.append(tableRow);
        });

        $('.product-delete-btn').click(function() {
            let prodId = $(this).attr('product');
            deleteProduct(prodId);
        });

        $('.product-edit-btn').click(function() {
            let prodId = $(this).attr('product');
            window.location.href = '/products/' + prodId + '/edit/';
        });
    }
});
