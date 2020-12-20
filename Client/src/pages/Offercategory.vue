<template>
  <f7-page name="offercategory">
    <f7-navbar back-link="back" class="bgnav" style="border-radius:0px 0px 30px 0px;box-shadow: 5px 0px 10px rgba(0, 0, 0, 0.12)" sliding>
      <f7-nav-title style="font-size:18px;font-weight:bold;margin:0px">
        {{offer_name}}
      </f7-nav-title>
    </f7-navbar>
          <offline @detected-condition="handleConnectivityChange">
  </offline>
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
      </div>
      <div v-if="!preloader">
      </div>
      <f7-block style="margin:0px">
      <f7-row style="margin:15px 0px 55px 0px">
        <template v-for="(category,index) in categories">
          <f7-col width="50" style="margin-bottom:16px">
           <f7-link @click="saveproduct(category.subcategory_id,category.discount)" href="/offers1">
             <f7-card style="margin:0px;border-radius:10px;padding:0px 5px;-webkit-box-shadow: none;box-shadow: none;border:1px solid gray">
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
          </f7-col>
        </template>
      </f7-row>
    </f7-block>
    <div style="position:fixed;bottom:0px;left:0px;width:100%;z-index:99;border-radius:30px 30px 0px 0px;background-image: linear-gradient(to right, #ff416c, #ff4b2b);color:#FFFFFF">
      <center>
        <f7-link style="width:100%" @click="saveshop" href="/shophome/">
            <p style="font-size:16px;font-weight:bold;color:#FFFFFF">By Shop : {{shop_name}}</p>
        </f7-link>
      </center>
    </div>
  </f7-page>
</template>

<script>
import offline from 'v-offline';
import axios from '../axios';
export default {
  name: 'Hdcart',
  data() {
    return {
      preloader:true,
      categories:null,
      shop_name:localStorage.getItem('shop'),
      offer_name:localStorage.getItem('bname'),
      icons:[]
    };
  },
  mounted(){
    this.getCategoriesOfShopOffers();
  },
    components: {
    offline
  },
  methods:{
    getCategoriesOfShopOffers()
    {
      axios({
        method:'GET',
        url : 'categories/'+localStorage.getItem('shop'),
      }).then(response => {
        this.categories = response.data.result;
        console.log(this.categories);
        this.preloader = false;
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
    saveproduct(category,discount)
    {
      localStorage.setItem('offerCategory',category);
      localStorage.setItem('offerDiscount',discount);
    },
    saveshop()
    {
      localStorage.setItem('sname',localStorage.getItem('shop'));
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
</style>