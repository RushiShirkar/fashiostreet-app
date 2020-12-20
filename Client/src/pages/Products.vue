<template>
  <f7-page style="padding-bottom:35px" name="products"
           infinite
           :infinite-distance="20"
           :infinite-preloader="showPreloader"
           @infinite="loadMore"
           >
    <div v-if="toast_msg != null" class="custom_toast z-depth-3">
      {{ toast_msg }}
    </div>
    <f7-navbar class="bgnav" style="border-radius:0px 0px 30px 0px;box-shadow: 5px 0px 10px rgba(0, 0, 0, 0.12)" sliding>
      <f7-nav-left>
        <f7-link icon-f7="icon-arrow_left" style="padding:21px" @click="Pageback($f7router)"></f7-link>
      </f7-nav-left>
      <f7-nav-title style="font-size:18px;font-weight:bold;margin:0px">
        {{category}}
      </f7-nav-title>
       <f7-nav-right>
        <!--<f7-link style="padding:0 10px" icon-f7="icon-search_strong" href="/search/WHATS YOUR TODAY WISH/enter product you want/product"></f7-link>-->
        <f7-link style="padding:0 10px" href="/wishlist/" v-if="wishlistinfo.length>0"><img src="../assets/thumbs-up_white.svg" alt="">
          <span class="badge" v-if="wishlistinfo.length>0" style="border-radius: 16px;height: 20px;width: 20px;margin-top:-18px;margin-left:-1.5vw;background-color:#5ddcf9;color:#000000"><p style="margin-top: -19px;margin-left: -0.5vw;font-size:14px;font-weight:bold">{{wishlistinfo.length}}</p></span>
        </f7-link>
        <f7-link style="padding:0 10px" href="/wishlist/" v-else><img src="../assets/thumbs-up_white.svg" alt=""></f7-link>
        <f7-link style="padding:0 10px" href="/hdcart/" v-if="cartinfo.length>0"><img src="../assets/delivery-motorbike.svg" alt="">
          <span class="badge" v-if="cartinfo.length>0" style="border-radius: 16px;height: 20px;width: 20px;margin-top:-18px;margin-left:-1.5vw;background-color:#5ddcf9;color:#000000"><p style="margin-top: -19px;margin-left: -0.5vw;font-size:14px;font-weight:bold">{{cartinfo.length}}</p></span>
        </f7-link>
        </f7-link>
        <f7-link style="padding:0 10px" href="/hdcart/" v-else><img src="../assets/delivery-motorbike.svg" alt=""></f7-link>      
       </f7-nav-right>
    </f7-navbar>
          <offline @detected-condition="handleConnectivityChange">
  </offline>
    <!-- Scrollable page content-->
    <!-- <f7-block-title>{{ title }</f7-block-title> -->
    <div v-if="AppLoader" style="position:fixed;width:100%;height:100vh;background-color: rgba(255,255,255,0.8);z-index:99">
      <center>
        <div class="preloader" style="margin-top:45vh">
        <span class="preloader-inner">
          <span class="preloader-inner-gap"></span>
          <span class="preloader-inner-left">
              <span class="preloader-inner-half-circle"></span>
          </span>
          <span class="preloader-inner-right">
              <span class="preloader-inner-half-circle"></span>
          </span>
        </span>
        </div>
      </center>
    </div>
    <div class="content" style="background-color:#ffffff">
      <div v-if="!preloader">
        <div v-show="productMsg!=null">
          <center>
            <h2 style="padding:10px 0px">{{ productMsg }}</h2>
            <h4 style="margin:18px 0px 10px 0px">Shopkeepers Will Soon Add Great {{category}}</h4>
            <h3 style="margin:0px 0px 30px 0px">Stay Tuned !</h3>
            <span style="font-size:38px;font-weight:800;border: 1px solid #000000;border-radius:5px;padding:5px 10px;">OR</span>
            <h2 style="padding:10px 0px">Use Specific Want Feature</h2>
            <f7-link href="/specificPage" style="width:100%;height:18vh;padding:0px 15px 28px 15px">
            <img src="../assets/featurebanner1.png" style="width:100%;height:100%;border-radius:5px" alt="Specific Want Order">
            </f7-link>
          </center>
        </div>
        <div v-if="q != undefined" style="color:black;font-size: 16px;padding:5px;">
          Search result : {{ q }}
        </div>
        <f7-block style="background-color:white;padding:18px 0px 0px 10px;margin:0px" v-show="productinfo.length>0">
          <f7-row>
            <f7-col style="height:90px">
              <f7-link href="/specificPage" @click="save" style="width:100%;height:100%;border-radius:50px 0px 0px 50px">
               <img src="../assets/featurebanner1.png" style="width:100%;height:100%;border-radius:50px 0px 0px 50px" alt="">
              </f7-link>
            </f7-col>
          </f7-row>
        </f7-block>
        <f7-block v-if="gender!='Deodorant'" style="background-color:white;margin:18px 10px 28px 0px;padding:0px 2px 0px 0px;border-radius:0px 30px 30px 0px;border:1px solid gray;border-left:0px" v-show="productinfo.length>0">
         <div style="padding:16px 0px 10px 0px">
          <p style="font-size:16px;font-weight:bold;padding:0px 0px 16px 16px">Which price are you looking for?</p>
          <div style="overflow-x:scroll;overflow-y:hidden;white-space:nowrap;padding:0px 0px 0px 16px;font-weight:bold">
            <f7-button @click="savePrice('0-299')" popup-open=".filterpopup1" style="display:inline-block;padding:0px 16px;border-radius:4px;border:1px solid gray;margin:0px 8px 0px 0px;color:#212121">Under ₹ 299</f7-button>
            <f7-button @click="savePrice('300-399')" popup-open=".filterpopup1" style="display:inline-block;padding:0px 16px;border-radius:4px;border:1px solid gray;margin:0px 8px 0px 0px;color:#212121">₹ 300 - ₹ 399</f7-button>
            <f7-button @click="savePrice('400-499')" popup-open=".filterpopup1" style="display:inline-block;padding:0px 16px;border-radius:4px;border:1px solid gray;margin:0px 8px 0px 0px;color:#212121">₹ 400 - ₹ 499</f7-button>
            <f7-button @click="savePrice('500-599')" popup-open=".filterpopup1" style="display:inline-block;padding:0px 16px;border-radius:4px;border:1px solid gray;margin:0px 8px 0px 0px;color:#212121">₹ 500 - ₹ 699</f7-button>
            <f7-button @click="savePrice('600-799')" popup-open=".filterpopup1" style="display:inline-block;padding:0px 16px;border-radius:4px;border:1px solid gray;margin:0px 8px 0px 0px;color:#212121">₹ 600 - ₹ 799</f7-button>
          </div>
         </div>
         <div style="padding:16px 0px 36px 0px">
          <p v-if="gender=='Deodorant'" style="font-size:16px;font-weight:bold;padding:0px 0px 16px 16px">What volume are you looking for?</p>
          <p v-else style="font-size:16px;font-weight:bold;padding:0px 0px 16px 16px">What size are you looking for?</p>
          <div style="overflow-x:scroll;overflow-y:hidden;white-space:nowrap;padding:0px 0px 0px 16px;font-weight:bold">
            <template v-for="size in sizesData">
               <f7-button @click="saveSize(size.name)" popup-open=".filterpopup1" style="display:inline-block;padding:0px 14px;border-radius:4px;border:1px solid gray;margin:0px 12px 0px 0px;color:#212121">{{ size.name }}</f7-button>     
            </template>
          </div>
         </div>
      </f7-block>
        <f7-row no-gap style="border-top:1px solid gray;border-radius:30px 30px 0px 0px;padding-top:18px">
          <template v-for="(result,index) in productinfo">
          <f7-col width="50" class="col_hgt" style="height:49vh;padding:0px 0px 14px 0px;border-right:1px solid #f1f3f6;border-bottom:1px solid #f1f3f6">
              <f7-link :href="'/productdetails/' + result.id + '/' + result.name" style="width:100%">
                <f7-card style="width:100%;height:100%;margin:0px;padding:0px;-webkit-box-shadow: none;box-shadow: none">
                  <div class="image_viewer" style="width: 100%;height:35vh;">
                    <img :src="result.image" style="width:100%;height:100%;margin:0px;object-fit: contain">
                    <div v-show="result.specialDiscount == true" style="max-width:120px;position:absolute;z-index:99;bottom:84px;left:0px;background-image: linear-gradient(to right, #8E2DE2, #4A00E0);color:#FFFFFF;border-radius:0px 30px 30px 0px;font-size:16px;font-weight:bold;padding:3px 8px">
                      <p class="mpzero lineclampin" style="font-size:16px">&#8377;{{result.specialDiscountedPrice}}<span style="font-size:12px;line-height:17px;height:17px"> - {{offers1[index]}}</span></p>
                    </div>
                    <!--<f7-chip :text="listSizes[index]" class="lineclampin1" style="position:absolute;bottom:12vh;left:5px;z-index:99;color:#FFFFFF;background-color:#000000;opacity:0.8"></f7-chip>-->
                  </div>
                  <div style="position:absolute;top:10px;left:10px;z-index:99;background-color:#5ddcf9;border-radius:50%;color:#000000;width:46px;height:46px;opacity:0.9;text-align:center">
                    <p style="font-size:20px;font-weight:bold;margin:6px 0px 0px;padding:0px;line-height:20px">{{discount[index]}}</p>
                    <p style="font-size:10px;font-weight:bold;margin:0px;padding:0px;line-height:12px">% OFF</p>
                  </div>
                  <f7-block style="color:gray;font-size:14px;font-weight:bold;padding:8px">
                    <p class="mpzero lineclampin">
                      <span v-show="result.specialDiscount == false" style="color:#000000;font-size:17px">&#8377;{{result.selling_price}}</span>
                      <span v-show="result.specialDiscount == true" style="color:#000000;font-size:17px;text-decoration:line-through;margin-left:0px">&#8377;{{result.selling_price}}</span>
                      <span style="text-decoration:line-through;margin-left:3px">&#8377;{{result.mrp_price}}</span>
                    </p>
                    <div v-if="result.wishlistflag ==0" style="position:absolute;top:6px;right:8px;z-index:99;background-color:transparent;border-radius:20px;width:70px;height:26px;border:1px solid #606770">
                      <f7-link  
                         @click="addToWishlist(result.id,0,result.wishlistflag,index)" 
                         style="position:absolute;top:4px;right:8px;color:#606770;line-height:18px"><img src="../assets/thumbs-up.svg" alt="">&nbsp Like</f7-link>
                    </div>
                    <div v-if="result.wishlistflag==1" style="position:absolute;top:6px;right:8px;z-index:99;background-color:transparent;border-radius:20px;width:70px;height:26px;border:1px solid #008000">
                      <f7-link @click="addToWishlist(result.id,1,result.wishlistflag,index)" 
                        style="position:absolute;top:4px;right:8px;color:#008000;line-height:18px"><img src="../assets/thumbs-up_green.svg" alt="">&nbsp Like</f7-link>
                    </div>
                    <p class="mpzero lineclampin" style="margin-top:12px">
                    <img src="../assets/shop_icon.png" style="width:24px;height:24px;border-radius:50%;vertical-align: middle;" alt="Shops">&nbsp {{result.shop_name}}</p>
                  </f7-block>
                </f7-card>
              </f7-link>
          </f7-col>
      </template>
    </f7-row>
        <f7-segmented style="position:fixed;bottom:0;z-index:999;width:100%;background-color:white;border-radius:0px;box-shadow: 5px 0px 10px rgba(0, 0, 0, 0.12);border-radius:30px 30px 0px 0px">
          <f7-button big sheet-open=".sortsheet" icon-f7="sort" color="black" style="font-size:18px;font-weight:bold;text-transform:capitalize">&nbsp Sort</f7-button>
          <f7-button big popup-open=".filterpopup" icon-f7="filter" color="black" style="font-size:18px;font-weight:bold;text-transform:capitalize">&nbsp Filter</f7-button>
        </f7-segmented>

          <f7-sheet ref="sortsheet" class="sortsheet" style="border-radius:30px 30px 0px 0px">
              <f7-block-title style="margin:0px;padding:28px 20px;font-size:18px;font-weight:bold;color:#000000">
               <f7-icon f7="sort" style="font-size:30px"></f7-icon>&nbsp Sort by
               <f7-button sheet-close outline @click="ApplySort()" color="black" style="font-size:14px;font-weight:bold;line-height:22px;position:absolute;right:20px;top:25px;text-transform:capitalize;padding:5px 15px;border-radius:20px">Apply</f7-button>
              </f7-block-title>
              <f7-block style="margin:0px;padding:7px">
                  <f7-list style="margin:0px;color:gray;font-size:16px;font-weight:bold">
                    <label class="item-content item-radio"><input name="shopsortradio" v-model="sortby" value="ltoh" type="radio"><i class="icon icon-radio"></i><div class="item-inner"><div class="item-title">Price - Low to High</div></div></label>
                    <label class="item-content item-radio"><input name="shopsortradio" v-model="sortby" value="htol" type="radio"><i class="icon icon-radio"></i><div class="item-inner"><div class="item-title">Price - High to Low </div></div></label>
                  </f7-list>
              </f7-block>
        </f7-sheet>

        <f7-sheet ref="loginsheet" class="loginsheet" style="height:150px">
          <center>
            <img src="../assets/fashiostreet.png" style="height:40px;margin-top:10px" alt="">
          </center>
              <f7-block-title style="margin:0px;padding:15px;text-align:center"><h5 class="mpzero">YOU ARE NOT LOGGED IN</h5>
              </f7-block-title>
              <f7-block style="margin:0px">
                  <f7-segmented style="border-top:1px solid #E0E0E0">
                    <f7-button color="green" href="/login/" sheet-close style="font-size:12px;font-weight:bold">LOG IN</f7-button>
                    <f7-button color="green" href="/signup/" sheet-close style="font-size:12px;font-weight:bold">SIGN UP</f7-button>
                  </f7-segmented>
              </f7-block>
        </f7-sheet>
        <div v-show="productDone==true && showPreloader==false && productinfo.length>0">
          <center>
            <h2 style="padding:10px 0px">More Products Coming Soon</h2>
            <h4 style="margin:18px 0px 10px 0px">Shopkeepers Are Soon Adding Great {{category}}</h4>
            <h3 style="margin:0px 0px 30px 0px">Stay Tuned !</h3>
            <span style="font-size:38px;font-weight:800;border: 1px solid #000000;border-radius:5px;padding:5px 10px;">OR</span>
            <h2 style="padding:10px 0px">Use Specific Want Feature</h2>
            <f7-link href="/specificPage" style="width:100%;height:18vh;padding:0px 15px 28px 15px">
            <img src="../assets/featurebanner1.png" style="width:100%;height:100%;border-radius:5px" alt="Specific Want Order">
            </f7-link>
          </center>
        </div>
        <f7-popup class="filterpopup1 content">
          <f7-page infinite :infinite-distance="20" :infinite-preloader="showPreloader1" @infinite="loadMore1">
            <f7-navbar class="bgnav" style="border-radius:0px 0px 30px 0px;box-shadow: 5px 0px 10px rgba(0, 0, 0, 0.12)" sliding>
              <f7-nav-left>
                <f7-link icon-f7="icon-arrow_left" style="padding:21px" @click="clearParam1" popup-close></f7-link>
              </f7-nav-left>
              <f7-nav-title style="font-size:18px;font-weight:bold;margin:0px">
                {{filterText}}
              </f7-nav-title>
            </f7-navbar>
            <div v-if="AppLoader1" style="position:fixed;width:100%;height:100vh;background-color: rgba(255,255,255,0.8);z-index:99">
      <center>
        <div class="preloader" style="margin-top:45vh">
        <span class="preloader-inner">
          <span class="preloader-inner-gap"></span>
          <span class="preloader-inner-left">
              <span class="preloader-inner-half-circle"></span>
          </span>
          <span class="preloader-inner-right">
              <span class="preloader-inner-half-circle"></span>
          </span>
        </span>
        </div>
      </center>
    </div>
            <div style="padding:16px 0px 25px 0px" v-show="selectedSize==true">
              <p style="font-size:16px;font-weight:bold;padding:0px 0px 20px 16px;margin:0px">Which price are you looking for?</p>
              <div style="overflow-x:scroll;overflow-y:hidden;white-space:nowrap;padding:0px 0px 0px 16px;font-weight:bold">
                <f7-button @click="savePrice1('0-299')" style="display:inline-block;padding:0px 12px;border-radius:4px;border:1px solid gray;margin:0px 8px 0px 0px;color:#212121;color:#212121">Under ₹ 299</f7-button>
                <f7-button @click="savePrice1('300-399')" style="display:inline-block;padding:0px 12px;border-radius:4px;border:1px solid gray;margin:0px 8px 0px 0px;color:#212121">₹ 300 - ₹ 399</f7-button>
                <f7-button @click="savePrice1('400-499')" style="display:inline-block;padding:0px 12px;border-radius:4px;border:1px solid gray;margin:0px 8px 0px 0px;color:#212121">₹ 400 - ₹ 499</f7-button>
                <f7-button @click="savePrice1('500-599')" style="display:inline-block;padding:0px 12px;border-radius:4px;border:1px solid gray;margin:0px 8px 0px 0px;color:#212121">₹ 500 - ₹ 699</f7-button>
                <f7-button @click="savePrice1('600-799')" style="display:inline-block;padding:0px 12px;border-radius:4px;border:1px solid gray;margin:0px 8px 0px 0px;color:#212121">₹ 600 - ₹ 799</f7-button>
              </div>
            </div>
           <div style="padding:16px 0px 25px 0px" v-show="selectedPrice==true">
            <p style="font-size:16px;font-weight:bold;padding:0px 0px 20px 16px;margin:0px">What size are you looking for?</p>
            <div style="overflow-x:scroll;overflow-y:hidden;white-space:nowrap;padding:0px 0px 0px 16px;font-weight:bold">
              <template v-for="size in sizesData">
                 <f7-button @click="saveSize1(size.name)" style="display:inline-block;padding:0px 16px;border-radius:4px;border:1px solid gray;margin:0px 11px 0px 0px;color:#212121">{{ size.name }}</f7-button>     
              </template>
            </div>
          </div>
          <f7-row no-gap style="border-top:1px solid #f1f3f6">
          <template v-for="(result,index) in productinfo1">
          <f7-col width="50" class="col_hgt" style="height:47vh;border-right:1px solid #f1f3f6;border-bottom:1px solid #f1f3f6">
              <f7-link :href="'/productdetails/' + result.id + '/' + result.name" style="width:100%">
                <f7-card style="width:100%;height:100%;margin:0px;padding:0px;-webkit-box-shadow: none;box-shadow: none">
                  <div class="image_viewer" style="width: 100%;height:35vh;">
                    <img :src="result.image" style="width:100%;height:100%;margin:0px;object-fit: contain">
                    <div v-show="result.specialDiscount == true" style="max-width:120px;position:absolute;z-index:99;bottom:84px;left:0px;background-image: linear-gradient(to right, #8E2DE2, #4A00E0);color:#FFFFFF;border-radius:0px 30px 30px 0px;font-size:16px;font-weight:bold;padding:3px 8px">
                      <p class="mpzero lineclampin" style="font-size:16px">&#8377;{{result.specialDiscountedPrice}}<span style="font-size:12px;line-height:17px;height:17px"> - {{offers2[index]}}</span></p>
                    </div>
                    <!--<f7-chip :text="listSizes[index]" class="lineclampin1" style="position:absolute;bottom:12vh;left:5px;z-index:99;color:#FFFFFF;background-color:#000000;opacity:0.8"></f7-chip>-->
                  </div>
                  <div style="position:absolute;top:10px;left:10px;z-index:99;background-color:#5ddcf9;border-radius:50%;color:#000000;width:46px;height:46px;opacity:0.9;text-align:center">
                    <p style="font-size:20px;font-weight:bold;margin:6px 0px 0px;padding:0px;line-height:20px">{{discount1[index]}}</p>
                    <p style="font-size:10px;font-weight:bold;margin:0px;padding:0px;line-height:12px">% OFF</p>
                  </div>
                  <f7-block style="color:gray;font-size:14px;font-weight:bold;padding:8px">
                    <p class="mpzero lineclampin">
                      <span v-show="result.specialDiscount == false" style="color:#000000;font-size:17px">&#8377;{{result.selling_price}}</span>
                      <span v-show="result.specialDiscount == true" style="color:#000000;font-size:17px;text-decoration:line-through;margin-left:0px">&#8377;{{result.selling_price}}</span>
                      <span style="text-decoration:line-through;margin-left:3px">&#8377;{{result.mrp_price}}</span>
                    </p>
                    <div v-if="result.wishlistflag ==0" style="position:absolute;top:6px;right:8px;z-index:99;background-color:transparent;border-radius:20px;width:70px;height:26px;border:1px solid #606770">
                      <f7-link  
                         @click="addToWishlist1(result.id,0,result.wishlistflag,index)" 
                         style="position:absolute;top:2px;right:8px;color:#606770"><img src="../assets/thumbs-up.svg" alt="">&nbsp Like</f7-link>
                    </div>
                    <div v-if="result.wishlistflag==1" style="position:absolute;top:6px;right:8px;z-index:99;background-color:transparent;border-radius:20px;width:70px;height:26px;border:1px solid #008000">
                      <f7-link @click="addToWishlist1(result.id,1,result.wishlistflag,index)" 
                        style="position:absolute;top:2px;right:8px;color:#008000"><img src="../assets/thumbs-up_green.svg" alt="">&nbsp Like</f7-link>
                    </div>
                    <p class="mpzero lineclampin" style="margin-top:8px">
                    <img src="../assets/shop_icon.png" style="width:24px;height:24px;border-radius:50%;vertical-align: middle;" alt="Shops">&nbsp {{result.shop_name}}</p>
                  </f7-block>
                </f7-card>
              </f7-link>
          </f7-col>
      </template>
    </f7-row>
    <div v-show="productMsg1!=null">
          <center>
            <h2 style="padding:10px 0px">{{ productMsg1 }}</h2>
            <h4 style="margin:18px 0px 10px 0px">Shopkeepers Will Soon Add Great {{category}}</h4>
            <h3 style="margin:0px 0px 30px 0px">Stay Tuned !</h3>
            <span style="font-size:38px;font-weight:800;border: 1px solid #000000;border-radius:5px;padding:5px 10px;">OR</span>
            <h2 style="padding:10px 0px">Use Specific Want Feature</h2>
            <f7-link href="/specificPage" style="width:100%;height:18vh;padding:0px 15px 28px 15px">
            <img src="../assets/featurebanner1.png" style="width:100%;height:100%;border-radius:5px" alt="Specific Want Order">
            </f7-link>
          </center>
        </div>
    </f7-page>
        </f7-popup>
        <f7-popup class="filterpopup">
            <f7-navbar class="bgnav" style="border-radius:0px 0px 30px 0px;box-shadow: 5px 0px 10px rgba(0, 0, 0, 0.12)" sliding>
              <f7-nav-left>
                <f7-link icon-f7="icon-arrow_left" style="padding:21px" popup-close></f7-link>
              </f7-nav-left>
              <f7-nav-title style="font-size:18px;font-weight:bold;margin:0px">
                Filters
              </f7-nav-title>
              <f7-nav-right>
                <f7-link popup-close @click="clearFilter()"><h6 style="font-size:18px;font-weight:bold">Clear All</h6></f7-link>
              </f7-nav-right>
            </f7-navbar>
            <f7-row no-gap style="height:100%;font-weight:bold">
          <f7-col width="35" style="color:#000000">
              <f7-list no-hairlines-between style="margin:0px;padding:0px">
                  <f7-list-item link title="Price" @click='shop = false,price = true,size=false,color=false,brand=false'/>
                  <f7-list-item link title="Size" @click='shop = false,price = false,size=true,color=false,brand=false'/>
                  <f7-list-item link title="Color" @click='shop = false,price = false,size=false,color=true,brand=false'/>
                  <f7-list-item link title="Shop" @click='shop = true,price = false,size=false,color=false,brand=false'/>
              </f7-list>
              </f7-col>
          <f7-col class="box" width="65" style="padding-left:10px;background-color:white;height:100%;overflow-y:scroll;color:#000000;border-left:1px solid #000000">
            <f7-block v-show='shop' style="margin:0px;padding:0px">
              <form data-v-532328bc="" class="searchbar searchbar-enabled" disable-link-text="Cancel"><div class="searchbar-inner"><div class="searchbar-input-wrap"><input placeholder="Search shop" v-model="shopsearch" type="search" class=""><i class="searchbar-icon"></i><span class="input-clear-button"></span></div><span class="searchbar-disable-button">Cancel</span></div></form>
              <center>
                <div v-if="shopData.length <= 0" class="preloader" style="margin-top:5vh">
                  <span class="preloader-inner">
                    <span class="preloader-inner-gap"></span>
                    <span class="preloader-inner-left">
                        <span class="preloader-inner-half-circle"></span>
                    </span>
                    <span class="preloader-inner-right">
                        <span class="preloader-inner-half-circle"></span>
                    </span>
                  </span>
                </div>
              </center>
              <div v-if="shopData.length <= 0">
                <center><h3>no Shop found</h3></center>
              </div>
              <f7-list v-if="shopData.length > 0" style="margin:0px;padding:0px">
                  <template v-for="shop in shopData">
                    <label class="item-radio item-content">
                      <input type="radio" v-model="shopfilter" :value="shop.name"/>
                      <i class="icon icon-radio"></i>
                      <div class="item-inner">
                        <div class="item-title">{{ shop.name }}</div>
                      </div>
                    </label>
                  </template>
                <br/><br/><br/><br/><br/>
              </f7-list>
            </f7-block>
            <f7-block  v-show='price' style="margin:0px;padding:0px">
              <f7-list style="margin:0px;padding:0px">
                <label class="item-content item-checkbox"><input type="checkbox" v-model="pricefilter" value="0-299"><i class="icon icon-checkbox"></i><div class="item-inner"><div class="item-title">Below &#8377;300</div></div></label>
                <label class="item-content item-checkbox"><input type="checkbox" v-model="pricefilter" value="300-399"><i class="icon icon-checkbox"></i><div class="item-inner"><div class="item-title">&#8377;300-399</div></div></label>
                <label class="item-content item-checkbox"><input type="checkbox" v-model="pricefilter" value="400-499"><i class="icon icon-checkbox"></i><div class="item-inner"><div class="item-title">&#8377;400-499</div></div></label>
                <label class="item-content item-checkbox"><input type="checkbox" v-model="pricefilter" value="500-599"><i class="icon icon-checkbox"></i><div class="item-inner"><div class="item-title">&#8377;500-599</div></div></label>
                <label class="item-content item-checkbox"><input type="checkbox" v-model="pricefilter" value="600-699"><i class="icon icon-checkbox"></i><div class="item-inner"><div class="item-title">&#8377;600-699</div></div></label>
                <label class="item-content item-checkbox"><input type="checkbox" v-model="pricefilter" value="700-799"><i class="icon icon-checkbox"></i><div class="item-inner"><div class="item-title">&#8377;700-799</div></div></label>
                <label class="item-content item-checkbox"><input type="checkbox" v-model="pricefilter" value="800-1000"><i class="icon icon-checkbox"></i><div class="item-inner"><div class="item-title">Above &#8377;800-1000</div></div></label>
                <br/><br/><br/><br/><br/>
              </f7-list>
            </f7-block>
            <f7-block v-show='size' style="margin:0px;padding:0px">
              <center>
                <div v-if="filerloader" class="preloader" style="margin-top:5vh">
                  <span class="preloader-inner">
                    <span class="preloader-inner-gap"></span>
                    <span class="preloader-inner-left">
                        <span class="preloader-inner-half-circle"></span>
                    </span>
                    <span class="preloader-inner-right">
                        <span class="preloader-inner-half-circle"></span>
                    </span>
                  </span>
                </div>
              </center>
              <div v-if="sizesData.length <= 0">
                <center><h3>No Sizes Found</h3></center>
              </div>
              <f7-list v-if="!filerloader" style="margin:0px;padding:0px">
                  <template v-for="size in sizesData">
                    <label class="item-content item-checkbox"><input type="checkbox" v-model="sizefilter" :value="size.name"><i class="icon icon-checkbox"></i><div class="item-inner"><div class="item-title">{{ size.name }}</div></div></label>
                  </template>
                <br/><br/><br/><br/><br/>
              </f7-list>
            </f7-block>
            <f7-block v-show='color' style="margin:0px;padding:0px;height:90vh">
              <f7-list sortable style="margin:0px;padding:0px">
                <template v-for="color in colorData">
                  <label class="item-content item-checkbox"><input v-model="colorfilter" :value="color" type="checkbox"><i class="icon icon-checkbox"></i><div class="item-inner"><div class="item-title" style="text-transform:capitalize">{{ color }}</div></div></label>
                </template>
                <br/><br/><br/><br/><br/>
              </f7-list>
            </f7-block>
          </f7-col>
        </f7-row>
        <div style="position:fixed;bottom:0;z-index:999;width:100%;background-color:#FFFFFF;box-shadow: 5px 0px 10px rgba(0, 0, 0, 0.12);border-radius:30px 30px 0px 0px">
          <f7-button @click="applyFilter" big fill popup-close style="background-image: linear-gradient(to right, #11998e, #38ef7d);color:#FFFFFF;font-size:18px;font-weight:bold;border:0px;text-transform:Capitalize;margin:10px;border-radius:30px">Apply</f7-button>
        </div>
        </f7-popup>
      </div>
    </div>
  </f7-page>
</template>

<script>
import offline from 'v-offline';
  import axios from '../axios'
export default {
  name: 'Products',
  data() {
    return {
      title: 'Services Page',
      inProcess:false,
      Cleartime:null,
      AppLoader:false,
      AppLoader1:false,
      filerloader:false,
      sizesData:[],
      page:1,
      page1:1,
      q:null,
      q1:null,
      category:localStorage.getItem("product"),
      showPreloader:true,
      showPreloader1:true,
      allowInfinite:true,
      allowInfinite1:true,
      sizefilter:[],
      productDone : false,
      productDone1:false,
      colorData:[
        'black',
        'green',
        'yellow',
        'gray',
        'maroon',
        'blue',
        'dark blue',
        'skin',
        'white',
        'brown',
        'orange',
        'purple',
        'multicolor',
        'red',
        'pink'
      ],
      colorfilter:[],
      pricefilter:[],
      filterText:null,
      selectedSize:false,
      selectedPrice:false,
      shopData:[],
      shopsearch:null,
      shopfilter:null,
      sortby:"ltoh",
      productinfo:[],
      productinfo1:[],
      productMsg:null,
      productMsg1:null,
      toast_msg:null,
      productload:true,
      productload1:true,
      price:true,
      color:false,
      brand:false,
      size:false,
      shop:false,
      internet:null,
      status:'not shown',
      product:null,
      preloader:false,
      preloader1:false,
      urlParam:{},
      urlParam1:{},
      discount:[],
      discount1:[],
      url:'/product/' + localStorage.getItem("city") + '/' + localStorage.getItem("product") + '/json',
      url1:'/product/' + localStorage.getItem("city") + '/' + localStorage.getItem("product") + '/json',
      loadMoreProduct:[],
      loadMoreProduct1:[],
      gender:localStorage.getItem('gender'),
      cartinfo:[],
      wishlistinfo:[],
      listSizes:[],
      offers1:[],
      offers2:[]
    };
  },
    components: {
    offline
  },
  created(){
    var url = window.location.href;
    if(url.indexOf('?q=') != -1) {
      url = url.substring(url.indexOf("?q=") + 3);
      url = decodeURIComponent(url);
    }
    else{
      url = undefined;
    }
    this.q = url;
    if(this.q == 'undefined')
    {
      this.q = undefined;
    }
  },
  mounted(){
    this.init();
    this.getCart();
    this.getProduct();
    this.getSizes();
    this.getShop();
    this.productDone= true;
  },
  watch:{
    sizefilter:function(newVal,oldVal){
      var length = this.sizefilter.length;
      if(length >= 5)
      {
        this.sizefilter = oldVal;
        alert('max five size filter allow');
        return false;
      }
    },
    colorfilter:function(newVal,oldVal){
      var length = this.colorfilter.length;
      if(length >= 5)
      {
        this.colorfilter = oldVal;
        alert('max five color filter allow');
        return false;
      }
    },
    pricefilter:function(newVal,oldVal){
      var length = this.pricefilter.length;
      if(length >= 5)
      {
        this.pricefilter = oldVal;
        alert('max five price filter allow');
        return false;
      }
    },
    shopsearch:function(){

      this.searchShop();
    }
  },
  methods:{
    saveSize(size)
    { 
      this.urlParam1.size = '';
      this.filterText = '';
      this.productMsg1 = null;
      this.urlParam1.size = size;
      this.selectedSize = true;
      this.selectedPrice = false;
      console.log(size);
      this.filterText = 'Items in '+ size + ' Size';
      this.inProcess1 = true; 
      this.preloader1 = true;
      this.getProduct1();
      //console.log(this.urlParam1);
    },
    savePrice(price)
    {
      this.urlParam1.price = '';
      this.filterText = '';
      this.urlParam1.price = price;
      this.selectedPrice = true;
      this.productMsg1 = null;
      this.selectedSize = false;
      console.log(price);
      this.filterText = 'Items in ₹ '+ price;
      this.inProcess1 = true;
      this.preloader1 = true;
      this.getProduct1();
      //console.log(this.urlParam1);
    },
    savePrice1(price)
    {
      this.urlParam1.price = price;
      this.urlParam1.size = this.urlParam1.size; 
      this.productinfo1 = [];
      this.productMsg1 = null;
      this.page1 = 1;
      this.filterText = 'Items in '+this.urlParam1.size + ' Size & ₹ '+price;
      this.inProcess1 = true;
      this.preloader1 = true;
      this.getProduct1();
      console.log(this.urlParam1);
    },
    saveSize1(size)
    {
      this.urlParam1.size = size;
      this.urlParam1.price = this.urlParam1.price;
      this.productinfo1 = [];
      this.productMsg1 = null;
      this.page1 = 1;
      this.filterText = 'Items in ₹ '+this.urlParam1.price + ' & ' + size + ' Size';
      this.inProcess1 = true;
      this.preloader1 = true;
      this.getProduct1();
      console.log(this.urlParam1);
    },
    clearParam1()
    {
      this.urlParam1 = {};
      console.log('hgbj');
      this.page1 = 1;
      this.productinfo1 = [];
    },
    save()
    {
      var value = '';
      if(localStorage.getItem('gender')=='Footwear')
      {
        value = 'footwear';
      }
      else if(localStorage.getItem('gender')=='Deodorant')
      {
        value = 'deodorant';
      }
      else
      {
        value = 'clothing';
      }
      localStorage.setItem('specific',value);
      localStorage.setItem('gen',localStorage.getItem('gender'));
            localStorage.setItem('cat',localStorage.getItem('product'));
    },
    handleConnectivityChange(status) {
      this.internet = status;
      console.log(this.internet);
      if(this.internet == false)
      {
        this.showNotificationWithButton();
      }
      if(this.internet == true)
      {
        this.closepop();
      }
    },
     showNotificationWithButton() {
        const self = this;

        if (!self.notificationWithButton) {
          self.notificationWithButton = self.$f7.notification.create({
            icon: '',
            title: '',
            cssClass:'color',
            subtitle: 'Please Connect to Internet',
            text: ''
          });
        }
        // Open it
        self.notificationWithButton.open();
      },
    closepop:function(){
      const self = this;
      self.notificationWithButton.close();
    },
    openPopup:function(){

      if(this.status == 'notshown')
      {
      this.popupOpened = true;

      this.status = 'shown';

      }
    },
    Pageback:function(route){
      //source.cancel();
      //cancel();
      route.back();
    },
    getCart:function(event,done){
      axios({
        method:'GET',
        url : 'user/viewcart/json'
      }).then(response => {
        this.cartinfo = response.data.result;
      }).catch(error => {
        //alert('hi8');
        if(error.response.data.message != undefined)
        {
          alert(error.response.data.message);
        }
        else
          alert('Something went wrong,please try again');
        done();
      });
    },
    getWishlist:function(){
      //this.preloader = true;
      axios({
        method:'GET',
        url : '/user/wishlist/json?page=' + this.page
      }).then(response => {

          this.wishlistinfo=response.data.result;

      }).catch(error => {
        if(error.response.data.message != undefined)
        {
          alert(error.response.data.message);
          alert('hi7');
        }
        else
          alert('Something went wrong,please try again');

      });
    },
    clearFilter:function(){
      this.init();
      this.page = 1;
      this.getProduct();
      this.showPreloader = true;
      this.productinfo = [];
    },
    loadMore:function(){
      const self = this;
      if(this.loadMoreProduct.length >= 15)
      {
        self.allowInfinite = true;
      }
      else{
        self.allowInfinite = false;
        this.showPreloader = false;
        return false;
      }
      if(!self.allowInfinite) return;
      self.allowInfinite = false;
      if(this.loadMoreProduct.length >= 15)
      {
        if(this.inProcess == false) {
          this.inProcess = true;
          this.getProduct();
          self.allowInfinite = true;
          return true;
        }
      }
      else{
        this.showPreloader = false;
      }
      return false;
    },
    loadMore1:function(){
      const self = this;
      if(this.loadMoreProduct1.length >= 15)
      {
        self.allowInfinite1 = true;
      }
      else{
        self.allowInfinite1 = false;
        this.showPreloader1 = false;
        return false;
      }
      if(!self.allowInfinite1) return;
      self.allowInfinite1 = false;
      if(this.loadMoreProduct1.length >= 15)
      {
        if(this.inProcess1 == false) {
          this.inProcess1 = true;
          this.getProduct1();
          self.allowInfinite1 = true;
          return true;
        }
      }
      else{
        this.showPreloader1 = false;
      }
      return false;
    },
    init:function(){
      this.urlParam = {
        'shop': 'All Shop',
        'gender': localStorage.getItem("gender"),
        'category': localStorage.getItem("category")
      },
        this.shopfilter = null;
      this.colorfilter = [];
      this.sizefilter = [];
      this.pricefilter = [];
    },
    applyFilter:function(){
      this.page =1;
      this.showPreloader = true;
      this.allowInfinite = true;
      this.productinfo = [];
      if(this.colorfilter.length > 0)
      {
        this.urlParam.color = '';
        for(var i=0;i < this.colorfilter.length;i++)
        {
          this.urlParam.color = this.urlParam.color + this.colorfilter[i] + ' and ';
        }
        this.urlParam.color = this.urlParam.color.substring(0, this.urlParam.color.length - 5);
      }
      if(this.sizefilter.length > 0)
      {
        this.urlParam.size = '';
        for(var i=0;i < this.sizefilter.length;i++)
        {
          this.urlParam.size = this.urlParam.size + this.sizefilter[i] + ' and ';
        }
        this.urlParam.size = this.urlParam.size.substring(0,this.urlParam.size.length - 5);
      }
      if(this.pricefilter.length > 0)
      {
        this.urlParam.price = '';
        for(var i=0;i < this.pricefilter.length;i++)
        {
          this.urlParam.price = this.urlParam.price + this.pricefilter[i] + ' and ';
        }
        this.urlParam.price = this.urlParam.price.substring(0,this.urlParam.price.length - 5);
        console.log(this.urlParam.price);
      }
      if(this.shopfilter != null)
      {
        this.urlParam.shop = this.shopfilter;
      }
      this.getProduct();
      return true;
    },
    applyFilter1:function(){
      this.page1 =1;
      this.showPreloader1 = true;
      this.allowInfinite1 = true;
      this.productinfo1 = [];
      this.getProduct1();
      return true;
    },
    getShop:function(){
      setTimeout(() => {
        var url  = '/shop/json1?city=' + localStorage.getItem('city');
        var axiosMeta = {
          method: 'POST',
          url: url,
          data:{
            'gender': localStorage.getItem("gender"),
            'category': localStorage.getItem("category")
          }
          //cancelToken:source.token
        };
        if(localStorage.getItem('local_id') && localStorage.getItem('token')){
          axiosMeta.header = {
            'local-id' : localStorage.getItem('local_id'),
            'token' : localStorage.getItem('token')
          };
        }
        axios(axiosMeta).then(response => {
          this.shopData = response.data.result;
          console.log(this.shopData);
        }).catch(error => {
          if(error.response.data.message != undefined)
          {
            //alert(error.response.data.message);
            //alert('hi6');
          }
          else
            alert('application error found,restart your application');
        });
      },500);
    },
    searchShop:function(){
      if(this.shopsearch == null || this.shopsearch == '')
      {
        this.getShop();
        return true;
      }
      setTimeout(() => {
        var url  = '/search/shop?city=' + localStorage.getItem('city') + '&shop=' + this.shopsearch;
        var axiosMeta = {
          method: 'POST',
          url: url,
          //cancelToken:source.token
        };
        if(localStorage.getItem('local_id') && localStorage.getItem('token')){
          axiosMeta.header = {
            'local-id' : localStorage.getItem('local_id'),
            'token' : localStorage.getItem('token')
          };
        }
        axios(axiosMeta).then(response => {
          this.shopData = response.data;
        }).catch(error => {
          if(error.response.data.message != undefined)
          {
            alert(error.response.data.message);
            //alert('hi5');
          }
          else
            alert('application error found,restart your application');
        });
      },500);
    },
    getSizes:function(){
      this.filerloader = true;
      setTimeout(() => {
        var url  = '/product/sizes/json?sub_category='+ localStorage.getItem('product') +'&category='+ localStorage.getItem('category') +'&gender=' + localStorage.getItem('gender');
        var axiosMeta = {
          method: 'GET',
          url: url,
          //cancelToken:source.token
        };
        if(localStorage.getItem('local_id') && localStorage.getItem('token')){
          axiosMeta.header = {
            'local-id' : localStorage.getItem('local_id'),
            'token' : localStorage.getItem('token')
          };
        }
        axios(axiosMeta).then(response => {
          this.sizesData = response.data.result;
          this.filerloader = false;
        }).catch(error => {
          if(error.response.data.message != undefined)
          {
            alert(error.response.data.message);
            //alert('hi4');
          }
          else
            alert('application error found,restart your application');
          this.filerloader = false;
        });
      },500);
    },
    getProduct2:function(event,done) {
      this.showPreloader = true;
      done();
      this.preloader = true;
      this.getProduct(event,done,1);
    },
    getProduct2_1:function(event,done) {
      this.showPreloader1 = true;
      done();
      this.preloader1 = true;
      this.getProduct1(event,done,1);
    },
    getProduct:function(event,done,index){
      //console.log(localStorage.getItem('userId'));
      setTimeout(() => {
        var url  = this.url + '?';
        console.log('q : ' + this.q);
        if(this.q != undefined)
        {
          this.urlParam.q = this.q;
        }
        if(index != undefined)
        {
          this.urlParam.page = index;
        }
        else{
          this.urlParam.page = this.page;
        }
        this.urlParam.sort = "ltoh";
        for(var key in this.urlParam)
        {
          url = url + key + '=' + this.urlParam[key] + '&';
        }
        url = url.slice(0, -1);
        console.log(url);
        var axiosMeta = {
          method: 'GET',
          url: url
        };
        if(localStorage.getItem('local_id') && localStorage.getItem('token')){
          axiosMeta.header = {
            'local-id' : localStorage.getItem('local_id'),
            'token' : localStorage.getItem('token')
          };
        }
        axios(axiosMeta).then((response) => {
          this.loadMoreProduct = response.data.result;
          console.log(this.loadMoreProduct);
          if(this.loadMoreProduct.original == 'No Product Found' && this.productload)
          {
            this.productMsg = 'No Products Right Now';
            this.loadMoreProduct = [];
            console.log("No Product console");
            this.productinfo = this.loadMoreProduct;
             console.log(this.productinfo.length);
          }
          else {
            this.product = localStorage.getItem("product");
            this.productload = false;
            if (this.page == 1) {
              this.productinfo = this.loadMoreProduct;
              console.log(this.productinfo.length);
              for(var i=0;i<this.productinfo.length;i++)
              {
                this.productinfo[i].mrp_price = Math.floor(this.productinfo[i].mrp_price);
                this.productinfo[i].selling_price = Math.floor(this.productinfo[i].selling_price);
                var a = this.productinfo[i].mrp_price - this.productinfo[i].selling_price;
                this.discount[i] = Math.round((a/this.productinfo[i].mrp_price)*100);
                if(this.productinfo[i].specialDiscount == true)
                {
                  this.discount[i] = this.productinfo[i].specialDiscountedPercentage;
                  this.offers1[i] = this.productinfo[i].offers[0];
                }
              }
            }
            else {
              this.productinfo = this.productinfo.concat(this.loadMoreProduct);
              for(var i=0;i<this.productinfo.length;i++)
              {
                this.productinfo[i].mrp_price = Math.floor(this.productinfo[i].mrp_price);
                this.productinfo[i].selling_price = Math.floor(this.productinfo[i].selling_price);
                var a = this.productinfo[i].mrp_price - this.productinfo[i].selling_price;
                this.discount[i] = Math.round((a/this.productinfo[i].mrp_price)*100);
                if(this.productinfo[i].specialDiscount == true)
                {
                  this.discount[i] = this.productinfo[i].specialDiscountedPercentage;
                  this.offers1[i] = this.productinfo[i].offers[0];
                }
              }
            }
            this.page = this.page + 1;
          }
          if(this.loadMoreProduct.length < 15)
          {
            this.showPreloader = false;
          }
          this.preloader = false;
          this.inProcess = false;
        },(error) => {
          this.showPreloader = false;
          this.inProcess = false;
          if(error.response.data.message != undefined)
          {
            if(error.response.data.message == 'no product found')
            {
              this.productMsg = 'no product found';
              this.preloader = false;
              return false;
            }
            alert(error.response.data.message);
          }
          else
            alert('application error found,restart your application');
          this.preloader = false;
        });
      },500);
    },
    getProduct1:function(event,done,index){
      //console.log(localStorage.getItem('userId'));
      this.urlParam1.shop = 'All Shop';
      this.urlParam1.gender =  localStorage.getItem("gender");
      this.urlParam1.category = localStorage.getItem("category");
      setTimeout(() => {
        var url1  = this.url1 + '?';
        console.log('q : ' + this.q1);
        if(this.q1 != undefined)
        {
          this.urlParam1.q = this.q1;
        }
        if(index != undefined)
        {
          this.urlParam1.page = index;
        }
        else{
          this.urlParam1.page = this.page1;
        }
        this.urlParam1.sort = "ltoh";
        console.log(this.urlParam1);
        for(var key in this.urlParam1)
        {
          url1 = url1 + key + '=' + this.urlParam1[key] + '&';
        }
        url1 = url1.slice(0, -1);
        console.log(url1);
        var axiosMeta = {
          method: 'GET',
          url: url1
        };
        if(localStorage.getItem('local_id') && localStorage.getItem('token')){
          axiosMeta.header = {
            'local-id' : localStorage.getItem('local_id'),
            'token' : localStorage.getItem('token')
          };
        }
        axios(axiosMeta).then((response) => {
          this.loadMoreProduct1 = response.data.result;
          console.log(this.loadMoreProduct1);
          if(this.loadMoreProduct1.original == 'No Product Found')
          {
            this.productMsg1 = 'No Products Right Now';
            this.loadMoreProduct1 = [];
            console.log("No Product console");
            this.productinfo1 = this.loadMoreProduct1;
             console.log(this.productinfo1.length);
          }
          else {
            this.product1 = localStorage.getItem("product");
            this.productload1 = false;
            if (this.page1 == 1) {
              this.productinfo1 = this.loadMoreProduct1;
              console.log(this.productinfo1.length);
              for(var i=0;i<this.productinfo1.length;i++)
              {
                this.productinfo1[i].mrp_price = Math.floor(this.productinfo1[i].mrp_price);
                this.productinfo1[i].selling_price = Math.floor(this.productinfo1[i].selling_price);
                var a = this.productinfo1[i].mrp_price - this.productinfo1[i].selling_price;
                this.discount1[i] = Math.round((a/this.productinfo1[i].mrp_price)*100);
                if(this.productinfo1[i].specialDiscount == true)
                {
                  this.discount1[i] = this.productinfo1[i].specialDiscountedPercentage;
                  this.offers2[i] = this.productinfo1[i].offers[0];
                }
              }
            }
            else {
              this.productinfo1 = this.productinfo1.concat(this.loadMoreProduct1);
              for(var i=0;i<this.productinfo1.length;i++)
              {
                this.productinfo1[i].mrp_price = Math.floor(this.productinfo1[i].mrp_price);
                this.productinfo1[i].selling_price = Math.floor(this.productinfo1[i].selling_price);
                var a = this.productinfo1[i].mrp_price - this.productinfo1[i].selling_price;
                this.discount1[i] = Math.round((a/this.productinfo1[i].mrp_price)*100);
                if(this.productinfo1[i].specialDiscount == true)
                {
                  this.discount1[i] = this.productinfo1[i].specialDiscountedPercentage;
                  this.offers2[i] = this.productinfo1[i].offers[0];
                }
              }
            }
            this.page1 = this.page1 + 1;
          }
          if(this.loadMoreProduct1.length < 15)
          {
            this.showPreloader1 = false;
          }
          this.preloader1 = false;
          this.inProcess1 = false;
          console.log('qwe');
        },(error) => {
          this.showPreloader1 = false;
          this.inProcess1 = false;
          console.log('gfhj');

          if(error.response.data.message != undefined)
          {
            if(error.response.data.message == 'No Product Found')
            {
              this.productMsg1 = 'no product found';
              this.preloader1 = false;
              return false;
            }
            alert(error.response.data.message);
            //alert('hi3');
          }

          else
            alert('application error found,restart your application');
          this.preloader1 = false;
        });
      },500);
    },
    ApplySort:function(){
      this.page =1;
      this.showPreloader = true;
      this.productinfo = [];
      this.urlParam.sort = this.sortby;
      this.$refs.sortsheet.close();
      this.getProduct();
    },
    addToWishlist1:function(product_id,status,el,index){
      if(localStorage.getItem('local_id') && localStorage.getItem('token'))
      {
        if(status == 1)
        {
          //this.getProduct();
          this.AppLoader = true;
          axios({
            method:'POST',
            url : 'user/deletewishlist/json',
            data:{
              'product_id' : product_id
            }
          }).then(response => {
             this.AppLoader = false;
             const self = this;
             this.productinfo1[index].wishlistflag = 0;
          self.notificationWithButton = self.$f7.notification.create({
            icon: '',
            title: '',
            cssClass:'color',
            subtitle: 'Product removed to Liked Items',
            text: ''
          });
          self.notificationWithButton.open();
            setTimeout(()=>{
              this.closepop();
            },2000);
            this.getWishlist();
            //this.getProduct();
          }).catch(error => {
            this.AppLoader = false;
            if(error.response.data.message != undefined)
            {
              alert(error.response.data.message);
              //alert('hi2');
            }
            else
              alert('failed to remove product from Liked Items');
          });
        }
        else {
          //this.getProduct();
          this.AppLoader = true;
          //this.toast_msg = 'please wait, product adding to wishlist...';
          axios({
            method: 'POST',
            url: '/user/addtowishlist',
            //cancelToken : source.token,
            data: {
              'product_id': product_id
            },
            header: {
              'local-id': localStorage.getItem('local_id'),
              'token': localStorage.getItem('token')
            }
          }).then(response => {
            el = 1;
            this.AppLoader = false;
             const self = this;
             this.productinfo1[index].wishlistflag = 1;
          self.notificationWithButton = self.$f7.notification.create({
            icon: '',
            title: '',
            cssClass:'color',
            subtitle: 'Product added to Liked Items',
            text: ''
          });
          self.notificationWithButton.open();
            setTimeout(()=>{
              this.closepop();
            },2000);
            //location.reload();
            this.getWishlist(); 
            //this.getProduct();
          },(error) => {
            this.AppLoader = false;
            setTimeout(() => {
              this.toast_msg = null;
            },2000);
            if (error.response.data.message != undefined) {
              alert(error.response.data.message);
              //alert('hi1');
            }
            else
              alert('application error found,restart your application');
          });
        }
      }
    },
    addToWishlist:function(product_id,status,el,index){
      if(localStorage.getItem('local_id') && localStorage.getItem('token'))
      {
        if(status == 1)
        {
          //this.getProduct();
          this.AppLoader = true;
          axios({
            method:'POST',
            url : 'user/deletewishlist/json',
            data:{
              'product_id' : product_id
            }
          }).then(response => {
             this.AppLoader = false;
             const self = this;
             this.productinfo[index].wishlistflag = 0;
          self.notificationWithButton = self.$f7.notification.create({
            icon: '',
            title: '',
            cssClass:'color',
            subtitle: 'Product removed to Liked Items',
            text: ''
          });
          self.notificationWithButton.open();
            setTimeout(()=>{
              this.closepop();
            },2000);
            this.getWishlist();
            //this.getProduct();
          }).catch(error => {
            this.AppLoader = false;
            if(error.response.data.message != undefined)
            {
              alert(error.response.data.message);
              //alert('hi2');
            }
            else
              alert('failed to remove product from Liked Items');
          });
        }
        else {
          //this.getProduct();
          this.AppLoader = true;
          //this.toast_msg = 'please wait, product adding to wishlist...';
          axios({
            method: 'POST',
            url: '/user/addtowishlist',
            //cancelToken : source.token,
            data: {
              'product_id': product_id
            },
            header: {
              'local-id': localStorage.getItem('local_id'),
              'token': localStorage.getItem('token')
            }
          }).then(response => {
            el = 1;
            this.AppLoader = false;
             const self = this;
             this.productinfo[index].wishlistflag = 1;
          self.notificationWithButton = self.$f7.notification.create({
            icon: '',
            title: '',
            cssClass:'color',
            subtitle: 'Product added to Liked Items',
            text: ''
          });
          self.notificationWithButton.open();
            setTimeout(()=>{
              this.closepop();
            },2000);
            //location.reload();
            this.getWishlist(); 
            //this.getProduct();
          },(error) => {
            this.AppLoader = false;
            setTimeout(() => {
              this.toast_msg = null;
            },2000);
            if (error.response.data.message != undefined) {
              alert(error.response.data.message);
              //alert('hi1');
            }
            else
              alert('application error found,restart your application');
          });
        }
      }
    }
  }
};
</script>
<style scoped>
  .md .navbar:after{
  content:none
  }
  .inWishlist{
    background-color: red;
    border: 0px solid red;
  }
  .lineclampin1{
    overflow: hidden !important;
    text-overflow: ellipsis !important;
    white-space: nowrap !important;
    max-width: 90% !important;
}
.lineclampin{
    overflow: hidden !important;
    text-overflow: ellipsis !important;
    white-space: nowrap !important;
    width: 100% !important;
}
.box.block::-webkit-scrollbar {
    display: none;
    -moz-appearance: none;
   }
 @media only screen and (max-height: 570px) {
    .pad{
      padding-bottom:10px !important
    }
    .col_hgt{
      height: 47.5vh !important;
    }
  }
  @media only screen and (max-height: 530px) {
    .col_hgt {
      height: 49.5vh !important;
    }
  }
</style>
