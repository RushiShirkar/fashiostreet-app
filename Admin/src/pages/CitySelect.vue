<template>
  <f7-page style="background-image: linear-gradient(to bottom, #273657, #00c4cc)">
  <f7-link @click="$f7router.back()" icon-f7="icon-arrow_left" style="color:#FFFFFF;margin-left:30px;margin-top:25px" ></f7-link>
  <img style="position:fixed;bottom:0;left:0;width:100%" src="../assets/city.png"/>
  <div>
    <center>
      <f7-block>
        <div style="margin-top: 15%">
          <img style="width:100px" src="../assets/fashiostreet.png"/>
          <p style="color:#FFFFFF;font-size:24px;font-weight:800">Fashio<span style="color:#76ff03">street</span></p>
        </div>
        <div style="color:#FFFFFF;font-size: 20px;">Select Your City</div>
        <div>
          <template v-for="city in cities">
            <a href="/" style="background-color:#76ff03;color:#273657;margin: 20px 20px 10px 20px" class="button button-fill button-big" @click="saveCity(city)"><b>{{ city }}</b></a>
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
