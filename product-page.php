<!DOCTYPE html>
<html lang="zxx">

<head>
<?php
    $title = "Product";
    include("./components/head.php");
?>
</head>

<body>
    <?php include("./components/header.php"); ?>

    <!-- Related Product Section Begin -->
    <section class="related-product spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="section-title">
                        <h2>Products</h2>
                    </div>
                </div>
            </div>
            <div class="row" id="productGridList"></div>
        </div>
    </section>
    <!-- Related Product Section End -->

    <?php include("./components/scripts.html"); ?>
    <script>
        document.addEventListener("DOMContentLoaded", loadProducts, false);

        function loadProducts() {
            let tracey = "https://traceywangweb.com/db/getProducts.php";
            let david = "http://mindcrunch.com/david/marketplace.php";
            let zan = "http://zanjavednow.tech/products";
            let sean = "https://laogeebai.com/products.php";
            let marketplaces = [tracey, david, zan, sean];

            marketplaces.forEach(function(url) {
                $.get(url, function(data) {
                    console.log(data);  // For debugging only
                    var row = document.querySelector("#productGridList");
                    data.forEach(function(product) {
                        var loc = new URL(url);
                        product.source = loc.hostname;
                        createProductPoster(row, product);
                    })
                })
                .fail(function() {
                    console.log("Failed to load product list for " + url);
                })
            })
        }

        function getRatings(productName) {
            // $.get("./db/getRatings.php", {'productName': productName}, function(data) {
            // // $.get("./db/getRatings.php", function(data) {
            //     // console.log(data)
            //     return data
            // }).fail(function() {
            //     console.log("Failed to load product ratings for " + url);
            //     return -1
            // })
            
            var result = {'rating': -1};
            $.ajax({
                url: "./db/getRatings.php",
                type: 'get',
                data: {'productName': productName},
                async: false,
                success: function(data) {
                   result = data;
                }
            });
            return result;
        }

        function updateRating(productName, value) {
            // console.log('updating')
            $.ajax({
                url: "./db/updateRatings.php",
                type: 'post',
                data: {'productName': productName, 'value': value}
            });
            // console.log('maybe updated')
        }

        function rate(positive, name) {
            var value = document.getElementById(name).innerHTML
            // var rating = JSON.parse(getRatings(name))
            // console.log(`RATINGS: ${rating}`)
            // console.log(rating["rating"])
            // console.log(rating.rating)
            if(positive) 
                value = parseInt(value) + 1
            else 
                value = parseInt(value) - 1
            
            document.getElementById(name).innerHTML = value.toString()
            updateRating(name, value)
            // getReview(name);
        }

        function getReview(productName) {
            var result = {'rating': -1};
            $.ajax({
                url: "./db/getReview.php",
                type: 'get',
                data: {'product': productName},
                async: false,
                success: function(data) {
                   result = data;
                }
            });
            // return result;
            // console.log(JSON.parse(result).join('\n'));
            // return result.join('\n');
            return JSON.parse(result).join('\n');
        }

        function createProductPoster(node, params) {
            params = params || {};
            var source = params.source;
            var name = params.productName;
            var price = params.price;
            var picture = params.picture;

            var outerContainer = document.createElement("div");
            outerContainer.setAttribute("class", "col-lg-3 col-sm-6");
            var innerContainer = document.createElement("div");
            innerContainer.setAttribute("class", "single-product-item");
            outerContainer.appendChild(innerContainer);
            var figure = document.createElement("figure");
            innerContainer.appendChild(figure);
            var img = document.createElement("img");
            img.src = picture;
            var link = document.createElement("a");
            var url = "./product_detail.php?";
            url += "source=" + source + "&";
            url += "productName=" + name + "&";
            url += "price=" + price + "&";
            url += "picture=" + picture;
            link.setAttribute("href", url);
            link.appendChild(img);
            figure.appendChild(link);
            var productDetail = document.createElement("div");
            productDetail.setAttribute("class", "product-text");
            innerContainer.appendChild(productDetail);
            var productName = document.createElement("h6");
            productName.innerHTML = name;
            productDetail.appendChild(productName);
            var productPrice = document.createElement("p");
            productDetail.appendChild(productPrice);
            productPrice.innerHTML = price;

            // var productRating = document.createElement("h7");
            // productRating.setAttribute("id", params.productName);
            // productDetail.appendChild(productRating);
            // productRating.innerHTML = JSON.parse(getRatings(params.productName))['rating'];

            // var productPlusBtn = document.createElement("button");
            // productPlusBtn.addEventListener('click', function() {
            //     rate(true, `${name}`);
            // });
            // productDetail.appendChild(productPlusBtn);
            // productPlusBtn.innerHTML = "+1";

            // var productMinusBtn = document.createElement("button");
            // productMinusBtn.addEventListener('click', function() {
            //     rate(false, `${name}`);
            // });
            // productDetail.appendChild(productMinusBtn);
            // productMinusBtn.innerHTML = "-1";

            // var productReview = document.createElement("textarea");
            // var reviewTitle = document.createElement("h6");
            // reviewTitle.innerHTML = "Look At Other Reviews!";
            // productDetail.appendChild(reviewTitle);
            // productReview.setAttribute("readonly", "yes");
            // productDetail.appendChild(productReview);
            // // productReview.innerHTML = "Anonymous: ";
            // productReview.innerHTML = getReview(params.productName);

            // var form = document.createElement("form");
            // var productReviewForm = document.createElement("textarea");
            // var productReviewBtn = document.createElement("input");
            // var productHidden = document.createElement("input");
            // var formTitle = document.createElement("h6");
            // formTitle.innerHTML = "Submit a Review!";
            // productHidden.setAttribute("type", "hidden");
            // productHidden.setAttribute("name", "product");
            // productHidden.setAttribute("value", params.productName);
            // productReviewForm.setAttribute("name","review");
            // productReviewBtn.setAttribute("type", "submit");
            // form.setAttribute("action","./db/updateReview.php");
            // form.setAttribute("name","productForm");
            // form.setAttribute("method", "post");
            // form.appendChild(productReviewForm);
            // form.appendChild(productReviewBtn);
            // form.appendChild(productHidden);
            // productDetail.appendChild(formTitle);
            // productDetail.appendChild(form);


            

            node.appendChild(outerContainer);
        }
    </script>
</body>

</html>
