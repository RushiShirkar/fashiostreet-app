<template>
       <f7-page login-screen>
         <div v-if="flag==false">
        <f7-link icon-f7="icon-arrow_left" style="color:#BDBDBD;margin-left:30px;margin-top:25px" @click="$f7router.back()"></f7-link>
       <f7-block style="padding-top:0px;margin:0px">
      <f7-login-screen-title style="margin:0px"><img style="width:100px" src="../assets/fashiostreet.png"></f7-login-screen-title>
      <f7-block-footer> <h4> CREATE ACCOUNT </h4></f7-block-footer>
            <offline @detected-condition="handleConnectivityChange">
  </offline>
      <h5 v-if="mobileerror" style="color:red;text-transform:uppercase">{{ mobileerror }}</h5>
      <f7-list form>
        <f7-list-item>
          <f7-label floating>Phone No</f7-label>
          <f7-input type="number" @input="mobile = $event.target.value" clear-button></f7-input>
        </f7-list-item>
        <f7-list-item>
          <f7-label floating>Password</f7-label>
          <f7-input type="password" @input="password = $event.target.value"  clear-button></f7-input>
        </f7-list-item>
        <f7-list-item>
          <f7-label floating>Confirm Password</f7-label>
          <f7-input type="password" @input="confirmpassword = $event.target.value"  clear-button></f7-input>
        </f7-list-item>
      </f7-list>
      <f7-list>
<f7-list-item> <f7-button @click="signin" style="width:100%;background-color:#273657;font-size:12px;font-weight:bold" fill login-screen-close :disabled="status">{{ btn_name }}</f7-button></f7-list-item>
        <!-- <f7-block-footer>Already have an account <span><f7-link style="color:#7fff00" popup-close>Login</f7-link></span> now </f7-block-footer> -->
      </f7-list>
     </f7-block>
         </div>
     <div v-else>
        <f7-block style="padding-top:100px;margin:0px;text-align:center">
          <img style="width:100px;margin:0 auto" src="../assets/fashiostreet.png">
          <h3>REGISTRATION SUCCESSFUL</h3>
          <center><f7-icon f7="check_round_fill" size="40px" color="green"></f7-icon></center><br>
          <f7-button style="width:100%;background-color:#7fff00;font-size:12px;font-weight:bold" fill href='/activateuser/'>ACTIVATE ACCOUNT</f7-button>
          <f7-block-footer><a href="/#">Skip</a></f7-block-footer>
        </f7-block>
      </div>
     </f7-page>

</template>

<script>
import validate from '../packages/validation'
import offline from 'v-offline';
import axios from '../axios';
export default {
  name: 'Signup',
  data() {
    return {
      title: 'Feedback Page',
       mobile:null,
      mobileerror:null,
      password:null,
      internet:null,
      confirmpassword:null,
      flag:false,
      btn_name:'NEXT',
      status:false,
      status1:'not shown'
    };
  },
  components: {
    offline
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
      signin:function() {
        this.mobileerror = null;
        if (this.status == false) {
          this.status = true;
          this.btn_name = 'loading...';
          if (!validate.isEmpty(this.mobile) && !validate.isEmpty(this.password)) {
            if (validate.length(this.mobile) && validate.lengthpass(this.password)) {
              if (this.password == this.confirmpassword) {
                this.mobileerror = null
                axios({
                  method: 'POST',
                  url: 'api/auth/register',
                  data: {mobile: this.mobile, password: this.password}
                }).then(response => {
                  localStorage.setItem('mobile', this.mobile);
                  this.flag = true;
                  this.status = false;
                  this.btn_name = 'TRY AGAIN';
                }, (error) => {
                  this.status = false;
                  this.btn_name = 'TRY AGAIN';
                  if (error.response.data.message != undefined)
                  {
                    this.mobileerror = error.response.data.message;
                  }
                  else
                  {
                    alert('connection error found,please retry again');
                  }
                });
              }
              else {
                this.status = false;
                this.mobileerror = "Password doesn't match";
              }
            }
            else {
              this.status = false;
              this.mobileerror = "Invalid Number or Password";
            }
          }
          else {
            this.status = false;
            this.mobileerror = "Fill the data";
          }
        }
      },
  }
};
</script>
