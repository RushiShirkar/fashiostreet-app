<template>
	<f7-page>
		<f7-navbar back-link="Back" class="bgnav" sliding>
			<f7-nav-title style="font-size:15px;margin:0px;text-transform:uppercase">
				Ongoing shop offers
      		</f7-nav-title>
	      	<f7-nav-right>
	    	</f7-nav-right>
    	</f7-navbar>
	    <offline @detected-condition="handleConnectivityChange"></offline>
	    <center>
        <div v-if="preloader" class="preloader" style="margin:25px 0px 10px 0px">
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
      </center>
      <div v-show="!preloader">
	    <f7-list no-hairlines style="margin:12px 8px">
  			<template v-for="(result,index) in shopinfo">
	      			<f7-card style="margin:12px 0px;padding:10px 16px;background-color:#FFFFFF;box-shadow:0px 1px 6px 0px rgba(0, 0, 0, 0.1);border-radius:4px" v-show="result.offers!=null">
					    <f7-link href="/shophome/" @click="saveshop(result.name)" style="width:100%;" >
					    <f7-list no-hairlines style="margin:0px;width:100%;">
					    	<template v-for="offer in result.offers">
					    		<p style="padding:8px;margin-top:8px;background-color:skyblue;color:navy;text-align: center;font-weight: bold;border-radius:3px">{{offer}}</p>
							</template>
							<h4 style="color:#000000;margin:5px 0px 8px 0px">by {{result.name}}</h4>
						</f7-list>
	    			</f7-link>
	    			</f7-card>
        	</template>
        </f7-list>
        </div>
	</f7-page>
</template>

<script>
	import offline from 'v-offline';
	import axios from '../axios';
	export default
	{
		name: 'Ongoing',
		data(){
			return{
				internet : null,
				status : 'not shown',
				shopinfo : [],
				page : 1,
				offers : [],
				id : null,
				token : null,
				preloader:true

			};
		},
		components:{
			offline
		},
		mounted(){
			this.getList();
			this.id = localStorage.getItem('local_id');
			this.token = localStorage.getItem('token');
		},
		methods:{
			saveshop:function(sname)
    		{
      			localStorage.setItem("sname",sname);
    		},
			getList(){
				axios({
		        method:'GET',
		        url : '/shop/'+localStorage.getItem('city')
		      }).then((response) => {
		      	  var a = 0;
		      	  this.preloader = false;
		          this.shopinfo=response.data.result;
		          for(var i=0;i<this.shopinfo.length;i++)
		          {
		          	console.log(this.shopinfo[i].offers);
		          }
		          for(var i=0;i<this.shopinfo.length;i++)
		          {

		          	if(this.shopinfo[i].offers!=null)
		          	{
		          		a = parseInt(a)+1;
		          		this.shopinfo[i].offers = this.shopinfo[i].offers.split(',');
		          	}
		          }  
		          console.log(this.shopinfo[i].offers.length);
		          	console.log(a); 
		      },(error) => {
		        //this.inProcess = false;
		        if (error.response.data.message != undefined) {
		          alert(error.response.data.message);
		        }
		        else
		          alert('application error found,restart your application');
		      });
			},
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
    		}
		}
	};
</script>

<style scoped>

</style>
