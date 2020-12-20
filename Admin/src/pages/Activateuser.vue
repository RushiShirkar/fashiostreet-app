<template>

    <f7-page login-screen>
      <div v-if="flag==false">
        <f7-link @click="$f7router.back()" icon-f7="icon-arrow_left" style="color:#BDBDBD;margin-left:30px;margin-top:25px" ></f7-link>
      <f7-block style="padding-top:0px;margin:0px">
      <f7-login-screen-title style="margin:0px"><img style="width:100px" src="../assets/fashiostreet.png"></f7-login-screen-title>
            <offline @detected-condition="handleConnectivityChange">
  </offline>
      <h5 style="color:red;text-transform:uppercase">{{ mobileerror }}</h5>
      <f7-list form>
        <f7-list-item>
          <f7-label floating>Phone No</f7-label>
          <f7-input type="number" :value="mobile" @input="mobile = $event.target.value" clear-button></f7-input>
        </f7-list-item>
        <f7-list-item>
          <f7-label floating>OTP</f7-label>
          <f7-input type="number" @input="otp = $event.target.value"  clear-button></f7-input>
        </f7-list-item>
        <f7-list-item>
          <a href="javascript:void(0)" @click="resendOTP">{{ resend_text }}</a>
          <p>{{ otp_txt }}</p>
        </f7-list-item>
      </f7-list>
      <f7-list>
        <f7-list-item> <f7-button @click="login" style="width:100%;background-color:#273657;font-size:12px;font-weight:bold" fill login-screen-close :disabled="status">{{ btn_text }}</f7-button></f7-list-item>
      </f7-list>
      </f7-block>
      </div>
      <div v-else>
        <f7-block style="padding-top:100px;margin:0px;text-align:center">
          <img style="width:100px;margin:0 auto" src="../assets/fashiostreet.png">
          <h3>ACTIVATION SUCCESSFUL</h3>
          <center><f7-icon f7="check_round_fill" size="40px" color="green"></f7-icon></center><br>
         <f7-button style="width:100%;background-color:#273657;font-size:12px;font-weight:bold" fill href='/login/'>LOGIN</f7-button>
          <f7-block-footer><a href="/#">Skip</a></f7-block-footer>
        </f7-block>
      </div>
    </f7-page>

</template>

<script>
import offline from 'v-offline';

import { f7Navbar, f7Page, f7Block, f7Button } from 'framework7-vue';
import axios from '../axios';
import validate from '../packages/validation'
import F7ListItem from "framework7-vue/src/components/list-item";
export default {
  name: 'Login',
  components: {F7ListItem},
  data() {
    return {
      title: 'Feedback Page',
      mobile:localStorage.getItem('mobile'),
      mobileerror:null,
      otp:null,
      internet:null,
      btn_text:'ACTIVATE',
      flag:false,
      status:false,
      status1:'not shown',
      resend_text:'resend OTP',
      otp_txt:null
    };
  },
  components: {
    offline
  },
  mounted()
  {
    FB.init({
      appId: "2141628305957160",
      version: 'v3.1'
    });
  },
  methods:{handleConnectivityChange(status1) {
      this.internet = status1;
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
    logCompleteRegistrationEvent(registrationMethod) {
      var params = {};
      params[FB.AppEvents.ParameterNames.REGISTRATION_METHOD] = registrationMethod;
      FB.AppEvents.logEvent(FB.AppEvents.EventNames.COMPLETED_REGISTRATION, null, params);
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

      if(this.status1 == 'notshown')
      {
      this.popupOpened = true;

      this.status1 = 'shown';

      }
    },
    resendOTP:function(){
      this.mobileerror = null;
      if(this.status == false) {
        this.resend_text = 'loading...';
        this.status = true;
        axios({
          method: 'POST',
          url: 'api/auth/completeRegister_ResendOTP',
          data: {mobile: this.mobile}
        }).then(response => {
          this.resend_text = 'successfully otp send,click here to resend again';
          this.status = false;
        }, (error) => {
          this.resend_text = 'fail resend otp,click here to resend again';
          this.status = false;
          if (error.response.data.message != undefined) {
            this.mobileerror = error.response.data.message;
          }
          else {
            alert('connection error found,please retry again');
          }
        });
      }
    },
      login:function()
      {
        this.logCompleteRegistrationEvent('signup');
          /*axios({
            method: 'POST',
            url: '/user/addUserWallet/'+localStorage.getItem('mobile')
          }).then(response => {
            console.log(response.data);
          },(error) => {
            if (error.response.data.message != undefined) {
                this.mobileerror = error.response.data.message;
              }
              else {
                alert('connection error found,please retry again');
              }
          });*/
          this.mobileerror=null;
          if(this.status == false) {
            this.status = true;
            this.btn_text = 'loading...'
            axios({
              method: 'POST',
              url: '/api/auth/completeRegister',
              data: {mobile: this.mobile, code: this.otp}
            }).then(response => {
              this.flag = true;
              this.status = false;
              this.btn_text = 'ACTIVATE';
            }, (error) => {
              this.btn_text = 'TRY AGAIN';
              this.status = false;
              if (error.response.data.message != undefined) {
                this.mobileerror = error.response.data.message;
              }
              else {
                alert('connection error found,please retry again');
              }
            });
          }
      }
  }
};
</script>
