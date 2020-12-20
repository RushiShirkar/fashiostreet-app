<template>
  <f7-page class="bgpage" style="background-color:white" name="categorymen">
    <f7-navbar back-link="Back" class="bgnav" sliding>

      <f7-nav-title style="font-size:15px;margin:0px">
        WANT SOMETHING SPECIFIC !
      </f7-nav-title>
    </f7-navbar>
    <offline @detected-condition="handleConnectivityChange">
  </offline>
    <!-- Scrollable page content-->
    <f7-block style="margin:0px">
      <f7-row style="margin:10px 0px 16px 0px">
        <f7-col>
           <f7-card style="height:14vh;margin:0px;border-radius:5px">
             <img src="../assets/cat_page-subbannersp.png" style="width:100%;height:100%;border-radius:5px" alt="">
           </f7-card>
        </f7-col>
      </f7-row>
      <f7-row style="margin:10px 0px 10px 0px">
        <f7-col>
         <f7-link href="/specificPage" @click="save('clothing')">
           <f7-card style="height:16vh;margin:0px;border-radius:5px">
             <img src="../assets/sp_clothing.png" style="width:100%;height:100%;border-radius:5px" alt="">
           </f7-card>
         </f7-link>
        </f7-col>
        <f7-col>
         <f7-link href="/specificPage" @click="save('deodorant')">
           <f7-card style="height:16vh;margin:0px;border-radius:5px">
             <img src="../assets/sp_deodorant.png" style="width:100%;height:100%;border-radius:5px" alt="">
           </f7-card>
         </f7-link>
        </f7-col>
        <f7-col>
         <f7-link @click="sheet">
           <f7-card style="height:16vh;margin:0px;border-radius:5px">
             <img src="../assets/sp_next.png" style="width:100%;height:100%;border-radius:5px" alt="">
           </f7-card>
         </f7-link>
        </f7-col>
        <!--<f7-col>
         <f7-link href="/specificPage" @click="save('phonecover')">
           <f7-card style="height:16vh;margin:0px;border-radius:5px">
             <img src="../assets/sp_phonecover.png" style="width:100%;height:100%;border-radius:5px" alt="">
           </f7-card>
         </f7-link>
        </f7-col>-->
      </f7-row>
     <!-- <f7-row style="margin:10px 0px 10px 0px">
        <f7-col>
         <f7-link href="/specificPage" @click="save('electronicaccs')">
           <f7-card style="height:16vh;margin:0px;border-radius:5px">
             <img src="../assets/sp_electronicaccs.png" style="width:100%;height:100%;border-radius:5px" alt="">
           </f7-card>
         </f7-link>
        </f7-col>
        <f7-col>
         <f7-link @click="sheet">
           <f7-card style="height:16vh;margin:0px;border-radius:5px">
             <img src="../assets/sp_next.png" style="width:100%;height:100%;border-radius:5px" alt="">
           </f7-card>
         </f7-link>
        </f7-col>
        <f7-col>
        </f7-col>
      </f7-row> -->
    </f7-block>
    <div v-if="toast_msg != null" class="custom_toast z-depth-3" >
      {{ toast_msg }}
    </div>
    <f7-sheet ref="sizesheet1" style="height:auto">
    <f7-block-title style="margin:0px;padding:15px 15px 5px 15px;font-size:12px">WHICH CATEGORY SHOULD WE ADD NEXT ?</f7-block-title>
          <f7-block style="margin:0px;padding:0px">
            <f7-list form no-hairlines-md style="margin:0px">
            <f7-list-item>
                <h5 style="color:red;text-transform:uppercase;margin:0px">{{featureerror}}</h5>
                <f7-label floating>Give category name</f7-label>
                <f7-input type="text" @input="feature = $event.target.value" clear-button></f7-input>
            </f7-list-item>
            </f7-list>
            <f7-button fill @click="addFeature()" href="/specificWant" :disabled="sizeStatus" style="background-color:#00E676;font-size:12px;font-weight:bold;border-radius:0px;width:100%;margin-top:13px">SUBMIT</f7-button>
          </f7-block>
    </f7-sheet>
    <f7-block style="margin:0px;padding:0px;position:fixed;bottom:0;z-index:999;width:100%;background-color:white;box-shadow: 5px 0px 10px rgba(0, 0, 0, 0.12)">
      <f7-list accordion-list style="margin:0px">
  <f7-list-item accordion-item title="What is Specific Want Feature ?" style="font-size:14px;color:#000000;font-weight:bold">
    <f7-accordion-content>
      <f7-block style="font-size:13px;font-weight:normal;margin-top:18px">
        <p>
         If you are looking for something specific (Example:- White formal shirt or Red and white striped T-Shirt etc.) in particular price range and size. Then you can tell us above and we will find that product for you (from shops in your city).<br>
        </p>
        <p>
         <span style="font-weight:bold">Note :-</span><br>
         After you sent your specific want enquiry, you will get update regarding your enquiry through text message and whatsapp(photos of product will be sent through whatsapp so that you can choose).<br>
        </p>
      </f7-block>
    </f7-accordion-content>
  </f7-list-item>
      </f7-list>
  </f7-block>
  </f7-page>
</template>

<script>
import axios from '../axios';
import offline from 'v-offline';
export default {
  name: 'specificWant',
  data() {
    return {
      title: 'Services Page',
      category:'',
      c:['Cargos','Boxers','Socks','Handkerchiefs'],
      cartinfo:[],
      wishlistinfo:[],
      internet:null,
      status:'not shown',
      feature:null,
      featureerror:null,
      toast_msg:null
    };
  },
components: {
    offline
  },
  methods:{
    /*savecategory:function(category){
      localStorage.setItem("category",category);
    },*/
    addFeature(){
      if(this.feature!=null && this.feature!='')
      {
        this.$refs.sizesheet1.close();
        axios({
          method:'POST',
          url : '/upcoming',
          header : {
            'local-id' : localStorage.getItem('local_id'),
            'token' : localStorage.getItem('token')
          },
          data:{
            'feature':this.feature
          }
        }).then(response => {
            console.log(response);
            this.toast_msg = 'Thanks for helping us. We will definitely looking for your demand';
            setTimeout(() => {
              this.toast_msg = null;
            },2000);
            this.feature = null;
          },(error) => {
            alert(error.response.data.message);
        });
      }
      else
      {
        this.featureerror = 'Enter Category';
      }
    },
    sheet(){
      this.$refs.sizesheet1.open();
    },
    save(value){
      if(localStorage.getItem('specific')!=null)
      {
        localStorage.removeItem('specific');
      }
      localStorage.setItem("specific",value);
      localStorage.removeItem('gen');
      localStorage.removeItem('cat');
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
    }
  }
};
</script>
