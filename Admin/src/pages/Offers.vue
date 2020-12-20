<template>
  <f7-page style="color:#BDBDBD" name="Offers"
           ptr @ptr:refresh="getOfferDetails"
  >
    <f7-navbar back-link="Back" class="bgnav" sliding>

      <f7-nav-title style="font-size:15px;margin:0px">
        {{offer_name}}
      </f7-nav-title>
      <f7-nav-right>
        <!--<f7-link style="padding:0 10px"><img src="../assets/share.svg" alt=""></f7-link>-->
        <f7-link style="padding:0 10px" icon-f7="icon-heart_fill" href="/wishlist/" v-if="wishlistinfo.length>0"><span class="badge color-red" style="border-radius: 16px;height: 15px;width: 15px;margin-top: -5vw;margin-left:-5px;"><p style="margin-top: -5.5vw;margin-left: -0.5vw;">{{wishlistinfo.length}}</p></span></f7-link>
        <f7-link style="padding:0 10px" icon-f7="icon-heart_fill" href="/wishlist/" v-else></f7-link>
        <f7-link style="padding:0 10px" href="/hdcart/" v-if="cartinfo.length>0"><img src="../assets/delivery-motorbike.svg" alt=""><span class="badge color-red" style="border-radius: 16px;height: 15px;width: 15px;margin-top: -5vw;"><p style="margin-top: -5.5vw;margin-left: -0.5vw;">{{cartinfo.length}}</p></span></f7-link>
        <f7-link style="padding:0 10px" href="/hdcart/" v-else><img src="../assets/delivery-motorbike.svg" alt=""></f7-link>      </f7-nav-right>
      </f7-nav-right>
    </f7-navbar>
    <offline @detected-condition="handleConnectivityChange">
  </offline>
      <center>
        <div v-if="showPreloader" class="preloader" style="margin:25px 0px 0px;">
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
    <div v-if="!showPreloader">

          <f7-row no-gap style="background-color:#ffffff">
            <template v-for="(result,index) in shopoffers">
              <f7-col v-if="listSizes[index]!=''" width="50" class="col_hgt" style="height:44vh;border-right:1px solid #f1f3f6;border-bottom:1px solid #f1f3f6" :key="index">
                <f7-link :href="'/productdetails/' + result.id + '/' + result.name" style="width:100%">
                  <f7-card style="width:100%;height:100%;margin:0px;padding:0px;-webkit-box-shadow: none;box-shadow: none">
                    <div class="image_viewer" style="width: 100%;height:35vh;">
                      <img :src="result.image[0]" style="width:100%;height:100%;margin:0px">
                      <f7-chip :text="listSizes[index]" class="lineclampin1" style="position:absolute;bottom:12vh;left:5px;z-index:99;color:#FFFFFF;background-color:#000000;opacity:0.8"></f7-chip>
                    </div>
                    <f7-block style="color:#BDBDBD;font-size:12px;font-weight:bold;padding:8px">
                      <p class="mpzero lineclampin" style="text-transform: capitalize">{{result.name}}</p>
                      <p class="mpzero lineclampin">
                      <span style="color:gray;font-size:14px">Rs.{{result.selling_price}} </span>
                      <span style="text-decoration:line-through;margin-left:3px">Rs.{{result.mrp_price}}</span></p>
                      <!--<p class="mpzero lineclampin">Store : {{shops[index]}}</p>-->
                    </f7-block>
                  </f7-card>
                </f7-link>
              </f7-col>
            </template>
          </f7-row>
</div>
  </f7-page>
</template>

<script>
import axios from '../axios';
import offline from 'v-offline';
import F7Row from "framework7-vue/src/components/row";
export default {
  name: 'Offers',
  components: {F7Row,offline},
  data() {
    return {
      title: 'Services Page',
      shopinfo:[],
      showPreloader:false,
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
      internet:null,
      status:'not shown',
      cartinfo:[],
      wishlistinfo:[],
      shops:[],
      listSizes:[]
    };
  },
   mounted(){
     //this.getOfferDetails();
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
    getOffers:function(event,done){
      console.log(this.shop_name); 
      if(this.showPreloader == false){
        this.showPreloader = true;
        axios({
          method:'GET',
          url:'/offers/'+this.shop_name
        }).then(response => {
          this.shopoffers = response.data.result;
          for(var i=0;i<this.shopoffers.length;i++)
              {
                console.log("b");
                axios({
                  method:'GET',
                  url : '/product/'+localStorage.getItem("city")+'/'+ this.shopoffers[i].name +'/' + this.shopoffers[i].id +'/buy/json',
                }).then(response => {
                  //console.log(response);
                  var a = response.data.result[0].size;
                  console.log(a);
                  var str = '';
                  for(var j=0;j<a.length;j++)
                  {
                    if(j<a.length-1)
                      str = str + a[j].size + ', ';
                    else
                      str = str + a[j].size;
                  }
                  //this.listSizes[i] = str;
                  this.listSizes.push(str);
                  console.log(str);
                  //console.log(a);
                }).catch(function(error){
                  //alert('hi');
                  /*if(error.response.data.message != undefined)
                    alert(error.response.data.message);
                  else
                    alert('application error found,please restart your app');*/
                  this.preloader = false;
                  done();
                });
              }
          for(var i=0; i<this.shopoffers.length; i++)
          {
            axios({
              method:'GET',
              url:'/getShopName/'+this.shopoffers[i].shop_id
            }).then(response => {
              var data = null;
              data = response.data.result;
              var b =  data[0].name;
              //console.log(b);
              this.shops[i] = b;
              //console.log(this.shops[i]);
            }, (error) =>{
              alert('hi1');
              if(error.response.data.message != undefined)
                console.log(error);
              else
                alert('application error found,please restart your app');
            });
          }
          this.showPreloader = false;
          console.log(this.shopoffers);          
          done();
        }, (error) =>{
          alert('hi2');
          if(error.response.data.message != undefined)
            console.log(error);
          else
            alert('application error found,please restart your app');
        });
      }
    },
    getOfferDetails:function(event,done){
      console.log('preloader : ' + this.showPreloader);
      if(this.showPreloader == false) {
        this.showPreloader = true;
        axios({
          method: 'GET',
          url: '/offers',
        }).then(response => {
          console.log('Hi');
          this.showPreloader = false;
          this.productinfo = response.data.result;
          this.name = this.productinfo.name;
          this.image = this.productinfo.image;
          this.contact = this.productinfo.contact;
          this.alt_contact = this.productinfo.alternate_contact;
          this.op_time = this.productinfo.opening_time;
          this.cl_time = this.productinfo.closing_time;
          this.address = this.productinfo.address;
          this.close_days = this.productinfo.close_days;
          console.log("a");
          done();
        
        }, (error) =>
        {
          if(error.response.data.message != undefined)
          {
            alert(error.response.data.message);
            console.log(error.response.data.message);
          }
          else
            alert('application error found,please restart your app');
        });
      }
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
