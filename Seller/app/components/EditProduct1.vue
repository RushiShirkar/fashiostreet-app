<template>
    <Page actionBarHidden="true" loaded="pageLoaded" :class="{ dialogOpen: dialogOpen }">
        <GridLayout rows="56, 40, *, 3*">
            <GridLayout row="0" columns="50, 2*, *" class="action-bar">
                <Label col="0" class="fa" :text="'fa-angle-left' | fonticon" fontSize="24" fontWeight="500" style="padding:0 20 0 20;vertical-align:middle" @tap="back" />
                <Label col="1" text="Edit Product " fontSize="20" fontWeight="500" style="vertical-align:middle"/>
                <StackLayout col="2" class="btn btn-upload" horizontalAlignment="right" 
                        style="vertical-align:middle" @tap="onButtonTap">
                    <Label text="SAVE" style="padding:5"  horizontalAlignment="center" :visibility="!show ? 'visible':'collapse'"/>
                    <ActivityIndicator :busy="show"  height="20" width="20" style="color:#344955"/>
                </StackLayout>
            </GridLayout>
             <ActivityIndicator :busy="showLogin" height="30" width="30" marginTop="15" style="color:#344955" :visibility="showLogin ? 'visible':'collapse'"/>
            <Label :text="name2" row="1" style="margin:10 0 0 0;margin-left: 13; margin-right: 13;" />
            <StackLayout row="2" style="margin:0 10 8 10">
                <ScrollView orientation="horizontal">
                    <StackLayout orientation="horizontal">
                        <template v-for="(img,index) in image" >
                            <GridLayout :key="index">
                                <Image :src="'https://seller.fashiostreet.com/products/compress220X258/' +img" width="100" :key="index"
                                    height="125" stretch="aspectFit" margin="0 3"
                                    style="border-width:1; border-color:#C0C0C0;border-radius:4" />
                            </GridLayout>
                        </template>
                    </StackLayout>
                </ScrollView>
            </StackLayout>
            <ScrollView row="3">
                <StackLayout class="form">
                    <GridLayout columns="*, *" marginBottom="15">
                        <StackLayout col="0">
                            <TextField v-model="mrp_price" hint="Enter MRP price" keyboardType="number" />
                        </StackLayout>
                        <StackLayout col="1">
                            <TextField :text="cal_selling_price" v-model="selling_price" @focus="b" @textChange="qwe" hint="Selling price" keyboardType="number" />
                        </StackLayout>
                    </GridLayout>
                    <GridLayout columns="90, *, 60" marginBottom="15">
                        <StackLayout col="0" style="vertical-align: middle;padding:0 3">
                            <Label text="Discount" />
                        </StackLayout>
                        <StackLayout col="1">
                            <TextField v-model="discount" hint="Enter discount" keyboardType="number" />
                        </StackLayout>
                        <StackLayout col="2" @tap="getType" orientation="horizontal" style="vertical-align: middle; horizontal-align:center;">
                            <Label :text="type"/>
                            <Label class="fa" :text="'fa-caret-down' | fonticon" style="padding-left:8" />
                        </StackLayout>
                    </GridLayout>
                    <GridLayout columns="70, *, 30" @tap="showDialog"
                        marginBottom="10" style="padding:5 0 5 0">
                        <StackLayout col="0">
                            <Label text="Sizes" marginLeft="3" />
                        </StackLayout>
                        <StackLayout col="1" orientation="horizontal" horizontalAlignment="right">
                            <template v-for="(size,index) in itemSizes">
                                <Label :text="size.name+','" :key="index"  />
                            </template>
                        </StackLayout>
                        <StackLayout col="2">
                            <Label text="+" class="pull-right" margin="0 10 0 10" />
                        </StackLayout>
                    </GridLayout>
                    <GridLayout columns="*, *, 30" @tap="tapColor"
                        marginBottom="10" style="padding:5 0 5 0">
                        <StackLayout col="0">
                            <Label text="Colors" marginLeft="3" />
                        </StackLayout>
                        <Label col="1" :text="color" horizontalAlignment="right" />
                        <StackLayout col="2">
                            <Label text="+" class="pull-right" margin="0 10 0 10" />
                        </StackLayout>
                    </GridLayout> 
                    <StackLayout class="name" marginBottom="15">
                        <TextView editable="true" hint="Brand name"
                           v-model="brand" autocorrect="true">
                        </TextView>
                    </StackLayout>
                    <StackLayout class="name" marginBottom="15">
                        <TextView editable="true" hint="Enter product description (optional)"
                           v-model="description" autocorrect="true">
                        </TextView>
                    </StackLayout>
                    <Label :text="AutoNameGenerate" marginLeft="3" marginBottom="10" />
                </StackLayout>
            </ScrollView>
            <StackLayout class="bg_sizedialog" rowSpan="4" @tap="closeDialog">
            </StackLayout>
            <StackLayout class="dialog-wrapper" rowSpan="4">
                <StackLayout class="dialog">
                    <GridLayout rows="60, *, 60">
                        <StackLayout row="0" style="border-width:0 0 1 0; border-color:#ECEFF1">
                            <label horizontalAlignment="left" fontSize="20" fontWeight="500" style="padding:18 12 0 12" text="Select Product Sizes"></label>
                        </StackLayout>
                        <ScrollView row="1">
                            <StackLayout class="list-group" style="padding:10 20">
                                <template v-for="(data,index) in sizes1">
                                    <GridLayout columns="30, *, 40" class="list-group-item" :key="index">
                                        <CheckBox col="0" :checked="getSizeStatus(data.size)"
                                            @checkedChange=" AddorRemoveSizes(data.size,$event)" :id="'data_size'+index" />
                                        <Label col="1" :for="'data_size'+index" :text="data.size" style="padding-top:14;font-size:16"/>
                                        <TextField col="2" keyboardType="number" :text="getQtyValue(data.size)" @textChange="updateQty(data.size,$event)"/>
                                    </GridLayout>
                                </template>
                            </StackLayout>
                        </ScrollView>
                        <StackLayout row="2" style="border-width:1 0 0 0; border-color:#ECEFF1">
                            <Label horizontalAlignment="right" fontSize="14" style="padding:18 12 0 12; color:#252323" text="DONE" @tap="closeDialog"/>
                        </StackLayout>
                    </GridLayout>
                </StackLayout>
            </StackLayout>
        </GridLayout>
    </Page>
</template>

<script>
    import Home from './Home';
    import axios from '../axios';
    const application = require("tns-core-modules/application");
    const localStorage = require( "nativescript-localstorage" );
    export default {
        name : 'EditProduct1',
        data() {
            return {
                name2 : '',
                listOfItems : ["Colors", "Brands", "Types", "Sizes"],
                textFieldValue : null,
                itemEnabled : false,
                discount : 0,
                dis: null,
                id : localStorage.getItem("id"),
                dialogOpen : false,
                sizes1: [],
                sizes:null,
                size:[],
                mrp_price : null,
                selling_price : null,
                colorData : null,
                color : [],
                color1 : null,
                images : [],
                image : null,
                name1 : null,
                brand : null,
                type : 'Rs.',
                description : null,
                itemSizes : null,
                gender:null,
                category : null,
                sub_category : null,
                showLogin : false,
                boo : false,
                show : false
            };
        },
        mounted(){
            this.getProduct();
            
        },
        created(){
            axios.defaults.headers = {
                'Content-Type': 'application/json',
                'shopId' : localStorage.getItem('shopId'),
                'token' : localStorage.getItem('token')
            };
            application.android.on(application.AndroidApplication.activityBackPressedEvent, (args) => {
                args.cancel = true;
                //this.$navigateTo(Home); //this cancels the normal backbutton behaviour
            });
        },
        components:{
            Home
        },
        watch:{
            mrp_price:function(newVal)
            {
                this.mrp_price = newVal;
            },
            selling_price:function(newVal)
            {
                this.selling_price = newVal;
            },
            type:function (newVal) {
                this.discount = "0";
                this.selling_price = this.mrp_price;
                this.type = newVal;
            },
            discount:function (newVal) {
                if(this.discount == '' || this.discount == null)
                {
                    newVal = "0";
                }
                else {
                    if (this.type == '%' && newVal > 100) {
                        alert('percent should be less than 100');
                        newVal = 100;
                        this.discount = newVal;
                    }
                    else if (this.type == 'Rs.' && this.discount > this.mrp_price) {
                        alert('discount should be less than mrp price');
                        newVal = this.mrp_price;
                        this.discount = newVal;
                    }
                }
                this.discount = newVal;
            }
        },
        computed:{
            cal_selling_price:function() {
                if(this.type == '%')
                {
                    if(parseInt(this.discount) != 0)
                    {
                        this.selling_price = parseInt(this.mrp_price) - ((parseInt(this.mrp_price) * parseInt(this.discount))/100);
                    }
                    else{
                        this.selling_price = this.selling_price;
                    }
                }
                if(this.type == 'Rs.')
                {
                    if(parseInt(this.discount)  != 0)
                    {
                        this.selling_price = parseInt(this.mrp_price) - parseInt(this.discount);
                    }
                    else{
                        this.selling_price = this.selling_price;
                    }
                }
                return this.selling_price;
            },
            AutoNameGenerate:function(){
                var tmp_brand = '';
                if(this.brand != null  || this.color != null)
                {
                    if(this.brand == 'other')
                    {
                        tmp_brand = '';
                    }
                    else
                    {
                        tmp_brand = this.brand;
                    }
                    if(this.brand == null || this.brand == ''){
                        tmp_brand = '';
                    }
                    var tmp_color = this.color;
                    //alert(this.brand);
                    this.name1 = this.gender + ' ' + tmp_color +  ' ' + this.sub_category +' ' ;
                    if(this.description != null)
                    {
                        this.name1 = this.name1 + '' + this.description;
                    }
                    if(this.brand != null)
                    {
                        this.name1 = this.brand + ' ' + this.name1;
                    }
                    return this.name1;
                }
            }
        },
        methods: {
            onButtonTap() {
                if(this.mrp_price!=null && this.selling_price!=null && this.itemSizes!=null)
                {
                    const data = {
                        product_id : this.id,
                        mrp_price : this.mrp_price,
                        selling_price : this.selling_price,
                        description : this.description,
                        color : this.color,
                        itemSizes : this.itemSizes,
                        name : this.name1
                    };
                    this.show = true;
                    //alert(this.selling_price);
                    axios.post('/updateProduct',data)
                    .then(response => { 
                        alert('Product Updated');
                        this.show = false;
                        this.$navigateTo(Home);
                    })
                    .catch(error => {
                        alert(error.response.data.message);
                    });
                }
                else{

                    if(this.mrp==null){
                        alert('Enter MRP Price');
                    }
                    else if(this.selling==null)
                    {
                        alert('Selling price is not entered');
                    }
                    else if(this.itemSizes==null)
                    {
                        alert('Select sizes');
                    }
                    else{
                        
                    }
                }
            },  
            qwe(){
                this.boo = true;
            },
            b(){
                if(this.boo){
                    this.discount = 0;
                }
            },
            back(){
                this.$navigateTo(Home);
            },
            showDialog() {
                this.dialogOpen = true;
                //alert('size');
            },
            closeDialog() {
                this.dialogOpen = false;
            },
            getType(){
                action("Select Discount Type","Cancel",["%","Rs."])
                .then(result => {
                    this.type = result;
                    if(this.type=="Cancel")
                        this.type = 'Rs.';
                })
            },
            getProduct(){
                this.showLogin = true;
                axios.get('/getProductDetails?product_id='+ this.id)
                .then((response) => {

                    response = response.data.result;
                    response = response[0];
                    this.mrp_price = response.mrp_price;
                    this.selling_price = response.selling_price;
                    this.discount = response.discount;
                    this.colorData = response.color;
                    this.color = response.color;
                    this.color1 = this.color;
                    this.itemSizes = response.sizes;
                    this.gender = response.gender;
                    this.category = response.category;
                    this.sub_category = response.sub_category;
                    //alert(this.gender);
                    this.name2 = this.gender + ' / ' + this.sub_category,
                    //alert(this.name);
                    this.images = response.image;
                    this.image = this.images.split(',');
                    this.name1 = response.name;
                    this.discount = this.mrp_price - this.selling_price;
                    if(this.gender == 'Men'){
                        this.brand = this.name1.substring(0,this.name1.indexOf('Men'));
                    }
                    if(this.gender == 'Women'){
                        this.brand = this.name1.substring(0,this.name1.indexOf('Women'));
                    }
                    if(this.gender == 'Baby and Kids'){
                        this.brand = this.name1.substring(0,this.name1.indexOf('Baby and Kids'));
                    }
                    //alert(this.brand);
                    this.description = response.description;
                    //this.brand = response.brand;
                    this.showLogin = false;
                    axios.get('/getSizes?gender=' + this.gender + '&category=' + this.category + '&sub_category=' + this.sub_category)
                    .then((response) => {
                        this.sizes1 = response.data.result;
                        //alert(this.sizes1);
                    })
                    .catch((error) =>{
                        if(error.response.status == 500)
                        {
                        }
                        this.sizes1 = null;
                    });
                },(error) =>{
                    if(error.response.status == 500)
                    {
                        alert(error.response.result);
                    }
                    alert('failed to fetch product Data');
                });
            },
            /*getSizes(){
                
            },*/
            getSizeStatus:function(size){
                for(var i=0;i < this.itemSizes.length;i++)
                {
                    if(this.itemSizes[i].name == size)
                    {
                        return true;
                    }
                }
                return false;
            },
            getQtyValue:function(size){
                for(var i=0;i < this.itemSizes.length;i++)
                {
                    if(this.itemSizes[i].name == size)
                    {
                        return this.itemSizes[i].qty;
                    }
                }
                return 0;
            },
            AddorRemoveSizes:function(size,event){
                if(event.value)
                {
                    this.addSize(size);
                }
                else{
                    this.removeSize(size);
                }
            },
            updateQty:function(size,qty){
                for(var i=0;i < this.itemSizes.length;i++)
                {
                    if(this.itemSizes[i].name == size)
                    {
                        var value = qty.value;
                        if(parseInt(qty.value) <= 0)
                        {
                            alert('value must be greater than 1');
                            value=1;
                        }
                        this.itemSizes[i].qty = value;
                    }
                }
            },
            removeSize:function(size){
                for(var i=0;i < this.itemSizes.length;i++)
                {
                    if(this.itemSizes[i].name == size)
                    {
                        this.itemSizes.splice(i,1);
                        break;
                    }
                }
            },
            addSize:function(size){
                var tmp = {
                'name' : size,
                'qty' : 1
                };
                this.itemSizes.push(tmp);  
            },
            switchChange() {
                if (itemEnabled == false) dis =
                    "Enter discount in Percentage";
                if (itemEnabled == true) dis = "Enter discount in rupees";
            },
            onItemTap() {},
            tapColor() {
                action("Select Product Color", "Cancel", ["Black","White","Blue","Brown","Red","Yellow","Orange","Pink",
                    "Gray","Purple","Dark Blue","Maroon","Multicolor","Skincolor","Green","Navy","Mehendi"])
                .then(result => {
                    this.color = [];
                    //alert(this.color1);
                    if(result=="Cancel")
                        this.color.push(this.color1);
                    if(result!="Cancel")
                        this.color.push(result);
                });
            },
            tapSize() {
                alert("Sizes");
            },
            tapBrand() {
                alert("Brands");
            },
            tapType() {
                alert("Types");
            }
        }
    };
</script>

<style scoped>
    @keyframes show {
		from {
			opacity: 0;
		}
		to {
			opacity: 1;
		}
	}

    .page {
        align-items: center;
        height: 100%;
    }

    .form {
        width:95%;
        font-size: 16;
        vertical-align: top;
    }

    .action-bar {
        background-color: #344955;
        color: #FFFFFF;
    }

    .btn-upload {
        height: 30;
        margin: 0 10 0 0;
        padding: 0 15;
        background-color: #F9AA33;
        color: #232F34;
        border-radius: 5;
        font-size: 14;
    }

    .btn-fixed {
        height: 30;
        margin: 0;
        padding: 0 15;
        background-color: #F9AA33;
        color: #232F34;
        border-radius: 5;
        font-size: 14;
    }

    .drop-down {
        padding: 4 7 3 7;
    }

    .error {
        color: #D51A1A;
        padding-bottom: 10;
        margin-left: 3;
    }
    
	.dialogOpen .bg_sizedialog {
		visibility: visible;
        opacity: 0.5;
	}

    .bg_sizedialog {
        visibility: collapse; 
        background:  #000000; 
        left: 0; 
        top: 0; 
        width: 100%; 
        height: 100%; 
        opacity: 0;
        transition-duration: 300ms;
    }

	.dialogOpen .dialog-wrapper {
		visibility: visible;
		animation-name: show;
		animation-duration: 0.3s;
		animation-fill-mode: forwards;
	}

	.dialog-wrapper {
		visibility: collapse;
		opacity: 0;
	}

	.dialog {
		background-color: white;
		width: 86%;
        padding: 0;
        border-radius: 3;
        margin-top: 15;
        margin-bottom: 15;
	}

	.dialog Label {
		margin: 0 15 15 15;
		color: black;
	}
    .input {
        font-size: 18;
        placeholder-color: #A8A8A8;
    }
</style>