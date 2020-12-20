<template>
  <f7-page name="account" style="text-align:center;padding-bottom:75px">
    <f7-navbar class="bgnav" style="border-radius:0px 0px 30px 0px;box-shadow: 5px 0px 10px rgba(0, 0, 0, 0.12)" sliding>
     <f7-nav-left>
        <f7-link icon-f7="icon-arrow_left" style="padding:21px" @click="$f7router.back()"></f7-link>
      </f7-nav-left>
      <f7-nav-title style="font-size:18px;font-weight:bold;margin:0px">
        Your Account
      </f7-nav-title>
    </f7-navbar>
      <offline @detected-condition="handleConnectivityChange">
  </offline>
    <!-- Scrollable page content-->
    <f7-block style="margin:0px;margin-top:-40px;padding:70px 50px 20px 50px;height:300px;background-image: linear-gradient(to right, #7F7FD5, #91EAE4)">
      <f7-block style="border-radius:50%;padding:0px;margin:0px auto 20px auto; height:150px;width:150px; background-color:white">
     <f7-icon f7="icon-person" style="font-size:150px"></f7-icon>
      <!-- <f7-button style="border-radius:50%;width:25px;height:50px;position:absolute;right:0px;bottom:0px;background-color:black"></f7-button> -->
    </f7-block>
    <h3 class="mpzero" style="color:#FFFFFF;font-size:20px" v-if="name!=null">Hello {{name}}</h3>
    <h3 class="mpzero" style="color:#FFFFFF;font-size:20px" v-else>Hello User</h3>
    </f7-block>
    <f7-block style="margin:0px">
     <f7-list style="margin:0px">
        <f7-list-item link="/hdorders/" style="padding:8px 0px">
                <div slot="media" style="height:30px">
                  <img src="../assets/delivery_icon.png" style="width:30px;height:30px;border-radius:50%" alt="Delivery Orders">
                </div>
                <div style="font-weight:bold;color:#000000;font-size:18px" class="mpzero">&nbsp Hd Orders</div>
        </f7-list-item>
        <f7-list-item link="/wishlist/" style="padding:8px 0px">
                <div slot="media" style="height:30px">
                  <img src="../assets/wishlist_icon.png" style="width:30px;height:30px;border-radius:50%" alt="Wishlist">
                </div>
                <div style="font-weight:bold;color:#000000;font-size:18px" class="mpzero">&nbsp Your Liked Items</div>
        </f7-list-item>
        <f7-list-item link="/address/" style="padding:8px 0px">
                <div slot="media" style="height:30px">
                  <img src="../assets/address_icon.png" style="width:30px;height:30px;border-radius:50%" alt="User Address">
                </div>
                <div style="font-weight:bold;color:#000000;font-size:18px" class="mpzero">&nbsp Your Address</div>
        </f7-list-item>
        <f7-list-item link="/profile/" style="padding:8px 0px">
          <div slot="media" style="height:30px">
            <img src="../assets/account_icon.png" style="width:30px;height:30px;border-radius:50%" alt="Profile">
          </div>
          <div style="font-weight:bold;color:#000000;font-size:18px" class="mpzero">&nbsp Profile Details</div>
        </f7-list-item>
  <!-- <f7-list-item title="SETTINGS" style="font-size:13px" link="/settings/"></f7-list-item> -->
</f7-list>
</f7-block>
  <div style="position:fixed;bottom:0;z-index:999;width:100%;background-color:#FFFFFF;box-shadow: 5px 0px 10px rgba(0, 0, 0, 0.12);border-radius:30px 30px 0px 0px">
    <f7-button href="/home" @click="logout" outline big style="font-size:18px;font-weight:bold;text-transform:capitalize;border:1px solid #1d2671;color:#1d2671;margin:10px;border-radius:30px">Logout</f7-button>
  </div>
  </f7-page>
</template>

<script>
import offline from 'v-offline';
import axios from '../axios';
export default {
  name: 'Account',
  data() {
    return {
      title: 'About Page',
      internet:null,
      mobile:localStorage.getItem('loginmobile'),
      name:null,
      gender:null,
      status:'not shown',
      money : null
    };
  },
  components: {
    offline
  },
  mounted(){
    axios({
      method:'GET',
        url : 'user/profile/json'
      }).then(response => {
        this.name=response.data.result[0].name;
        this.gender=response.data.result[0].gender;
        if(response.data.result[0].mobile != localStorage.getItem('loginmobile'))
        {
          localStorage.setItem('loginmobile',response.data.result[0].mobile);
        }
      this.preloader = false;
      }).catch(function(error){
      if (error.response.data.message != undefined)
        console.log(error.response.data.message);
      else
        alert('system error found,please try again');
      this.preloader = false;
      });
      this.getMoney();
    },
  methods:
  {
    logout:function()
    {
      localStorage.removeItem('local_id');
      localStorage.removeItem('token');
      localStorage.removeItem('loginmobile');
      //location.reload();
    },
    getMoney()
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
    }
  }
};
</script>
<style scoped>
.md .navbar:after{
  content:none
}
</style>
