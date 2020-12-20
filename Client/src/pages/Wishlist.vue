<template>
  <f7-page name="wishlist"
           infinite
           :infinite-distance="50"
           :infinite-preloader="showPreloader"
           @infinite="loadMore"
           ptr @ptr:refresh="getWishlist"
  >
    
    <f7-navbar class="bgnav" style="border-radius:0px 0px 30px 0px;box-shadow: 5px 0px 10px rgba(0, 0, 0, 0.12)" sliding>
      <f7-nav-left>
        <f7-link icon-f7="icon-arrow_left" style="padding:21px" @click="$f7router.back()"></f7-link>
      </f7-nav-left>
      <f7-nav-title style="font-size:18px;font-weight:bold;margin:0px">
        Your Liked Items
      </f7-nav-title>
      <f7-nav-right>
        <f7-link style="padding:0 10px" href="/hdcart/"><img src="../assets/delivery-motorbike.svg" alt="">
        <span class="badge" v-if="cartinfo.length>0" style="border-radius: 16px;height: 20px;width: 20px;margin-top:-18px;margin-left:-1.5vw;background-color:#5ddcf9;color:#000000"><p style="margin-top: -19px;margin-left: -0.5vw;font-size:14px;font-weight:bold">{{cartinfo.length}}</p></span>
        </f7-link>
      </f7-nav-right>
    </f7-navbar>
          <offline @detected-condition="handleConnectivityChange">
  </offline>
    <!-- Scrollable page content-->
    <f7-block style="margin:0px;padding:0px">

      <div v-if="!preloader">
        <f7-block-title  style="margin-top:16px;color:#000000"><h5 class="mpzero" style=";font-size:18px;font-weight:bold"><img src="../assets/item_icon.png" style="width:30px;height:30px;border-radius:50%;vertical-align: middle;" alt="Shops">&nbsp Items ({{ wishlistinfo.length}})</h5></f7-block-title>
        <f7-block style="padding:0px;margin:0px 10px 0px 10px">
        <div v-if="wishlistinfo.length <= 0">
          <center><h3>No Product In Liked Items</h3></center>
        </div>
        <f7-row>
      <template v-for="(result,index) in wishlistinfo">
        <f7-col width="50" class="col_hgt" style="height:auto;margin-bottom:16px">
          <f7-link :href="'/productdetails/' + result.id + '/' + result.name" style="width:100%">
            <f7-card style="width:100%;height:100%;margin:0px;padding:0px;-webkit-box-shadow: none;box-shadow: none;border-radius:8px;border:1px solid gray">
              <div class="image_viewer" style="width: 100%;height:30vh;">
                <img :src="result.image" style="width:100%;height:100%;margin:0px;border-radius:8px 8px 0px 0px;object-fit: contain">
                <div v-show="result.specialDiscount == true" style="max-width:120px;position:absolute;z-index:99;bottom:135px;left:0px;background-image: linear-gradient(to right, #8E2DE2, #4A00E0);color:#FFFFFF;border-radius:0px 30px 30px 0px;font-size:16px;font-weight:bold;padding:3px 8px">
                  <p class="mpzero lineclampin" style="font-size:16px">&#8377;{{result.specialDiscountedPrice}}<span style="font-size:12px;line-height:17px;height:17px"> - {{result.offers}}</span></p>
                </div>
              </div>
              <div style="position:absolute;top:13px;left:13px;z-index:99;background-color:white;border-radius:50%;width:30px;height:30px">
                <f7-link @click="DeleteFromWishlist(result.id)" icon-f7="icon-close_round" style="color:gray;padding:5px"></f7-link>
              </div>
              <div style="position:absolute;top:5px;right:10px;z-index:99;background-color:#5ddcf9;border-radius:50%;color:#000000;width:46px;height:46px;opacity:0.9;text-align:center">
                    <p style="font-size:20px;font-weight:bold;margin:6px 0px 0px;padding:0px;line-height:20px">{{discount[index]}}</p>
                    <p style="font-size:10px;font-weight:bold;margin:0px;padding:0px;line-height:12px">% OFF</p>
              </div>
              <f7-block style="color:gray;font-size:14px;font-weight:bold;padding:16px 8px">
                <p class="mpzero lineclampin">
                  <span v-show="result.specialDiscount == false" style="color:#000000;font-size:17px">&#8377;{{result.selling_price}}</span>
                  <span v-show="result.specialDiscount == true" style="color:#000000;font-size:17px;text-decoration:line-through;margin-left:0px">&#8377;{{result.selling_price}}</span>
                  <span style="text-decoration:line-through;margin-left:3px">&#8377;{{result.mrp_price}}</span>
                </p>
                <p class="mpzero lineclampin" style="margin-top:5px">
                  <img src="../assets/shop_icon.png" style="width:24px;height:24px;border-radius:50%;vertical-align: middle;" alt="Shops">&nbsp {{result.shop_name}}
                </p>
              </f7-block>
              <f7-button @click="openSizes(index)" color="white" outline style="font-size:16px;font-weight:bold;text-transform:capitalize;border-radius:30px;border:1px solid #1d2671;color:#1d2671;margin:0px 8px 8px">Move to bag</f7-button>
            </f7-card>
          </f7-link>
        </f7-col>
      </template>
    </f7-row>
    </f7-block>
      </div>
    </f7-block>
    <f7-sheet ref="sizesheet" class="sizesheet" style="height:auto;border-radius:30px 30px 0px 0px">
          <f7-block-title style="margin:0px;padding:22px 16px 16px;font-size:18px;font-weight:bold;color:#000000"><img src="../assets/size_icon.png" style="width:30px;height:30px;border-radius:50%;vertical-align: middle;" alt="Size">&nbsp Select Size</f7-block-title>
          <f7-block style="margin:0px;padding:0px 0px 0px 16px">
            <template v-for="(result,itemIndex) in sizes">
              <f7-chip :class="{'size_selector_active': activeItemId === itemIndex}"
                 @click="setActiveItemId(itemIndex)"   style="margin:2px;cursor:pointer;text-transform: uppercase;font-size:16px;font-weight:bold" :text="result.size"></f7-chip>
          </template>
          </f7-block>
      <f7-button @click="addTocart('abc')" fill big href="/hdcart/" :disabled="sizeStatus" style="background-image: linear-gradient(to right, #11998e, #38ef7d);color:#FFFFFF;font-size:18px;font-weight:bold;border:0px;margin:10px;margin-top:20px;text-transform:capitalize;border-radius:30px">Add To Delivery Bag <f7-icon f7="chevron_right" style="margin:-5px 0px 0px 10px"></f7-icon></f7-button>
    </f7-sheet>
  </f7-page>
</template>
<script>
import axios from '../axios';
import offline from 'v-offline';
import F7Block from "framework7-vue/src/components/block";
export default {
  name: 'Wishlist',
  components: {F7Block},
  data() {
    return {
      title: 'ITEMS (16)',
      wishlistinfo:[],
      preloader:false,
      toast_msg:null,
      internet:null,
      status:'not shown',
      cartinfo:[],
      showPreloader:true,
      allowInfinite:true,
      loadMoreData:[],
      page:1,
      discount:[],
      index:null,
      sizes:[],
      activeItemId:null,
      selectedSize:null,
      sizeStatus:true,
    };
  },
    components: {
    offline
  },
  mounted()
  {
    this.getWishlist();
    this.getCart();
  },
  methods:{
    openSizes:function(index)
    {
      this.index = index;
      console.log(index);
      this.sizes = this.wishlistinfo[index].size;
      this.$refs.sizesheet.open();
    },
    setActiveItemId(itemIndex) {
      this.activeItemId = itemIndex;
      this.selectedSize = this.wishlistinfo[this.index].size[itemIndex].size;
      console.log(this.selectedSize);
      this.sizeStatus = false;
    },
    addTocart:function(text)
    {
      if(this.selectedSize == null)
      {
        this.toast_msg = 'Please select size';
        return false;
      }
      if(localStorage.getItem('local_id') && localStorage.getItem('token'))
      {
        axios({
          method:'POST',
          url : 'user/addtocart',
          header : {
            'local-id' : localStorage.getItem('local_id'),
            'token' : localStorage.getItem('token')
          },
          data:{
            'product_id' : this.wishlistinfo[this.index].id,
            'size' : this.selectedSize,
            'qty' : 1
          }
        }).then(response => {
          this.getCart();
          this.DeleteFromWishlist1(this.wishlistinfo[this.index].id);
          this.$refs.sizesheet.close();
          const self = this;
          self.notificationWithButton = self.$f7.notification.create({
            icon: '',
            title: '',
            cssClass:'color',
            subtitle: 'Product added to delivery bag',
            text: ''
          });
          self.notificationWithButton.open();
            setTimeout(()=>{
              this.closepop();
            },3000);
          console.log('hi');
        },(error) => {
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
    loadMore:function(){
      this.page = 1;
      const self = this;
      if(!self.allowInfinite) return;
      self.allowInfinite = false;
      if(this.loadMoreData.length >= 15)
      {
        console.log('load more call...');
        this.getWishlist();
        self.allowInfinite = true;
        return true;
      }
      else{
        self.showPreloader = false;
      }
      console.log('no more product');
      return false;
    },
    DeleteFromWishlist:function (p_id) {
      this.preloader = true;
      axios({
        method:'POST',
        url : 'user/deletewishlist/json',
        data:{
          'product_id' : p_id
        }
      }).then(response => {
       const self = this;
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
        this.preloader = false;
        this.page = 1;
        this.getWishlist();
      }).catch(error => {
        if(error.response.data.message != undefined)
          alert(error.response.data.message);
        else
          alert('failed to remove product from Liked Items');
        this.preloader = false;
      });
    },
    DeleteFromWishlist1:function (p_id) {
      this.preloader = true;
      axios({
        method:'POST',
        url : 'user/deletewishlist/json',
        data:{
          'product_id' : p_id
        }
      }).then(response => {
        this.preloader = false;
        this.page = 1;
        this.getWishlist();
      }).catch(error => {
        if(error.response.data.message != undefined)
          alert(error.response.data.message);
        else
          alert('failed to remove product from Liked Items');
        this.preloader = false;
      });
    },
    getWishlist:function(){
      this.preloader = true;
      axios({
        method:'GET',
        url : '/user/wishlist/json?page=' + this.page
      }).then(response => {
        if(this.page == 1)
        {
          this.wishlistinfo=response.data.result;
          console.log(this.wishlistinfo.length);
          this.loadMoreData = response.data.result;
          if(this.loadMoreData < 15)
          {
            this.showPreloader = false;
          }
          this.showPreloader = false;
        }
        else if(this.page > 1){
          this.loadMoreData = response.data.result;
          this.wishlistinfo = this.wishlistinfo.concat(this.loadMoreData);
        }
        else{
          this.page = 0;
        }
        if(this.wishlistinfo < 14)
        {
          this.preloader = false;
          this.showPreloader = false;
        }
        for(var i = 0;i< this.wishlistinfo.length; i++)
        {
          this.wishlistinfo[i].mrp_price = parseInt(this.wishlistinfo[i].mrp_price);
        }
        for(var i = 0;i< this.wishlistinfo.length; i++)
        {
          this.wishlistinfo[i].selling_price = parseInt(this.wishlistinfo[i].selling_price);
        }
        for(var i = 0;i< this.wishlistinfo.length; i++)
        {
          this.discount[i] = parseInt(((this.wishlistinfo[i].mrp_price-this.wishlistinfo[i].selling_price)/this.wishlistinfo[i].mrp_price)*100);
          if(this.wishlistinfo[i].specialDiscount == true)
          {
            this.discount[i] = this.wishlistinfo[i].specialDiscountedPercentage;
          }
        }
        console.log(this.wishlistinfo);
        this.page++;
        this.preloader = false;
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
  .size_selector_active{
    background-color:#273657 !important;
    color:#00FF96;
  }
 @media only screen and (max-height: 570px) {
    .col_hgt{
      height: 48vh !important;
    }
  }
  @media only screen and (max-height: 530px){
      .col_hgt{
      height: 50vh !important;
    }
  }
</style>
