<template>
  <f7-page class="bgpage"  style="padding-bottom:45px">
    <offline @detected-condition="handleConnectivityChange"></offline>
    <f7-navbar back-link="Back" class="bgnav" sliding>
      <f7-nav-title style="font-size:15px;margin:0px;text-transform:uppercase">SCAN FS QR CODE FROM SHOP</f7-nav-title>
    </f7-navbar>
    <center><h3 style ="font-size:20px;padding-left:16px">Visit Shop Discount</h3></center>
    <f7-button @click="scan" fill style="background-color:#00E676;line-height:50px;height:50px;font-size:14px;font-weight:750;border-radius:5px;margin:0px 15px">
      Scan Me
    </f7-button>
        <p v-if="decodedContent!=''">Last result: <b>{{ decodedContent }}</b></p>
    <p  v-if="errorMessage!=''" class="error">{{ errorMessage }}</p>
    <qrcode-stream v-if="check" @decode="onDecode" @init="onInit"></qrcode-stream>
    <f7-list form style="margin:5px 0px 0px 0px;padding-bottom:93px">
      <f7-list-item>
        <h5 style="color:red;text-transform:uppercase;margin:0px">{{moneyerror}}</h5>
        <f7-label floating>Enter Money:</f7-label>
        <f7-input type="text" @input="money = $event.target.value"  clear-button></f7-input>
      </f7-list-item>
    </f7-list>
    <f7-button @click="getDiscount" href="/wallet" fill style="font-size:15px;font-weight:50;border-radius:0px;background-color:#00E676;height:8%;line-height:45px;">Get Discount<f7-icon f7="chevron_right" style="margin:-5px 0px 0px 10px"></f7-icon></f7-button>
  </f7-page>
</template>

<script>
import offline from 'v-offline';
import axios from '../axios';
export default {
  name: 'Discount',
  data() {
    return {
      internet:null,
      status:'not shown',
      decodedContent: '',
      errorMessage: '',
      check:true,
      money:null,
      moneyerror:null,
      wallet:null
    }
  },
  components:{
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
    getDiscount(){
      var total = 0;
      if(this.money==null && this.money=="")
      {
        this.moneyerror = 'Enter Money';
      }
      else
      {
        axios({
        method:'GET',
          url : 'checkShop/'+this.decodedContent
        }).then(response => {
            var a = response.data.result;
            console.log(a);
            if(response.data.result=='successs')
            {
              axios({
              method:'GET',
                url : 'user/getMoney/'+localStorage.getItem('loginmobile')
              }).then(response => {
                  this.wallet = response.data.result[0].money; 
                  this.wallet = parseInt(this.wallet,10);
                   console.log(this.wallet); 
                   this.money = parseInt(this.money,10);
                   this.money = (5*this.money)/100;
                  total = this.money + this.wallet;
                  console.log(total);
                  axios({
                  method:'POST',
                  url: '/updateCustomerWallet',
                  data: {
                    'mobile':localStorage.getItem('loginmobile'),
                    'money':total
                  }
                }).then(response => {
                    console.log(response);

                }).catch(error => {
                    console.log(error.response.data.message);
                });
              }).catch(function(error){
                if (error.response.data.message != undefined)
                  console.log(error.response.data.message);
                else
                  alert('system error found,please try again');
              });
            }
            else
            {
              console.log('no');
            }
        }).catch(function(error){
          if (error.response.data.message != undefined)
            console.log(error.response.data.message);
          else
            alert('system error found,please try again');
        });
      }
    },
    onDecode (content) {
      this.decodedContent = content;
      if(this.decodedContent!='')
      {
        this.check = false;
      }
    },
    scan(){
      this.check = true;
    },
    onInit (promise) {
      promise.then(() => {
        console.log('Successfully initilized! Ready for scanning now!');
      })
      .catch(error => {
        if (error.name === 'NotAllowedError') {
          this.errorMessage = 'Hey! I need access to your camera';
        } else if (error.name === 'NotFoundError') {
          this.errorMessage = 'Do you even have a camera on your device?';
        } else if (error.name === 'NotSupportedError') {
          this.errorMessage = 'Seems like this page is served in non-secure context (HTTPS, localhost or file://)';
        } else if (error.name === 'NotReadableError') {
          this.errorMessage = 'Couldn\'t access your camera. Is it already in use?';
        } else if (error.name === 'OverconstrainedError') {
          this.errorMessage = 'Constraints don\'t match any installed camera. Did you asked for the front camera although there is none?';
        } else {
          this.errorMessage = 'UNKNOWN ERROR: ' + error.message;
        }
      })
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
    }
  }
};
</script>

<style scoped>

</style>
