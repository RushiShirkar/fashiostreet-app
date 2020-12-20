<template>
	<f7-page>
		<div class="row marginzero" style="position: fixed;width: 100%;top:0px;left:0px;">
	      <div class="col-md-11 " style="border-right: 1px solid #FFFFFF">
	        <a href="javascript:void(0)" class="rep_tab" style="font-size:14px">Orders</a>
	      </div>
	      <div class="col-md-1" style="border-right: 1px solid #FFFFFF">
	        <f7-link href="/" class="rep_tab">Customers</f7-link>
	      </div>
    	</div>
        <div class="table-responsive" style="margin-top: 50px" >
            <table class="table table-striped">
                <thead>
                    <tr class="info">
                        <th>Order No.</th>
                        <th>Customer Details</th>
                        <th>Acc. Mob No.</th>
                        <th>Products</th>
                        <th>Total Amt.</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <template v-for="(order,index) in orders">
                    	<tr>
	                       	<td align="center">{{order.id}}</td>
	                        <td>
	                            <span style="color: #1dbf73">({{status[index]}})</span><br>
	                            {{order.customer_name}}<br>{{order.address}}
	                        </td>
	                        <td align="center">{{order.contact}}</td>
	                        <td align="center">
	                        	<template v-for="(product,index) in order.products">
		                            <div class="row">
		                                <div class="col-md-4 paddingzero"><img class="img-responsive logo" style="height: 120px" :src="product.image[0]"></div>
		                                <div class="col-md-8" style="text-align: left">
		                                   	<span v-show="product.specialDiscount == true" style="color:#000000;font-size:17px">&#8377;{{product.specialDiscountedPrice}}</span>
                    <span v-show="product.specialDiscount == false" style="color:#000000;font-size:17px">&#8377;{{product.selling_price}} </span>
                    <span v-show="product.specialDiscount == true" style="color:#000000;font-size:17px;text-decoration:line-through;">&#8377;{{product.selling_price}} </span>
		                                    <span style="text-decoration: line-through;">Rs.{{product.mrp_price}}</span><br>
		                                    Size : {{product.size_name[0].name}} &nbsp | &nbsp Qty : {{product.qty}}<br>
		                                    Shop : {{product.shop_name[0].name}}<br>
		                                    <div class="row">
		                                        <div class="col-md-6">
		                                            <f7-button :href="'/productdetails/' + product.product_id + '/' + product.name" class="btn btn-orange btn-block btn-sm" type="button">View</f7-button>
		                                        </div>
		                                        <div class="col-md-6">
		                                            <f7-button @click="restock(order.id,product.product_id,product.size_name[0].name)" class="btn btn-green btn-block btn-sm" type="button">Re-stock</f7-button>
		                                        </div>
		                                    </div> 
		                                </div>
		                            </div>
		                        </template>
	                        </td>
	                        <td>
	                            Sub-Total : Rs.{{subTotal[index]}}<br>
	                            Promocode : -Rs.{{promocodes[index]}}<br>
	                            Wallet : -Rs.{{cashbacks[index]}}<br>
	                            <b style="font-size: 17px">Total : Rs.{{subTotal[index]-cashbacks[index]-promocodes[index]}}</b>
	                        </td>
	                        <td>
	                            <f7-button @click="delivered(order.id,order.products[0].shop_name[0].name)" class="btn btn-blue btn-block btn-sm">Delivered</f7-button>
	                            <f7-button @click="cancelled(order.id,subTotal[index],promocodes[index],cashbacks[index])" class="btn btn-red btn-block btn-sm">Cancelled</f7-button>
	                            <!--<f7-button class="btn btn-green btn-block btn-sm">Share</f7-button>-->
	                        </td>
                    	</tr>
                    </template>
                </tbody>
            </table>
        </div>
	</f7-page>
</template>

<script>
import axios from '../../axios';
export default{
	name:'order',
	data(){
		return{
			orders:[],
			promocodes:[],
			cashbacks:[],
			status:[],
			subTotal:[]
		}
	},
	created()
	{
		this.getOrders();
	},
	methods:
	{
		getOrders()
		{
			axios({
		        method:'GET',
		        url : '/getAllOrders'
		    }).then(response => {
		        this.orders = response.data.result.orders;
		        for(var i=0;i<this.orders.length;i++)
		        {
		        	for(var j=0;j<this.orders[i].products.length;j++)
		        	{
		        		if(this.orders[i].products[j].specialDiscount == true)
		        		{
		        			this.orders[i].products[j].selling_price = this.orders[i].products[j].specialDiscountedPrice;
		        		}
		        	}
		        }
		        for(var i=0;i<this.orders.length;i++)
		        {
		        	if(this.orders[i].cashback>0)
		        		this.cashbacks[i] = this.orders[i].cashback;
		        	else
		        		this.cashbacks[i] = 0;
		        }
		        for(var i=0;i<this.orders.length;i++)
		        {
		        	if(this.orders[i].completed==1)
		        		this.status[i] = 'Order Delivered';
		        	if(this.orders[i].completed==2)
		        		this.status[i] = 'Order Cancelled';
		        	if(this.orders[i].completed==0)
		        		this.status[i] = 'Order Pending';
		        }
		        for(var i=0;i<this.orders.length;i++)
		        {
		        	this.subTotal[i] = Math.floor(0);
		        	for(var j=0;j<this.orders[i].products.length;j++)
		        	{
		        		this.subTotal[i] = Math.floor(this.subTotal[i] + Math.floor(this.orders[i].products[j].selling_price));
		        	}
		        }
		        for(var i=0;i<this.orders.length;i++)
		        {
		        	if(this.orders[i].promocode == 'SUPER30')
		        	{
		        		this.promocodes[i] = Math.floor(((this.subTotal[i]-this.cashbacks[i])*30)/100);
		        		if(this.promocodes[i]>50)
		        			this.promocodes[i] = 50;
		        	}
		        	else
		        	{
		        		this.promocodes[i] = 0;
		        	}
		        }
		        console.log(this.promocodes);
		        console.log(response);
		    }).catch(error => {
		        if(error.response.data.message != undefined)
		        {
		          alert(error.response.data.message);
		        }
		        else
		          alert('Something went wrong,please try again');
		    });
		},
		cancelled(id,total,cashback,promocode)
		{
			if(confirm("Do you really want to Cancel this order?"))
      		{
      			const self = this;
        		self.$f7.dialog.preloader('Cancelling....');
				axios({
		          method:'POST',
		          url : '/cancelled',
		          data:{
		            'order_id' : id,
		            'total' : total,
		            'cashback' : cashback,
		            'promocode' : promocode
		          }
		        }).then(response => {
		           	setTimeout(() => {
            			self.$f7.dialog.close();
            			alert(response.data.result);
          			}, 1000);
          			location.reload();
		        }).catch(error => {
		          if(error.response.data.message != undefined)
		            alert(error.response.data.message);
		          else
		            alert('failed please retry');
		        });
		    }
		},
		restock(order_id,product_id,size_name)
		{
			if(confirm("Do you really want to Re-stock this product?"))
      		{
      			const self = this;
        		self.$f7.dialog.preloader('Re-stocking....');
				axios({
		          method:'POST',
		          url : '/restock',
		          data:{
		            'order_id' : order_id,
		            'product_id' : product_id,
		            'size_name': size_name
		          }
		        }).then(response => {
		           	setTimeout(() => {
            			self.$f7.dialog.close();
            			alert(response.data.result);
          			}, 1000);
          			location.reload();
		        }).catch(error => {
		          if(error.response.data.message != undefined)
		            alert(error.response.data.message);
		          else
		            alert('failed please retry');
		        });
		    }	
		},
		delivered(id,shop_name)
		{
			if(confirm("Do you really want to delivered?"))
      		{
      			const self = this;
        		self.$f7.dialog.preloader('Delivering....');
				axios({
		          method:'POST',
		          url : '/delivered',
		          data:{
		            'order_id' : id,
		            'shop_name' : shop_name
		          }
		        }).then(response => {
		        	alert(response.data.result);
		        	location.reload();
		        }).catch(error => {
		          if(error.response.data.message != undefined)
		            alert(error.response.data.message);
		          else
		            alert('failed please retry');
		        });
		    }
		}
	}
};
</script>

<style scoped>

.rep_tab{
  display: block;
  text-align:center;
  padding: 15px 10px;
  text-decoration: none !important;
  background-color:#0277BD;
  color: #FFFFFF; 
}
</style>