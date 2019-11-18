$(function () {

    showProductsPage();

    function showProductsPage() {
        $.ajax({
            type:'GET',
            url:'/get_all_products',
            dataType: 'json'
        })
        .done(function(products) {
            show(products, 'index');
        });
    }

    function deleteProduct(productId) {
        $.ajax({
            type:'GET',
            url:'/products/' + productId + '/delete'
        })
        .done(function(response) {
            showProductsPage();
        });
    }

    function show(products, page) {
        let content = $('.content');

        content.empty();
        content.append('<table class="table all-products-table"></table>');

        let productsTable = $('.all-products-table');
        let title = $('.admin-title');

        title.empty();

        if (page === 'index') {
            title.append('All products');
        }

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
                    '<buttton class="btn btn-primary mr-2" productEditBtn="' + prodId + '">Edit</buttton>' +
                    '<buttton class="btn btn-primary" productDeleteBtn="' + prodId + '">Delete</buttton>' +
                '</td>'
            );

            productsTable.append(tableRow);
        });

        content.append('<button class="btn btn-primary mb-2 mr-2" productAddBtn>Add</button>');
        content.append('<a href="/logout" class="btn btn-primary mb-2">Logout</a>');

        $('[productDeleteBtn]').click(function() {
            let prodId = $(this).attr('productDeleteBtn');
            deleteProduct(prodId);
        });

        $('[productEditBtn]').click(function() {
            let prodId = $(this).attr('productEditBtn');
            editProductForm(prodId);
        });

        $('[productAddBtn]').click(function() {
            addProductForm();
        });

    }

    function editProductForm(productId) {
        let content = $('.content');

        content.empty();
        content.append('<div class="container mt-3"><form method="POST" action="" class="form-group" enctype="multipart/form-data"></form></div>');

        let form = $('form');

        $('.admin-title').append('Edit product');

    }

    function addProductForm() {
        let content = $('.content');
        let title = $('.admin-title');

        title.empty();
        content.empty();

        content.append(
            '<div class="container mt-3">' +
                '<form method="POST" enctype="multipart/form-data"></form>' +
            '</div>'
        );

        let form = $('form');

        title.append('Add product');

        form.append(
            '<input class="input form-control mb-2" type="text" placeholder="Title" name="title">' +
            '<textarea class="textarea form-control mb-2" placeholder="Description" name="description"></textarea>' +
            '<input class="input form-control" type="text" placeholder="Price" name="price">' +
            '<input class="input form control text-left mb-2 mt-2" type="file" name="image"><br>' +
            '<button class="btn btn-primary" add-product>Add</button>'
        );

        content.append(
            '<div class="text-left">' +
                '<button class="btn btn-info ml-3" back>Go back</button>' +
            '</div>'
        );

        $('form').submit(function(e) {
            e.preventDefault();

            let token = $('[name="_token"]').val();
            let formData = new FormData(this);

            $.ajax({
                url: '/products/create',
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
                console.log(response);
            })
            .fail(function (response) {
                console.log(response);
            })
        });

        $('[back]').click(function() {
            showProductsPage();
        });
    }


});
