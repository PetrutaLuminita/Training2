$(function () {
    var divEditForm = $('.edit-product-form');
    var productForm = divEditForm.find('.form');
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
        btnSubmit.html(btnName).removeClass('d-none');

        if (productdImg !== '') {
            $('<img src="' + product.image + '"><br><br>').insertBefore(btnSubmit);
        }
    }

    divEditForm.find('.back-to-products').click(function() {
        window.location.href = '/products';
    });

    productForm.submit(function(e) {
        e.preventDefault();

        productForm.find('.err').empty();

        var token = productForm.find('[name="_token"]').val();
        var formData = new FormData(this);
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
            var responseObj = JSON.parse(response.responseText);
            var message = responseObj.message;
            var errors = responseObj.errors;

            divEditForm.find('.message-error').html(message).removeClass('d-none');

            if (errors) {
                for (var key in errors) {
                    errors[key].forEach(function (error) {
                        var divErrors = $('<div class="help-is-danger err">' + error + '</div>');

                        if (!divErrors.length || divErrors.val() !== error) {
                            divErrors.insertAfter(productForm.find('input[name="' + key + '"]'));
                        }
                    })
                }
            }
        })
    });
});
