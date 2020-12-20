<template>
  <f7-page class="bgpage" name="profile" style="background-color:white">
    <div v-if="toast_msg != null" class="custom_toast z-depth-3">
      {{ toast_msg }}
    </div>
    <f7-navbar class="bgnav" back-link="Back" sliding>
      <f7-nav-title style="font-size:15px;margin:0px">
        PROFILE
      </f7-nav-title>
    </f7-navbar>
          <offline @detected-condition="handleConnectivityChange">
  </offline>
    <f7-block>
      <f7-block style="border-radius:50%;padding:0px;margin-top:0px;margin-left: auto; margin-right: auto; height:150px;width:150px; background-color:white">
      <f7-icon f7="icon-person" style="font-size:150px"></f7-icon>
      <!-- <f7-button style="border-radius:50%;width:25px;height:50px;position:absolute;right:0px;bottom:0px;background-color:black"></f7-button> -->
    </f7-block>
    </f7-block>
    <f7-block style="margin-bottom:15px">

      <center>
        <div v-if="preloader" class="preloader">
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
  <f7-list no-hairlines-md>
  <f7-list-item>
    <f7-label>Name</f7-label>
    <f7-input :value="name" @input="name = $event.target.value" type="text" placeholder="Enter Name" clear-button></f7-input>
    </f7-list-item>
  <f7-list-item>
    <label>Gender</label>
     <f7-list style="margin:0px">
       <label class="item-content item-radio"><input value="male" v-model="gender" name="gender-radio" type="radio"><i class="icon icon-radio"></i><div class="item-inner"><div class="item-title">Male</div></div></label>
       <label class="item-content item-radio"><input value="female" v-model="gender" name="gender-radio" type="radio"><i class="icon icon-radio"></i><div class="item-inner"><div class="item-title">Female</div></div></label>
    </f7-list>
    </f7-list-item>
     <f7-list-item>
       <f7-label>Mobile No</f7-label>
    <f7-input disabled type="text" :value="mobile"></f7-input>
    </f7-list-item>
</f7-list>
  <f7-button href="/forgetpass/" style="font-size:12px;font-weight:bold" outline color="green">CHANGE PASSWORD</f7-button>
  </div>
  </f7-block>
    <f7-button v-if="!preloader" style="font-size:12px;font-weight:bold;border-radius:0px;position:absolute;bottom:0;width:100%" @click="saveProfile" fill color="gray">SAVE CHANGES</f7-button>
  </f7-page>
</template>

<script>
import offline from 'v-offline';
import axios from '../axios'
export default {
  name: 'Profile',
  data() {
    return {
      title: 'Another Page',
      mobile:localStorage.getItem('loginmobile'),
      name:null,
      gender:null,
      mflag:false,
      fflag:false,
      internet:null,
      status:'not shown',
      preloader:false,
      toast_msg:null,
    };
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
    saveProfile:function(){
      this.preloader = true;
      axios({
        method:'POST',
        url : 'user/updateProfile',
        data:{
          'name' : this.name,
          'gender' : this.gender
        }
      }).then(response => {
        this.toast_msg = 'profile successfully updated';
        setTimeout(() => {
          this.toast_msg = null;
        },2000);
        this.preloader = false;
      }).catch(error => {
        if(error.response.data.message != undefined)
          alert(error.response.data.message);
        else
          alert('failed to save profile data');
        this.preloader = false;
      });
    }
  },
  mounted()
  {
    this.preloader = true;
    axios({
      method:'GET',
        url : 'user/profile/json'
      }).then(response => {
        this.name=response.data.result[0].name;
        this.gender=response.data.result[0].gender;
        /*if(response.data.result[0].mobile != localStorage.getItem('loginmobile'))
        {
          localStorage.setItem('loginmobile',response.data.result[0].mobile);
        }*/
        localStorage.setItem('loginmobile',response.data.result[0].mobile);
        this.preloader = false;
      }).catch(function(error){
      if (error.response.data.message != undefined)
      {
        console.log(error.response.data.message);
      }
      else
      {
        alert('system error found,please try again');
        this.preloader = false;
      }
      });
  }
};
</script>
