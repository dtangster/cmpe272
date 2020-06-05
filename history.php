<!DOCTYPE html>
<html lang="zxx">

<head>
<?php
    $title = "History";
    include("./components/head.php");
    include("./db/mysql_connect.inc.php");

    // Get top 5 highest average rating among all products and marketplaces
    $sql = "SELECT product_name, source, url, AVG(rating) AS average_rating
            FROM review
            GROUP BY source, url, product_name
            ORDER BY average_rating DESC
            LIMIT 5";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $global_top_ratings = $stmt->fetchAll();

    // Get unique marketplaces that have had a review
    $sql = "SELECT DISTINCT(source) from review";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $reviewed_markets = $stmt->fetchAll(PDO::FETCH_COLUMN);

    // Get top 5 average ratings for products from each marketplace
    $top_ratings = array();
    foreach ($reviewed_markets as $market) {
        $sql = "SELECT product_name, source, url, AVG(rating) AS average_rating
                FROM review
                WHERE source = ?
                GROUP BY source, url, product_name
                ORDER BY average_rating DESC
                LIMIT 5";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$market]);
        $top_ratings[$market] = $stmt->fetchAll();
    }

    // Get top 5 products based on the # of reviews among all marketplaces
    $sql = "SELECT product_name, source, url, AVG(rating) AS average_rating, COUNT(url) as count
            FROM review
            GROUP BY source, url, product_name
            ORDER BY count DESC
            LIMIT 5";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $global_most_reviews = $stmt->fetchAll();

    // Get top 5 products based on the # of reviews from each marketplace
    $most_reviews = array();
    foreach ($reviewed_markets as $market) {
        $sql = "SELECT product_name, source, url, AVG(rating) AS average_rating, COUNT(url) as count
                FROM review
                WHERE source = ?
                GROUP BY source, url, product_name
                ORDER BY count DESC
                LIMIT 5";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$market]);
        $most_reviews[$market] = $stmt->fetchAll();
    }
?>
</head>

<body>
<?php
    include("./components/header.php");
    include("./components/scripts.html");

    // Show the top 5 rated products among all marketplaces
    echo "<br /><b>Top 5 rated products among all marketplaces</b><br />";
    foreach($global_top_ratings as $data) {
        $product_name = $data["product_name"];
        $source = $data["source"];
        $url = $data["url"];
        $average_rating = $data["average_rating"];

        echo "<a href=$url>$product_name</a> ";
        for ($i = 0; $i < 5; $i++) {
            if ($i < $average_rating) {
                echo '<i class="fa fa-star"></i>';
            } else {
                echo '<i class="fa fa-star-o"></i>';
            }
        }
        echo " $source";
        echo '<br />';
    }

    // Show the top 5 rated products for each marketplace
    foreach ($top_ratings as $source => $data) {
        echo "<br /><b>Top 5 rated products from $source</b><br />";
        foreach ($data as $elem) {
            $product_name = $elem["product_name"];
            $url = $elem["url"];
            $average_rating = $elem["average_rating"];

            echo "<a href=$url>$product_name</a> ";
            for ($i = 0; $i < 5; $i++) {
                if ($i < $average_rating) {
                    echo '<i class="fa fa-star"></i>';
                } else {
                    echo '<i class="fa fa-star-o"></i>';
                }
            }
            echo '<br />';
        }
    }

    // Get top 5 products based on the # of reviews among all marketplaces
    echo "<br /><b>Top 5 most reviewed products among all marketplaces</b><br />";
    foreach ($global_most_reviews as $data) {
        $product_name = $data["product_name"];
        $source = $data["source"];
        $url = $data["url"];
        $average_rating = $data["average_rating"];
        $count = $data["count"];

        echo "<a href=$url>$product_name</a> ";
        for ($i = 0; $i < 5; $i++) {
            if ($i < $average_rating) {
                echo '<i class="fa fa-star"></i>';
            } else {
                echo '<i class="fa fa-star-o"></i>';
            }
        }
        echo " $source Review count: $count";
        echo '<br />';
    }

    // Get top 5 products based on the # of reviews from each marketplace
    foreach ($most_reviews as $source => $data) {
        echo "<br /><b>Top 5 most reviewed products from $source</b><br />";
        foreach ($data as $elem) {
            $product_name = $elem["product_name"];
            $url = $elem["url"];
            $average_rating = $elem["average_rating"];
            $count = $elem["count"];

            echo "<a href=$url>$product_name</a> ";
            for ($i = 0; $i < 5; $i++) {
                if ($i < $average_rating) {
                    echo '<i class="fa fa-star"></i>';
                } else {
                    echo '<i class="fa fa-star-o"></i>';
                }
            }
            echo " Review count: $count";
            echo '<br />';
        }
    }

    foreach ($_SESSION["visits"] as $source => $data) {
        // Show the last 5 visited products for specific marketplace
        echo "<br /><b>Last 5 products you viewed from $source</b><br />";
        foreach ($data["history"] as $elem) {
            foreach ($elem as $url => $product_name) {
                echo "<a href=$url>$product_name</a><br />";
            }
        }

        // Show the top 5 visited for specific marketplace
        $i = 0;
        echo "<br /><b>Top 5 products you viewed from $source</b><br />";
        foreach ($data["top"] as $url => $elem) {
            if ($i == 5) {
                break;
            }
            echo "<a href=$url>$elem[1]</a> views = $elem[0]<br />";
            $i++;
        }
    }
?>
</body>

</html>
