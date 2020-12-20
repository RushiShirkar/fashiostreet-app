<template>
  <f7-page style="background-color:#ffffff">
  <f7-link @click="$f7router.back()" icon-f7="icon-arrow_left" style="color:#FFFFFF;margin-left:30px;margin-top:25px" ></f7-link>
  <img style="position:fixed;top:0;left:0;width:100%;height:100%" src="../assets/city2.png"/>
  <div>
    <f7-block style="margin:15px 0px 0px 28px;padding:0px">
      <div>
        <p style="color:#ffffff;font-size:11vw;font-weight:800;margin:0px">Fashio<span style="color:#76ff03">street</span></p>
        <p style="color:#ffffff;font-size:5vw;font-weight:bold;margin:0px 0px 0px 3px;letter-spacing:2px">Get best out of your city</p>
      </div>
    </f7-block>
    <center>
      <f7-block style="margin-top:calc(43% - 90px)">
        <div style="color:#FFFFFF;font-size: 20px;font-weight:bold;margin-top:20px">Select Your City</div>
        <div>
          <template v-for="city in cities">
            <a href="/" style="background-color:#FFFFFF;color:#121f4b;margin: 20px 45px 10px 45px;;font-size:18px;font-weight:bold;text-transform:capitalize;border-radius:30px" class="button button-fill button-big" @click="saveCity(city)"><b>{{ city }}</b></a>
          </template>
        </div>
      </f7-block>
    </center>
  </div>
  </f7-page>
</template>

<script>

    export default {
        name: "CitySelect",
        data(){
          return{
            preloaderStatus:true,
            cities:['kolhapur','islampur']
          }
        },
        methods:{
          saveCity:function(city){
            localStorage.setItem('city',city);
          }
        }
    }
</script>

<style scoped>
</style>
