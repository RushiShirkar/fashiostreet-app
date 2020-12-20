<template>
  <f7-page name="shop"
           infinite
           :infinite-distance="50"
           :infinite-preloader="showPreloader"
           @infinite="loadMore"
           ptr @ptr:refresh="getShop2"
  >
    <f7-navbar back-link="Back" class="bgnav" sliding>

      <f7-nav-title style="font-size:15px;margin:0px;text-transform:uppercase">
        SHOPS AT {{city}}
      </f7-nav-title>
        <f7-nav-right>
          <!--<f7-link style="padding:0 10px" icon-f7="icon-search_strong" href="/search/Enter shop name you want/enter shop name/shop"></f7-link>-->
        <!-- <f7-link style="padding:0 10px" icon-f7="icon-search_strong" href="/search/"></f7-link> -->
        </f7-nav-right>
      </f7-searchbar>
    </f7-navbar>
    <offline @detected-condition="handleConnectivityChange">
  </offline>

<f7-list no-hairlines style="margin:12px 8px" class="shoplist shoplistcss">
  <template v-for="(result,index) in shopinfo">
      <f7-link style="margin-bottom:12px;width:100%;box-shadow:0px 1px 6px 0px rgba(0, 0, 0, 0.1);border-radius:4px" @click="saveshop(result.name)" href="/shophome/">
        <f7-card style="padding-bottom:2px;width:100%;-webkit-box-shadow: none;box-shadow: none;border-radius:4px">
          <f7-row no-gap style="padding:8px">
           <f7-col width="40" style="height:120px;border-radius:4px">
             <span style="position:absolute;top:15px;left:15px;background-color:#1fd163;color:#FFFFFF;padding:3px 5px;border-radius:4px">NEW</span>
             <img :src="result.image" style="width:100%;height:100%;border-radius:4px" alt="">
           </f7-col>
           <f7-col width="60" style="padding-left:10px">
             <h4 style="font-weight:bold;color:#595959;font-size:18px" class="mpzero lineclampin">{{result.name}}</h4>
             <!--<h5 style="font-weight:normal;color:#BDBDBD;font-size:14px" class="mpzero lineclampin">{{genders[index]}}</h5>-->
             <div style="padding:10px 0px;overflow-x:scroll;overflow-y:hidden;white-space:nowrap;" v-show="result.offers!=null">
              <template v-for="offer in result.offers">
               <span style="font-weight:normal;font-size:14px;background-color:skyblue;color:navy;padding:5px 10px;border-radius:2px" class="lineclampin">{{offer}}</span>
              </template>
             </div>
             <div style="padding:10px 0px;overflow-x:scroll;overflow-y:hidden;white-space:nowrap;" v-show="result.offers==null">
                <span style="font-weight:normal;font-size:14px;background-color:skyblue;color:navy;padding:5px 10px;border-radius:2px">No Offers</span> 
             </div>
             <h5 style="font-weight:normal;color:#BDBDBD;font-size:14px" class="mpzero lineclampin">{{result.address}}</h5>
           </f7-col>
          </f7-row>
        </f7-card>
      </f7-link>
  </template>
</f7-list>
  </f7-page>

</template>

<script>
import axios from '../axios';
import offline from 'v-offline';
export default {
  name: 'Shop',
  data() {
    return {
      title: 'Services Page',
      inProcess:false,
      categories:true,
      distances:false,
      ratings:false,
      shopinfo:[],
      city:null,
      showPreloader:true,
      allowInfinite:true,
      page:1,
      loadMoreData:[],
      internet:null,
      status:'not shown',
      list:[],
      genders:[],
      g : []
    };
  },
  components: {
    offline
  },
   mounted(){
     this.city=localStorage.getItem("city");
     console.log(this.city);
     this.getShop();
     this.getList();
  },
  destroyed(){
    console.log('destroyed function call');
  },
  methods:{
    getList(){
      console.log(localStorage.getItem('city'));
      axios({
        method:'GET',
        url : '/getlist/'+localStorage.getItem('city')
      }).then(response => {
        this.list = response.data.result;
        console.log(this.list);
        for(var i=0;i<this.list.length;i++)
        {
          axios({
            method:'GET',
            url : '/getGenders/'+this.list[i].id
          }).then(response=> {
              //console.log(response);
              var a = null;
              a = response.data.result;
              var b =  a[0].name;
              this.genders[i] = this.genders[i].push(b);
              /*this.g[i] = this.genders[i];
              console.log(this.g[i]);*/
          }).catch(error => {
            alert(error.response.data.message);
          });
        }
      }).catch(error => {
        if(error.response.data.message != undefined)
          alert(error.response.data.message);
        else
          alert('Something went wrong,please try again');
      });
      console.log(this.genders);
    },
    handleConnectivityChange(status) {
      this.internet = status;
      console.log(this.internet);
      if(this.internet == false)
      {
        this.showNotificationWithButton();
      }
      if(this.internet == true)
      {
        this.closepop();
      }
    },
     showNotificationWithButton() {
        const self = this;

        if (!self.notificationWithButton) {
          self.notificationWithButton = self.$f7.notification.create({
            icon: '',
            title: '',
            cssClass:'color',
            subtitle: 'Please Connect to Internet',
            text: ''
          });
        }
        // Open it
        self.notificationWithButton.open();
      },
    closepop:function(){
      const self = this;
      self.notificationWithButton.close();
    },
    openPopup:function(){

      if(this.status == 'notshown')
      {
      this.popupOpened = true;

      this.status = 'shown';

      }
    },
    loadMore:function(){
      console.log('load more call');
      const self = this;
      if(this.loadMoreData.length >= 14)
      {
        self.allowInfinite = true;
      }
      else{
        self.allowInfinite = false;
        self.showPreloader = false;
        return false;
      }
      if(!self.allowInfinite) return;
      self.allowInfinite = false;
      if(this.loadMoreData.length >= 15)
      {
        if(this.inProcess == false)
        {
          this.inProcess = true;
          console.log('load more call...');
          this.getShop();
          self.allowInfinite = true;
          return true;
        }
      }
      else {
        self.showPreloader = false;
      }
      console.log('no more product');
      return false;
    },
    getShop2:function(event,done)
    {
      this.showPreloader = true;
      this.getShop(event,done,1);
    },
    getShop:function(event,done,index){
      console.log('start page : ' + this.page);
      if(index != undefined)
      {
        this.page = index;
      }
      axios({
        method:'GET',
        url : '/shop/'+localStorage.getItem("city")+'/json?shop=All%20Shop&page=' + this.page
      }).then((response) => {
        this.inProcess = false;
        if(this.page == 1)
        {
          this.shopinfo=response.data;
          console.log(this.shopinfo);
          this.loadMoreData = response.data;
        }
        else if(this.page > 1)
        {
          this.loadMoreData = response.data;
          console.log(this.shopinfo);
          this.shopinfo = this.shopinfo.concat(this.loadMoreData);
          console.log(this.shopinfo);
        }
        else{
          this.page = 0;
        }
        if(index != undefined)
        {
          done();
        }
        this.page = this.page + 1;
        console.log('End page : ' + this.page);
      },(error) => {
        this.inProcess = false;
        if(this.page = 1)
        {
          done();
        }
        if (error.response.data.message != undefined) {
          alert(error.response.data.message);
        }
        else
          alert('application error found,restart your application');
      });
    },
    saveshop:function(sname)
    {
      localStorage.setItem("sname",sname);
    }
  }
};
</script>
<style scoped>
.lineclampin{
    overflow: hidden !important;
    text-overflow: ellipsis !important;
    white-space: nowrap !important;
    width: 100% !important;
}
</style>