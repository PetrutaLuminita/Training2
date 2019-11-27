$(function () {
    var content = $('.products-listing');

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
        var token = content.find('[name="_token"]').val();

        $.ajax({
            type:'DELETE',
            data: {
                _token: token
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
        var title = $('.admin-title');

        title.html('All products');

        if (products.length === 0) {
            content.append('<div>There are no products</div>');

            return;
        }

        content.find('.all-products-table').remove();
        content.append($('<table class="table all-products-table"></table>'));

        var productsTable = content.find('.all-products-table');
        var html;

        products.forEach(function (product) {
            if (product.image === '') {
                product.image = '/img/missing-image.png';
            }

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
            html +=         '<buttton class="btn btn-primary mr-2 product-edit-btn" product="' + product.id + '">Edit</buttton>';
            html +=         '<buttton class="btn btn-primary product-delete-btn" product="' + product.id + '">Delete</buttton>';
            html +=     '</td>';
            html += '</tr>';
        });

        productsTable.html(html);
    }

    $(document).on('click', '.all-products-table .product-delete-btn', function () {
        var prodId = $(this).attr('product');
        deleteProduct(prodId);
    });

    $(document).on('click', '.all-products-table .product-edit-btn', function () {
        var prodId = $(this).attr('product');
        window.location.href = '/products/' + prodId + '/edit/';
    });
});
