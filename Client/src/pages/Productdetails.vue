<template>
  <f7-page name="productdetails;"
           ptr @ptr:refresh="getproduct"
  >
    <f7-navbar back-link="Back" class="bgnav" style="border-radius:0px 0px 30px 0px;box-shadow: 5px 0px 10px rgba(0, 0, 0, 0.12)" sliding>
      <f7-nav-title style="margin:0px;padding-top:5px">
        <img src="../assets/fashiostreet.png" style="height:25px" alt="">
      </f7-nav-title>
      <f7-nav-right>
        <!-- <f7-link style="padding:0 10px" raised @click="actionGridOpened = true"><img src="../assets/share.svg" alt=""></f7-link>-->
        <f7-link style="padding:0 10px" href="/wishlist/" v-if="wishlistinfo.length>0"><img src="../assets/thumbs-up_white.svg" alt="">
          <span class="badge" v-if="wishlistinfo.length>0" style="border-radius: 16px;height: 20px;width: 20px;margin-top:-18px;margin-left:-1.5vw;background-color:#5ddcf9;color:#000000"><p style="margin-top: -19px;margin-left: -0.5vw;font-size:14px;font-weight:bold">{{wishlistinfo.length}}</p></span>
        </f7-link>
        <f7-link style="padding:0 10px" href="/wishlist/" v-else><img src="../assets/thumbs-up_white.svg" alt=""></f7-link>
        <f7-link style="padding:0 10px" href="/hdcart/" v-if="cartinfo.length>0"><img src="../assets/delivery-motorbike.svg" alt="">
          <span class="badge" v-if="cartinfo.length>0" style="border-radius: 16px;height: 20px;width: 20px;margin-top:-18px;margin-left:-1.5vw;background-color:#5ddcf9;color:#000000"><p style="margin-top: -19px;margin-left: -0.5vw;font-size:14px;font-weight:bold">{{cartinfo.length}}</p></span>
        </f7-link>
        <f7-link style="padding:0 10px" href="/hdcart/" v-else><img src="../assets/delivery-motorbike.svg" alt=""></f7-link>
      </f7-nav-right>
    </f7-navbar>
          <offline @detected-condition="handleConnectivityChange">
  </offline>
    <div v-if="AppLoader" style="position:fixed;width:100%;height:100vh;background-color: rgba(255,255,255,0.8);">
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
    <div class="content">
      <center v-if="preloader">
        <br/>
        <div class="preloader">
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
      <div v-if="!preloader">
        <div v-if="productinfo.length <= 0">
          <center><h3>{{ productMsg }}</h3></center>
        </div>
    <f7-block id="block" style="padding:0px;margin:0px">
    <div v-if="wishlist != 1" style="position:absolute;bottom:16px;right:0px;z-index:99;background-color:#FFFFFF;border-radius:20px 0px 0px 20px;width:80px;height:35px;border-top:1px solid #606770;border-left:1px solid #606770;border-bottom:1px solid #606770">
        <f7-link @click="addToWishlist()" style="position:absolute;top:8px;left:15px;color:#606770;line-height:18px"><img src="../assets/thumbs-up.svg" alt="">&nbsp Like</f7-link>
    </div>
    <div v-if="wishlist == 1" style="position:absolute;bottom:16px;right:0px;z-index:99;background-color:#FFFFFF;border-radius:20px 0px 0px 20px;width:80px;height:35px;border-top:1px solid #008000;border-left:1px solid #008000;border-bottom:1px solid #008000">
        <f7-link @click="addToWishlist()" style="position:absolute;top:8px;left:11px;color:#008000;line-height:18px"><img src="../assets/thumbs-up_green.svg" alt="">&nbsp Liked</f7-link>
    </div>
        <div v-if="image != null">
          <f7-photo-browser
            :photos="photos"
            type="popup",
            theme="dark",
            ref="standalone"
          ></f7-photo-browser>
        </div>
        <div style="position:absolute;bottom:16px;left:0px;z-index:99;color:#FFFFFF;background-color:#000000;opacity:0.6;border-radius:0px 20px 20px 0px;padding:6px 12px">Tap on image to zoom</div>
         <div style="height:65vh;background-color:#FFFFFF">
         <f7-swiper v-if="image != null" pagination>
           <template v-for="p_image in image">
             <f7-swiper-slide class="image_viewer" style="height:65vh">
               <center>
                 <f7-link @click="openPhotoBrowser()"><img style="max-width:100%;height:65vh;object-fit: contain"  :src="p_image" alt=""></f7-link>
               </center>
             </f7-swiper-slide>
           </template>
         </f7-swiper>
         </div>
    </f7-block>
    <div style="border-top:1px solid gray;border-radius:30px 30px 0px 0px;margin:2px 0px 0px">
    <f7-row no-gap v-show="specialDiscount==true" style="padding:0px;margin:8px 8px 0px 8px;padding:0px">
        <f7-col width="70" style="background-image: linear-gradient(to right, #8E2DE2, #4A00E0);color:#FFFFFF;border-radius:50px 0px 0px 50px;padding:8px 0px 8px 25px">
          <h5 style="margin:0px;font-size:12px">{{offer_name}} !</h5>
          <h3 style="margin:0px;font-size:22px">&#8377;{{specialDiscountedPrice}}</h3>
        </f7-col>
        <f7-col width="30" style="background-color:#06d4bb;color:#FFFFFF;border-radius:0px 50px 50px 0px;padding:11px 0px 11px 12px">
          <h5 style="margin:0px;font-size:12px">Ends On</h5>
          <h3 style="margin:0px;font-size:18px">{{offerDate}} {{offerMonth}}</h3>
        </f7-col>
    </f7-row>
    <f7-block style="border-radius:30px 30px 0px 0px;margin:0px;padding:28px 20px 0px 20px;background-color:#FFFFFF;color:gray;font-size:20px;font-weight:bold">
        <p class="mpzero">
        <span v-show="specialDiscount==true" style="margin-right:8px;color:#000000;font-size:24px;font-weight: bold;text-decoration:line-through">&#8377;{{selling}}</span>
        <span v-show="specialDiscount==false" style="margin-right:8px;color:#000000;font-size:24px;font-weight: bold;">&#8377;{{selling}}</span>
        <span style="text-decoration:line-through">&#8377;{{mrp}}</span>
        <f7-chip :text="discount+'% OFF'" class="lineclampin1" style="float:right;color:#000000;background-color:#5ddcf9;font-weight:bold;font-size:16px"></f7-chip>
        </p>
        <p style="color:orange;font-size:14px">
          Don't worry. Price are same that are in shops.
        </p>
        <h4 class="mpzero" style="color:#000000;text-transform: capitalize;font-size:18px">{{name}}</h4>
    </f7-block>
    </div>
    <f7-block style="background-color:white;padding:0px;margin:28px 0px 10px 10px;border:1px solid gray;border-right:0px;border-radius:30px 0px 0px 30px">
      <div style="padding:22px 16px 8px 20px">
        <div style="display:inline-block;height:30px">
          <img src="../assets/offer_icon.png" style="width:30px;height:30px;border-radius:50%;vertical-align: middle;" alt="Shops">
        </div>
        <div style="font-weight:bold;color:#000000;font-size:18px;display:inline-block;vertical-align: middle;" class="mpzero">&nbsp FS Offers</div>
      </div>
      <ul style="color:gray;font-size:16px;font-weight:bold;margin-bottom:0px">
          <li>
            <p style="margin-bottom:10px;padding:0px">Get Extra 5% &nbsp<img src="../assets/fashiostreet.png" style="height:20px;margin-bottom:-5px !important" alt="fslogo">&nbsp cashback on shop price.</p>
          </li>
        </ul>  
        <f7-list accordion-list style="margin:0px;color:#FFFFFF;margin-bottom:24px" no-hairlines-md>
          <f7-list-item accordion-item title="KNOW MORE" style="font-size:13px;color:gray;font-weight:bold;padding:0px 12px">
            <f7-accordion-content style="padding:0px 5px 0px 5px">
              <f7-block>
                <p style="font-size:13px;font-weight:bold"><f7-icon f7="info" style="color:green;font-size:12px"></f7-icon>&nbsp To get FS Cashback, you have to either Home Delivery from Fashiostreet OR Visit shop as a Fashiostreet customer by clicking on "VISIT SHOP" button below.</p>
              </f7-block>
            </f7-accordion-content>
          </f7-list-item>
        </f7-list>
    </f7-block>
    <f7-block style="background-color:white;padding:18px 10px 0px 0px;margin:0px">
      <div style="padding:24px 16px 28px 16px;border-radius:0px 30px 30px 0px;border:1px solid gray;border-left:0px">
       <f7-row no-gap>
        <f7-col width="65" class="lineclampin" style="font-size:18px;font-weight:bold;color:#000000;margin-top:3px;padding-right:5px">
        <img src="../assets/shop_icon.png" style="width:30px;height:30px;border-radius:50%;vertical-align: middle;" alt="Shops">&nbsp {{shop}}</f7-col>
        <f7-col width="35">
        <f7-button fill  @click="openVisitSheet" style="width:auto;background-color:#0d1635;color:#00ff96;font-weight:bold;text-transform:Capitalize;border-radius:30px">Visit Shop</f7-button>
        </f7-col>
       </f7-row>
       <f7-row style="margin-top:20px">
           <f7-col>
             <a @click="whatsapp" class="link external" :href="'https://wa.me/+91'+this.contact+'?text=I%20saw%20your%20shop%20on%20Fashiostreet%20and%20I%20am%20interested%20in%20knowing%20'" style="width:100%;font-size:16px;font-weight:bold;text-transform:capitalize;border-radius:30px;border:1px solid #1d2671;color:#1d2671;padding:6px 0px"><center style="line-height:1"><img src="../assets/whatsapp-logo.svg" alt="chat with shopkeeper"><div style="display:inline-block;padding-left:8px;position: relative;bottom:5px">Chat Now</div></center></a>
           </f7-col>
           <f7-col>
             <a @click="call"  class="link external" :href="'tel:'+this.contact"  style="width:100%;font-size:16px;font-weight:bold;text-transform:capitalize;border-radius:30px;border:1px solid #1d2671;color:#1d2671;padding:9px 0px 8px 0px"><center style="line-height:1"><f7-icon f7="phone_fill" style="padding-right:8px"></f7-icon>Call Now</center></a>
           </f7-col>
        </f7-row>
      </div>  
    </f7-block>
    <div style="background-color:white;padding:0px;margin:28px 0px 10px 10px;border:1px solid gray;border-right:0px;border-radius:30px 0px 0px 30px">
      <f7-block style="margin:0px;padding:22px 20px 16px 20px;border-radius:30px 0px 0px 0px;background-color:#FFFFFF">
      <f7-block-title style="margin:0px 0px 16px;font-size:18px;font-weight:bold;color:#000000"><p class="mpzero"><img src="../assets/size_icon.png" style="width:30px;height:30px;border-radius:50%;vertical-align: middle;" alt="Size">&nbsp {{text}}</p></f7-block-title>
            <template v-for="result in productinfo.size">
          <f7-chip style="margin:2px;text-transform: uppercase;font-size:16px;font-weight:bold" :text="result.size"></f7-chip>
            </template>
      </f7-block>
      <f7-block style="margin:0px;padding:16px 20px;background-color:#FFFFFF">
        <f7-block-title style="margin:0px 0px 16px;font-size:18px;font-weight:bold;color:#000000"><p class="mpzero"><img src="../assets/color_icon.png" style="width:30px;height:30px;border-radius:50%;vertical-align:middle" alt="color">&nbsp Product Color</p></f7-block-title>
        <span style="color:gray;font-size:16px;font-weight:bold">{{pcolor}}</span>
      </f7-block>
      <f7-block style="margin:0px;padding:16px 20px 26px 20px;background-color:#FFFFFF;border-radius:0px 0px 0px 30px">
         <f7-block-title style="margin:0px 0px 16px;font-size:18px;font-weight:bold;color:#000000"><p class="mpzero"><img src="../assets/detail_icon.png" style="width:30px;height:30px;border-radius:50%;vertical-align:middle" alt="color">&nbsp Product Details</p></f7-block-title>
          <span style="color:gray;font-size:16px;font-weight:bold;text-transform: capitalize">{{details}}</span>
      </f7-block>
    </div>
    <f7-block style="margin:0px;padding:18px 10px 0px 0px;background-color:#FFFFFF;color:#FFFFFF;font-size:16px;font-weight:bold">
      <center style="padding:14px 8px;border-radius:0px 30px 30px 0px;background-image: linear-gradient(to right, #4568DC, #B06AB3)">
      Free delivery by this shop upto 10Km
      </center>
    </f7-block>
    <f7-block style="margin:28px 0px 68px 10px;padding:0px;background-color:#FFFFFF;border:1px solid gray;border-right:0px;border-radius:30px 0px 0px 30px">
      <f7-block-title style="margin:0px;padding:20px 16px 22px 20px;font-size:18px;font-weight:bold;color:#000000"><p class="mpzero"><img src="../assets/sale_icon.png" style="width:30px;height:30px;border-radius:50%;vertical-align: middle;" alt="Shops">&nbsp Live Shop Offers</p></f7-block-title>
      <div style="overflow-x:scroll;overflow-y:hidden;white-space:nowrap;padding:0px 6px 28px 16px;margin-left:2px" v-show="productinfo.offers!=null">
        <template v-for="category in productinfo.categories">
          <f7-link @click="saveproduct(category.subcategory_id,category.discount)" href="/offers1">
             <f7-card style="margin:0px;border-radius:10px;padding:0px 5px;-webkit-box-shadow: none;box-shadow: none;border:1px solid gray;width:162px;margin-right:10px">
              <center>
                <p style="color:#000000;font-size:16px;font-weight:bold;margin:14px 0px">{{category.discount}}% OFF</p>
                <img v-show="category.subcategory_name=='T-shirts'" src="../assets/m_tshirt.png" style="width:100%;height:152px;border-radius:10px 10px;margin-bottom:0px" alt="">
                <img v-show="category.subcategory_name=='Casual Shirts'" src="../assets/m_shirt.png" style="width:100%;height:152px;border-radius:10px 10px;margin-bottom:0px" alt="">
                <img v-show="category.subcategory_name=='Sweatshirts'" src="../assets/m_sweatshirt.png" style="width:100%;height:152px;border-radius:10px 10px;margin-bottom:0px" alt="">
                <img v-show="category.subcategory_name=='Jeans'" src="../assets/m_jean.png" style="width:100%;height:152px;border-radius:10px 10px;margin-bottom:0px" alt="">
                <img v-show="category.subcategory_name=='Trousers'" src="../assets/m_trouser.png" style="width:100%;height:152px;border-radius:10px 10px;margin-bottom:0px" alt="">
                <img v-show="category.subcategory_name=='Shorts and 3 by 4ths'" src="../assets/m_short.png" style="width:100%;height:152px;border-radius:10px 10px;margin-bottom:0px" alt="">
                <img v-show="category.subcategory_name=='Track pants'" src="../assets/m_trackpant.png" style="width:100%;height:152px;border-radius:10px 10px;margin-bottom:0px" alt="">
                <img v-show="category.subcategory_name=='Briefs and Trunks'" src="../assets/m_brief.png" style="width:100%;height:152px;border-radius:10px 10px;margin-bottom:0px" alt="">
                <img v-show="category.subcategory_name=='Vests'" src="../assets/m_vest.png" style="width:100%;height:152px;border-radius:10px 10px;margin-bottom:0px" alt="">
                <img v-show="category.subcategory_name=='Casual Shoes'" src="../assets/m_casualshoes.png" style="width:100%;height:152px;border-radius:10px 10px;margin-bottom:0px" alt="">
                <img v-show="category.subcategory_name=='Sport Shoes'" src="../assets/m_sportshoes.png" style="width:100%;height:152px;border-radius:10px 10px;margin-bottom:0px" alt="">
                <img v-show="category.subcategory_name=='Formal Shoes'" src="../assets/m_formalshoes.png" style="width:100%;height:152px;border-radius:10px 10px;margin-bottom:0px" alt="">
                <img v-show="category.subcategory_name=='Loafers'" src="../assets/m_loafers.png" style="width:100%;height:152px;border-radius:10px 10px;margin-bottom:0px" alt="">
                <img v-show="category.subcategory_name=='Sandals'" src="../assets/m_sandals.png" style="width:100%;height:152px;border-radius:10px 10px;margin-bottom:0px" alt="">
                <img v-show="category.subcategory_name=='Chappals'" src="../assets/m_chapals.png" style="width:100%;height:152px;border-radius:10px 10px;margin-bottom:0px" alt="">
              </center>
             </f7-card>
           </f7-link>
        </template>
      </div>
      <div  style="font-size:16px;font-weight:bold;background-color:skyblue;color:navy;padding:5px 20px;margin:0px 150px 0px 16px;border-radius:20px" v-show="productinfo.offers==null">
        No Offers 
      </div>
    </f7-block>
     <div style="position:fixed;bottom:0;z-index:999;width:100%;background-color:#FFFFFF;box-shadow: 5px 0px 10px rgba(0, 0, 0, 0.12);border-radius:30px 30px 0px 0px">
      <f7-button @click="sizesheet1" big fill style="background-image: linear-gradient(to right, #11998e, #38ef7d);color:#FFFFFF;font-size:18px;font-weight:bold;border:0px;text-transform:Capitalize;margin:10px;border-radius:30px"><img src="../assets/scooter.svg" alt="" style="height:30px;vertical-align: middle;">&nbsp See Ordering Options</f7-button>
     </div>
      <!--<f7-block-title style="margin:0px 20px;margin-top:8px;padding:10px 0px"><h5 class="mpzero">SIMILAR PRODUCTS</h5></f7-block-title>-->
      <f7-block style="padding:10px 0px;margin:0px">
        <f7-row no-gap>
          <template v-for="result in similarproductinfo">
              <f7-col width="50" class="col_hgt" style="height:39.5vh;margin-top:10px;">
                <f7-link :href="'/productdetails/' + result.id + '/' + result.name" style="width:100%">
                  <f7-card style="width:100%;height:80%;margin:0px;padding:0px">
                    <div class="image_viewer" style="width: 100%;height:31vh;">
                      <img :src="result.image[0]" style="width:100%;height:100%;margin:0px">
                    </div>
                    <f7-block style="color:#BDBDBD;font-size:12px;font-weight:bold">
                      <p class="mpzero lineclampin">{{result.name}}</p>
                      <p class="mpzero lineclampin"><span style="color:gray;font-size:14px">Rs.{{result.selling_price}} </span><span style="text-decoration:line-through">Rs.{{result.mrp_price}}</span></p>
                      <!--<p class="mpzero lineclampin">Store : {{result.shop_name}}</p>-->
                    </f7-block>
                  </f7-card>
                </f7-link>
              </f7-col>
            </template>
        </f7-row>
      </f7-block>
    <f7-sheet ref="sizesheet" class="sizesheet" style="height:auto;border-radius:30px 30px 0px 0px">
          <f7-block-title style="margin:0px;padding:20px 16px 16px;font-size:18px;font-weight:bold;color:#000000"><img src="../assets/size_icon.png" style="width:30px;height:30px;border-radius:50%;vertical-align: middle;" alt="Size">&nbsp {{selectText}}</f7-block-title>
          <f7-block style="margin:0px;padding:0px 0px 0px 16px">
            <template v-for="(result,itemIndex) in productinfo.size">
              <f7-chip :class="{'size_selector_active': activeItemId === itemIndex}"
                 @click="setActiveItemId(itemIndex)"   style="margin:2px;cursor:pointer;text-transform: uppercase;font-size:16px;font-weight:bold" :text="result.size"></f7-chip>
          </template>
          </f7-block>
      <f7-button fill big @click="addTocart1()" href="/hdcart/" :disabled="sizeStatus" style="background-image: linear-gradient(to right, #11998e, #38ef7d);color:#FFFFFF;font-size:18px;font-weight:bold;border:0px;margin:10px;margin-top:20px;text-transform:capitalize;border-radius:30px">Add To Delivery Bag <f7-icon f7="chevron_right" style="margin:-5px 0px 0px 10px"></f7-icon></f7-button>
    </f7-sheet>
    <f7-sheet ref="sizesheet4" style="height:auto" v-show="sheet==true">
          <f7-block-title style="margin:0px;padding:15px 15px 5px 15px;font-size:12px;line-height:20px">GET <b>EXTRA 5% &nbsp<img src="../assets/fashiostreet.png" style="height:20px;margin-bottom:-5px !important" alt="fslogo">&nbsp DISCOUNT</b> DURING SHOP VISIT</f7-block-title>
          <f7-block style="margin:0px;padding:0px">
            <f7-list form no-hairlines-md style="margin:0px">
            <f7-list-item>
                <h5 style="color:red;text-transform:uppercase;margin:0px">{{mobileerror}}</h5>
                <f7-label floating>Your Whatsapp number</f7-label>
                <f7-input type="number" @input="mobile = $event.target.value" clear-button></f7-input>
            </f7-list-item>
            </f7-list>
            <p style="margin:0px;padding:8px 15px 5px 15px;font-size:12px"><f7-icon style="font-size:12px;color:green" f7="info"></f7-icon>&nbsp Tell same whatsapp number to shopkeeper to get the offer</p>
            <f7-button fill @click="addVisitShop()" href="/shophome/"  style="background-color:#00E676;font-size:12px;font-weight:bold;border-radius:0px;width:100%;margin-top:13px">SEE SHOP</f7-button>
          </f7-block>
    </f7-sheet>
    <f7-sheet ref="sizesheet1" class="sizesheet1" style="height:auto;text-align:center;border-radius:30px 30px 0px 0px">
      <h4 style="font-weight:bold;color:#000000;font-size:18px;text-align:left;padding:24px 16px 16px" class="mpzero">Select Your Order Option</h4>
      <div @click="openVisitSheet" style="margin:4px 16px 20px 16px;box-shadow:0px 1px 6px 0px rgba(0, 0, 0, 0.1);border-radius:4px">
        <f7-link style="padding-bottom:2px;width:100%;-webkit-box-shadow: none;box-shadow: none;border-radius:4px">
          <f7-row no-gap style="padding:8px">
           <f7-col width="25" style="padding-top:4px;text-align:center">
             <img src="../assets/store.svg" alt="">
           </f7-col>
           <f7-col width="75" style="padding-left:10px">
             <h4 style="font-weight:bold;color:#000000;font-size:16px;text-align:left" class="mpzero">Directly Visit Shop And Buy Through Shop</h4>
             <h5 style="color:#595959;font-size:13px;text-align:left;margin:0px">Visit Shop by Seeing Shop Details</h5>
           </f7-col>
          </f7-row>
        </f7-link>
      </div>
      <div style="margin:20px 16px 16px;box-shadow:0px 1px 6px 0px rgba(0, 0, 0, 0.1);border-radius:4px">
          <f7-link @click="sizesheetOpen" style="padding-bottom:2px;width:100%;-webkit-box-shadow: none;box-shadow: none;border-radius:4px">
          <f7-row no-gap style="padding:8px">
           <f7-col width="25" style="padding-top:4px;text-align:center">
             <img src="../assets/scooter.svg" alt="">
           </f7-col>
           <f7-col width="75" style="padding-left:10px">
             <h4 style="font-weight:bold;color:#000000;font-size:16px;text-align:left" class="mpzero">Place Home Delivery Through APP</h4>
             <h5 style="color:#595959;font-size:13px;text-align:left;margin:0px">Add Product to Delivery Bag</h5>
           </f7-col>
          </f7-row>
        </f7-link>
      </div>
      <div style="margin:16px;margin-top:20px;box-shadow:0px 1px 6px 0px rgba(0, 0, 0, 0.1);border-radius:4px">
        <f7-link class="link external" :href="'https://wa.me/+918600198512?text=Hello%20Fashiostreet%20-%20I%20want%20to%20order%20'" style="padding-bottom:2px;width:100%;-webkit-box-shadow: none;box-shadow: none;border-radius:4px">
          <f7-row no-gap style="padding:8px">
           <f7-col width="25" style="padding-top:4px;text-align:center">
             <img src="../assets/whatsapp-logo.svg" alt="" style="height:54px">
           </f7-col>
           <f7-col width="75" style="padding-left:10px">
             <h4 style="font-weight:bold;color:#000000;font-size:16px;text-align:left" class="mpzero">Place Home Delivery Using Whatsapp</h4>
             <h5 style="color:#595959;font-size:13px;text-align:left;margin:0px">Book Through Whatsapp</h5>
           </f7-col>
          </f7-row>
        </f7-link>
      </div>
      <div style="margin:16px;margin-top:20px;box-shadow:0px 1px 6px 0px rgba(0, 0, 0, 0.1);border-radius:4px">
        <f7-link class="link external" :href="'tel:' + 8600198512" style="padding-bottom:2px;width:100%;-webkit-box-shadow: none;box-shadow: none;border-radius:4px">
          <f7-row no-gap style="padding:8px">
           <f7-col width="25" style="padding-top:4px;text-align:center">
             <f7-icon f7="phone_fill" style="font-size:54px"></f7-icon>
           </f7-col>
           <f7-col width="75" style="padding-left:10px">
             <h4 style="font-weight:bold;color:#000000;font-size:16px;text-align:left" class="mpzero">Place Home Delivery Through Call</h4>
             <h5 style="color:#595959;font-size:13px;text-align:left;margin:0px">Book Just By Calling Us</h5>
           </f7-col>
          </f7-row>
        </f7-link>
      </div>
    </f7-sheet>

      </div></div>
    
      <f7-actions :grid="true" :opened="actionGridOpened" @actions:closed="actionGridOpened = false">
      <f7-actions-group>



<social-sharing :url="url" inline-template>
  <span>
    <network network="facebook">
      <f7-actions-button style="overflow:visible !important">
        <img src="https://img.icons8.com/color/48/000000/facebook.png">
        <p style="margin-left: 15vw;margin-top: -10vw"> Facebook</p>
      </f7-actions-button>
    </network>
    <network network="linkedin">
      <f7-actions-button style="overflow:visible !important">
        <img src="https://img.icons8.com/color/48/000000/linkedin.png">
        <p style="margin-left: 15vw;margin-top: -10vw"> LinkedIn</p>
      </f7-actions-button>
    </network>
    <network network="pinterest">
      <f7-actions-button style="overflow:visible !important">
        <img src="https://img.icons8.com/color/48/000000/pinterest.png">
        <p style="margin-left: 15vw;margin-top: -10vw"> Pinterest</p>
      </f7-actions-button>
    </network>
  </span>
</social-sharing>

      </f7-actions-group>
    </f7-actions>

    <social-sharing :url="url" inline-template>
  <div>
      <network network="facebook">
        <i class="fa fa-facebook"></i> 
      </network>
      <network network="linkedin">
        <i class="fa fa-linkedin"></i>      </network>
      <network network="whatsapp">
        <i class="fa fa-whatsapp"></i> 
      </network>
  </div>
</social-sharing>


    <f7-sheet ref="visitSheet" class="sizesheet1" style="height:auto;border-radius:30px 30px 0px 0px">
      <f7-block-title style="margin:0px;padding:26px 20px 15px 20px;font-size:18px;font-weight:bold;color:#000000">Give me reminder for shop visit</f7-block-title>
          <f7-block style="margin:0px;padding:0px">
            <div style="overflow-x:scroll;overflow-y:hidden;white-space:nowrap;padding:14px 0px 14px 15px;font-weight:bold">
              <template v-for="(result,index) in shopVisitDates">
                <f7-chip :class="{'day_selector_active': activeItemId1 === index}"
                 @click="setActiveDayId(index)"   style="margin:2px 5px;cursor:pointer;text-transform: capitalize;font-size:16px" :text="result"></f7-chip>
              </template>
            </div>
            <f7-button @click="addVisitShop(shop)" href="/shophome/" fill big :disabled="dayStatus" style="background-image: linear-gradient(to right, #11998e, #38ef7d);color:#FFFFFF;font-size:18px;font-weight:bold;border:0px;margin:10px;margin-top:20px;text-transform:capitalize;border-radius:30px">See shop details <f7-icon f7="chevron_right" style="margin:-5px 0px 0px 10px"></f7-icon></f7-button>
          </f7-block>
    </f7-sheet>
  </f7-page>
</template>

<script>
import axios from '../axios';
import offline from 'v-offline';
import SocialSharing from 'vue-social-sharing';
import Vue from 'vue';
import {
  Facebook,
  Twitter,
  Linkedin,
  Pinterest,
  Reddit,
  Telegram,
  WhatsApp,
  Email,
  Google
} from "vue-socialmedia-share";

Vue.use(SocialSharing);

import { f7Navbar, f7Page, f7BlockTitle, f7Block, f7Link, f7Button, f7Actions, f7ActionsGroup, f7ActionsLabel, f7ActionsButton } from 'framework7-vue';

export default {
  name: 'Productdetails',
  data() {
    return {
      AppLoader:false,
      actionGridOpened: false,
      title: 'Services Page',
      p_id:null,
      photos:[],
      wishlist:null,
     productinfo:[],
     url:null,
     similarproductinfo:[],
     shopVisitDates:['Tomorrow','After 3 Days','This Saturday, Sunday','Daily for 4 Days'],
     image:null,
     name:null,
     mrp:null,
     selling:null,
     shop:null,
     size:null,
     details:null,
     pcolor:null,
     colorvalue:null,
     internet:null,
     status:'not shown',
     diff:null,
     discount:null,
      toast_msg:null,
      productMsg:null,
      preloader:false,
      activeItemId:null,
      activeItemId1:null,
      selectedSize:null,
      selectedDay:null,
      sizeStatus:true,
      dayStatus:true,
      subcategory:null,
      cartinfo:[],
      wishlistinfo:[],
      id:null,
      sid:[],
      sheet:false,
      mobile:null,
      mobileerror:null,
      check:false,
      contact:null,
      specialDiscount:false,
      specialDiscountedPrice:null,
      text:null,
      selectText:null,
      offer_name:null,
      offerDate:null,
      offerMonth:null
    };
  },
  props:['product_id','product_name'],
  mounted(){
    this.getproduct();
    FB.init({
      appId: "2141628305957160",
      version: 'v3.1'
    });
  },
  created(){
    this.getCart();
    this.getWishlist();
    if(localStorage.getItem('gender') == "Deodorant")
    {
      this.text = "Available Volumes";
      this.selectText = "Select Volume";
        //this.logViewContentEvent('product',this.name,this.p_id,'Rs.',this.mrp);
    }
    else{
      this.text = "Available Sizes";
      this.selectText = "Select Size";
    }
    //this.getShopContact();
  },
    components: {
    offline,
    f7Page,
    f7Navbar,
    f7BlockTitle,
    f7Block,
    f7Link,
    f7Button,
    f7Actions,
    f7ActionsGroup,
    f7ActionsLabel,
    f7ActionsButton,
  },
  methods:{
    openVisitSheet()
    {
      this.$refs.sizesheet1.close();
      this.$refs.visitSheet.open();
    },
    saveproduct(category,discount)
    {
      localStorage.setItem('offerCategory',category);
      localStorage.setItem('offerDiscount',discount);
      localStorage.setItem('shop',this.shop);
    },
    getShopContact()
    {
      axios({
        method:'GET',
        url : '/getShopContact/'+this.shop
      }).then(response => {
        console.log(response);
      }).catch(error => {
        if(error.response.data.message != undefined)
          alert(error.response.data.message);
        else
          alert('Something went wrong,please try again');
      });
    },
    getCart:function(event,done){
      axios({
        method:'GET',
        url : 'user/viewcart/json'
      }).then(response => {
        this.cartinfo = response.data.result;

        done();
      }).catch(error => {
        if(error.response.data.message != undefined)
          alert(error.response.data.message);
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
          console.log(this.wishlistinfo);

      }).catch(error => {
        if(error.response.data.message != undefined)
          alert(error.response.data.message);
        else
          alert('Something went wrong,please try again');

      });
    },
    addVisitShop:function(sname)
    {
        localStorage.setItem('visit',"true");
        localStorage.setItem('visitMobile',localStorage.getItem('loginmobile'));
        localStorage.setItem("sname",sname);
        this.$refs.visitSheet.close();
        console.log(this.selectedDay)
        axios({
          method: 'POST',
          url: 'visitShop',
          data: 
            {
              'shop_name':localStorage.getItem('sname'),
              'mobile':localStorage.getItem('loginmobile'),
              'product_id':this.p_id
            }
        }).then(response => {
          console.log(response);
          this.check = true;
          this.sheet = false;
          this.selectedDay = null;
          this.activeItemId1 = true;
        }, (error) => { 
          console.log(error.response.data.message);          
        });
    },
    call(){
      console.log(this.contact);
      axios({
        method: 'POST',
        url: 'shop/call',
        data: {
          shop_name:this.shop,
          mobile:localStorage.getItem('loginmobile')
        }
      }).then(response => {
        console.log(response);
      }, (error) => { 
        console.log(error.response.data.message);          
      });
    },
    whatsapp(){
      console.log(this.contact);
      axios({
        method: 'POST',
        url: 'shop/whatsapp',
        data: {
          shop_name:this.shop,
           mobile:localStorage.getItem('loginmobile')
        }
      }).then(response => {
        console.log(response);
      }, (error) => { 
        console.log(error.response.data.message);          
      });
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
      openSizesheet4()
      {
        this.$refs.sizesheet1.close();
        this.$refs.sizesheet4.open();
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
    openPhotoBrowser:function(){
      this.$refs.standalone.open();
    },
    sizesheetOpen()
    {
      this.$refs.sizesheet1.close();
      if(localStorage.getItem('local_id') && localStorage.getItem('token')) {
        this.$refs.sizesheet.open();
      }
      else{
        this.$refs.loginsheet.open();
      }
    },
    sizesheet:function(){
      if(localStorage.getItem('local_id') && localStorage.getItem('token')) {
        this.$refs.sizesheet.open();
      }
      else{
        this.$refs.loginsheet.open();
      }
    },
    sizesheet1:function(){
      //if(localStorage.getItem('local_id') && localStorage.getItem('token')) {
        this.$refs.sizesheet1.open();
      /*}
      else{
        this.$refs.loginsheet.open();
      }*/
     },
    addTocart:function(){
      //this.logAddToCartEvent(this.name,this.p_id,'product','Rs.',this.mrp);
      if(this.selectedSize == null)
      {
        this.toast_msg = 'Please select size';
        return false;
      }
      if(localStorage.getItem('local_id') && localStorage.getItem('token'))
      {
        this.AppLoader = true;
        //this.toast_msg = 'Please wait, adding to cart.';
        axios({
          method:'POST',
          url : 'user/addtocart',
          header : {
            'local-id' : localStorage.getItem('local_id'),
            'token' : localStorage.getItem('token')
          },
          data:{
            'product_id' : this.product_id,
            'size' : this.selectedSize,
            'qty' : 1
          }
        }).then(response => {
          this.AppLoader = false;
          this.$refs.sizesheet.close();
          this.getCart();
          //this.toast_msg = 'Product added to cart';
          const self = this;
          self.notificationWithButton = self.$f7.notification.create({
            icon: '',
            title: '',
            cssClass:'color1',
            subtitle: 'Product added to cart',
            text: ''
          });
          self.notificationWithButton.open();
            setTimeout(()=>{
              this.closepop();
            },2000);
          
        },(error) => {
          this.AppLoader = false;
          setTimeout(() => {
            this.toast_msg = null;
          },2000);
          if(error.response.data.message != undefined)
            alert(error.response.data.message);
          else
            alert('failed to add product into cart');
          this.$refs.sizesheet.close();
        });
      }
      else{
        this.$refs.loginsheet.open();
      }
    },
    addTocart1:function(){
      //let self = this;
      //this.logAddToCartEvent(this.name,this.p_id,'product','Rs.',this.mrp);
      if(this.selectedSize == null)
      {
        this.toast_msg = 'Please select size';
        return false;
      }
      if(localStorage.getItem('local_id') && localStorage.getItem('token'))
      {
        this.AppLoader = true;
        //this.toast_msg = 'please wait, product adding to cart';
        axios({
          method:'POST',
          url : 'user/addtocart',
          header : {
            'local-id' : localStorage.getItem('local_id'),
            'token' : localStorage.getItem('token')
          },
          data:{
            'product_id' : this.product_id,
            'size' : this.selectedSize,
            'qty' : 1
          }
        }).then(response => {
          this.getCart();
          this.AppLoader = false;
          this.$refs.sizesheet.close();
          const self = this;
          self.notificationWithButton = self.$f7.notification.create({
            icon: '',
            title: '',
            cssClass:'color',
            subtitle: 'Product added to cart',
            text: ''
          });
          self.notificationWithButton.open();
            setTimeout(()=>{
              this.closepop();
            },3000);
          console.log('hi');
          //router.go('/hdcart/');
        },(error) => {
          this.AppLoader = false;
          setTimeout(() => {
            this.toast_msg = null;
          },2000);
          if(error.response.data.message != undefined)
            alert(error.response.data.message);
          else
            alert('failed to add product into cart');
          this.$refs.sizesheet.close();
        });
      }
      else{
        this.$refs.loginsheet.open();
      }
    },
    setActiveItemId(itemIndex) {
      this.activeItemId = itemIndex;
      this.selectedSize = this.productinfo.size[itemIndex].size;
      this.sizeStatus = false;
    },
    setActiveDayId(itemIndex) {
      this.activeItemId1 = itemIndex;
      this.selectedDay = this.shopVisitDates[itemIndex];
      this.dayStatus = false;
    },
    addToWishlist:function()
    {
      var product_id = this.p_id;
      var status = this.wishlist;
      //this.logAddToWishlistEvent(this.name,this.p_id,'product','Rs.',this.mrp);
      if(localStorage.getItem('local_id') && localStorage.getItem('token'))
      {
        if(status == 1)
        {
          axios({
            method:'POST',
            url : 'user/deletewishlist/json',
            data:{
              'product_id' : product_id
            }
          }).then(response => {
            /*this.toast_msg = 'Product removed from wishlist';
            setTimeout(() => {
              this.toast_msg = null;
            },2000);*/
            const self = this;
          self.notificationWithButton = self.$f7.notification.create({
            icon: '',
            title: '',
            cssClass:'color',
            subtitle: 'Product removed from Liked Items',
            text: ''
          });
          self.notificationWithButton.open();
            setTimeout(()=>{
              this.closepop();
            },2000);
            this.getWishlist();
            this.wishlist = 0;
          }).catch(error => {
            if(error.response.data.message != undefined)
              alert(error.response.data.message);
            else
              alert('failed to remove product from Liked Items');
          });
        }
        else {
          axios({
            method: 'POST',
            url: '/user/addtowishlist',
            data: {
              'product_id': product_id
            },
            header: {
              'local-id': localStorage.getItem('local_id'),
              'token': localStorage.getItem('token')
            }
          }).then(response => {
            const self = this;
          self.notificationWithButton = self.$f7.notification.create({
            icon: '',
            title: '',
            subtitle: 'Product added to Liked Items',
            text: ''
          });
          self.notificationWithButton.open();
            setTimeout(()=>{
              this.closepop();
            },2000);
            this.getWishlist();
            this.wishlist = 1;
          }).catch(error => {

            if (error.response.data.message != undefined) {
              alert(error.response.data.message);
            }
            else
              alert('application error found,restart your application');
          });
        }
      }
      else{
        this.$refs.loginsheet.open();
      }
    },

    getproduct:function(event,done)
    {
      var a = [];
      this.preloader = true;
      //document.getElementById("block").scrollTop=0;
      axios({
      method:'GET',
        url : '/product/'+localStorage.getItem("city")+'/'+ this.product_name +'/' + this.product_id +'/buy/json',
      }).then(response => {
        this.productinfo=response.data.result[0];
        //a = this.productinfo;
        console.log(this.productinfo);
        this.p_id = this.productinfo.id;
        this.wishlist = this.productinfo.wishlistflag;
        var photosData = [];
        for(var i=0;i < this.productinfo.image.length;i++) {
          var tmp = this.productinfo.image[i].replace("compress420X458","compress620X658");
          photosData.push(tmp);
        }
        this.photos = photosData;
        this.image=this.productinfo.image;
        //console.log(this.image[0]);
        localStorage.setItem("url",this.image[0]);
        this.name=this.productinfo.name;
        this.contact = this.productinfo.contact;
        console.log(this.contact);
        this.mrp=this.productinfo.mrp_price;
        this.offer_name = this.productinfo.offers;
        this.offerMonth = this.productinfo.offerMonth;
        this.offerDate = this.productinfo.offerDate;
        this.discount = (((this.mrp-this.selling)/this.mrp)*100);
        this.selling=this.productinfo.selling_price;
        localStorage.setItem("s",this.selling);
        this.shop=this.productinfo.shop_name; 
        this.details=this.productinfo.description;
        localStorage.setItem("b",this.productinfo.shop_name);
        if(this.details == null)
        {
          this.details = 'no description found';
        }
        this.pcolor=this.productinfo.color;
        this.colorvalue=this.productinfo.code;
        this.subcategory = this.productinfo.sub_category;
        this.diff=this.mrp-this.selling;
        this.discount=Math.round((this.diff/this.mrp)*100);
        this.mrp = Math.round(this.mrp);
        this.selling = Math.round(this.selling);
        if(this.productinfo.specialDiscount == true)
        {
          this.specialDiscount = true;
          this.specialDiscountedPrice = this.productinfo.specialDiscountedPrice;
          this.discount = this.productinfo.specialDiscountedPercentage;
        }
        else
        {
          this.specialDiscount = false;
        }
        this.preloader = false;
        done();
      }).catch(function(error){
        if(error.response.data.message != undefined)
          alert(error.response.data.message);
        else
          alert('application error found,please restart your app');
        this.preloader = false;
        done();
      });
      this.url = localStorage.getItem("url");
      console.log(this.url);
    },
    saveshop:function(sname)
    {
      localStorage.setItem("sname",sname);
      //this.sheet = true;
      //this.$refs.sizesheet4.open();
    },
    savedata:function(name,id,sname)
    {
      localStorage.setItem("pname",name);
      localStorage.setItem("pid",id);
      localStorage.setItem("sname",sname);
    }
  }
};
</script>
<style scoped>
.md .navbar:after{
  content:none
}
.actions-modal
{
  height: 40% !important;
}
  .size_selector_active{
    background-color:#273657 !important;
    color:#00FF96;
  }
  .day_selector_active{
    background-color:#273657 !important;
    color:#00FF96;
  }
.lineclampin{
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    width: 100%;
}
  @media only screen and (max-height: 570px) {
    .pad{
      padding-bottom:10px !important
    }
    .col_hgt{
      height: 40.5vh !important;
    }
  }
  @media only screen and (max-height: 530px){
      .col_hgt{
      height: 42.5vh !important;
    }
  }
</style>
