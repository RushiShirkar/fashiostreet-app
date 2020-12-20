/* eslint-disable no-unused-vars */
// Import Vue
import Vue from 'vue';
import Vuex from 'vuex'
import axios from 'axios'
import VueAxios from 'vue-axios'
import AnimatedVue from 'animated-vue'
 
Vue.use(AnimatedVue)
Vue.use(VueAxios, axios)
Vue.use(Vuex)
// Import F7
import Framework7 from 'framework7/dist/framework7.esm.bundle.js';

// Import F7 Vue Plugin
import Framework7Vue from 'framework7-vue/dist/framework7-vue.esm.bundle.js';

// Import F7 Styles
import Framework7Styles from 'framework7/dist/css/framework7.css';

// Import Icons and App Custom Styles
import IconsStyles from './css/icons.css';
import AppStyles from './css/app.css';
import Style from './assets/bootstrap/css/bootstrap.min.css';
import glyphicons from './assets/bootstrap/fonts/glyphicons.css';
//import Javascript from './assets/bootstrap/js/bootstrap.min.js';
import UserStyles from './assets/css/user.css';
// Import Routes
import Routes from './routes.js';
Vue.use(Routes);
// Import App Component
import App from './app';

// Set up some useful globals
window.isMaterial = !Framework7.device.ios;
window.isiOS = Framework7.device.ios;

// Init F7 Vue Plugin
Vue.use(Framework7Vue, Framework7);

// Init App
const baseApp = new Vue({
  el: '#app',
  template: '<app/>',
  // Init Framework7 by passing parameters here
  framework7: {
    id: 'io.framework7.testapp', // App bundle ID
    name: 'Framework7', // App name
    theme: 'auto', // Automatic theme detection
    pushStateNoAnimation: true,
    panel: {
      leftBreakpoint: 960
    },
    view: {
      pushState: true,
      reloadAll:true
    },
    // App routes
    routes: Routes
  },
  // Register App Component
  components: {
    app: App
  }
});
