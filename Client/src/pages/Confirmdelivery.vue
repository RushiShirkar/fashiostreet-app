<template>
  <f7-page style="padding-bottom:70px" name="confirmdelivery"
           
  >
    <div v-if="toast_msg != null" class="custom_toast z-depth-3">
      {{ toast_msg }}
    </div>
    <div style="margin-top:110px" v-if="page == 'success'">
      <center>
      <div class="check_mark">
        <div class="sa-icon sa-success animate">
          <span class="sa-line sa-tip animateSuccessTip"></span>
          <span class="sa-line sa-long animateSuccessLong"></span>
          <div class="sa-placeholder"></div>
          <div class="sa-fix"></div>
        </div>
      </div>
        <p style="color:green;font-size:22px;font-weight:700">&#8377;{{cashback}}</p>
      <h3 style="color:black">Cashback Added to Wallet</h3>
      <h3 style="color:black">Order Successfully placed</h3>
      <f7-button href="/wallet" fill style="background-image: linear-gradient(to right, #4568DC, #B06AB3);line-height:50px;height:50px;font-size:14px;font-weight:750;border-radius:30px;margin:0px 15px">View Wallet <f7-icon f7="chevron_right" style="margin:-5px 0px 0px 10px"></f7-icon></f7-button>
      <f7-button href="/hdorders/" fill style="background-image: linear-gradient(to right, #ff416c, #ff4b2b);line-height:50px;height:50px;font-size:14px;font-weight:750;border-radius:30px;margin:20px 15px 0px 15px">View Order <f7-icon f7="chevron_right" style="margin:-5px 0px 0px 10px"></f7-icon></f7-button>
      <f7-button href="/home" fill style="background-image: linear-gradient(to right, #11998e, #38ef7d);height:50px;line-height:50px;font-size:14px;font-weight:750;border-radius:30px;margin:20px 15px 0px 15px">Continue Shopping <f7-icon f7="chevron_right" style="margin:-5px 0px 0px 10px"></f7-icon></f7-button>
      </center>
    </div>
    <div v-if="page == 'main'">
    <f7-navbar back-link="back" class="bgnav" style="border-radius:0px 0px 30px 0px;box-shadow: 5px 0px 10px rgba(0, 0, 0, 0.12)" sliding>
      <f7-nav-title style="font-size:18px;font-weight:bold;margin:0px">
        Confirm Delivery
      </f7-nav-title>
    </f7-navbar>
    <offline @detected-condition="handleConnectivityChange"></offline>
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
      <f7-block-title  style="margin-top:16px;color:#000000"><h5 class="mpzero" style=";font-size:18px;font-weight:bold"><img src="../assets/item_icon.png" style="width:30px;height:30px;border-radius:50%;vertical-align: middle;" alt="Shops">&nbsp Items (<span v-if="order.length != 0">{{ order.product.length }}</span>)</h5></f7-block-title>
    <f7-block v-if="order.product.length != 0" style="padding:0px;margin:0px 10px 0px 10px">
      <div v-if="order.product.length == 0">
          <center><h3>No Product found</h3></center>
      </div>
      <template v-for="product in order.product">
      <f7-card style="margin-bottom:10px;font-weight:bold;color:gray;-webkit-box-shadow:none;box-shadow:none;border-radius:10px;border:1px solid gray">
          <f7-card-content style="padding:10px 0px">
              <f7-block style="margin:0px">
                <f7-row no-gap>
                  <f7-col width="25"><img :src="product.image[0]" style="width:80%;height:90px"></f7-col>
                  <f7-col width="75"><p class="mpzero">{{ product.name }}</p>
                  <p class="mpzero">
                    <span v-show="product.specialDiscount == true" style="color:#000000;font-size:17px">&#8377;{{product.specialDiscountedPrice}}</span>
                    <span v-show="product.specialDiscount == false" style="color:#000000;font-size:17px">&#8377;{{product.selling_price}}</span>
                    <span v-show="product.specialDiscount == true" style="color:#000000;font-size:17px;text-decoration:line-through;margin-left:0px">&#8377;{{product.selling_price}}</span>
                    <span style="color:gray;text-decoration:line-through;margin-left:3px">&#8377;{{ product.mrp_price }}</span>
                  </p>
                  <p class="mpzero"><span>Size : {{ product.size }}</span> &nbsp|&nbsp <span>Qty : {{ product.qty }}</span></p>
                  <p class="mpzero">Store : {{ product.shop_name }}</p>
                  </f7-col>
                </f7-row>
               </f7-block>
          </f7-card-content>
      </f7-card>
      </template>
      <f7-card style="padding:0px;margin:0px;-webkit-box-shadow:none;box-shadow:none;border-radius:10px;border:1px solid gray">
      <div style="padding:15px 10px;color:gray;font-size:15px;font-weight:bold">
        <f7-row>
          <f7-col>
          <p class="mpzero" style="padding-bottom:8px;color:#000000">Total MRP</p>
          <p class="mpzero" style="padding-bottom:8px">Shop Discount</p>
          <p class="mpzero" style="padding-bottom:8px">Delivery Charges</p>
          <p v-show="promocodeCheck=='true'" class="mpzero" style="padding-bottom:8px">Promocode Discount</p>
          </f7-col>
          <f7-col style="text-align:right">
          <p class="mpzero" style="padding-bottom:8px;color:#000000">&#8377;{{total_mrp}}</p>
          <p class="mpzero" style="padding-bottom:8px;color:#FD6A02">- &#8377;{{total_discount}}</p>
          <p class="mpzero" style="padding-bottom:8px;color:#4caf50">FREE</p>
          <p v-show="promocodeCheck=='true'" class="mpzero" style="padding-bottom:8px;color:#FD6A02">- &#8377;{{per}}</p>
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
      </f7-block>
      <f7-block style="padding-top:0px;margin:16px 0px">
       <f7-card style="padding:0px;margin:0px;-webkit-box-shadow:none;box-shadow:none;border-radius:10px;border:1px solid gray;color:gray;font-size:15px;font-weight:bold">
        <f7-list style="margin:0px">
          <f7-list-item checkbox value="check_1" style="color:#4caf50;font-size:16px;font-weight:bold" :after="'₹'+money" title="Use FS Wallet" @change="checkWallet"></f7-list-item>
        </f7-list>
        <f7-block v-show="use==true" style="padding:0px;margin:0px">
      <div style="padding:15px 10px;color:gray">
        <f7-row>
          <f7-col>
          <p class="mpzero" style="padding-bottom:8px">Total Selling</p>
          <p class="mpzero" style="padding-bottom:8px">Wallet Money</p>
          </f7-col>
          <f7-col style="text-align:right">
          <p class="mpzero" style="padding-bottom:8px">&#8377;{{total_selling}}</p>
          <p class="mpzero" style="padding-bottom:8px;color:#FD6A02">- &#8377;{{money}}</p>
          </f7-col>
        </f7-row>
        <hr>
        <f7-row style="color:#000000;font-size:18px;font-weight:bold">
         <f7-col>
         <p class="mpzero" style="padding-top:8px">Total</p>
         </f7-col>  
         <f7-col style="text-align:right">
         <p class="mpzero" style="padding-top:8px">&#8377;{{total}}</p>
         </f7-col>
        </f7-row>
        </div>
        </f7-block>
        </f7-card>
        </f7-block>
        <f7-card v-show="try_buyApplied=='true'" style="padding:0px;margin:0px 10px 10px 10px;-webkit-box-shadow:none;box-shadow:none;border-radius:10px;border:1px solid gray">
          <f7-card-content style="padding:15px 10px;color:#4CAF50;font-size:15px;font-weight:bold">
            <f7-icon f7="info"></f7-icon> &nbsp TRY & BUY applied for this order.
          </f7-card-content>
        </f7-card>
        <f7-card style="padding:0px;margin:0px 10px 10px 10px;border-radius:10px;background-image: linear-gradient(to right, #F2994A, #F2C94C)">
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
    <f7-block-title  style="margin-top:16px;color:#000000"><h5 class="mpzero" style="font-size:18px;font-weight:bold"><img src="../assets/address_icon.png" style="width:30px;height:30px;border-radius:50%;vertical-align: middle;" alt="Shops">&nbsp Delivery Address</h5></f7-block-title>
      <f7-block style="padding:0px;margin:0px 10px 0px 10px">
      <f7-card v-for="address in order.address" :key="address.id" style="-webkit-box-shadow:none;box-shadow:none;border-radius:10px;border:1px solid gray">
                  <f7-card-content style="margin:0px;padding:10px 10px;color:gray">
                      <h4 class="mpzero" style="color:#000000;font-size:16px">{{ address.first_name }} {{ address.last_name }}</h4>
                  <h5 class="mpzero" style="font-size:14px">{{ address.address }}</h5>
                  <h5 class="mpzero" style="font-size:14px">{{ address.area }}</h5>
                  <h5 class="mpzero" style="font-size:14px">Mobile : {{ address.mobile }}</h5>
                  </f7-card-content>
              </f7-card>
      </f7-block>
      <f7-block-title  style="margin-top:16px;color:#000000"><h5 class="mpzero" style="font-size:18px;font-weight:bold"><img src="../assets/time_icon.png" style="width:30px;height:30px;border-radius:50%;vertical-align: middle;" alt="Shops">&nbsp Estimated Delivery</h5></f7-block-title>
      <f7-block style="padding:0px;margin:0px 10px 15px 10px">
      <f7-card style="-webkit-box-shadow:none;box-shadow:none;border-radius:10px;border:1px solid gray">
                  <f7-card-content style="margin:0px;padding:10px 10px">
                      <h5 style="color:#4CAF50;font-size:15px;margin:8px 0px">
                        Upto 10Km : Within 4-6 hours
                      </h5>
                      <h5 style="color:#4CAF50;font-size:15px;margin:8px 0px">
                        Above 10Km : Within 1-4 days
                      </h5>
                  </f7-card-content>
              </f7-card>
      </f7-block>
      <div style="position:fixed;bottom:0;z-index:999;width:100%;background-color:#FFFFFF;box-shadow: 5px 0px 10px rgba(0, 0, 0, 0.12);border-radius:30px 30px 0px 0px">
        <f7-button :disabled="disabled" big fill @click="placedOrder" style="background-image: linear-gradient(to right, #11998e, #38ef7d);color:#FFFFFF;font-size:18px;font-weight:bold;border:0px;text-transform:Capitalize;margin:10px;border-radius:30px"><img src="../assets/scooter.svg" alt="" style="height:30px;vertical-align: middle;">&nbsp Place Delivery <f7-icon f7="chevron_right" style="margin:-5px 0px 0px 10px"></f7-icon></f7-button>
      </div>
    </div></div>
    </div> </f7-page>
</template>

<script>
  import axios from '../axios'
  import offline from 'v-offline';
  import F7Button from "framework7-vue/src/components/button";
export default {
  name: 'Confirmdelivery',
  components: {F7Button},
  data() {
    return {
      toast_msg:null,
      preloader:false,
      disabled:true,
      customer_name:null,
      address:null,
      contact:null,
      internet:null,
      status:'not shown',
      mrp:[],
      amount:[],
      money:null,
      selling:[],
      discount:[],
      total:null,
      price:null,
      total_mrp:null,
      total_selling:null,
      total_discount:null,
      money:null,
      active:null,
      cashback:null,
      use:false,
      per:null,
      shopMoneyReceiving:null,
      shopMoneyPaying:null,
      id : [],
      promocodeCheck:localStorage.getItem('promocodeCheck'),
      try_buyApplied:localStorage.getItem('try_buy'),
      try_buy:null,
      promocode:null,
      order:{
        product:[],
        address:[]
      },
      page:'main'
    };
  },
  props:['address_id'],
    components: {
    offline
  },
  mounted(){
    console.log('current timestamp : ' + new Date());
    this.getWalletMoney();
    this.getCart();
    FB.init({
      appId: "2141628305957160",
      version: 'v3.1'
    });
  },
  methods:{
    checkWallet(event)
    {
      if(event.target.checked)
      {
        this.use = true;
        this.price = this.total_selling;
        if(this.total_selling>this.money)
          this.total = this.total_selling - this.money;
        else
          this.total = 0;   
      }
      else
      {
        this.use = false;
        this.total = this.total_selling + this.money;
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
    save(){
     //alert('hi');
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
    deliveryTime:function(){
      var d = new Date();
      var hr = parseInt(d.getHours());
      var new_time = null;
      if(hr >= 19 && hr <= 20)
      {
        new_time = 'Tomorrow 11:00 AM';
      }
      else if(hr > 20 && hr <= 23 ){
        new_time = 'Tomorrow 3:00 PM';
      }
      else if(hr >= 0 && hr <= 9){
        new_time = 'Today 3:00 PM';
      }
      else
      {
        hr = hr + 5;
        if(hr > 12)
        {
          hr = hr - 12;
        }
        new_time = 'Today ' + hr + ':00 PM';
      }
      return new_time;
    },
    placedOrder:function(){
      var t = 0;
      var p = 0;
      var z = 0;
      this.preloader = true;
      if(this.promocodeCheck=="true")
      {
        this.promocode = "SUPER30";
      }
      else
      {
        this.promocode = null;
      }
      if(localStorage.getItem('try_buy')=="true")
      {
        this.try_buy = "YES";
      }
      else
      {
        this.try_buy = "NO";
      }
      if(this.customer_name != null && this.address != null && this.contact != null) {
        axios({
          method: 'POST',
          url: '/user/placeOrder',
          data: {
            'customer_name': this.customer_name,
            'address': this.address,
            'contact': this.contact,
            'promocode':this.promocode,
            'try_buy':this.try_buy
          }
        }).then(response => {
          this.page = 'success';
          console.log(response.statusText);
          if(response.statusText == "OK")
          {
            console.log(this.id);
            for(var i=0;i<this.order.product.length;i++)
            {
              axios({
                method: 'POST',
                url: '/order',
                data: {
                  'id' : this.id[i]
                }
              }).then(response => {
                console.log(response);
              }, (error) => {
                if (error.response.data.message != undefined) {
                  this.mobileerror = error.response.data.message;
                }
                else {
                  alert('connection error found,please retry again');
                }
              });
            }
          }
          if(this.use==true){
            if(this.total_selling>this.money)
            {
              p = this.money;
              t = this.money - t;
            }
            else
            {
              p = this.total_selling;
              t = this.money - this.total_selling;
            }
          }
          else
          {
            t = 0;
            p = 0;
          }/*
          axios({
                method: 'GET',
                url: '/saveDiscount',
                data: {
                  'money': p
                }
              }).then(response => {
                console.log(response);
              }, (error) => {
                if (error.response.data.message != undefined) {
                  this.mobileerror = error.response.data.message;
                }
                else {
                  alert('connection error found,please retry again');
                }
          });*/
          console.log(this.amount);
          if(this.use==true)
          {
            if(this.money>this.amount){
              z = (this.amount*5)/100;
              z = t+z;
            }
            else
              z = (this.total*5)/100;
          }
          else
          {
            z = ((this.amount*5)/100)+this.money;
          }
          this.cashback = z;
          console.log(t);
          //z = z+p;
          console.log(z);
          axios({
            method: 'POST',
            url: '/updateCustomerWallet',
            data: {
              'mobile':localStorage.getItem('loginmobile'),
              'money': z
            }
          }).then(response => {
            console.log(response);
          }, (error) => {
            if (error.response.data.message != undefined) {
              this.mobileerror = error.response.data.message;
            }
            else {
              alert('connection error found,please retry again');
            }
          });
          for(var i=0;i<this.order.product.length;i++)
          {
            var l = this.order.product.length;
            var mr = 0;
            var mp = 0;
            axios({
            method:'GET',
              url : '/getShopWalletMoney/'+this.order.product[i].id
            }).then(response => {
                console.log(response.data.result)
                mr = response.data.result[0].money_receiving;
                mp = response.data.result[0].money_paying;
                console.log(mr);
                console.log(mp);
                //this.money = response.data.result[0].money;  
            }).catch(function(error){
              if (error.response.data.message != undefined)
                console.log(error.response.data.message);
              else
                alert('system error found,please try again');
            });
            var paying = (this.order.product[i].selling_price*10)/100;
            mp = mp + paying;
            if(this.use == true)
              mr = mr + Math.floor(p/l);
            else 
              mr = mr;
            console.log(mp);
            console.log(mr);
            axios({
              method: 'POST',
              url: '/updateShopWalletMoney',
              data: {
                'product_id': this.order.product[i].id,
                'money_paying': mp,
                'money_receiving': mr
              }
            }).then(response => {
              console.log(response);
            }, (error) => {
              if (error.response.data.message != undefined) {
                this.mobileerror = error.response.data.message;
              }
              else {
                alert('connection error found,please retry again');
              }
            });
            console.log(p);
            axios({
              method: 'GET',
              url: '/saveDiscount/'+p
            }).then(response => {
              console.log(response);
            }, (error) => {
              if (error.response.data.message != undefined) {
                this.mobileerror = error.response.data.message;
              }
              else {
                alert('connection error found,please retry again');
              }
            });
          }
          return true;
        }).catch(error => {
          console.log('at catch ');
          if (error.response.data.message != undefined)
          {
            this.mobileerror=error.response.data.message;
          }
          else
            alert('application error found,please restart your app');
          this.preloader = false;
        });
        return true;
      }
      //alert('invalid data found,please restart your app');
    },
    getCart:function(){
      this.page='main';
      this.disabled = true;
      this.preloader = true;
      axios({
        method:'GET',
        url : '/user/confirm_address/json',
        params:{
          'a_id' : this.address_id
        }
      }).then(response => {
        this.order = response.data.result;
        console.log(this.order);
        for(var i=0;i<this.order.product.length;i++)
        {
          this.id[i] = this.order.product[i].id;
        }
        this.customer_name = this.order.address[0].first_name + ' ' + this.order.address[0].last_name;
        this.address = this.order.address[0].address + ' ' + this.order.address[0].area;
        this.contact = this.order.address[0].mobile;
        for(var i = 0; i < this.order.product.length; i++)
        {
          this.mrp[i] = Math.floor(this.order.product[i].mrp_price);
        }
        this.total_mrp = 0;
        for (var i = 0; i < this.order.product.length; i++) {
          this.total_mrp = this.total_mrp+this.mrp[i];
        }
        console.log(this.total_mrp);
        for(var i = 0; i < this.order.product.length; i++)
        {
          this.selling[i] = Math.floor(this.order.product[i].selling_price);
          if(this.order.product[i].specialDiscount == true)
          {
            this.selling[i] = this.order.product[i].specialDiscountedPrice;
          }
        }
        this.total_selling = 0;
        for (var i = 0; i < this.order.product.length; i++) {
          this.total_selling = this.total_selling+this.selling[i];
        }
        console.log(this.total_selling);
        this.amount = this.total_selling;
        this.total_discount = this.total_mrp - this.total_selling;
        if(localStorage.getItem('promocodeCheck')=="true")
        {
          this.per = Math.floor((30/100)*this.total_selling);
          if(this.per>50)
          {
            this.total_selling = Math.floor(this.total_selling - 50);
            this.per = 50;
          }
          else
          {
            this.total_selling = Math.floor(this.total_selling - this.per);
          }
          console.log(this.total_selling);
        }
        console.log(this.total_discount);
        if(this.order.product.length > 0)
          this.disabled = false;
        this.preloader = false;
      }).catch(error => {
        if(error.response.data.message != undefined)
          alert(error.response.data.message);
        else
          alert('application error found,please restart your app');
        this.preloader = false;
      });
    }
  }
};
</script>
<style>
.md .navbar:after{
  content:none
  }
.md .list .item-after{
  font-size:16px !important;
}
  .sa-icon {
    width: 80px;
    height: 80px;
    border: 4px solid gray;
    -webkit-border-radius: 40px;
    border-radius: 40px;
    border-radius: 50%;
    margin: 20px auto;
    padding: 0;
    position: relative;
    box-sizing: content-box;
  }

  .sa-icon.sa-success {
    border-color: #4CAF50;
  }

  .sa-icon.sa-success::before, .sa-icon.sa-success::after {
    content: '';
    -webkit-border-radius: 40px;
    border-radius: 40px;
    border-radius: 50%;
    position: absolute;
    width: 74px;
    height: 120px;
    background: white;
    -webkit-transform: rotate(45deg);
    transform: rotate(45deg);
  }

  .sa-icon.sa-success::before {
    -webkit-border-radius: 120px 0 0 120px;
    border-radius: 120px 0 0 120px;
    top: -19px;
    left: -22px;
    -webkit-transform: rotate(-45deg);
    transform: rotate(-45deg);
    -webkit-transform-origin: 60px 60px;
    transform-origin: 60px 60px;
  }

  .sa-icon.sa-success::after {
    -webkit-border-radius: 0 120px 120px 0;
    border-radius: 0 120px 120px 0;
    top: -11px;
    left: 30px;
    -webkit-transform: rotate(-45deg);
    transform: rotate(-45deg);
    -webkit-transform-origin: 0px 60px;
    transform-origin: 0px 60px;
  }

  .sa-icon.sa-success .sa-placeholder {
    width: 80px;
    height: 80px;
    border: 4px solid rgba(76, 175, 80, .5);
    -webkit-border-radius: 40px;
    border-radius: 40px;
    border-radius: 50%;
    box-sizing: content-box;
    position: absolute;
    left: -4px;
    top: -4px;
    z-index: 2;
  }

  .sa-icon.sa-success .sa-fix {
    width: 5px;
    height: 90px;
    background-color: white;
    position: absolute;
    left: 28px;
    top: 8px;
    z-index: 1;
    -webkit-transform: rotate(-45deg);
    transform: rotate(-45deg);
  }

  .sa-icon.sa-success.animate::after {
    -webkit-animation: rotatePlaceholder 4.25s ease-in;
    animation: rotatePlaceholder 4.25s ease-in;
  }

  .sa-icon.sa-success {
    border-color: transparent\9;
  }
  .sa-icon.sa-success .sa-line.sa-tip {
    -ms-transform: rotate(45deg) \9;
  }
  .sa-icon.sa-success .sa-line.sa-long {
    -ms-transform: rotate(-45deg) \9;
  }

  .animateSuccessTip {
    -webkit-animation: animateSuccessTip 0.75s;
    animation: animateSuccessTip 0.75s;
  }

  .animateSuccessLong {
    -webkit-animation: animateSuccessLong 0.75s;
    animation: animateSuccessLong 0.75s;
  }

  @-webkit-keyframes animateSuccessLong {
    0% {
      width: 0;
      right: 46px;
      top: 54px;
    }
    65% {
      width: 0;
      right: 46px;
      top: 54px;
    }
    84% {
      width: 55px;
      right: 0px;
      top: 35px;
    }
    100% {
      width: 47px;
      right: 8px;
      top: 38px;
    }
  }
  @-webkit-keyframes animateSuccessTip {
    0% {
      width: 0;
      left: 1px;
      top: 19px;
    }
    54% {
      width: 0;
      left: 1px;
      top: 19px;
    }
    70% {
      width: 50px;
      left: -8px;
      top: 37px;
    }
    84% {
      width: 17px;
      left: 21px;
      top: 48px;
    }
    100% {
      width: 25px;
      left: 14px;
      top: 45px;
    }
  }
  @keyframes animateSuccessTip {
    0% {
      width: 0;
      left: 1px;
      top: 19px;
    }
    54% {
      width: 0;
      left: 1px;
      top: 19px;
    }
    70% {
      width: 50px;
      left: -8px;
      top: 37px;
    }
    84% {
      width: 17px;
      left: 21px;
      top: 48px;
    }
    100% {
      width: 25px;
      left: 14px;
      top: 45px;
    }
  }

  @keyframes animateSuccessLong {
    0% {
      width: 0;
      right: 46px;
      top: 54px;
    }
    65% {
      width: 0;
      right: 46px;
      top: 54px;
    }
    84% {
      width: 55px;
      right: 0px;
      top: 35px;
    }
    100% {
      width: 47px;
      right: 8px;
      top: 38px;
    }
  }

  .sa-icon.sa-success .sa-line {
    height: 5px;
    background-color: #4CAF50;
    display: block;
    border-radius: 2px;
    position: absolute;
    z-index: 2;
  }

  .sa-icon.sa-success .sa-line.sa-tip {
    width: 25px;
    left: 14px;
    top: 46px;
    -webkit-transform: rotate(45deg);
    transform: rotate(45deg);
  }

  .sa-icon.sa-success .sa-line.sa-long {
    width: 47px;
    right: 8px;
    top: 38px;
    -webkit-transform: rotate(-45deg);
    transform: rotate(-45deg);
  }

  @-webkit-keyframes rotatePlaceholder {
    0% {
      transform: rotate(-45deg);
      -webkit-transform: rotate(-45deg);
    }
    5% {
      transform: rotate(-45deg);
      -webkit-transform: rotate(-45deg);
    }
    12% {
      transform: rotate(-405deg);
      -webkit-transform: rotate(-405deg);
    } 
    100% {
      transform: rotate(-405deg);
      -webkit-transform: rotate(-405deg);
    }
  }
  @keyframes rotatePlaceholder {
    0% {
      transform: rotate(-45deg);
      -webkit-transform: rotate(-45deg);
    }
    5% {
      transform: rotate(-45deg);
      -webkit-transform: rotate(-45deg);
    }
    12% {
      transform: rotate(-405deg);
      -webkit-transform: rotate(-405deg);
    }
    100% {
      transform: rotate(-405deg);
      -webkit-transform: rotate(-405deg);
    }
  }
</style>
