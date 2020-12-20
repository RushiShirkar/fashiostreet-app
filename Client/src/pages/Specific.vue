<template>
	<f7-page login-screen>
	<div v-show="page==false">
		<f7-navbar back-link="Back" class="bgnav" style="border-radius:0px 0px 30px 0px;box-shadow: 5px 0px 10px rgba(0, 0, 0, 0.12)" sliding>
			<f7-nav-title style="font-size:18px;font-weight:bold;margin:0px" v-if="which=='clothing'">
				Clothing
      </f7-nav-title>
      <f7-nav-title style="font-size:18px;font-weight:bold;margin:0px" v-if="which=='deodorant'">
        Deodorant
      </f7-nav-title>
      <f7-nav-title style="font-size:18px;font-weight:bold;margin:0px" v-if="which=='footwear'">
        Footwear
      </f7-nav-title>
      <f7-nav-title style="font-size:18px;font-weight:bold;margin:0px" v-if="which=='electronicaccs'">
        Electronic Accessories
      </f7-nav-title>
	      	<f7-nav-right>
	    	</f7-nav-right>
    	</f7-navbar>
	    <offline @detected-condition="handleConnectivityChange">
	  	</offline>
	  	<h3 style ="padding-left:16px">Tell Us - What Are Your Looking For ?</h3>
	  		<f7-list form style="margin:5px 0px 0px 0px;padding-bottom:93px" v-show="which=='clothing'">
        		<f7-list-item>
        			<h5 style="color:red;text-transform:uppercase;margin:0px">{{categoryerror}}</h5>
          			<f7-label floating>Category: Eg. T-Shirt,Jeans</f7-label>
          			<f7-input type="text" @input="category=$event.target.value" clear-button></f7-input>
        		</f7-list-item>
        		<f7-list-item>
        			<h5 style="color:red;text-transform:uppercase;margin:0px">{{priceerror}}</h5>
          			<f7-label floating>Price Range: Eg. 400-500</f7-label>
          			<f7-input type="text" @input="price = $event.target.value" clear-button></f7-input>
        		</f7-list-item>
        		<f7-list-item>
        			<h5 style="color:red;text-transform:uppercase;margin:0px">{{colorerror}}</h5>
          			<f7-label floating>Color: Eg. White,Black</f7-label>
          			<f7-input type="text" @input="color = $event.target.value" clear-button></f7-input>
        		</f7-list-item>
        		<f7-list-item>
        			<h5 style="color:red;text-transform:uppercase;margin:0px">{{sizeerror}}</h5>
          			<f7-label floating>Size: Eg. M, L, XL</f7-label>
          			<f7-input type="text" @input="size = $event.target.value"  clear-button></f7-input>
        		</f7-list-item>
        		<f7-list-item>
          			<f7-label floating>Other Details</f7-label>
          			<f7-input type="text" @input="description = $event.target.value" clear-button></f7-input>
        		</f7-list-item>
      		</f7-list>
          <f7-list form style="margin:5px 0px 0px 0px;padding-bottom:93px" v-show="which=='deodorant'">
            <f7-list-item>
              <h5 style="color:red;text-transform:uppercase;margin:0px">{{branderror}}</h5>
                <f7-label floating>Brand</f7-label>
                <f7-input type="text" @input="brand = $event.target.value" clear-button></f7-input>
            </f7-list-item>
            <f7-list-item>
              <h5 style="color:red;text-transform:uppercase;margin:0px">{{volumeerror}}</h5>
                <f7-label floating>Volume (120ml, 150ml)</f7-label>
                <f7-input type="text" @input="volume = $event.target.value"  clear-button></f7-input>
            </f7-list-item>
            <f7-list-item>
                <f7-label floating>Other Details</f7-label>
                <f7-input type="text" @input="description = $event.target.value" clear-button></f7-input>
            </f7-list-item>
          </f7-list>
          <f7-list form style="margin:5px 0px 0px 0px;padding-bottom:93px" v-show="which=='footwear'">
            <f7-list-item>
              <h5 style="color:red;text-transform:uppercase;margin:0px">{{categoryerror}}</h5>
                <f7-label floating>Category: Eg. Chappals,Sandals</f7-label>
                <f7-input type="text" @input="category=$event.target.value" clear-button></f7-input>
            </f7-list-item>
            <f7-list-item>
              <h5 style="color:red;text-transform:uppercase;margin:0px">{{priceerror}}</h5>
                <f7-label floating>Price Range: Eg. 400-500</f7-label>
                <f7-input type="text" @input="price = $event.target.value" clear-button></f7-input>
            </f7-list-item>
            <f7-list-item>
              <h5 style="color:red;text-transform:uppercase;margin:0px">{{colorerror}}</h5>
                <f7-label floating>Color: Eg. White,Black</f7-label>
                <f7-input type="text" @input="color = $event.target.value" clear-button></f7-input>
            </f7-list-item>
            <f7-list-item>
              <h5 style="color:red;text-transform:uppercase;margin:0px">{{sizeerror}}</h5>
                <f7-label floating>Size: Eg. 7, 8, 9, 10</f7-label>
                <f7-input type="text" @input="size = $event.target.value"  clear-button></f7-input>
            </f7-list-item>
            <f7-list-item>
                <f7-label floating>Other Details</f7-label>
                <f7-input type="text" @input="description = $event.target.value" clear-button></f7-input>
            </f7-list-item>
          </f7-list>
      		<f7-block style="margin:0px;padding:0px;position:fixed;bottom:0;z-index:999;width:100%;background-color:white;box-shadow: 5px 0px 10px rgba(0, 0, 0, 0.12);border-radius:30px 30px 0px 0px">
    <div style="position:fixed;bottom:0;z-index:999;width:100%;background-color:#FFFFFF;box-shadow: 5px 0px 10px rgba(0, 0, 0, 0.12);border-radius:30px 30px 0px 0px">
        <f7-button :disabled="disabled" @click="sendOrder" big fill style="background-image: linear-gradient(to right, #11998e, #38ef7d);color:#FFFFFF;font-size:18px;font-weight:bold;border:0px;text-transform:Capitalize;margin:10px;border-radius:30px">Send Enquiry <f7-icon f7="chevron_right" style="margin:-5px 0px 0px 10px"></f7-icon></f7-button>
    </div>
  </f7-block>
    </div>
    <div style="margin-top:120px" v-show="page == true">
      <center>
      <div class="check_mark">
        <div class="sa-icon sa-success animate">
          <span class="sa-line sa-tip animateSuccessTip"></span>
          <span class="sa-line sa-long animateSuccessLong"></span>
          <div class="sa-placeholder"></div>
          <div class="sa-fix"></div>
        </div>
      </div>
        <br/>
      <h3 style="color:black">Enquiry Successfully Sent</h3>
      <h5>You will get update regarding enquiry through<br>text message and whatsapp</h5>
      <f7-button href="/" fill style="background-image: linear-gradient(to right, #11998e, #38ef7d);height:50px;line-height:50px;font-size:14px;font-weight:750;border-radius:30px;margin:25px 15px 0px 15px">Continue Shopping <f7-icon f7="chevron_right" style="margin:-5px 0px 0px 10px"></f7-icon></f7-button>
      <h4>If you have any image of product<br>then send us on whatsapp</h4>
      <a class="link external" :href="'https://wa.me/+918600198512'" style="color:green;font-size:16px;font-weight:bold;border:1px solid green;padding:8px 16px;border-radius:30px;line-height:18px"><center><img src="../assets/whatsapp-logo.svg" alt="chat with shopkeeper"><div style="display:inline-block;padding-left:8px;position: relative;bottom:5px">Whatsapp</div></center></a>
      </center>
    </div>
	</f7-page>
</template>

<script>
	import offline from 'v-offline';
	import axios from '../axios';
	export default
	{
		name: 'Specific',
		data(){
			return{
				internet : null,
				status : 'not shown',
				category : null,
				price : null,
				size : null,
				color : null,
        brand:null,
				description : null,
        volume:null,
        model:null,
        modelerror:null,
        volumeerror:null,
        branderror:null,
				categoryerror : null,
				sizeerror : null,
				colorerror : null,
				priceerror : null,
				id: null,
				token : null,
				page : false,
        whatsapp:null,
        whatsapperror:null,
        which:localStorage.getItem('specific')
			};
		},
		mounted(){
			this.id = localStorage.getItem('local_id');
			this.token = localStorage.getItem('token');
      if(localStorage.getItem('gen')!=null && localStorage.getItem('cat')!=null && localStorage.getItem('specific')=='clothing')
      {
        this.category = ''+localStorage.getItem('gen')+' - '+localStorage.getItem('cat');
        console.log(this.category);
      }
      else
      {
        this.category = '';
      }
		},
		components:{
			offline
		},
		methods:{
      handleConnectivityChange(status) 
      {
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
        showNotificationWithButton() 
        {
            const self = this;
            if (!self.notificationWithButton) 
            {
              self.notificationWithButton = self.$f7.notification.create({
                  icon: '',
                  title: '',
                  cssClass:'color',
                  subtitle: 'Please Connect to Internet',
                  text: ''
              });
            }
            self.notificationWithButton.open();
          },
        closepop:function()
        {
          const self = this;
          self.notificationWithButton.close();
        },
        openPopup:function()
        {
          if(this.status == 'notshown')
          {
            this.popupOpened = true;
            this.status = 'shown';
          }
        },
        deodorant:function(){
          if(this.brand==null || this.brand=="")
            {
              this.branderror = "Enter Brand";
            }
            else
            {
              this.branderror = null;
            }
            if(this.volume==null || this.volume=="")
            {
              this.volumeerror = "Enter Size";
            }
            else
            {
              this.volumeerror = null;
            }
            this.whatsapp = localStorage.getItem('loginmobile');
            if(this.volume!=null && this.brand!=null && this.brand!="" && this.volume!="")
            {
                this.page= true;
                axios({
                      method:'POST',
                      url : '/specific',
                      header : {
                        'local-id' : localStorage.getItem('local_id'),
                        'token' : localStorage.getItem('token')
                      },
                      data:{
                        'brand' : this.brand,
                        'size' : this.volume,
                        'description' : this.description,
                        'mobile' : this.whatsapp,
                        'which' : this.which
                      }
                    }).then(response => {
                      console.log(response);
                      this.page= true;
                      this.brand = null;
                      this.volume = null;
                      this.description = null;
                      this.whatsapp = null;
                    },(error) => {
                  alert(error.response.data.message);
                    });
                this.branderror = null;
                this.volumeerror = null;          
            }
        },
        footwear:function(){
          if(this.category==null || this.category=="")
          {
            this.categoryerror = "Enter Category";
          }
          else
          {
            this.categoryerror = null;
          }
          if(this.price==null || this.price=="")
          {
            this.priceerror = "Enter Price";
          }
          else
          {
            this.priceerror = null;
          }
          if(this.color==null || this.color=="")
          {
            this.colorerror = "Enter Color";
          }
          else
          {
            this.colorerror = null;
          }
          if(this.size==null || this.size=="")
          {
            this.sizeerror = "Enter Size";
          }
          else
          {
            this.sizeerror = null;
          }
          this.whatsapp = localStorage.getItem('loginmobile');
          if(this.size!=null && this.price!=null && this.color!=null && this.category!=null && this.category!="" && this.price!="" && this.color!="" && this.size!="")
          {
              this.page= true;
              axios({
                method:'POST',
                url : '/specific',
                header : {
                  'local-id' : localStorage.getItem('local_id'),
                  'token' : localStorage.getItem('token')
                },
                      data:{
                        'category' : this.category,
                        'price' : this.price,
                        'color' : this.color,
                        'size' : this.size,
                        'description' : this.description,
                        'mobile' : this.whatsapp,
                        'which' : this.which
                      }
                    }).then(response => {
                      console.log(response);
                      this.page= true;
                      this.size = null;
                      this.color = null;
                      this.price = null;
                      this.category = null;
                      this.description = null;
                                localStorage.removeItem('specific');
                                localStorage.removeItem('gen');
                                localStorage.removeItem('cat');
                    },(error) => {
                  alert(error.response.data.message);
                    });
                this.categoryerror = null;
                this.sizeerror = null;
                this.colorerror = null;
                this.priceerror = null;
          }
        },
        clothing:function(){
          if(this.category==null || this.category=="")
          {
            this.categoryerror = "Enter Category";
          }
          else
          {
            this.categoryerror = null;
          }
          if(this.price==null || this.price=="")
          {
            this.priceerror = "Enter Price";
          }
          else
          {
            this.priceerror = null;
          }
          if(this.color==null || this.color=="")
          {
            this.colorerror = "Enter Color";
          }
          else
          {
            this.colorerror = null;
          }
          if(this.size==null || this.size=="")
          {
            this.sizeerror = "Enter Size";
          }
          else
          {
            this.sizeerror = null;
          }
          this.whatsapp = localStorage.getItem('loginmobile');
          if(this.size!=null && this.price!=null && this.color!=null && this.category!=null && this.category!="" && this.price!="" && this.color!="" && this.size!="")
          {
              this.page= true;
              axios({
                method:'POST',
                url : '/specific',
                header : {
                  'local-id' : localStorage.getItem('local_id'),
                  'token' : localStorage.getItem('token')
                },
                      data:{
                        'category' : this.category,
                        'price' : this.price,
                        'color' : this.color,
                        'size' : this.size,
                        'description' : this.description,
                        'mobile' : this.whatsapp,
                        'which' : this.which
                      }
                    }).then(response => {
                      console.log(response);
                      this.page= true;
                      this.size = null;
                      this.color = null;
                      this.price = null;
                      this.category = null;
                      this.description = null;
                                localStorage.removeItem('specific');
                                localStorage.removeItem('gen');
                                localStorage.removeItem('cat');
                    },(error) => {
                  alert(error.response.data.message);
                    });
                this.categoryerror = null;
                this.sizeerror = null;
                this.colorerror = null;
                this.priceerror = null;
          }
        },
        raincoat:function(){
          if(this.model==null || this.model=="")
            {
              this.modelerror = "Enter Category";
            }
            else
            {
              this.modelerror = null;
            }
            if(this.price==null || this.price=="")
            {
              this.priceerror = "Enter Price";
            }
            else
            {
              this.priceerror = null;
            }
            if(this.color==null || this.color=="")
            {
              this.colorerror = "Enter Color";
            }
            else
            {
              this.colorerror = null;
            }
            if(this.whatsapp==null || this.whatsapp=="")
            {
              this.whatsapperror = "Enter whatsapp number";
            }
            else{
              this.whatsapperror = null;
            }
            if(this.model!=null && this.price!=null && this.price!="" && this.color!=null && this.color!="" && this.model!="" && this.whatsapp!=null && this.whatsapp!="")
            {
              if(this.whatsapp.length!=10)
              {
                this.whatsapperror = "Enter 10 digit whatsapp number";
              }
              else
              {
                this.page= true;
                axios({
                      method:'POST',
                      url : '/specific',
                      header : {
                        'local-id' : localStorage.getItem('local_id'),
                        'token' : localStorage.getItem('token')
                      },
                      data:{
                        'brand' : this.brand,
                        'price' : this.price,
                        'color' : this.color,
                        'description' : this.description,
                        'mobile' : this.whatsapp,
                        'which' : this.which
                      }
                    }).then(response => {
                      console.log(response);
                      this.page= true;
                      this.model = null;
                      this.color = null;
                      this.price = null;
                      this.description = null;
                      this.whatsapp = null;
                                localStorage.removeItem('specific');
                    },(error) => {
                  alert(error.response.data.message);
                    });
                this.modelerror = null;
                this.priceerror = null;
                this.colorerror = null;
                this.whatsapperror = null;
              }
            }
        },
        electronic:function(){
          if(this.category==null || this.category=="")
            {
              this.categoryerror = "Enter Category";
            }
            else
            {
              this.categoryerror = null;
            }
            if(this.price==null || this.price=="")
            {
              this.priceerror = "Enter Price";
            }
            else
            {
              this.priceerror = null;
            }
            if(this.whatsapp==null || this.whatsapp=="")
            {
              this.whatsapperror = "Enter whatsapp number";
            }
            else{
              this.whatsapperror = null;
            }
            if(this.category!=null && this.price!=null && this.price!="" && this.category!="" && this.whatsapp!=null && this.whatsapp!="")
            {
              this.page= true;
              axios({
                    method:'POST',
                    url : '/specific',
                    header : {
                      'local-id' : localStorage.getItem('local_id'),
                      'token' : localStorage.getItem('token')
                    },
                    data:{
                      'category' : this.category,
                      'price' : this.price,
                      'description' : this.description,
                      'mobile' : this.whatsapp,
                      'which' : this.which
                    }
                  }).then(response => {
                    console.log(response);
                    this.page= true;
                    this.category = null;
                    this.price = null;
                    this.description = null;
                    this.whatsapp = null;
                              localStorage.removeItem('specific');
                  },(error) => {
                alert(error.response.data.message);
              });
              this.categoryerror = null;
              this.priceerror = null;
              this.whatsapperror = null;
            }
        },
			sendOrder:function()
			{
        if(this.which=='clothing')
        {
          this.clothing();
        }
          else if(this.which=='deodorant')
          {
            this.deodorant();
          }
          else if(this.which=='raincoat')
          {
            this.raincoat();
          }
          else if(this.which=='electronicaccs')
          {
            this.electronic();
          }
          else
          {

          }
        }
      }
	};
</script>

<style scoped>
	.md .navbar:after{
  content:none
  }
  .sa-icon {
    width: 80px;
    height: 80px;
    border: 4px solid gray;
    -webkit-border-radius: 40px;
    border-radius: 40px;
    border-radius: 50%;
    margin: 20px auto;
    padding: 0;
    position: relative;
    box-sizing: content-box;
  }

  .sa-icon.sa-success {
    border-color: #4CAF50;
  }

  .sa-icon.sa-success::before, .sa-icon.sa-success::after {
    content: '';
    -webkit-border-radius: 40px;
    border-radius: 40px;
    border-radius: 50%;
    position: absolute;
    width: 74px;
    height: 120px;
    background: white;
    -webkit-transform: rotate(45deg);
    transform: rotate(45deg);
  }

  .sa-icon.sa-success::before {
    -webkit-border-radius: 120px 0 0 120px;
    border-radius: 120px 0 0 120px;
    top: -19px;
    left: -22px;
    -webkit-transform: rotate(-45deg);
    transform: rotate(-45deg);
    -webkit-transform-origin: 60px 60px;
    transform-origin: 60px 60px;
  }

  .sa-icon.sa-success::after {
    -webkit-border-radius: 0 120px 120px 0;
    border-radius: 0 120px 120px 0;
    top: -11px;
    left: 30px;
    -webkit-transform: rotate(-45deg);
    transform: rotate(-45deg);
    -webkit-transform-origin: 0px 60px;
    transform-origin: 0px 60px;
  }

  .sa-icon.sa-success .sa-placeholder {
    width: 80px;
    height: 80px;
    border: 4px solid rgba(76, 175, 80, .5);
    -webkit-border-radius: 40px;
    border-radius: 40px;
    border-radius: 50%;
    box-sizing: content-box;
    position: absolute;
    left: -4px;
    top: -4px;
    z-index: 2;
  }

  .sa-icon.sa-success .sa-fix {
    width: 5px;
    height: 90px;
    background-color: white;
    position: absolute;
    left: 28px;
    top: 8px;
    z-index: 1;
    -webkit-transform: rotate(-45deg);
    transform: rotate(-45deg);
  }

  .sa-icon.sa-success.animate::after {
    -webkit-animation: rotatePlaceholder 4.25s ease-in;
    animation: rotatePlaceholder 4.25s ease-in;
  }

  .sa-icon.sa-success {
    border-color: transparent\9;
  }
  .sa-icon.sa-success .sa-line.sa-tip {
    -ms-transform: rotate(45deg) \9;
  }
  .sa-icon.sa-success .sa-line.sa-long {
    -ms-transform: rotate(-45deg) \9;
  }

  .animateSuccessTip {
    -webkit-animation: animateSuccessTip 0.75s;
    animation: animateSuccessTip 0.75s;
  }

  .animateSuccessLong {
    -webkit-animation: animateSuccessLong 0.75s;
    animation: animateSuccessLong 0.75s;
  }

  @-webkit-keyframes animateSuccessLong {
    0% {
      width: 0;
      right: 46px;
      top: 54px;
    }
    65% {
      width: 0;
      right: 46px;
      top: 54px;
    }
    84% {
      width: 55px;
      right: 0px;
      top: 35px;
    }
    100% {
      width: 47px;
      right: 8px;
      top: 38px;
    }
  }
  @-webkit-keyframes animateSuccessTip {
    0% {
      width: 0;
      left: 1px;
      top: 19px;
    }
    54% {
      width: 0;
      left: 1px;
      top: 19px;
    }
    70% {
      width: 50px;
      left: -8px;
      top: 37px;
    }
    84% {
      width: 17px;
      left: 21px;
      top: 48px;
    }
    100% {
      width: 25px;
      left: 14px;
      top: 45px;
    }
  }
  @keyframes animateSuccessTip {
    0% {
      width: 0;
      left: 1px;
      top: 19px;
    }
    54% {
      width: 0;
      left: 1px;
      top: 19px;
    }
    70% {
      width: 50px;
      left: -8px;
      top: 37px;
    }
    84% {
      width: 17px;
      left: 21px;
      top: 48px;
    }
    100% {
      width: 25px;
      left: 14px;
      top: 45px;
    }
  }

  @keyframes animateSuccessLong {
    0% {
      width: 0;
      right: 46px;
      top: 54px;
    }
    65% {
      width: 0;
      right: 46px;
      top: 54px;
    }
    84% {
      width: 55px;
      right: 0px;
      top: 35px;
    }
    100% {
      width: 47px;
      right: 8px;
      top: 38px;
    }
  }

  .sa-icon.sa-success .sa-line {
    height: 5px;
    background-color: #4CAF50;
    display: block;
    border-radius: 2px;
    position: absolute;
    z-index: 2;
  }

  .sa-icon.sa-success .sa-line.sa-tip {
    width: 25px;
    left: 14px;
    top: 46px;
    -webkit-transform: rotate(45deg);
    transform: rotate(45deg);
  }

  .sa-icon.sa-success .sa-line.sa-long {
    width: 47px;
    right: 8px;
    top: 38px;
    -webkit-transform: rotate(-45deg);
    transform: rotate(-45deg);
  }

  @-webkit-keyframes rotatePlaceholder {
    0% {
      transform: rotate(-45deg);
      -webkit-transform: rotate(-45deg);
    }
    5% {
      transform: rotate(-45deg);
      -webkit-transform: rotate(-45deg);
    }
    12% {
      transform: rotate(-405deg);
      -webkit-transform: rotate(-405deg);
    }
    100% {
      transform: rotate(-405deg);
      -webkit-transform: rotate(-405deg);
    }
  }
  @keyframes rotatePlaceholder {
    0% {
      transform: rotate(-45deg);
      -webkit-transform: rotate(-45deg);
    }
    5% {
      transform: rotate(-45deg);
      -webkit-transform: rotate(-45deg);
    }
    12% {
      transform: rotate(-405deg);
      -webkit-transform: rotate(-405deg);
    }
    100% {
      transform: rotate(-405deg);
      -webkit-transform: rotate(-405deg);
    }
  }
</style>