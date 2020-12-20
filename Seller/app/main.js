import Vue from 'nativescript-vue';
import Home from './components/Home';
import App from './components/App';
import {TNSFontIcon, fonticon} from 'nativescript-fonticon';
TNSFontIcon.debug = true;
TNSFontIcon.paths = {
'fa': './assets/font-awesome.css'
};
TNSFontIcon.loadCss();
Vue.filter('fonticon', fonticon);
import VueDevtools from 'nativescript-vue-devtools';
const localStorage = require('nativescript-localstorage');
if(TNS_ENV !== 'production') {
  Vue.use(VueDevtools)
}
// Prints Vue logs when --env.production is *NOT* set while building
Vue.config.silent = (TNS_ENV === 'production')
Vue.registerElement('DropDown',() => require('nativescript-drop-down').DropDown)
Vue.registerElement(
  'PullToRefresh',
  () => require('nativescript-pulltorefresh').PullToRefresh
);
Vue.registerElement('CheckBox', () => require('nativescript-checkbox').CheckBox, {
	model: {
		prop: 'checked',
		event: 'checkedChange'
	}
});
if(localStorage.getItem('token') != null && localStorage.getItem('shopId') != null && localStorage.getItem('shopId')!=0){
    new Vue({
		render: h => h('frame', [h(Home)])
	}).$start();
  }
  else{
	new Vue({
		render: h => h('frame', [h(App)])
	}).$start();
  }
	
