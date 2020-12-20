<template>
  <f7-page name="account" class="bgpage" style="text-align:center;background-color:white">
    <f7-navbar class="bgnav" sliding>
     <f7-nav-left>
        <f7-link icon-f7="icon-arrow_left" @click="$f7router.back()"></f7-link>
      </f7-nav-left>
      <f7-nav-title style="font-size:15px;margin:0px">
        ACCOUNT
      </f7-nav-title>
    </f7-navbar>
      <offline @detected-condition="handleConnectivityChange">
  </offline>
    <!-- Scrollable page content-->
    <f7-block style="margin:0px;padding:30px;height:260px;background-color:#E0E0E0">
      <f7-block style="border-radius:50%;padding:0px;margin-top:0px;margin-left: auto; margin-right: auto; height:150px;width:150px; background-color:white">
     <f7-icon f7="icon-person" style="font-size:150px"></f7-icon>
      <!-- <f7-button style="border-radius:50%;width:25px;height:50px;position:absolute;right:0px;bottom:0px;background-color:black"></f7-button> -->
    </f7-block>
    <h3 class="mpzero" style="color:#424242" v-if="name!=null">Hello {{name}}</h3>
    <h3 class="mpzero" style="color:#424242" v-else>Hello User</h3>
    </f7-block>
    <f7-block style="margin:0px">
     <f7-list style="margin:20px 0px">
  <f7-list-item title="HD ORDERS" style="font-size:13px" link="/hdorders/"></f7-list-item>
  <f7-list-item title="WISHLIST" style="font-size:13px" link="/wishlist/"></f7-list-item>
  <f7-list-item title="ADDRESS" style="font-size:13px" link="/address/"></f7-list-item>
  <f7-list-item title="PROFILE DETAILS" style="font-size:13px" link="/profile/"></f7-list-item>
  <!-- <f7-list-item title="SETTINGS" style="font-size:13px" link="/settings/"></f7-list-item> -->
</f7-list>
</f7-block>
<f7-block style="margin:0px;padding-bottom:15px">
<f7-button href="/#" @click="logout" style="font-size:12px;font-weight:bold" outline color="red">LOGOUT</f7-button>
</f7-block>
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
      location.reload();
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
