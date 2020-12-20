<template>
    <f7-panel left :reveal="isiOS" :effect="panelEffect">
    <!-- force page background color to white if on iOS -->
    <f7-page style="color:#9E9E9E;margin-top:0px">
    <f7-link style="width:100%" v-if="t==null&& l==null" panel-close href="/login/">
      <f7-block style="background-color:#0d1635;height:120px;margin:0px;width:100%;color:#9E9E9E;border-radius:0px 0px 30px 30px">
        <f7-row no-gap>
          <f7-col width="25">
            <div style="height:45px;width:45px;border-radius:50%;background-color:white;margin-top:18px">
              <f7-icon f7="icon-person" style="height:45px;line-height:45px;font-size:45px"></f7-icon>
            </div>
          </f7-col>
          <f7-col width="75" style="padding:5px;height:115px;line-height:115px">
            <!--<h4 class="mpzero" style="padding-left:15px;color:white;" v-if="name!=null">Hello {{name}}</h4>-->
            <h4 class="mpzero" style="padding-left:15px;color:white;font-size:18px" >{{user}}</h4>
          </f7-col>
        </f7-row>
      </f7-block>
    </f7-link>
    <f7-link style="width:100%" v-if="t!=null&& l!=null" panel-close href="/account/">
      <f7-block style="background-color:#0d1635;height:120px;margin:0px;width:100%;color:#9E9E9E;border-radius:0px 0px 30px 30px">
        <f7-row no-gap>
          <f7-col width="25">
            <div style="height:45px;width:45px;border-radius:50%;background-color:white;margin-top:36px;margin-left:15px">
              <f7-icon f7="icon-person" style="height:45px;line-height:45px;font-size:45px"></f7-icon>
            </div>
          </f7-col>
          <f7-col width="75" style="padding:5px;height:105px;line-height:105px">
            <!--<h4 class="mpzero" style="padding-left:10px;color:white;" v-if="name!=null">Hello {{name}}</h4>-->
            <h4 class="mpzero lineclampin" style="padding-left:10px;color:white;font-size:18px" >{{user}}</h4>
          </f7-col>
        </f7-row>
      </f7-block>
    </f7-link>

    <f7-list no-hairlines no-hairlines-between style="margin-top:0px;margin-bottom:0px">
      <f7-list-item @click="savegender('Men')" link="/categorymen/" link-view="#main-view" panel-close style="padding:8px 0px">
        <div style="height:30px">
          <img src="../assets/man_icon.png" style="width:30px;height:30px;border-radius:50%" alt="Mens Clothing">
        </div>
        <div style="font-weight:bold;color:#000000;font-size:16px;margin-right:48px" class="mpzero">&nbsp Mens Clothing</div>
      </f7-list-item>
      <f7-list-item @click="savegender('Footwear')" link="/categoryfootwear/" link-view="#main-view" panel-close style="padding:8px 0px">
        <div style="height:30px">
          <img src="../assets/footwear_icon.png" style="width:30px;height:30px;border-radius:50%" alt="Mens Footwear">
        </div>
        <div style="font-weight:bold;color:#000000;font-size:16px;margin-right:42px" class="mpzero">&nbsp Mens Footwear</div>
      </f7-list-item>
      <f7-list-item @click="savegender('Deodorant')" link="/categorydeodorant/" link-view="#main-view" panel-close style="padding:8px 0px">
        <div style="height:30px">
          <img src="../assets/deo_icon.png" style="width:30px;height:30px;border-radius:50%" alt="Womens Clothing">
        </div>
        <div style="font-weight:bold;color:#000000;font-size:16px;margin-right:68px" class="mpzero">Deodorants</div>
      </f7-list-item>
      <f7-list-item link="/wallet/" panel-close style="margin:8px 0px;background-image: linear-gradient(to right, #4568DC, #B06AB3);border-radius:0px 30px 30px 0px">
          <div>
            <img src="../assets/wallet.svg" alt="FS Wallet" style="padding:4px 0px 0px 5px">
          </div>
          <div style="color:#FFFFFF;font-size:16px;font-weight:bold;margin-left:-12px" class="mpzero">&nbsp FS Wallet</div>
          <f7-chip :text="'₹ '+money" style="color:#000000;background-color:#5ddcf9;font-weight:bold;font-size:16px"></f7-chip>
      </f7-list-item>
      <f7-list-item link="/wishlist/" link-view="#main-view" panel-close style="padding:8px 0px">
          <div style="height:30px">
            <img src="../assets/wishlist_icon.png" style="width:30px;height:30px;border-radius:50%" alt="Wishlist">
          </div>
          <div style="font-weight:bold;color:#000000;font-size:16px;margin-right:31px" class="mpzero">&nbsp Your Liked Items</div>
        </f7-list-item>
        <f7-list-item link="/hdorders/" link-view="#main-view" panel-close style="padding:8px 0px">
          <div style="height:30px">
            <img src="../assets/delivery_icon.png" style="width:30px;height:30px;border-radius:50%" alt="Delivery Orders">
          </div>
          <div style="font-weight:bold;color:#000000;font-size:16px;margin-right:81px" class="mpzero">&nbsp Hd Orders</div>
        </f7-list-item>
        <f7-list-item link="/account/" link-view="#main-view" panel-close style="padding:8px 0px">
          <div style="height:30px">
            <img src="../assets/account_icon.png" style="width:30px;height:30px;border-radius:50%" alt="Account">
          </div>
          <div style="font-weight:bold;color:#000000;font-size:16px;margin-right:68px" class="mpzero">&nbsp My Account</div>
        </f7-list-item>
    </f7-list> 
      <f7-block style="margin-top:20px;margin-bottom:20px;padding-left:16px">
        <f7-row>
          <f7-col style="color:#4caf50;padding-top:5px;font-size:16px;font-weight:bold">
             <f7-icon f7="icon-phone_fill"></f7-icon>&nbsp&nbsp Support
          </f7-col>
          <f7-col>
              <a class="link external" :href="'tel:' + 8600198512"  style="background-color:#4caf50;display:block;font-size:16px;font-weight:bold;color:#FFFFFF;padding:5px;border-radius:30px"><center>Call Now</center></a>
          </f7-col>
        </f7-row>
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
      l:null,
      money:null
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
    this.getMoney();
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
    getMoney()
    {
      axios({
          method:'GET',
            url : 'user/getMoney/'+localStorage.getItem('loginmobile')
        }).then(response => {
              console.log(response.data.result);
              this.money = response.data.result[0].money;  
        }).catch(function(error){
            if (error.response.data.message != undefined)
              console.log(error.response.data.message);
            else
              alert('system error found,please try again');
        });
    },
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
.lineclampin{
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    width: 100%;
}
@media (min-width: 960px) {
  .panel.panel-left {
    border-right: 1px solid #b2b2b2;
  }
}
</style>
