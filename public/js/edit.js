$(function () {
    var productForm = $('.edit-product-form .form');
    var prodId = productForm.attr('product');

    console.log(prodId);

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

        $('.edit-product-form .back-to-products').click(function() {
            window.location.href = '/products';
        });
    }
});
