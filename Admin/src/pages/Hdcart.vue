<template>
  <f7-page>
  <div>
    <div class="marginzero" style="position: fixed;width: 100%;top:0px;left:0px;">
      <div class=" paddingzero" style="border-right: 1px solid #FFFFFF">
        <a href="javascript:void(0)" class="rep_tab" style="font-size: 20px;font-style: ">Customers</a>
      </div>
    </div>
    <div class="row marginzero" style="margin-top: 60px">
      <div class="col-lg-2 col-md-2 col-sm-2 sidebar">
        <ul class="list-unstyled">
          <li><a href="/" style="font-size:20px">All Customers<span class="glyphicon glyphicon-menu-right pull-right menu_arrow"></span></a></li>
          <li><a style="font-size:20px" href="/wishlist">Wishlist Msg<span class="glyphicon glyphicon-menu-right pull-right menu_arrow"></span></a></li>
          <li><a style="font-size:20px" href="/hdcart">Hd Cart Msg<span class="glyphicon glyphicon-menu-right pull-right menu_arrow"></span></a></li>
          <li><a style="font-size:20px" href="/visitshop">Visit Shop Msg<span class="glyphicon glyphicon-menu-right pull-right menu_arrow"></span></a></li>
          <li><a style="font-size:20px" href="/call">Call Msg<span class="glyphicon glyphicon-menu-right pull-right menu_arrow"></span></a></li>
          <li><a style="font-size:20px" href="/whatsapp">Whatsapp Msg<span class="glyphicon glyphicon-menu-right pull-right menu_arrow"></span></a></li>
          <li><a style="font-size:20px" href="chat">Chat Msg<span class="glyphicon glyphicon-menu-right pull-right menu_arrow"></span></a></li>
          <li  style="background-color: red;"><a href="javascript:void(0)" style="font-size:20px">Wallet Msg<span class="glyphicon glyphicon-menu-right pull-right menu_arrow"></span></a></li>
        </ul>
      </div>
      <div style="float:right;width:60%;margin-left:210px">
        <div>
          <h4><label class="addpro_title" style="margin-top: 30px">Message :</label></h4>
          <textarea style="height:80%" rows="8" class="form-control" ></textarea>
          <button class="btn btn-green btn-block btn-sm" type="button" style="margin-top:30px">Send</button>
        </div>
      </div>
    </div>
  </div> 
  </f7-page>
</template>

<script>
import axios from '../axios';
export default {
  name: 'wallet',
  data(){
    return{
      
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
.sidebar ul li a:hover{
  background-color: #37474F;
  color: #ffffff;
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
.btn-green:hover,.btn-green:active
{
 background:transparent;
 transitions:500ms;
 border:2px solid #1dbf73;
 color: #1dbf73 !important;
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
.btn-blue:hover,.btn-blue:active
{
 background:transparent;
 transitions:500ms;
 border:2px solid #1E88E5;
 color: #1E88E5 !important;
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
.btn-orange:hover,.btn-orange:active 
{
 background:transparent;
 transitions:500ms;
 border:2px solid #f49d41;
 color: #f49d41 !important;
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
.btn-red:hover,.btn-red:active 
{
 background:transparent;
 transitions:500ms;
 border:2px solid #E53935;
 color: #E53935 !important;
}
.rep_tab{
  display: block;
  text-align:center;
  padding: 15px 10px;
  text-decoration: none !important;
  background-color:#0277BD;
  color: #FFFFFF; 
}
.rep_tab:hover{
  color: #FFFFFF;
  background-color: #0091EA;
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

.menu > ul > li:hover{
    background-color: #76FF03;
}
.cat_title{
    text-decoration: none;
    padding: 1em 3em;
    display: block;
    text-align:left;
    color: #FFFFFF;
}
.cat_title:hover{
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
.menu > ul > li > ul > li > ul > li a:hover {
    color:#0288D1;
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
