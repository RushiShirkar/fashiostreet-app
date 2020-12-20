<template>
  <f7-page name="selectaddress"
           ptr @ptr:refresh="getadd"
  >
    <div v-if="toast_msg != null" class="custom_toast z-depth-3">
      {{ toast_msg }}
    </div>
    <f7-navbar class="bgnav" back-link="Back" style="border-radius:0px 0px 30px 0px;box-shadow: 5px 0px 10px rgba(0, 0, 0, 0.12)" sliding>
      <f7-nav-title style="font-size:18px;font-weight:bold;margin:0px">
        Select Address
      </f7-nav-title>
    </f7-navbar>
          <offline @detected-condition="handleConnectivityChange">
  </offline>
    <f7-block-title style="margin:0px;padding:16px;color:#000000">
      <h5 class="mpzero" style=";font-size:18px;font-weight:bold"><img src="../assets/address_icon.png" style="width:30px;height:30px;border-radius:50%;vertical-align: middle;" alt="Shops">&nbsp Default Address</h5>
      <f7-button popup-open =".editadd" outline small color="black" style="font-size:18px;font-weight:bold;position:absolute;right:15px;top:17px;text-transform:capitalize;border-radius:30px">+ Add New</f7-button></f7-block-title>
    <f7-block style="padding:0px">
      <center>
        <div v-if="preloader" class="preloader" style="margin-top:5vh">
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
        <f7-list v-if="!preloader" style="margin:0px">
            <template v-for="result in address">
              <li class="">
                <label class="item-content item-radio">
                  <input type="radio" :value="result.id" v-model="active_address"><i class="icon icon-radio"></i>
                  <div class="item-inner">
                    <div class="card" style="margin: 0px; width: 100%;-webkit-box-shadow:none;box-shadow:none;border-radius:4px;border:1px solid gray">
                      <div class="card-content card-content-padding" style="margin: 0px; padding: 10px;color:gray">
                        <h4 class="mpzero" style="color:#000000;font-size:16px">Name : {{result.first_name}} {{result.last_name}}</h4>
                        <h5 class="mpzero" style="font-size:14px">Detail Address : {{result.address}}</h5>
                        <h5 class="mpzero" style="font-size:14px">Area : {{result.area}}</h5>
                        <h5 class="mpzero" style="font-size:14px">Mobile : {{result.mobile}}</h5>
                      </div>
                    </div>
                  </div>
                </label>
              </li>
            </template>
        </f7-list>
    </f7-block>
    <div style="position:fixed;bottom:0;z-index:999;width:100%;background-color:#FFFFFF;box-shadow: 5px 0px 10px rgba(0, 0, 0, 0.12);border-radius:30px 30px 0px 0px">
        <f7-button :disabled="disabled" big fill :href="'/confirmdelivery/' + active_address" style="background-image: linear-gradient(to right, #11998e, #38ef7d);color:#FFFFFF;font-size:18px;font-weight:bold;border:0px;text-transform:Capitalize;margin:10px;border-radius:30px">Next <f7-icon f7="chevron_right" style="margin:-5px 0px 0px 10px"></f7-icon></f7-button>
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
    <f7-list no-hairlines-md style="padding:0px;margin:0px">
      <f7-list-item>
        <div class="row">
          <div class="col">
            <f7-label floating>First Name</f7-label>
            <f7-input type="text" @input="fname = $event.target.value" :value="fname" placeholder="First Name" clear-button></f7-input>
          </div>
          <div class="col">
            <f7-label floating>Last Name</f7-label>
            <f7-input type="text" @input="lname = $event.target.value" :value="lname" placeholder="Last Name" clear-button></f7-input>
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
<f7-block style="margin:0px;padding:0px;position:fixed;bottom:0;z-index:999;width:100%;background-color:white;box-shadow: 5px 0px 10px rgba(0, 0, 0, 0.12);border-radius:30px 30px 0px 0px">
<f7-segmented>
  <f7-button popup-close fill color="white" outline style="font-size:18px;font-weight:bold;text-transform:capitalize;margin:10px;border-radius:30px;border:1px solid #1d2671;color:#1d2671">Cancel</f7-button>
  <f7-button class="popup-close" fill @click="addnew" style="font-size:18px;font-weight:bold;background-image: linear-gradient(to right, #1d2671, #dc5496);text-transform:capitalize;margin:10px;border-radius:30px">Save</f7-button>
  </f7-segmented>
  </f7-block>
    </f7-block>
        </f7-popup>
  </f7-page>
</template>
<script>
  import axios from '../axios'
  import offline from 'v-offline';
export default {
  name: 'Selectaddress',
  data() {
    return {
      title: 'Add New Address',
      address:[],
      toast_msg:null,
      preloader:false,
      fname:null,
      lname:null,
      user_address:null,
      mobile:null,
      area:null,
      internet:null,
      status:'not shown',
      active_address:null,
      address_id:null,
      disabled:true
    };
  },
    components: {
    offline
  },
  destroyed(){
    console.log('select address destory');
  },
  watch:{
    active_address:function(){
      if(this.active_address != null)
      {
        this.disabled = false;
      }
    }
  },
  mounted(){
    this.getadd();
  },
  methods:{
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
    clearData:function(){
      this.fname = null;
      this.lname = null;
      this.mobile = null;
      this.user_address = null;
      this.area = null;
    },
    addnew:function()
    {
      this.preloader = true;
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
  }
};
</script>
<style scoped>
  .md .navbar:after{
  content:none
  }
</style>