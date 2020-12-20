<template>
    <Page>
        <ActionBar class="action-bar" title="Settings">
            <GridLayout columns="2*, *">
                <Label col="0" text="Settings" fontSize="20" fontWeight="500"  />
                <Button col="1" text="Logout" horizontalAlignment="right"
                    class="btn btn-upload" @tap="onButtonTap" />
            </GridLayout>
        </ActionBar>
        <GridLayout rows="*, 56" style="background-color:#ECEFF1">
            <StackLayout row="0">
                <GridLayout columns="2*, *" @tap="tapSize" margin="8 8 0 8"
                    style="padding:18;background-color:#FFFFFF;border-radius:4;height:60">
                    <StackLayout col="0">
                        <Label text="User Profile" marginLeft="3" />
                    </StackLayout>
                    <StackLayout col="1">
                        <Label text="Coming Soon.." class="pull-right" marginRight="3" />
                    </StackLayout>
                </GridLayout>
                <GridLayout columns="2*, *" @tap="tapSize" margin="8 8 0 8"
                    style="padding:18;background-color:#FFFFFF;border-radius:4;height:60">
                    <StackLayout col="0">
                        <Label text="Shop Profile" marginLeft="3" />
                    </StackLayout>
                    <StackLayout col="1">
                        <Label text="Coming Soon.." class="pull-right" marginRight="3" />
                    </StackLayout>
                </GridLayout>
                <GridLayout columns="*, 30"  margin="8 8 0 8" @tap="offerPage"
                    style="padding:18;background-color:#FFFFFF;border-radius:4;height:60">
                    <StackLayout col="0">
                        <Label text="Offer Zone" marginLeft="3" />
                    </StackLayout>
                    <StackLayout col="1">
                        <Label class="fa" :text="'fa-angle-right' | fonticon" fontSize="24" fontWeight="500" marginRight="3"/>
                    </StackLayout>
                </GridLayout>
                <GridLayout columns="*, 30" margin="8 8 0 8" @tap="deleteTab"
                    style="padding:18;background-color:#FFFFFF;border-radius:4;height:60">
                    <StackLayout col="0">
                        <Label text="Delete Category" marginLeft="3" />
                    </StackLayout>
                    <StackLayout col="1">
                        <Label class="fa" :text="'fa-angle-right' | fonticon" fontSize="24" fontWeight="500" marginRight="3"/>
                    </StackLayout>
                </GridLayout>
            </StackLayout>
            <StackLayout row="1" class="main_footer">
                <GridLayout columns="*, *, *">
                    <StackLayout col="0" style="vertical-align:middle" @tap="home">
                        <Label class="fa" :text="'fa-home' | fonticon"
                            horizontalAlignment="center"></Label>
                        <Label text="Home" horizontalAlignment="center">
                        </Label>
                    </StackLayout>
                    <StackLayout col="1" style="vertical-align:middle" @tap="orders">
                        <Label class="fa" :text="'fa-cubes' | fonticon"
                            horizontalAlignment="center"></Label>
                        <Label text="Orders" horizontalAlignment="center">
                        </Label>
                    </StackLayout>
                    <StackLayout col="2" class="footer-links_active" style="vertical-align:middle">
                        <Label class="fa" :text="'fa-gears' | fonticon"
                            horizontalAlignment="center"></Label>
                        <Label text="Settings" horizontalAlignment="center">
                        </Label>
                    </StackLayout>
                </GridLayout>
            </StackLayout>
        </GridLayout>
    </Page>
</template>

<script>
    import Home from './Home';
    import Orders from './Orders';
    import App from './App';
    import Offer from './Offer';
    const localStorage = require( "nativescript-localstorage" );
    const application = require("tns-core-modules/application");
    import DeleteTabs from './DeleteTabs';
    export default {
        name: "Settings",
        data() {
            return {

            };
        },
        components:{
            Home,
            Orders,
            DeleteTabs,
            App,
            Offer
        },
        created(){
            application.android.on(application.AndroidApplication.activityBackPressedEvent, (args) => {
                args.cancel = true; //this cancels the normal backbutton behaviour
                //alert('The button was pressed but nothing happens');
            });
        },
        methods:{
            deleteTab(){
                this.$navigateTo(DeleteTabs);
            },
            home(){
                this.$navigateTo(Home);
            },
            offerPage(){
                //alert('offer');
                this.$navigateTo(Offer);
                //alert('page');
            },
            orders(){
                this.$navigateTo(Orders);
            },
            onButtonTap(){
                localStorage.clear();
                this.$navigateTo(App);
            }
        }
    };
</script>

<style scoped>
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
</style>