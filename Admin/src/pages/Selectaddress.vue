<template>
  <f7-page class="bgpage" name="selectaddress" style="background-color:white"
           ptr @ptr:refresh="getadd"
  >
    <div v-if="toast_msg != null" class="custom_toast z-depth-3">
      {{ toast_msg }}
    </div>
    <f7-navbar class="bgnav" back-link="Back" sliding>
      <f7-nav-title style="font-size:15px;margin:0px">
        SELECT ADDRESS
      </f7-nav-title>
    </f7-navbar>
          <offline @detected-condition="handleConnectivityChange">
  </offline>
    <f7-block-title style="margin:0px;padding:15px;"><h5 class="mpzero">DEFAULT ADDRESS</h5><f7-button popup-open =".editadd" outline small color="gray" style="font-size:12px;font-weight:bold;display:inline-block;position:absolute;right:15px;top:10px">+ ADD NEW</f7-button></f7-block-title>
    <f7-block style="padding:0px">
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
        <f7-list v-if="!preloader" style="margin:0px">
            <template v-for="result in address">
              <li class="">
                <label class="item-content item-radio">
                  <input type="radio" :value="result.id" v-model="active_address"><i class="icon icon-radio"></i>
                  <div class="item-inner">
                    <div class="card" style="margin: 0px; width: 100%;">
                      <div class="card-content card-content-padding" style="margin: 0px; padding: 10px;">
                        <h4 class="mpzero" style="color:#757575">Name : {{result.first_name}} {{result.last_name}}</h4>
                        <h5 class="mpzero">Detail Address : {{result.address}}</h5>
                        <h5 class="mpzero">Area : {{result.area}}</h5>
                        <h5 class="mpzero">Mobile : {{result.mobile}}</h5>
                      </div>
                    </div>
                  </div>
                </label>
              </li>
            </template>
        </f7-list>
    </f7-block>
        <f7-button :disabled="disabled" fill :href="'/confirmdelivery/' + active_address" style="background-color:#00E676;border-radius:0px;font-size:15px;font-weight:750;position:fixed;bottom:0;z-index:999;width:100%;height:45px;line-height:45px;">CONTINUE <f7-icon f7="chevron_right" style="margin:-5px 0px 0px 10px"></f7-icon></f7-button>

        <f7-popup class="editadd">
            <f7-navbar class="bgnav" sliding>
                <f7-nav-left>
                            <f7-link icon-f7="icon-close" popup-close></f7-link>
                </f7-nav-left>
      <f7-nav-title style="font-size:15px;margin:0px">
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
<f7-segmented style="width:100%;position:fixed;bottom:0;z-index:999">
  <f7-button popup-close fill color="white" outline style="font-size:12px;font-weight:bold;border-radius:0px;border-width:1px 0px 0px 0px;border-color:green;color:green">CANCEL</f7-button>
  <f7-button class="popup-close" fill @click="addnew" color="green" style="font-size:12px;font-weight:bold;border-radius:0px">SAVE</f7-button>
  </f7-segmented>
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
      title: 'ADD NEW ADDRESS',
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
