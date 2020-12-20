<template>
    <Page loaded="pageLoaded" class="page">
        <ActionBar class="action-bar" marginLeft="-20">
            <GridLayout columns="50, 2*, *">
                <Label col="0" class="fa" :text="'fa-angle-left' | fonticon" fontSize="24" fontWeight="500" style="padding:0 20 0 20" @tap="back" />
                <Label col="1" text="Delete Category" fontSize="20" fontWeight="500" />
            </GridLayout>
        </ActionBar>
        <ScrollView row="1">
            <StackLayout style="background-color:#ECEFF1;padding-bottom:8">
                <ActivityIndicator :busy="showLogin" height="30" width="30"  marginTop="15" style="color:#344955" :visibility="showLogin ? 'visible':'collapse'"/>
                <StackLayout v-show="ErrorMsg!=null" margin="8 8 0 8" fontSize="18" style="border-radius:4;background-color:#FFFFFF;vertical-align: middle;height:50">
                    <Label :text="ErrorMsg" horizontalAlignment="center"/>
                </StackLayout>
                <template v-for="(item,index) in tabs">
                    <GridLayout columns="3*, *" :key="index" margin="8 8 0 8" style="border-radius:4;background-color:#FFFFFF">
                        <StackLayout col="0" orientation="horizontal">
                            <Label :text="item.gender+' / '+item.sub_category" style="vertical-align: middle;padding-left:15"/>
                        </StackLayout>
                        <Button text="Delete" col="1" class="btn-delete" @tap="deleteTab(item.gender,item.category,item.sub_category)" />
                    </GridLayout>                                        
                </template>
            </StackLayout>
        </ScrollView>
    </Page>
</template>

<script>
    import axios from '../axios';
    import Settings from './Settings';
    const application = require("tns-core-modules/application");
    export default{
        name: "DeleteTabs",
        data(){
            return{
                tabs:null,
                showLogin : true,
                ErrorMsg: null
            };
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
        mounted(){
            this.getTabs();
        },
        components:{
            Settings
        },
        methods:{
            back(){
                this.$navigateTo(Settings);
            },
            getTabs(){
                var url = '/getTabs';
                axios.get(url)
                .then((response) => {
                    this.tabs = response.data.result;
                    this.showLogin = false;
                }, (error) => {
                    if (error.response.data.status == 500) {
                        this.tabs = null;
                        this.showLogin = false;
                        this.ErrorMsg = error.response.data.message;
                    } else {
                        this.tabs = 0;
                        alert('System error found');
                        this.showLogin = false;
                    }
              });
            },
            deleteTab: function (gender, category, sub_category) {
                
                var url = '/deleteTab';
                axios.post(url, {
                    'gender': gender,
                    'category': category,
                    'sub_category': sub_category
                })
                .then((response) => {
                    this.showLogin = true;
                    alert('Successfully Category deleted - ' + gender + ' , ' + category + ' , ' + sub_category);
                    this.getTabs();
                }, (error) => {
                    if (error.response.data.status == 500) {
                        alert(error.response.data.message);
                    } else {
                        alert("server error found will deleting tab");
                    }
                    this.showLogin = false;
                });
                this.getTabs();
            }
        }
    };
</script>

<style scoped>
    .page {
        align-items: center;
        flex-direction: column;
        width:100%
    }
    .action-bar {
        background-color: #344955;
        color: #FFFFFF;
    }

    .main_footer {
        background-color: #344955;
        color: #FFFFFF;
    }

    .footer-links_active {
        font-size: 16;
        color: #F9AA33;
    }

    .btn-delete{
        background-color: #F9AA33;
        color: #232F34;
    }
</style>