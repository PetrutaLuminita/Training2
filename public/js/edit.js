$(function () {

    if (window.location.href.indexOf('create') !== -1) {
        addOrEditProductForm();
    } else {
        let arr = window.location.href.split('/');
        let productId = arr[4];

        let match = window.location.href.match(/\/products\/(\d+)\/edit\//);

        console.log(match);

        getProductForEdit(productId);
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
     * Show the add/edit form
     *
     * @param product
     */
    function addOrEditProductForm(product) {
        let title = $('.admin-title-edit');
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

        $('.prod-title').val(productTitle);
        $('.description').val(productDesc);
        $('.price').val(productPrice);
        $('.image').attr('value', productImg);
        $('.product-btn').html(btnName);

        if (productImg !== '') {
            $('<img src="'+ productImg + '""><br><br>').insertBefore('.product-btn');
        } else {
            $('<div class="text-left">No image uploaded</div><br>').insertBefore('.product-btn');
        }

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
                        window.location.href = '/products';
                    }
                })
        });

        $('.back').click(function() {
            window.location.href = '/products';
        });
    }

});
