<template>
    <Page loaded="pageLoaded"  :class="{ dialogOpen: dialogOpen }">
        <ActionBar class="action-bar" marginLeft="-20">
            <GridLayout columns="50, 2*, *">
                <Label col="0" class="fa" :text="'fa-angle-left' | fonticon" fontSize="24" fontWeight="500" style="padding:0 20 0 20" @tap="back" />
                <Label col="1" text="Edit Product" fontSize="20" fontWeight="500" />
                <Button col="2" text="Save" horizontalAlignment="right" class="btn btn-upload" />
            </GridLayout>
        </ActionBar>
        <GridLayout rows="*, 4*">
            <StackLayout row="0" style="margin:0 10 8 10">
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
            <ScrollView row="1">
                <StackLayout class="form">
                    <GridLayout columns="*, *" marginBottom="15">
                        <StackLayout col="0">
                            <TextField v-model="mrp_price" hint="Enter MRP price" />
                        </StackLayout>
                        <StackLayout col="1">
                            <TextField :text="selling_price" hint="Selling price" 
                                 style="placeholder-color:#d3d3d3" />
                        </StackLayout>
                    </GridLayout>
                    <GridLayout columns="90, *, 60" marginBottom="15">
                        <StackLayout col="0" style="vertical-align: middle;padding:0 3">
                            <Label text="Discount" />
                        </StackLayout>
                        <StackLayout col="1">
                            <TextField v-model="discount" hint="Enter discount" />
                        </StackLayout>
                        <StackLayout col="2" style="vertical-align: middle; horizontal-align:center; padding:0 10">
                            <Label v-model="type" @tap="getType"/>
                        </StackLayout>
                    </GridLayout>
                    <GridLayout columns="*, *, 30" @tap="showDialog"
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
                            <Label text="+" class="pull-right" marginRight="3" />
                        </StackLayout>
                    </GridLayout>
                    <StackLayout class="name" marginBottom="15" >
                        <TextView editable="true" hint="Enter product description (optional)"
                            autocorrect="true" v-model="description">
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
                            <Label horizontalAlignment="right" fontSize="14" style="padding:18 12 0 12; color:#252323" text="CLOSE" @tap="closeDialog"/>
                        </StackLayout>
                    </GridLayout>
                </StackLayout>
            </StackLayout>
        </GridLayout>
    </Page>
</template>

<script>
    import axios from '../axios';
    import Home from './Home';
    const localStorage = require( "nativescript-localstorage" );
    export default {
        name : "EditProduct",
        data() {
            return {
                textFieldValue: null,
                discount: '',
                id : localStorage.getItem('id'),
                mrp_price : null,
                selling_price : null,
                colorData : null,
                color : null,
                itemSizes : null,
                size : null,
                images : null,
                image : [],
                name : null,
                name1: null,
                description : null,
                type : 'Rs.',
                sizes1: [],
                sizes:null,
                gender : null,
                category : null,
                sub_category : null,
                dialogOpen : false
            };
        },
        mounted(){
            this.getProduct();
        },
        components:{
            Home
        },
        created(){
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
                this.type = newVal;
            },
            discount:function (newVal) {
                if(this.discount == '' || this.discount == null)
                {
                    newVal = "0";
                }
                else 
                {
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
            cal_selling() {
                //this.selling_price = this.mrp_price;
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
                    if(parseInt(this.discount)!=0)
                    {
                        this.selling_price = parseInt(this.mrp_price) - parseInt(this.discount);
                    }
                    else{
                        this.selling_price = this.selling_price;
                    }
                }
                return this.selling_price;
            },
            AutoNameGenerate:function() {
                this.name = this.name1;
                if(this.description!=null){
                    this.name = this.name + this.description;
                }
                return this.name;
            }
        },
        methods: {
            back(){
                this.$navigateTo(Home);
            },
            showDialog() {
                this.dialogOpen = true;
                alert('bi');
                alert(JSON.stringify(this.sizes1));
            },
            closeDialog() {
                this.dialogOpen = false;
            },
            getSizeStatus:function(size){

                for(var i=0;i < this.size.length;i++)
                {
                if(this.size[i].size == size)
                {
                    return true;
                }
                }
                return false;
            },
            getQtyValue:function(size){
                for(var i=0;i < this.size.length;i++)
                {
                if(this.size[i].size == size)
                {
                    return this.size[i].qty;
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
                this.sizes = this.size;
            },
            updateQty:function(size,qty){
                for(var i=0;i < this.size.length;i++)
                {
                    if(this.size[i].size == size)
                    {
                        this.size[i].qty = 1;
                    }
                }
                this.sizes = this.size;
            },
            removeSize:function(size){
                for(var i=0;i < this.size.length;i++)
                {
                if(this.size[i].size == size)
                {
                    this.size.splice(i,1);
                    break;
                }
                }
            },
            addSize:function(size){
                var tmp = {
                'size' : size,
                'qty' : 1
                };
                this.size = this.size.concat(tmp);     
            },
            getType(){
                action("Select Discount Type","Cancel",["%","Rs."])
                .then(result => {
                    this.type = result;
                    if(result == "Cancel"){
                        this.type = 'Rs.';
                    }
                })
            },
            getColor(){
                action("Select Product Color", "Cancel", ["Red", "Blue","Green"])
                .then(result => {
                    this.color = result;
                    if(this.color=="Cancel")
                        this.color = "";
                });
            },
            getProduct(){

                axios.get('/getProductDetails?product_id='+ this.id)
                .then((response) => {

                    response = response.data.result;
                    response = response[0];
                    this.mrp_price = response.mrp_price;
                    this.selling_price = response.selling_price;
                    this.discount = response.discount;
                    this.colorData = response.color;
                    this.color = response.color;
                    this.itemSizes = response.sizes;
                    this.images = response.image;
                    this.image = this.images.split(',');
                    this.name1 = response.name;
                    this.discount = this.mrp_price - this.selling_price;
                    this.description = response.description;
                    axios.get('/getSizes?gender=' + response.gender + '&category=' + response.category + '&sub_category=' + response.sub_category)
                    .then((response) => {
                        this.sizes1 = response.data.result;
                        alert(JSON.stringify(this.sizes1));
                    })
                    .catch((error) =>{
                        if(error.response.status == 500)
                        {
                            
                        }
                        alert(error.response.data.message);
                        this.sizes1 = null;
                    });
                },(error) =>{
                    if(error.response.status == 500)
                    {
                        alert(error.response.result);
                    }
                    alert('failed to fetch product Data');
                });
                
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
        flex-direction: column;
        height: 100%;
    }

    .form {
        width:95%;
        flex-grow: 2;
        font-size: 16;
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

    .drop-down {
        padding: 4 7 3 7;
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