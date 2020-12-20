<template>
  <f7-page style="padding-bottom:35px" name="products"
           infinite
           :infinite-distance="20"
           :infinite-preloader="showPreloader"
           @infinite="loadMore"
           >
    <div v-if="toast_msg != null" class="custom_toast z-depth-3">
      {{ toast_msg }}
    </div>
    <f7-navbar class="bgnav" sliding>
     <f7-nav-left>
        <f7-link icon-f7="icon-arrow_left" @click="Pageback($f7router)"></f7-link>
      </f7-nav-left>
      <f7-nav-title style="font-size:15px;margin:0px;text-transform:uppercase">
        {{category}}
      </f7-nav-title>
        <f7-nav-right>
        <!--<f7-link style="padding:0 10px" icon-f7="icon-search_strong" href="/search/WHATS YOUR TODAY WISH/enter product you want/product"></f7-link>-->
        <f7-link style="padding:0 10px" icon-f7="icon-heart_fill" href="/wishlist/" v-if="wishlistinfo.length>0"><span class="badge color-red" style="border-radius: 16px;height: 15px;width: 15px;margin-top: -5vw;margin-left:-5px;"><p style="margin-top: -5.5vw;margin-left: -0.5vw;">{{wishlistinfo.length}}</p></span></f7-link>
        <f7-link style="padding:0 10px" icon-f7="icon-heart_fill" href="/wishlist/" v-else></f7-link>
        <f7-link style="padding:0 10px" href="/hdcart/" v-if="cartinfo.length>0"><img src="../assets/delivery-motorbike.svg" alt=""><span class="badge color-red" style="border-radius: 16px;height: 15px;width: 15px;margin-top: -5vw;"><p style="margin-top: -5.5vw;margin-left: -0.5vw;">{{cartinfo.length}}</p></span></f7-link>
        <f7-link style="padding:0 10px" href="/hdcart/" v-else><img src="../assets/delivery-motorbike.svg" alt=""></f7-link>      </f7-nav-right>
    </f7-navbar>
          <offline @detected-condition="handleConnectivityChange">
  </offline>
    <!-- Scrollable page content-->
    <!-- <f7-block-title>{{ title }</f7-block-title> -->
    <div v-if="AppLoader" style="position:fixed;width:100%;height:100vh;background-color: rgba(255,255,255,0.8);">
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
    <div class="content" style="background-color:#ffffff">
      <div v-if="!preloader">
        <div v-show="productMsg!=null">
          <center>
            <h2 style="padding:10px 0px">{{ productMsg }}</h2>
            <h4 style="margin:18px 0px 10px 0px">Shopkeepers Will Soon Add Great {{category}}</h4>
            <h3 style="margin:0px 0px 30px 0px">Stay Tuned !</h3>
            <span style="font-size:38px;font-weight:800;border: 1px solid #000000;border-radius:5px;padding:5px 10px;">OR</span>
            <h2 style="padding:10px 0px">Use Specific Want Feature</h2>
            <f7-link href="/specificPage" @click="save('clothing')">
            <img src="../assets/featurebanner1.png" style="width:170px;height:190px;border-radius:5px" alt="Specific Want Order">
            </f7-link>
          </center>
        </div>
        <div v-if="q != undefined" style="color:black;font-size: 16px;padding:5px;">
          Search result : {{ q }}
        </div>
        <f7-block style="margin:0px;padding:0px">
         <f7-link href="/products/" v-show="productinfo.length>0">
           <f7-card style="height:18.8vh;margin:0px">
            <f7-link href="/specificPage" @click="save('clothing')" style="width:100%;height:100%">
             <img src="../assets/pro_page-banner.png" style="width:100%;height:100%" alt="">
            </f7-link>
           </f7-card>
         </f7-link>
      </f7-block>
        <f7-row no-gap>
          <template v-for="(result,index) in productinfo">
          <f7-col v-if="listSizes[index]!=''" width="50" class="col_hgt" style="height:47vh;border-right:1px solid #f1f3f6;border-bottom:1px solid #f1f3f6">
              <f7-link :href="'/productdetails/' + result.id + '/' + result.name" style="width:100%">
                <f7-card style="width:100%;height:100%;margin:0px;padding:0px;-webkit-box-shadow: none;box-shadow: none">
                  <div class="image_viewer" style="width: 100%;height:35vh;text-align:center">
                    <img :src="result.image" style="max-width:100%;height:100%;margin:0px">
                    <f7-chip :text="listSizes[index]" class="lineclampin1" style="position:absolute;bottom:12vh;left:5px;z-index:99;color:#FFFFFF;background-color:#000000;opacity:0.8"></f7-chip>
                  </div>
                  <div style="position:absolute;top:13px;right:13px;z-index:99;background-color:white;border-radius:50%;width:30px;height:30px">
                    <f7-link  
                      v-if="result.wishlistflag ==0" @click="addToWishlist(result.id,0,result.wishlistflag)" 
                      icon-f7="icon-heart" style="position:absolute;top:7px;right:5px;color:gray;"></f7-link>
                    <f7-link v-if="result.wishlistflag==1" @click="addToWishlist(result.id,1,result.wishlistflag)" 
                      icon-f7="icon-heart_fill" 
                      style="position:absolute;top:7px;right:5px;color:red"></f7-link>
                  </div>
                  <f7-block style="color:#BDBDBD;font-size:12px;font-weight:bold;padding:8px">
                    <p class="mpzero lineclampin" style="text-transform: capitalize">{{result.name}}</p>
                    <p class="mpzero lineclampin">
                      <span style="color:gray;font-size:14px">Rs.{{result.selling_price}} </span>
                      <span style="text-decoration:line-through;margin-left:3px">Rs.{{result.mrp_price}}</span>
                      <span style="color:red;font-size:12px;margin-left:2px">({{discount[index]}}% OFF)</span>
                    </p>
                    <p class="mpzero lineclampin">Store : {{result.shop_name}}</p>
                  </f7-block>
                </f7-card>
              </f7-link>
          </f7-col>
      </template>
    </f7-row>
        <f7-segmented style="position:fixed;bottom:0;z-index:999;width:100%;background-color:white;border-radius:0px;box-shadow: 5px 0px 10px rgba(0, 0, 0, 0.12)">
          <f7-button sheet-open=".sortsheet" icon-f7="sort" color="gray" style="font-size:12px;font-weight:bold">&nbsp SORT</f7-button>
          <f7-button popup-open=".filterpopup" icon-f7="filter" color="gray" style="font-size:12px;font-weight:bold">&nbsp FILTER</f7-button>
        </f7-segmented>

          <f7-sheet ref="sortsheet" class="sortsheet">
              <f7-block-title style="margin:0px;padding:15px;font-size:12px">SORT BY<f7-button sheet-close outline small @click="ApplySort()" color="gray" style="font-size:12px;font-weight:bold;display:inline-block;position:absolute;right:15px;top:10px">APPLY</f7-button>
        </f7-block-title>
              <f7-block style="margin:0px">
                  <f7-list style="margin:0px;color:gray;font-size:14px">
                    <label class="item-content item-radio"><input name="shopsortradio" v-model="sortby" value="ltoh" type="radio"><i class="icon icon-radio"></i><div class="item-inner"><div class="item-title">Price - Low to High</div></div></label>
                    <label class="item-content item-radio"><input name="shopsortradio" v-model="sortby" value="htol" type="radio"><i class="icon icon-radio"></i><div class="item-inner"><div class="item-title">Price - High to Low </div></div></label>
                  </f7-list>
              </f7-block>
        </f7-sheet>

        <f7-sheet ref="loginsheet" class="loginsheet" style="height:150px">
          <center>
            <img src="../assets/fashiostreet.png" style="height:40px;margin-top:10px" alt="">
          </center>
              <f7-block-title style="margin:0px;padding:15px;text-align:center"><h5 class="mpzero">YOU ARE NOT LOGGED IN</h5>
              </f7-block-title>
              <f7-block style="margin:0px">
                  <f7-segmented style="border-top:1px solid #E0E0E0">
                    <f7-button color="green" href="/login/" sheet-close style="font-size:12px;font-weight:bold">LOG IN</f7-button>
                    <f7-button color="green" href="/signup/" sheet-close style="font-size:12px;font-weight:bold">SIGN UP</f7-button>
                  </f7-segmented>
              </f7-block>
        </f7-sheet>
        <div v-show="productDone==true && showPreloader==false && productMsg==null">
          <center>
            <h2 style="padding:10px 0px">More Products Coming Soon</h2>
            <h4 style="margin:18px 0px 10px 0px">Shopkeepers Are Soon Adding Great {{category}}</h4>
            <h3 style="margin:0px 0px 30px 0px">Stay Tuned !</h3>
            <span style="font-size:38px;font-weight:800;border: 1px solid #000000;border-radius:5px;padding:5px 10px;">OR</span>
            <h2 style="padding:10px 0px">Use Specific Want Feature</h2>
            <f7-link href="/specificPage">
            <img src="../assets/featurebanner1.png" style="width:170px;height:190px;border-radius:5px;margin-bottom:28px" alt="Specific Want Order">
            </f7-link>
          </center>
        </div>
        <f7-popup class="filterpopup" style="color:#BDBDBD;background-color:#F5F5F5;">
            <f7-navbar class="bgnav" sliding>
              <f7-nav-left>
                <f7-link icon-f7="icon-arrow_left" popup-close></f7-link>
              </f7-nav-left>
              <f7-nav-title style="font-size:15px;margin:0px">
                FILTERS
              </f7-nav-title>
              <f7-nav-right>
                <f7-link popup-close @click="clearFilter()"><h6 style="font-weight:normal">CLEAR ALL</h6></f7-link>
              </f7-nav-right>
            </f7-navbar>
            <f7-row no-gap style="height:100%">
          <f7-col width="35" style="color:#757575">
              <f7-list no-hairlines-between style="margin:0px;padding:0px">
                  <f7-list-item link title="Price" @click='shop = false,price = true,size=false,color=false,brand=false'/>
                  <f7-list-item link title="Size" @click='shop = false,price = false,size=true,color=false,brand=false'/>
                  <f7-list-item link title="Color" @click='shop = false,price = false,size=false,color=true,brand=false'/>
                  <f7-list-item link title="Shop" @click='shop = true,price = false,size=false,color=false,brand=false'/>
              </f7-list>
              </f7-col>
          <f7-col class="box" width="65" style="padding-left:10px;background-color:white;height:100%;overflow-y:scroll">
            <f7-block v-show='shop' style="margin:0px;padding:0px">
              <form data-v-532328bc="" class="searchbar searchbar-enabled" disable-link-text="Cancel"><div class="searchbar-inner"><div class="searchbar-input-wrap"><input placeholder="Search shop" v-model="shopsearch" type="search" class=""><i class="searchbar-icon"></i><span class="input-clear-button"></span></div><span class="searchbar-disable-button">Cancel</span></div></form>
              <center>
                <br/>
                <div v-if="shopData.length <= 0" class="preloader">
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
              <div v-if="shopData.length <= 0">
                <center><h3>no Shop found</h3></center>
              </div>
              <f7-list v-if="shopData.length>=1" style="margin:0px;padding:0px">
                  <template v-for="shop in shopData">
                    <label class="item-radio item-content">
                      <input type="radio" v-model="shopfilter" :value="shop.name"/>
                      <i class="icon icon-radio"></i>
                      <div class="item-inner">
                        <div class="item-title">{{ shop.name }}</div>
                      </div>
                    </label>
                  </template>
                <br/><br/><br/><br/><br/>
              </f7-list>
            </f7-block>
            <f7-block  v-show='price' style="margin:0px;padding:0px">
              <f7-list style="margin:0px;padding:0px">
                <label class="item-content item-checkbox"><input type="checkbox" v-model="pricefilter" value="0-500"><i class="icon icon-checkbox"></i><div class="item-inner"><div class="item-title">Below Rs.500</div></div></label>
                <label class="item-content item-checkbox"><input type="checkbox" v-model="pricefilter" value="500-700"><i class="icon icon-checkbox"></i><div class="item-inner"><div class="item-title">Rs. 500-700</div></div></label>
                <label class="item-content item-checkbox"><input type="checkbox" v-model="pricefilter" value="700-1000"><i class="icon icon-checkbox"></i><div class="item-inner"><div class="item-title">Rs. 700-1000</div></div></label>
                <label class="item-content item-checkbox"><input type="checkbox" v-model="pricefilter" value="1000-1300"><i class="icon icon-checkbox"></i><div class="item-inner"><div class="item-title">Rs. 1000-1300</div></div></label>
                <label class="item-content item-checkbox"><input type="checkbox" v-model="pricefilter" value="1300-1500"><i class="icon icon-checkbox"></i><div class="item-inner"><div class="item-title">Rs. 1300-1500</div></div></label>
                <label class="item-content item-checkbox"><input type="checkbox" v-model="pricefilter" value="1500-2000"><i class="icon icon-checkbox"></i><div class="item-inner"><div class="item-title">Rs. 1500-2000</div></div></label>
                <label class="item-content item-checkbox"><input type="checkbox" v-model="pricefilter" value="2000-10000"><i class="icon icon-checkbox"></i><div class="item-inner"><div class="item-title">Above Rs.2000</div></div></label>
                <br/><br/><br/><br/><br/>
              </f7-list>
            </f7-block>
            <f7-block v-show='size' style="margin:0px;padding:0px">
              <center>
                <br/>
                <div v-if="filerloader" class="preloader">
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
              <div v-if="sizesData.length <= 0">
                <center><h3>no sizes found</h3></center>
              </div>
              <f7-list v-if="!filerloader" style="margin:0px;padding:0px">
                  <template v-for="size in sizesData">
                    <label class="item-content item-checkbox"><input type="checkbox" v-model="sizefilter" :value="size.name"><i class="icon icon-checkbox"></i><div class="item-inner"><div class="item-title">{{ size.name }}</div></div></label>
                  </template>
                <br/><br/><br/><br/><br/>
              </f7-list>
            </f7-block>
            <f7-block v-show='color' style="margin:0px;padding:0px;height:90vh">
              <f7-list sortable style="margin:0px;padding:0px">
                <template v-for="color in colorData">
                  <label class="item-content item-checkbox"><input v-model="colorfilter" :value="color" type="checkbox"><i class="icon icon-checkbox"></i><div class="item-inner"><div class="item-title">{{ color }}</div></div></label>
                </template>
                <br/><br/><br/><br/><br/>
              </f7-list>
            </f7-block>
          </f7-col>
        </f7-row>
        <f7-button @click="applyFilter" fill popup-close color="gray" style="position:fixed;bottom:0;z-index:999;width:100%">Apply</f7-button>
        </f7-popup>
      </div>
    </div>
  </f7-page>
</template>

<script>
import offline from 'v-offline';
  import axios from '../axios'
export default {
  name: 'Products',
  data() {
    return {
      title: 'Services Page',
      inProcess:false,
      Cleartime:null,
      AppLoader:false,
      filerloader:false,
      sizesData:[],
      page:1,
      q:null,
      category:localStorage.getItem("product"),
      showPreloader:true,
      allowInfinite:true,
      sizefilter:[],
      productDone : false,
      colorData:[
        'black',
        'green',
        'yellow',
        'gray',
        'maroon',
        'blue',
        'dark blue',
        'skin',
        'white',
        'brown',
        'orange',
        'purple',
        'multicolor',
        'red',
        'pink'
      ],
      colorfilter:[],
      pricefilter:[],
      shopData:[],
      shopsearch:null,
      shopfilter:null,
      sortby:"ltoh",
      productinfo:[],
      productMsg:null,
      toast_msg:null,
      productload:true,
      price:true,
      color:false,
      brand:false,
      size:false,
      shop:false,
      internet:null,
      status:'not shown',
      product:null,
      preloader:false,
      urlParam:{},
      discount:[],
      url:'/product/' + localStorage.getItem("city") + '/' + localStorage.getItem("product") + '/json',
      loadMoreProduct:[],
      cartinfo:[],
      wishlistinfo:[],
      listSizes:[]
    };
  },
    components: {
    offline
  },
  created(){
    var url = window.location.href;
    if(url.indexOf('?q=') != -1) {
      url = url.substring(url.indexOf("?q=") + 3);
      url = decodeURIComponent(url);
    }
    else{
      url = undefined;
    }
    this.q = url;
    if(this.q == 'undefined')
    {
      this.q = undefined;
    }
  },
  mounted(){
    this.init();
    this.getCart();
    this.getWishlist();
    this.getProduct();
    this.getSizes();
    this.getShop();
    this.productDone= true;
  },
  watch:{
    sizefilter:function(newVal,oldVal){
      var length = this.sizefilter.length;
      if(length >= 5)
      {
        this.sizefilter = oldVal;
        alert('max five size filter allow');
        return false;
      }
    },
    colorfilter:function(newVal,oldVal){
      var length = this.colorfilter.length;
      if(length >= 5)
      {
        this.colorfilter = oldVal;
        alert('max five color filter allow');
        return false;
      }
    },
    pricefilter:function(newVal,oldVal){
      var length = this.pricefilter.length;
      if(length >= 5)
      {
        this.pricefilter = oldVal;
        alert('max five price filter allow');
        return false;
      }
    },
    shopsearch:function(){

      this.searchShop();
    }
  },
  methods:{
    save(value)
    {
      localStorage.setItem('specific',value);
      localStorage.setItem('gen',localStorage.getItem('gender'));
            localStorage.setItem('cat',localStorage.getItem('product'));
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
    Pageback:function(route){
      //source.cancel();
      //cancel();
      route.back();
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
        {
          //alert('hi8');
          alert(error.response.data.message);
        }
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
        {
          alert(error.response.data.message);
          //alert('hi7');
        }
        else
          alert('Something went wrong,please try again');

      });
    },
    clearFilter:function(){
      this.init();
      this.page = 1;
      this.showPreloader = true;
      this.productMsg = null;
      this.preloader = true;  
      this.inProcess = true;
      this.getProduct();
      this.productinfo = [];
    },
    loadMore:function(){
      const self = this;
      if(this.loadMoreProduct.length >= 15)
      {
        self.allowInfinite = true;
      }
      else{
        self.allowInfinite = false;
        this.showPreloader = false;
        return false;
      }
      if(!self.allowInfinite) return;
      self.allowInfinite = false;
      if(this.loadMoreProduct.length >= 15)
      {
        if(this.inProcess == false) {
          this.inProcess = true;
          this.getProduct();
          self.allowInfinite = true;
          return true;
        }
      }
      else{
        this.showPreloader = false;
      }
      return false;
    },
    init:function(){
      this.urlParam = {
        'shop': 'All Shop',
        'gender': localStorage.getItem("gender"),
        'category': localStorage.getItem("category")
      },
        this.shopfilter = null;
      this.colorfilter = [];
      this.sizefilter = [];
      this.pricefilter = [];
    },
    applyFilter:function(){
      this.page =1;
      this.showPreloader = true;
      this.productMsg = null;
      this.inProcess = true;
      this.preloader = true;
      this.productinfo = [];
      if(this.colorfilter.length > 0)
      {
        this.urlParam.color = '';
        for(var i=0;i < this.colorfilter.length;i++)
        {
          this.urlParam.color = this.urlParam.color + this.colorfilter[i] + ' and ';
        }
        this.urlParam.color = this.urlParam.color.substring(0, this.urlParam.color.length - 5);
      }
      if(this.sizefilter.length > 0)
      {
        this.urlParam.size = '';
        for(var i=0;i < this.sizefilter.length;i++)
        {
          this.urlParam.size = this.urlParam.size + this.sizefilter[i] + ' and ';
        }
        this.urlParam.size = this.urlParam.size.substring(0,this.urlParam.size.length - 5);
      }
      if(this.pricefilter.length > 0)
      {
        this.urlParam.price = '';
        for(var i=0;i < this.pricefilter.length;i++)
        {
          this.urlParam.price = this.urlParam.price + this.pricefilter[i] + ' and ';
        }
        this.urlParam.price = this.urlParam.price.substring(0,this.urlParam.price.length - 5);
      }
      if(this.shopfilter != null)
      {
        this.urlParam.shop = this.shopfilter;
      }
      this.getProduct();
      return true;
    },
    getShop:function(){
      setTimeout(() => {
        var url  = '/shop/json?city=' + localStorage.getItem('city');
        var axiosMeta = {
          method: 'POST',
          url: url,
          //cancelToken:source.token
        };
        if(localStorage.getItem('local_id') && localStorage.getItem('token')){
          axiosMeta.header = {
            'local-id' : localStorage.getItem('local_id'),
            'token' : localStorage.getItem('token')
          };
        }
        axios(axiosMeta).then(response => {
          this.shopData = response.data.result;

        }).catch(error => {
          if(error.response.data.message != undefined)
          {
            //alert(error.response.data.message);
            //alert('hi6');
          }
          else
            alert('application error found,restart your application');
        });
      },500);
    },
    searchShop:function(){
      if(this.shopsearch == null || this.shopsearch == '')
      {
        this.getShop();
        return true;
      }
      setTimeout(() => {
        var url  = '/search/shop?city=' + localStorage.getItem('city') + '&shop=' + this.shopsearch;
        var axiosMeta = {
          method: 'POST',
          url: url,
          //cancelToken:source.token
        };
        if(localStorage.getItem('local_id') && localStorage.getItem('token')){
          axiosMeta.header = {
            'local-id' : localStorage.getItem('local_id'),
            'token' : localStorage.getItem('token')
          };
        }
        axios(axiosMeta).then(response => {
          this.shopData = response.data;
        }).catch(error => {
          if(error.response.data.message != undefined)
          {
            alert(error.response.data.message);
            //alert('hi5');
          }
          else
            alert('application error found,restart your application');
        });
      },500);
    },
    getSizes:function(){
      this.filerloader = true;
      setTimeout(() => {
        var url  = '/product/sizes/json?sub_category='+ localStorage.getItem('product') +'&category='+ localStorage.getItem('category') +'&gender=' + localStorage.getItem('gender');
        var axiosMeta = {
          method: 'GET',
          url: url,
          //cancelToken:source.token
        };
        if(localStorage.getItem('local_id') && localStorage.getItem('token')){
          axiosMeta.header = {
            'local-id' : localStorage.getItem('local_id'),
            'token' : localStorage.getItem('token')
          };
        }
        axios(axiosMeta).then(response => {
          this.sizesData = response.data.result;
          this.filerloader = false;
        }).catch(error => {
          if(error.response.data.message != undefined)
          {
            alert(error.response.data.message);
            //alert('hi4');
          }
          else
            alert('application error found,restart your application');
          this.filerloader = false;
        });
      },500);
    },
    getProduct2:function(event,done) {
      this.showPreloader = true;
      done();
      this.preloader = true;
      this.getProduct(event,done,1);
    },
    getProduct:function(event,done,index){
      //console.log(localStorage.getItem('userId'));
      setTimeout(() => {
        var url  = this.url + '?';
        console.log('q : ' + this.q);
        if(this.q != undefined)
        {
          this.urlParam.q = this.q;
        }
        if(index != undefined)
        {
          this.urlParam.page = index;
        }
        else{
          this.urlParam.page = this.page;
        }
        this.urlParam.sort = "ltoh";
        for(var key in this.urlParam)
        {
          url = url + key + '=' + this.urlParam[key] + '&';
        }
        url = url.slice(0, -1);
        console.log(url);
        var axiosMeta = {
          method: 'GET',
          url: url
        };
        if(localStorage.getItem('local_id') && localStorage.getItem('token')){
          axiosMeta.header = {
            'local-id' : localStorage.getItem('local_id'),
            'token' : localStorage.getItem('token')
          };
        }
        axios(axiosMeta).then((response) => {
          this.loadMoreProduct = response.data.result;
          console.log(this.loadMoreProduct);
          if(this.loadMoreProduct.original == 'No Product Found')
          {
            this.productMsg = 'No Products Right Now';
            this.loadMoreProduct = [];
            console.log("No Product console");
            this.productinfo = this.loadMoreProduct;

          }
          else {
            this.product = localStorage.getItem("product");
            this.productload = false;
            if (this.page == 1) {
              this.productinfo = this.loadMoreProduct;
              console.log(this.productinfo);
              for(var i=0;i<this.productinfo.length;i++)
              {
                this.productinfo[i].mrp_price = Math.floor(this.productinfo[i].mrp_price);
                this.productinfo[i].selling_price = Math.floor(this.productinfo[i].selling_price);
                var a = this.productinfo[i].mrp_price - this.productinfo[i].selling_price;
                this.discount[i] = Math.round((a/this.productinfo[i].mrp_price)*100);
              }
              for(var i=0;i<this.productinfo.length;i++)
              {
                axios({
                  method:'GET',
                  url : '/product/'+localStorage.getItem("city")+'/'+ this.productinfo[i].name +'/' + this.productinfo[i].id +'/buy/json',
                }).then(response => {
                  //console.log(response);
                  var a = response.data.result[0].size;
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
                  if(error.response.data.message != undefined)
                    alert(error.response.data.message);
                  else
                    alert('application error found,please restart your app');
                  this.preloader = false;
                  done();
                });
              }
            }
            else {
              this.productinfo = this.productinfo.concat(this.loadMoreProduct);
              for(var i=0;i<this.productinfo.length;i++)
              {
                this.productinfo[i].mrp_price = Math.floor(this.productinfo[i].mrp_price);
                this.productinfo[i].selling_price = Math.floor(this.productinfo[i].selling_price);
                var a = this.productinfo[i].mrp_price - this.productinfo[i].selling_price;
                this.discount[i] = Math.round((a/this.productinfo[i].mrp_price)*100);
              }
              var c = ((this.page-1)*16)-1;
              for(var i=c;i<this.productinfo.length;i++)
              {
                axios({
                  method:'GET',
                  url : '/product/'+localStorage.getItem("city")+'/'+ this.productinfo[i].name +'/' + this.productinfo[i].id +'/buy/json',
                }).then(response => {
                  //console.log(response);
                  var a = response.data.result[0].size;
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
                  if(error.response.data.message != undefined)
                    alert(error.response.data.message);
                  else
                    alert('application error found,please restart your app');
                  this.preloader = false;
                  done();
                });
              }
            }
            this.page = this.page + 1;
          }
          if(this.loadMoreProduct.length < 15)
          {
            this.showPreloader = false;
          }
          this.preloader = false;
          this.inProcess = false;
        },(error) => {
          this.showPreloader = false;
          this.inProcess = false;
          if(error.response.data.message != undefined)
          {
            if(error.response.data.message == 'no product found')
            {
              this.productMsg = 'no product found';
              this.preloader = false;
              return false;
            }
            alert(error.response.data.message);
            //alert('hi3');
          }

          else
            alert('application error found,restart your application');
          this.preloader = false;
        });
      },500);
    },
    ApplySort:function(){
      this.page =1;
      this.showPreloader = true;
      this.productinfo = [];
      this.urlParam.sort = this.sortby;
      this.$refs.sortsheet.close();
      this.getProduct();
    },
    addToWishlist:function(product_id,status,el){
      if(localStorage.getItem('local_id') && localStorage.getItem('token'))
      {
        if(status == 1)
        {
          this.getProduct();
          axios({
            method:'POST',
            url : 'user/deletewishlist/json',
            data:{
              'product_id' : product_id
            }
          }).then(response => {
            this.toast_msg = 'successfully remove product from wishlist';
            setTimeout(() => {
              this.toast_msg = null;
            },2000);
            this.getWishlist();
            this.getProduct();
          }).catch(error => {
            if(error.response.data.message != undefined)
            {
              alert(error.response.data.message);
              //alert('hi2');
            }
            else
              alert('failed to remove product from wishlist');
          });
        }
        else {
          this.getProduct();
          this.AppLoader = true;
          this.toast_msg = 'please wait, product adding to wishlist...';
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
            this.AppLoader = false;
            this.toast_msg = 'successfully product added to wishlist';
            setTimeout(() => {
              this.toast_msg = null;
            },2000);
            //location.reload();
            this.getWishlist(); 
            this.getProduct();
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
      else{
        this.$refs.loginsheet.open();
      }
    }
  }
};
</script>
<style scoped>
  .inWishlist{
    background-color: red;
    border: 0px solid red;
  }
.lineclampin{
    overflow: hidden !important;
    text-overflow: ellipsis !important;
    white-space: nowrap !important;
    width: 100% !important;
}
.lineclampin1{
    overflow: hidden !important;
    text-overflow: ellipsis !important;
    white-space: nowrap !important;
    max-width: 90% !important;
}
.box.block::-webkit-scrollbar {
    display: none;
    -moz-appearance: none;
   }
 @media only screen and (max-height: 570px) {
    .pad{
      padding-bottom:10px !important
    }
    .col_hgt{
      height: 47.5vh !important;
    }
  }
  @media only screen and (max-height: 530px) {
    .col_hgt {
      height: 49.5vh !important;
    }
  }
</style>
