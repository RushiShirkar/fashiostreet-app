<template>

    <f7-page login-screen>
      <div v-if="flag==false">
        <f7-link @click="$f7router.back()" icon-f7="icon-arrow_left" style="color:#BDBDBD;margin-left:30px;margin-top:25px" ></f7-link>
      <f7-block style="padding-top:0px;margin:0px">
      <f7-login-screen-title style="margin:0px"><img style="width:100px" src="../assets/fashiostreet.png"></f7-login-screen-title>
            <offline @detected-condition="handleConnectivityChange">
  </offline>
      <h5 style="color:red;text-transform:uppercase">{{mobileerror}}</h5>
      <f7-list form>
        <f7-list-item>
          <f7-label floating>Phone No</f7-label>
          <f7-input type="number" @input="mobile = $event.target.value" clear-button></f7-input>
        </f7-list-item>
        <f7-list-item>
          <f7-label floating>Password</f7-label>
          <f7-input type="password" @input="password = $event.target.value"  clear-button></f7-input>
        </f7-list-item>
      </f7-list>
      <f7-list>
        <f7-list-item> <f7-button @click="login" style="width:100%;background-color:#273657" fill big login-screen-close :disabled="status">{{ btn_text }}</f7-button></f7-list-item>
        <f7-block-footer><f7-link href="/forgetpass/" style="color:#273657;margin-right:5px"><h5> FORGOT PASSWORD? </h5></f7-link> | <f7-link href="/activateuser/" style="color:#273657;margin-left:5px"> <h5 class="mpzero"> ACTIVATE ACCOUNT </h5></f7-link></f7-block-footer>
        <f7-block-footer>New to Fashiostreet?<span><f7-link style="color:green;padding:5px" href="/signup/">Signup</f7-link> </span></f7-block-footer>
      </f7-list>
      </f7-block>
      </div>
      <div v-else>
        <f7-block style="padding-top:100px;margin:0px;text-align:center">
          <img style="width:100px;margin:0 auto" src="../assets/fashiostreet.png">
          <h3>LOGIN SUCCESSFUL</h3>
          <center><f7-icon f7="check_round_fill" size="40px" color="green"></f7-icon></center><br>
          <f7-button  style="width:100%;background-color:#273657;font-size:12px;font-weight:bold" fill @click="restartPage">Continue to Shopping</f7-button>
        </f7-block>
      </div>
    </f7-page>

</template>

<script>
import axios from '../axios';
import validate from '../packages/validation'
import offline from 'v-offline';
export default {
  name: 'Login',
  data() {
    return {
      title: 'Feedback Page',
      btn_text:'LOGIN',
      mobile:null,
      mobileerror:null,
      internet:null,
      password:null,
      flag:false,
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
    restartPage:function(){
      console.log('windows return');
      location.reload();
    },
      login:function()
      {
        this.mobileerror = null;
        this.btn_text = 'loading...';
        if(this.status == false) {
          this.status = true;
          if (!validate.isEmpty(this.mobile) && !validate.isEmpty(this.password)) {
            if (!validate.length(this.mobile) && !validate.lengthpass(this.password)) {
              this.mobileerror = "Invalid Number or Password"
            }
            else {

              this.mobileerror = null
              axios({
                method: 'POST',
                url: 'api/auth/login',
                data: {mobile: this.mobile, password: this.password}
              }).then(response => {
                console.log(response);
                this.btn_text = 'TRY AGAIN';
                localStorage.setItem('loginmobile', this.mobile);
                localStorage.setItem('token', response.data.result.token);
                localStorage.setItem('local_id', response.data.result.local_id);
                this.flag = true;
              },(error) => {
                this.status = false;
                this.btn_text = 'TRY AGAIN';
                if (error.response.data.message != undefined)
                {
                  this.mobileerror = error.response.data.message;
                }
                else
                {
                  alert('connection error found,please retry again');
                }
                localStorage.setItem('mobile', this.mobile);
              });
            }
          }
          else {
            this.mobileerror = "Fill the data"
          }
        }
      },
  }
};
</script>
