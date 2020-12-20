<template>
  <f7-page class="bgpage" name="shophome"
           ptr @ptr:refresh="getShopDetails"
  >
  <div v-if="toast_msg != null" class="custom_toast z-depth-3">
      {{ toast_msg }}
    </div>
    <f7-navbar @click="$f7router.back()" back-link="Back" class="bgnav" sliding>

      <f7-nav-title style="margin:0px;padding-top:5px">
        <img src="../assets/fashiostreet.png" style="height:25px" alt="">
      </f7-nav-title>
      <f7-nav-right>
        <!--<f7-link style="padding:0 10px"><img src="../assets/share.svg" alt=""></f7-link>-->
      </f7-nav-right>
    </f7-navbar>
          <offline @detected-condition="handleConnectivityChange">
  </offline>
      <center>
        <div v-if="showPreloader" class="preloader" style="margin:25px 0px 0px">
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
      <div v-if="!fetched">
        <center>
          <h3>
        No Products Found in the Shop
        </h3>
        </center>
      </div>
    <div v-if="!showPreloader && fetched" >
     <span style="position:absolute;top:70px;left:15px;background-color:#1fd163;color:#FFFFFF;padding:3px 5px;border-radius:4px;z-index:9">NEW</span>
     <f7-swiper pagination style="background-color:#FFFFFF">
       <template v-for="(image,index) in shopinfo.image">
          <f7-swiper-slide style="height:30vh">
            <img :src="'https://seller.fashiostreet.com/shops/original/' + image" style="width:100%;height:100%" alt="">
          </f7-swiper-slide>
       </template>
     </f7-swiper>
<div style="padding:10px 0px;width:100%;background-color:#273657;border-radius:0px">
         <f7-row no-gap>
           <f7-col width="30" >
             <a icon-f7="phone_fill" @click="call"  class="link external" :href="'tel:' + this.contact"  style="color:white;display:block;font-size:14px;font-weight:bold;padding:3px 0px"><center>CALL NOW</center></a>
           </f7-col>
           <f7-col width="30" @click="chat" style="height:28px;border-left:1px solid #FFFFFF">
             <a icon-f7="chats_fill" @click="chat" class="link external" :href="'sms://' + this.contact + '?body=I saw your shop on Fashiostreet and I\'m interested in knowing'" style="color:white;display:block;font-size:14px;font-weight:bold;padding:3px 0px"><center>CHAT NOW</center></a>
           </f7-col>
           <f7-col width="40" style="border-left:1px solid #FFFFFF" >
             <a icon-f7="chats_fill"  @click="whatsapp" class="link external" :href="'https://wa.me/+91'+this.contact+'?text=I%20saw%20your%20shop%20on%20Fashiostreet%20and%20I%20am%20interested%20in%20knowing%20'" style="color:white;display:block;font-size:14px;font-weight:bold"><center><img src="../assets/whatsapp-logo.svg" alt="chat with shopkeeper"><div style="display:inline-block;padding-left:5px;position: relative;bottom:5px">WHATSAPP</div></center></a>
           </f7-col>
         </f7-row>
        </div>
      <!--<div style="background-color:#FFFFFF;padding:1px 16px;box-shadow:0px 1px 6px 0px rgba(0, 0, 0, 0.1);margin:0px 0px 8px">
      <f7-block style="margin:15px 0">
        <f7-list accordian style="margin-top:0px;margin-bottom:0px">
          <template v-for="results in category">
            <f7-list-item :title="results" style="font-size:13px"/>
          </template>
        </f7-list>
      </f7-block>
        </div>-->
        <f7-block style="font-size:14px;font-weight:normal;margin:0px 0px 8px;padding:8px 16px;background-color:#FFFFFF;box-shadow:0px 1px 6px 0px rgba(0, 0, 0, 0.1)">
        <f7-block style="margin:5px 0px 5px 0px;padding:0px">
          <span style="color:#696969;font-size:20px;font-weight:bold">{{name}}</span>
        </f7-block>
        <f7-block style="margin:5px 0px 15px 0px;padding:0px">
          <span>{{address}}</span>
        </f7-block>
        <f7-block style="margin:15px 0;padding:0px">
          <f7-icon f7="icon-phone"></f7-icon><span style="padding-left:10px">{{contact}} / {{alt_contact}}</span>
        </f7-block>
        <f7-block style="margin:15px 0;padding:0px">
          <f7-icon f7="icon-time"></f7-icon><span style="padding-left:10px">{{op_time}} AM - {{cl_time}} PM ({{close_days}} Closed)</span>
        </f7-block>
        <f7-block style="margin:15px 0;padding:0px">
          <f7-icon f7="icon-card"></f7-icon><span style="padding-left:10px">Cash, Mobile Banking, Card</span>
        </f7-block>
      </f7-block>
        <f7-block style="margin:0px 0px 8px;padding:16px;background-color:#FFFFFF;box-shadow:0px 1px 6px 0px rgba(0, 0, 0, 0.1)">
      <f7-block-title style="margin:0px 0px 16px"><h5 class="mpzero">ONGOING SHOP OFFERS</h5></f7-block-title>
      <f7-swiper :params="{speed:500, slidesPerView: 2, spaceBetween: 10}" v-show="shopinfo.offers!=null">
        <template v-for="offer in shopinfo.offers">
          <f7-swiper-slide style="padding:8px;background-color:skyblue;font-size:14px;color:navy;text-align: center;font-weight: bold;border-radius:2px">{{ offer }}</f7-swiper-slide>
        </template>
      </f7-swiper>
      <div style="font-weight:normal;font-size:14px;background-color:skyblue;color:navy;padding:5px 10px;margin-right:160px;border-radius:2px" v-show="shopinfo.offers==null">
        No Offers 
      </div>
    </f7-block>

         <f7-block style="background-color:#FFFFFF;box-shadow:0px 1px 6px 0px rgba(0, 0, 0, 0.1);margin:0px;padding:5px 0px 0px">
             <div style="height:10px;border-bottom: 1px solid #BDBDBD; text-align: center;margin:15px 24px 35px 24px">
                <span class="mpzero" style="font-size:12px;font-weight:bold;padding:0px 10px;background-color:#FFFFFF">TRENDING PRODUCTS OF THIS SHOP</span>
             </div>
            <template v-for="result in productinfo">
                <f7-link :href="'/productdetails/' + result.id + '/' + result.name" style="width:50%;height:47vh;border-right:1px solid #f1f3f6;border-bottom:1px solid #f1f3f6">
                  <f7-card style="width:100%;height:100%;margin:0px;padding:0px;-webkit-box-shadow: none;box-shadow: none">
                    <div class="image_viewer" style="width: 100%;height:35vh;">
                      <img :src="result.image" style="width:100%;height:100%;margin:0px">
                    </div>
                    <f7-block style="color:#BDBDBD;font-size:12px;font-weight:bold;;padding:8px">
                      <p class="mpzero lineclampin" style="text-transform: capitalize">{{result.name}}</p>
          <p class="mpzero lineclampin">
          <span style="color:gray;font-size:14px">Rs.{{result.selling_price}} </span>
          <span style="text-decoration:line-through;margin-left:3px">Rs.{{result.mrp_price}}</span></p>
          <p class="mpzero lineclampin">Store : {{result.shop_name}}</p>
                    </f7-block>
                  </f7-card>
                </f7-link>
            </template>
      </f7-block>
    </div>
  </f7-page>
</template>

<script>
import axios from '../axios';
import offline from 'v-offline';
import F7Row from "framework7-vue/src/components/row";
export default {
  name: 'Shophome',
  components: {F7Row},
  data() {
    return {
      title: 'Services Page',
      shopinfo:[],
      showPreloader:false,
      trendinginfo:[],
      name:localStorage.getItem("sname"),
      image:null,
      fetched:true,
      contact:null,
      internet:null,
      status:'not shown',
      alt_contact:null,
      op_time:null,
      cl_time:null,
      close_days:null,
      address:null,
      productinfo:[],
      category:[],
      toast_msg:null
    };
  },
    components: {
    offline
  },
   mounted(){
    if(localStorage.getItem('visit') == "true")
    {
      this.toast_msg = "Hurray !! FS Discount activated to your whatsapp number";
      setTimeout(() => {
        this.toast_msg = null;
      },4000);
    }
    this.getShopDetails();
    localStorage.removeItem('visit');
     //this.getCategory();
  },
  created(){
    //this.getCategory();
  },
  methods:{
    call(){
      axios({
        method: 'POST',
        url: 'shop/call',
        data: {shop_name:this.name}
      }).then(response => {
        console.log(response);
      }, (error) => { 
        console.log(error.response.data.message);          
      });
    },
    chat(){
      axios({
        method: 'POST',
        url: 'shop/chat',
        data: {shop_name:this.name}
      }).then(response => {
        console.log(response);
      }, (error) => { 
        console.log(error.response.data.message);          
      });
    },
    whatsapp(){
      axios({
        method: 'POST',
        url: 'shop/whatsapp',
        data: {shop_name:this.name}
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
    getShopDetails:function(event,done){
      //this.getCategory();
      console.log(localStorage.getItem("sname"));
      if(this.showPreloader == false) {
        this.showPreloader = true;
        axios({
          method: 'GET',
          url: '/shop/' + localStorage.getItem("city") + '/available-category/json?shop=' + localStorage.getItem("sname"),
        }).then(response => {
          //this.showPreloader = false;
          this.shopinfo = response.data.shop[0];

          this.productinfo = response.data.products;
          this.name = this.shopinfo.name;
          this.image = this.shopinfo.image;
          this.contact = this.shopinfo.contact;
          this.alt_contact = this.shopinfo.alternate_contact;
          this.op_time = this.shopinfo.opening_time;
          this.cl_time = this.shopinfo.closing_time;
          this.address = this.shopinfo.address;
          this.close_days = this.shopinfo.close_days;
          this.showPreloader = false;
        }, (error) =>
        {
          if(error.response.data.message != undefined)
          {
            this.fetched = false;
            this.showPreloader = false;
           // alert(error.response.data.message);
          
          }
          else
          {
            this.fetched = false;
            alert('application error found,please restart your app');
           
          }
        });
      }
    },
     getCategory:function(event,done){
        axios({
          method: 'GET',
          url: '/shop/'+localStorage.getItem("sname")
        }).then(response => {
          this.category = response.data.result;
          console.log(this.category);
          done();
        },(error) =>
        {
          if(error.response.data.message != undefined)
          {
            this.fetched = false;
            this.showPreloader = false;
          }
          else
          {
            this.fetched = false;
            alert('application error found,please restart your app'); 
          }
        })
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
.lineclampin{
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    width: 100%;
}
.prod_width{
    width: 150px
  }
  .box::-webkit-scrollbar {
    display: none;
    -moz-appearance: none;
   }
</style>
