<template>
    <Page actionBarHidden="true">
        <FlexboxLayout class="page">
            <StackLayout marginBottom="-10">
                <Image src="~/images/fashiostreet-icon.png" class="logo"
                    marginTop="35" />
                <Label text="Verify Mobile No." class="fashioColor" />
                <Label text="OTP Send to your mobile number" class="otpsend-label" />
            </StackLayout>
            <StackLayout class="form">
                <StackLayout class="input-field" marginBottom="25">
                    <Label :text="mobileError" v-if="mobileError" class="error" />
                    <GridLayout columns="*, *" rows="*" width="auto" height="45">
                        <TextField hint="Mobile Number" keyboardType="phone"
                            v-model="mobile" maxLength="10" class="input"
                            fontSize="18" editable="false" />
                        <Button row="0" col="1" text="Change"
                            horizontalAlignment="right" class="btn btn-resendotp m-t-20"
                            @tap="change" />
                    </GridLayout>
                    <StackLayout class="hr-light" />
                </StackLayout>
                <StackLayout class="input-field" marginBottom="25">
                    <Label :text="codeError" v-if="codeError" class="error" />
                    <TextField hint="Enter OTP" keyboardType="number" v-model="code"
                        maxLength="6" class="input" fontSize="18" />
                    <StackLayout class="hr-light" />
                </StackLayout>
                <StackLayout class="btn btn-primary m-t-20" style="vertical-align:middle" @tap="verify">
                    <Label text="Verify OTP" style="padding:10" horizontalAlignment="center" :visibility="!showLogin ? 'visible':'collapse'"/>
                    <ActivityIndicator :busy="showLogin"  height="30" width="30" style="color:#344955"/>
                </StackLayout>
                <StackLayout orientation="horizontal" horizontalAlignment="center">
                    <Label text="Already have an account - " class="login-label" />
                    <Label text="Login" class="login-label1" />
                </StackLayout>
            </StackLayout>
        </FlexboxLayout>
    </Page>
</template>

<script>
    import axios from '../axios'
    import App from './App'
    import Signin from './Signin'
    const localStorage = require('nativescript-localstorage');
    const application = require("tns-core-modules/application");
    export default {
        name: "OtpVerify",
        data() {
            return {
                mobile: localStorage.getItem('no'),
                code: null,
                codeError: null,
                showLogin : false
            };
        },
        components:{
            App,
            Signin
        },
        created(){
            application.android.on(application.AndroidApplication.activityBackPressedEvent, (args) => {
                args.cancel = true; //this cancels the normal backbutton behaviour
                //alert('The button was pressed but nothing happens');
            });
        },
        methods: {
            change(){
                this.$navigateTo(Signin);
            },
            verify() {
                this.codeError = null;
                if (this.Empty(this.code)) {
                    this.codeError = "please enter OTP";
                    return false;
                }
                if (!this.Numeric(this.code, 6, 6)) {
                    this.codeError = "Invalid OTP found";
                    return false;
                }
                const data = {
                    mobile : this.mobile,
                    code : this.code
                };
                this.showLogin = true;
                axios.post('/auth/completeRegister',data)
                    .then((response) => {
                    this.$navigateTo(App);
                    this.showLogin = false;
                },(error) => {
                    if(error.response.status == 500)
                    {
                        this.Error = error.response.data.message;
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

    .btn-resendotp {
        height:
            30;
        margin: 0;
        margin-bottom: 5;
        padding: 0 15;
        background-color: #1dbf73;
        color: #FFFFFF;
        border-radius: 5;
        font-size: 14;
    }

    .login-label {
        horizontal-align: center;
        color: #A8A8A8;
        font-size: 16;
    }

    .login-label1 {
        horizontal-align: center;
        font-size: 16;
        margin-left: 5;
    }

    .otpsend-label {
        horizontal-align: center;
        padding-bottom:
            10;
        color: green;
    }

    .fashioColor {
        color: #232F34;
        float: center;
        margin-top: 15;
        margin-bottom: 30;
        font-size: 35;
        font-weight:
            600;
    }
</style>