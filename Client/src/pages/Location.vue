<template>
  <f7-page class="bgpage" name="location">
    <f7-navbar class="bgnav" sliding>
     <f7-nav-left>
        <f7-link icon-f7="icon-arrow_left" href="/"></f7-link>
      </f7-nav-left>
      <f7-nav-title style="font-size:15px;margin:0px">
        SELECT LOCATION
      </f7-nav-title>
    </f7-navbar>
          <offline @detected-condition="handleConnectivityChange">
  </offline>
    <f7-searchbar
  disable-link-text=""
  placeholder="Enter your City"
  :clear-button="true"
  search-container=".citylist"
></f7-searchbar>
    <!-- Scrollable page content-->
    <!-- <f7-block-title>{{ title }}</f7-block-title> -->
    <f7-block  style="margin:0px;padding:0px;color:#757575">
      <f7-list class="citylist" no-hairlines-between style="margin:10px">
  <template v-for="result in cityinfo.city">
        <f7-list-item :title="result" link="/" @click="save(result)"/>
  </template>
      </f7-list>
    </f7-block>
    <f7-block-title  style="margin-top:15px"><h5 class="mpzero">LAUNCHING SOON</h5></f7-block-title>
    <f7-block  style="margin:0px;padding:0px;color:#757575">
<f7-list no-hairlines-between style="margin:10px">
        <f7-list-item title="Satara" />
        <f7-list-item title="Sangli" />
        <f7-list-item title="Pune" />
        <f7-list-item title="Mumbai" />
      </f7-list>
    </f7-block>
  </f7-page>
</template>

<script>
import axios from 'axios';
import offline from 'v-offline';
export default {
  name: 'Location',
  data() {
    return {
      cityinfo:[],
      title: 'Services Page',
      internet:null,
      status:'not shown'
    };
  },
    components: {
    offline
  },
  mounted()
  {
    axios({
      method:'GET',
        url : 'http://localhost/Fashiostreet/src/tmpjson/city.json'
      }).then(response => {
        this.cityinfo=response.data;
      }).catch(function(error){
          console.log(error);
      });
  },
  methods:{
    save:function(city){
      localStorage.setItem("city",city);
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
