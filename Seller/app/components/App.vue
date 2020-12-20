<template>
    <Page actionBarHidden="true">
        <FlexboxLayout class="page" >
            <StackLayout marginBottom="-10">
                <Image src="~/images/fashiostreet-icon.png" class="logo"
                    marginTop="35" />
                <Label text="Login" class="fashioColor" />
            </StackLayout>
            <StackLayout class="form">
                <StackLayout class="input-field" marginBottom="25">
                    <Label :text="mobileError" v-if="mobileError" class="error" />
                    <TextField hint="Mobile Number" keyboardType="phone"
                        v-model="mobile" maxLength="10" class="input"
                        fontSize="18" />
                    <StackLayout class="hr-light" />
                </StackLayout>
                <StackLayout class="input-field" marginBottom="25">
                    <Label :text="passwordError" v-if="passwordError" class="error" />
                    <TextField hint="Password" class="input" secure="true"
                        v-model="password" fontSize="18" />
                    <StackLayout class="hr-light" />
                </StackLayout>
                <StackLayout class="btn btn-primary m-t-20" style="vertical-align:middle" @tap="checkLogin">
                    <Label text="LOG IN" style="padding:10" horizontalAlignment="center" :visibility="!showLogin ? 'visible':'collapse'"/>
                    <ActivityIndicator :busy="showLogin"  height="30" width="30" style="color:#344955"/>
                </StackLayout>
                <StackLayout>
                    <Label text="Forgot Password" class="login-label" @tap="fp" />
                    <Label text="SIGN UP" class="signup-label" @tap="si" />
                </StackLayout>
            </StackLayout>
        </FlexboxLayout>
    </Page>
</template>
<script>
    import axios from '../axios';
    import Home from './Home';
    const application = require("tns-core-modules/application");
    import ForgetPassword from './ForgetPassword';
    import Signin from './Signin';
    import ShopForm from './ShopForm';
    const timerModule = require("tns-core-modules/timer");
    const localStorage = require( "nativescript-localstorage" );
    export default {
        name: "App",
        data() {
            return {
                mobile: null,
                password: null,
                mobileError: null,
                passwordError: null,
                inProcess : false,
                showLogin : false
            };
        },
        beforeCreate()
        {
            
        },
        mounted(){
            
        },
        created(){
            application.android.on(application.AndroidApplication.activityBackPressedEvent, (args) => {
                args.cancel = true; //this cancels the normal backbutton behaviour
            });
            //this.load = false;
        },
        components:{
            Home,
            ForgetPassword,
            Signin,
            ShopForm
        },
        methods: {
            si(){
                this.$navigateTo(Signin);
            },
            fp(){
                this.showLogin = true;
                this.$navigateTo(ForgetPassword);
                this.showLogin = false;
                //timerModule.clearInterval();
            },
            StoreToken(response)
            {
                localStorage.setItem('token',response.token);
                localStorage.setItem('shopId',response.shop_id);
                localStorage.setItem('userId',response.userId);
                localStorage.setItem('refresh_token',response.refresh_token);
            },
            checkLogin() {
                this.mobileError=null;
                this.passwordError=null;
                if (this.Empty(this.mobile)) {
                    this.mobileError = "Please enter mobile number";
                    return false;
                }
                if (!this.Numeric(this.mobile, 10, 10)) {
                    this.mobileError = "Invalid mobile number found";
                    return false;
                }
                if (this.Empty(this.password)) {
                    this.passwordError = "Please enter password";
                    return false;
                }
                const data = {
                    mobile: this.mobile,
                    password: this.password
                };
                this.showLogin = true;
                axios.post('/auth/login',data)
                .then((response) => {
                    var myresponse = response.data.result;
                    this.StoreToken(response.data.result);
                    if(myresponse.shop_id == 0){
                        this.$navigateTo(ShopForm);
                        this.showLogin = true;
                    }
                    else{
                        this.$navigateTo(Home);
                        this.showLogin = false;
                    }
                },(error) => {
                    if(error.response.status == 500)
                    {
                        if(error.response.data.status == 401)
                        {
                            console.log('user not activated');
                        }
                        alert(error.response.data.message);
                        this.showLogin = false;
                    }
                    else{
                        console.log('error while connecting...');
                    }
                });
            },
            Numeric(str, min, max) {
                var pattern = /^\d+$/;
                if (this.length(str, min, max)) {
                    return pattern.test(str); // returns a boolean } return false;
                }
                return false;
            },
            Empty(str) {
                if (str == null || str == "") 
                    return true;
                return false;
            },
            length: function(str, min, max) {
                //var length = str.length;
                if (str.length >= min && str.length <= max) 
                    return true;
                return false;
            }
        }
    };
</script>
<style scoped>
    .page {
        align-items: center;
        flex-direction: column;
    }

    .form {
        width:300;
        flex-grow: 2;
        vertical-align: middle;
    }

    .logo {
        margin-bottom: 12;
        height: 90;
        font-weight: bold;
    }

    .error {
        color: #D51A1A;
        padding-bottom: 10;
    }

    .input {
        font-size: 18;
        placeholder-color: #A8A8A8;
    }

    .btn-primary {
        height: 50;
        margin: 30 5 10 5;
        background-color: #F9AA33;
        color: #232F34;
        border-radius: 5;
        font-size: 20;
        font-weight: 600;
    }

    .login-label {
        horizontal-align: center;
        color: #A8A8A8;
        font-size: 16;
        padding: 5 0 5 0;
    }
    .loading2{
        position:absolute;margin-top:-40px;margin-left:auto;margin-right:auto;left:0;right:0;
    }
    .loading{
        background-color:hsla(0,0%,100%,.9);position:fixed;top:0;left:0;z-index:99999;width:100%;height:100vh;
    }
    .loadingGif{
        width:200px;margin-top:80px
    }
    .signup-label {
        horizontal-align: center;
        margin-top: 10;
        padding: 5 0 5 0;
    }

    .fashioColor {
        color: #232F34;
        float: center;
        margin-top: 15;
        margin-bottom: 45;
        font-size: 35;
        font-weight: 600;
    }
</style>