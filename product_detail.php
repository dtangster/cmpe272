<!DOCTYPE html>
<html lang="zxx">

<head>
<?php
    $title = "Product Detail";
    include("./components/head.php");
    include("./db/getReview.php");
    include("./db/getRatings.php");
    include("./db/mysql_connect.inc.php");

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

    // Fetch the existing reviews for this product
    $query = "SELECT email, date, rating, comment FROM review where url = ?";
    $statement = $conn->prepare($query);
    $statement->execute([$url]);
    $reviews = $statement->fetchAll();

    // Fetch the average rating for this product
    $query = "SELECT AVG(rating) FROM review where url = ?";
    $statement = $conn->prepare($query);
    $statement->execute([$url]);
    $row = $statement->fetch(PDO::FETCH_NUM);
    $average_rating = round($row[0]);

?>
    <style>
        #product-section {
            padding-top: 50px;
        }
    </style>

<script src="js/star-rating.min.js"></script>
<link href="css/star-rating.min.css" rel="stylesheet"/>
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
                    <?php
                        for ($i = 0; $i < $average_rating; $i++) {
                            echo '<i class="fa fa-star"></i>';
                        }
                        for ($i = $average_rating; $i < 5; $i++) {
                            echo '<i class="fa fa-star-o"></i>';
                        }
                    ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <h3><?php echo $price ?></h3>
                    </div>
                </div>
            </div>

            <div class="container-fluid p-4">
                <div class="card">
                    <?php
                        foreach ($reviews as $elem) {
                            echo '<div class="card-body">';
                            echo '<h5 class="card-title">';
                            echo $elem["date"] . " " . $elem["email"];
                            echo '</h5>';
                            echo '<h6 class="card-subtitle mb-2 text-muted">';
                            for ($i = 0; $i < $elem["rating"]; $i++) {
                                echo '<i class="fa fa-star"></i>';
                            }
                            for ($i = $elem["rating"]; $i < 5; $i++) {
                                echo '<i class="fa fa-star-o"></i>';
                            }
                            echo '</h6>';
                            echo $elem["comment"];
                            echo '</div>';
                        }
                    ?>
                </div>
            </div>
<?php
if (isset($_SESSION["email"])) {
echo <<< EOT
            <div class="container-fluid">
                <div class="card">
                    <h6>Submit a Review!</h6>
                    <form action="./db/updateReview2.php", method="post">
                        <input name="product_name" type="hidden" value="$productName">
                        <select name="rating" class="star-rating testChange">
                            <option value="1"></option>
                            <option value="2"></option>
                            <option value="3"></option>
                            <option value="4"></option>
                            <option value="5"></option>
                        </select>
                        <textarea name="comment" class="container-fluid"></textarea>
                        <input type="submit">
                    </form>
                </div>
            </div>
EOT;
}
?>
        </div>
        <?php include("./components/scripts.html"); ?>

        <script>
            let starRatingControl = new StarRating('.star-rating', {
                maxStars: 5,
                showText: false,
            });
        </script>
</body>

</html>
