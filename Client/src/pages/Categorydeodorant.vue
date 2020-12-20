<template>
  <f7-page name="categorymen">
    <f7-navbar back-link="Back" class="bgnav" style="border-radius:0px 0px 30px 0px;box-shadow: 5px 0px 10px rgba(0, 0, 0, 0.12)" sliding>
      <f7-nav-title style="font-size:18px;font-weight:bold;margin:0px">
        Deodorants
      </f7-nav-title>
      <!--<f7-nav-right>
        <f7-link style="padding:0 10px" href="/wishlist/" v-if="wishlistinfo.length>0"><img src="../assets/thumbs-up_white.svg" alt="">
          <span class="badge" v-if="cartinfo.length>0" style="border-radius: 16px;height: 20px;width: 20px;margin-top:-18px;margin-left:-1.5vw;background-color:#5ddcf9;color:#000000"><p style="margin-top: -19px;margin-left: -0.5vw;font-size:14px;font-weight:bold">{{wishlistinfo.length}}</p></span>
        </f7-link>
        <f7-link style="padding:0 10px" href="/wishlist/" v-else><img src="../assets/thumbs-up_white.svg" alt=""></f7-link>
        <f7-link style="padding:0 10px" href="/hdcart/" v-if="cartinfo.length>0"><img src="../assets/delivery-motorbike.svg" alt="">
          <span class="badge" v-if="cartinfo.length>0" style="border-radius: 16px;height: 20px;width: 20px;margin-top:-18px;margin-left:-1.5vw;background-color:#5ddcf9;color:#000000"><p style="margin-top: -19px;margin-left: -0.5vw;font-size:14px;font-weight:bold">{{cartinfo.length}}</p></span>
        </f7-link>
        <f7-link style="padding:0 10px" href="/hdcart/" v-else><img src="../assets/delivery-motorbike.svg" alt=""></f7-link>
      </f7-nav-right>-->
    </f7-navbar>
    <offline @detected-condition="handleConnectivityChange">
    </offline>
    <!-- Scrollable page content-->
    <f7-block style="margin:0px">
      <!--<f7-row style="margin:10px 0px 10px 0px">
        <f7-col>
         <f7-link @click="saveproduct('Briefs and Trunks')" href="/products/">
           <f7-card style="height:14vh;margin:0px;border-radius:5px">
             <img src="../assets/cat_page-subbanner1.png" style="width:100%;height:100%;border-radius:5px" alt="">
           </f7-card>
         </f7-link>
        </f7-col>
      </f7-row>-->
      <f7-row style="margin:15px 0px 15px 0px">
        <f7-col>
         <f7-link @click="saveproduct('Fogg')" href="/products/">
           <f7-card style="height:16vh;margin:0px;border-radius:5px">
             <img src="../assets/d_fogg.png" style="width:100%;height:100%;border-radius:5px" alt="Mens Casual Shoes">
           </f7-card>
         </f7-link>
        </f7-col>
        <f7-col>
         <f7-link @click="saveproduct('Axe')" href="/products/">
           <f7-card style="height:16vh;margin:0px;border-radius:5px">
             <img src="../assets/d_axe.png" style="width:100%;height:100%;border-radius:5px" alt="Mens Sandals">
           </f7-card>
         </f7-link>
        </f7-col>
        <f7-col>
         <f7-link @click="saveproduct('Wildstone')" href="/products/">
           <f7-card style="height:16vh;margin:0px;border-radius:5px">
             <img src="../assets/d_wildstone.png" style="width:100%;height:100%;border-radius:5px" alt="Sport Shoes">
           </f7-card>
         </f7-link>
        </f7-col>
      </f7-row>
      <f7-row style="margin:15px 0px 15px 0px">
        <f7-col>
         <f7-link @click="saveproduct('Park Avenue')" href="/products/">
           <f7-card style="height:16vh;margin:0px;border-radius:5px">
             <img src="../assets/d_parkavenue.png" style="width:100%;height:100%;border-radius:5px" alt="Mens Loafers">
           </f7-card>
         </f7-link>
        </f7-col>
        <f7-col>
         <f7-link @click="saveproduct('Nivea')" href="/products/">
           <f7-card style="height:16vh;margin:0px;border-radius:5px">
             <img src="../assets/d_nivea.png" style="width:100%;height:100%;border-radius:5px" alt="Mens Chapals">
           </f7-card>
         </f7-link>
        </f7-col>
        <f7-col>
         <f7-link @click="saveproduct('Denver')" href="/products/">
           <f7-card style="height:16vh;margin:0px;border-radius:5px">
             <img src="../assets/d_denver.png" style="width:100%;height:100%;border-radius:5px" alt="Mens Formal Shoes">
           </f7-card>
         </f7-link>
        </f7-col>
      </f7-row>
      <f7-row style="margin:15px 0px 15px 0px">
        <f7-col>
         <f7-link @click="saveproduct('Engage')" href="/products/">
           <f7-card style="height:16vh;margin:0px;border-radius:5px">
             <img src="../assets/d_engage.png" style="width:100%;height:100%;border-radius:5px" alt="Mens Casual Shoes">
           </f7-card>
         </f7-link>
        </f7-col>
        <f7-col>
         <f7-link @click="saveproduct('Kamasutra')" href="/products/">
           <f7-card style="height:16vh;margin:0px;border-radius:5px">
             <img src="../assets/d_kamasutra.png" style="width:100%;height:100%;border-radius:5px" alt="Mens Sandals">
           </f7-card>
         </f7-link>
        </f7-col>
        <f7-col>
         <f7-link @click="saveproduct('Rasasi')" href="/products/">
           <f7-card style="height:16vh;margin:0px;border-radius:5px">
             <img src="../assets/d_rasasi.png" style="width:100%;height:100%;border-radius:5px" alt="Sport Shoes">
           </f7-card>
         </f7-link>
        </f7-col>
      </f7-row>
      <f7-row style="margin:15px 0px 15px 0px">
        <f7-col>
         <f7-link @click="saveproduct('Envy')" href="/products/">
           <f7-card style="height:16vh;margin:0px;border-radius:5px">
             <img src="../assets/d_envy.png" style="width:100%;height:100%;border-radius:5px" alt="Mens Casual Shoes">
           </f7-card>
         </f7-link>
        </f7-col>
        <f7-col>
         <f7-link @click="saveproduct('He')" href="/products/">
           <f7-card style="height:16vh;margin:0px;border-radius:5px">
             <img src="../assets/d_he.png" style="width:100%;height:100%;border-radius:5px" alt="Mens Sandals">
           </f7-card>
         </f7-link>
        </f7-col>
        <f7-col>
         <f7-link @click="saveproduct('Jaguar')" href="/products/">
           <f7-card style="height:16vh;margin:0px;border-radius:5px">
             <img src="../assets/d_jaguar.png" style="width:100%;height:100%;border-radius:5px" alt="Sport Shoes">
           </f7-card>
         </f7-link>
        </f7-col>
      </f7-row>
      <f7-row style="margin:15px 0px 15px 0px">
        <f7-col>
         <f7-link @click="saveproduct('Nike')" href="/products/">
           <f7-card style="height:16vh;margin:0px;border-radius:5px">
             <img src="../assets/d_nike.png" style="width:100%;height:100%;border-radius:5px" alt="Mens Casual Shoes">
           </f7-card>
         </f7-link>
        </f7-col>
        <f7-col>
         <f7-link @click="saveproduct('Cfs')" href="/products/">
           <f7-card style="height:16vh;margin:0px;border-radius:5px">
             <img src="../assets/d_cfs.png" style="width:100%;height:100%;border-radius:5px" alt="Mens Sandals">
           </f7-card>
         </f7-link>
        </f7-col>
        <f7-col>
         <f7-link @click="saveproduct('19V69')" href="/products/">
           <f7-card style="height:16vh;margin:0px;border-radius:5px">
             <img src="../assets/d_19v69.png" style="width:100%;height:100%;border-radius:5px" alt="Sport Shoes">
           </f7-card>
         </f7-link>
        </f7-col>
      </f7-row>
    </f7-block>
  </f7-page>
</template>

<script>
import offline from 'v-offline';

import { f7Navbar, f7Page, f7Block, f7Button } from 'framework7-vue';
import axios from 'axios';
export default {
  name: 'Categoryfootwear',
  data() {
    return {
      category:[],
      title: 'Services Page',
      internet:null,
      cartinfo:[],
      wishlistinfo:[],
      status:'not shown',
      products:[],
      discount:[],
      showPreloader:true,
    };
  },
  components: {
    offline
  },
   mounted(){
    //this.getSuperDiscountedProducts();
    this.showPreloader = true;
  },
  methods:{
    getSuperDiscountedProducts()
    {
      axios({
        method:'POST',
        url : '/menSuperDiscountedProducts/'+localStorage.getItem('city')
      }).then(response => {
        this.showPreloader = false;
        this.products = response.data.result;
        for(var i = 0;i< this.products.length; i++)
        {
          this.products[i].mrp_price = parseInt(this.products[i].mrp_price);
        }
        for(var i = 0;i< this.products.length; i++)
        {
          this.products[i].selling_price = parseInt(this.products[i].selling_price);
        }
        for(var i = 0;i< this.products.length; i++)
        {
          this.discount[i] = parseInt(((this.products[i].mrp_price-this.products[i].selling_price)/this.products[i].mrp_price)*100);
        } 
        console.log(this.products); 
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
    /*getCart:function(event,done){
      axios({
        method:'GET',
        url : '/user/viewcart/json'
      }).then(response => {
        this.cartinfo = response.data.result;
        console.log(this.cartinfo);
        done();
      }).catch(error => {
        if(error.response.data.message != undefined)
          alert(error.response.data.message);
        else
          alert('Something went wrong,please try again');
      });
    },
    getWishlist:function(){
      this.preloader = true;
      axios({
        method:'GET',
        url : '/user/wishlist/json'
      }).then(response => {

          this.wishlistinfo=response.data.result;
          console.log(this.wishlistinfo);
      }).catch(error => {
        if(error.response.data.message != undefined)
          alert(error.response.data.message);
        else
          alert('Something went wrong,please try again');

      });
    },*/
    savecategory:function(category){
      localStorage.setItem("category",category);
    },
    saveproduct:function(product){
            localStorage.setItem("category","Men Deodorant");
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
