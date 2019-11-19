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
        $.ajax({
            type:'GET',
            url:'/products/' + productId + '/delete'
        })
        .done(function(response) {
            showProductsPage();
        });
    }

    /**
     * Get the details of the selected product from the DB
     *
     * @param productId
     */
    function getProductForEdit(productId) {
        $.ajax({
            type:'GET',
            url:'/products/' + productId,
        })
        .done(function(product) {
            addOrEditProductForm(product);
        });
    }

    /**
     * Show the products listing
     *
     * @param products
     */
    function show(products) {
        let content = $('.content');
        let title = $('.admin-title');
        let productsTable = $('<table class="table all-products-table"></table>');

        title.html('All products');

        content.empty();
        content.append(productsTable);

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
                    '<div class="font-weight-normal mb-2">' + product.description + '</div>' +
                    '<div class="font-italic">' + product.price + '</div>' +
                '</td>' +
                '<td class="text-center align-middle to-center">' +
                    '<buttton class="btn btn-primary mr-2 mb-2 product-edit-btn" product="' + prodId + '">Edit</buttton>' +
                    '<buttton class="btn btn-primary product-delete-btn" product="' + prodId + '">Delete</buttton>' +
                '</td>'
            );

            productsTable.append(tableRow);
        });

        content.append('<button class="btn btn-primary mb-2 mr-2 product-add-btn">Add</button>');
        content.append('<a href="/logout" class="btn btn-primary mb-2">Logout</a>');

        $('.product-delete-btn').click(function() {
            let prodId = $(this).attr('product');
            deleteProduct(prodId);
        });

        $('.product-edit-btn').click(function() {
            let prodId = $(this).attr('product');
            getProductForEdit(prodId);
        });

        $('.product-add-btn').click(function() {
            addOrEditProductForm();
        });
    }

    /**
     * Show the add/edit form
     *
     * @param product
     */
    function addOrEditProductForm(product) {
        let content = $('.content');
        let title = $('.admin-title');

        title.empty();
        content.empty();

        content.append(
            '<div class="container mt-3">' +
                '<form method="POST" class="form" enctype="multipart/form-data"></form>' +
            '</div>'
        );

        let form = $('.form');

        let btnName = productTitle = productDesc = productPrice = productImg = productId = '';

        if (typeof product === "undefined") {
            title.empty();
            title.html('Add product');

            btnName = 'Add';
        } else {
            title.empty();
            title.html('Edit product');

            btnName = 'Update';
            productTitle = product.title;
            productDesc = product.description;
            productPrice = product.price;
            productImg = product.image;
            productId = product.id;

            form.append('<input type="hidden" name="_method" value="PUT">');
        }

        form.append(
            '<input class="input form-control mb-2" type="text" placeholder="Title" name="title" value="' + productTitle + '">' +
            '<textarea class="textarea form-control mb-2" placeholder="Description" name="description">' + productDesc + '</textarea>' +
            '<input class="input form-control" type="text" placeholder="Price" name="price" value="' + productPrice + '">' +
            '<input class="input form control text-left mb-2 mt-2" type="file" name="image" value="' + productImg + '"><br>' +
            '<button class="btn btn-primary product-btn">' + btnName + '</button>'
        );

        if (productImg !== '') {
            $('<img src="'+ productImg + '""><br><br>').insertBefore('.product-btn');
        } else {
            $('<div class="text-left">No image uploaded</div><br>').insertBefore('.product-btn');
        }

        content.append(
            '<div class="text-left">' +
                '<button class="btn btn-info ml-3 back">Go back</button>' +
            '</div>'
        );

        $('form').submit(function(e) {
            e.preventDefault();

            let token = $('[name="_token"]').val();
            let formData = new FormData(this);
            let url;

            if (productId === '') {
                url = '/products/create';
            } else {
                url = '/products/' + productId + '/edit';
            }

            $.ajax({
                url: url,
                type: 'post',
                data: formData,
                dataType: 'json',
                contentType: false,
                processData: false,
                headers: {
                    'X-CSRF-TOKEN': token
                }
            })
            .done(function(response) {
                if (response.error) {
                    response.error.forEach(function (error) {
                        let msg = $('<div class="alert alert-danger d-none"></div>');

                        if (error.indexOf('title') !== -1) {
                            $('input[name="title"]').after(msg);
                        }

                        if (error.indexOf('price') !== -1) {
                            $('input[name="price"]').after(msg);
                        }
                        msg.append(error);
                        msg.removeClass('d-none');
                        msg.css('background', '#FCAE9D');
                        msg.css('color', 'red');
                    })
                } else {
                    showProductsPage();
                }
            })
            .fail(function (response) {
            })
        });

        $('.back').click(function() {
            showProductsPage();
        });
    }
});
