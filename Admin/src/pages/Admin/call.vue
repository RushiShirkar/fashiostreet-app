<template>
  <f7-page>
  <div>
    <div class="row marginzero" style="position: fixed;width: 100%;top:0px;left:0px;">
      <div class="col-md-11 " style="border-right: 1px solid #FFFFFF">
        <a href="javascript:void(0)" class="rep_tab">Call / Chat / Whatsapp Msg</a>
      </div>
      <div class="col-md-1" style="border-right: 1px solid #FFFFFF">
        <f7-link href="/order" class="rep_tab">Orders</f7-link>
      </div>
    </div>
    <div class="row marginzero" style="margin-top: 60px">
      <div class="col-lg-2 col-md-2 col-sm-2 sidebar">
        <ul class="list-unstyled">
          <li><a href="/" style="font-size:20px">All Customers<span class="glyphicon glyphicon-menu-right pull-right menu_arrow"></span></a></li>
          <li><a style="font-size:20px" href="/wishlist">Wishlist Msg<span class="glyphicon glyphicon-menu-right pull-right menu_arrow"></span></a></li>
          <li><a style="font-size:20px" href="/cart">Hd Cart Msg<span class="glyphicon glyphicon-menu-right pull-right menu_arrow"></span></a></li>
          <li><a style="font-size:20px" href="/visitshop">Visit Shop Msg<span class="glyphicon glyphicon-menu-right pull-right menu_arrow"></span></a></li>
          <li style="background-color: red;"><a style="font-size:20px" >Call / Chat / Whatsapp Msg<span class="glyphicon glyphicon-menu-right pull-right menu_arrow"></span></a></li>
          <li><a href="/wallet" style="font-size:20px">Wallet Msg<span class="glyphicon glyphicon-menu-right pull-right menu_arrow"></span></a></li>
        </ul>
      </div>
      <div style="float:right;width:60%;margin-left:210px">
        <div>
          <h4><label class="addpro_title" style="margin-top: 30px">Message :</label></h4>
          <textarea v-model="message" style="height:80%;font-size:21px" rows="8" class="form-control" ></textarea>
          <button @click="sendMessage" class="btn btn-green btn-block btn-sm" type="button" style="margin-top:30px">Send</button>
        </div>
      </div>
    </div>
  </div> 
  </f7-page>
</template>

<script>
import axios from '../../axios';
export default {
  name: 'call',
  data(){
    return{
      message:null
    }
  },
  methods:{
    sendMessage()
    {
      if(confirm("Do you really want to send this Message?"))
      {
        const self = this;
        self.$f7.dialog.preloader('Sending Messages');
        axios({
          method:'POST',
          url : '/callMsg',
          data:{
            'message' : this.message
          }
        }).then(response => {
          setTimeout(() => {
            self.$f7.dialog.close();
            alert(response.data.result);
          }, 1000);
        }).catch(error => {
          if(error.response.data.message != undefined)
            alert(error.response.data.message);
          else
            alert('failed to send messages');
        });
      }
      this.message = null;
    }
  }
};
</script>

<style scoped>
  .mpzero{
  padding: 0;
  margin: 0
}
th{
  text-align:center;
}
.paddingzero{
  padding:0;
}
.marginzero{
  margin:0;
  z-index:1002;
}
.sidebar{
  height:92vh;
  margin-top: 0px;
  position:fixed;
  color:#ffffff;
  background-color:#455A64;
  padding:0;
  text-align:left;
}
.sidebar ul li{
  border-bottom: 1px solid #E0E0E0; 
}

.sidebar ul li a{
  color: #E0E0E0;
  display: block;
  text-decoration: none;
  padding: 15px 20px;
}
.btn-green
{
 color:white !important;
 font-size:14px;
 font-weight:600;
 background-color:#1dbf73;
 transitions:500ms;
 border-radius:0px;
 border:2px solid #1dbf73;
 text-decoration:none !important;
}
.btn-blue
{
 color:white !important;
 font-size:14px;
 font-weight:600;
 background-color:#1E88E5;
 transitions:500ms;
 border-radius:0px;
 border:2px solid #1E88E5;
 text-decoration:none !important;
}

.btn-orange
{
 color:white !important;
 font-size:14px;
 font-weight:600;
 background-color:#f49d41;
 transitions:500ms;
 border-radius:0px;
 border:2px solid #f49d41;
 text-decoration:none !important;
}

.btn-red
{
 color:white !important;
 font-size:14px;
 font-weight:600;
 background-color:#E53935;
 transitions:500ms;
 border-radius:0px; 
 border:2px solid #E53935;
 text-decoration:none !important;
}

.rep_tab{
  display: block;
  text-align:center;
  padding: 15px 10px;
  text-decoration: none !important;
  background-color:#0277BD;
  color: #FFFFFF; 
}


.show {
display:block;
}
.menu-container {
    width: 80%;
    margin: 0 auto;
    background: #263238;
}
.menu > ul {
    margin: 0 auto;
    width: 100%;
    list-style: none;
    padding: 0;
    position: relative;
    /* IF .menu position=relative -> ul = container width, ELSE ul = 100% width */
    box-sizing: border-box;
    text-align:center;
}

.menu > ul:before,
.menu > ul:after {
    content: "";
    display: table;
}

.menu > ul:after {
    clear: both;
}

.menu > ul > li {
    background: inherit;
    padding: 0;
    margin: 0;
    display: inline-block;
    font-weight: 700;
}

.menu > ul > li a {
    text-decoration: none;
    padding: 0.8em 3em;
    display: block;
    text-align:left;
}


.cat_title{
    text-decoration: none;
    padding: 1em 3em;
    display: block;
    text-align:left;
    color: #FFFFFF;
}

.menu > ul > li > ul {
    display: none;
    width: 100%;
    background: #FAFAFA;
    padding: 10px 20px;
    position: absolute;
    z-index: 99;
    left: 0;
    margin: 0;
    list-style: none;
    box-sizing: border-box;
    border: 1px solid #9E9E9E;
    border-top:none; 
}

.menu > ul > li > ul:before,
.menu > ul > li > ul:after {
    content: "";
    display: table;
}

.menu > ul > li > ul:after {
    clear: both;
}

.menu > ul > li > ul > li {
    margin: 0;
    padding-bottom: 0;
    list-style: none;
    width: 10%;
    background: none;
    float: left;
    padding: 0px 7px;
}

.menu > ul > li > ul > li a {
    color: #F50057;
    padding: .2em 0;
    width: 95%;
    display: block;
    border-bottom: 1px solid #ccc;
}

.menu > ul > li > ul > li > ul {
    display: block;
    padding: 0;
    margin: 5px 0 0;
    list-style: none;
    box-sizing: border-box;
}

.menu > ul > li > ul > li > ul:before,
.menu > ul > li > ul > li > ul:after {
    content: "";
    display: table;
}

.menu > ul > li > ul > li > ul:after {
    clear: both;
}

.menu > ul > li > ul > li > ul > li {
    float: left;
    width: 100%;
    padding: 2px 0;
    margin: 0;
    font-size: .9em;
}

.menu > ul > li > ul > li > ul > li a {
    border: 0;
    color: #212121;
}

.menu > ul > li > ul.normal-sub {
    width: 300px;
    left: auto;
    padding: 10px 20px;
}

.menu > ul > li > ul.normal-sub > li {
    width: 100%;
}

.menu > ul > li > ul.normal-sub > li a {
    border: 0;
    padding: 1em 0;
}
</style>