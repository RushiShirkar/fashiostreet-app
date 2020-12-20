<template>
  <f7-page name="shophome"
           ptr @ptr:refresh="getShopDetails"
  >
  <div v-if="toast_msg != null" class="custom_toast z-depth-3">
      {{ toast_msg }}
    </div>
    <f7-navbar @click="$f7router.back()" back-link="Back" class="bgnav" style="border-radius:0px 0px 30px 0px;box-shadow: 5px 0px 10px rgba(0, 0, 0, 0.12)" sliding>

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
     <span style="position:absolute;z-index:9;top:78px;left:15px;background-color:#1fd163;color:#FFFFFF;padding:3px 5px;border-radius:4px;font-size:16px;font-weight:bold">New</span>
        <f7-row no-gap style="padding:16px 8px">
           <f7-col width="35" style="height:120px">
             <span style="position:absolute;top:15px;left:15px;background-color:#1fd163;color:#FFFFFF;padding:3px 5px;border-radius:4px;font-weight:bold">New</span>
             <img :src="'https://seller.fashiostreet.com/shops/compress/'+image" style="width:115px;height:115px;border-radius:10px" alt="">
           </f7-col>
           <f7-col width="65" style="padding:6px 0px 0px 10px">
             <p style="font-weight:bold;color:#000000;font-size:20px" class="mpzero">{{name}}</p>
             <h5 style="font-weight:bold;color:gray;font-size:14px;margin:8px 0px" class="mpzero">{{address}}</h5>
           </f7-col>
        </f7-row>
      <div style="margin:0px auto;padding:10px 0px;width:89%;background-image: linear-gradient(to right, #1d2671, #dc5496);border-radius:30px">
         <f7-row no-gap>
           <f7-col style="padding-top:3px">
             <a @click="call"  class="link external" :href="'tel:' + this.contact"  style="color:white;display:block;font-size:16px;font-weight:bold;padding:4px 0px"><center style="line-height:1"><f7-icon f7="phone_fill" style="padding-right:8px"></f7-icon>Call Now</center></a>
           </f7-col>
           <f7-col style="border-left:1px solid #FFFFFF;padding-top:3px" >
             <a @click="whatsapp" class="link external" :href="'https://wa.me/+91'+this.contact+'?text=I%20saw%20your%20shop%20on%20Fashiostreet%20and%20I%20am%20interested%20in%20knowing%20'" style="color:white;display:block;font-size:16px;font-weight:bold"><center><img src="../assets/whatsapp-logo.svg" alt="chat with shopkeeper"><div style="display:inline-block;padding-left:8px;position: relative;bottom:5px">Whatsapp</div></center></a>
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
      <f7-block style="font-size:16px;font-weight:bold;margin:28px 10px 10px 0px;padding:0px 16px;background-color:#FFFFFF;color:#212121;border:1px solid gray;border-radius:0px 30px 30px 0px;border-left:0px">
        <f7-block style="margin:22px 0px;padding:0px">
          <f7-icon f7="icon-time" style="font-size:28px"></f7-icon><span style="padding-left:14px">{{op_time}} AM - {{cl_time}} PM ({{close_days}} Closed)</span>
        </f7-block>
        <f7-block style="margin:22px 0px;padding:0px">
          <f7-icon f7="icon-card" style="font-size:28px"></f7-icon><span style="padding-left:16px">Cash, Mobile Banking, Card</span>
        </f7-block>
      </f7-block>
      <f7-block style="margin:28px 0px 10px 10px;padding:0px;background-color:#FFFFFF;border:1px solid gray;border-radius:30px 0px 0px 30px;border-right:0px">
      <f7-block-title style="margin:0px;padding:20px 16px 22px 20px;font-size:18px;font-weight:bold;color:#000000"><p class="mpzero"><img src="../assets/sale_icon.png" style="width:30px;height:30px;border-radius:50%;vertical-align: middle;" alt="Shops"> &nbsp {{offer_name}}</p></f7-block-title>
      <div style="padding:0px 6px 28px 16px;margin-left:2px;overflow-x:scroll;overflow-y:hidden;white-space:nowrap;" v-show="categories.length>0">
        <template v-for="category in categories">
          <f7-link @click="saveproduct(category.subcategory_id,category.discount,category.subcategory_name)" href="/offers1">
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
      <div style="padding:0px 6px 28px 16px;overflow-x:scroll;overflow-y:hidden;white-space:nowrap;" v-show="categories.length==0">
        <span style="font-weight:bold;font-size:16px;background-color:skyblue;color:navy;padding:8px 16px;border-radius:30px;display:inline-block">No Offers</span> 
      </div>
    </f7-block>

         <f7-block style="background-color:#FFFFFF;margin:28px 0px 0px;padding:5px 0px 0px;border-top:1px solid gray; border-radius: 30px 30px 0px 0px">
             <div style="padding:20px 16px 22px 20px">
                <div style="display:inline-block;height:30px">
                  <img src="../assets/trending_icon.png" style="width:30px;height:30px;border-radius:50%;vertical-align: middle;" alt="Shops">
                </div>
                <div style="font-weight:bold;color:#000000;font-size:18px;display:inline-block;vertical-align: middle;" class="mpzero">&nbsp Trending products at shop</div>
            </div>
            <template v-for="(result,index) in productinfo">
                <f7-link :href="'/productdetails/' + result.id + '/' + result.name" style="width:50%;height:47vh;border-right:1px solid #f1f3f6;border-bottom:1px solid #f1f3f6">
                  <f7-card style="width:100%;height:100%;margin:0px;padding:0px;-webkit-box-shadow: none;box-shadow: none">
                    <div class="image_viewer" style="width: 100%;height:35vh;">
                      <img :src="result.image" style="width:100%;height:100%;margin:0px">
                      <div v-show="result.specialDiscount == true" style="max-width:120px;position:absolute;z-index:99;bottom:84px;left:0px;background-image: linear-gradient(to right, #8E2DE2, #4A00E0);color:#FFFFFF;border-radius:0px 30px 30px 0px;font-size:16px;font-weight:bold;padding:3px 8px">
                        <p class="mpzero lineclampin" style="font-size:16px">&#8377;{{result.specialDiscountedPrice}}<span style="font-size:12px;line-height:17px;height:17px"> - {{offer_name}}</span></p>
                      </div>
                    </div>
                    <div style="position:absolute;top:10px;left:10px;z-index:99;background-color:#5ddcf9;border-radius:50%;color:#000000;width:46px;height:46px;opacity:0.9;text-align:center">
                      <p style="font-size:20px;font-weight:bold;margin:6px 0px 0px;padding:0px;line-height:20px">{{discount[index]}}</p>
                      <p style="font-size:10px;font-weight:bold;margin:0px;padding:0px;line-height:12px">% OFF</p>
                    </div>
                    <f7-block style="color:gray;font-size:14px;font-weight:bold;padding:8px">
                        <p class="mpzero lineclampin">
                        <span v-show="result.specialDiscount == false" style="color:#000000;font-size:17px">&#8377;{{result.selling_price}}</span>
                      <span v-show="result.specialDiscount == true" style="color:#000000;font-size:17px;text-decoration:line-through;margin-left:0px">&#8377;{{result.selling_price}}</span>
                        <span style="text-decoration:line-through;margin-left:3px">&#8377;{{result.mrp_price}}</span></p>
                        <p class="mpzero lineclampin" style="margin-top:8px">
                        <img src="../assets/shop_icon.png" style="width:24px;height:24px;border-radius:50%;vertical-align: middle;" alt="Shops">&nbsp {{result.shop_name}}</p>
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
      toast_msg:null,
      discount:[],
      checkOffers:null,
      categories:null,
      shop_name:localStorage.getItem('shop'),
      offer_name:null
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
        data: {
          shop_name:this.name,
           mobile:localStorage.getItem('loginmobile')
        }
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
        data: {
          shop_name:this.name,
          mobile:localStorage.getItem('loginmobile')
        }
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
        data: {
          shop_name:this.name,
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
          console.log(response);
          this.shopinfo = response.data.shop[0];
          this.categories = response.data.categories;
          console.log(this.shopinfo);
          this.productinfo = response.data.products;
          console.log(this.productinfo);
          for(var i=0;i<this.productinfo.length;i++)
          {
            this.productinfo[i].mrp_price = parseInt(this.productinfo[i].mrp_price);
          }
          for(var i=0;i<this.productinfo.length;i++)
          {
            this.productinfo[i].selling_price = parseInt(this.productinfo[i].selling_price);
          }
          for(var i=0;i<this.productinfo.length;i++)
          {
            this.discount[i] = parseInt(((this.productinfo[i].mrp_price - this.productinfo[i].selling_price)/this.productinfo[i].mrp_price)*100);
            if(this.productinfo[i].specialDiscount == true)
            {
              this.discount[i] = this.productinfo[i].specialDiscountedPercentage;
            }
          }
          if(this.shopinfo.offers!=null)
          {
            this.checkOffers = true;
          }
          else
          {
            this.checkOffers = false;
          }
          this.offer_name = this.shopinfo.offers[0];
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
    },
    saveproduct(category,discount,category_name)
    {
      localStorage.setItem('offerCategory',category);
      localStorage.setItem('offerDiscount',discount);
      localStorage.setItem('shop',localStorage.getItem('sname'));
      localStorage.setItem('offerCategoryName',category_name);
      localStorage.setItem('bname',this.offer_name);
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
.prod_width{
    width: 150px
  }
  .box::-webkit-scrollbar {
    display: none;
    -moz-appearance: none;
   }
</style>
