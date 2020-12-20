<template>

    <f7-page login-screen>
        <f7-link @click="$f7router.back()" icon-f7="icon-arrow_left" style="color:#BDBDBD;margin-left:30px;margin-top:25px" ></f7-link>
        <offline @detected-condition="handleConnectivityChange">
  </offline>

      <f7-block style="padding-top:0px;margin:0px">
          <div v-if="resetflag==false">
      <f7-login-screen-title style="margin:0px"><img style="width:100px" src="../assets/fashiostreet.png"></f7-login-screen-title>
      <!-- <h5 style="color:red;text-transform:uppercase"><center>{{mobileerror}}</center></h5>  -->
      <div v-if="flag==false">
      <f7-list form>
        <f7-list-item>
          <f7-label floating>Phone No</f7-label>
          <f7-input type="number" v-model="mobile" :value="mobile" @input="mobile = $event.target.value" clear-button></f7-input>
        </f7-list-item>
      </f7-list>
      <f7-list>
        <f7-list-item> <f7-button @click="send" style="width:100%;background-color:#273657;font-size:12px;font-weight:bold" fill :disabled="status">{{ btn_text }}</f7-button></f7-list-item>
      </f7-list>
      <center><a href="javascript:void(0)" @click="mobileerror = null"><h5 @click="flag=true">ALREADY HAVE OTP?</h5></a></center>
      </div>
      <div v-else>
           <center><h5 style="color:#7fff00">OTP SENT TO YOUR MOBILE NUMBER</h5></center>
       <f7-list form>
           <f7-list-item>
          <f7-label floating>OTP</f7-label>
          <f7-input type="number" value="" @input="otp = $event.target.value"  clear-button></f7-input>
        </f7-list-item>
        <f7-list-item>
          <a href="javascript:void(0)" @click="resendOTP">{{ resend_text }}</a>
          <p>{{ otp_text }}</p>
        </f7-list-item>
        <f7-list-item>
          <f7-label floating>Password</f7-label>
          <f7-input type="password" @input="password = $event.target.value" clear-button></f7-input>
        </f7-list-item>
      </f7-list>
      <f7-list>
        <f7-list-item> <f7-button @click="reset" style="width:100%;background-color:#273657;font-size:12px;font-weight:bold" fill >RESET PASSWORD</f7-button></f7-list-item>
      </f7-list>
      </div>
      </div>
      <div v-else>
          <f7-block style="padding-top:100px;margin:0px;text-align:center">
          <img style="width:100px;margin:0 auto" src="../assets/fashiostreet.png">
          <h3>PASSWORD RESET SUCCESSFUL</h3>
          <center><f7-icon f7="check_round_fill" size="40px" color="green"></f7-icon></center><br>
          <f7-button style="width:100%;background-color:#7fff00;font-size:12px;font-weight:bold" fill href="/login/">LOGIN</f7-button>
        </f7-block>
      </div>
      </f7-block>
    </f7-page>

</template>

<script>
import axios from '../axios';
import offline from 'v-offline';
import validate from '../packages/validation'
import F7ListItem from "framework7-vue/src/components/list-item";
export default {
  name: 'Forgotpass',
  components: {F7ListItem,offline},
  data() {
    return {
      title: 'Feedback Page',
      mobile:localStorage.getItem('loginmobile'),
      mobileerror:null,
      password:null,
      otp:null,
      flag:false,
      resetflag:false,
      status:false,
      status1:'not shown',
      otp_text:null,
      resend_text:'Resend OTP',
      btn_text:'NEXT',
      btn_text2:'RESET PASSWORD'
    };
  },
  methods:{
      handleConnectivityChange(status1) {
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
            url: 'api/auth/forgetpassword',
            data: {mobile: this.mobile}
          }).then(response => {
            this.resend_text = 'successfully otp send,click here to resend again';
            this.status = false;
            console.log("resend : " + response);
          }, (error) => {
            this.resend_text = 'successfully otp send,click here to resend again';
            console.log("resend error : " + error);
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
      send:function()
      {
        this.mobileerror=null;
        if(!validate.isEmpty(this.mobile))
        {
          if(!validate.length(this.mobile))
        {
          this.mobileerror="Invalid Number"
        }
        else
        {
          if(this.status == false) {
            this.btn_text = 'loading...';
            this.status = true;
            axios({
              method: 'POST',
              url: 'api/auth/completeForgetpassword_resendOTP',
              data: {mobile: this.mobile}
            }).then(response => {
              this.status = false;
              this.flag = true;
              this.btn_text = 'TRY AGAIN';
            }, (error) => {
              this.status = false;
              this.btn_text = 'TRY AGAIN';
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
        else
        {
          this.mobileerror="Fill the data"
        }
      },
      reset:function()
      {
        this.mobileerror = null;
        if(!validate.isEmpty(this.password))
        {
          if(!validate.lengthpass(this.password))
        {
          this.mobileerror="Invalid Password"
        }
        else {
            if (this.status == false) {
              this.status = true;
              this.btn_text2 = 'loading...';
              axios({
                method: 'POST',
                url: 'api/auth/completeForgetpassword',
                data: {mobile: this.mobile, code: this.otp, password: this.password}
              }).then(response => {
                this.btn_text2 = 'TRY AGAIN';
                this.status = false;
                this.resetflag = true;
              },(error) => {
                this.status = false;
                this.btn_text2 = 'TRY AGAIN';
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
        else
        {
          this.mobileerror="Fill the data"
        }
      },
  }
};
</script>
