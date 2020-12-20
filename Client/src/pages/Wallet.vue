<template>
	<f7-page name="account" style="text-align:center">
		<f7-navbar class="bgnav" style="border-radius:0px 0px 30px 0px;box-shadow: 5px 0px 10px rgba(0, 0, 0, 0.12)" sliding>
     		<f7-nav-left>
        		<f7-link icon-f7="icon-arrow_left" style="padding:21px" @click="$f7router.back()"></f7-link>
      		</f7-nav-left>
      		<f7-nav-title style="font-size:18px;font-weight:bold;margin:0px">FS Wallet</f7-nav-title>
      <!--<f7-nav-right>
      			<f7-link style="padding:0 10px;font-size:15px" @click="save" href="/discount"><img src="../assets/qr-code.svg" alt="">&nbsp Scan FS QR Code</f7-link>
    		  </f7-nav-right> -->
    	</f7-navbar>
      	<offline @detected-condition="handleConnectivityChange"></offline>
      	<f7-block style="position:fixed;top:16px;z-index:999;width:100%;height:240px;margin:0px;padding:0px;background-image: linear-gradient(to right, #4568DC, #B06AB3)">
	      	<div style="color:#FFFFFF;font-size:24px;padding-top:85px">
	      		₹ <span style="color:#FFFFFF;font-size:44px">{{money}}</span>
	      		<p style="margin:0px;font-size:18px">Your Wallet Amount</p>
	      	</div>
      	</f7-block>
      	<div style="margin:216px 16px 20px 16px;width:90%;box-shadow:0px 1px 6px 0px rgba(0, 0, 0, 0.1);border-radius:4px">
          <f7-card style="padding-bottom:2px;width:100%;-webkit-box-shadow: none;box-shadow: none;border-radius:4px">
          <f7-row no-gap style="padding:8px">
           <f7-col width="25" style="padding-top:4px">
             <img src="../assets/scooter.svg" alt="">
           </f7-col>
           <f7-col width="75" style="padding-left:10px">
             <h4 style="font-weight:bold;color:#000000;font-size:16px;text-align:left" class="mpzero">Order Home Delivery & Get 5% Cashback</h4>
             <h5 style="color:#595959;font-size:13px;text-align:left;margin:0px">Place home delivery from Fashiostreet & get cashback</h5>
           </f7-col>
          </f7-row>
        </f7-card>
      </div>
      <span style="font-size:28px;font-weight:800;border: 1px solid #000000;border-radius:5px;padding:5px 10px;color:#595959">OR</span>
      <div style="margin:16px;margin-top:20px;width:90%;box-shadow:0px 1px 6px 0px rgba(0, 0, 0, 0.1);border-radius:4px">
        <f7-card style="padding-bottom:2px;width:100%;-webkit-box-shadow: none;box-shadow: none;border-radius:4px">
          <f7-row no-gap style="padding:8px">
           <f7-col width="25" style="padding-top:4px">
             <img src="../assets/store.svg" alt="">
             <p style="font-size:12px;margin:0px;color:green">Coming Soon</p>
           </f7-col>
           <f7-col width="75" style="padding-left:10px">
             <h4 style="font-weight:bold;color:#000000;font-size:16px;text-align:left" class="mpzero">Get 7% Cashback On Bill Amount During Shop Visit</h4>
             <h5 style="color:#595959;font-size:13px;text-align:left;margin:0px">Just scan FS QR Code from shop to get cashback on bill amount</h5>
           </f7-col>
          </f7-row>
        </f7-card>
      </div>
      <div style="margin:16px;margin-top:20px;width:90%;box-shadow:0px 1px 6px 0px rgba(0, 0, 0, 0.1);border-radius:4px">
        <f7-card style="padding-bottom:2px;width:100%;-webkit-box-shadow: none;box-shadow: none;border-radius:4px">
          <f7-row no-gap style="padding:8px;color:green">
           <f7-col width="10" style="padding-top:4px">
             <f7-icon f7="info"></f7-icon>
           </f7-col>
           <f7-col width="90" style="padding-left:10px">
             <h5 style="font-size:14px;text-align:left;margin:0px">Cashback will be added to your wallet & you can use your wallet money for next shopping.</h5>
           </f7-col>
          </f7-row>
        </f7-card>
      </div>
      <!--<div style="margin:16px;margin-top:20px;width:90%;box-shadow:0px 1px 6px 0px rgba(0, 0, 0, 0.1);border-radius:4px">
        <f7-card style="padding-bottom:2px;width:100%;-webkit-box-shadow: none;box-shadow: none;border-radius:4px">
          <f7-row no-gap style="padding:8px;color:green">
           <f7-col width="10" style="padding-top:4px">
             <f7-icon f7="info"></f7-icon>
           </f7-col>
           <f7-col width="90" style="padding-left:10px">
             <h5 style="font-size:14px;text-align:left;margin:0px">You can also use your Wallet money when you visit shop.</h5>
           </f7-col>
          </f7-row>
        </f7-card>
      </div>-->
	</f7-page>
</template>

<script>
import offline from 'v-offline';
import axios from '../axios';
export default 
{
	name: 'Wallet',
  	data() {
    	return {
    		internet:null,
      		status:'not shown',
      		money:null,
          mobile:null
    	}
    },
    components:{
    	offline
    },
    mounted(){
    	this.getmoney();
    },
    methods:{
    	save(){
    		localStorage.setItem('scan','hi');
    		//alert('hi');
    	},
    	getmoney()
    	{
    		axios({
		      method:'GET',
		        url : 'user/getMoney/'+localStorage.getItem('loginmobile')
		    }).then(response => {
		          console.log(response.data.result);
		          this.money = response.data.result[0].money;  
		    }).catch(function(error){
		        if (error.response.data.message != undefined)
		          console.log(error.response.data.message);
		        else
		          alert('system error found,please try again');
		    });
    	},
    	handleConnectivityChange(status) 
    	{
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
	    showNotificationWithButton() 
	    {
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
.md .navbar:after{
  content:none
}
</style>