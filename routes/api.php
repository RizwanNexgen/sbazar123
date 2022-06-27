<?php
header('Content-Type: text/html; charset=utf-8');
use Illuminate\Http\Request;
header('Access-Control-Allow-Origin:  *');
header('Access-Control-Allow-Methods:  POST, GET, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Headers:  Content-Type, X-Auth-Token, Origin, Authorization');
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api','cors')->get('/user', function (
    Request $request
) {
    return $request->user();
});

/*
	|--------------------------------------------------------------------------
	| App Controller Routes
	|--------------------------------------------------------------------------
	|
	| This section contains all Routes of application
	|
	|
*/

Route::group(['namespace' => 'App', 'middleware' => 'cors'], function () {
    
    /* Brands */
    Route::post('/brand_product', 'MyProductController@brand_product');
    Route::post('/manufacturers', 'MyProductController@manufacturers');
    Route::post('/get_top_brands', 'MyProductController@get_top_brands');
    Route::post('/get_categories_by_brand', 'MyProductController@get_categories_by_brand');
    Route::post('/get_products_by_brand_and_categories', 'MyProductController@get_products_by_brand_and_categories');
    /* Brands */
    
    /*Combo*/
    Route::post('/combos', 'MyProductController@combos');
    Route::post('/combo_products', 'MyProductController@combo_products');
    Route::post('/addComboToCart', 'MyProductController@addCartCombo');
    Route::post('/removeComboFromCart', 'MyProductController@remove_combo_from_cart');
    Route::post('/increaseComboQty', 'MyProductController@add_combo_qty');
    Route::post('/decreaseComboQty', 'MyProductController@decrease_combo_qty');
    /*Combo*/
    
    /*Bundles*/
    Route::post('/bundles', 'MyProductController@bundles');
    Route::post('/bundle_products', 'MyProductController@bundle_products');
    Route::post('/addBundleToCart', 'MyProductController@addCartBundle');
    Route::post('/removeBundleFromCart', 'MyProductController@remove_bundle_from_cart');
    Route::post('/increaseBundleQty', 'MyProductController@add_bundle_qty');
    Route::post('/decreaseBundleQty', 'MyProductController@decrease_bundle_qty');
    /*Bundles*/
    
    /*Collection*/
    Route::get('/collection', 'MyProductController@collection');
    Route::get('/collection_product', 'MyProductController@collection_product');
    Route::get('/get_collection_packages', 'MyProductController@get_collection_packages');
    Route::get('/addCollectionToCart', 'MyProductController@addCartPackage');
    Route::get('/removeCollectionFromCart', 'MyProductController@remove_package_from_cart');
    Route::get('/increaseCollectionQty', 'MyProductController@add_package_qty');
    Route::get('/decreaseCollectionQty', 'MyProductController@decrease_package_qty');
    /*Collection*/


    /* Hotcat */
    Route::post('/hotcat', 'MyProductController@hotcat');
    Route::post('/hotcat-product', 'MyProductController@hotcats_products');
    /* Hotcat */


    /*Order*/
    Route::post('/addtoorder', 'OrderController@addtoorder');
    Route::post('/getorders', 'OrderController@getorders');
    Route::post('/create_order', 'MyProductController@create_order');
    Route::post('/get_order_items', 'MyProductController@get_order_items');
    Route::post('/get_past_orders', 'MyProductController@get_past_orders');
    /*Order*/
    

    /*Item Quantity*/
    Route::get('/get_item_quantity', 'MyProductController@get_item_quantity');
    /*Item Quantity*/
    

    /*Points System*/
    Route::get('/getPointsSetting', 'MyProductController@get_points_setting');
    /*Points System*/
    

    /*Membership*/
    Route::post('/getMemberships', 'MyProductController@get_memberships');
    Route::post('/getUserMembershipInfo', 'MyProductController@get_user_membership_info');
    /*Membership*/
    
    
    /* Product */
    Route::post('/getallproducts', 'MyProductController@getallproducts');
    Route::post('/addtocart', 'MyProductController@addCart');
    Route::post('/removeCart', 'MyProductController@removeCart');
    Route::post('/removeallCart', 'MyProductController@removeallCart');
    Route::post('/addqty', 'MyProductController@addqty');
    Route::post('/decreaseqty', 'MyProductController@decreaseqty');
    Route::post('/addfavproducts', 'MyProductController@addfavproducts');
    Route::post('/getfavproducts', 'MyProductController@getfavproducts');
    Route::post('/deletefavproducts', 'MyProductController@deletefavproducts');
    /* Product */
    
    
    /* Categories */
    //Route::post('/getcategories', 'CategoriesController@getcategories');
    Route::post('/allcategories', 'MyProductController@allcategories');
    Route::post('/parentcategories', 'MyProductController@parentcategories');
    Route::post('/rootcategories', 'MyProductController@rootcategories');
    Route::post('/childcategories', 'MyProductController@childcategories');
    Route::post('/catproducts', 'MyProductController@catproducts');
    Route::post('/getCategoryProducts', 'MyProductController@getCategoryProducts');
    Route::post('/getAllParentCatProducts', 'MyProductController@getAllParentCatProducts');
    /* Categories */

    
    /*Get cart data*/
    Route::get('/get_cart_data', 'MyProductController@get_cart_data');
    /*Get cart data*/
    
    /*address*/
    Route::post('/create_or_update_address', 'MyProductController@create_or_update_address');
    Route::get('/get_users_address', 'MyProductController@get_users_address');
    /*address*/
    



    // 	Route::post('/test', 'MyProductController@test');
    Route::post('/register', 'CustomersController@register');
    Route::post('/forgetpass', 'CustomersController@forgetpass');

    

    //Route::post('/getAllcartPro', 'MyProductController@getAllcartPro');

    Route::post('/app_banners', 'MyProductController@app_banners');
    Route::post('/testing', 'MyProductController@testing');
  	Route::post('/testing_products_variations', 'MyProductController@testing_products_variations');
    Route::post('/recomended', 'MyProductController@recomended');

    Route::post('/sliderimages', 'MyProductController@sliderimages');
    Route::post('/settings', 'MyProductController@settings');

    Route::post('/specialproducts', 'MyProductController@specialproducts');
    Route::post('/allpages', 'MyProductController@allpages');

    Route::post('/getpages', 'MyProductController@getpages');
    
    
    Route::post('/brands', 'MyProductController@brands');
    
    Route::post('/getter', 'MyProductController@getter');
    Route::post('/banners', 'MyProductController@banners');

    Route::post('/featuredproducts', 'MyProductController@featuredproducts');

    Route::post('/exclusiveproducts', 'MyProductController@exclusiveproducts');

    Route::post(
        '/products_points_redeem',
        'MyProductController@products_points_redeem'
    );
    Route::post('/flashsaleproducts', 'MyProductController@flashsaleproducts');

    Route::post('/recentproducts', 'MyProductController@recentproducts');
    Route::post('/couponsall', 'MyProductController@couponsall');
    Route::post('/app_menus', 'MyProductController@app_menus');
    Route::post('/app_menus_main', 'MyProductController@app_menus_main');
    Route::post('/app_menus_bottom', 'MyProductController@app_menus_bottom');
    Route::post('/single_setting', 'MyProductController@single_setting');
    Route::post('/terms', 'MyProductController@terms');
    Route::post('/privacy', 'MyProductController@privacy');
    
    Route::post('/recomendedproducts', 'MyProductController@recomendedproducts');
    //Route::post('/top_offers', 'MyProductController@top_offers');

    //end custom apis/////////////////////////////////////////////

    Route::post('/authuser', 'CustomersController@getAuthUserData');

    Route::post('/updateAuthUser', 'CustomersController@updateAuthUser');

    //Route::post('/uploadimage', 'AppSettingController@uploadimage');

    

    //registration url
    Route::post('/registerdevices', 'CustomersController@registerdevices');

    //processregistration url
    Route::post(
        '/processregistration',
        'CustomersController@processregistration'
    );

    

    //update customer info url
    Route::post(
        '/updatecustomerinfo',
        'CustomersController@updatecustomerinfo'
    );
    Route::get('/updatepassword', 'CustomersController@updatepassword');

    // login url
    Route::post('/processlogin', 'CustomersController@processlogin');

    //social login
    Route::post(
        '/facebookregistration',
        'CustomersController@facebookregistration'
    );
    Route::post(
        '/googleregistration',
        'CustomersController@googleregistration'
    );

    //push notification setting
    Route::post('/notify_me', 'CustomersController@notify_me');

    // forgot password url
    Route::post(
        '/processforgotpassword',
        'CustomersController@processforgotpassword'
    );

    /*
	|--------------------------------------------------------------------------
	| Location Controller Routes
	|--------------------------------------------------------------------------
	|
	| This section contains countries shipping detail
	| This section contains links of affiliated to address
	|
	*/

    //get country url
    Route::post('/getcountries', 'LocationController@getcountries');

    //get zone url
    Route::post('/getzones', 'LocationController@getzones');

    //get all address url
    Route::post('/getalladdress', 'LocationController@getalladdress');

    //address url
    Route::post('/addshippingaddress', 'LocationController@addshippingaddress');

    //update address url
    Route::post(
        '/updateshippingaddress',
        'LocationController@updateshippingaddress'
    );

    //update default address url
    Route::post(
        '/updatedefaultaddress',
        'LocationController@updatedefaultaddress'
    );

    //delete address url
    Route::post(
        '/deleteshippingaddress',
        'LocationController@deleteshippingaddress'
    );

    /*
	|--------------------------------------------------------------------------
	| Product Controller Routes
	|--------------------------------------------------------------------------
	|
	| This section contains product data
	| Such as:
	| top seller, Deals, Liked, categroy wise or category individually and detail of every product.
	*/

    //like products
    Route::post('/likeproduct', 'MyProductController@likeproduct');

    //unlike products
    Route::post('/unlikeproduct', 'MyProductController@unlikeproduct');

    //get filters
    Route::post('/getfilters', 'MyProductController@getfilters');

    //get getFilterproducts
    Route::post('/getfilterproducts', 'MyProductController@productSearch');

    Route::post('/getsearchdata', 'MyProductController@getsearchdata');

    //getquantity
    Route::post('/getquantity', 'MyProductController@getquantity');
    
    /*Product Apis*/
   // Route::post('/get-single-product', 'MyProductController@get_single_product');
    Route::post('/get-product-info', 'MyProductController@get_product_info');
    /*Product Apis*/

    /*
	|--------------------------------------------------------------------------
	| News Controller Routes
	|--------------------------------------------------------------------------
	|
	| This section contains news data
	| Such as:
	| top news or category individually and detail of every news.

	*/

    //get categories
    Route::post('/allnewscategories', 'NewsController@allnewscategories');

    //getAllProducts
    Route::post('/getallnews', 'NewsController@getallnews');

    /*
	|--------------------------------------------------------------------------
	| Cart Controller Routes
	|--------------------------------------------------------------------------
	|
	| This section contains customer orders
	|
	*/

    //hyperpaytoken
    Route::post('/hyperpaytoken', 'OrderController@hyperpaytoken');

    //hyperpaytoken
    Route::get(
        '/hyperpaypaymentstatus',
        'OrderController@hyperpaypaymentstatus'
    );

    //paymentsuccess
    Route::get('/paymentsuccess', 'OrderController@paymentsuccess');

    //paymenterror
    Route::post('/paymenterror', 'OrderController@paymenterror');

    //generateBraintreeToken
    Route::get(
        '/generatebraintreetoken',
        'OrderController@generatebraintreetoken'
    );

    //generateBraintreeToken
    Route::get('/instamojotoken', 'OrderController@instamojotoken');

    
    
    //updatestatus
    Route::post('/updatestatus/', 'OrderController@updatestatus');

    

    //get default payment method
    Route::post('/getpaymentmethods', 'OrderController@getpaymentmethods');

    //get shipping / tax Rate
    Route::post('/getrate', 'OrderController@getrate');

    //get Coupon
    Route::post('/getcoupon', 'OrderController@getcoupon');

    //paytm hash key
    Route::get('/generatpaytmhashes', 'OrderController@generatpaytmhashes');

    /*
	|--------------------------------------------------------------------------
	| Banner Controller Routes
	|--------------------------------------------------------------------------
	|
	| This section contains banners, banner history
	|

	*/

    //get banners
    Route::get('/getbanners', 'BannersController@getbanners');

    //banners history
    Route::post('/bannerhistory', 'BannersController@bannerhistory');

    /*
	|--------------------------------------------------------------------------
	| App setting Controller Routes
	|--------------------------------------------------------------------------
	|
	| This section contains app  languages
	|

	*/
    Route::get('/sitesetting', 'AppSettingController@sitesetting');

    //old app label
    Route::post('/applabels', 'AppSettingController@applabels');
    Route::get('/getSearchTags', 'AppSettingController@getSearchTags');

    //new app label
    Route::get('/applabels3', 'AppSettingController@applabels3');
    Route::post('/contactus', 'AppSettingController@contactus');
    Route::get('/getlanguages', 'AppSettingController@getlanguages');

    /*
	|--------------------------------------------------------------------------
	| Page Controller Routes
	|--------------------------------------------------------------------------
	|
	| This section contains news data
	| Such as:
	| top Page individually and detail of every Page.

	*/

    //getAllPages
    Route::post('/getallpages', 'PagesController@getallpages');

    /*
	|--------------------------------------------------------------------------
	| reviews Controller Routes
	|--------------------------------------------------------------------------
 */

    Route::post('/givereview', 'ReviewsController@givereview');
    Route::post('/updatereview', 'ReviewsController@updatereview');
    Route::get('/getreviews', 'ReviewsController@getreviews');

    /*
  |--------------------------------------------------------------------------
  | current location Controller Routes
  |--------------------------------------------------------------------------
  */

    Route::get('/getlocation', 'AppSettingController@getlocation');

    /*
  |--------------------------------------------------------------------------
  | currency location Controller Routes
  |--------------------------------------------------------------------------
  */

    Route::get('/getcurrencies', 'AppSettingController@getcurrencies');

    // Route::post('/get-super-deals', 'MyProductController@get_super_deals');

    Route::post('customerregistration','CustomersController@customerregistration');
    
    Route::post('/get-super-deals', 'MyNewProductController@get_super_deals');
    
    Route::post('/get-flash-deals', 'MyProductController@get_flash_deals');
 
    Route::post('/get-random-brands', 'MyNewProductController@get_random_brands');
    
    Route::post('/get-msd-products', 'MyNewProductController@msd_products');
    
    Route::post('/get-exclusive-products', 'MyNewProductController@exclusive_products');
    
    Route::post('/get-bonus-point-products', 'MyNewProductController@bonus_point_products');
    
    Route::post('/get-trending-products', 'MyNewProductController@trending_products');
    
    Route::post('/get-discounted-products', 'MyNewProductController@discounted_products');
    
    Route::post('/get-single-product', 'MyNewProductController@get_single_product');
    
    Route::post('/get-faq-page', 'MyNewProductController@faq_page');
    
    Route::post('/get-all-pages', 'MyNewProductController@all_pages');
    
    Route::post('get-shipping-methods', 'MyNewProductController@shipping_methods');

    Route::post('get-back-in-stock', 'MyNewProductController@get_back_in_stock');

    
    
        


    
    
    


});
