<template>
    <Page loaded="pageLoaded" class="page">
        <ActionBar class="action-bar" marginLeft="-20">
            <GridLayout columns="50, 2*, *">
                <Label col="0" class="fa" :text="'fa-angle-left' | fonticon" fontSize="24" fontWeight="500" style="padding:0 20 0 20" @tap="back" />
                <Label col="1" text="Add Category" fontSize="20" fontWeight="500" />
                <StackLayout col="2" class="btn btn-upload" horizontalAlignment="right" style="vertical-align:middle" @tap="addTab">
                    <Label text="+ ADD" style="padding:5"  horizontalAlignment="center" :visibility="!showLogin ? 'visible':'collapse'"/>
                    <ActivityIndicator :busy="showLogin"  height="20" width="20" style="color:#344955"/>
                </StackLayout>
            </GridLayout>
        </ActionBar>
        <GridLayout rows="60, 60" style="background-color:#ECEFF1">
            <GridLayout row="
            0" columns="*, *, 30" @tap="getGender"
                margin="8 8 0 8" style="padding:15;background-color:#FFFFFF;border-radius:4;">
                <StackLayout col="0">
                    <Label text="Gender" marginLeft="3" />
                </StackLayout>
                <Label col="1" :text="gender" horizontalAlignment="right" />
                <StackLayout col="2">
                    <Label text="+" class="pull-right" margin="0 10 0 10" />
                </StackLayout>
            </GridLayout>
            <GridLayout row="1" columns="*, *, 30" @tap="getSub" margin="8 8 0 8"
                style="padding:15;background-color:#FFFFFF;border-radius:4;">
                <StackLayout col="0">
                    <Label text="Sub-Category" marginLeft="3" />
                </StackLayout>
                <Label col="1" :text="cat" horizontalAlignment="right" />
                <StackLayout col="2">
                    <Label text="+" class="pull-right" margin="0 10 0 10" />
                </StackLayout>
            </GridLayout>
        </GridLayout>
    </Page>
</template>
<script>
    import Home from './Home'
    import axios from '../axios'
    const application = require("tns-core-modules/application");
    export default{
        name:"AddTabs",
        data(){
            return{
                gender:null,
                cat:null,
                selectedCategory:null,
                showLogin: false
                
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
        components:{
            Home
        },
        methods:{
            back(){
                this.$navigateTo(Home);
            },
            addTab(){
                if(this.cat==null)
                {
                    alert('Please select Sub-Category');
                }
                if((this.cat=='T-Shirts' || this.cat=='Casual Shirts' || this.cat=='Sweatshirts') && this.gender=='Men')
                {
                    this.selectedCategory = 'Top Wear';
                }
                else if((this.cat=='Jeans' || this.cat=='Cargos' || this.cat=='Shorts and 3 by 4ths' || this.cat=='Track Pants') && this.gender=='Men')
                {
                    this.selectedCategory = 'Bottom Wear';
                }
                else if((this.cat=='Briefs and Trunks' || this.cat=='Vests' || this.cat=='Boxers') && this.gender=='Men')
                {
                    this.selectedCategory = 'Innerwear and Sleepwear';
                }
                else if((this.cat=='Socks' || this.cat=='Handkerchiefs') && this.gender=='Men')
                {
                    this.selectedCategory = 'Accessories';
                }
                else if((this.cat=='Kurtis' || this.cat=='Leggings' || this.cat=='Salwars' || this.cat=='Dress Material' ) && this.gender=='Women')
                {
                    this.selectedCategory = 'Ethnic Wear';
                }
                else if((this.cat=='Capris' || this.cat=='Shirts' || this.cat=='Tops' || this.cat=='T-Shirts' || this.cat=='Jeans' || this.cat=='Dungarees' || this.cat=='Jackets' || this.cat=='One Piece' || this.cat=='Plazo' || this.cat=='Shrugs') && this.gender=='Women')
                {
                    this.selectedCategory = 'Western Wear';
                }
                else if((this.cat=='Sweatshirts' || this.cat=='Socks') && this.gender=='Women')
                {
                    this.selectedCategory = 'Winter and Seasonal';
                }
                else if((this.cat=='Casual Shoes' || this.cat=='Formal Shoes' || this.cat=='Sport Shoes' || this.cat=='Loafers' || this.cat=='Sneakers' || this.cat=='Sandals' || this.cat=='Chappals') && this.gender=='Footwear')
                {
                    this.selectedCategory = 'Men Footwear';
                }
                else if((this.cat=='Fogg' || this.cat=='Axe' || this.cat=='Wildstone' || this.cat=='Park Avenue' || this.cat=='Nivea' || this.cat=='Denver' || this.cat=='Engage' || this.cat=='Kamasutra' || 
                        this.cat=='Rasasi' || this.cat=='Envy' || this.cat=='He' || this.cat=='Jaguar' || this.cat=='Nike' || this.cat=='Cfs' || this.cat=="19V69") && this.gender=='Deodorant')
                {
                    this.selectedCategory = 'Men Deodorant';
                }
                var url = '/addTab';
                this.showLogin = true;
                axios.post(url, {
                'gender': this.gender,
                'category': this.selectedCategory,
                'sub_category': this.cat
                })
                .then((response) => {
                    alert('Category Successfully Added');
                    this.$navigateTo(Home);
                    this.showLogin = false;
                    return true;
                }, (error) => {
                    if (error.response.data.status == 500) {
                        alert(error.response.data.message);
                        this.showLogin = false;
                        return false;
                    } else {
                        alert('server error found,try again');
                        this.showLogin = false;
                    }
                });
            },
            getGender(){
                action("Select Gender", "Cancel", ["Men", "Women","Footwear","Deodorant"])
                    .then(result => {
                        this.gender = result;
                        if(this.gender=='Cancel')
                        {
                            this.gender = '';
                        }
                });
            },
            getSub(){
                if(this.gender == "Men")
                {
                    action("Select Sub-Category", "Cancel", ["T-Shirts", "Jeans","Sweatshirts","Casual Shirts","Cargos",
                        "Shorts and 3 by 4ths","Track Pants","Briefs and Trunks","Vests","Boxers","Socks","Handkerchiefs"])
                    .then(result => {
                        this.cat = result;
                    });
                }
                if(this.gender == "Women")
                {
                    action("Select Sub-Category", "Cancel", ["Shirts","Tops", "One Piece","T-Shirts","Jeans","Dungarees","Socks",
                        "Fashion Jackets","Plazo","Shrugs","Kurtis","Dress Material","Salwars","Leggings","Capris","Sweatshirts"])
                    .then(result => {
                        this.cat = result;
                    });
                }
                if(this.gender == "Footwear")
                {
                    action("Select Sub-Category", "Cancel", ["Casual Shoes","Formal Shoes","Sport Shoes","Loafers","Sneakers","Sandals","Chappals"])
                    .then(result => {
                        this.cat = result;
                    });
                }
                if(this.gender == "Deodorant")
                {
                    action("Select Sub-Category", "Cancel", ["Fogg","Axe","Wildstone","Park Avenue","Nivea","Denver","Engage","Kamasutra",
                            "Rasasi","Envy","He","Jaguar","Nike","Cfs","19V69"])
                    .then(result => {
                        this.cat = result;
                    });
                }
                if(this.gender == '')
                {
                    alert('Please select Gender')
                }
                
            }
        }
    };
</script>

<style>
    .page {
        align-items: center;
        flex-direction: column;
        width:100%
    }

    .action-bar {
        background-color: #344955;
        color: #FFFFFF;
    }

    .btn-upload {
        height: 30;
        width:100%;
        margin: 0 10 0 0;
        padding: 0 15;
        background-color: #F9AA33;
        color: #232F34;
        border-radius: 5;
        font-size: 14;
    }

    .error {
        color: #D51A1A;
        padding-bottom: 10;
        margin-left: 3;
    }
</style>