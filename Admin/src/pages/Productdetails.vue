<template>
  <f7-page class="bgpage" name="productdetails;"
           ptr @ptr:refresh="getproduct"
  >
    <div v-if="toast_msg != null" class="custom_toast z-depth-3">
      {{ toast_msg }}
    </div>
    <f7-navbar back-link="Back" class="bgnav" sliding>
      <f7-nav-title style="margin:0px;padding-top:5px">
        <img src="../assets/fashiostreet.png" style="height:25px" alt="">
      </f7-nav-title>
      <f7-nav-right>
        <!-- <f7-link style="padding:0 10px" raised @click="actionGridOpened = true"><img src="../assets/share.svg" alt=""></f7-link>-->
        <f7-link style="padding:0 10px" icon-f7="icon-heart_fill" href="/wishlist/" v-if="wishlistinfo.length>0"><span class="badge color-red" style="border-radius: 16px;height: 15px;width: 15px;margin-top: -5vw;margin-left:-5px;"><p style="margin-top: -5.5vw;margin-left: -0.5vw;">{{wishlistinfo.length}}</p></span></f7-link>
        <f7-link style="padding:0 10px" icon-f7="icon-heart_fill" href="/wishlist/" v-else></f7-link>
        <f7-link style="padding:0 10px" href="/hdcart/" v-if="cartinfo.length>0"><img src="../assets/delivery-motorbike.svg" alt=""><span class="badge color-red" style="border-radius: 16px;height: 15px;width: 15px;margin-top: -5vw;"><p style="margin-top: -5.5vw;margin-left: -0.5vw;">{{cartinfo.length}}</p></span></f7-link>
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
            <div style="position:absolute;top:25px;right:25px;z-index:99;background-color:white;border-radius:50%;width:30px;height:30px">
    <f7-link v-if="wishlist != 1" icon-f7="icon-heart" @click="addToWishlist()" style="position:absolute;top:7px;right:5px;color:gray"></f7-link>
    <f7-link v-if="wishlist == 1" icon-f7="icon-heart_fill" @click="addToWishlist()" style="position:absolute;top:7px;right:5px;color:red"></f7-link>
    </div>
        <div v-if="image != null">
          <f7-photo-browser
            :photos="photos"
            type="popup",
            theme="dark",
            ref="standalone"
          ></f7-photo-browser>
        </div>
        <f7-chip style="position:absolute;bottom:10px;right:10px;z-index:99;color:#FFFFFF;background-color:#000000;opacity:0.6" text="Tap on image to zoom"></f7-chip>
         <div style="height:65vh;background-color:#FFFFFF">
         <f7-swiper v-if="image != null" pagination>
           <template v-for="p_image in image">
             <f7-swiper-slide class="image_viewer" style="height:65vh">
               <center>
                 <f7-link @click="openPhotoBrowser()"><img style="max-width:100%;height:65vh"  :src="p_image" alt=""></f7-link>
               </center>
             </f7-swiper-slide>
           </template>
         </f7-swiper>
         </div>
    </f7-block>
    <f7-block style="margin:0px 0px 8px;padding:14px 16px;background-color:#FFFFFF;box-shadow:0px 1px 6px 0px rgba(0, 0, 0, 0.1)">
        <p class="mpzero"><span style="color:gray;font-size:20px;font-weight: bold">Rs.{{selling}} &nbsp</span><span style="text-decoration:line-through">Rs.{{mrp}}</span>
        <span style="color:red;font-size:12px">&nbsp ({{discount}}% OFF)</span>
        </p>
        <p style="color:orange;margin-top:10px">
          Price are same that are in shops.So,order freely
        </p>
        <h4 class="mpzero" style="color:gray;margin-bottom:3px;text-transform: capitalize;font-size:16px">{{name}}</h4>
    </f7-block>
    <f7-block style="margin:0px 0px 8px;padding:0px;background-color:#FFFFFF;box-shadow:0px 1px 6px 0px rgba(0, 0, 0, 0.1)">
    <f7-block-title style="margin:0px 0px 16px;color:green;padding:16px 16px 0px 16px"><h5 class="mpzero">EXTRA OFFERS</h5></f7-block-title>
        <p style="color:#000000;font-weight:bold;margin-bottom:0px;;padding:0px 16px 0px 16px">Get Extra 5% &nbsp<img src="../assets/fashiostreet.png" style="height:20px;margin-bottom:-5px !important" alt="fslogo">&nbsp Discount on shop price.</p>  
        <f7-list accordion-list style="margin:0px;padding-bottom:8px" no-hairlines-md>
  <f7-list-item accordion-item title="KNOW MORE" style="font-size:13px;color:gray;font-weight:bold">
    <f7-accordion-content style="padding:0px 5px 0px 5px">
      <f7-block style="font-size:13px;font-weight:normal">
        <p style="color:gray;font-size:12px"><f7-icon f7="info" style="color:green;font-size:12px"></f7-icon>&nbspTo get FS Discount, you have to either order from Fashiostreet OR Visit shop as a Fashiostreet customer by clicking on "VISIT SHOP" button below.</p>
      </f7-block>
    </f7-accordion-content>
  </f7-list-item>
      </f7-list>
    </f7-block>
    <f7-block style="margin:0px 0px 8px;padding:16px;background-color:#FFFFFF;color:green;box-shadow:0px 1px 6px 0px rgba(0, 0, 0, 0.1)">
      <center>
      ** FREE HOME DELIVERY **
      </center>
    </f7-block>
    <f7-block style="margin:0px 0px 8px;padding:16px;background-color:#FFFFFF;box-shadow:0px 1px 6px 0px rgba(0, 0, 0, 0.1)">
    <f7-block-title style="margin:0px 0px 16px"><h5 class="mpzero">AVAILABLE SIZES</h5></f7-block-title>
          <template v-for="result in productinfo.size">
        <f7-chip style="margin:2px;text-transform: uppercase" :text="result.size"></f7-chip>
          </template>
    </f7-block>
    <f7-block style="margin:0px 0px 8px;padding:16px;background-color:#FFFFFF;box-shadow:0px 1px 6px 0px rgba(0, 0, 0, 0.1)">
      <f7-block-title style="margin:0px 0px 16px"><h5 class="mpzero">AVAILABLE COLORS</h5></f7-block-title>
      <span style="color:black">{{pcolor}}</span>
    </f7-block>
    <f7-block style="margin:0px 0px 8px;padding:16px;background-color:#FFFFFF;box-shadow:0px 1px 6px 0px rgba(0, 0, 0, 0.1)">
       <f7-block-title style="margin:0px 0px 16px"><h5 class="mpzero">PRODUCT DETAILS</h5></f7-block-title>
        {{details}}
    </f7-block>
    <f7-block style="margin:0px 0px 8px;padding:16px;background-color:#FFFFFF;box-shadow:0px 1px 6px 0px rgba(0, 0, 0, 0.1);color:#00E676">
       <f7-block-title style="margin:0px 0px 16px"><h5 class="mpzero">SHOP</h5></f7-block-title>
        {{shop}}
    </f7-block>
    <f7-block style="margin:0px 0px 38px;padding:16px;background-color:#FFFFFF;box-shadow:0px 1px 6px 0px rgba(0, 0, 0, 0.1)">
      <f7-block-title style="margin:0px 0px 16px"><h5 class="mpzero">ONGOING SHOP OFFERS</h5></f7-block-title>
      <f7-swiper :params="{speed:500, slidesPerView: 2, spaceBetween: 10}" v-show="productinfo.offers!=null">
        <template v-for="offer in productinfo.offers">
          <f7-swiper-slide style="padding:8px;background-color:skyblue;color:navy;text-align: center;font-weight: bold;border-radius:2px">{{ offer }}</f7-swiper-slide>
        </template>
      </f7-swiper>
      <div  style="font-weight:normal;font-size:14px;background-color:skyblue;color:navy;padding:5px 10px;margin-right:160px;border-radius:2px" v-show="productinfo.offers==null">
        No Offers 
      </div>
    </f7-block>
     <f7-segmented style="position:fixed;bottom:0;z-index:999;width:100%;background-color:#E0E0E0;border-radius:0px">
      <f7-button big fill color="gray"  @click="saveshop(shop)" style="font-size:12px;font-weight:bold;border-radius:0px;width:26%;border:0px">VISIT SHOP</f7-button>
      <f7-button @click="sizesheet1" big fill style="background-color:#ffa726;font-size:12px;font-weight:bold;border-radius:0px;width:37%;border:0px">BUY NOW</f7-button>
      <f7-button @click="sizesheet" big fill style="background-color:#00E676;font-size:12px;font-weight:bold;border-radius:0px;width:37%;border:0px">ADD TO HD CART</f7-button>
      </f7-segmented>
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
    <f7-sheet ref="sizesheet" class="sizesheet" style="height:auto">
      <f7-block-title style="margin:0px;padding:15px;font-size:12px">SELECT SIZE</f7-block-title>
          <f7-block style="margin:0px">
            <template v-for="(result,itemIndex) in productinfo.size">
        <f7-chip :class="{'size_selector_active': activeItemId === itemIndex}"
                 @click="setActiveItemId(itemIndex)"   style="margin:2px;cursor:pointer;text-transform: uppercase" :text="result.size"></f7-chip>
          </template>
          </f7-block>
      <f7-button fill @click="addTocart()" :disabled="sizeStatus" style="background-color:#00E676;font-size:12px;font-weight:bold;border-radius:0px;width:100%;margin-top:20px">DONE</f7-button>
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
            <f7-button fill @click="addVisitShop()" href="/shophome/"  style="background-color:#00E676;font-size:12px;font-weight:bold;border-radius:0px;width:100%;margin-top:13px">SUBMIT</f7-button>
          </f7-block>
    </f7-sheet>
    <f7-sheet ref="sizesheet1" class="sizesheet1" style="height:auto">
      <f7-block-title style="margin:0px;padding:15px;font-size:12px">SELECT SIZE</f7-block-title>
          <f7-block style="margin:0px">
            <template v-for="(result,itemIndex) in productinfo.size">
              <f7-chip :class="{'size_selector_active': activeItemId === itemIndex}"
                 @click="setActiveItemId(itemIndex)"   style="margin:2px;cursor:pointer;text-transform: uppercase" :text="result.size"></f7-chip>
          </template>
          </f7-block>
      <f7-button fill @click="addTocart1()" href="/hdcart/" :disabled="sizeStatus" style="background-color:#00E676;font-size:12px;font-weight:bold;border-radius:0px;width:100%;margin-top:20px">DONE</f7-button>
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
      selectedSize:null,
      sizeStatus:true,
      subcategory:null,
      cartinfo:[],
      wishlistinfo:[],
      id:null,
      sid:[],
      sheet:false,
      mobile:null,
      mobileerror:null,
      check:false
    };
  },
  props:['product_id','product_name'],
  mounted(){
    this.getproduct();
    FB.init({
      appId: "2141628305957160",
      version: 'v3.1'
    });
        this.logViewContentEvent('product',this.name,this.p_id,'Rs.',this.mrp);
  },
  created(){
    this.getCart();
    this.getWishlist();
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

      }).catch(error => {
        if(error.response.data.message != undefined)
          alert(error.response.data.message);
        else
          alert('Something went wrong,please try again');

      });
    },
    addVisitShop:function()
    {
      if(this.mobile==null || this.mobile=='')
      {
        this.mobileerror = 'Enter whatsapp number';
      }
      else
      {
        this.mobileerror = null;
                  localStorage.setItem('visit',"true");
        this.$refs.sizesheet4.close();
        axios({
          method: 'POST',
          url: 'visitShop',
          data: 
            {
              'shop_name':localStorage.getItem('sname'),
              'mobile':this.mobile
            }
        }).then(response => {
          console.log(response);
          this.check = true;
          this.sheet = false;
        }, (error) => { 
          console.log(error.response.data.message);          
        });
      }
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
    openPhotoBrowser:function(){
      this.$refs.standalone.open();
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
      if(localStorage.getItem('local_id') && localStorage.getItem('token')) {
        this.$refs.sizesheet1.open();
      }
      else{
        this.$refs.loginsheet.open();
      }
     },
    addTocart:function(){
      this.logAddToCartEvent(this.name,this.p_id,'product','Rs.',this.mrp);
      if(this.selectedSize == null)
      {
        this.toast_msg = 'please select size before add to cart';
        return false;
      }
      if(localStorage.getItem('local_id') && localStorage.getItem('token'))
      {
        this.AppLoader = true;
        this.toast_msg = 'please wait, product adding to cart';
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
          this.toast_msg = 'successfully product added to cart';
          setTimeout(() => {
            this.toast_msg = null;
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
    logAddToCartEvent(contentData, contentId, contentType, currency, price) {
      var params = {};
      params[window.FB.AppEvents.ParameterNames.CONTENT] = contentData;
      params[window.FB.AppEvents.ParameterNames.CONTENT_ID] = contentId;
      params[window.FB.AppEvents.ParameterNames.CONTENT_TYPE] = contentType;
      params[window.FB.AppEvents.ParameterNames.CURRENCY] = currency;
      window.FB.AppEvents.logEvent(window.FB.AppEvents.EventNames.ADDED_TO_CART, price, params);
    },
    logAddToWishlistEvent(contentData, contentId, contentType, currency, price) 
    {
      var params = {};
      params[FB.AppEvents.ParameterNames.CONTENT] = contentData;
      params[FB.AppEvents.ParameterNames.CONTENT_ID] = contentId;
      params[FB.AppEvents.ParameterNames.CONTENT_TYPE] = contentType;
      params[FB.AppEvents.ParameterNames.CURRENCY] = currency;
      FB.AppEvents.logEvent(FB.AppEvents.EventNames.ADDED_TO_WISHLIST, price, params);
    },
    logViewContentEvent(contentType, contentData, contentId, currency, price) {
      var params = {};
      params[FB.AppEvents.ParameterNames.CONTENT_TYPE] = contentType;
      params[FB.AppEvents.ParameterNames.CONTENT] = contentData;
      params[FB.AppEvents.ParameterNames.CONTENT_ID] = contentId;
      params[FB.AppEvents.ParameterNames.CURRENCY] = currency;
      FB.AppEvents.logEvent(FB.AppEvents.EventNames.VIEWED_CONTENT, price, params);
    },
    addTocart1:function(){
      //let self = this;
      this.logAddToCartEvent(this.name,this.p_id,'product','Rs.',this.mrp);
      if(this.selectedSize == null)
      {
        this.toast_msg = 'please select size before add to cart';
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
          this.$refs.sizesheet1.close();
          this.toast_msg = 'successfully product added to cart';
          setTimeout(() => {
            this.toast_msg = null;
          },2000);
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
          this.$refs.sizesheet1.close();
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
    addToWishlist:function(){
      var product_id = this.p_id;
      var status = this.wishlist;
      this.logAddToWishlistEvent(this.name,this.p_id,'product','Rs.',this.mrp);
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
            this.toast_msg = 'successfully remove product from wishlist';
            setTimeout(() => {
              this.toast_msg = null;
            },2000);
            this.getWishlist();
            this.wishlist = 0;
          }).catch(error => {
            if(error.response.data.message != undefined)
              alert(error.response.data.message);
            else
              alert('failed to remove product from wishlist');
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
            this.toast_msg = 'successfully product added to wishlist';
            setTimeout(() => {
              this.toast_msg = null;
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
        console.log(this.image[0]);
        localStorage.setItem("url",this.image[0]);
        this.name=this.productinfo.name;
        this.mrp=this.productinfo.mrp_price;
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
      /*this.id = localStorage.getItem("id");
      console.log(localStorage.getItem("b"));
      axios({
        method:'GET',
        url: '/similar/'+localStorage.getItem("b")
      }).then(response =>
      {
        this.sid = response.data.result;
        console.log(this.sid[0].id);
        localStorage.setItem("ss",this.sid[0].id);
      }).catch(function(error){
        if(error.response.data.message != undefined)
          alert(error.response.data.message);
        else
          alert('application error found,please restart your app');
        this.preloader = false;
        done();
      });
      axios({
        method:'GET',
        url: '/getSimilar/'+localStorage.getItem("ss")
      }).then(response =>
      {
        this.similarproductinfo = response.data.result;
        console.log(this.similarproductinfo);
      }).catch(function(error){

      });*/
      this.url = localStorage.getItem("url");
      console.log(this.url);
    },
    saveshop:function(sname)
    {
      localStorage.setItem("sname",sname);
      this.sheet = true;
      this.$refs.sizesheet4.open();
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
.actions-modal
{
  height: 40% !important;
}
  .size_selector_active{
    background-color:greenyellow !important;
    color:white;
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
