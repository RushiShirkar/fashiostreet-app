<template>
    <Page actionBarHidden="true">
        <GridLayout rows="56, 40, *, 56">
            <StackLayout row="0">
                <GridLayout columns="7*, *">
                    <ScrollView orientation="horizontal" col="0" marginRight="8">
                        <StackLayout orientation="horizontal" style="padding-left:5">
                            <Button text="ALL" class="category_label" @tap="all"/>
                            <template v-for="(tab,index) in tabs" marginBottom="5">
                                <Button :text="tab.gender.charAt(0).toUpperCase(0)+'-'+tab.sub_category" :key="index" class="category_label"
                                    @tap="selectTab(tab.gender,tab.category,tab.sub_category,index)" />
                            </template>
                        </StackLayout>
                    </ScrollView>
                    <Button col="1" text="+" class="btn btn-addcategory" @tap="addCat"/>
                </GridLayout>
            </StackLayout>
            <Label :text="gs" row="1" style="background-color:#FFFFFF;padding:8 0 8 12; border-width: 1 0 0 0; border-color:#ECEFF1" />  
            <GridLayout row="2" rows="*" >
                <ScrollView>
                    <StackLayout style="background-color:#ECEFF1;padding-bottom:8">
                        <ActivityIndicator :busy="showLogin" height="30" width="30" marginTop="15" style="color:#344955" :visibility="showLogin ? 'visible':'collapse'"/>
                        <StackLayout v-show="ErrorMsg!=null" margin="8 8 0 8" fontSize="18" style="border-radius:4;background-color:#FFFFFF;vertical-align: middle;height:50">
                            <Label :text="ErrorMsg" horizontalAlignment="center" />
                        </StackLayout>
                        <StackLayout v-show="products!=null">
                            <template v-for="(product,index) in products">
                                <StackLayout :key="index" style="margin:8;margin-bottom:0;border-radius:4;background-color:#FFFFFF">
                                    <GridLayout columns="*, 2*, 30">
                                        <Image :src="'https://seller.fashiostreet.com/products/compress220X258/' + product.image[len[index]]" col="0" stretch="aspectFill"
                                            width="97" height="110" margin="4 5 4 5"
                                            style="border-radius:4 0 0 4" />
                                        <StackLayout col="1" style="margin:5">
                                            <Label :text="product.name"
                                                style="font-size:15;font-weight:500;line-height:60" />
                                            <StackLayout orientation="horizontal">
                                                <Label :text="'Rs.'+product.selling_price" style="font-size:17;font-weight:600" />
                                                <Label :text="'Rs.'+product.mrp_price" style="font-size:14;font-weight:500;padding:2;margin-left:5;text-decoration: line-through" />
                                            </StackLayout>
                                            <GridLayout columns="38, *">
                                                <Label col="0" text="Size : " style="font-size:14;font-weight:500" />
                                                <StackLayout col="1" orientation="horizontal">
                                                    <template v-for="(size,index) in product.sizes">
                                                        <Label :text="size.name+','" :key="index" style="font-size:14;font-weight:500" />
                                                    </template>
                                                </StackLayout>
                                            </GridLayout>
                                            <Label :text="'Color : '+product.color" style="font-size:14;font-weight:500" />
                                        </StackLayout>
                                        <StackLayout col="2">
                                            <Label class="fa" :text="'fa-ellipsis-v' | fonticon"  fontSize="20" style="padding:5 10 8 10" @tap="update(product.id)" />
                                        </StackLayout>
                                    </GridLayout>
                                </StackLayout>
                            </template>
                        </StackLayout>
                        <!--<StackLayout>
                            <Button v-show="loadMore" text="Load More" @tap="getLoadMoreProduct"/>
                        </StackLayout>-->
                    </StackLayout>
                </ScrollView>
                <AbsoluteLayout row="0" verticalAlignment="bottom" v-if="!isAllActive"
                    horizontalAlignment="right" style="padding:10">
                    <Button text="+ Add Products" class="btn-addproduct" @tap="addProduct">
                    </Button>
                </AbsoluteLayout>
            </GridLayout>
            <StackLayout row="3" class="main_footer">
                <GridLayout columns="*, *, *">
                    <StackLayout col="0" class="footer-links_active" style="vertical-align:middle">
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
    import AddTabs from './AddTabs';
    import Orders from './Orders';
    import Settings from './Settings';
    import AddProducts1 from './AddProducts1';
    import EditProduct1 from './EditProduct1';
    import axios from '../axios';
    const localStorage = require("nativescript-localstorage" );
    const application = require("tns-core-modules/application");
    export default {
        name: "Home",
        data() {
            return {
                tabs:[],
                TabsErrorMsg:null,
                TabGender: null,
                TabCategory: null,
                TabSub_Category: null,
                names:[],
                isActive : false,
                isAllActive : true,
                loadMore : false,
                products : null,
                pageNo : 1,
                ErrorMsg : null,
                gs : 'All Products',
                showLogin : true,
                gender : null,
                category : null,
                sub_category : null,
                len : []
            };
        },
        components:{
            AddTabs,
            Orders,
            Settings,
            AddProducts1,
            EditProduct1
        },
        created(){
            axios.defaults.headers = {
                'Content-Type': 'application/json',
                'shopId' : localStorage.getItem('shopId'),
                'token' : localStorage.getItem('token')
            };
            /*application.android.on(application.AndroidApplication.activityBackPressedEvent, (args) => {
                args.cancel = true; //this cancels the normal backbutton behaviour
                //alert('The button was pressed but nothing happens');
            });*/
        },
        mounted(){
            this.getTabs();
            this.getProducts();
        },
        methods:{
             refreshList(args) {
                var pullRefresh = args.object;
                this.getProducts();
                setTimeout(function() {
                    pullRefresh.refreshing = false;
                }, 1000);
            },
            update(id){
                action("Select Action", "Cancel", ["Edit Product", "Delete Product"])
                .then(result => {
                    if(result=='Edit Product')
                    {
                        localStorage.setItem("id",id);
                        this.$navigateTo(EditProduct1);
                    }
                    if(result=='Delete Product')
                    {
                        confirm({
                            title: "Confirm",
                            message: "Are you sure you want to delete this product ?",
                            okButtonText: "Delete",
                            cancelButtonText: "Cancel"
                            }).then(result => {
                                if(result==true)
                                {
                                    this.showLogin = true;
                                    this.deleteProduct(id);     
                                }
                        });
                    }
                    if(result=="Cancel")
                    {

                    }
                });
            },
            deleteProduct(id)
            {
                var url = '/deleteProduct';
                axios.post(url, {
                    'product_id': id
                })
                .then((response) => {
                    alert('successfully product deleted');
                    this.getProducts();
                }, (error) => {
                    if (error.response.data.status == 500) {
                        alert(error.response.data.message);
                    } else {
                        alert("System error found");
                    }
                });
            },
            all(){
                this.isAllActive = true;
                this.isActive = false;
                this.TabGender = null;
                this.TabCategory = null;
                this.gs = 'All Products';
                this.TabSub_Category = null;
                this.pageNo = 1;
                this.getProducts();
                this.showLogin = true;
            },
            selectTab: function (gender, category, sub_category,args) {
                this.TabGender = gender; 
                this.TabCategory = category;
                this.TabSub_Category = sub_category;
                
                this.gs = this.TabGender + ' / '+this.TabSub_Category;
                this.isActive = true;
                this.isAllActive = false;
                this.pageNo = 1;
                this.getProducts();
                this.showLogin = true;
                //this.makeTabActive(args);
            },
            getTabs(){
                this.tabs = null;
                var url = '/getTabs';
                axios.get(url)
                .then((response) => {
                    this.tabs = response.data.result;
                    //alert(JSON.stringify(this.tabs));

                }, (error) => {
                    console.log('in error sizes');
                    console.log(error.response);
                    if (error.response.data.status == 500) {
                        this.tabs = 0;
                        this.TabsErrorMsg = error.response.data.message;
                        alert(this.TabsErrorMsg);
                        //this.TabsErrorMsg = ' All Products';
                    } else {
                        this.tabs = 0;
                        this.TabsErrorMsg = "System error found";
                        alert(this.TabsErrorMsg);
                    }
                });
            },
            getLoadMoreProduct(){
                this.pageNo = this.pageNo + 1;
                alert('hi');
                this.showLogin = true;
                this.getProducts();
                alert('hi');
            },
            getProducts() {
                this.loadMore = false;
                this.ErrorMsg = null;
                this.products = null;
                var url = '/getProducts?page=' + this.pageNo;
                if(this.TabGender != null && this.TabCategory != null && this.TabSub_Category != null){
                    url = url + '&gender=' + this.TabGender + '&category=' + this.TabCategory + '&sub_category=' + this.TabSub_Category;
                }
                axios.get(url)
                .then((response) => {
                        this.products = response.data.result;
                        for(var i=0;i<this.products.length;i++)
                        {
                            this.products[i].image = this.products[i].image.split(',');
                            if(this.products[i].image.length==1)
                            {
                                this.len[i] = 0;
                            }
                            if(this.products[i].image.length==2)
                            {
                                this.len[i] = 1;
                            }
                            if(this.products[i].image.length==3)
                            {
                                this.len[i] = 2;
                            }
                        }
                        this.showLogin = false;
                        //alert(JSON.stringify(this.products));
                   
                }, (error) => {
                    if (error.response.data.status == 500) {
                        this.ErrorMsg = error.response.data.message;
                        this.showLogin = false;
                    } 
                    else {
                        this.ErrorMsg = "System error found";
                        this.showLogin = false;
                    }
                });
            },
            addProduct(){
                localStorage.setItem('g',this.TabGender);
                localStorage.setItem('c',this.TabCategory);
                localStorage.setItem('s',this.TabSub_Category);
                this.$navigateTo(AddProducts1);
                //this.$navigateTo(Settings);
            },
            orders(){
                this.$navigateTo(Orders);
            },
            settings(){
                this.$navigateTo(Settings);
            },
            addCat(){
                this.$navigateTo(AddTabs);
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
    .category_label {
        height: 35;
        vertical-align: middle;
        padding: 5 15;
        margin: 0 4;
        background-color: #344955;
        color: #FFFFFF;
        border-radius: 5;
        font-size: 16;
    }

    .btn-addproduct {
        height: 40;
        padding: 5 15;
        background-color: #F9AA33;
        color: #232F34;
        border-radius: 5;
        font-size: 14;
        font-weight: 500;
    }

    .active {
        border-width: 0 0 4 0;
        border-color: #F9AA33;
    }

    .hidden {
        visibility: collapsed;
    }

    .btn-addcategory {
        height: 41;
        margin: 0 8 0 0;
        padding: 0;
        background-color: #F9AA33;
        color: #232F34;
        border-radius: 5;
        font-size: 22;
    }
    
</style>