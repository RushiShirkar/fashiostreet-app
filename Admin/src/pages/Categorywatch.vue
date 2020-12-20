<template>
  <f7-page class="bgpage" style="background-color:white" name="categorymen">
    <f7-navbar back-link="Back" class="bgnav" sliding>

      <f7-nav-title style="font-size:15px;margin:0px">
        WATCHES
      </f7-nav-title>
      <f7-nav-right>
        <f7-link style="padding:0 10px" icon-f7="icon-search_strong" href="/search/"></f7-link>
        <f7-link style="padding:0 10px" icon-f7="icon-heart_fill" href="/wishlist/"></f7-link>
        <f7-link style="padding:0 10px" href="/hdcart/"><img src="../assets/delivery-motorbike.svg" alt=""></f7-link>
      </f7-nav-right>
    </f7-navbar>
          <offline @detected-condition="handleConnectivityChange">
  </offline>
    <!-- Scrollable page content-->
    <f7-block style="margin-top:15px">
        <f7-list accordion>
      <template v-for="wear in category">
  <f7-list-item accordion-item :title="wear.wear" @click="savecategory(wear.wear)" style="font-size:12px;font-weight:bold">
    <f7-accordion-content>
      <f7-block>
      <f7-list>
      <template v-for="type in wear.type">
        <f7-list-item
        :title="type"
        @click="saveproduct(type)"
        style="font-size:12px"
        link="/products/"
        link-view="#main-view"
        panel-close/>
      </template>
      </f7-list>
      </f7-block>
    </f7-accordion-content>
  </f7-list-item>
      </template>
      </f7-list>
    </f7-block>
  </f7-page>
</template>

<script>
import axios from '../axios';
import offline from 'v-offline';
export default {
  name: 'Categorymen',
  data() {
    return {
      title: 'Services Page',
      category:[],
      internet:null,
      status:'not shown'
    };
  },
    components: {
    offline
  },
   mounted(){
    axios({
      method:'GET',
        url : '/tmpjson/leftpanel.json'
      }).then(response => {
        this.category=response.data.category[4].wear;
      }).catch(function(error){
          console.log(error);
      });
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
    savecategory:function(category){
      localStorage.setItem("category",category);
    },
    saveproduct:function(product){
      localStorage.setItem("product",product);
    }
  }
};
</script>
