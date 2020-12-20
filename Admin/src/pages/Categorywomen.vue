<template>
  <f7-page class="bgpage" style="background-color:white" name="categorymen">
    <f7-navbar back-link="Back" class="bgnav" sliding>

      <f7-nav-title style="font-size:15px;margin:0px">
        WOMENS CLOTHING
      </f7-nav-title>
      <f7-nav-right>
        <f7-link style="padding:0 10px" icon-f7="icon-heart_fill" href="/wishlist/" v-if="wishlistinfo.length>0"><span class="badge color-red" style="border-radius: 16px;height: 15px;width: 15px;margin-top: -5vw;margin-left:-5px;"><p style="margin-top: -5.5vw;margin-left: -0.5vw;">{{wishlistinfo.length}}</p></span></f7-link>
        <f7-link style="padding:0 10px" icon-f7="icon-heart_fill" href="/wishlist/" v-else></f7-link>
        <f7-link style="padding:0 10px" href="/hdcart/" v-if="cartinfo.length>0"><img src="../assets/delivery-motorbike.svg" alt=""><span class="badge color-red" style="border-radius: 16px;height: 15px;width: 15px;margin-top: -5vw;"><p style="margin-top: -5.5vw;margin-left: -0.5vw;">{{cartinfo.length}}</p></span></f7-link>
        <f7-link style="padding:0 10px" href="/hdcart/" v-else><img src="../assets/delivery-motorbike.svg" alt=""></f7-link>
      </f7-nav-right>
    </f7-navbar>
      <offline @detected-condition="handleConnectivityChange">
  </offline>
    <!-- Scrollable page content-->
    <f7-block style="margin:0px">
      <f7-row style="margin:10px 0px 10px 0px">
        <f7-col>
         <f7-link @click="saveproduct('Kurtis')" href="/products/">
           <f7-card style="height:14vh;margin:0px;border-radius:5px">
             <img src="../assets/cat_page-subbanner2.png" style="width:100%;height:100%;border-radius:5px" alt="">
           </f7-card>
         </f7-link>
        </f7-col>
      </f7-row>
      <f7-row style="margin:10px 0px 10px 0px">
        <f7-col>
         <f7-link @click="saveproduct('Shirts')" href="/products/">
           <f7-card style="height:16vh;margin:0px;border-radius:5px">
             <img src="../assets/w_shirt.png" style="width:100%;height:100%;border-radius:5px" alt="">
           </f7-card>
         </f7-link>
        </f7-col>
        <f7-col>
         <f7-link @click="saveproduct('Tops')" href="/products/">
           <f7-card style="height:16vh;margin:0px;border-radius:5px">
             <img src="../assets/w_top.png" style="width:100%;height:100%;border-radius:5px" alt="">
           </f7-card>
         </f7-link>
        </f7-col>
        <f7-col>
         <f7-link @click="saveproduct('Kurtis')" href="/products/">
           <f7-card style="height:16vh;margin:0px;border-radius:5px">
             <img src="../assets/w_kurti.png" style="width:100%;height:100%;border-radius:5px" alt="">
           </f7-card>
         </f7-link>
        </f7-col>
      </f7-row>
      <f7-row style="margin:10px 0px 10px 0px">
        <f7-col>
         <f7-link @click="saveproduct('T-Shirts')" href="/products/">
           <f7-card style="height:16vh;margin:0px;border-radius:5px">
             <img src="../assets/w_tshirt.png" style="width:100%;height:100%;border-radius:5px" alt="">
           </f7-card>
         </f7-link>
        </f7-col>
        <f7-col>
         <f7-link @click="saveproduct('Jeans')" href="/products/">
           <f7-card style="height:16vh;margin:0px;border-radius:5px">
             <img src="../assets/w_jean.png" style="width:100%;height:100%;border-radius:5px" alt="">
           </f7-card>
         </f7-link>
        </f7-col>
        <f7-col>
         <f7-link @click="saveproduct('Dungarees')" href="/products/">
           <f7-card style="height:16vh;margin:0px;border-radius:5px">
             <img src="../assets/w_dungarees.png" style="width:100%;height:100%;border-radius:5px" alt="">
           </f7-card>
         </f7-link>
        </f7-col>
      </f7-row>
      <f7-row style="margin:10px 0px 10px 0px">
        <f7-col>
         <f7-link @click="saveproduct('Fashion Jackets')" href="/products/">
           <f7-card style="height:16vh;margin:0px;border-radius:5px">
             <img src="../assets/w_fjacket.png" style="width:100%;height:100%;border-radius:5px" alt="">
           </f7-card>
         </f7-link>
        </f7-col>
        <f7-col>
         <f7-link @click="saveproduct('Leggings')" href="/products/">
           <f7-card style="height:16vh;margin:0px;border-radius:5px">
             <img src="../assets/w_legging.png" style="width:100%;height:100%;border-radius:5px" alt="">
           </f7-card>
         </f7-link>
        </f7-col>
        <f7-col>
         <f7-link @click="saveproduct('One piece')" href="/products/">
           <f7-card style="height:16vh;margin:0px;border-radius:5px">
             <img src="../assets/w_onepiece.png" style="width:100%;height:100%;border-radius:5px" alt="">
           </f7-card>
         </f7-link>
        </f7-col>
      </f7-row>
    </f7-block>
    <f7-block style="margin-top:0px">
      <f7-list accordion style="margin-top:0px">
        <template v-for="product in c">
          <f7-list-item :title="product" @click="saveproduct(product)" style="font-size:12px" link="/products/" link-view="#main-view" panel-close/>
        </template>
      </f7-list>
    </f7-list>
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
      category:'',
      c:['Plazo','Shrugs','Salwars','Capris','Sweatshirts','Socks'],
      title: 'Services Page',
      cartinfo:[],
      wishlistinfo:[],
      internet:null,
      status:'not shown'
    };
  },
components: {
    offline
  },
  mounted(){
    /*var tmp_data = localStorage.getItem('panelData');
    if(tmp_data)
    {
      var category = JSON.parse(tmp_data);
      this.category = category.category[1].wear;
    }else {
      axios({
        method: 'GET',
        url: '/tmpjson/leftpanel'
      }).then(response => {
        this.category = response.data.category[1].wear;
      }, (error) => {
        alert('please check your internet connection');
      });
    }*/
    this.getCart();
    this.getWishlist();
  },
  methods:{/*
    savecategory:function(category){
      localStorage.setItem("category",category);
    },*/
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
        console.log("Hi");
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
          console.log("Hi");
      }).catch(error => {
        if(error.response.data.message != undefined)
          alert(error.response.data.message);
        else
          alert('Something went wrong,please try again');

      });
    },
    saveproduct:function(product){
      if(product == "Shirts" || product == "One piece" || product == "Plazo" || product == "Shrugs" || product == "Tops" || product == "Capris" || product == "Dress Material" || product=="T-Shirts" || product == "Jeans" || product == "Dungarees" || product=="Fashion Jackets")
        this.category = "WESTERN WEAR";
      if(product == "Leggings" || product == "Salwars" || product == "Kurtis" || product == "Dress Material")
        this.category = "ETHNIC WEAR";
      if(product == "Socks" || product == "Sweatshirts")
        this.category = "WINTER AND SEASONAL";
      localStorage.setItem("category",this.category);
      localStorage.setItem("product",product);
    }
  }
};
</script>
