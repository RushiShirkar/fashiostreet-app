<template>
  <!-- App -->
  <div id="app">
    <div style="background-image: linear-gradient(to bottom, #273657, #00c4cc);position:fixed;top:0;left:0;width:100%;height:100vh" v-if="page == 'city'">
      <img style="position:fixed;bottom:0;left:0;width:100%" src="./assets/city.png"/>
      <center>
        <f7-block>
          <div style="margin-top: 30%">
            <img style="width:100px" src="./assets/fashiostreet.png"/>
            <p style="color:#FFFFFF;font-size:24px;font-weight:800">Fashio<span style="color:#76ff03">street</span></p>
          </div>
          <div style="color:#FFFFFF;font-size: 20px;">Select Your City</div>
        <div>
          <template v-for="city in cities">
            <a style="background-color:#76ff03;color:#273657;margin: 20px 20px 10px 20px" class="button button-fill button-big" @click="saveCity(city)"><b>{{ city }}</b></a>
          </template>
        </div>
        </f7-block>
      </center>
    </div>
    <div style="background-color: white;position:fixed;top:0;left:0;width:100%;height:100vh" v-if="page == 'loading'">
      <center>
        <div style="margin-top: 145px">
          <img style="width:100px" src="./assets/fashiostreet.png"/>
          <h2>Fashiostreet</h2>
          <br/>
          <div v-if="!preloaderStatus">
            Please check your internet connection
          </div>
          <div v-if="preloaderStatus" class="preloader">
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
          <h3 style="position:fixed;left:0;width:100%;bottom:50px;text-align: center">Handcrafted in india</h3>
        </div>
      </center>
    </div>
    <template v-if="page == 'body'">
    <!-- Statusbar -->
    <f7-statusbar></f7-statusbar>

    <!-- Left Panel / View -->

    <!-- Main View -->
    <f7-view id="main-view" url="/" main></f7-view>
    </template>
  </div>
</template>

<script>
import LeftPanel from './components/LeftPanel';
import axios from './axios';
import F7Block from "framework7-vue/src/components/block";
export default {
  name: 'App',
  props:['flag'],
  data(){
    return{
      page:'loading',
      preloaderStatus:true,
      cities:['kolhapur','islampur']
    }
  },
  watch:{
    page:function () {
      console.log( 'page '  + this.page);
    }
  },
  components: {
    F7Block,
    'left-panel-view': LeftPanel
  },
  methods: {
    saveCity:function(city){
      localStorage.setItem('city',city);
      this.page='body';
      window.location.href = window.location.href;
    },
    handleBackButton() {
      // NOTE: The back button will behave differently depending on circumstance
      // If the side panel is open, close it
      if (document.querySelector('.panel-left.panel-active')) {
        // This will do nothing when the split-view is open
        return this.$f7.panel.close();
      }
      // Close modals
      // @TODO How to handle modals we shouldn't close like a login-screen?
      if (document.querySelector('.modal-in')) {
        return this.$f7.popover.close();
      }
      // If we have a back button, we want it to go back
      if (this.$f7.views.main.router.history.length > 1) {
        return this.$f7.views.main.router.back();
      }
      // Default to closing the app
      return window.navigator.app.exitApp();
    }
  },
  computed: {
    isiOS() {
      return this.$theme.ios;
    }
  },
  mounted(){
    var tmp_data = localStorage.getItem('city');
    console.log('city : ' + tmp_data);
    if(!tmp_data)
    {
      this.page = 'city';
    }
    console.log('city : ' + this.page);
    tmp_data = localStorage.getItem('panelData');
    if(tmp_data)
    {
      this.category = JSON.parse(tmp_data);
      if(this.page != 'city') {
        this.page = 'body';
      }
    }
    else{
      axios({
        method:'GET',
        url : '/tmpjson/leftpanel'
      }).then(response => {
        this.category = response.data;
        localStorage.setItem('panelData',JSON.stringify(this.category));
        if(this.page != 'city') {
          this.page = 'body';
        }
      },error => {
        this.preloaderStatus = false;
        alert('please check your internet connection');
      });
    }
  },
  created() {
    console.log('flag : ' + this.flag);
    document.addEventListener('backbutton', this.handleBackButton);
  }
};
</script>

<style>
/* style is not `scoped` so navbars in Pages are modified as well */
@media (min-width: 960px) {
  /* Let's hide panel-opener button when left panel is visible */
  .view-main .navbar .panel-open {
    display: none;
  }
}
.z-depth-3 {
  -webkit-box-shadow: 0 8px 17px 2px rgba(0, 0, 0, 0.14), 0 3px 14px 2px rgba(0, 0, 0, 0.12), 0 5px 5px -3px rgba(0, 0, 0, 0.2);
  box-shadow: 0 8px 17px 2px rgba(0, 0, 0, 0.14), 0 3px 14px 2px rgba(0, 0, 0, 0.12), 0 5px 5px -3px rgba(0, 0, 0, 0.2);
}
.image_viewer{
  background-image: url("assets/fashiostreet.png");
  background-size: 40%;
  background-position: center;
  background-repeat: no-repeat;
}
.custom_toast{
  z-index: 9999;
  position:fixed;
  bottom: 30px;
  text-overflow: ellipsis;
  left:0;
  right:0;
  margin: auto;
  max-width:250px;
  background-color:black;
  color:white;
  opacity: 0.9;
  text-align: center;
  font-size:17px;
  padding:10px;
}
</style>
