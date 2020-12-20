/* eslint-disable no-unused-vars */
// Import Vue
import Vue from 'vue';
import Vuex from 'vuex'
import axios from 'axios'
import VueAxios from 'vue-axios'
import AnimatedVue from 'animated-vue'
 import VueCordova from 'vue-cordova'

Vue.use(VueCordova, {
  optionTestKey: 'optionTestValue'
})
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

if (window.location.protocol === 'file:' || window.location.port === '3000') {
  var cordovaScript = document.createElement('script')
  cordovaScript.setAttribute('type', 'text/javascript')
  cordovaScript.setAttribute('src', 'cordova.js')
  document.body.appendChild(cordovaScript)
}
// Init App
const baseApp = new Vue({
  el: '#app',
  template: '<app/>',
  data: function () {
    return {
      cordova: Vue.cordova
    }
  },
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
