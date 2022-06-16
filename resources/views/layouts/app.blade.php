<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link href="https://fonts.googleapis.com/css?family=Work+Sans:300,400,500,600,700&amp;amp;subset=latin-ext" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('theme/fonts/Linearicons/Font/demo-files/demo.css') }}">    
    <link rel="stylesheet" href="{{ asset('theme/plugins/bootstrap/css/bootstrap.min.css') }} ">
    <link rel="stylesheet" href="{{ asset('theme/plugins/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('theme/plugins/jquery-bar-rating/dist/themes/fontawesome-stars.css') }}">
    <link rel="stylesheet" href="{{ asset('theme/plugins/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('theme/plugins/owl-carousel/assets/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('theme/plugins/slick/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('theme/plugins/lightGallery/dist/css/lightgallery.min.css') }}">
    <link rel="stylesheet" href="{{ asset('theme/css/style.css') }} ">    
</head>
<body>
    
    <header class="header">
        <div class="ps-top-bar">
            <div class="container">
                <div class="top-bar">
                    <div class="top-bar__left">
                        <ul class="nav-top">
                            <li class="nav-top-item"> <a class="nav-top-link" href="#">Sell on Famart.</a>
                            </li>
                            <li class="nav-top-item"> <a class="nav-top-link text-success" href="#">Register Now</a>
                            </li>
                        </ul>
                    </div>
                    <div class="top-bar__right">
                        <ul class="nav-top">
                            <li class="nav-top-item contact"><a class="nav-top-link" href="tel:970978-6290"> <i class="icon-telephone"></i><span>Hotline:</span><span class="text-success font-bold">970 978-6290</span></a></li>
                            <li class="nav-top-item"><a class="nav-top-link" href="order-tracking.html">Order Tracking</a></li>
                            <li class="nav-top-item languages"><a class="nav-top-link" href="javascript:void(0);"> <span class="current-languages">English</span><i class="icon-chevron-down"></i></a>
                                <div class="select--dropdown">
                                    <ul class="select-languages">
                                        <li class="active language-item" data-value="English"><a href="javascript:void(0);">English</a></li>
                                        <li class="language-item" data-value="Brunei"><a href="javascript:void(0);">Brunei</a></li>
                                        <li class="language-item" data-value="Armenia"><a href="javascript:void(0);">Armenia</a></li>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-top-item currency"><a class="nav-top-link" href="javascript:void(0);"> <span class="current-currency">USD</span><i class="icon-chevron-down"></i></a>
                                <div class="select--dropdown">
                                    <ul class="select-currency">
                                        <li class="active currency-item" data-value="USD"><a href="javascript:void(0);">USD</a></li>
                                        <li class="currency-item" data-value="VND"><a href="javascript:void(0);">VND</a></li>
                                        <li class="currency-item" data-value="EUR"><a href="javascript:void(0);">EUR</a></li>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-top-item account"><a class="nav-top-link" href="javascript:void(0);"> <i class="icon-user"></i>Hi! <span class="font-bold">Jonhnathan</span></a>
                                <div class="account--dropdown">
                                    <div class="account-anchor">
                                        <div class="triangle"></div>
                                    </div>
                                    <div class="account__content">
                                        <ul class="account-list">
                                            <li class="title-item"> <a href="javascript:void(0);">My Account</a>
                                            </li>
                                            <li> <a href="#">Dasdboard</a>
                                            </li>
                                            <li> <a href="#">Account Setting</a>
                                            </li>
                                            <li> <a href="shopping-cart.html">Orders</a>
                                            </li>
                                            <li> <a href="wishlist.html">Wishlist</a>
                                            </li>
                                            <li> <a href="#">Shipping Address</a>
                                            </li>
                                        </ul>
                                        <hr>
                                        <ul class="account-list">
                                            <li class="title-item"> <a href="javascript:void(0);">Vendor Settings</a>
                                            </li>
                                            <li> <a href="#">Dasdboard</a>
                                            </li>
                                            <li> <a href="#">Products</a>
                                            </li>
                                            <li> <a href="shopping-cart.html">Orders</a>
                                            </li>
                                            <li> <a href="#">Settings</a>
                                            </li>
                                            <li> <a href="vendor-store.html">View Store</a>
                                            </li>
                                        </ul>
                                        <hr><a class="account-logout" href="#"><i class="icon-exit-left"></i>Log out</a>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="ps-header--center header--mobile">
            <div class="container">
                <div class="header-inner">
                    <div class="header-inner__left">
                        <button class="navbar-toggler"><i class="icon-menu"></i></button>
                    </div>
                    <div class="header-inner__center"><a class="logo open" href="index.html">Farm<span class="text-black">art.</span></a></div>
                    <div class="header-inner__right">
                        <button class="button-icon icon-sm search-mobile"><i class="icon-magnifier"></i></button>
                    </div>
                </div>
            </div>
        </div>
        <section class="ps-header--center header-desktop">
            <div class="container">
                <div class="header-inner">
                    <div class="header-inner__left"><a class="logo" href="index.html">Eco<span class="text-black">farm.</span></a>
                        <ul class="menu">
                            <li class="menu-item-has-children has-mega-menu">
                                <button class="category-toggler"><i class="icon-menu"></i></button>
                                <div class="mega-menu mega-menu-category">
                                    <ul class="menu--mobile menu--horizontal">
                                        <li class="daily-deals category-item"> <a href="flash-sale.html">Daily Deals</a>
                                        </li>
                                        <li class="category-item"> <a href="shop-categories.html">Top Promotions</a>
                                        </li>
                                        <li class="category-item"> <a class="active" href="shop-categories.html">New Arrivals</a>
                                        </li>
                                        <li class="has-mega-menu category-item"><a href="javascript:void(0);">Fresh</a><span class="sub-toggle"><i class="icon-chevron-down"></i></span>
                                            <div class="mega-menu">
                                                <div class="mega-anchor"></div>
                                                <div class="mega-menu__column">
                                                    <h4>Fruit<span class="sub-toggle"></span></h4>
                                                    <ul class="sub-menu--mega">
                                                        <li> <a href="shop-view-grid.html">Apples</a>
                                                        </li>
                                                        <li> <a href="shop-view-grid.html">Bananas</a>
                                                        </li>
                                                        <li> <a href="shop-view-grid.html">Berries</a>
                                                        </li>
                                                        <li> <a href="shop-view-grid.html">Oranges & Easy Peelers</a>
                                                        </li>
                                                        <li> <a href="shop-view-grid.html">Grapes</a>
                                                        </li>
                                                        <li> <a href="shop-view-grid.html">Lemons & Limes</a>
                                                        </li>
                                                        <li> <a href="shop-view-grid.html">Peaches & Nectarines</a>
                                                        </li>
                                                        <li> <a href="shop-view-grid.html">Pears</a>
                                                        </li>
                                                        <li> <a href="shop-view-grid.html">Melon</a>
                                                        </li>
                                                        <li> <a href="shop-view-grid.html">Avocados</a>
                                                        </li>
                                                        <li> <a href="shop-view-grid.html">Plums & Apricots</a>
                                                        </li>
                                                        <li class="see-all"> <a href="shop-view-grid.html">See all products <i class='icon-chevron-right'></i></a>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="mega-menu__column">
                                                    <h4>Vegetables<span class="sub-toggle"></span></h4>
                                                    <ul class="sub-menu--mega">
                                                        <li> <a href="shop-view-grid.html">Potatoes</a>
                                                        </li>
                                                        <li> <a href="shop-view-grid.html">Carrots & Root Vegetables</a>
                                                        </li>
                                                        <li> <a href="shop-view-grid.html">Broccoli & Cauliflower</a>
                                                        </li>
                                                        <li> <a href="shop-view-grid.html">Cabbage, Spinach & Greens</a>
                                                        </li>
                                                        <li> <a href="shop-view-grid.html">Onions, Leeks & Garlic</a>
                                                        </li>
                                                        <li> <a href="shop-view-grid.html">Mushrooms</a>
                                                        </li>
                                                        <li> <a href="shop-view-grid.html">Tomatoes</a>
                                                        </li>
                                                        <li> <a href="shop-view-grid.html">Beans, Peas & Sweetcom</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="has-mega-menu category-item"><a href="javascript:void(0);">Food Cupboard</a><span class="sub-toggle"><i class="icon-chevron-down"></i></span>
                                            <div class="mega-menu">
                                                <div class="mega-anchor"></div>
                                                <div class="mega-menu__column">
                                                    <h4>Crisps, Snacks &amp; Nuts<span class="sub-toggle"></span></h4>
                                                    <ul class="sub-menu--mega">
                                                        <li> <a href="shop-view-grid.html">Crisps & Popcorn</a>
                                                        </li>
                                                        <li> <a href="shop-view-grid.html">Nuts & Seeds</a>
                                                        </li>
                                                        <li> <a href="shop-view-grid.html">Lighter Options</a>
                                                        </li>
                                                        <li> <a href="shop-view-grid.html">Cereal Bars</a>
                                                        </li>
                                                        <li> <a href="shop-view-grid.html">Breadsticks & Pretzels</a>
                                                        </li>
                                                        <li> <a href="shop-view-grid.html">Fruit Snacking</a>
                                                        </li>
                                                        <li> <a href="shop-view-grid.html">Rice & Corn Cakes</a>
                                                        </li>
                                                        <li> <a href="shop-view-grid.html">Protein & Energy Snacks</a>
                                                        </li>
                                                        <li> <a href="shop-view-grid.html">Toddler Snacks</a>
                                                        </li>
                                                        <li> <a href="shop-view-grid.html">Meat Snacks</a>
                                                        </li>
                                                        <li> <a href="shop-view-grid.html">Beans</a>
                                                        </li>
                                                        <li> <a href="shop-view-grid.html">Lentils</a>
                                                        </li>
                                                        <li> <a href="shop-view-grid.html">Chickpeas</a>
                                                        </li>
                                                        <li class="see-all"> <a href="shop-view-grid.html">See all products <i class='icon-chevron-right'></i></a>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="mega-menu__column">
                                                    <h4>Tins &amp; Cans<span class="sub-toggle"></span></h4>
                                                    <ul class="sub-menu--mega">
                                                        <li> <a href="shop-view-grid.html">Tomatoes</a>
                                                        </li>
                                                        <li> <a href="shop-view-grid.html">Baked Beans, Spaghetti</a>
                                                        </li>
                                                        <li> <a href="shop-view-grid.html">Fish</a>
                                                        </li>
                                                        <li> <a href="shop-view-grid.html">Beans & Pulses</a>
                                                        </li>
                                                        <li> <a href="shop-view-grid.html">Fruit</a>
                                                        </li>
                                                        <li> <a href="shop-view-grid.html">Caconut Milk & Cream</a>
                                                        </li>
                                                        <li> <a href="shop-view-grid.html">Lighter Options</a>
                                                        </li>
                                                        <li> <a href="shop-view-grid.html">Olives</a>
                                                        </li>
                                                        <li> <a href="shop-view-grid.html">Sweetcorn</a>
                                                        </li>
                                                        <li> <a href="shop-view-grid.html">Carrots</a>
                                                        </li>
                                                        <li> <a href="shop-view-grid.html">Peas</a>
                                                        </li>
                                                        <li> <a href="shop-view-grid.html">Mixed Vegetables</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="mega-menu__column"><a class="mega-menu__thumbnail" href="flash-sale.html"><img src="{{asset('theme/img/promotion/mega_food.jpg')}}" alt="alt" /></a>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="category-item"> <a href="shop-categories.html">Bakery</a>
                                        </li>
                                        <li class="category-item"> <a href="shop-categories.html">Frozen Foods</a>
                                        </li>
                                        <li class="has-mega-menu category-item"><a href="javascript:void(0);">Ready Meals</a><span class="sub-toggle"><i class="icon-chevron-down"></i></span>
                                            <div class="mega-menu">
                                                <div class="mega-anchor"></div>
                                                <div class="mega-menu__column">
                                                    <h4>Ready Meals<span class="sub-toggle"></span></h4>
                                                    <ul class="sub-menu--mega">
                                                        <li> <a href="#">Meals for 1</a>
                                                        </li>
                                                        <li> <a href="#">Meals for 2</a>
                                                        </li>
                                                        <li> <a href="#">Indian</a>
                                                        </li>
                                                        <li> <a href="#">Italian</a>
                                                        </li>
                                                        <li> <a href="#">Chinese</a>
                                                        </li>
                                                        <li> <a href="#">Traditional British</a>
                                                        </li>
                                                        <li> <a href="#">Thai & Oriental</a>
                                                        </li>
                                                        <li> <a href="#">Mediterrancan & Moroccan</a>
                                                        </li>
                                                        <li> <a href="#">Mexican & Caribbean</a>
                                                        </li>
                                                        <li> <a href="#">Lighter Meals</a>
                                                        </li>
                                                        <li> <a href="#">Lunch & Veg Pots</a>
                                                        </li>
                                                        <li class="see-all"> <a href="#">See all products <i class='icon-chevron-right'></i></a>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="mega-menu__column">
                                                    <h4>Salad &amp; Herbs<span class="sub-toggle"></span></h4>
                                                    <ul class="sub-menu--mega">
                                                        <li> <a href="#">Salad Bags</a>
                                                        </li>
                                                        <li> <a href="#">Cucumber</a>
                                                        </li>
                                                        <li> <a href="#">Tomatoes</a>
                                                        </li>
                                                        <li> <a href="#">Lettuce</a>
                                                        </li>
                                                        <li> <a href="#">Lunch Salad Bowls</a>
                                                        </li>
                                                        <li> <a href="#">Fresh Herbs</a>
                                                        </li>
                                                        <li> <a href="#">Avccados</a>
                                                        </li>
                                                        <li> <a href="#">Peppers</a>
                                                        </li>
                                                        <li> <a href="#">Coleslaw & Potato Salad</a>
                                                        </li>
                                                        <li> <a href="#">Spring Onions</a>
                                                        </li>
                                                        <li> <a href="#">Chili, Ginger & Ganic</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="mega-menu__column"><a class="mega-menu__thumbnail" href="flash-sale.html"><img src="{{asset('theme/img/promotion/mega_ready.jpg')}}" alt="alt" /></a>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="category-item"> <a href="shop-categories.html">Drinks, Tea & Coffee</a>
                                        </li>
                                        <li class="category-item"> <a href="shop-categories.html">Beer, Wine & Spirits</a>
                                        </li>
                                        <li class="category-item"> <a href="shop-categories.html">Baby & Child</a>
                                        </li>
                                        <li class="category-item"> <a href="shop-categories.html">Kitchen & Dining</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="header-inner__center">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="header-search-select"><span class="current">All<i class="icon-chevron-down"></i></span>
                                    <ul class="list">
                                        <li class="category-option active" data-value="option"><a href="javascript:void(0);">All</a></li>
                                        <li class="category-option"><a>Fresh</a><span class="sub-toggle"><i class="icon-chevron-down"></i></span>
                                            <ul>
                                                <li> <a href="#">Meat & Poultry</a>
                                                </li>
                                                <li> <a href="#">Fruit</a>
                                                </li>
                                                <li> <a href="#">Vegetables</a>
                                                </li>
                                                <li> <a href="#">Milks, Butter & Eggs</a>
                                                </li>
                                                <li> <a href="#">Fish</a>
                                                </li>
                                                <li> <a href="#">Frozen</a>
                                                </li>
                                                <li> <a href="#">Cheese</a>
                                                </li>
                                                <li> <a href="#">Pasta & Sauce</a>
                                                </li>
                                            </ul>
                                        </li>
                                        <li class="category-option"><a>Food Cupboard</a><span class="sub-toggle"><i class="icon-chevron-down"></i></span>
                                            <ul>
                                                <li> <a href="#">Crisps, Snacks & Nuts</a>
                                                </li>
                                                <li> <a href="#">Breakfast Cereals</a>
                                                </li>
                                                <li> <a href="#">Tins & Cans</a>
                                                </li>
                                                <li> <a href="#">Chocolate & Sweets</a>
                                                </li>
                                            </ul>
                                        </li>
                                        <li class="category-option" data-value="Bakery"><a href="javascript:void(0);">Bakery</a></li>
                                        <li class="category-option" data-value="Drinks, Tea &amp; Coffee"><a href="javascript:void(0);">Drinks, Tea &amp; Coffee</a></li>
                                        <li class="category-option" data-value="Frozen Foods"><a href="javascript:void(0);">Frozen Foods</a></li>
                                        <li class="category-option"><a>Ready Meals</a><span class="sub-toggle"><i class="icon-chevron-down"></i></span>
                                            <ul>
                                                <li> <a href="#">Traditional British</a>
                                                </li>
                                                <li> <a href="#">Indian</a>
                                                </li>
                                                <li> <a href="#">Italian</a>
                                                </li>
                                                <li> <a href="#">Chinese</a>
                                                </li>
                                            </ul>
                                        </li>
                                        <li class="category-option" data-value="Beer, Wine &amp; Spirits"><a href="javascript:void(0);">Beer, Wine &amp; Spirits</a></li>
                                        <li class="category-option" data-value="Baby &amp; Child"><a href="javascript:void(0);">Baby &amp; Child</a></li>
                                        <li class="category-option" data-value="Kitchen &amp; Dining"><a href="javascript:void(0);">Kitchen &amp; Dining</a></li>
                                    </ul>
                                </div><i class="icon-magnifier search"></i>
                            </div>
                            <input class="form-control input-search" placeholder="I'm searchching for...">
                            <div class="input-group-append">
                                <button class="btn">Search</button>
                            </div>
                        </div>
                        <div class="trending-search">
                            <ul class="list-trending">
                                <li class="title"> <a>Trending search: </a>
                                </li>
                                <li class="trending-item"> <a href="#">meat</a>
                                </li>
                                <li class="trending-item"> <a href="#">fruit</a>
                                </li>
                                <li class="trending-item"> <a href="#">vegetables</a>
                                </li>
                                <li class="trending-item"> <a href="#">salad</a>
                                </li>
                                <li class="trending-item"> <a href="#">yoghurts</a>
                                </li>
                                <li class="trending-item"> <a href="#">apple</a>
                                </li>
                            </ul>
                        </div>
                        <div class="result-search">
                            <ul class="list-result">
                                <li class="cart-item">
                                    <div class="ps-product--mini-cart"><a href="product-default.html"><img class="ps-product__thumbnail" src="{{asset('theme/img/products/01-Fresh/01_18a.jpg')}}" alt="alt" /></a>
                                        <div class="ps-product__content"><a class="ps-product__name" href="product-default.html"><u>Organic</u> Large Green Bell Pepper</a>
                                            <p class="ps-product__rating">
                                                <select class="rating-stars">
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3" selected="selected">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>
                                                </select><span>(5)</span>
                                            </p>
                                            <p class="ps-product__meta"> <span class="ps-product__price">$6.90</span>
                                            </p>
                                        </div>
                                    </div>
                                </li>
                                <li class="cart-item">
                                    <div class="ps-product--mini-cart"><a href="product-default.html"><img class="ps-product__thumbnail" src="{{asset('theme/img/products/01-Fresh/01_16a.jpg')}}" alt="alt" /></a>
                                        <div class="ps-product__content"><a class="ps-product__name" href="product-default.html">Avocado <u>Organic</u> Hass Large</a>
                                            <p class="ps-product__meta"> <span class="ps-product__price">$12.90</span>
                                            </p>
                                        </div>
                                    </div>
                                </li>
                                <li class="cart-item">
                                    <div class="ps-product--mini-cart"><a href="product-default.html"><img class="ps-product__thumbnail" src="{{asset('theme/img/products/01-Fresh/01_32a.jpg')}}" alt="alt" /></a>
                                        <div class="ps-product__content"><a class="ps-product__name" href="product-default.html">Tailgater Ham <u>Organic</u> Sandwich</a>
                                            <p class="ps-product__meta"> <span class="ps-product__price">$33.49</span>
                                            </p>
                                        </div>
                                    </div>
                                </li>
                                <li class="cart-item">
                                    <div class="ps-product--mini-cart"><a href="product-default.html"><img class="ps-product__thumbnail" src="{{asset('theme/img/products/01-Fresh/01_6a.jpg')}}" alt="alt" /></a>
                                        <div class="ps-product__content"><a class="ps-product__name" href="product-default.html">Extreme <u>Organic</u> Light Can</a>
                                            <p class="ps-product__rating">
                                                <select class="rating-stars">
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4" selected="selected">4</option>
                                                    <option value="5">5</option>
                                                </select><span>(16)</span>
                                            </p>
                                            <p class="ps-product__meta"> <span class="ps-product__price-sale">$4.99</span><span class="ps-product__is-sale">$8.99</span>
                                            </p>
                                        </div>
                                    </div>
                                </li>
                                <li class="cart-item">
                                    <div class="ps-product--mini-cart"><a href="product-default.html"><img class="ps-product__thumbnail" src="{{asset('theme/img/products/01-Fresh/01_22a.jpg')}}" alt="alt" /></a>
                                        <div class="ps-product__content"><a class="ps-product__name" href="product-default.html">Extreme <u>Organic</u> Light Can</a>
                                            <p class="ps-product__meta"> <span class="ps-product__price">$12.99</span>
                                            </p>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="header-inner__right">
                        <button class="button-icon icon-md"><i class="icon-repeat"></i></button><a class="button-icon icon-md" href="wishlist.html"><i class="icon-heart"></i><span class="badge bg-warning">2</span></a>
                        <div class="button-icon btn-cart-header"><i class="icon-cart icon-shop5"></i><span class="badge bg-warning">3</span>
                            <div class="mini-cart">
                                <div class="mini-cart--content">
                                    <div class="mini-cart--overlay"></div>
                                    <div class="mini-cart--slidebar cart--box">
                                        <div class="mini-cart__header">
                                            <div class="cart-header-title">
                                                <h5>Shopping Cart(3)</h5><a class="close-cart" href="javascript:void(0);"><i class="icon-arrow-right"></i></a>
                                            </div>
                                        </div>
                                        <div class="mini-cart__products">
                                            <div class="out-box-cart">
                                                <div class="triangle-box">
                                                    <div class="triangle"></div>
                                                </div>
                                            </div>
                                            <ul class="list-cart">
                                                <li class="cart-item">
                                                    <div class="ps-product--mini-cart"><a href="product-default.html"><img class="ps-product__thumbnail" src="{{asset('theme/img/products/01-Fresh/01_18a.jpg')}}" alt="alt" /></a>
                                                        <div class="ps-product__content"><a class="ps-product__name" href="product-default.html">Extreme Budweiser Light Can</a>
                                                            <p class="ps-product__unit">500g</p>
                                                            <p class="ps-product__meta"> <span class="ps-product__price">$3.90</span><span class="ps-product__quantity">(x1)</span>
                                                            </p>
                                                        </div>
                                                        <div class="ps-product__remove"><i class="icon-trash2"></i></div>
                                                    </div>
                                                </li>
                                                <li class="cart-item">
                                                    <div class="ps-product--mini-cart"><a href="product-default.html"><img class="ps-product__thumbnail" src="{{asset('theme/img/products/01-Fresh/01_31a.jpg')}}" alt="alt" /></a>
                                                        <div class="ps-product__content"><a class="ps-product__name" href="product-default.html">Honest Organic Still Lemonade</a>
                                                            <p class="ps-product__unit">100g</p>
                                                            <p class="ps-product__meta"> <span class="ps-product__price-sale">$5.99</span><span class="ps-product__is-sale">$8.99</span><span class="quantity">(x1)</span>
                                                            </p>
                                                        </div>
                                                        <div class="ps-product__remove"><i class="icon-trash2"></i></div>
                                                    </div>
                                                </li>
                                                <li class="cart-item">
                                                    <div class="ps-product--mini-cart"><a href="product-default.html"><img class="ps-product__thumbnail" src="{{asset('theme/img/products/01-Fresh/01_16a.jpg')}}" alt="alt" /></a>
                                                        <div class="ps-product__content"><a class="ps-product__name" href="product-default.html">Matures Own 100% Wheat</a>
                                                            <p class="ps-product__unit">1.5L</p>
                                                            <p class="ps-product__meta"> <span class="ps-product__price">$12.90</span><span class="ps-product__quantity">(x1)</span>
                                                            </p>
                                                        </div>
                                                        <div class="ps-product__remove"><i class="icon-trash2"></i></div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="mini-cart__footer row">
                                            <div class="col-6 title">TOTAL</div>
                                            <div class="col-6 text-right total">$29.98</div>
                                            <div class="col-12 d-flex"><a class="view-cart" href="shopping-cart.html">View cart</a><a class="checkout" href="checkout.html">Checkout</a></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <nav class="navigation">
            <div class="container">
                <ul class="menu">
                    <li class="menu-item-has-children has-mega-menu active"><a class="nav-link active" href="javascript:void(0);">Home</a><span class="sub-toggle"><i class="icon-chevron-down"></i></span>
                        <div class="mega-menu">
                            <div class="mega-anchor"></div>
                            <div class="mega-menu__column">
                                <h4>Home Pages<span class="sub-toggle"></span></h4>
                                <ul class="sub-menu--mega">
                                    <li> <a class="active" href="index.html">Home Supermarket</a>
                                    </li>
                                    <li> <a href="home-full-width.html">Home Supermarket Full Width</a>
                                    </li>
                                    <li> <a href="home-local-store.html">Home Local Store</a>
                                    </li>
                                    <li> <a href="home-sidebar.html">Home Sidebar</a>
                                    </li>
                                    <li> <a href="home-business.html">Home Business</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </li>
                    <li class="menu-item-has-children has-mega-menu"><a class="nav-link" href="javascript:void(0);">Shop</a><span class="sub-toggle"><i class="icon-chevron-down"></i></span>
                        <div class="mega-menu mega-shop">
                            <div class="mega-anchor"></div>
                            <div class="mega-menu__column">
                                <h4>Shop Pages<span class="sub-toggle"></span></h4>
                                <ul class="sub-menu--mega">
                                    <li> <a href="shop-view-grid.html">Shop Default View Grid</a>
                                    </li>
                                    <li> <a href="shop-view-listing.html">Shop Default View Listing</a>
                                    </li>
                                    <li> <a href="shop-view-extended.html">Shop Default View Products</a>
                                    </li>
                                    <li> <a href="shop-categories.html">Shop Categories</a>
                                    </li>
                                    <li> <a href="shop-with-banner.html">Shop With Banner</a>
                                    </li>
                                    <li> <a href="shop-all-brands.html">Shop All Brands</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="mega-menu__column">
                                <h4>Product Layouts<span class="sub-toggle"></span></h4>
                                <ul class="sub-menu--mega">
                                    <li> <a href="product-default.html">Shop Default</a>
                                    </li>
                                    <li> <a href="product-extended.html">Shop Extended</a>
                                    </li>
                                    <li> <a href="product-sidebar.html">Shop Sidebar</a>
                                    </li>
                                    <li> <a href="product-full-width.html">Shop Full Width</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="mega-menu__column">
                                <h4>Product Types<span class="sub-toggle"></span></h4>
                                <ul class="sub-menu--mega">
                                    <li> <a href="product-simple.html">Simple</a>
                                    </li>
                                    <li> <a href="product-variable.html">Variable</a>
                                    </li>
                                    <li> <a href="product-attribute.html">Attribute (Size)</a>
                                    </li>
                                    <li> <a href="product-image-swatches.html">Images Swatches</a>
                                    </li>
                                    <li> <a href="product-on-sale.html">On Sale</a>
                                    </li>
                                    <li> <a href="product-out-of-stock.html">Out of Stock</a>
                                    </li>
                                    <li> <a href="product-groupped.html">Groupped</a>
                                    </li>
                                    <li> <a href="product-countdown-timer.html">Countdown Timer</a>
                                    </li>
                                    <li> <a href="product-coupon-code.html">Coupon Code</a>
                                    </li>
                                    <li> <a href="product-price-list-compare.html">Price List Compare</a>
                                    </li>
                                    <li> <a href="product-instagram-feed.html">Instagram Feed</a>
                                    </li>
                                    <li> <a href="product-video-featured.html">Video Featured</a>
                                    </li>
                                    <li> <a href="product-with-button-buy-now.html">With button Buy Now</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="mega-menu__column">
                                <h4>Woo Pages<span class="sub-toggle"></span></h4>
                                <ul class="sub-menu--mega">
                                    <li> <a href="shopping-cart.html">Shopping Cart</a>
                                    </li>
                                    <li> <a href="checkout.html">Checkout</a>
                                    </li>
                                    <li> <a href="wishlist.html">Wishlist</a>
                                    </li>
                                    <li> <a href="index.html">Compare</a>
                                    </li>
                                    <li> <a href="order-tracking.html">Order Tracking</a>
                                    </li>
                                    <li> <a href="login-register.html">Login & Register</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </li>
                    <li class="menu-item-has-children has-mega-menu"><a class="nav-link" href="javascript:void(0);">Pages</a><span class="sub-toggle"><i class="icon-chevron-down"></i></span>
                        <div class="mega-menu">
                            <div class="mega-anchor"></div>
                            <div class="mega-menu__column">
                                <h4>Page all<span class="sub-toggle"></span></h4>
                                <ul class="sub-menu--mega">
                                    <li> <a href="vendor-registration.html">Vendor Register</a>
                                    </li>
                                    <li> <a href="become-a-vendor.html">Become a Vendor</a>
                                    </li>
                                    <li> <a href="store-list.html">Dokan Store List</a>
                                    </li>
                                    <li> <a href="vendor-store.html">Dokan Vendor Store</a>
                                    </li>
                                    <li> <a href="flash-sale.html">Flash Sale</a>
                                    </li>
                                    <li> <a href="about-us.html">About Us</a>
                                    </li>
                                    <li> <a href="contact.html">Contact</a>
                                    </li>
                                    <li> <a href="faq.html">FAQs</a>
                                    </li>
                                    <li> <a href="404-not-found.html">404 Not Found</a>
                                    </li>
                                    <li> <a href="coming-soon.html">Coming Soon</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </li>
                    <li class="menu-item-has-children has-mega-menu"><a class="nav-link" href="javascript:void(0);">Blog</a><span class="sub-toggle"><i class="icon-chevron-down"></i></span>
                        <div class="mega-menu">
                            <div class="mega-anchor"></div>
                            <div class="mega-menu__column">
                                <h4>Blog Type<span class="sub-toggle"></span></h4>
                                <ul class="sub-menu--mega">
                                    <li> <a href="blog-default.html">01 Blog-Default</a>
                                    </li>
                                    <li> <a href="blog-thumbnail.html">Blog Small Thumbnail</a>
                                    </li>
                                    <li> <a href="blog-gird.html">Blog Gird</a>
                                    </li>
                                    <li> <a href="blog-list.html">Blog Listing</a>
                                    </li>
                                    <li> <a href="single-post.html">Single Post without Sidebar</a>
                                    </li>
                                    <li> <a href="single-post-sidebar.html">Single Post with Sidebar</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </li>
                    <li class="menu-item-has-children has-mega-menu menu-item-branch"><a class="nav-link" href="javascript:void(0);">Brand</a>
                        <div class="mega-menu mega-brand">
                            <div class="mega-anchor"></div>
                            <div class="brand-box">
                                <div class="brand__title">FEATURED BRAND</div>
                                <div class="row">
                                    <div class="col-4"><a href="shop-view-grid.html"><img src="{{ asset('theme/img/brand/brand_themeforest.jpg') }}" alt="alt" /></a></div>
                                    <div class="col-4"><a href="shop-view-grid.html"><img src="{{ asset('theme/img/brand/brand_envato.jpg') }}" alt="alt" /></a></div>
                                    <div class="col-4"><a href="shop-view-grid.html"><img src="{{ asset('theme/img/brand/brand_codecanyon.jpg') }}" alt="alt" /></a></div>
                                    <div class="col-4"><a href="shop-view-grid.html"><img src="{{ asset('theme/img/brand/brand_cudicjungle.jpg') }}" alt="alt" /></a></div>
                                    <div class="col-4"><a href="shop-view-grid.html"><img src="{{ asset('theme/img/brand/brand_videohive.jpg') }}" alt="alt" /></a></div>
                                    <div class="col-4"><a href="shop-view-grid.html"><img src="{{ asset('theme/img/brand/brand_photodune.jpg') }}" alt="alt" /></a></div>
                                    <div class="col-4"><a href="shop-view-grid.html"><img src="{{ asset('theme/img/brand/brand_evatotuts.jpg') }}" alt="alt" /></a></div>
                                    <div class="col-4"><a href="shop-view-grid.html"><img src="{{ asset('theme/img/brand/brand_3docean.jpg') }}" alt="alt" /></a></div>
                                    <div class="col-4"><a href="shop-view-grid.html"><img src="{{ asset('theme/img/brand/microlancer.jpg') }}" alt="alt" /></a></div>
                                </div><a class="brand__link" href="shop-all-brands.html">See all brands<i class="icon-chevron-right"></i></a>
                            </div>
                            <div class="brand__promotion"><a href="flash-sale.html"><img src="{{ asset('theme/img/brand/brand_01.jpg') }}" alt="alt" /></a></div>
                            <div class="brand__promotion"><a href="flash-sale.html"><img src="{{ asset('theme/img/brand/brand_02.jpg') }}" alt="alt" /></a></div>
                        </div>
                    </li>
                    <li class="menu-item-has-children has-mega-menu"> <a class="nav-link" href="flash-sale.html">Flash Sale</a>
                    </li>
                </ul>
                <div class="navigation-text">
                    <ul class="menu">
                        <li class="menu-item-has-children has-mega-menu"><a class="nav-link" href="javascript:void(0);">Your Recent Viewed</a><span class="sub-toggle"><i class="icon-chevron-down"></i></span>
                            <div class="mega-menu recent-view">
                                <div class="mega-anchor"></div>
                                <div class="container">
                                    <div class="slick-many-item">
                                        <a class="recent-item" href="shop-categories.html">
                                            <img src="{{ asset('theme/img/products/01-Fresh/01_1a.jpg') }}" alt="alt" />
                                        </a>
                                        <a class="recent-item" href="shop-categories.html">
                                            <img src="{{asset('theme/img/products/01-Fresh/01_2a.jpg')}}" alt="alt" />
                                        </a>
                                        <a class="recent-item" href="shop-categories.html">
                                            <img src="{{asset('theme/img/products/01-Fresh/01_30a.jpg')}}" alt="alt" />
                                        </a>
                                        <a class="recent-item" href="shop-categories.html">
                                            <img src="{{asset('theme/img/products/01-Fresh/01_10a.jpg')}}" alt="alt" />
                                        </a>
                                        <a class="recent-item" href="shop-categories.html">
                                            <img src="{{asset('theme/img/products/01-Fresh/01_18a.jpg')}}" alt="alt" />
                                        </a>
                                        <a class="recent-item" href="shop-categories.html">
                                            <img src="{{asset('theme/img/products/01-Fresh/01_28b.jpg')}}" alt="alt" />
                                        </a>
                                        <a class="recent-item" href="shop-categories.html">
                                            <img src="{{asset('theme/img/products/01-Fresh/01_16a.jpg')}}" alt="alt" />
                                        </a>
                                        <a class="recent-item" href="shop-categories.html">
                                            <img src="{{asset('theme/img/products/01-Fresh/01_31a.jpg')}}" alt="alt" />
                                        </a>
                                        <a class="recent-item" href="shop-categories.html">
                                            <img src="{{asset('theme/img/products/01-Fresh/01_15a.jpg')}}" alt="alt" />
                                        </a>
                                        <a class="recent-item" href="shop-categories.html">
                                            <img src="{{asset('theme/img/products/01-Fresh/01_5a.jpg')}}" alt="alt" />
                                        </a>
                                        <a class="recent-item" href="shop-categories.html">
                                            <img src="{{asset('theme/img/products/01-Fresh/01_32a.jpg')}}" alt="alt" />
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>        

    <main class="no-main">
        @yield('content')
    </main>
    <footer class="ps-footer">
        <div class="container">
            <div class="ps-footer--contact">
                <div class="row">
                    <div class="col-12 col-lg-4">
                        <p class="contact__title">Contact Us</p>
                        <p><b><i class="icon-telephone"> </i>Hotline: </b><span>(7:00 - 21:30)</span></p>
                        <p class="telephone">097 978-6290<br>097 343-8888</p>
                        <p> <b>Head office: </b>8049 High Ridge St. Saint Joseph, MI 49085</p>
                        <p> <b>Email us: </b><a href="http://nouthemes.net/cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="0c7f797c7c637e784c6a6d7e616d7e78226f6361">[email&#160;protected]</a></p>
                    </div>
                    <div class="col-12 col-lg-4">
                        <div class="row">
                            <div class="col-12 col-lg-6">
                                <p class="contact__title">Help & Info<span class="footer-toggle"><i class="icon-chevron-down"></i></span></p>
                                <ul class="footer-list">
                                    <li> <a href="#">About Us</a>
                                    </li>
                                    <li> <a href="#">Contact</a>
                                    </li>
                                    <li> <a href="#">Sore Locations</a>
                                    </li>
                                    <li> <a href="#">Terms of Use</a>
                                    </li>
                                    <li> <a href="#">Policy</a>
                                    </li>
                                    <li> <a href="#">Flash Sale</a>
                                    </li>
                                    <li> <a href="#">FAQs</a>
                                    </li>
                                </ul>
                                <hr>
                            </div>
                            <div class="col-12 col-lg-6">
                                <p class="contact__title">Corporate<span class="footer-toggle"><i class="icon-chevron-down"></i></span></p>
                                <ul class="footer-list">
                                    <li> <a href="#">Become a Vendor</a>
                                    </li>
                                    <li> <a href="#">Affiliate Program</a>
                                    </li>
                                    <li> <a href="#">Farm Business</a>
                                    </li>
                                    <li> <a href="#">Careers</a>
                                    </li>
                                    <li> <a href="#">Our Suppliers</a>
                                    </li>
                                    <li> <a href="#">Accessibility</a>
                                    </li>
                                </ul>
                                <hr>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-4">
                        <p class="contact__title">Newsletter Subscription</p>
                        <p>Join our email subscription now to get updates on <b>promotions </b>and <b>coupons.</b></p>
                        <div class="input-group">
                            <div class="input-group-prepend"><i class="icon-envelope"></i></div>
                            <input class="form-control" type="text" placeholder="Enter your email...">
                            <div class="input-group-append">
                                <button class="btn">Subscribe</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="ps-footer--service">
                <div class="row">
                    <div class="col-12 col-lg-4">
                        <div class="service__payment">
                            <img src="{{asset('theme/img/promotion/payment_paypal.jpg')}}" alt>
                            <img src="{{asset('theme/img/promotion/payment_visa.jpg')}}" alt>
                            <img src="{{asset('theme/img/promotion/payment_mastercart.jpg')}}" alt>
                            <img src="{{asset('theme/img/promotion/payment_electron.jpg')}}" alt>
                            <img src="{{asset('theme/img/promotion/payment_skrill.jpg')}}" alt>
                        </div>
                        <p class="service__app">Get Farmart App to <span class="text-success">get $15 coupon</span></p>
                        <div class="service__download">
                            <a href="contact.html">
                                <img src="{{asset('theme/img/promotion/appStore.jpg')}}" alt>
                            </a><a href="contact.html">
                                <img src="{{asset('theme/img/promotion/googlePlay.jpg')}}" alt>
                            </a>
                        </div>
                    </div>
                    <div class="col-12 col-lg-4">
                        <table class="table table-bordered">
                            <tr>
                                <td><a href="contact.html"><img src="{{asset('theme/img/promotion/badges_01.jpg')}}" alt></a></td>
                                <td><a href="contact.html"><img src="{{asset('theme/img/promotion/badges_02.jpg')}}" alt></a></td>
                                <td><a href="contact.html"><img src="{{asset('theme/img/promotion/badges_03.jpg')}}" alt></a></td>
                            </tr>
                            <tr>
                                <td><a href="contact.html"><img src="{{asset('theme/img/promotion/badges_04.jpg')}}" alt></a></td>
                                <td><a href="contact.html"><img src="{{asset('theme/img/promotion/badges_05.jpg')}}" alt></a></td>
                                <td><a href="contact.html"><img src="{{asset('theme/img/promotion/badges_06.jpg')}}" alt></a></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-12 col-lg-4">
                        <div class="service--block">
                            <p class="service__item"> <i class="icon-speed-fast"></i><span> <b>Fast Delivery </b>& Shipping</span></p>
                            <p class="service__item"> <i class="icon-color-sampler"></i><span>Top <b>Offers</b></span></p>
                            <p class="service__item"> <i class="icon-wallet"></i><span>Money <b>Cashback</b></span></p>
                            <p class="service__item"> <i class="icon-bubble-user"></i><span>Friendly <b>Support 24/7</b></span></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="ps-footer--categories">
                <div class="categories__list"><b>Fresh: </b>
                    <ul class="menu--vertical">
                        <li class="menu-item"> <a href="shop-categories.html">Meat & Poultry</a>
                        </li>
                        <li class="menu-item"> <a href="shop-categories.html">Fruit</a>
                        </li>
                        <li class="menu-item"> <a href="shop-categories.html">Vegetables</a>
                        </li>
                        <li class="menu-item"> <a href="shop-categories.html">Salad & Herbs</a>
                        </li>
                        <li class="menu-item"> <a href="shop-categories.html">Yoghurts</a>
                        </li>
                        <li class="menu-item"> <a href="shop-categories.html">Milk, Butter & Eggs</a>
                        </li>
                        <li class="menu-item"> <a href="shop-categories.html">Ham, Deli & Dips</a>
                        </li>
                        <li class="menu-item"> <a href="shop-categories.html">Cheese</a>
                        </li>
                        <li class="menu-item"> <a href="shop-categories.html">Fish</a>
                        </li>
                        <li class="menu-item"> <a href="shop-categories.html">Pizza & Garlic Bread</a>
                        </li>
                    </ul>
                </div>
                <div class="categories__list"><b>Food Cupboard: </b>
                    <ul class="menu--vertical">
                        <li class="menu-item"> <a href="shop-categories.html">Crisps, Snacks & Nuts</a>
                        </li>
                        <li class="menu-item"> <a href="shop-categories.html">Breakfast Cereals</a>
                        </li>
                        <li class="menu-item"> <a href="shop-categories.html">Tins & Cans</a>
                        </li>
                        <li class="menu-item"> <a href="shop-categories.html">Chocolate & Sweets</a>
                        </li>
                        <li class="menu-item"> <a href="shop-categories.html">Biscuits</a>
                        </li>
                        <li class="menu-item"> <a href="shop-categories.html">Rice, Pasta & Pulses</a>
                        </li>
                        <li class="menu-item"> <a href="shop-categories.html">Cooking Ingredients</a>
                        </li>
                    </ul>
                </div>
                <div class="categories__list"><b>Bakery: </b>
                    <ul class="menu--vertical">
                        <li class="menu-item"> <a href="shop-categories.html">Bread</a>
                        </li>
                        <li class="menu-item"> <a href="shop-categories.html">Rolls, Bagels & Thins</a>
                        </li>
                        <li class="menu-item"> <a href="shop-categories.html">Cakes & Treats</a>
                        </li>
                        <li class="menu-item"> <a href="shop-categories.html">Wraps, Pitta & Naan Bread</a>
                        </li>
                        <li class="menu-item"> <a href="shop-categories.html">Crumpets, Muffins & Pancakes</a>
                        </li>
                        <li class="menu-item"> <a href="shop-categories.html">Croissants & Brioche</a>
                        </li>
                    </ul>
                </div>
                <div class="categories__list"><b>Frozen Foods: </b>
                    <ul class="menu--vertical">
                        <li class="menu-item"> <a href="shop-categories.html">Ice Cream</a>
                        </li>
                        <li class="menu-item"> <a href="shop-categories.html">Fruit, Vegetables & Herbs</a>
                        </li>
                        <li class="menu-item"> <a href="shop-categories.html">Chips, Potatoes & Rice</a>
                        </li>
                        <li class="menu-item"> <a href="shop-categories.html">Fish</a>
                        </li>
                        <li class="menu-item"> <a href="shop-categories.html">Vegetarian</a>
                        </li>
                        <li class="menu-item"> <a href="shop-categories.html">Meat & Poultry</a>
                        </li>
                        <li class="menu-item"> <a href="shop-categories.html">Ready Meals & Party Food</a>
                        </li>
                    </ul>
                </div>
                <div class="categories__list"><b>Ready Meals: </b>
                    <ul class="menu--vertical">
                        <li class="menu-item"> <a href="shop-categories.html">Meals for 1</a>
                        </li>
                        <li class="menu-item"> <a href="shop-categories.html">Indian</a>
                        </li>
                        <li class="menu-item"> <a href="shop-categories.html">Italian</a>
                        </li>
                        <li class="menu-item"> <a href="shop-categories.html">Chinese</a>
                        </li>
                        <li class="menu-item"> <a href="shop-categories.html">Traditional British</a>
                        </li>
                        <li class="menu-item"> <a href="shop-categories.html">Thai & Oriental</a>
                        </li>
                        <li class="menu-item"> <a href="shop-categories.html">Mediterranean & Moroccan</a>
                        </li>
                        <li class="menu-item"> <a href="shop-categories.html">Mexican & Caribbean</a>
                        </li>
                        <li class="menu-item"> <a href="shop-categories.html">Kids' Meals</a>
                        </li>
                    </ul>
                </div>
                <div class="categories__list"><b>Soft Drinks, Tea & Coffee: </b>
                    <ul class="menu--vertical">
                        <li class="menu-item"> <a href="shop-categories.html">Fizzy Drinks</a>
                        </li>
                        <li class="menu-item"> <a href="shop-categories.html">Water</a>
                        </li>
                        <li class="menu-item"> <a href="shop-categories.html">Tea, Coffee & Hot Drinks</a>
                        </li>
                        <li class="menu-item"> <a href="shop-categories.html">Squash</a>
                        </li>
                        <li class="menu-item"> <a href="shop-categories.html">Juices</a>
                        </li>
                        <li class="menu-item"> <a href="shop-categories.html">Mixers</a>
                        </li>
                        <li class="menu-item"> <a href="shop-categories.html">Diet & No Added Sugar</a>
                        </li>
                        <li class="menu-item"> <a href="shop-categories.html">Still & Sparkling</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="row ps-footer__copyright">
                <div class="col-12 col-lg-6 ps-footer__text">&copy; 2020 Farmart Marhetplace. All Rights Reversed.</div>
                <div class="col-12 col-lg-6 ps-footer__social"> <a class="icon_social facebook" href="#"><i class="fa fa-facebook-f"></i></a><a class="icon_social twitter" href="#"><i class="fa fa-twitter"></i></a><a class="icon_social google" href="#"><i class="fa fa-google-plus"></i></a><a class="icon_social youtube" href="#"><i class="fa fa-youtube"></i></a><a class="icon_social wifi" href="#"><i class="fa fa-wifi"></i></a></div>
            </div>
        </div>
    </footer>
    <script src="{{ asset('theme/plugins/jquery.min.js') }}"></script>
    <script src="{{ asset('theme/plugins/popper.min.js') }}"></script>
    <script src="{{ asset('theme/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('theme/plugins/owl-carousel/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('theme/plugins/jquery.matchHeight-min.js') }}"></script>
    <script src="{{ asset('theme/plugins/jquery-bar-rating/dist/jquery.barrating.min.js') }}"></script>
    <script src="{{ asset('theme/plugins/select2/dist/js/select2.min.js') }}"></script>
    <script src="{{ asset('theme/plugins/slick/slick.js') }}"></script>
    <script src="{{ asset('theme/plugins/lightGallery/dist/js/lightgallery-all.min.js') }}"></script>    
    <!-- custom code-->
    <script src="{{ asset('theme/js/main.js') }}"></script>
</body>
</html>
