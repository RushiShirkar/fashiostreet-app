<template>
    <Page actionBarHidden="true" loaded="pageLoaded" >
        <GridLayout rows="56, 125, *">
            <GridLayout row="0" columns="50, 2*" class="action-bar">
                <Label col="0" class="fa" :text="'fa-angle-left' | fonticon" fontSize="24" fontWeight="500" style="padding:0 20 0 20;vertical-align:middle" @tap="back" />
                <Label col="1" text="Offer Zone" fontSize="20" fontWeight="500" style="vertical-align:middle"/>
            </GridLayout>
            <GridLayout row="1" margin="8">
                    <StackLayout>
                        <TextField hint="Enter offer" v-model="name" />
                        <Button text="+ Add Offer" class="btn-addoffer" @tap="addOffer" />
                    </StackLayout>
            </GridLayout>
            <GridLayout row="2" style="background-color:#ECEFF1">
                <ScrollView>
                    <StackLayout>
                        <template v-for="(item,index) in offers">
                            <StackLayout :key="index">
                            <GridLayout columns="*, 30" margin="8 8 0 8" style="padding:18;background-color:#FFFFFF;border-radius:4;height:60">
                                <StackLayout col="0">
                                    <Label :text="item" marginLeft="3" />
                                </StackLayout>
                                <StackLayout col="1" @tap="deleteOffer(index)">
                                    <Label class="fa" :text="'fa-trash' | fonticon" fontSize="22" fontWeight="500" marginRight="3"/>
                                </StackLayout>
                            </GridLayout>
                            </StackLayout>
                        </template>
                    </StackLayout>
                </ScrollView>
            </GridLayout>
        </GridLayout>
    </Page>
</template>

<script>
    import Settings from './Settings';
    const localStorage = require( "nativescript-localstorage" );
    import axios from '../axios';
    export default{
        name : 'Offer',
        data(){
            return{
                offer : [],
                offers : [],
                id : null,
                name : null,
                data : null,
                qwe : null,
                abc : null
            };
        },
        mounted(){
            this.getOffers();
        },
        created(){
            axios.defaults.headers = {
                'Content-Type': 'application/json',
                'shopId' : localStorage.getItem('shopId'),
                'token' : localStorage.getItem('token')
            };
        },
        methods:{
            getOffers(){
                axios({
                  method:'GET',
                  url:'/getOffers/'+localStorage.getItem('shopId')
                }).then(response => {
                    this.offer = response.data.result;
                    this.data = this.offer[0].offers;   
                    this.offers = this.data;
                    this.offers = this.offers.split(',');  
                }, (error) =>{
                  alert(error.response.data.message);   
                });
            },
            deleteOffer(index){
                this.offers.splice(index,1);
                this.abc = this.offers.join(',');
                const data = {
                    id : localStorage.getItem('shopId'),
                    offers : this.abc
                };
                axios.post('/offer',data)
                .then((response) => {
                        this.getOffers();
                        alert('Offer Deleted');
                })
                .catch((error) =>{
                    if(error.response.status == 500)
                    {
                    }
                    console.log(error.response.data.message);
                });
            },
            addOffer(){
                if(this.name==null || this.name==''){
                    alert('Enter Offer');
                }
                else
                {
                    if(this.data==null){
                    this.qwe = this.name;
                    }
                    else{
                        this.qwe = this.data+','+this.name;
                    }
                    const data = {
                        id : localStorage.getItem('shopId'),
                        offers : this.qwe
                    };
                    axios.post('/offer',data)
                    .then((response) => {
                            this.getOffers();
                            alert('Offer added');
                            this.name = '';
                    })
                    .catch((error) =>{
                        if(error.response.status == 500)
                        {
                        }
                        alert(error.response.data.message);
                    });
                    this.offer = null;
                }
            },
            back(){
                this.$navigateTo(Settings);
            }
        }
    };
</script>

<style scoped>
.btn-addoffer {
        height: 45;
        padding: 0 15;
        margin: 10 4 5 4;
        background-color: #F9AA33;
        color: #232F34;
        border-radius: 4;
        font-size: 14;
    }
</style>