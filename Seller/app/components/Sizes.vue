<template>
    <Page>
        <ActionBar class="action-bar">
            <GridLayout columns="30, 2*, *">
                <Label col="0" text="<" fontSize="20" fontWeight="500" @tap="back" />
                <Label col="1" text="Sizes" fontSize="20" fontWeight="500" />
            </GridLayout>
        </ActionBar>
        <StackLayout>
            <ListView class="list-group" for="item in items" @itemTap="onItemTap">
                <v-template>
                    <FlexBoxLayout flexDirection="row" class="list-group-item">
                        <CheckBox :text="item.name" :checked="isChecked" 
                            @checkedChange="onchange1($event.value,item.name)"/>
                        <TextField hint="0"  />
                    </FlexBoxLayout>
                </v-template>
            </ListView>
        </StackLayout>
    </Page>
</template>

<script>
    import AddProducts from './AddProducts';
    const localStorage = require( "nativescript-localstorage" );
    export default{
        name: "Sizes",
        data(){
            return{
                items:[
                    {name:"A"},
                    {name:"B"},
                    {name:"C"},
                    {name:"D"},
                    {name:"A"},
                    {name:"B"},
                    {name:"C"},
                    {name:"D"},
                    {name:"A"},
                    {name:"B"},
                    {name:"C"},
                    {name:"D"},
                    {name:"A"},
                    {name:"B"},
                    {name:"C"},
                    {name:"D"},
                    {name:"A"},
                    {name:"B"},
                    {name:"C"},
                    {name:"D"},
                    {name:"D"},
                    {name:"A"},
                    {name:"B"},
                    {name:"C"},
                    {name:"D"},  
                    {name:"D"},
                    {name:"A"},
                    {name:"B"},
                    {name:"C"},
                    {name:"D"}
                ],
                isChecked:null,
                sizes:null
            };
        },
        components:{
            AddProducts
        },
        methods:{
            select(name){
                alert(name);
            },
            back(){
                localStorage.setItem('sizes',this.sizes);
                this.$navigateTo(AddProducts);
            },
            onchange1(args,b){
                this.sizes = this.sizes + b + ',';
            }
        }
    };
</script>

<style scoped>

</style>