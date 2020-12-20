<template>
    <f7-panel left :reveal="isiOS" :effect="panelEffect">
    <!-- force page background color to white if on iOS -->
    <f7-page style="color:#9E9E9E;margin-top:0px">
    <f7-link style="width:100%" v-if="t==null&& l==null" panel-close href="/login/">
      <f7-block style="background-color:#273657;height:100px;margin:0px;width:100%;color:#9E9E9E">
        <f7-row no-gap>
          <f7-col width="25">
            <div style="height:65px;width:65px;border-radius:50%;background-color:white;margin-top:18px">
              <f7-icon f7="icon-person" style="height:65px;line-height:65px;font-size:65px"></f7-icon>
            </div>
          </f7-col>
          <f7-col width="75" style="padding:5px;height:100px;line-height:100px">
            <!--<h4 class="mpzero" style="padding-left:15px;color:white;" v-if="name!=null">Hello {{name}}</h4>-->
            <h4 class="mpzero" style="padding-left:15px;color:white;" >{{user}}</h4>
          </f7-col>
        </f7-row>
      </f7-block>
    </f7-link>
    <f7-link style="width:100%" v-if="t!=null&& l!=null" panel-close href="/account/">
      <f7-block style="background-color:#273657;height:100px;margin:0px;width:100%;color:#9E9E9E">
        <f7-row no-gap>
          <f7-col width="25">
            <div style="height:65px;width:65px;border-radius:50%;background-color:white;margin-top:18px">
              <f7-icon f7="icon-person" style="height:65px;line-height:65px;font-size:65px"></f7-icon>
            </div>
          </f7-col>
          <f7-col width="75" style="padding:5px;height:100px;line-height:100px">
            <!--<h4 class="mpzero" style="padding-left:15px;color:white;" v-if="name!=null">Hello {{name}}</h4>-->
            <h4 class="mpzero" style="padding-left:15px;color:white;" >{{user}}</h4>
          </f7-col>
        </f7-row>
      </f7-block>
    </f7-link>
     <f7-list style="margin-top:0px;margin-bottom:0px">
       <!--<f7-list-item
         link="/citySelector/"
         style="font-size:13px;color:navy"
         link-view="#main-view"
         panel-close
       >{{c}}</f7-list-item>-->
    </f7-list>
    <f7-list accordion style="margin-top:0px;margin-bottom:0px">
      <f7-list-item @click="savegender('Men')" title="MEN CLOTHING" link="/categorymen/" link-view="#main-view" style="font-size:13px" panel-close/>
      <f7-list-item @click="savegender('Women')" title="WOMEN CLOTHING" link="/categorywomen/" link-view="#main-view" style="font-size:13px" panel-close/>
      <f7-list-item @click="savegender('Baby and Kids')" title="BABY & KIDS CLOTHING" link="/categorykids/" link-view="#main-view" style="font-size:13px"   panel-close/>
    </f7-list> 
        <f7-list style="margin-top:0px;margin-bottom:0px">
        <!-- <f7-list-item
          link="/"
          title="Home"
          link-view="#main-view"
          panel-close
          reload-all
        /> -->
        <f7-list-item
          link="/wishlist/"
          title="WISHLIST"
          style="font-size:13px"
          link-view="#main-view"
          panel-close

        />
        <f7-list-item
          link="/hdorders/"
          title="HD ORDERS"
          style="font-size:13px"
          link-view="#main-view"
          panel-close
        />
        <f7-list-item
          link="/account/"
          title="ACCOUNT"
          style="font-size:13px"
          link-view="#main-view"
          panel-close

        />
      </f7-list>
      
  <f7-list accordion style="margin-top:0px;margin-bottom:0px">
        <f7-list-item style="font-size:13px"  panel-close><a class="link external" style="color:rgb(158, 158, 158);" href="https://help.fashiostreet.com/term_condition.html">TERMS & CONDITIONS</a></f7-list-item>
        <f7-list-item style="font-size:13px" panel-close><a class="link external" style="color:rgb(158, 158, 158);" href="https://help.fashiostreet.com">SELL ON FASHIOSTREET</a></f7-list-item>
      </f7-list>
      <f7-block style="margin-top:20px;margin-bottom:20px;padding-left:16px">
        <f7-row>
          <f7-col style="color:green;padding-top:5px;font-size:13px">
             <f7-icon f7="icon-phone_fill"></f7-icon>&nbsp&nbsp SUPPORT
          </f7-col>
          <f7-col>
              <a class="link external" :href="'tel:' + 8600198512"  style="background-color:green;display:block;font-size:13px;color:#FFFFFF;padding:5px;border-radius:3px"><center>CALL NOW</center></a>
          </f7-col>
        </f7-row>
      </f7-block>
      
      <f7-block style="margin-top:10px;margin-bottom:10px;margin-left:auto;margin-right:auto;width:88%">
<a class="link external" style="color:rgb(158, 158, 158);" href="https://www.facebook.com/fashiostreet/"><f7-icon style="padding:10px" f7="icon-social_facebook"></f7-icon></a>
<a class="link external" style="color:rgb(158, 158, 158);" href="https://www.instagram.com/fashiostreet_official/"><f7-icon style="padding:10px" f7="icon-social_instagram"></f7-icon></a>
<a class="link external" style="color:rgb(158, 158, 158);" href="https://www.linkedin.com/company/fashiostreet/"><f7-icon style="padding:10px" f7="icon-social_linkedin"></f7-icon></a>
<a class="link external" style="color:rgb(158, 158, 158);" href="https://twitter.com/Fashiostreet10/"><f7-icon style="padding:10px" f7="icon-social_twitter"></f7-icon></a>
      </f7-block>
    </f7-page>
  </f7-panel>
</template>

<script>
import axios from '../axios';
export default {
  name: 'LeftPanel',
  data() {
    return {
      isMaterial: window.isMaterial,
      isiOS: window.isiOS,
      category:[],
      city_name:localStorage.getItem('city'),
      mobile:localStorage.getItem('loginmobile'),
      name:null,
      gender:null,
      t:null,
      l:null
    };
  },
    mounted(){
    this.city_name = localStorage.getItem('city');
    //alert(city);
    this.city_name = this.city_name.charAt(0).toUpperCase()+this.city_name.slice(1);
    //alert(this.city_name);
    var tmp_data = localStorage.getItem('panelData');
    if(tmp_data)
    {
      this.category = JSON.parse(tmp_data);
    }
    else{
      axios({
        method:'GET',
        url : '/tmpjson/leftpanel'
      }).then(response => {
        this.category = response.data;
      },(error) => {
        alert('please check your internet connection');
      });
    }
    axios({
      method:'GET',
        url : 'user/profile/json'
      }).then(response => {
        this.name=response.data.result[0].name;
        this.gender=response.data.result[0].gender;
        if(response.data.result[0].mobile != localStorage.getItem('loginmobile'))
        {
          localStorage.setItem('loginmobile',response.data.result[0].mobile);
        }
      this.preloader = false;
      }).catch(function(error){
      if (error.response.data.message != undefined)
      {
        //alert(error.response.data.message);
      }
      else
        alert('system error found,please try again');
      this.preloader = false;
      });
  },
  computed: {
    user(){

      var token= localStorage.getItem('token');
      var local_id = localStorage.getItem('local_id');
      this.t = localStorage.getItem('token');
      this.l = localStorage.getItem('local_id');
      if(token == null && local_id == null) {
        return 'Sign In / Sign Up';
      }
      else{
        //console.log(this.name);
        if(this.name!=null) {
          return 'Hello '+this.name;
        }
        return 'Hello user';
      }
    },
    c(){
      var a = localStorage.getItem('city');
      //alert(a);
      return a;
    },
    pageStyle() {
      return this.isiOS ? 'background-color: white;' : '';
    },
    panelEffect() {
      return this.isiOS ? 'reveal' : 'cover';
    }
  },
  methods:{
    savegender:function(gender){
      localStorage.setItem("gender",gender);
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

<style scoped>
@media (min-width: 960px) {
  .panel.panel-left {
    border-right: 1px solid #b2b2b2;
  }
}
</style>
