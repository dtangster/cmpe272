<!DOCTYPE html>
<html lang="zxx">

<head>
<?php
    $title = "Product Detail";
    include("./components/head.php");
    include("./db/getReview.php");
    include("./db/getRatings.php");

    $productName = $_GET["productName"];
    $price = $_GET["price"];
    $picture = $_GET["picture"];
    $source = $_GET["source"];

    $visits = &$_SESSION["visits"];
    if (!isset($visits[$source])) {
        $visits[$source] = array(
            "history" => array(),
            "top" => array()
        );
    }
    if (!isset($visits["all"])) {
        $visits["all"] = array(
            "history" => array(),
            "top" => array()
        );
    }

    $url_scheme = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
    $url = $url_scheme . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $stats = &$visits[$source];
    $global_stats = &$visits["all"];

    // Process history for last 5 visited for the specific marketplace
    $history = &$stats["history"];
    array_unshift($history, array($url => $productName));
    $history = array_unique($history, SORT_REGULAR);
    while (count($history) > 5) {
        array_pop($history);
    }

    // Process history for last 5 visited among all marketplaces
    $global_history = &$global_stats["history"];
    array_unshift($global_history, array($url => $productName));
    $global_history = array_unique($global_history, SORT_REGULAR);
    while (count($global_history) > 5) {
        array_pop($global_history);
    }

    // Process top 5 visited for the specific marketplace
    $top = &$stats["top"];
    if (!isset($top[$url])) {
        // We use the url as the key so that there are no collisions
        $top[$url] = array(1, $productName);
    } else {
        $top[$url][0]++;
    }
    arsort($top);

    // Process top 5 visited among all marketplaces
    $global_top = &$global_stats["top"];
    if (!isset($global_top[$url])) {
        // We use the url as the key so that there are no collisions
        $global_top[$url] = array(1, $productName);
    } else {
        $global_top[$url][0]++;
    }
    arsort($global_top);

    // Sort source keys. We intentionally called the "all" marketplace to represent the global
    // state since it will get sorted to the beginning.
    ksort($visits);

    // get all the reviews for this product
    $reviews = implode(getReviews($productName), "\n\n");
    $rating = getRatings($productName)['rating'];
?>
    <style>
        #product-section {
            padding-top: 50px;
        }
    </style>
</head>

<body>
    <?php include("./components/header.php"); ?>
    <div class="container" id="product-section">
        <div class="row">
            <div class="col-md-6 text-center">
                <img src=<?php echo $picture ?> class="image-responsive" />
            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-12">
                        <h3><?php echo $productName ?></h3>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <h3><?php echo $price ?></h3>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <!-- <h7 id=<?php echo $productName?>><?php echo $rating?></h7> -->
                        <!-- <h7 <?php echo "id=$productName"?>><?php echo $rating?></h7> -->
                        <h7 id=<?php echo json_encode($productName)?>><?php echo $rating?></h7>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <button id="+Btn" style="background-color: Transparent; border: none">
                            <i class="fa fa-thumbs-o-up fa-lg" aria-hidden="true"></i>
                        </button>
                        <button id="-Btn" style="background-color: Transparent; border: none">
                            <i class="fa fa-thumbs-o-down fa-lg" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <h6>Look At Other Reviews!</h6>
                        <textarea readonly="yes"><?php echo $reviews ?></textarea>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <h6>Submit a Review!</h6>
                        <form action="./db/updateReview.php", method="post">
                            <input hidden=true name="product" value=<?php echo $productName?>>
                            <input hidden=true name="source" value=<?php echo $source?>>
                            <input hidden=true name="price" value=<?php echo $price?>>
                            <input hidden=true name="picture" value=<?php echo $picture?>>
                            <textarea name="review"></textarea>
                            <input type="submit">
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php include("./components/scripts.html"); ?>

        <script>
            function updateRating(productName, value) {
                $.ajax({
                    url: "./db/updateRatings.php",
                    type: 'post',
                    data: {'productName': productName, 'value': value}
                });
            }

            function rate(positive, name) {
            // function rate(positive) {
                var value = document.getElementById(name).innerHTML
                // console.log(value)
                // var value = name.innerHTML
                // var value = document.getElementByName(<?php echo json_encode($productName)?>)
                if(positive) 
                    value = parseInt(value) + 1
                else 
                    value = parseInt(value) - 1
                
                document.getElementById(name).innerHTML = value.toString()
                // name.innerHTML = value.toString()
                updateRating(name, value)
                // // console.log(name.id);
                // updateRating(name.id, value);
            }
            document.getElementById("+Btn").addEventListener("click", function(){
                // rate(true, <?php echo $productName?>);
                rate(true, <?php echo json_encode($productName)?>);
                // rate(true);
            });

            document.getElementById("-Btn").addEventListener("click", function(){
                // rate(false, <?php echo $productName?>);
                rate(false, <?php echo json_encode($productName)?>);
                // rate(false);
            });
    </script>
</body>

</html>
