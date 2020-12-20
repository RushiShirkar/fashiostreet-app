<template>
    <Page loaded="pageLoaded" :class="{ dialogOpen: dialogOpen }">
        <ActionBar class="action-bar" marginLeft="-20">
            <GridLayout columns="50, 2*, *">
                <Label col="0" class="fa" :text="'fa-angle-left' | fonticon" fontSize="24" fontWeight="500" style="padding:0 20 0 20" @tap="back" />
                <Label col="1" text="Add Product" fontSize="20" fontWeight="500" />
                <Button col="2" text="+ Upload" horizontalAlignment="right"
                    class="btn btn-upload" @tap="onButtonTap" />
            </GridLayout>
        </ActionBar>
        <GridLayout rows="40, *, 3*">
            <Label :text="cat" row="0" class="content" style="margin:10 0 0 0;margin-left: 13; margin-right: 13;" />
            <StackLayout row="1" class="content" style="margin:0 10 8 10">
                <ScrollView orientation="horizontal">
                    <StackLayout orientation="horizontal">
                        <StackLayout width="100" height="125" margin="0 3" @tap="getImages"
                            style="border-radius:4;font-size:35;background-color:#C0C0C0;vertical-align:middle">
                            <Label text="+" horizontalAlignment="center" />
                        </StackLayout>
                        <template v-for="(img,index) in images" >
                            <GridLayout :key="index">
                                <Image :src="img.src" width="100" :key="index"
                                    height="125" stretch="aspectFit" margin="0 3"
                                    style="border-width:1; border-color:#C0C0C0;border-radius:4" />
                                <AbsoluteLayout  horizontalAlignment="right" :key="index"
                                    style="padding:0 4 0 0">
                                    <Button text="X" width="30" @tap="deleteImage(index)" height="35" style="background-color:#C0C0C0;border-radius: 0 4 0 4;padding:0"></Button>
                                </AbsoluteLayout>
                            </GridLayout>
                        </template>
                    </StackLayout>
                </ScrollView>
            </StackLayout>
           <GridLayout row="2">
            <ScrollView class="content">
                <StackLayout class="form">
                    <GridLayout columns="*, *" marginBottom="15">
                        <Label :text="mrpError" class="error" v-if="mrpError" />
                        <StackLayout col="0">
                            <TextField v-model="mrp" hint="Enter MRP price" keyboardType="number" />
                        </StackLayout>
                        <StackLayout col="1">
                            <TextField :text="cal_selling" hint="Selling price" keyboardType="number" />
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
                            <Label v-model="type"  />
                            <Label class="fa" :text="'fa-caret-down' | fonticon" style="padding-left:8" />
                        </StackLayout>
                    </GridLayout>
                    <GridLayout columns="*, *, 30," @tap="showDialog"
                        marginBottom="10" style="padding:5 0 5 0">
                        <StackLayout col="0">
                            <Label text="Sizes" marginLeft="3" />
                        </StackLayout>
                         <StackLayout col="1" orientation="horizontal" horizontalAlignment="right">
                            <template v-for="(size,index) in sizes">
                                <Label :text="size.size+','" :key="index"  />
                            </template>
                        </StackLayout>
                        <StackLayout col="2" row="0">
                            <Label text="+" class="pull-right" margin="0 10 0 10" />
                        </StackLayout>
                    </GridLayout>
                    <GridLayout columns="*, *, 30" @tap="tapColor"
                        marginBottom="10" style="padding:5 0 5 0">
                        <StackLayout col="0">
                            <Label text="Colors" marginLeft="3" />
                        </StackLayout>
                        <Label col="1" :text="color[0]" horizontalAlignment="right" />
                        <StackLayout col="2">
                            <Label text="+" class="pull-right" margin="0 10 0 10" />
                        </StackLayout>
                    </GridLayout>
                    <StackLayout class="name" marginBottom="15">
                        <TextView editable="true" hint="Brand name (optional)"
                           v-model="brand" autocorrect="true">
                        </TextView>
                    </StackLayout>
                    <StackLayout class="name" marginBottom="15">
                        <TextView editable="true" hint="Enter product description (optional)"
                           v-model="description" autocorrect="true">
                        </TextView>
                    </StackLayout>
                    <TextView hint="Product Name" editable="false" borderWidth="0" :text="AutoNameGenerate"
                      marginLeft="3" marginBottom="10" style="placeholder-color:#d3d3d3"/>
                </StackLayout>
            </ScrollView>
            <AbsoluteLayout class="dialog-wrapper">
                <StackLayout class="dialog">
                    <ScrollView style="height:260">
                        <StackLayout class="list-group" >
                            <template v-for="(data,index) in sizes1">
                                <FlexBoxLayout flexDirection="row" class="list-group-item" :key="index">
                                    <CheckBox :checked="getSizeStatus(data.size)"
                                        @checkedChange=" AddorRemoveSizes(data.size,$event)" :id="'data_size'+index" />
                                    <Label :for="'data_size'+index" :text="data.size" />
                                    <TextField :text="getQtyValue(data.size)" @textChange="updateQty(data.size,$event)"/>
                                </FlexBoxLayout>
                            </template>
                        </StackLayout>
                    </ScrollView>
                    <label class="btn-close pull-right" text="CLOSE" @tap="closeDialog"></label>
                </StackLayout>
            </AbsoluteLayout>
           </GridLayout>
        </GridLayout>
    </Page>
</template>

<script>
    import Sizes from './Sizes';
    import axios from '../axios';
    import Home from './Home';
    import * as imagepicker from "nativescript-imagepicker";
    import { Image } from "tns-core-modules/ui/image";
    const imageSourceModule = require("tns-core-modules/image-source");
	const fileSystemModule = require("tns-core-modules/file-system");
	const imageAssetModule = require("tns-core-modules/image-asset");
	var resizebase64 = require('resize-base64');  
    const application = require("tns-core-modules/application");
    const localStorage = require( "nativescript-localstorage" );
    export default {
        data() {
            return {
                cat: localStorage.getItem('g')+' / '+localStorage.getItem('s'),
                listOfItems: ["Colors", "Brands", "Types", "Sizes"],
                textFieldValue: null,
                itemEnabled: false,
                gender: 'Men',
                sub_category: 'Jeans',
                discount: null,
                dis: null,
                color: [],
                sizes1: [],
                sizes:null,
                size:[],
                mrp: null,
                mrpError : null,
                selling: null,
                type: '%',
                brand: null,
                images:[],
				image:null,
				value:null,
				obj_image:[],
				a:null,
                description: null,
                name: null,
                params : [],
                gender: localStorage.getItem('g'),
                dialogOpen: false,
                category: localStorage.getItem('c'),
                sub_category: localStorage.getItem('s')
            };
        },
        components:{
            Sizes,
            Home
        },
        mounted(){
            this.getSizes();
        },
        created(){
            //alert('hello');
            
            application.android.on(application.AndroidApplication.activityBackPressedEvent, (args) => {
                args.cancel = true; //this cancels the normal backbutton behaviour
                //alert('The button was pressed but nothing happens');
            });
            axios.defaults.headers = {
                'Content-Type': 'application/json',
                'shopId' : localStorage.getItem('shopId'),
                'token' : localStorage.getItem('token')
            };
        },
        watch:{
            mrp:function(newVal)
            {
                this.mrp = newVal;
            },
            selling:function(newVal)
            {
                this.selling = newVal;
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
                else {
                    if (this.type == '%' && newVal > 100) {
                        alert('percent should be less than 100');
                        newVal = 100;
                        this.discount = newVal;
                    }
                    else if (this.type == 'Rs.' && this.discount > this.mrp) {
                        alert('discount should be less than mrp price');
                        newVal = this.mrp;
                        this.discount = newVal;
                    }
                }
                this.discount = newVal;
            }
        },
        computed:{
            cal_selling() {
                if(this.mrp==null){
                        this.selling = null;
                }
                if(this.type == '%')
                {
                    if(parseInt(this.discount) != 0)
                    {
                        this.selling = parseInt(this.mrp) - ((parseInt(this.mrp) * parseInt(this.discount))/100);
                    }
                    else{
                        this.selling = this.mrp;
                    }
                }
                else if(this.type == 'Rs.')
                {
                    this.selling = parseInt(this.mrp) - parseInt(this.discount);
                }
                return this.selling;
            },
            AutoNameGenerate:function(){
                if(this.brand != null  && this.color != null)
                {
                    if(this.brand == 'other')
                    {
                        var tmp_brand = '';
                    }
                    else
                    {
                        var tmp_brand = this.brand;
                    }
                    var tmp_color = this.color;
                    this.name = tmp_brand + ' ' + this.gender + ' ' + tmp_color +  ' ' + this.sub_category + ' ';
                    if(this.description != null)
                    {
                        this.name = this.name + '' + this.description;
                    }
                    return this.name;
                }
            }
        },
        methods: {
            showDialog() {
                this.dialogOpen = true;
            },
            closeDialog() {
                this.dialogOpen = false;
            },
            getSizes(){
                axios.get('/getSizes?gender=' + this.gender + '&category=' + this.category + '&sub_category=' + this.sub_category)
                .then((response) => {
                    this.sizes1 = response.data.result;
                })
                .catch((error) =>{
                    if(error.response.status == 500)
                    {
                    }
                    this.sizes1 = null;
                });
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
            onButtonTap() {
                var discount = parseFloat(this.mrp) - parseFloat(this.selling);
                var obj = {
                    'shop_id':localStorage.getItem('shopId'),
                    'gender':this.gender,
                    'category':this.category,
                    'sub_category':this.sub_category,
                    'brand':'other',
                    'type':'other',
                    'name':this.name,
                    's_p_id':0,
                    'mrp_price':this.mrp,
                    'selling_price':this.selling,
                    'discount':discount,
                    'description':this.description,
                    'sizes':this.sizes,
                    'colors':this.color,
                    'extension':'webp',
                    'image':this.obj_image
                };
                //alert(localStorage.getItem('shopId'));
                //alert(localStorage.getItem('userId'));
                //alert(this.obj_image);
                axios.post('/addProduct',obj)
                .then(response => {
                    alert(response.data.result);
                    alert('Success');
                    this.images = null;
                    this.brand = null;
                    this.name = null;
                    this.mrp = null;
                    this.selling = null;
                    this.discount = null;
                    this.description =null;
                    this.obj_image = null;
                    this.sizes = null;
                    this.color = null;
                }, error =>{
                    alert(error.response.data.message);
                });
                //alert('upload');
            },
            getImages(){
                let context = imagepicker.create({
					mode: 'multiple' 
				});
				
				context.authorize()
				.then(function() {
					return context.present();
				})
				.then(selection => {
					selection.forEach(selected => {
						var img = new Image();
						
						imageSourceModule.fromAsset(selected)
						.then((res) => {
							this.image = res;
							var base64 = this.image.toBase64String("webp",100);
							img.src = selected;
							this.images.push(img);
							base64 = 'data:image/webp;base64,'+ base64 ;
							this.obj_image.push(base64);
							//alert(str);
							//alert(base64);
						})
					});
				}).catch(function (e) {
					console.log('error in selectPicture', e);
				});
            },
            deleteImage(index){
                this.images.splice(index,1);
                if(this.images.length == 0)
                {
                    this.images = []; 
                }
            },
            back(){
                localStorage.removeItem('g');
                localStorage.removeItem('c');
                localStorage.removeItem('s');
                this.$navigateTo(Home);
            },
            onItemTap() {},
            tapColor() {
                this.color = [];
                action("Select Product Color", "Cancel", ["Black","White","Blue","Brown","Red","Yellow","Orange","Pink",
                    "Gray","Purple","Dark Blue","Maroon","Multicolor","Skincolor","Green","Navy","Mehendi"])
                .then(result => {
                    this.color.push(result);
                    if(this.color=="Cancel")
                        this.color = "";
                });
            },
            getType(){
                action("Select Discount Type","Cancel",["%","Rs."])
                .then(result => {
                    this.type = result;
                })
            },
            tapSize() {
                //this.$navigateTo(Sizes);
            },
            tapBrand() {
                alert("Brands");
            },
            tapType() {
                alert("Types");
            },
            Empty(str) {
                if (str == null || str == "") return true;
                return false;
            },
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

    .btn-close{
        height: 30;
        padding: 0 15;
        background-color: #FFFFFF;
        color: rgb(87, 7, 192);
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
    
	.dialogOpen .content,
	.dialogOpen .action-bar {
		opacity: 0.7;
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
		width: 90%;
        padding: 20;
        border-radius: 2;
        margin-left: 5%;
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