<template>
  <f7-page name="Offers"
           infinite :infinite-distance="50" :infinite-preloader="showPreloader"
           @infinite="loadMore" ptr  @ptr:refresh="getOffers2"
  >
    <f7-navbar back-link="Back" class="bgnav" style="border-radius:0px 0px 30px 0px;box-shadow: 5px 0px 10px rgba(0, 0, 0, 0.12)" sliding>

      <f7-nav-title style="font-size:16px;font-weight:bold;margin:0px">
        {{navHeading}}
      </f7-nav-title>
      <f7-nav-right>
        <!--<f7-link style="padding:0 10px"><img src="../assets/share.svg" alt=""></f7-link>-->
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
          <f7-row no-gap style="background-color:#ffffff">
            <template v-for="(result,index) in shopoffers">
              <f7-col v-if="listSizes[index]!=''" width="50" class="col_hgt" style="height:49vh;border-right:1px solid #f1f3f6;border-bottom:1px solid #f1f3f6" :key="index">
                <f7-link :href="'/productdetails/' + result.id + '/' + result.name" style="width:100%">
                  <f7-card style="width:100%;height:100%;margin:0px;padding:0px;-webkit-box-shadow: none;box-shadow: none">
                    <div class="image_viewer" style="width: 100%;height:35vh;">
                      <img :src="result.image[0]" style="width:100%;height:100%;margin:0px;object-fit: contain">
                      <div v-show="result.specialDiscount == true" style="max-width:120px;position:absolute;z-index:99;bottom:84px;left:0px;background-image: linear-gradient(to right, #8E2DE2, #4A00E0);color:#FFFFFF;border-radius:0px 30px 30px 0px;font-size:16px;font-weight:bold;padding:3px 8px">
                        <p class="mpzero lineclampin" style="font-size:16px">&#8377;{{result.specialDiscountedPrice}}<span style="font-size:12px;line-height:17px;height:17px"> - {{offer_name}}</span></p>
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
                    <img src="../assets/shop_icon.png" style="width:24px;height:24px;border-radius:50%;vertical-align: middle;" alt="Shops">&nbsp{{result.shop_name}}</p>
                  </f7-block>
                  </f7-card>
                </f7-link>
              </f7-col>
            </template>
          </f7-row>
          <div style="position:fixed;bottom:0px;left:0px;width:100%;z-index:99;border-radius:30px 30px 0px 0px;background-image: linear-gradient(to right, #ff416c, #ff4b2b);color:#FFFFFF">
              <f7-link style="width:100%" href="/offercategory/">
                <center>
                  <p style="font-size:16px;font-weight:bold;color:#FFFFFF;margin:6px 5px 2px">{{offer_name}}</P>
                  <p style="font-size:12px;color:#FFFFFF;margin:0px 5px 6px">By Shop : Superstar kids mens</p>
                </center>
              </f7-link>
          </div>
  </f7-page>
</template>

<script>
import axios from '../axios';
import offline from 'v-offline';
import F7Row from "framework7-vue/src/components/row";
export default {
  name: 'Offers1',
  components: {F7Row,offline},
  data() {
    return {
      title: 'Services Page',
      shopinfo:[],
      showPreloader:true,
      loadMoreData:[],
      page:1,
      inProcess:false,
      allowInfinite:true,
      AppLoader:false,
      trendinginfo:[],
      name:null,
      image:null,
      contact:null,
      alt_contact:null,
      op_time:null,
      cl_time:null,
      close_days:null,
      address:null,
      productinfo:[],
      shopoffers:[],
      offer_name:localStorage.getItem("bname"),
      shop_name:localStorage.getItem("shop"),
      index:localStorage.getItem("index"),
      offerCategory:localStorage.getItem("offerCategory"),
      offerCategoryName:localStorage.getItem("offerCategoryName"),
      offerDiscount:localStorage.getItem("offerDiscount"),
      internet:null,
      status:'not shown',
      cartinfo:[],
      wishlistinfo:[],
      shops:[],
      listSizes:[],
      discount:[],
      navHeading:null
    };
  },
   mounted(){
     //this.getOfferDetails();
     this.navHeading = this.offerDiscount + '% OFF on ' + this.offerCategoryName;
     this.getCart();
     this.getWishlist();
     this.getOffers();
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
      console.log('load more call');
      const self = this;
      if(this.loadMoreData.length >= 15)
      {
        self.allowInfinite = true;
      }
      else{
        self.allowInfinite = false;
        self.showPreloader = false;
        return false;
      }
      if(!self.allowInfinite) return;
      self.allowInfinite = false;
      if(this.loadMoreData.length >= 15)
      {
        if(this.inProcess == false)
        {
          this.inProcess = true;
          console.log('load more call...');
          this.getOffers();
          self.allowInfinite = true;
          return true;
        }
      }
      else {
        self.showPreloader = false;
      }
      console.log('no more product');
      return false;
    },
    getOffers2:function(event,done)
    {
      this.showPreloader = true;
      this.getOffers(event,done,1);
    },
    getOffers:function(event,done,index){
      if(index!=undefined)
      {
        this.page = index;
      }
      var axiosMeta = {
          method: 'GET',
          url: '/offers/'+this.shop_name+'/'+this.offerCategory+'/'+this.offerDiscount+'/'+this.page
        };
        if(localStorage.getItem('local_id') && localStorage.getItem('token')){
          axiosMeta.header = {
            'local-id' : localStorage.getItem('local_id'),
            'token' : localStorage.getItem('token')
          };
        }
      axios(axiosMeta).then((response) => {
        this.inProcess = false;
        if(this.page==1)
        {
          this.shopoffers = response.data.result;
          this.loadMoreData = response.data.result;
          console.log(this.shopoffers);
        }
        else if(this.page>1)
        {
          this.loadMoreData = response.data.result;
          this.shopoffers = this.shopoffers.concat(this.loadMoreData);
          console.log(this.shopoffers);
        }
        else
        {
          this.page = 0;
        }
        if(index!=undefined)
        {
          this.page = index;
        }
        for(var i=0;i<this.shopoffers.length;i++)
        {
          this.shopoffers[i].mrp_price = parseInt(this.shopoffers[i].mrp_price);
        }
        for(var i=0;i<this.shopoffers.length;i++)
        {
          this.shopoffers[i].selling_price = parseInt(this.shopoffers[i].selling_price);
        }
        for(var i=0;i<this.shopoffers.length;i++)
        {
          this.discount[i] = parseInt(((this.shopoffers[i].mrp_price - this.shopoffers[i].selling_price)/this.shopoffers[i].mrp_price)*100);
          if(this.shopoffers[i].specialDiscount == true)
          {
            this.discount[i] = this.shopoffers[i].specialDiscountedPercentage;
          }
        }
        this.page = this.page + 1;
        this.preloader = false;
        //this.showPreloader = false;
        this.inProcess = false;
      },(error)=>{
        this.inProcess = false;
        if(this.page = 1)
        {
          done();
        }
        if (error.response.data.message != undefined) {
          alert(error.response.data.message);
        }
        else
          alert('application error found,restart your application');
      });
    },
    savedata:function(name,id,sname)
    {
      localStorage.setItem("pname",name);
      localStorage.setItem("pid",id);
      localStorage.setItem("sname",sname);
    },
    addToWishlist:function(product_id,status,el,index){
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
             this.shopoffers[index].wishlistflag = 0;
          self.notificationWithButton = self.$f7.notification.create({
            icon: '',
            title: '',
            cssClass:'color',
            subtitle: 'Product removed to Liked items',
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
            this.shopoffers[index].wishlistflag = 1;
            this.AppLoader = false;
             const self = this;
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
