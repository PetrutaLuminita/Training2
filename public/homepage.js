function getProducts() {
    var products;
    $.ajax({
        type:'GET',
        url:'/get_products',
        data: {products : products}
    })
        .done({
            function: function (response) {
                return response[1];
            }
        });
}
