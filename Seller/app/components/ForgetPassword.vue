<template>
    <Page actionBarHidden="true">
        <FlexboxLayout class="page">
            <StackLayout marginBottom="-10">
                <Image src="~/images/fashiostreet-icon.png" class="logo"
                    marginTop="35" />
                <Label text="Forgot Password" class="fashioColor" />
            </StackLayout>
            <StackLayout class="form">
                <StackLayout class="input-field" marginBottom="25">
                    <Label :text="mobileError" v-if="mobileError" class="error" />
                    <TextField hint="Mobile Number" keyboardType="phone"
                        v-model="mobile" maxLength="10" class="input"
                        fontSize="18" />
                    <StackLayout class="hr-light" />
                </StackLayout>
                <StackLayout class="btn btn-primary m-t-20" style="vertical-align:middle" @tap="recover">
                    <Label text="GET OTP" style="padding:10" horizontalAlignment="center" :visibility="!showLogin ? 'visible':'collapse'"/>
                    <ActivityIndicator :busy="showLogin"  height="30" width="30" style="color:#344955"/>
                </StackLayout>
                <StackLayout>
                    <Label text="Back to login" class="login-label" @tap="login" />
                </StackLayout>
            </StackLayout>
        </FlexboxLayout>
    </Page>
</template>

<script>
    import App from './App'
    import ForgetPassword2 from './ForgetPassword2'
    import axios from '../axios'
    const application = require("tns-core-modules/application");
    const localStorage = require( "nativescript-localstorage" );
    export default {
        name: "ForgetPassword",
        data() {
            return {
                mobile: null,
                mobileError: null,
                message: null,
                showLogin : false
            };
        },
        components:{
            App,
            ForgetPassword2
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
            recover() {
                this.mobileError = null;
                if (this.Empty(this.mobile)) {
                    this.mobileError = "Please enter mobile number";
                    return false;
                }
                if (!this.Numeric(this.mobile, 10, 10)) {
                    this.mobileError = "Invalid mobile number found";
                    return false;
                }
                const data = {
                    mobile: this.mobile
                };
                this.showLogin = true;
                axios.post('/auth/forgetpassword',data)
                .then((response) => {
                    localStorage.setItem('number',this.mobile);
                    this.$navigateTo(ForgetPassword2);
                    this.showLogin = false;
                },(error) => {
                    if(error.response.status == 500)
                    {
                        this.mobileError = 'Invalid mobile number found';
                        this.showLogin = false;
                        return false;
                    }
                    else{
                        console.log('Error while connecting...');
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

<style>
    .page {
        align-items: center;
        flex-direction: column;
        height: 100%;
        margin-left: 30;
        margin-right: 30;
    }

    .form {
        width: 300;
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
        margin: 30 5 15 5;
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