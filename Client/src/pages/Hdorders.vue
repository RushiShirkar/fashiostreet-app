<template>
  <f7-page class="bgpage" name="hdorders"
           infinite
           :infinite-distance="50"
           :infinite-preloader="showPreloader"
           @infinite="loadMore"
           >
  <f7-navbar class="bgnav" sliding>
    <f7-nav-left>
      <f7-link icon-f7="icon-close" @click="$f7router.back()"></f7-link>
    </f7-nav-left>
    <f7-nav-title style="font-size:15px;margin:0px">
      HD ORDERS
    </f7-nav-title>
    <f7-nav-right>
      <!--<f7-button large small outline round color="white" style="margin-right:16px">Call Delivery Boy</f7-button>-->
      <a icon-f7="phone_fill" class="link external button button-outline button-round color-white" href="tel:8600198512"  style="color:white;display:block;font-size:14px;font-weight:bold;height:30px;line-height:28px;margin-right:10px">
        <center>CALL DELIEVERY BOY</center>
      </a>
    </f7-nav-right>
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
      <div v-show="error && !preloader">
        <center><h3>No Orders found</h3></center>
      </div>
      <template v-for="(order,index) in orders">
        <f7-block-title style="margin-top:15px">
        <f7-row>
          <f7-col><h5 class="mpzero">ORDER NO : {{ order.order_id }}</h5></f7-col>
          <f7-col  v-show="order.try_buy=='YES'" style="text-align:right;color:green"><h5 class="mpzero">(Try & Buy Applied)</h5></f7-col>
        </f7-row>
        </f7-block-title>
        <f7-block style="padding:0px;margin:0px">
            <f7-card style="margin:0px 10px 0px 10px">
              <f7-card-header>
                <h5 class="mpzero" style="color:#757575">Delivery Address : <span style="font-weight:normal">{{ order.address }}</span></h5>
              </f7-card-header>
              <f7-card-content style="padding:10px 0px">
                <f7-block style="margin:0px">
                  <template v-for="product in order.products">
                    <f7-row no-gap>
                    <f7-col width="25"><img :src="product.image" style="width:100%;height:90px"></f7-col>
                    <f7-col width="75" style="padding-left:15px"><p class="mpzero" style="font-weight:bold;color:#616161">{{ product.name }}</p>
                      <p class="mpzero">
                        <span v-show="product.specialDiscount == true" style="color:#000000;font-size:17px">&#8377;{{product.specialDiscountedPrice}}</span>
                    <span v-show="product.specialDiscount == false" style="color:#000000;font-size:17px">&#8377;{{product.selling_price}}</span>
                    <span v-show="product.specialDiscount == true" style="color:#000000;font-size:17px;text-decoration:line-through;margin-left:0px">&#8377;{{product.selling_price}}</span>
                        <span style="color:gray;text-decoration:line-through;margin-left:3px">Rs.{{ product.mrp_price }}</span>
                      </p>
                      <p class="mpzero" style="color:#616161">Size : {{ product.size }}</p>
                      <p class="mpzero" style="color:#616161">qty : {{ product.qty }}</p>
                     <p v-if="product.color!=null" class="mpzero" style="color:#616161">Color : {{ product.color }}</p>
                      <p class="mpzero" style="color:#616161">Store : {{ product.shop_name }}</p>
                    </f7-col>
                  </f7-row>
                    <hr/>
                  </template>
                  <div style="color:gray">
                    <f7-row>
                      <f7-col>
                      <p class="mpzero" style="padding-bottom:8px">Total MRP</p>
                      <p class="mpzero" style="padding-bottom:8px">Discount</p>
                      <p class="mpzero" style="padding-bottom:8px">Delivery Charges</p>
                      </f7-col>
                      <f7-col style="text-align:right">
                      <p class="mpzero" style="padding-bottom:8px">RS.{{total_mrp[index]}}</p>
                      <p class="mpzero" style="padding-bottom:8px;color:#FD6A02">- RS.{{discount[index]}}</p>
                      <p class="mpzero" style="padding-bottom:8px;color:#00E676">FREE</p>
                      </f7-col>
                    </f7-row>
                    <hr>
                    <f7-row style="color:rgb(97, 97, 97);font-weight:800">
                     <f7-col>
                     <p class="mpzero" style="padding-top:8px">Total</p>
                     <p class="mpzero" style="padding-top:8px">Wallet Money</p>
                     <p v-show="order.promocode=='SUPER30'" class="mpzero" style="padding-top:8px">Promocode Discount</p>
                     </f7-col>
                     <f7-col style="text-align:right">
                     <p class="mpzero" style="padding-top:8px">RS.{{total_selling[index]}}</p>
                     <p v-if="order.cashback!=null" class="mpzero" style="padding-top:8px">- RS.{{order.cashback}} </p>
                     <p v-else class="mpzero" style="padding-top:8px">RS.0 </p>
                     <p v-show="order.promocode=='SUPER30'" class="mpzero" style="padding-top:8px">- RS.{{promocode[index]}}</p>
                     </f7-col>
                    </f7-row>
                    <hr>
                    <f7-row style="color:rgb(97, 97, 97);font-weight:800">
                      <f7-col>
                        <p class="mpzero" style="padding-top:8px">Total</p>
                      </f7-col>
                      <f7-col style="text-align:right">
                        <p class="mpzero" style="padding-top:8px">RS.{{total_selling[index] - promocode[index] - order.cashback }}</p>
                      </f7-col>
                    </f7-row>
                  </div>
                </f7-block>
              </f7-card-content>
              <f7-card-footer v-if="order.order_status != 1">
                <h5 style="left:0px" class="mpzero">Delivering within 4 hours</h5>
                <f7-icon f7="time_fill" size="20px" color="red"></f7-icon>
              </f7-card-footer>
              <f7-card-footer v-if="order.order_status == 1">
                <h5 style="left:0px" class="mpzero">Delivered at {{order.completed_at}} </h5>
                <f7-icon f7="check_round_fill" size="20px" color="green"></f7-icon>
              </f7-card-footer>
            </f7-card>
          </f7-block>
        </template>
      </div>
    </div>

  </f7-page>
</template>

<script>
  import axios from '../axios2';
  import offline from 'v-offline';
export default {
  name: 'Hdorders',
  data() {
    return {
      title: 'Services Page',
      preloader:false,
      toast_msg:null,
      orders:[],
      internet:null,
      status:'not shown',
      page:1,
      showPreloader:true,
      allowInfinite:true,
      loadMoreData:[],
      error : false,
      mrp:[],
      selling:[],
      discount:[],
      total_mrp:[],
      cashback:[],
      promocode:[],
      total_selling:[],
      total_discount:[]
    };
  },
  mounted(){
    this.getOrders();
  },
    components: {
    offline
  },
  methods:{
    
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
      const self = this;
      if(!self.allowInfinite) return;
      self.allowInfinite = false;
      if(this.loadMoreData.length == 15)
      {
        console.log('load more call...');
        this.getOrders();
        self.allowInfinite = true;
        return true;
      }
      else{
        self.showPreloader = false;
      }
      console.log('no more product');
      return false;
    },
    deliveryTime:function(time){
      var d = new Date(time);
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
        new_time = 'Today ' + hr + ':00 PM';
      }
      return new_time;
    },
    getOrders:function () {
      var str = null;
      axios({
        method:'GET',
        url : 'user/ordersHistory/json',
        params:{
          'page' : this.page
        }
      }).then(response => {
        if(this.page == 1)
        {
          this.orders = response.data.result;
          this.loadMoreData = response.data.result;
          if(this.loadMoreData < 15)
          {
            this.showPreloader = false;
          }
          this.showPreloader = false;
        }
        else if(this.page > 1){
          this.loadMoreData = response.data.result;
          this.orders = this.orders.concat(this.loadMoreData);
        }
        else{
          this.page = 0;
        }
        if(this.orders.length<=0){
          this.error = true;
        }
        this.orders = this.orders.slice().reverse();
        console.log(this.orders);
        for(var i=0;i<this.orders.length;i++)
        {
          this.mrp=[];
          this.selling=[];
          var k = this.orders[i].order_id;
          axios({
          method:'GET',
            url : '/getOrderCashback/'+k
          }).then(response => {
              var a = response.data.result[0].cashback;
              //console.log(this.orders[i].order_id);
              console.log(a);
              str = str + a +',';
              console.log(str);
              this.cashback.push(a);
              //console.log(this.cashback[i]);  
          }).catch(function(error){
            if (error.response.data.message != undefined)
              console.log(error.response.data.message);
            else
              alert('system error found,please try again');
          });
          for(var j=0;j<this.orders[i].products.length;j++)
          {
            this.mrp[j]=Math.floor(this.orders[i].products[j].mrp_price);
          }
          this.total_mrp[i]=0;
          for(var a=0;a<this.orders[i].products.length;a++)
          {
            this.total_mrp[i]=this.total_mrp[i]+this.mrp[a];
          }
          for(var k=0;k<this.orders[i].products.length;k++)
          {
            this.selling[k]=Math.floor(this.orders[i].products[k].selling_price);
            if(this.orders[i].products[k].specialDiscount == true)
            {
              this.selling[k] = this.orders[i].products[k].specialDiscountedPrice;
            }
          }
          this.total_selling[i]=0;
          for(var b=0;b<this.orders[i].products.length;b++)
          {
            this.total_selling[i]=this.total_selling[i]+this.selling[b];
          }
          if(this.orders[i].promocode=='SUPER30')
          {

            this.promocode[i] = Math.floor((this.total_selling)*(30/100));
            if(this.promocode[i]>50)
              this.promocode[i] = 50;
            if(this.orders[i].promocode==null)
              this.promocode[i] = 0; 
          }
          else
          {
            this.promocode[i] = 0;
          }
          this.discount[i]=this.total_mrp[i]-this.total_selling[i];
        }

        this.cashback = this.cashback.slice().reverse();
        console.log(str);
        this.page++;
        this.preloader = false;
      }).catch(error => {
        if(error.response.data.message != undefined)
        {
          //alert('hi');
          //alert(error.response.data.message);
          this.getOrders();
        }
        else
          alert('application error found,please restart your app');
        this.preloader = false;
      });
    }
  }
};
</script>
