<template>
    <Page loaded="pageLoaded" class="page">
        <ActionBar title="Create Shop" class="action-bar">
        </ActionBar>
            <ScrollView>
                <StackLayout class="form">
                    <Label :text="cityError" v-if="cityError"
                            class="error" />
                    <GridLayout @tap="getCity" orientation="horizontal" margin="10 5 10 5" style="vertical-align: middle;width:100%;padding:10 0">
                        <Label v-model="city" color="#A8A8A8" fontSize="16" />
                        <Label class="fa" :text="'fa-caret-down' | fonticon" horizontalAlignment="right" style="vertical-align: middle"/>
                        <StackLayout class="hr-light" />
                    </GridLayout>
                    <StackLayout class="input-field" marginBottom="20">
                        <Label :text="shopnameError" v-if="shopnameError"
                            class="error" />
                        <TextField hint="Enter Shop name" v-model="shopname"
                            class="input" fontSize="16" />
                        <StackLayout class="hr-light" />
                    </StackLayout>
                    <StackLayout class="input-field" marginBottom="20">
                        <Label :text="ownernameError" v-if="ownernameError"
                            class="error" />
                        <TextField hint="Enter Owner name" v-model="ownername"
                            class="input" fontSize="16" />
                        <StackLayout class="hr-light" />
                    </StackLayout>
                    <StackLayout class="input-field" marginBottom="20">
                        <Label :text="cnumberError" v-if="cnumberError" class="error" />
                        <TextField hint="Enter Contact number" keyboardType="phone"
                            v-model="cnumber" class="input" maxLength="10"
                            fontSize="16" />
                        <StackLayout class="hr-light" />
                    </StackLayout>
                    <StackLayout class="input-field" marginBottom="20">
                        <Label :text="acnumberError" v-if="acnumberError"
                            class="error" />
                        <TextField hint="Enter alternate Contact number"
                            keyboardType="phone" v-model="acnumber" class="input"
                            maxLength="10" fontSize="16" />
                        <StackLayout class="hr-light" />
                    </StackLayout>
                    <StackLayout class="input-field" marginBottom="20">
                        <Label :text="addressError" v-if="addressError" class="error" />
                        <TextField hint="Enter shop address" v-model="address"
                            class="input" fontSize="16" />
                        <StackLayout class="hr-light" />
                    </StackLayout>
                    <StackLayout class="input-field" marginBottom="20">
                        <Label :text="pancardError" v-if="pancardError" class="error" />
                        <TextField hint="Enter Pancard number(optional)"
                            v-model="pancard" class="input" fontSize="16" />
                        <StackLayout class="hr-light" />
                    </StackLayout>
                    <StackLayout class="input-field" marginBottom="20">
                        <Label :text="gstError" v-if="gstError" class="error" />
                        <TextField hint="Enter GST number(optional)" v-model="gst"
                            class="input" fontSize="16" />
                        <StackLayout class="hr-light" />
                    </StackLayout>
                    <StackLayout style="margin-left: 3">
                    <Label text="Closed Day :" fontSize="16" marginBottom="10" />
                    <FlexboxLayout flexWrap="wrap" marginBottom="20" color="#A8A8A8">
                        <CheckBox @checkedChange="onchange1($event.value,'Monday')"
                            text="Monday" class="checkbox_opt" />
                        <CheckBox @checkedChange="onchange1($event.value,'Tuesday')"
                            text="Tuesday" class="checkbox_opt" />
                        <CheckBox @checkedChange="onchange1($event.value,'Wednesday')"
                            text="Wednesday" class="checkbox_opt" />
                        <CheckBox @checkedChange="onchange1($event.value,'Thursday')"
                            text="Thursday" class="checkbox_opt" />
                        <CheckBox @checkedChange="onchange1($event.value,'Friday')"
                            text="Friday" class="checkbox_opt" />
                        <CheckBox @checkedChange="onchange1($event.value,'Saturday')"
                            text="Saturday" class="checkbox_opt" />
                        <CheckBox @checkedChange="onchange1($event.value,'Sunday')"
                            text="Sunday" class="checkbox_opt" />
                    </FlexboxLayout>
                    <Label text="Shop Payment Mode :" fontSize="16" marginBottom="10" />
                    <FlexboxLayout flexWrap="wrap" marginBottom="20" color="#A8A8A8">
                        <CheckBox @checkedChange="change($event.value,'Cash')"
                            text="Cash" class="checkbox_opt" v-model="payment_mode"/>
                        <CheckBox @checkedChange="change($event.value,'Card Swipe')"
                            text="Card Swipe" class="checkbox_opt" />
                        <CheckBox @checkedChange="change($event.value,'UPI')"
                            text="UPI" class="checkbox_opt" />
                    </FlexboxLayout>
                    <StackLayout class="btn btn-primary m-t-20" style="vertical-align:middle" @tap="addShop">
                        <Label text="Create Shop" style="padding:10" horizontalAlignment="center" :visibility="!showLogin ? 'visible':'collapse'"/>
                        <ActivityIndicator :busy="showLogin"  height="30" width="30" style="color:#344955"/>
                    </StackLayout>
                    </StackLayout>
                </StackLayout>
            </ScrollView>
    </Page>
</template>
<script>
    const application = require("tns-core-modules/application");
    import * as imagepicker from "nativescript-imagepicker";
    import { Image } from "tns-core-modules/ui/image";
    import axios from '../axios';
    import Home from './Home';
    const imageSourceModule = require("tns-core-modules/image-source");
	const fileSystemModule = require("tns-core-modules/file-system");
	const imageAssetModule = require("tns-core-modules/image-asset");
    export default {
        name: "ShopForm",
        data() {
            return {
                someList: ["Select city", "Islampur","Kolhapur"],
                shopname: null,
                shopnameError: null,
                ownername: null,
                ownernameError: null,
                cnumber: null,
                cnumberError: null,
                acnumber: null,
                acnumberError: null,
                selectedIndex: null,
                address: null,
                addressError: null,
                pancard: null,
                pancardError: null,
                gst: null,
                gstError: null,
                openingTime: null,
                closingTime: null,
                isChecked: [],
                city:'Select City',
                cityError: null,
                selectedHour: null,
                selectedMinute: null,
                holiday:'',
                tmp_payment:'',
                images:[],
                obj_image:[],
                showLogin : false
            };
        },
        created(){
            application.android.on(application.AndroidApplication.activityBackPressedEvent, (args) => {
                args.cancel = true; //this cancels the normal backbutton behaviour
                //alert('The button was pressed but nothing happens');
            });
            axios.defaults.headers = {
                'Content-Type': 'application/json',
                'shopId' : localStorage.getItem('shopId'),
                'token' : localStorage.getItem('token'),
                'userId' : localStorage.getItem('userId')
            };
        },
        components:{
            Home
        },
        methods: {
            getCity(){
                action("Select City", "Cancel", ["islampur","kolhapur"])
                .then(result => {
                    this.city = result;
                    if(this.city == "Cancel")
                        this.city = "Select City";
                });
            },
            getImage()
            {
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
							var base64 = this.image.toBase64String("png",100);
							img.src = selected;
							this.images.push(img);
							base64 = 'data:image/png;base64,'+ base64 ;
                            //alert(base64);
                            this.obj_image.push(base64);
                            
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
            onchange1(args,b){
                this.holiday = this.holiday + b + ',';
            },
            change(args,a){
                this.tmp_payment = this.tmp_payment + a + ',';
            },
            onchange(args){
                //alert(args.newIndex);
                if(args.newIndex == 1)
                {
                    this.city = "islampur";
                }
                if(args.newIndex == 2)
                {
                    this.city = "kolhapur";
                }
                else{
                    this.city = "Select city";
                }
                alert(this.city);
            },
            addShop() {
                this.ownernameError = null;
                this.shopnameError = null;
                this.cnumberError = null;
                this.acnumberError = null;
                if(this.city=="Select city")
                {
                    this.cityError = "Please select city";
                }
                if (this.Empty(this.shopname)) {
                    this.shopnameError = "Please enter shop name";
                    return false;
                }
                if (this.Empty(this.ownername)) {
                    this.ownernameError = "Please enter owner name";
                    return false;
                }
                if (this.Empty(this.cnumber)) {
                    this.cnumberError = "Please enter contact number";
                    return false;
                }
                if (!this.Numeric(this.cnumber, 10, 10)) {
                    this.cnumberError = "Invalid mobile number found";
                    return false;
                }
                if (!this.Numeric(this.acnumber, 10, 10)) {
                    this.acnumberError = "Invalid mobile number found";
                    return false;
                }
                if (this.Empty(this.address)) {
                    this.addressError = "Please enter shop address";
                    return false;
                }
                this.holiday = this.holiday.slice(0,-1);
                this.tmp_payment = this.tmp_payment.slice(0,-1);
                const data = {
                    'city' : this.city,
                    'name' : this.shopname,
                    'image' : this.obj_image,
                    'owner_name' : this.ownername,
                    'contact' : this.cnumber,
                    'alternate_contact' : this.acnumber,
                    'address' : this.address,
                    'opening_time' : '9.00 am',
                    'closing_time' : '9.00 pm',
                    'payment_mode' : this.tmp_payment,
                    'closed_day' : this.holiday,
                    'pan_number': this.pancard,
                    'gst_number':this.gst,
                    'longitude' : '0',
                    'latitude' : '0'
                    };
                    this.showLogin = true;
                    axios.post('/addShop_Profile',data)
                    .then((response) => {
                        //alert(JSON.stringify(response.data.result));
                        this.StoreToken(response.data.result);
                        alert('Hurray!! Shop Created Successfully');
                        this.$navigateTo(Home);
                        this.showLogin = false;
                    },(error) => {
                        if(error.response.data.status == 500)
                        {
                            alert(error.response.data.message);
                            this.showLogin = false;
                        }else{
                            alert("System error found");
                            this.showLogin = false;
                        }
                });
            },
            StoreToken:function(response){
                localStorage.setItem('local_id',response.token);
                localStorage.setItem('shopId',response.shop_id);
            },
            Numeric(str, min, max) {
                var pattern = /^\d+$/;
                if (this.length(str, min, max)) {
                    return pattern.test(str); // returns a boolean } return false;
                }
                return false;
            },
            Empty(str) {
                if (str == null || str == "") return true;
                return false;
            },
            length: function(str, min, max) {
                //var length = str.length;
                if (str.length >= min && str.length <= max) return true;
                return false;
            }
        }
    };
</script>

<style scoped>
    .page {
        align-items: center;
        flex-direction: column;
        height: 100%;
        margin: 0;
    }

    .action-bar {
        background-color: #344955;
        color: #FFFFFF;
    }

    .form {
        margin:0;
        flex-grow: 2;
        width: 90%;
    }

    .drop-down{
        padding: 4 7 3 7;
    } 

    .error {
        color: #D51A1A;
        padding-bottom: 10;
        margin-left:3;
    }

    .input {
        font-size: 18;
        placeholder-color: #A8A8A8;
    }

    .btn-primary {
        height: 50;
        margin: 0 5 15 5;
        background-color: #F9AA33;
        color: #232F34;
        border-radius: 5;
        font-size: 20;
        font-weight: 600;
    }
</style>