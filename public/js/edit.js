$(function () {
    var productForm = $('.edit-product-form .form');
    var prodId = productForm.attr('product');

    if (prodId) {
        getProduct(prodId);
    } else {
        addOrEditProductForm();
    }

    /**
     * Get the details of the selected product from the DB
     *
     * @param productId
     */
    function getProduct(productId) {
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
        var title = $('.admin-title-edit');
        var btnName = productTitle = productDesc = productPrice = productdImg= productId = '';
        var btnSubmit = productForm.find('.product-btn');

        title.empty();

        if (typeof product === "undefined") {
            title.html('Add product');

            btnName = 'Add';
        } else {
            title.html('Edit product');

            btnName = 'Update';
            productTitle = product.title;
            productDesc = product.description;
            productPrice = product.price;
            productdImg = product.image;
            productId = product.id;
        }

        productForm.find('.prod-title').val(productTitle);
        productForm.find('.prod-description').val(productDesc);
        productForm.find('.prod-price').val(productPrice);
        btnSubmit.html(btnName);

        if (productdImg !== '') {
            $('<img src="' + product.image + '"><br><br>').insertBefore(btnSubmit);
        }

        btnSubmit.click(function(e) {
            e.preventDefault();

            var token = productForm.find('[name="_token"]').val();
            var formData = new FormData(productForm[0]);
            var url;

            if (productId === '') {
                url = '/products';
            } else {
                url = '/products/' + productId;
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
            .done(function () {
                window.location.href = '/products';
            })
            .fail(function(response) {
                var responseArray = JSON.parse(response.responseText);
                var errors = responseArray.errors;

                if (errors.title) {
                    productForm.find('.title-err')
                        .html(errors.title[0])
                        .removeClass('d-none');
                }

                if (errors.price) {
                    productForm.find('.price-err')
                        .html(errors.price[0])
                        .removeClass('d-none');
                }

                if (errors.description) {
                    productForm.find('.desc-err')
                        .html(errors.description[0])
                        .removeClass('d-none');
                }

                if (errors.image) {
                    productForm.find('.image-err')
                        .html(errors.image[0])
                        .removeClass('d-none');
                }
            })
        });

        $('.edit-product-form .back-to-products').click(function() {
            window.location.href = '/products';
        });
    }
});
