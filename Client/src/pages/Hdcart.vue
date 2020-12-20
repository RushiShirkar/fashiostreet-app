<template>
  <f7-page name="hdcart"  style="padding-bottom:70px">
    <div v-if="toast_msg != null" class="custom_toast z-depth-3">
      {{ toast_msg }}
    </div>
    <f7-navbar back-link="back" class="bgnav" style="border-radius:0px 0px 30px 0px;box-shadow: 5px 0px 10px rgba(0, 0, 0, 0.12)" sliding>
      <f7-nav-title style="font-size:18px;font-weight:bold;margin:0px">
        Delivery Bag
      </f7-nav-title>
      <f7-nav-right>
          <!-- <f7-link href="/wishlist/"> -->
          <f7-button href="/wishlist/" outline small color="white" style="font-size:18px;font-weight:bold;text-transform:Capitalize;margin-right:10px;border-radius:30px">Liked Items</f7-button>
          <span class="badge" v-if="wishlistinfo.length>0" style="border-radius: 16px;height: 20px;width: 20px;margin-top:-6.5vw;margin-left:-5.5vw;margin-right:10px;background-color:#5ddcf9;color:#000000"><p style="margin-top: -0.4vw;margin-left: -0.5vw;font-size:14px;font-weight:bold">{{wishlistinfo.length}}</p></span>
          <!-- </f7-link> -->
      </f7-nav-right>
    </f7-navbar>
          <offline @detected-condition="handleConnectivityChange">
  </offline>
    <!-- Scrollable page content-->
    <div class="content">
      <center>
        <div v-if="preloader" class="preloader" style="margin:25px 0px 10px 0px">
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
        <f7-block-title  style="margin-top:16px;color:#000000"><h5 class="mpzero" style=";font-size:18px;font-weight:bold"><img src="../assets/item_icon.png" style="width:30px;height:30px;border-radius:50%;vertical-align: middle;" alt="Shops">&nbsp Items ({{cartinfo.length}})</h5></f7-block-title>
        <f7-block style="padding:0px;margin:0px 10px 0px 10px">
          <div v-show="cartinfo==0">
            <center><h3>No Product In Cart</h3></center>
          </div>
          <template v-for="result in cartinfo">
            <f7-card style="margin-bottom:10px;font-weight:bold;color:gray;-webkit-box-shadow:none;box-shadow:none;border-radius:10px;border:1px solid gray">
                <f7-card-content style="padding:10px 0px">
                  <f7-block style="margin:0px">
                    <f7-row no-gap>
                      <f7-col width="25"><img :src="result.image[0]" style="width:100%;height:90px"></f7-col>
                      <f7-col width="75" style="padding-left:15px"><p class="mpzero lineclampin">{{result.name}}</p>
                      <p class="mpzero">
                        <span v-show="result.specialDiscount == true" style="color:#000000;font-size:17px">&#8377;{{result.specialDiscountedPrice}}</span>
                        <span v-show="result.specialDiscount == false" style="color:#000000;font-size:17px">&#8377;{{result.selling_price}}</span>
                        <span v-show="result.specialDiscount == true" style="color:#000000;font-size:17px;text-decoration:line-through;margin-left:3px">&#8377;{{result.selling_price}}</span>
                        <span style="text-decoration:line-through;margin-left:3px">&#8377;{{result.mrp_price}}</span>
                      </p>
                      <p class="mpzero">Size : {{result.size}}</p>
                      <p class="mpzero">Shop : {{result.shop_name}}</p>
                      </f7-col>
                    </f7-row>
                   <f7-segmented>
                      <f7-button color="red" @click="DeleteFromCart(result.cart_id)" style="font-size:16px;font-weight:bold;text-transform:capitalize">Remove</f7-button>
                      <f7-button color="green" @click="MoveToWishlist(result.cart_id,result.id)" style="font-size:16px;font-weight:bold;text-transform:capitalize">Move To Liked</f7-button>
                   </f7-segmented>
                  </f7-block>
                </f7-card-content>
            </f7-card>
          </template>
        </f7-block>
      </div>
    </div>
      <f7-card v-show="cartinfo.length>0" style="padding:0px;margin:0px 10px 10px 10px;-webkit-box-shadow:none;box-shadow:none;border-radius:10px;border:1px solid gray">
      <div style="padding:15px 10px;color:gray;font-size:15px;font-weight:bold">
        <f7-row>
          <f7-col>
          <p class="mpzero" style="padding-bottom:8px;color:#000000">Total MRP</p>
          <p class="mpzero" style="padding-bottom:8px">Discount</p>
          <p class="mpzero" style="padding-bottom:8px">Delivery Charges</p>
          <p v-show="selectPromocode==true" class="mpzero" style="padding-bottom:8px">Promocode Discount</p>
          </f7-col>
          <f7-col style="text-align:right">
          <p class="mpzero" style="padding-bottom:8px;color:#000000">&#8377;{{total_mrp}}</p>
          <p class="mpzero" style="padding-bottom:8px;color:#FD6A02">- &#8377;{{total_discount}}</p>
          <p class="mpzero" style="padding-bottom:8px;color:#4caf50">FREE</p>
          <p v-show="selectPromocode==true" class="mpzero" style="padding-bottom:8px;color:#FD6A02">- &#8377;{{promocode}}</p>
          </f7-col>
        </f7-row>
        <hr>
        <f7-row style="color:#000000;font-size:18px;font-weight:bold">
         <f7-col>
         <p class="mpzero" style="padding-top:8px">Total</p>
         </f7-col>
         <f7-col style="text-align:right">
         <p class="mpzero" style="padding-top:8px">&#8377;{{total_selling}}</p>
         </f7-col>
        </f7-row>
        </div>
      </f7-card>
      <!--<f7-block v-show="cartinfo.length>0 && numberOfPromocodeOrders.length<2" style="padding-top:0px;margin:16px 0px">
       <f7-card style="padding:0px;margin:0px;-webkit-box-shadow:none;box-shadow:none;border-radius:10px;border:1px solid gray">
        <f7-list style="margin:0px">
          <f7-list-item checkbox value="check_1" style="color:#4caf50" title="Use Promocode - SUPER30" @change="checkWallet"></f7-list-item>
          <p style="color:gray;font-size:14px;margin:0px;padding:0px 16px 16px 72px">Get 30% OFF on First 2 orders(Upto &#8377;50)<br>[ONLY FOR FIRST 200 ORDERS FROM KOLHAPUR]</p>
        </f7-list>
        </f7-card>
        </f7-block>-->
        <f7-block style="padding-top:0px;margin:16px 0px">
       <f7-card v-show="cartinfo.length>1 && sameShop=='true' && cartinfo.length<=4" style="padding:0px;margin:0px;-webkit-box-shadow:none;box-shadow:none;border-radius:10px;border:1px solid gray">
        <f7-list style="margin:0px">
          <f7-list-item checkbox value="check_1" style="color:#4caf50;font-size:16px;font-weight:bold" title="Use TRY & BUY Feature" @change="checkTry"></f7-list-item>
          <p style="color:gray;font-size:14px;;font-weight:bold;margin:0px;padding:0px 16px 16px 72px">Know more on Home page.</p>
        </f7-list>
        </f7-card>
        <f7-card v-show="cartinfo.length>0 && sameShop=='false'" style="padding:0px;margin:0px;-webkit-box-shadow:none;box-shadow:none;border-radius:10px;border:1px solid gray">
          <f7-card-content style="padding:15px 10px;color:#4caf50;font-weight:bold">
            Checkbox for TRY & BUY will appear when atleast 2 products from same shop are added to HD Cart.
          </f7-card-content>
        </f7-card>
        </f7-block>
        <f7-card v-show="cartinfo.length>0" style="padding:0px;margin:0px 10px 16px 10px;background-image: linear-gradient(to right, #4568DC, #B06AB3);border-radius:10px">
          <f7-card-content style="padding:15px 10px;color:#FFFFFF;font-size:15px;font-weight:bold">
            <f7-row>
                <f7-col width="10">
                  <f7-icon f7="info"></f7-icon>
                </f7-col>
                <f7-col width="90">
                  You can use your FS wallet in next step.
                </f7-col>
              </f7-row>
          </f7-card-content>
        </f7-card>
        <f7-card v-show="cartinfo.length>0" style="padding:0px;margin:0px 10px 16px 10px;background-image: linear-gradient(to right, #F2994A, #F2C94C);border-radius:10px">
          <f7-card-content style="padding:15px 10px;color:#FFFFFF;font-size:15px;font-weight:bold">
              <f7-row>
                <f7-col width="10">
                  <f7-icon f7="info"></f7-icon>
                </f7-col>
                <f7-col width="90">
                  Cashback of this order will add to FS wallet.
                </f7-col>
              </f7-row>
          </f7-card-content>
        </f7-card>
      <f7-card v-show="cartinfo.length>0" style="padding:0px;margin:0px 10px 16px 10px;;-webkit-box-shadow:none;box-shadow:none;border-radius:10px;border:1px solid gray">
          <f7-card-content style="padding:15px 10px;color:#4caf50;font-size:15px;font-weight:bold">
            <f7-icon f7="info"></f7-icon> &nbsp Free home delivery upto 10Km
            <p><f7-icon f7="info"></f7-icon> &nbsp Half Delivery Charges for above 10Km</p>
            <p style="color:#000000"><f7-icon f7="info"></f7-icon> &nbsp Cash on delivery service upto 10Km</p>
            <!--<p style="color:gray"><f7-icon f7="bolt_round"></f7-icon> &nbsp We give TRY & BUY Feature</p>-->
          </f7-card-content>
      </f7-card>
      <f7-block style="margin:0px;padding:0px;position:fixed;bottom:0;z-index:999;width:100%;background-color:white;box-shadow: 5px 0px 10px rgba(0, 0, 0, 0.12);border-radius:30px 30px 0px 0px">
      <!--<f7-list accordion-list style="margin:0px">
  <f7-list-item accordion-item title="What is TRY & BUY Feature ?" style="font-size:13px;color:gray;font-weight:bold">
    <f7-accordion-content>
      <f7-block style="font-size:13px;font-weight:normal">
        <p>
         You can order 3-4 items from same category Example : 3-4 T-shirts. When order is delivered to your door step, you can instantly try out the items and buy only that items you liked. It's is exciting but unfortunately we have to keep one rule to this feature to avoid mis-use of it.<br>Rule :- You should aleast buy 1 item for every 3 items you order.
        </p>
        <p>
         <span style="font-weight:bold">Example :-</span><br>
         You ordered 3 items > You should atleast buy 1 item of that 3 items<br>
         You ordered 4 items > You should atleast buy 2 items of that 4 items<br>
        </p>
        <p>
         <span style="font-weight:bold">Ordered To Buy Ratio :-</span><br>
         1-3 items ordered > Buy atleast 1 item<br>
         4-6 items ordered > Buy atleast 2 items<br>
         7-9 items ordered > Buy atleast 3 items<br>
         Continue similarly..
        </p>
      </f7-block>
    </f7-accordion-content>
  </f7-list-item>
      </f7-list>-->
    <f7-segmented>
      <p class="mpzero" style="width:50%;padding:12px 0px 12px 10px;text-align:center;color:#000000;font-size:14px;font-weight:bold">Free Delivery<br>Upto 10 Km</p>
      <f7-button :disabled="disabled" @click="save" href="/selectaddress/" fill big style="font-size:18px;font-weight:bold;background-image: linear-gradient(to right, #11998e, #38ef7d);color:#FFFFFF;text-transform:capitalize;margin:10px;border-radius:30px">Next <f7-icon f7="chevron_right" style="margin:-5px 0px 0px 10px"></f7-icon></f7-button>
    </f7-segmented>
  </f7-block>
  </f7-page>
</template>

<script>
import offline from 'v-offline';
import axios from '../axios';
export default {
  name: 'Hdcart',
  data() {
    return {
      cartinfo:[],
      wishlistinfo:[],
      preloader:true,
      toast_msg:null,
      disabled:true,
      internet:null,
      status:'not shown',
      page:10000000,
      mrp:[],
      use:false,
      total:null,
      selling:[],
      discount:[],
      total_mrp:null,
      total_selling:null,
      final_selling:null,
      total_discount:null,
      promocode:null,
      selectPromocode:false,
      money:null,
      sameShop:'false',
      try_buy:false,
      numberOfPromocodeOrders:null,
      showTryText:false
    };
  },
  mounted(){
    this.getWalletMoney();
    this.getCart();
    this.getWishlist();
    this.checkOrders();
    this.getCategoriesOfShopOffers();
    console.log(this.sameShop);
    FB.init({
      appId: "2141628305957160",
      version: 'v3.1'
    });
    //this.logInitiateCheckoutEvent(this.cartinfo,localStorage.getItem('loginmobile'),'OrderProduct',this.cartinfo.length,'COD','₹',this.total_selling);
  },
    components: {
    offline
  },
  methods:{
    getCategoriesOfShopOffers()
    {
      axios({
        method:'GET',
        url : 'categories/Sample',
      }).then(response => {
        console.log(response);
      },(error) => {
        alert(error.response.data.message);
      });
    },
    save(){
      if(this.use==true)
      {
        localStorage.setItem('promocodeCheck',"true");
      }
      else{
        localStorage.setItem('promocodeCheck',"false");
        this.selectPromocode = false;
      }
      if(this.cartinfo.length<2)
      {
        if(localStorage.getItem('try_buy')=='true')
        {
          localStorage.setItem('try_buy',"false");
        }
      }
    },
    checkOrders()
    {
      axios({
        method:'GET',
        url : '/user/numberOfPromocodeOrders/'+localStorage.getItem('loginmobile')
      }).then(response => {
        this.numberOfPromocodeOrders = response.data.result;
        console.log(this.numberOfPromocodeOrders);
      }).catch(error => {
        if(error.response.data.message != undefined)
          alert(error.response.data.message);
        else
          alert('Something went wrong,please try again');
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
    checkWallet(event)
    {
      if(event.target.checked)
      {
        this.use = true;
        this.selectPromocode = true;
        this.promocode = Math.floor((this.total_selling)*(30/100));
        if(this.promocode>50)
          this.promocode = 50;
        this.total_selling = this.final_selling - this.promocode;
      }
      else
      {
        this.use = false;
        this.selectPromocode = false;
        this.total_selling = this.total_selling + this.promocode;
      }
      console.log(this.selectPromocode);
    },
    checkTry(event)
    {
      if(event.target.checked)
      {
        localStorage.setItem('try_buy',"true");
      }
      else
      {
        localStorage.setItem('try_buy',"false");
      }
    },
    /*logInitiateCheckoutEvent(contentData, contentId, contentType, numItems, paymentInfoAvailable, currency, totalPrice) {
    var params = {};
    params[FB.AppEvents.ParameterNames.CONTENT] = contentData;
    params[FB.AppEvents.ParameterNames.CONTENT_ID] = contentId;
    params[FB.AppEvents.ParameterNames.CONTENT_TYPE] = contentType;
    params[FB.AppEvents.ParameterNames.NUM_ITEMS] = numItems;
    params[FB.AppEvents.ParameterNames.PAYMENT_INFO_AVAILABLE] = paymentInfoAvailable ? 1 : 0;
    params[FB.AppEvents.ParameterNames.CURRENCY] = currency;
     FB.AppEvents.logEvent(FB.AppEvents.EventNames.INITIATED_CHECKOUT, totalPrice, params);
    },*/
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
    getWalletMoney:function()
    {
      axios({
      method:'GET',
        url : 'user/getMoney/'+localStorage.getItem('loginmobile')
      }).then(response => {
          console.log(response.data.result[0].money);
          this.money = response.data.result[0].money;  
      }).catch(function(error){
        if (error.response.data.message != undefined)
          console.log(error.response.data.message);
        else
          alert('system error found,please try again');
      });
    },
    getWishlist:function(){
      this.preloader = true;
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
    getCart:function(event,done){
       var a = 0;
       var b =0;
      this.disabled = true;
      this.preloader = true;
      axios({
        method:'GET',
        url : 'user/viewcart/json'
      }).then(response => {
        this.cartinfo = response.data.result;
        console.log(this.cartinfo);
        if(this.cartinfo.length > 0)
        {
          this.disabled = false;
        }
        for(var i = 0; i < this.cartinfo.length; i++)
        {
          this.cartinfo[i].mrp_price = parseInt(this.cartinfo[i].mrp_price);
        }
        for(var i = 0; i < this.cartinfo.length; i++)
        {
          this.cartinfo[i].selling_price = parseInt(this.cartinfo[i].selling_price);
        }
        for(var i = 0; i < this.cartinfo.length; i++)
        {
          this.mrp[i] = Math.floor(this.cartinfo[i].mrp_price);
        }
        this.total_mrp = 0;
        for (var i = 0; i < this.cartinfo.length; i++) {
          this.total_mrp = this.total_mrp+this.mrp[i];
        }
        console.log(this.total_mrp);
        for(var i = 0; i < this.cartinfo.length; i++)
        {
          this.selling[i] = Math.floor(this.cartinfo[i].selling_price);
          if(this.cartinfo[i].specialDiscount == true)
          {
            this.selling[i] = this.cartinfo[i].specialDiscountedPrice;
          }
        }
        this.total_selling = 0;
        this.money = Math.floor(this.money);
        for (var i = 0; i < this.cartinfo.length; i++) {
          this.total_selling = this.total_selling+this.selling[i];
        }
        this.final_selling = this.total_selling;
        this.total_discount = this.total_mrp - this.total_selling;
        //this.total_selling = a;
        console.log(this.total_selling);
        var shop_name = this.cartinfo[0].shop_name;
        for(var i = 0;i < this.cartinfo.length; i++)
        {
          if(this.cartinfo[i].shop_name == shop_name && this.cartinfo.length>1)
          {
            this.sameShop = 'true';
          }
          else
          {
            this.sameShop = 'false';
          }
        }
        console.log(this.sameShop);
        if(this.selectPromocode == true)
        {
          console.log('fghjbk');
          this.promocode = Math.floor((this.total_selling)*(30/100));
          if(this.promocode>50)
            this.promocode = 50;
          this.total_selling = this.final_selling - this.promocode;
        }
        this.preloader = false;
        done();
      }).catch(error => {
        /*if(error.response.data.message != undefined)
          alert(error.response.data.message);
        else*/
        //alert('Something went wrong,please try again');
        this.preloader = false;
      });
    },
    handleConnectivityChange(status) {
      this.internet = status;
      console.log(this.internet);
      while(!this.internet)
      {
        this.showNotificationWithButton();
      }
    },
     showNotificationWithButton() {
        const self = this;

        if (!self.notificationWithButton) {
          self.notificationWithButton = self.$f7.notification.create({
            icon: '',
            title: 'Notification',
            subtitle: 'Please Connect to Internet',
            text: '',
            closeButton: true,
          });
        }

        self.notificationWithButton.open();
      },
    MoveToWishlist:function(cart_id,product_id){
      this.preloader = true;
      axios({
        method:'POST',
        url : '/user/movetocart',
        data : {
          'cart_id' : cart_id,
          'product_id' : product_id
        }
      }).then(response => {
        const self = this;
        self.notificationWithButton = self.$f7.notification.create({
            icon: '',
            title: '',
            cssClass:'color',
            subtitle: 'Product moved to Liked Items',
            text: ''
          });
          self.notificationWithButton.open();
            setTimeout(()=>{
              this.closepop();
            },2000);
        this.getWishlist();
          this.getCart();
      }).catch(error => {
        if(error.response.data.message != undefined)
          alert(error.response.data.message);
        else
          alert('Something went wrong,please try again');
        this.preloader = false;
      });
    },
    DeleteFromCart:function(cart_id){
      this.preloader = true;
      axios({
        method:'POST',
        url : '/user/removefromcart',
        data : {
          'cart_id' : cart_id
        }
      }).then(response => {
        const self = this;
        self.notificationWithButton = self.$f7.notification.create({
            icon: '',
            title: '',
            cssClass:'color',
            subtitle: 'Product successfully deleted from cart',
            text: ''
          });
          self.notificationWithButton.open();
            setTimeout(()=>{
              this.closepop();
            },2000);
        this.sameShop = 'false';
        this.getCart();
        console.log(this.total_selling);
        
      }).catch(error => {
        if(error.response.data.message != undefined)
          alert(error.response.data.message);
        else
          alert('Something went wrong,please try again');
        this.preloader = false;
      });
    }
  }
};
</script>
<style scoped>
  .md .navbar:after{
  content:none
  }
  .lineclampin{
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    width: 100%;
    }
</style>