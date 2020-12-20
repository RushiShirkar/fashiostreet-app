<?php

Route::prefix('api')->group(function(){

    /* -- Tabs Routes -- */
    Route::get(
        'getTabs',
        'fashiostreet\seller\Tabs\TabsRepository@getTabs'
    )->name('getTabs');

    Route::post(
        'addTab',
        'fashiostreet\seller\Tabs\TabsRepository@addTab'
    )->name('addTab');

    Route::post(
        'deleteTab',
        'fashiostreet\seller\Tabs\TabsRepository@deleteTab'
    )->name('deleteTab');

    Route::get(
        'getTabsGender',
        'fashiostreet\seller\Tabs\TabsRepository@TabsGender_list'
    )->name('getTabsGender');

    Route::get(
        'getTabsCategory',
        'fashiostreet\seller\Tabs\TabsRepository@TabsCategory_list'
    )->name('getTabsCategory');

    Route::get(
        'getTabsSub_Category',
        'fashiostreet\seller\Tabs\TabsRepository@TabsSub_Category_list'
    )->name('getTabsSub_category');
    /* --  End of Tabs Route -- */


    /* --  version check -- */

    Route::get('getVersion','fashiostreet\seller\Products\ProductsRepository@getVersion');
    Route::get('getOffers/{id}','fashiostreet\seller\Shops\ShopsRepository@getShopOffers');
    /* -- end of version check -- */

    /* -- products -- */
    Route::post('offer','fashiostreet\seller\Shops\ShopsRepository@addOffer');

    Route::get(
        'getProductDetails',
        'fashiostreet\seller\Products\ProductsRepository@GetTabsProductDetails'
    );
    Route::get(
        'getProducts',
        'fashiostreet\seller\Products\ProductsRepository@GetTabsProduct'
    );
    Route::post(
        'addProduct',
        'fashiostreet\seller\Products\ProductsRepository@AddTabProduct'
    );
    Route::post(
        'deleteProduct',
        'fashiostreet\seller\Products\ProductsRepository@DeleteTabsProduct'
    );
    Route::post(
        'updateProduct',
        'fashiostreet\seller\Products\ProductsRepository@UpdateTabsProduct'
    );
    Route::post(
        'saveImage',
        'fashiostreet\seller\Products\ProductsRepository@storeImage'
    );
    /* --  end of products -- */

    /* --  Common request -- */
    Route::get(
        'getColors',
        'fashiostreet\seller\Common\CommonController@getColors'
    );

    Route::get(
        'getTypes',
        'fashiostreet\seller\Common\CommonController@getTypes'
    );

    Route::get(
        'getSizes',
        'fashiostreet\seller\Common\CommonController@getSizes'
    );

    Route::get(
        'getBrands',
        'fashiostreet\seller\Common\CommonController@getBrands'
    );
    /* --  End of common request -- */

    /* -- Shop Route -- */
    Route::post(
        'addShop_Profile',
        'fashiostreet\seller\Shops\ShopsRepository@AddShop'
    );
    Route::post(
        'updateShop_Profile',
        'fashiostreet\seller\Shops\ShopsRepository@UpdateShop'
    );
    /* -- end of shop routes -- */


    /* orders routes */
    Route::get(
        'getorderedproduct',
        'fashiostreet\seller\Orders\OrdersRepository@GetOrderProduct'
    );

    Route::get(
        'getpickedupproduct',
        'fashiostreet\seller\Orders\OrdersRepository@GetPickedUpProduct'
    );

    Route::get(
        'getreturnproduct',
        'fashiostreet\seller\Orders\OrdersRepository@GetReturnProduct'
    );

    Route::get(
        'getcompletedproduct',
        'fashiostreet\seller\Orders\OrdersRepository@GetCompletedProduct'
    );

    /* --  end of orders routes -- */
});
