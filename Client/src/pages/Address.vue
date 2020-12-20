<template>
  <f7-page name="address" style="padding-bottom:50px">
    <div v-if="toast_msg != null" class="custom_toast z-depth-3">
      {{ toast_msg }}
    </div>
    <f7-navbar class="bgnav" back-link="Back" style="border-radius:0px 0px 30px 0px;box-shadow: 5px 0px 10px rgba(0, 0, 0, 0.12)" sliding>
      <f7-nav-title style="font-size:18px;font-weight:bold;margin:0px">
        Your Address
      </f7-nav-title>
    </f7-navbar>
    <offline @detected-condition="handleConnectivityChange">
  </offline>
    <f7-block style="margin:0px;padding:16px;background-color:#FFFFFF">
      <f7-block-title style="margin:0px 0px 16px;font-size:18px;font-weight:bold;color:#000000">
        <p class="mpzero"><img src="../assets/address_icon.png" style="width:30px;height:30px;border-radius:50%;vertical-align:middle" alt="User Address">&nbsp Address</p>
      </f7-block-title>
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
      <template v-if= "!preloader" v-for="result in address">
        <f7-card style="margin: 0px; width: 100%;-webkit-box-shadow:none;box-shadow:none;border-radius:4px;border:1px solid gray;margin:16px 0px">
            <f7-card-content style="margin:0px;padding:10px;color:gray">
              <h4 class="mpzero" style="color:#000000;font-size:16px">Name : {{result.first_name}} {{result.last_name}}</h4>
              <h5 class="mpzero" style="font-size:14px">Detail Address : {{result.address}}</h5>
              <h5 class="mpzero" style="font-size:14px">Area : {{result.area}}</h5>
              <h5 class="mpzero" style="font-size:14px">Mobile : {{result.mobile}}</h5>
            </f7-card-content>
            <f7-card-footer>
            <f7-segmented style="width:100%">
              <f7-button popup-open =".editadd" @click="editaddForm(result)" color="green" style="font-size:16px;font-weight:bold;text-transform:capitalize">Edit</f7-button>
              <f7-button @click="deleteadd(result.id)" color="red" style="font-size:16px;font-weight:bold;text-transform:capitalize">Delete</f7-button>
            </f7-segmented>
            </f7-card-footer>
        </f7-card>
      </template>
    </f7-block>
    <div style="position:fixed;bottom:0;z-index:999;width:100%;background-color:#FFFFFF;box-shadow: 5px 0px 10px rgba(0, 0, 0, 0.12);border-radius:30px 30px 0px 0px">
        <f7-button popup-open =".editadd" @click="addnewBtn" big fill style="background-image: linear-gradient(to right, #11998e, #38ef7d);color:#FFFFFF;font-size:18px;font-weight:bold;border:0px;text-transform:Capitalize;margin:10px;border-radius:30px">+ Add New Address</f7-button>
    </div>

        <f7-popup class="editadd">
            <f7-navbar class="bgnav" style="border-radius:0px 0px 30px 0px;box-shadow: 5px 0px 10px rgba(0, 0, 0, 0.12)" sliding>
                <f7-nav-left>
                            <f7-link icon-f7="icon-close" popup-close></f7-link>
                </f7-nav-left>
      <f7-nav-title style="font-size:18px;font-weight:bold;;margin:0px">
        {{title}}
      </f7-nav-title>
    </f7-navbar>
    <!-- <f7-block-title style="margin-top:15px"><h5 class="mpzero">{{title}}</h5></f7-block-title> -->
    <f7-block style="padding:0px;margin:0px">
<f7-list no-hairlines-md form style="padding:0px;margin:0px">
  <f7-list-item>
    <div class="row">
      <div class="col">
        <f7-label floating for="firstname">First Name</f7-label>
        <f7-input type="text" v-bind:id="firstname" @input="fname = $event.target.value" :value="fname" placeholder="First Name" clear-button></f7-input>
      </div>
      <div class="col">
        <f7-label floating for="lastname">Last Name</f7-label>
        <f7-input type="text" v-bind:id="lastname" @input="lname = $event.target.value" :value="lname" placeholder="Last Name" clear-button></f7-input>
      </div>
    </div>
  </f7-list-item>
  <f7-list-item>
    <f7-label floating>Mobile</f7-label>
    <f7-input type="number" @input="mobile = $event.target.value" :value="mobile" placeholder="Mobile Number" clear-button></f7-input>
  </f7-list-item>
  <f7-list-item>
    <f7-label floating>Detail Address</f7-label>
    <f7-input type="text" @input="user_address = $event.target.value" :value="user_address" placeholder="Address" clear-button></f7-input>
  </f7-list-item>
   <f7-list-item>
    <f7-label floating>Landmark</f7-label>
    <f7-input type="text" @input="area = $event.target.value" :value="area" placeholder="Area" clear-button></f7-input>
  </f7-list-item>
</f7-list>
<div style="margin:0px;padding:0px;position:fixed;bottom:0;z-index:999;width:100%;background-color:white;box-shadow: 5px 0px 10px rgba(0, 0, 0, 0.12);border-radius:30px 30px 0px 0px">
<f7-segmented>
  <f7-button popup-close fill color="white" outline style="font-size:18px;font-weight:bold;text-transform:capitalize;margin:10px;border-radius:30px;border:1px solid #1d2671;color:#1d2671">Cancel</f7-button>
  <f7-button class="popup-close" fill @click="saveFunct()" style="font-size:18px;font-weight:bold;background-image: linear-gradient(to right, #11998e, #38ef7d);color:#FFFFFF;text-transform:capitalize;margin:10px;border-radius:30px">Save</f7-button>
  </f7-segmented>
  </div>
    </f7-block>
        </f7-popup>
  </f7-page>
</template>
<style>
</style>
<script>
import offline from 'v-offline';

import { f7Navbar, f7Page, f7Block, f7Button } from 'framework7-vue';
import axios from '../axios'
export default {
  name: 'Address',
  data() {
    return {
      title: 'Add New Address',
      preloader:false,
      address:[],
      fname:null,
      lname:null,
      user_address:null,
      internet:null,
      status:'not shown',
      mobile:null,
      area:null,
      address_id:null,
      toast_msg:null,
      save_status:'addnew',
    };
  },
    components: {
    offline
  },
  created(){
    console.log('instance created');
  },
  destroyed(){
    console.log('instance destroy');
  },
  mounted()
  {
    this.getadd();
  },
  methods:
  {
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
    addnewBtn:function(){
      this.clearData();
      this.save_status = 'addnew';
    },
    saveFunct:function(){

      if(this.save_status == 'addnew')
      {
        this.addnew();
      }
      else if(this.save_status == 'editadd')
      {
        this.editadd();
      }
      else{
        this.toast_msg = 'application error found,please restart your application';
        setTimeout(() => {
          this.toast_msg = null;
        },2000);
      }
    },
    clearData:function(){
      this.fname = null;
      this.lname = null;
      this.mobile = null;
      this.user_address = null;
      this.area = null;
    },
    getadd:function(){
      this.preloader = true;
      this.address = [];
      axios({
      method:'GET',
        url : '/user/address/json'
      }).then(response => {
        this.address=response.data.result;
        this.preloader = false;
      }).catch(error => {
        if (error.response.data.message != undefined)
          alert(error.response.data.message);
        else
          alert('system error found,please try again');
        this.preloader = false;
      });
    },
    addnew:function()
    {
      this.preloader = true;
      if(this.fname==null&&this.lname==null&&this.mobile==null&&this.user_address==null&&this.area==null){
        alert('Enter All Details');
      }
      else
      {
        axios({
        method:'POST',
          url : 'user/addAddress',
          data:{
            'first_name':this.fname,
            'last_name':this.lname,
            'mobile':this.mobile,
            'address':this.user_address,
            'area':this.area
          }
        }).then(response => {
          this.toast_msg = 'address successfully added';
          setTimeout(() => {
            this.toast_msg = null;
          },2000);
          this.clearData();
          this.getadd();
      }).catch(error => {
          if(error.response.data.message != undefined)
            alert(error.response.data.message);
          else
            alert('failed to add new address');
      });
    }
    },
    editaddForm:function(address)
    {
      this.fname = address.first_name;
      this.lname = address.last_name;
      this.user_address = address.address;
      this.area = address.area;
      this.mobile = address.mobile;
      this.address_id = address.id;
      this.save_status = 'editadd';
    },
    editadd:function(){
      this.preloader = true;
      axios({
        method:'POST',
        url : 'user/editAddress',
        data:{
          'first_name':this.fname,
          'last_name':this.lname,
          'mobile':this.mobile,
          'address':this.user_address,
          'area':this.area,
          'address_id':this.address_id
        }
      }).then(response => {
        this.toast_msg = 'address successfully updated';
        setTimeout(() => {
          this.toast_msg = null;
        },2000);
        this.clearData();
        this.getadd();
      }).catch(error => {
        if(error.response.data.message != undefined)
          alert(error.response.data.message);
        else
          alert('failed to update address');
      });
    },
    deleteadd:function(id)
    {
      this.preloader = true;
      axios({
      method:'POST',
        url : 'user/deleteaddress',
        data:{
          'address_id':id
        }
      }).then(response => {
        this.toast_msg = 'address successfully deleted';
        setTimeout(() => {
          this.toast_msg = null;
        },2000);
        this.getadd();
      }).catch(error => {
        if(error.response.data.message != undefined)
          alert(error.response.data.message);
        else
          alert('failed to delete address');
      });
    }
  }
};
</script>
<style scoped>
.md .navbar:after{
  content:none
}
</style>

