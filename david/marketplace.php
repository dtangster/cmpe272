<?php

    $products = array(
        array("productName" => "CPU",
              "description" => "Some used CPU",
              "picture" => "http://mindcrunch.com/david/static/resource/cpu.jpg",
	      "price" => "$299.00"),
        array("productName" => "Mouse",
              "description" => "Some used mouse",
              "picture" => "http://mindcrunch.com/david/static/resource/mouse.jpg",
	      "price" => "$25.00"),
        array("productName" => "Motherboard",
              "description" => "Some used motherboard",
              "picture" => "http://mindcrunch.com/david/static/resource/motherboard.jpg",
	      "price" => "$249.00"),
        array("productName" => "Keyboard",
              "description" => "Some used keyboard",
              "picture" => "http://mindcrunch.com/david/static/resource/keyboard.jpg",
	      "price" => "$89.00"),
        array("productName" => "Memory",
              "description" => "Some used memory",
              "picture" => "http://mindcrunch.com/david/static/resource/memory.jpg",
	      "price" => "$160.00"),
        array("productName" => "Monitor",
              "description" => "Some used montor",
              "picture" => "http://mindcrunch.com/david/static/resource/monitor.jpg",
	      "price" => "$459.00"),
        array("productName" => "Router",
              "description" => "Some used router",
              "picture" => "http://mindcrunch.com/david/static/resource/router.jpg",
	      "price" => "$120.00"),
        array("productName" => "Storage",
              "description" => "Some used storage",
              "picture" => "http://mindcrunch.com/david/static/resource/storage.jpg",
	      "price" => "$219.00"),
        array("productName" => "Cable",
              "description" => "Some used cable",
              "picture" => "http://mindcrunch.com/david/static/resource/cable.jpg",
	      "price" => "$24.00"),
        array("productName" => "Software",
              "description" => "Some used software",
              "picture" => "http://mindcrunch.com/david/static/resource/software.jpg",
	      "price" => "$17.00"),
    );

    header("Access-Control-Allow-Origin: *");
    header('Content-Type: application/json');
    print(json_encode($products));
?>
