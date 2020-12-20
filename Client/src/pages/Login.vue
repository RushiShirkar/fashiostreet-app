<template>
  <f7-page name="categorymen">
    <f7-navbar back-link="Back" class="bgnav" style="border-radius:0px 0px 30px 0px;box-shadow: 5px 0px 10px rgba(0, 0, 0, 0.12)" sliding>
      <f7-nav-title style="font-size:18px;font-weight:bold;margin:0px">
        {{offer_name}}
      </f7-nav-title>
    </f7-navbar>
    <offline @detected-condition="handleConnectivityChange">
    </offline>
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
    <!-- Scrollable page content-->
    <f7-block style="margin:0px">
      <f7-row style="margin:15px 0px 55px 0px">
        <template v-for="(category,index) in categories">
          <f7-col width="50" style="margin-bottom:16px">
           <f7-link @click="saveproduct('T-Shirts')" href="/products/">
             <f7-card style="margin:0px;border-radius:10px;padding:0px 5px;-webkit-box-shadow: none;box-shadow: none;border:1px solid gray">
              <center>
                <p style="color:#000000;font-size:16px;font-weight:bold;margin:14px 0px">20% OFF</p>
                <img src="../assets/m_tshirt.png" style="width:100%;height:152px;border-radius:10px 10px;margin-bottom:0px" alt="">
              </center>
             </f7-card>
           </f7-link>
          </f7-col>
        </template>
      </f7-row>
    </f7-block>
    <div style="position:fixed;bottom:0px;left:0px;width:100%;z-index:99;border-radius:30px 30px 0px 0px;background-image: linear-gradient(to right, #ff416c, #ff4b2b);color:#FFFFFF">
      <center>
        <f7-link @click="saveproduct('T-Shirts')" href="/products/" style="width:100%">
            <p style="font-size:16px;font-weight:bold;color:#FFFFFF">By Shop : {{shop_name}}</p>
        </f7-link>
      </center>
    </div>
  </f7-page>
</template>

<script>
import offline from 'v-offline';

import { f7Navbar, f7Page, f7Block, f7Button } from 'framework7-vue';
import axios from 'axios';
export default {
  name: 'Offercategory',
  data() {
    return {
      category:[],
      title: 'Services Page',
      internet:null,
      AppLoader:true,
      cartinfo:[],
      wishlistinfo:[],
      status:'not shown',
      products:[],
      discount:[],
      showPreloader:true,
      categories:['1','2','3','4','5','6'],
      shop_name:localStorage.getItem('shop'),
      offer_name:localStorage.getItem('bname')
    };
  },
  components: {
    offline
  },
   mounted(){
    this.getCategoriesOfShopOffers();
    this.showPreloader = true;
  },
  methods:{
    getCategoriesOfShopOffers()
    {
      axios({
        method:'GET',
        url : 'getAppVersion',
      }).then(response => {
        //this.shopOfferBanners = response.data.result; 
        //console.log(this.shopOfferBanners);
      },(error) => {
        alert(error.response.data.message);
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
    savecategory:function(category){
      localStorage.setItem("category",category);
    },
    saveproduct:function(product){
            localStorage.setItem("category","Men Footwear");
      localStorage.setItem("product",product);
    }
  }
};
</script>
<style scoped>
.md .navbar:after{
  content:none
}
</style>
