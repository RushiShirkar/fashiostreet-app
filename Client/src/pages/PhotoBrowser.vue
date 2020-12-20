<template>
  <f7-page>
    <f7-photo-browser
      :photos="photos"
      type="popup",
      theme="dark",
      ref="standalone"
    ></f7-photo-browser>
    <!--
    <a href="javascript:void(0)" style="position: absolute;padding: 10px;top:0px;right:0px;background-color: red;color:white;z-index:999;" @click="backPage($f7router)">
      X
    </a>
    <f7-swiper pagination>
      <template v-for="p_image in photos">
        <f7-swiper-slide class="image_viewer" style="height:100vh">
          <center>
                <img style="height:100%;"  :src="p_image" alt="">
          </center>
        </f7-swiper-slide>
      </template>
    </f7-swiper> -->


  </f7-page>
</template>

<script>
    export default {
        name: "PhotoBrowser",
      data(){
          return{
          }
        },
      computed:{
          photos:function(){
            var photos = JSON.parse(localStorage.getItem("photoBrowser"));
            var photosData = [];
            for(var i=0;i < photos.length;i++) {
              var tmp = photos[i].replace("compress420X458","compress620X658");
              photosData.push(tmp);
            }
            console.log(photosData);
            return photosData;
          }
      },
      created(){
        setTimeout( () => {
          var route = JSON.parse(localStorage.getItem('f7router-view_main-history'));
          if (route) {
            var length = route.length;
            if (route[length - 1] == route[length - 2]) {
              route.splice(-1, 1);
              localStorage.setItem("f7router-view_main-history", JSON.stringify(route));
            }
          }
          console.log('created call');
        },1000);
      },
      mounted(){
          this.$refs.standalone.open();
            console.log('mounted call');
      },
      methods:{
        backPage:function (route) {
            localStorage.removeItem("photoBrowser");
            route.back();
            console.log('back button press');
          }
      }
    }
</script>

<style scoped>
  #viewport {
    width: 100vw;
    height: 100vh;
    position: relative;
    background-color: #000;
    overflow: hidden;
  }
  .wrapper {
    position: absolute;
    left: 0;
    right: 0;
    top: 50%;
    margin-top: -80px;
  }
  .wrapper > img {
    width: 100%;
    display: block;
    height: auto;
  }
</style>
