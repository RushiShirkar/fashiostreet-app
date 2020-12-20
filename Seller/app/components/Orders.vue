<template>
    <Page actionBarHidden="true">
        <GridLayout rows="56, *, 56">
            <StackLayout row="0">
                <SegmentedBar selectedIndex="0" @selectedIndexChange="change($event.value)">
                    <SegmentedBarItem title="Orders" />
                    <SegmentedBarItem title="Picked" />
                    <SegmentedBarItem title="Return" />
                    <SegmentedBarItem title="Done" />
                </SegmentedBar>
            </StackLayout>
            <ScrollView row="1">
                <StackLayout style="background-color:#ECEFF1;padding-bottom:8">
                    <ActivityIndicator :busy="showLogin" height="30" width="30" marginTop="15" style="color:#344955" :visibility="showLogin ? 'visible':'collapse'"/>
                    <StackLayout v-show="error!=null && check==false" margin="8 8 0 8" fontSize="18" style="border-radius:4;background-color:#FFFFFF;vertical-align: middle;height:50" >
                        <Label :text="error" horizontalAlignment="center" />
                    </StackLayout>
                    <StackLayout v-show="url=='getorderedproduct' && check==true" style="margin:8;margin-bottom:0;border-radius:4;background-color:#FFFFFF">
                        <template v-for="(data,index) in order">
                            <StackLayout :key="index">
                                <GridLayout columns="*, 2*, 25">
                                <Image :src="'https://seller.fashiostreet.com/products/compress220X258/' + data.image[len[index]]" col="0" stretch="aspectFill" width="97" height="110" margin="4 5 4 5" style="border-radius:4 0 0 4"
                                />
                                <StackLayout col="1" style="margin:5">
                                    <Label :text="data.name"
                                                        style="font-size:15;font-weight:500;line-height:60" />
                                    <StackLayout orientation="horizontal">
                                        <Label :text="'Rs.'+data.selling_price" style="font-size:17;font-weight:600" />
                                        <Label :text="'Rs.'+data.mrp_price" style="font-size:14;font-weight:500;padding:2;margin-left:5;text-decoration: line-through" />
                                    </StackLayout>
                                    <Label :text="'Size : '+data.size" style="font-size:14;font-weight:500" />
                                    <Label :text="'Color : '+data.color" style="font-size:14;font-weight:500" />
                                </StackLayout>
                                <StackLayout col="2">
                                    <Label text=":" style="padding:0 10 8 10; margin:5 0 5 0" />
                                </StackLayout>
                            </GridLayout>
                            </StackLayout>
                        </template>
                    </StackLayout>
                    <StackLayout v-show="url=='getpickedupproduct' && check==true" style="margin:8;margin-bottom:0;border-radius:4;background-color:#FFFFFF">
                        <template v-for="(data,index) in order">
                            <StackLayout :key="index">
                                <GridLayout columns="*, 2*, 25">
                                <Image :src="'https://seller.fashiostreet.com/products/compress220X258/' + data.image[len[index]]" col="0" stretch="aspectFill" width="97" height="110" margin="4 5 4 5" style="border-radius:4 0 0 4"
                                />
                                <StackLayout col="1" style="margin:5">
                                    <Label :text="data.name"
                                                        style="font-size:15;font-weight:500;line-height:60" />
                                    <StackLayout orientation="horizontal">
                                        <Label :text="'Rs.'+data.selling_price" style="font-size:17;font-weight:600" />
                                        <Label :text="'Rs.'+data.mrp_price" style="font-size:14;font-weight:500;padding:2;margin-left:5;text-decoration: line-through" />
                                    </StackLayout>
                                    <Label :text="'Size : '+data.size" style="font-size:14;font-weight:500" />
                                    <Label :text="'Color : '+data.color" style="font-size:14;font-weight:500" />
                                </StackLayout>
                                <StackLayout col="2">
                                    <Label text=":" style="padding:0 10 8 10; margin:5 0 5 0" />
                                </StackLayout>
                            </GridLayout>
                            </StackLayout>
                        </template>
                    </StackLayout>
                    <StackLayout v-show="url=='getreturnproduct' && check==true" style="margin:8;margin-bottom:0;border-radius:4;background-color:#FFFFFF">
                        <template v-for="(data,index) in order">
                            <StackLayout :key="index">
                                <GridLayout columns="*, 2*, 25">
                                <Image :src="'https://seller.fashiostreet.com/products/compress220X258/' + data.image[len[index]]" col="0" stretch="aspectFill" width="97" height="110" margin="4 5 4 5" style="border-radius:4 0 0 4"
                                />
                                <StackLayout col="1" style="margin:5">
                                    <Label :text="data.name"
                                                        style="font-size:15;font-weight:500;line-height:60" />
                                    <StackLayout orientation="horizontal">
                                        <Label :text="'Rs.'+data.selling_price" style="font-size:17;font-weight:600" />
                                        <Label :text="'Rs.'+data.mrp_price" style="font-size:14;font-weight:500;padding:2;margin-left:5;text-decoration: line-through" />
                                    </StackLayout>
                                    <Label :text="'Size : '+data.size" style="font-size:14;font-weight:500" />
                                    <Label :text="'Color : '+data.color" style="font-size:14;font-weight:500" />
                                </StackLayout>
                                <StackLayout col="2">
                                    <Label text=":" style="padding:0 10 8 10; margin:5 0 5 0" />
                                </StackLayout>
                            </GridLayout>
                            </StackLayout>
                        </template>
                    </StackLayout>
                    <StackLayout v-show="url=='getcompletedproduct' && check==true" style="margin:8;margin-bottom:0;border-radius:4;background-color:#FFFFFF">
                        <template v-for="(data,index) in order">
                            <StackLayout :key="index">
                                <GridLayout columns="*, 2*, 25">
                                <Image :src="'https://seller.fashiostreet.com/products/compress220X258/' + data.image[len[index]]" col="0" stretch="aspectFill" width="97" height="110" margin="4 5 4 5" style="border-radius:4 0 0 4"
                                />
                                <StackLayout col="1" style="margin:5">
                                    <Label :text="data.name"
                                                        style="font-size:15;font-weight:500;line-height:60" />
                                    <StackLayout orientation="horizontal">
                                        <Label :text="'Rs.'+data.selling_price" style="font-size:17;font-weight:600" />
                                        <Label :text="'Rs.'+data.mrp_price" style="font-size:14;font-weight:500;padding:2;margin-left:5;text-decoration: line-through" />
                                    </StackLayout>
                                    <Label :text="'Size : '+data.size" style="font-size:14;font-weight:500" />
                                    <Label :text="'Color : '+data.color" style="font-size:14;font-weight:500" />
                                </StackLayout>
                                <StackLayout col="2">
                                    <Label text=":" style="padding:0 10 8 10; margin:5 0 5 0" />
                                </StackLayout>
                            </GridLayout>
                            </StackLayout>
                        </template>
                    </StackLayout>
                </StackLayout>
            </ScrollView>
            <StackLayout row="2" class="main_footer">
                <GridLayout columns="*, *, *">
                    <StackLayout col="0" style="vertical-align:middle" @tap="home">
                        <Label class="fa" :text="'fa-home' | fonticon"
                            horizontalAlignment="center"></Label>
                        <Label text="Home" horizontalAlignment="center">
                        </Label>
                    </StackLayout>
                    <StackLayout col="1" class="footer-links_active" style="vertical-align:middle" @tap="orders">
                        <Label class="fa" :text="'fa-cubes' | fonticon"
                            horizontalAlignment="center"></Label>
                        <Label text="Orders" horizontalAlignment="center">
                        </Label>
                    </StackLayout>
                    <StackLayout col="2"  style="vertical-align:middle" @tap="settings">
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
    import axios from '../axios';
    import Home from './Home';
    import Settings from './Settings';
    const application = require("tns-core-modules/application");
    export default {
        name:"Orders1",
        data() {
            return {
                index:0,
                page:1,
                order:null,
                loadMoreBtn:false,
                error:null,
                showLogin : true,
                url : null,
                check : false,
                len : []
            };
        },
        created(){
            axios.defaults.headers = {
                'Content-Type': 'application/json',
                'shopId' : localStorage.getItem('shopId'),
                'token' : localStorage.getItem('token')
            }
            application.android.on(application.AndroidApplication.activityBackPressedEvent, (args) => {
                args.cancel = true; //this cancels the normal backbutton behaviour
                //alert('The button was pressed but nothing happens');
            });
        },
        mounted(){
            this.index = 0;
            this.get();
        },
        components:{
            Home,
            Settings
        },
        methods:{
            home(){
                this.$navigateTo(Home);
            },
            settings(){
                this.$navigateTo(Settings);
            },
            change(args)
            {
                this.index = args;
                this.page = 1;
                this.check = false;
                this.error = null;
                this.order = null;
                this.showLogin = true;
                this.get();
            },
            getLoadMoreProduct(){
                this.page = this.page + 1;
                this.get();
            },
            get(){
                //var url = null;
                this.check = false;
                if(this.index==0){
                    this.url = 'getorderedproduct';
                }
                if(this.index==1){
                    this.url = 'getpickedupproduct';
                }
                if(this.index==2){
                    this.url = 'getreturnproduct';
                }
                if(this.index==3){
                    this.url = 'getcompletedproduct';
                }
                this.showLogin = true;
                //alert('hi');
                axios.get('/'+this.url)
                .then((response) => {
                    //alert(JSON.stringify(response));
                    this.order = response.data.result;
                    for(var i=0;i<this.order.length;i++)
                        {
                            this.order[i].image = this.order[i].image.split(',');
                            if(this.order[i].image.length==1)
                            {
                                this.len[i] = 0;
                            }
                            if(this.order[i].image.length==2)
                            {
                                this.len[i] = 1;
                            }
                            if(this.order[i].image.length==3)
                            {
                                this.len[i] = 2;
                            }
                        }
                    this.check = true;
                    this.showLogin = false;
                },(error) => {
                    this.error = error.response.data.message;
                    // alert(error.response.data.message);
                    this.showLogin = false;
                });
            }
        }
                
    };
</script>

<style scoped>
    .main_footer {
        background-color: #344955;
        color: #FFFFFF;
    }

    
    .footer-links_active {
        font-size: 16;
        color: #F9AA33;
    }
</style>