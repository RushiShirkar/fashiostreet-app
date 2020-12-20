<template>
  <f7-page class="bgpage" name="search">
    <f7-navbar back-link="Back" class="bgnav" sliding>

      <f7-nav-title style="font-size:15px;margin:0px">
        {{ title }}
      </f7-nav-title>
    </f7-navbar>
          <offline @detected-condition="handleConnectivityChange">
  </offline>
    <f7-searchbar
      @input="search = $event.target.value"
  disable-link-text=""
  :placeholder="placeholder"
  :clear-button="true"
></f7-searchbar>
    <!-- Scrollable page content-->
    <f7-block style="background-color: white">
      <div v-if="searchMsg != null">{{ searchMsg }}</div>
      <h3>{{ status }}</h3>
      <div v-if="searchData != null && flag == 'shop'" class="list links-list">
        <ul>
          <li v-for="result in searchData"><a href="/shophome/" @click="setShop(result.name)">{{ result.name }}</a></li>
        </ul>
      </div>
      <div v-if="searchData != null && flag == 'product'" class="list links-list">
        <ul>
          <li v-for="result in searchData"><a :href="'/products/?q=' + result.keyword">{{ result.keyword }}</a></li>
        </ul>
      </div>
    </f7-block>
  </f7-page>
</template>

<script>
  import axios from '../axios'
  import offline from 'v-offline';

export default {
  name: 'Search',
  data() {
    return {
      search:null,
      status:null,
      timeout:null,
      internet:null,
      status1:'not shown',
      searchData:null,
      searchMsg:null
    };
  },
  props:['title','placeholder','flag'],
  watch:{
    search:function(){
      this.searchMsg = null;
      this.searchData = null;
      this.status = 'Listening your todays wish...';
      clearTimeout(this.timeout);
      if(this.search == null || this.search == '')
      {
        this.status = null;
        return false;
      }
      this.timeout = setTimeout(()=>{
        this.status = 'searching...';
        if(this.flag == 'shop')
        {
          this.getShop();
        }
        else if(this.flag == 'product')
        {
          this.getProduct();
          console.log('product search ...');
        }
      },700);
    }
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
    setShop:function(shop){
      localStorage.setItem('sname',shop);
    },
    getShop:function(){
      axios({
        method:'POST',
        url : '/search/shop',
        data:{
          'city' : localStorage.getItem('city'),
          'shop' : this.search
        }
      }).then(response => {
        this.status = null;
        if(response.data == 'No Shop Found')
        {
          this.searchMsg = 'Sorry! This shop not connected with us.Ask them to connect with us (Totally Free!)';
        }
        else
        {
          this.searchData = response.data;
        }
      }).catch(error => {
        if(error.response.data.message != undefined)
          alert(error.response.data.message);
        else
          this.searchMsg = 'failed to search shop';
        this.status = null;
      });
    },
    getProduct:function(){
      axios({
        method:'POST',
        url : '/search/product',
        data:{
          'city' : localStorage.getItem('city'),
          'shop' : 'all shop',
          'q' : this.search
        }
      }).then(response => {
        this.status = null;
        if(response.data == 'No Product Found')
        {
          this.searchMsg = 'Sorry! no product found';
        }
        else
        {
          this.searchData = response.data;
        }
      }).catch(error => {
        if(error.response.data.message != undefined)
          alert(error.response.data.message);
        else
          this.searchMsg = 'failed to search product';
        this.status = null;
      });
    }
  }
};
</script>
