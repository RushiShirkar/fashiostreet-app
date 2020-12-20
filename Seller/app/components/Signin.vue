<template>
    <Page actionBarHidden="true">
        <FlexboxLayout class="page">
            <StackLayout marginBottom="-10">
                <Image src="~/images/fashiostreet-icon.png" class="logo" marginTop="35" />
                <Label text="Create an account" class="fashioColor" />
            </StackLayout>
            <StackLayout v-if="SignupError">
                <label :text="SignupError" marginBottom="25" />
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
                <StackLayout class="input-field" marginBottom="25">
                    <Label :text="conPasswordError" v-if="conPasswordError"
                        class="error" />
                    <TextField hint="Confirm Password" class="input" secure="true"
                        v-model="cpassword" fontSize="18" />
                    <StackLayout class="hr-light" />
                </StackLayout>
                <StackLayout class="btn btn-primary m-t-20" style="vertical-align:middle" @tap="signin">
                    <Label text="Sign Up" style="padding:10" horizontalAlignment="center" :visibility="!showLogin ? 'visible':'collapse'"/>
                    <ActivityIndicator :busy="showLogin"  height="30" width="30" style="color:#344955"/>
                </StackLayout>
                <StackLayout orientation="horizontal" horizontalAlignment="center">
                    <Label text="Already have an account - " class="login-label"  />
                    <Label text="Login" class="login-label1" @tap="login" />
                </StackLayout>
            </StackLayout>
        </FlexboxLayout>
    </Page>
</template>

<script>
    import App from './App';
    import OtpVerify from './OtpVerify';
    import axios from '../axios'
    const localStorage = require('nativescript-localstorage');
    const application = require("tns-core-modules/application");
    export default {
        name: "Signin",
        data() {
            return {
                mobile: null,
                password: null,
                cpassword: null,
                mobileError: null,
                passwordError: null,
                conPasswordError: null,
                SignupError: null,
                showLogin : false
            };
        },
        components:{
            App,
            OtpVerify
        },
        created(){
            application.android.on(application.AndroidApplication.activityBackPressedEvent, (args) => {
                args.cancel = true; //this cancels the normal backbutton behaviour
                //alert('The button was pressed but nothing happens');
            });
        },
        methods: {
            login(){
                this.$navigateTo(App);
            },
            signin() {
                this.mobileError = null;
                this.passwordError = null;
                this.conPasswordError = null;
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
                if (this.Empty(this.cpassword)) {
                    this.conPasswordError = "Please enter confirm password";
                    return false;
                }
                if (this.cpassword != this.password) {
                    this.conPasswordError = "Password not match";
                    return false;
                }
                this.showLogin = true;
                const data = {
                    mobile: this.mobile,
                    password: this.password
                };
                axios.post('/auth/register',data)
                .then((response) => {
                    localStorage.setItem('no',this.mobile);
                    this.$navigateTo(OtpVerify);
                    this.showLogin = false;
                },(error) => {
                    if(error.response.status == 500)
                    {
                        this.SignupError = error.response.data.message;
                        this.showLogin = false;
                    }
                    else{
                    console.log('error while connecting...');
                    this.showLogin = false;
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
        margin-left: 30;
        margin-right: 30;
    }

    .form {
        flex-grow: 2;
        vertical-align: middle;
    }

    .logo {
        margin-bottom: 12;
        height: 90;
        font-weight: bold;
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
        padding:5 0 5 0;
    }

    .login-label1 {
        horizontal-align: center;
        font-size: 16;
        margin-left: 5;
        padding:5 0 5 0;
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