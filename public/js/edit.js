$(function () {
    var productForm = $('.edit-product-form .form');
    var prodId = productForm.find('.with-token').attr('product');

    if (prodId !== '') {
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
        var btnName = productTitle = productDesc = productPrice = productImg = productId = '';

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
            productImg = product.image;
            productId = product.id;

            productForm.append('<input type="hidden" name="_method" value="PUT">');
        }

        productForm.find('.prod-title').val(productTitle);
        productForm.find('.prod-description').val(productDesc);
        productForm.find('.prod-price').val(productPrice);
        productForm.find('.prod-image').attr('value', productImg);
        productForm.find('.product-btn').html(btnName);

        var showImage;

        if (productImg !== '') {
            showImage = $('<img src="'+ productImg + '""><br><br>');
        } else {
            showImage = $('<div class="text-left">No image uploaded</div><br>');
        }

        showImage.insertBefore(productForm.find('.product-btn'));

        productForm.submit(function(e) {
            e.preventDefault();

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
            .done(function(response) {
                if (response.error) {
                    response.error.forEach(function (error) {
                        var msg = $('<div class="alert alert-danger d-none"></div>');

                        if (error.indexOf('title') !== -1) {
                            productForm.find('input[name="title"]').after(msg);
                        }

                        if (error.indexOf('price') !== -1) {
                            productForm.find('input[name="price"]').after(msg);
                        }

                        msg.append(error);
                        msg.removeClass('d-none');
                    })
                } else {
                    window.location.href = '/products';
                }
            })
        });

        $('.edit-product-form .back-to-products').click(function() {
            window.location.href = '/products';
        });
    }
});
