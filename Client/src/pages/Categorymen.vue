<template>
  <f7-page  name="categorymen">
    <f7-navbar back-link="Back" class="bgnav" style="border-radius:0px 0px 30px 0px;box-shadow: 5px 0px 10px rgba(0, 0, 0, 0.12)" sliding>
      <f7-nav-title style="font-size:18px;font-weight:bold;margin:0px">
        Mens Clothing
      </f7-nav-title>
      <f7-nav-right>
        <!--<f7-link style="padding:0 10px" icon-f7="icon-search_strong" href="/search/"></f7-link>-->
        <f7-link style="padding:0 10px" href="/wishlist/" v-if="wishlistinfo.length>0"><img src="../assets/thumbs-up_white.svg" alt="">
          <span class="badge" v-if="cartinfo.length>0" style="border-radius: 16px;height: 20px;width: 20px;margin-top:-18px;margin-left:-1.5vw;background-color:#5ddcf9;color:#000000"><p style="margin-top: -19px;margin-left: -0.5vw;font-size:14px;font-weight:bold">{{wishlistinfo.length}}</p></span>
        </f7-link>
        <f7-link style="padding:0 10px" href="/wishlist/" v-else><img src="../assets/thumbs-up_white.svg" alt=""></f7-link>
        <f7-link style="padding:0 10px" href="/hdcart/" v-if="cartinfo.length>0"><img src="../assets/delivery-motorbike.svg" alt="">
          <span class="badge" v-if="cartinfo.length>0" style="border-radius: 16px;height: 20px;width: 20px;margin-top:-18px;margin-left:-1.5vw;background-color:#5ddcf9;color:#000000"><p style="margin-top: -19px;margin-left: -0.5vw;font-size:14px;font-weight:bold">{{cartinfo.length}}</p></span>
        </f7-link>
        <f7-link style="padding:0 10px" href="/hdcart/" v-else><img src="../assets/delivery-motorbike.svg" alt=""></f7-link>
      </f7-nav-right>
    </f7-navbar>
    <offline @detected-condition="handleConnectivityChange">
  </offline>
    <!-- Scrollable page content-->
    <f7-block style="margin:0px">
      <f7-row style="margin:15px 0px 15px 0px">
        <f7-col>
         <f7-link @click="saveproduct('T-Shirts')" href="/products/">
           <f7-card style="height:16vh;margin:0px;border-radius:5px">
             <img src="../assets/m_tshirt.png" style="width:100%;height:100%;border-radius:5px" alt="">
           </f7-card>
         </f7-link>
        </f7-col>
        <f7-col>
         <f7-link @click="saveproduct('Casual Shirts')" href="/products/">
           <f7-card style="height:16vh;margin:0px;border-radius:5px">
             <img src="../assets/m_shirt.png" style="width:100%;height:100%;border-radius:5px" alt="">
           </f7-card>
         </f7-link>
        </f7-col>
        <f7-col>
         <f7-link @click="saveproduct('Sweatshirts')" href="/products/">
           <f7-card style="height:16vh;margin:0px;border-radius:5px">
             <img src="../assets/m_sweatshirt.png" style="width:100%;height:100%;border-radius:5px" alt="">
           </f7-card>
         </f7-link>
        </f7-col>
      </f7-row>
      <f7-row style="margin:15px 0px 15px 0px">
        <f7-col>
         <f7-link @click="saveproduct('Jeans')" href="/products/">
           <f7-card style="height:16vh;margin:0px;border-radius:5px">
             <img src="../assets/m_jean.png" style="width:100%;height:100%;border-radius:5px" alt="">
           </f7-card>
         </f7-link>
        </f7-col>
        <f7-col>
         <f7-link @click="saveproduct('Trousers')" href="/products/">
           <f7-card style="height:16vh;margin:0px;border-radius:5px">
             <img src="../assets/m_trouser.png" style="width:100%;height:100%;border-radius:5px" alt="">
           </f7-card>
         </f7-link>
        </f7-col>
        <f7-col>
         <f7-link @click="saveproduct('Shorts and 3 by 4ths')" href="/products/">
           <f7-card style="height:16vh;margin:0px;border-radius:5px">
             <img src="../assets/m_short.png" style="width:100%;height:100%;border-radius:5px" alt="">
           </f7-card>
         </f7-link>
        </f7-col>
      </f7-row>
      <f7-row style="margin:15px 0px 15px 0px">
        <f7-col>
         <f7-link @click="saveproduct('Track pants')" href="/products/">
           <f7-card style="height:16vh;margin:0px;border-radius:5px">
             <img src="../assets/m_trackpant.png" style="width:100%;height:100%;border-radius:5px" alt="">
           </f7-card>
         </f7-link>
        </f7-col>
        <f7-col>
         <f7-link @click="saveproduct('Briefs and Trunks')" href="/products/">
           <f7-card style="height:16vh;margin:0px;border-radius:5px">
             <img src="../assets/m_brief.png" style="width:100%;height:100%;border-radius:5px" alt="">
           </f7-card>
         </f7-link>
        </f7-col>
        <f7-col>
         <f7-link @click="saveproduct('Vests')" href="/products/">
           <f7-card style="height:16vh;margin:0px;border-radius:5px">
             <img src="../assets/m_vest.png" style="width:100%;height:100%;border-radius:5px" alt="">
           </f7-card>
         </f7-link>
        </f7-col>
      </f7-row>
    </f7-block>
    <!--<f7-block style="margin:0px">
      <f7-list accordion style="margin:0px">
        <template v-for="product in c">
          <f7-list-item :title="product" @click="saveproduct(product)" style="font-size:16px;font-weight:bold;color:gray" link="/products/" link-view="#main-view" panel-close/>
        </template>
      </f7-list>
    </f7-list>
    </f7-block>-->
    <f7-block style="background-color:white;padding:0px;margin:28px 0px 10px 10px;border:1px solid gray;border-right:0px;border-radius:30px 0px 0px 30px">
      <div style="padding:22px 16px 22px 20px">
            <div style="display:inline-block;height:30px">
              <img src="../assets/offer_icon.png" style="width:30px;height:30px;border-radius:50%;vertical-align: middle;" alt="Shops">
            </div>
            <div style="font-weight:bold;color:#000000;font-size:18px;display:inline-block;vertical-align: middle;" class="mpzero">&nbsp Super discounted products</div>
        </div>
        <center v-if="showPreloader">
          <div class="preloader" style="margin:20px 0px 0px">
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
        <div style="overflow-x:scroll;overflow-y:hidden;white-space:nowrap;padding:0px 0px 18px 13px;margin-left:2px">
      <template v-for="(result,index) in products">
        <f7-link :key="index" :href="'/productdetails/' + result.id + '/' + result.name" style="width:162px;height:46vh;margin:0px 3px" @click="saveid(result.id)">
          <f7-card style="width:100%;height:100%;margin:0px;padding:0px;-webkit-box-shadow: none;box-shadow: none">
            <div class="image_viewer" style="width: 100%;height:34vh;">
              <img :src="result.image[0]" style="width:100%;height:100%;margin:0px;object-fit: contain">
            </div>
            <div style="position:absolute;top:10px;left:10px;z-index:99;background-color:#5ddcf9;border-radius:50%;color:#000000;width:46px;height:46px;opacity:0.9;text-align:center">
                <p style="font-size:20px;font-weight:bold;margin:6px 0px 0px;padding:0px;line-height:20px">{{discount[index]}}</p>
                <p style="font-size:10px;font-weight:bold;margin:0px;padding:0px;line-height:12px">% OFF</p>
            </div>
            <f7-block style="color:gray;font-size:14px;font-weight:bold;padding:8px">
              <p class="mpzero lineclampin">
              <span v-show="result.specialDiscount == true" style="color:#000000;font-size:17px">&#8377;{{result.specialDiscountedPrice}}</span>
              <span v-show="result.specialDiscount == false" style="color:#000000;font-size:17px">&#8377;{{result.selling_price}} </span>
              <span v-show="result.specialDiscount == true" style="color:#000000;font-size:17px;text-decoration:line-through;">&#8377;{{result.selling_price}} </span>
              <span style="text-decoration:line-through;margin-left:3px">&#8377;{{result.mrp_price}}</span></p>
              <p class="mpzero lineclampin" style="margin-top:8px">
              <img src="../assets/shop_icon.png" style="width:24px;height:24px;border-radius:50%;vertical-align: middle;" alt="Shops">&nbsp {{result.shop_name}}</p>
            </f7-block>
          </f7-card>
        </f7-link>
      </template>
      </div>
    </f7-block>
  </f7-page>
</template>

<script>
import axios from '../axios';
import offline from 'v-offline';
export default {
  name: 'Categorymen',
  data() {
    return {
      title: 'Services Page',
      category:'',
      c:['Socks','Handkerchiefs'],
      cartinfo:[],
      wishlistinfo:[],
      internet:null,
      status:'not shown',
      products:[],
      discount:[],
      showPreloader:true,
    };
  },
components: {
    offline
  },
  beforeCreate(){
         this.getCart();
     this.getWishlist();
  },
   mounted(){
     this.getCart();
     this.getWishlist();
     this.getSuperDiscountedProducts();
     this.showPreloader = true;
  },
  methods:{
    /*savecategory:function(category){
      localStorage.setItem("category",category);
    },*/
    getSuperDiscountedProducts()
    {
      axios({
        method:'GET',
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
          if(this.products[i].specialDiscount == true)
          {
            this.discount[i] = this.products[i].specialDiscountedPercentage;
          }
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
    saveproduct:function(product){
      if(product == "Jeans" || product == "Cargos" || product == "Trousers" || product == "Shorts and 3 by 4ths" || product=="Track pants")
        this.category = "BOTTOM WEAR";
      if(product == "T-Shirts" || product == "Casual Shirts" || product == "Sweatshirts")
        this.category = "TOP WEAR";
      if(product == "Briefs and Trunks" || product == "Vests" || product == "Boxers")
        this.category = "INNERWEAR AND SLEEPWEAR";
      if(product == "Socks" || product == "Handkerchiefs")
        this.category = "ACCESSORIES";
        localStorage.setItem("category",this.category);
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
