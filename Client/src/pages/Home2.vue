  <template>
  <f7-page>
    <f7-navbar class="bgnav" sliding v-show="loginmobile!=null">
      <f7-nav-left>
        <f7-link icon-f7="icon-bars" panel-open="left"></f7-link>
      </f7-nav-left>
      <f7-link href="/cityselector/" style="height:0px;padding:0px">
      <img src="../assets/pin.svg" alt="">
      <f7-nav-title style="font-size:18px;margin:0px;font-weight:bold;text-transform: capitalize;border-bottom:1px solid #FFFFFF;padding:5px;margin-left:2px">
        {{city}}
        <f7-icon style="margin-left:5px" f7="chevron_down" size="14"></f7-icon>
      </f7-nav-title>
      </f7-link>
      <f7-nav-right>
        <!--<f7-link style="padding:0 10px" icon-f7="icon-search_strong" href="/search/WHATS YOUR TODAY WISH/enter product you want/product"></f7-link>-->
         <f7-link v-if="loginmobile!=null" style="padding:0 10px" href="/wallet"> <img src="../assets/wallet.svg" alt=""></f7-link>
        <f7-link v-else style="padding:0 10px" href="/login/"> <img src="../assets/wallet.svg" alt=""></f7-link>
        <f7-link style="padding:0 10px" href="/shop/"> <img src="../assets/shop-store.svg" alt=""></f7-link>
        <f7-link style="padding:0 10px" href="/hdcart/" v-if="cartinfo.length>0"><img src="../assets/delivery-motorbike.svg" alt="">
          <span class="badge" v-if="cartinfo.length>0" style="border-radius: 16px;height: 20px;width: 20px;margin-top:-18px;margin-left:-1.5vw;background-color:#5ddcf9;color:#000000"><p style="margin-top: -19px;margin-left: -0.5vw;font-size:14px;font-weight:bold">{{cartinfo.length}}</p></span>
        </f7-link>
        <f7-link style="padding:0 10px" href="/hdcart/" v-else><img src="../assets/delivery-motorbike.svg" alt=""></f7-link>
      </f7-nav-right>
    </f7-navbar>
    <f7-subnavbar class="bgsubnav" style="height:85px" v-show="loginmobile!=null">
    <div style="overflow-x:scroll;overflow-y:hidden;white-space:nowrap;padding-left:5px">
         <f7-link  href="/specificWant" style="height:100%;padding:0px 5px"><f7-card style="height:64px;margin:0px;border-radius:4px" class="cat_width"><img src="../assets/hcbsp.png" style="width:100%;height:100%;border-radius:4px" alt=""></f7-card></f7-link>
         <f7-link @click="savegender('Men')" href="/categorymen/" style="height:100%;padding:0px 5px"><f7-card style="height:64px;margin:0px;border-radius:4px" class="cat_width"><img src="../assets/hcb1.png" style="width:100%;height:100%;border-radius:4px" alt=""></f7-card></f7-link>
         <!--<f7-link @click="savegender('Women')" href="/categorywomen/" style="height:100% ;padding:0px 5px"><f7-card style="height:64px;margin:0px;border-radius:4px" class="cat_width"><img src="../assets/hcb2.png" style="width:100%;height:100%;border-radius:4px" alt=""></f7-card></f7-link>-->
         <f7-link @click="savegender('Footwear')" href="/categoryfootwear/" style="height:100% ;padding:0px 5px"><f7-card style="height:64px;margin:0px;border-radius:4px" class="cat_width"><img src="../assets/hcb5.png" style="width:100%;height:100%;border-radius:4px" alt=""></f7-card></f7-link>
         <!--<f7-link @click="savegender('Baby and Kids')" href="/categorykids/" style="height:100% ;padding:0px 5px"><f7-card style="height:64px;margin:0px;border-radius:4px" class="cat_width"><img src="../assets/hcb3.png" style="width:100%;height:100%;border-radius:4px" alt=""></f7-card></f7-link>-->
         <f7-link @click="save('deodorant')" href="/specificPage" style="height:100% ;padding:0px 5px"><f7-card style="height:64px;margin:0px;border-radius:4px" class="cat_width"><img src="../assets/hcb4.png" style="width:100%;height:100%;border-radius:4px" alt=""></f7-card></f7-link>
         <!--<f7-link @click="save('electronicaccs')" href="/specificPage" style="height:100% ;padding:0px 5px"><f7-card style="height:64px;margin:0px;border-radius:4px" class="cat_width"><img src="../assets/raincoat.png" style="width:100%;height:100%;border-radius:4px" alt=""></f7-card></f7-link>-->
      </div>
</f7-subnavbar>
    <center v-show="loginmobile==null" style="margin-top:-150px;height:calc(100% + 150px)">
    <div style="height:100%;overflow:hidden;display: flex;flex-direction: column;">
    <f7-swiper pagination class="mpzero" :params="{speed:500,loop:true, slidesPerView: 1, autoplay: { delay: 2000, disableOnInteraction:false }}" style="flex: 1 1 100%">
          <f7-swiper-slide class="swiper-slide" data-swiper-autoplay="4000">
              <img src="../assets/opening-banner_1.png" style="width:100%;height:100%" alt="">
          </f7-swiper-slide>
          <f7-swiper-slide class="swiper-slide" data-swiper-autoplay="4000">
              <img src="../assets/opening-banner_2.png" style="width:100%;height:100%" alt="">
          </f7-swiper-slide>
          <f7-swiper-slide class="swiper-slide" data-swiper-autoplay="4000">
              <img src="../assets/opening-banner_3.png" style="width:100%;height:100%" alt="">
          </f7-swiper-slide>
          <f7-swiper-slide class="swiper-slide" data-swiper-autoplay="4000">
              <img src="../assets/opening-banner_4.png" style="width:100%;height:100%" alt="">
          </f7-swiper-slide>
      </f7-swiper>
      <f7-block style="margin:0px;flex: 0 0 auto">
        <div style="color:gray;font-size: 14px;" v-show="mobileCheck!=true">Ready to Explore Local World !</div>
        <h5 style="color:red;text-transform:capitalize;margin:0px;text-align:left;padding:5px 0px 0px 16px">{{mobileError}}</h5>
        <f7-list form style="margin:0px" no-hairlines>
          <f7-list-item v-show="mobileCheck!=true">
                 <f7-label floating style="float:left">Enter Phone number</f7-label>
                 <f7-input type="number" @input="mobile = $event.target.value" clear-button></f7-input>
          </f7-list-item>
          <f7-list-item v-show="mobileCheck==true" style="margin-top:-15px;">
            <f7-row>
              <f7-col style="font-size:16px;padding:0px 0px 16px;text-align:left">
                 +91 {{mobile}}
              </f7-col>
              <f7-col style="padding:0px 0px 16px;text-align:right">
                  <a href="javascript:void(0)" @click="changeNumber" style="color:#1d2671;font-weight:bold">Edit Number</a>
              </f7-col>
            </f7-row>
            <h5 style="color:green;text-transform:capitalize;margin:0px;text-align:left">{{otpSend}}</h5>
            <f7-row>
              <f7-col width="65">
                 <f7-label floating style="float:left">Enter OTP</f7-label>
                 <f7-input type="number" @input="otp = $event.target.value" clear-button></f7-input>
              </f7-col>
              <f7-col width="35" style="padding:16px 0px 0px">
                  <a href="javascript:void(0)" @click="resendOtp" style="color:#1d2671;font-weight:bold">Resend OTP</a>
              </f7-col>
            </f7-row>
          </f7-list-item>
        </f7-list>
        <div>
            <a @click="login" style="background-image: linear-gradient(to right, #1d2671, #dc5496);color:#00FF96;font-size:18px;font-weight:bold;border:0px;text-transform:Capitalize;margin:10px" class="button button-fill button-big">{{btn_text}} <f7-icon f7="chevron_right" style="margin:-5px 0px 0px 10px"></f7-icon></a>
        </div>
        <div v-if="AppLoader" style="position:fixed;width:100%;height:100vh;background-color: rgba(255,255,255,0.8);z-index:999">
          <center>
            <div class="preloader" style="margin-top:45vh">
            <span class="preloader-inner">
              <span class="preloader-inner-gap"></span>
              <span class="preloader-inner-left">
                  <span class="preloader-inner-half-circle"></span>
              </span>
              <span class="preloader-inner-right">
                  <span class="preloader-inner-half-circle"></span>
              </span>
            </span>
            </div>
          </center>
        </div>
      </f7-block>
  </div>
  </center>
  <div v-show="loginmobile!=null">
    <center v-if="showPreloader">
      <br/><br/><br/>
      <div class="preloader">
        <span class="preloader-inner">
          <span class="preloader-inner-gap"></span>
          <span class="preloader-inner-left">
              <span class="preloader-inner-half-circle"></span>
          </span>
          <span class="preloader-inner-right">
              <span class="preloader-inner-half-circle"></span>
          </span>
        </span>
      </div>
    </center>
  <offline @detected-condition="handleConnectivityChange">
  </offline>

    <div v-if="!showPreloader">
            <f7-block style="margin-top:-96px;background-color:white;margin:0px;height:48px;box-shadow: 0px 5px 10px rgba(0, 0, 0, 0.12);z-index:99">
              <center style="line-height:48px;color:#4caf50;font-size:17px;font-weight:bold">{{ slogan }}
               </center>
              </f7-block>
        <f7-swiper class="mpzero" :params="{speed:500,loop:true, slidesPerView: 1, autoplay: { delay: 2000, disableOnInteraction:false }}">
          <f7-swiper-slide class="swiper-slide" data-swiper-autoplay="2000" v-for="(image,index) in images" :key="image.name">
            <f7-card style="width:100%" class="cardm">
            <f7-link href="javascript:void(0)" @click="index!=0?saveshop(image.shop,image.name,index,$f7router,'/offers1'):''" style="width: 100%;height: 100%">
              <img :src="image.banner" style="width:100%;height:100%" alt="">
            </f7-link>
            </f7-card>
            </f7-swiper-slide>
      </f7-swiper>

      <f7-popup class="demo-popup " id="pop" :opened="popupOpened" @popup:closed="popupOpened = false">
      <f7-page>
        <f7-navbar class="bgnav">
          <f7-nav-title style="font-size:18px;font-weight:bold;margin:0px;padding-left:16px">
              Stand With Fashiostreet
          </f7-nav-title>
          <f7-nav-right>
            <f7-link popup-close @click="closepop()">X</f7-link>
          </f7-nav-right>
        </f7-navbar>
        <f7-block style="text-align:center">
          <img src="../assets/gandhiji.png" style="width:150px;height:150px" alt="">

          <div class="block" style="margin-top:0px"> 
<div class="row" style="font-size:7vw;font-weight:bold">
<p class="text-align-center" style="margin:10px auto 10px auto">Fashiostreet -<br><span style="color:#1d2671">Saving Shopkeepers</span></p>
</div>
<div class="row" style="font-size:4vw">
<p class="text-align-center">Support FASHIOSTREET in saving your local shopkeepers against big online shopping companies which are mostly foreign. Help us spread the word by rating us on the Play store. It'll only take 15 seconds.</p>
</div>
<div class="row" style="font-size:5vw">
<p class="text-align-center" style="margin:30px auto 0px auto">Made with ❤️ in Kolhapur 👑</p>
</div>
  </div>
        </f7-block>
        <div style="position:fixed;bottom:0;z-index:999;width:100%;background-color:#FFFFFF;box-shadow: 5px 0px 10px rgba(0, 0, 0, 0.12)">
        <a class="link external" href="https://play.google.com/store/apps/details?id=com.shoping_search_engine.fashiostreet&hl=en_US" style="width:100%">
         <button class="col button button-big button-fill popup-close" style="background-image: linear-gradient(to right, #1d2671, #dc5496);color:#00FF96;font-size:18px;font-weight:bold;border:0px;text-transform:Capitalize;margin:10px">Rate Us Now &nbsp <f7-icon f7="chevron_right"></f7-icon></button>
        </a>
        </div>
      </f7-page>
    </f7-popup>
    <f7-block style="background-color:white;padding:0px;margin:0px">
     <div style="padding:22px 16px 22px 20px">
        <div style="display:inline-block;height:30px">
          <img src="../assets/trending_icon.png" style="width:30px;height:30px;border-radius:50%;vertical-align: middle;" alt="Shops">
        </div>
        <div style="font-weight:bold;color:#000000;font-size:18px;display:inline-block;vertical-align: middle;" class="mpzero">&nbsp Top products at {{city}}</div>
      </div>
    <div style="overflow-x:scroll;overflow-y:hidden;white-space:nowrap;padding:0px 0px 0px 13px">
  <template v-for="(result,index) in trending">
    <f7-link :key="index" :href="'/productdetails/' + result.id + '/' + result.name" style="width:162px;height:46vh;margin:0px 3px" @click="saveid(result.id)">
      <f7-card style="width:100%;height:100%;margin:0px;padding:0px;-webkit-box-shadow: none;box-shadow: none">
        <div class="image_viewer" style="width: 100%;height:34vh;">
          <img :src="result.image[0]" style="width:100%;height:100%;margin:0px;object-fit: contain">
        </div>
        <div style="position:absolute;top:10px;left:10px;z-index:99;background-color:#5ddcf9;border-radius:50%;color:#000000;width:46px;height:46px;opacity:0.9;text-align:center">
            <p style="font-size:20px;font-weight:bold;margin:6px 0px 0px;padding:0px;line-height:20px">{{discountTrending[index]}}</p>
            <p style="font-size:10px;font-weight:bold;margin:0px;padding:0px;line-height:12px">% OFF</p>
        </div>
        <f7-block style="color:gray;font-size:14px;font-weight:bold;padding:8px">
          <p class="mpzero lineclampin">
          <span style="color:#000000;font-size:17px">&#8377;{{result.selling_price}} </span>
          <span style="text-decoration:line-through;margin-left:3px">&#8377;{{result.mrp_price}}</span></p>
          <p class="mpzero lineclampin" style="margin-top:6px">
          <img src="../assets/shop_icon.png" style="width:24px;height:24px;border-radius:50%;vertical-align: middle;" alt="Shops">&nbsp {{result.shop_name}}</p>
        </f7-block>
      </f7-card>
    </f7-link>
  </template>
  </div>
</f7-block>
    <f7-block style="background-color:white;padding:18px 16px 0px;margin:0px">
      <f7-row style="margin-bottom:1em">
        <f7-col style="height:14vh">
            <f7-link @click="sheetCheck1" style="height:100%"><img src="../assets/featurebanner3.png" style="width:100%;height:100%;border-radius:5px" alt="SUPER30 Promocode offer"></f7-link>
        </f7-col>
      </f7-row>
    </f7-block>
    <f7-block style="background-color:white;padding:0px;margin:0px">
     <div style="padding:16px 16px 22px 20px">
        <div style="display:inline-block;height:30px">
          <img src="../assets/shop_icon.png" style="width:30px;height:30px;border-radius:50%;vertical-align: middle;" alt="Shops">
        </div>
        <div style="font-weight:bold;color:#000000;font-size:18px;display:inline-block;vertical-align: middle;" class="mpzero">&nbsp Shops at {{city}}</div>
      <f7-link style="font-weight:bold;color:#1d2671;font-size:16px;margin-top:2px;float:right" class="mpzero" href="/shop/">See all</f7-link>
      </div>
    <div style="overflow-x:scroll;overflow-y:hidden;white-space:nowrap;padding:0px 0px 0px 8px;height:170px">
  <template v-for="(result,index) in trendingShops">
    <f7-link :key="index" href="/shophome/" style="width:162px;height:158px;margin:0px 8px" @click="saveshop1(result.name)">
      <div style="width:100%;height:100%;margin:0px;padding:0px;box-shadow:0px 1px 6px 0px rgba(0, 0, 0, 0.1);border-radius:5px">
        <div class="image_viewer" style="width:162px;height:120px">
          <img :src="result.image" style="width:100%;height:120px;margin:0px;border-radius:5px 5px 0px 0px">
        </div>
        <f7-block style="color:#000000;font-size:14px;font-weight:bold;padding:8px;margin:0px">
          <p class="mpzero lineclampin" style="text-transform: capitalize">{{result.name}}</p>
        </f7-block>
      </div>
    </f7-link>
  </template>
  </div>
</f7-block>
    <f7-block style="background-color:white;padding:14px 16px 0px;margin:0px">
      <f7-row style="margin-bottom:1em">
        <f7-col style="height:14vh">
            <f7-link @click="sheetCheck2" style="height:100%"><img src="../assets/featurebanner4.png" style="width:100%;height:100%;border-radius:5px" alt="Try and buy feature"></f7-link>
        </f7-col>
       </f7-row>
    </f7-block>
    <f7-block style="background-color:white;padding:0px 0px 8px;margin:0px">
      <div style="padding:16px 16px 22px 20px">
        <div style="display:inline-block;height:30px">
          <img src="../assets/man_icon.png" style="width:30px;height:30px;border-radius:50%;vertical-align: middle;" alt="Mens Clothing">
        </div>
        <div style="font-weight:bold;color:#000000;font-size:18px;display:inline-block;vertical-align: middle;" class="mpzero">&nbsp Mens Clothing</div>
        <f7-link style="font-weight:bold;color:#1d2671;font-size:16px;margin-top:2px;float:right" class="mpzero" href="/categorymen/">See all</f7-link>
      </div>
          <div style="overflow-x:scroll;overflow-y:hidden;white-space:nowrap;margin:0px">
  <f7-link @click="savebanner('Men','Top wear','T-Shirts',$f7router,'/products/')" href="javascript:void(0)" style="height:100%;padding:0px 8px 0px 16px"><f7-card style="height:124px;margin:0px;border-radius:8px" class="cat_width2"><img src="../assets/m_tshirt.png" style="width:100%;height:100%;border-radius:8px" alt=""></f7-card></f7-link>
  <f7-link @click="savebanner('Men','Top wear','Casual Shirts',$f7router,'/products/')" href="javascript:void(0)" style="height:100% ;padding:0px 8px"><f7-card style="height:124px;margin:0px;border-radius:8px" class="cat_width2"><img src="../assets/m_shirt.png" style="width:100%;height:100%;border-radius:8px" alt=""></f7-card></f7-link>
  <f7-link @click="savebanner('Men','Bottom wear','Jeans',$f7router,'/products/')" href="javascript:void(0)" style="height:100% ;padding:0px 8px"><f7-card style="height:124px;margin:0px;border-radius:8px" class="cat_width2"><img src="../assets/m_jean.png" style="width:100%;height:100%;border-radius:8px" alt=""></f7-card></f7-link>
  <f7-link @click="savebanner('Men','Innerwear and sleepwear','Briefs and trunks',$f7router,'/products/')" href="javascript:void(0)" style="height:100% ;padding:0px 8px"><f7-card style="height:124px;margin:0px;border-radius:8px" class="cat_width2"><img src="../assets/m_brief.png" style="width:100%;height:100%;border-radius:8px" alt=""></f7-card></f7-link>
  <f7-link @click="savebanner('Men','Bottom wear','Shorts and 3 by 4ths',$f7router,'/products/')" href="javascript:void(0)" style="height:100% ;padding:0px 16px 0px 8px"><f7-card style="height:124px;margin:0px;border-radius:8px" class="cat_width2"><img src="../assets/m_short.png" style="width:100%;height:100%;border-radius:8px" alt=""></f7-card></f7-link>
</div>
</f7-block>
    <f7-block style="background-color:white;padding:18px 16px 0px;margin:0px">
      <f7-row style="margin-bottom:1em">
        <f7-col style="height:14vh">
            <f7-link @click="sheetCheck" style="height:100%"><img src="../assets/cashback_featurebanner.png" style="width:100%;height:100%;border-radius:5px" alt="FS cashback"></f7-link>
        </f7-col>
       </f7-row>
    </f7-block>
<f7-block style="background-color:white;padding:0px;margin:0px">
     <div style="padding:16px 16px 22px 20px">
        <div style="display:inline-block;height:30px">
          <img src="../assets/innerwear_icon.png" style="width:30px;height:30px;border-radius:50%;vertical-align: middle;" alt="Mens innerwear">
        </div>
        <div style="font-weight:bold;color:#000000;font-size:18px;display:inline-block;vertical-align: middle;" class="mpzero">&nbsp Mens Innerwear</div>
      </div>
    <div style="overflow-x:scroll;overflow-y:hidden;white-space:nowrap;padding:0px 0px 0px 13px">
  <template v-for="(result,index) in mensInnerwear">
    <f7-link :key="index" :href="'/productdetails/' + result.id + '/' + result.name" style="width:162px;height:46vh;margin:0px 3px" @click="saveid(result.id)">
      <f7-card style="width:100%;height:100%;margin:0px;padding:0px;-webkit-box-shadow: none;box-shadow: none">
        <div class="image_viewer" style="width: 100%;height:34vh;">
          <img :src="result.image[0]" style="width:100%;height:100%;margin:0px;object-fit: contain">
        </div>
        <div style="position:absolute;top:10px;left:10px;z-index:99;background-color:#5ddcf9;border-radius:50%;color:#000000;width:46px;height:46px;opacity:0.9;text-align:center">
            <p style="font-size:20px;font-weight:bold;margin:6px 0px 0px;padding:0px;line-height:20px">{{discountInnerwear[index]}}</p>
            <p style="font-size:10px;font-weight:bold;margin:0px;padding:0px;line-height:12px">% OFF</p>
        </div>
        <f7-block style="color:gray;font-size:14px;font-weight:bold;padding:8px">
          <p class="mpzero lineclampin">
          <span style="color:#000000;font-size:17px">&#8377;{{result.selling_price}} </span>
          <span style="text-decoration:line-through;margin-left:3px">&#8377;{{result.mrp_price}}</span></p>
          <p class="mpzero lineclampin" style="margin-top:6px">
          <img src="../assets/shop_icon.png" style="width:24px;height:24px;border-radius:50%;vertical-align: middle;" alt="Shops">&nbsp {{result.shop_name}}</p>
        </f7-block>
      </f7-card>
    </f7-link>
  </template>
  </div>
</f7-block>
<f7-block style="background-color:white;padding:18px 0px 0px;margin:0px">
      <f7-row no-gap style="margin-bottom:1em">
        <f7-col style="height:30vh;padding:0px 2px 0px 0px">
            <f7-link @click="saveshop('MJ Collection','Shirts Under Rs.550',index,$f7router,'/offers1')" style="height:100%"><img src="../assets/featurebanner8.png" style="width:100%;height:100%" alt="Specific Want Order"></f7-link>
        </f7-col>
        <f7-col style="height:30vh;padding:0px 0px 0px 2px">
            <f7-link @click="saveshop('Style hub wear','T-Shirts Under Rs.299',index,$f7router,'/offers1')" style="height:100%"><img src="../assets/featurebanner9.png" style="width:100%;height:100%" alt="Specific Want Order"></f7-link>
        </f7-col>
       </f7-row>
    </f7-block>
    <!--<f7-block style="background-color:white;padding:0px 0px 8px;margin:0px">
      <div style="padding:16px 16px 22px 20px">
        <div style="display:inline-block;height:30px">
          <img src="../assets/woman_icon.png" style="width:30px;height:30px;border-radius:50%;vertical-align: middle;" alt="Womens Clothing">
        </div>
        <div style="font-weight:bold;color:#000000;font-size:18px;display:inline-block;vertical-align: middle;" class="mpzero">&nbsp Womens Clothing</div>
        <f7-link style="font-weight:bold;color:#1d2671;font-size:16px;margin-top:2px;float:right" class="mpzero" href="/categorywomen/">See all</f7-link>
      </div>
          <div style="overflow-x:scroll;overflow-y:hidden;white-space:nowrap;margin:0px">
  <f7-link @click="savebanner('Women','Western wear','Tops',$f7router,'/products/')" href="javascript:void(0)" style="height:100%;padding:0px 8px 0px 16px"><f7-card style="height:124px;margin:0px;border-radius:8px" class="cat_width2"><img src="../assets/w_top.png" style="width:100%;height:100%;border-radius:8px" alt=""></f7-card></f7-link>
  <f7-link @click="savebanner('Women','Western wear','Jeans',$f7router,'/products/')" href="javascript:void(0)" style="height:100% ;padding:0px 8px"><f7-card style="height:124px;margin:0px;border-radius:8px" class="cat_width2"><img src="../assets/w_jean.png" style="width:100%;height:100%;border-radius:8px" alt=""></f7-card></f7-link>
  <f7-link @click="savebanner('Women','Ethnic wear','Kurtis',$f7router,'/products/')" href="javascript:void(0)" style="height:100% ;padding:0px 8px"><f7-card style="height:124px;margin:0px;border-radius:8px" class="cat_width2"><img src="../assets/w_kurti.png" style="width:100%;height:100%;border-radius:8px" alt=""></f7-card></f7-link>
  <f7-link @click="savebanner('Women','Western wear','T-Shirts',$f7router,'/products/')" href="javascript:void(0)" style="height:100% ;padding:0px 8px"><f7-card style="height:124px;margin:0px;border-radius:8px" class="cat_width2"><img src="../assets/w_tshirt.png" style="width:100%;height:100%;border-radius:8px" alt=""></f7-card></f7-link>
  <f7-link @click="savebanner('Women','Ethnic wear','Leggings',$f7router,'/products/')" href="javascript:void(0)" style="height:100% ;padding:0px 16px 0px 8px"><f7-card style="height:124px;margin:0px;border-radius:8px" class="cat_width2"><img src="../assets/w_legging.png" style="width:100%;height:100%;border-radius:8px" alt=""></f7-card></f7-link>
</div>
</f7-block>
<f7-block style="background-color:white;padding:0px;margin:0px">
     <div style="padding:16px 16px 22px 20px">
        <div style="display:inline-block;height:30px">
          <img src="../assets/kurti_icon.png" style="width:30px;height:30px;border-radius:50%;vertical-align: middle;" alt="Womens Kurti">
        </div>
        <div style="font-weight:bold;color:#000000;font-size:18px;display:inline-block;vertical-align: middle;" class="mpzero">&nbsp Womens Kurtis</div>
      </div>
    <div style="overflow-x:scroll;overflow-y:hidden;white-space:nowrap;padding:0px 0px 0px 13px">
  <template v-for="(result,index) in womensKurtis">
    <f7-link :key="index" :href="'/productdetails/' + result.id + '/' + result.name" style="width:162px;height:46vh;margin:0px 3px" @click="saveid(result.id)">
      <f7-card style="width:100%;height:100%;margin:0px;padding:0px;-webkit-box-shadow: none;box-shadow: none">
        <div class="image_viewer" style="width: 100%;height:34vh;">
          <img :src="result.image[0]" style="width:100%;height:100%;margin:0px;object-fit: contain">
        </div>
        <div style="position:absolute;top:5px;right:10px;z-index:99;background-color:#5ddcf9;border-radius:50%;color:#000000;width:52px;height:52px;opacity:0.9;text-align:center">
            <p style="font-size:22px;font-weight:bold;margin:9px 0px 0px;padding:0px;line-height:20px">{{discountKurtis[index]}}</p>
            <p style="font-size:12px;font-weight:bold;margin:0px;padding:0px;line-height:12px">% OFF</p>
        </div>
        <f7-block style="color:gray;font-size:14px;font-weight:bold;padding:8px">
          <p class="mpzero lineclampin">
          <span style="color:#000000;font-size:17px">&#8377;{{result.selling_price}} </span>
          <span style="text-decoration:line-through;margin-left:3px">&#8377;{{result.mrp_price}}</span></p>
          <p class="mpzero lineclampin">
          <img src="../assets/shop_icon.png" style="width:24px;height:24px;border-radius:50%;vertical-align: middle;" alt="Shops">&nbsp {{result.shop_name}}</p>
        </f7-block>
      </f7-card>
    </f7-link>
  </template>
  </div>
</f7-block>-->
  <f7-block style="background-color:white;padding:0px 0px 8px;margin:0px">
      <div style="padding:16px 16px 22px 20px">
        <div style="display:inline-block;height:30px">
          <img src="../assets/footwear_icon.png" style="width:30px;height:30px;border-radius:50%;vertical-align: middle;" alt="Mens Footwear">
        </div>
        <div style="font-weight:bold;color:#000000;font-size:18px;display:inline-block;vertical-align: middle;" class="mpzero">&nbsp Mens Footwear</div>
        <f7-link style="font-weight:bold;color:#1d2671;font-size:16px;margin-top:2px;float:right" class="mpzero" href="/categoryfootwear/">See all</f7-link>
      </div>
          <div style="overflow-x:scroll;overflow-y:hidden;white-space:nowrap;margin:0px">
  <f7-link @click="savebanner('Footwear','Men footwear','Sandals',$f7router,'/products/')" href="javascript:void(0)" style="height:100% ;padding:0px 8px 0px 16px"><f7-card style="height:124px;margin:0px;border-radius:8px" class="cat_width2"><img src="../assets/m_sandals.png" style="width:100%;height:100%;border-radius:8px" alt=""></f7-card></f7-link>
  <f7-link @click="savebanner('Footwear','Men footwear','Chappals',$f7router,'/products/')" href="javascript:void(0)" style="height:100% ;padding:0px 8px"><f7-card style="height:124px;margin:0px;border-radius:8px" class="cat_width2"><img src="../assets/m_chapals.png" style="width:100%;height:100%;border-radius:8px" alt=""></f7-card></f7-link>
  <f7-link @click="savebanner('Footwear','Men footwear','Casual Shoes',$f7router,'/products/')" href="javascript:void(0)" style="height:100%;padding:0px 8px"><f7-card style="height:124px;margin:0px;border-radius:8px" class="cat_width2"><img src="../assets/m_casualshoes.png" style="width:100%;height:100%;border-radius:8px" alt=""></f7-card></f7-link>
  <f7-link @click="savebanner('Footwear','Men footwear','Loafers',$f7router,'/products/')" href="javascript:void(0)" style="height:100% ;padding:0px 8px"><f7-card style="height:124px;margin:0px;border-radius:8px" class="cat_width2"><img src="../assets/m_loafers.png" style="width:100%;height:100%;border-radius:8px" alt=""></f7-card></f7-link>
  <f7-link @click="savebanner('Footwear','Men footwear','Sport Shoes',$f7router,'/products/')" href="javascript:void(0)" style="height:100% ;padding:0px 16px 0px 8px"><f7-card style="height:124px;margin:0px;border-radius:8px" class="cat_width2"><img src="../assets/m_sportshoes.png" style="width:100%;height:100%;border-radius:8px" alt=""></f7-card></f7-link>
</div>
</f7-block>
<!--<f7-block style="background-color:white;padding:18px 16px 0px;margin:0px">
      <f7-row style="margin-bottom:1em">
        <f7-col style="height:14vh">
            <f7-link v-if="mobile!=null" href="/wallet" style="height:100%"><img src="../assets/featurebanner7.png" style="width:100%;height:100%;border-radius:5px" alt="User Feedback"></f7-link>
        </f7-col>
       </f7-row>
    </f7-block>-->
    <f7-block style="background-color:white;padding:18px 16px 0px;margin:0px">
      <f7-row style="margin-bottom:1em">
        <f7-col style="height:14vh">
            <f7-link href="/specificWant" style="height:100%"><img src="../assets/featurebanner1.png" style="width:100%;height:100%;border-radius:5px" alt="Specific Want Order"></f7-link>
        </f7-col>
       </f7-row>
    </f7-block>
<f7-block style="background-color:white;padding:0px;margin:0px">
     <div style="padding:16px 16px 22px 20px">
        <div style="display:inline-block;height:30px">
          <img src="../assets/casualshoes_icon.png" style="width:30px;height:30px;border-radius:50%;vertical-align: middle;" alt="Mens Casual Shoes">
        </div>
        <div style="font-weight:bold;color:#000000;font-size:18px;display:inline-block;vertical-align: middle;" class="mpzero">&nbsp Mens Casual Shoes</div>
      </div>
    <div style="overflow-x:scroll;overflow-y:hidden;white-space:nowrap;padding:0px 0px 0px 13px">
  <template v-for="(result,index) in mensCasualShoes">
    <f7-link :key="index" :href="'/productdetails/' + result.id + '/' + result.name" style="width:162px;height:46vh;margin:0px 3px" @click="saveid(result.id)">
      <f7-card style="width:100%;height:100%;margin:0px;padding:0px;-webkit-box-shadow: none;box-shadow: none">
        <div class="image_viewer" style="width: 100%;height:34vh;">
          <img :src="result.image[0]" style="width:100%;height:100%;margin:0px;object-fit: contain">
        </div>
        <div style="position:absolute;top:10px;left:10px;z-index:99;background-color:#5ddcf9;border-radius:50%;color:#000000;width:46px;height:46px;opacity:0.9;text-align:center">
            <p style="font-size:20px;font-weight:bold;margin:6px 0px 0px;padding:0px;line-height:20px">{{discountShoes[index]}}</p>
            <p style="font-size:10px;font-weight:bold;margin:0px;padding:0px;line-height:12px">% OFF</p>
        </div>
        <f7-block style="color:gray;font-size:14px;font-weight:bold;padding:8px">
          <p class="mpzero lineclampin">
          <span style="color:#000000;font-size:17px">&#8377;{{result.selling_price}} </span>
          <span style="text-decoration:line-through;margin-left:3px">&#8377;{{result.mrp_price}}</span></p>
          <p class="mpzero lineclampin" style="margin-top:6px">
          <img src="../assets/shop_icon.png" style="width:24px;height:24px;border-radius:50%;vertical-align: middle;" alt="Shops">&nbsp {{result.shop_name}}</p>
        </f7-block>
      </f7-card>
    </f7-link>
  </template>
  </div>
</f7-block>
<f7-block style="background-color:white;padding:18px 0px 0px;margin:0px">
      <f7-row no-gap style="margin-bottom:1em">
        <f7-col style="height:30vh;padding:0px 2px 0px 0px"">
            <f7-link @click="saveshop('Kingz','Shorts Under Rs.350',index,$f7router,'/offers1')"  style="height:100%"><img src="../assets/featurebanner10.png" style="width:100%;height:100%" alt="Specific Want Order"></f7-link>
        </f7-col>
        <f7-col style="height:30vh;padding:0px 0px 0px 2px"">
            <f7-link @click="saveshop('Shoe Park','Chappals Under Rs.210',index,$f7router,'/offers1')" style="height:100%"><img src="../assets/featurebanner11.png" style="width:100%;height:100%" alt="Specific Want Order"></f7-link>
        </f7-col>
       </f7-row>
    </f7-block>  
<f7-block style="background-color:white;padding:0px;margin:0px">
     <div style="padding:16px 16px 22px 20px">
        <div style="display:inline-block;height:30px">
          <img src="../assets/tshirt_icon.png" style="width:30px;height:30px;border-radius:50%;vertical-align: middle;" alt="Mens T-shirts">
        </div>
        <div style="font-weight:bold;color:#000000;font-size:18px;display:inline-block;vertical-align: middle;" class="mpzero">&nbsp Mens T-shirts</div>
        <f7-link style="font-weight:bold;color:#1d2671;font-size:16px;margin-top:2px;float:right" class="mpzero" @click="savebanner('Men','Top wear','T-Shirts',$f7router,'/products/')" href="javascript:void(0)">See all</f7-link>
      </div>
    <div style="overflow-x:scroll;overflow-y:hidden;white-space:nowrap;padding:0px 0px 0px 13px">
  <template v-for="(result,index) in mensTShirts">
    <f7-link :key="index" :href="'/productdetails/' + result.id + '/' + result.name" style="width:162px;height:46vh;margin:0px 3px" @click="saveid(result.id)">
      <f7-card style="width:100%;height:100%;margin:0px;padding:0px;-webkit-box-shadow: none;box-shadow: none">
        <div class="image_viewer" style="width: 100%;height:34vh;">
          <img :src="result.image[0]" style="width:100%;height:100%;margin:0px;object-fit: contain">
        </div>
        <div style="position:absolute;top:10px;left:10px;z-index:99;background-color:#5ddcf9;border-radius:50%;color:#000000;width:46px;height:46px;opacity:0.9;text-align:center">
            <p style="font-size:20px;font-weight:bold;margin:6px 0px 0px;padding:0px;line-height:20px">{{discountShoes[index]}}</p>
            <p style="font-size:10px;font-weight:bold;margin:0px;padding:0px;line-height:12px">% OFF</p>
        </div>
        <f7-block style="color:gray;font-size:14px;font-weight:bold;padding:8px">
          <p class="mpzero lineclampin">
          <span style="color:#000000;font-size:17px">&#8377;{{result.selling_price}} </span>
          <span style="text-decoration:line-through;margin-left:3px">&#8377;{{result.mrp_price}}</span></p>
          <p class="mpzero lineclampin" style="margin-top:6px">
          <img src="../assets/shop_icon.png" style="width:24px;height:24px;border-radius:50%;vertical-align: middle;" alt="Shops">&nbsp {{result.shop_name}}</p>
        </f7-block>
      </f7-card>
    </f7-link>
  </template>
  </div>
</f7-block>
    <f7-block style="background-color:white;padding:18px 16px 0px;margin:0px">
      <f7-row style="margin-bottom:1em">
        <f7-col style="height:14vh">
            <f7-link href="/ongoing/" style="height:100%"><img src="../assets/featurebanner2.png" style="width:100%;height:100%;border-radius:5px" alt="shop offers"></f7-link>
        </f7-col>
       </f7-row>
    </f7-block>
  <f7-block style="background-color:white;padding:0px;margin:0px">
     <div style="padding:16px 16px 22px 20px">
        <div style="display:inline-block;height:30px">
          <img src="../assets/sandal_icon.png" style="width:30px;height:30px;border-radius:50%;vertical-align: middle;" alt="Mens Sandals">
        </div>
        <div style="font-weight:bold;color:#000000;font-size:18px;display:inline-block;vertical-align: middle;" class="mpzero">&nbsp Mens Sandals</div>
        <f7-link style="font-weight:bold;color:#1d2671;font-size:16px;margin-top:2px;float:right" class="mpzero" @click="savebanner('Footwear','Men footwear','Sandals',$f7router,'/products/')" href="javascript:void(0)">See all</f7-link>
      </div>
    <div style="overflow-x:scroll;overflow-y:hidden;white-space:nowrap;padding:0px 0px 0px 13px">
  <template v-for="(result,index) in mensSandals">
    <f7-link :key="index" :href="'/productdetails/' + result.id + '/' + result.name" style="width:162px;height:46vh;margin:0px 3px" @click="saveid(result.id)">
      <f7-card style="width:100%;height:100%;margin:0px;padding:0px;-webkit-box-shadow: none;box-shadow: none">
        <div class="image_viewer" style="width: 100%;height:34vh;">
          <img :src="result.image[0]" style="width:100%;height:100%;margin:0px;object-fit: contain">
        </div>
        <div style="position:absolute;top:10px;left:10px;z-index:99;background-color:#5ddcf9;border-radius:50%;color:#000000;width:46px;height:46px;opacity:0.9;text-align:center">
            <p style="font-size:20px;font-weight:bold;margin:6px 0px 0px;padding:0px;line-height:20px">{{discountShoes[index]}}</p>
            <p style="font-size:10px;font-weight:bold;margin:0px;padding:0px;line-height:12px">% OFF</p>
        </div>
        <f7-block style="color:gray;font-size:14px;font-weight:bold;padding:8px">
          <p class="mpzero lineclampin">
          <span style="color:#000000;font-size:17px">&#8377;{{result.selling_price}} </span>
          <span style="text-decoration:line-through;margin-left:3px">&#8377;{{result.mrp_price}}</span></p>
          <p class="mpzero lineclampin" style="margin-top:6px">
          <img src="../assets/shop_icon.png" style="width:24px;height:24px;border-radius:50%;vertical-align: middle;" alt="Shops">&nbsp {{result.shop_name}}</p>
        </f7-block>
      </f7-card>
    </f7-link>
  </template>
  </div>
</f7-block>
    <f7-block style="background-color:white;padding:18px 16px 0px;margin:0px">
      <f7-row style="margin-bottom:1em">
        <f7-col style="height:14vh">
            <f7-link @click="save('deodorant')" href="/specificPage" style="height:100%"><img src="../assets/featurebanner5.png" style="width:100%;height:100%;border-radius:5px" alt="Deodorant"></f7-link>
        </f7-col>
       </f7-row>
    </f7-block>
  <f7-block style="background-color:white;padding:0px;margin:0px">
     <div style="padding:16px 16px 22px 20px">
        <div style="display:inline-block;height:30px">
          <img src="../assets/shirt_icon.png" style="width:30px;height:30px;border-radius:50%;vertical-align: middle;" alt="Mens Casual Shirt">
        </div>
        <div style="font-weight:bold;color:#000000;font-size:18px;display:inline-block;vertical-align: middle;" class="mpzero">&nbsp Mens Casual Shirts</div>
        <f7-link style="font-weight:bold;color:#1d2671;font-size:16px;margin-top:2px;float:right" class="mpzero" @click="savebanner('Men','Top wear','Casual Shirts',$f7router,'/products/')" href="javascript:void(0)">See all</f7-link>
      </div>
    <div style="overflow-x:scroll;overflow-y:hidden;white-space:nowrap;padding:0px 0px 0px 13px">
  <template v-for="(result,index) in mensShirts">
    <f7-link :key="index" :href="'/productdetails/' + result.id + '/' + result.name" style="width:162px;height:46vh;margin:0px 3px" @click="saveid(result.id)">
      <f7-card style="width:100%;height:100%;margin:0px;padding:0px;-webkit-box-shadow: none;box-shadow: none">
        <div class="image_viewer" style="width: 100%;height:34vh;">
          <img :src="result.image[0]" style="width:100%;height:100%;margin:0px;object-fit: contain">
        </div>
        <div style="position:absolute;top:10px;left:10px;z-index:99;background-color:#5ddcf9;border-radius:50%;color:#000000;width:46px;height:46px;opacity:0.9;text-align:center">
            <p style="font-size:20px;font-weight:bold;margin:6px 0px 0px;padding:0px;line-height:20px">{{discountShoes[index]}}</p>
            <p style="font-size:10px;font-weight:bold;margin:0px;padding:0px;line-height:12px">% OFF</p>
        </div>
        <f7-block style="color:gray;font-size:14px;font-weight:bold;padding:8px">
          <p class="mpzero lineclampin">
          <span style="color:#000000;font-size:17px">&#8377;{{result.selling_price}} </span>
          <span style="text-decoration:line-through;margin-left:3px">&#8377;{{result.mrp_price}}</span></p>
          <p class="mpzero lineclampin" style="margin-top:6px">
          <img src="../assets/shop_icon.png" style="width:24px;height:24px;border-radius:50%;vertical-align: middle;" alt="Shops">&nbsp {{result.shop_name}}</p>
        </f7-block>
      </f7-card>
    </f7-link>
  </template>
  </div>
</f7-block>
    <f7-block v-if="mobile!=null" style="background-color:white;padding:18px 16px 0px;margin:0px">
      <f7-row style="margin-bottom:1em">
        <f7-col style="height:14vh">
            <f7-link  href="/wallet" style="height:100%"><img src="../assets/featurebanner6.png" style="width:100%;height:100%;border-radius:5px" alt="FS Wallet"></f7-link>
        </f7-col>
       </f7-row>
    </f7-block> 
  <f7-block style="background-color:white;padding:0px;margin:0px">
     <div style="padding:16px 16px 22px 20px">
        <div style="display:inline-block;height:30px">
          <img src="../assets/chappal_icon.png" style="width:30px;height:30px;border-radius:50%;vertical-align: middle;" alt="Mens Chappals">
        </div>
        <div style="font-weight:bold;color:#000000;font-size:18px;display:inline-block;vertical-align: middle;" class="mpzero">&nbsp Mens Chappals</div>
        <f7-link style="font-weight:bold;color:#1d2671;font-size:16px;margin-top:2px;float:right" class="mpzero" @click="savebanner('Footwear','Men footwear','Chappals',$f7router,'/products/')" href="javascript:void(0)">See all</f7-link>
      </div>
    <div style="overflow-x:scroll;overflow-y:hidden;white-space:nowrap;padding:0px 0px 0px 13px">
  <template v-for="(result,index) in mensChappals">
    <f7-link :key="index" :href="'/productdetails/' + result.id + '/' + result.name" style="width:162px;height:46vh;margin:0px 3px" @click="saveid(result.id)">
      <f7-card style="width:100%;height:100%;margin:0px;padding:0px;-webkit-box-shadow: none;box-shadow: none">
        <div class="image_viewer" style="width: 100%;height:34vh;">
          <img :src="result.image[0]" style="width:100%;height:100%;margin:0px;object-fit: contain">
        </div>
        <div style="position:absolute;top:10px;left:10px;z-index:99;background-color:#5ddcf9;border-radius:50%;color:#000000;width:46px;height:46px;opacity:0.9;text-align:center">
            <p style="font-size:20px;font-weight:bold;margin:6px 0px 0px;padding:0px;line-height:20px">{{discountShoes[index]}}</p>
            <p style="font-size:10px;font-weight:bold;margin:0px;padding:0px;line-height:12px">% OFF</p>
        </div>
        <f7-block style="color:gray;font-size:14px;font-weight:bold;padding:8px">
          <p class="mpzero lineclampin">
          <span style="color:#000000;font-size:17px">&#8377;{{result.selling_price}} </span>
          <span style="text-decoration:line-through;margin-left:3px">&#8377;{{result.mrp_price}}</span></p>
          <p class="mpzero lineclampin" style="margin-top:6px">
          <img src="../assets/shop_icon.png" style="width:24px;height:24px;border-radius:50%;vertical-align: middle;" alt="Shops">&nbsp {{result.shop_name}}</p>
        </f7-block>
      </f7-card>
    </f7-link>
  </template>
  </div>
</f7-block>
<f7-block style="background-color:white;padding:18px 16px 0px;margin:0px">
      <f7-row style="margin-bottom:1em">
        <f7-col style="height:14vh">
            <f7-link @click="openFeedback" style="height:100%"><img src="../assets/featurebanner7.png" style="width:100%;height:100%;border-radius:5px" alt="User Feedback"></f7-link>
        </f7-col>
       </f7-row>
    </f7-block>
  <f7-block style="background-color:white;padding:0px;margin:0px">
     <div style="padding:16px 16px 22px 20px">
        <div style="display:inline-block;height:30px">
          <img src="../assets/jean_icon.png" style="width:30px;height:30px;border-radius:50%;vertical-align: middle;" alt="Mens Jeans">
        </div>
        <div style="font-weight:bold;color:#000000;font-size:18px;display:inline-block;vertical-align: middle;" class="mpzero">&nbsp Mens Jeans</div>
        <f7-link style="font-weight:bold;color:#1d2671;font-size:16px;margin-top:2px;float:right" class="mpzero" @click="savebanner('Men','Bottom wear','Jeans',$f7router,'/products/')" href="javascript:void(0)">See all</f7-link>
      </div>
    <div style="overflow-x:scroll;overflow-y:hidden;white-space:nowrap;padding:0px 0px 0px 13px">
  <template v-for="(result,index) in mensJeans">
    <f7-link :key="index" :href="'/productdetails/' + result.id + '/' + result.name" style="width:162px;height:46vh;margin:0px 3px" @click="saveid(result.id)">
      <f7-card style="width:100%;height:100%;margin:0px;padding:0px;-webkit-box-shadow: none;box-shadow: none">
        <div class="image_viewer" style="width: 100%;height:34vh;">
          <img :src="result.image[0]" style="width:100%;height:100%;margin:0px;object-fit: contain">
        </div>
        <div style="position:absolute;top:10px;left:10px;z-index:99;background-color:#5ddcf9;border-radius:50%;color:#000000;width:46px;height:46px;opacity:0.9;text-align:center">
            <p style="font-size:20px;font-weight:bold;margin:6px 0px 0px;padding:0px;line-height:20px">{{discountShoes[index]}}</p>
            <p style="font-size:10px;font-weight:bold;margin:0px;padding:0px;line-height:12px">% OFF</p>
        </div>
        <f7-block style="color:gray;font-size:14px;font-weight:bold;padding:8px">
          <p class="mpzero lineclampin">
          <span style="color:#000000;font-size:17px">&#8377;{{result.selling_price}} </span>
          <span style="text-decoration:line-through;margin-left:3px">&#8377;{{result.mrp_price}}</span></p>
          <p class="mpzero lineclampin" style="margin-top:6px">
          <img src="../assets/shop_icon.png" style="width:24px;height:24px;border-radius:50%;vertical-align: middle;" alt="Shops">&nbsp {{result.shop_name}}</p>
        </f7-block>
      </f7-card>
    </f7-link>
  </template>
  </div>
</f7-block>
           <!--<f7-block style="background-color:white;padding:5px 10px 25px 10px;margin:0px 0px 8px">
           <div style="height:10px;border-bottom: 1px solid #BDBDBD; text-align: center;margin:10px 34px 35px 34px">
          <span class="mpzero" style="text-transform:uppercase;font-size:12px;font-weight:bold;background-color: #FFFFFF;padding:0px 10px">WATCHES - <span style="color:#00E676">LAUNCHING SOON</span></span>
          </div>
      <f7-swiper pagination :params="{speed:500,loop:true, slidesPerView: 1, autoplay: { delay: 2000, disableOnInteraction:false }}">
  <f7-swiper-slide><f7-card style="height:50vh"><img src="../assets/wtmb1.png" style="width:100%;height:100%" alt=""></f7-card></f7-swiper-slide>
  <f7-swiper-slide><f7-card style="height:50vh"><img src="../assets/wtmb2.png" style="width:100%;height:100%" alt=""></f7-card></f7-swiper-slide>
  <f7-swiper-slide><f7-card style="height:50vh"><img src="../assets/wtmb3.png" style="width:100%;height:100%" alt=""></f7-card></f7-swiper-slide>
    <f7-swiper-slide><f7-card style="height:50vh"><img src="../assets/wtmb4.png" style="width:100%;height:100%" alt=""></f7-card></f7-swiper-slide>
</f7-swiper>
    </f7-block>

      <f7-block style="background-color:white;padding:5px 0px 25px 0px;margin:0px 0px 8px">
      <div style="height:10px;border-bottom: 1px solid #BDBDBD; text-align: center;margin:10px 87px 42px 87px">
          <span class="mpzero" style="text-transform:uppercase;font-size:12px;font-weight:bold;background-color: #FFFFFF;padding:0px 10px">KIDS CLOTHING</span>
          </div>
          <div style="overflow-x:scroll;overflow-y:hidden;white-space:nowrap;margin:5px 0px">
  <f7-link @click="savebanner('Baby and Kids','Boys Clothing','T-Shirts',$f7router,'/products/')" href="javascript:void(0)" style="height:100%;padding:0px 13px 0px 20px"><f7-card style="height:124px;margin:0px;border-radius:20px" class="cat_width2"><img src="../assets/k_tshirt.png" style="width:100%;height:100%;border-radius:20px" alt=""></f7-card></f7-link>
  <f7-link @click="savebanner('Baby and Kids','Boys Clothing','Casual Shirts',$f7router,'/products/')" href="javascript:void(0)" style="height:100% ;padding:0px 13px"><f7-card style="height:124px;margin:0px;border-radius:20px" class="cat_width2"><img src="../assets/k_shirt.png" style="width:100%;height:100%;border-radius:20px" alt=""></f7-card></f7-link>
  <f7-link @click="savebanner('Baby and Kids','Boys Clothing','Jeans',$f7router,'/products/')" href="javascript:void(0)" style="height:100% ;padding:0px 13px"><f7-card style="height:124px;margin:0px;border-radius:20px" class="cat_width2"><img src="../assets/k_jean.png" style="width:100%;height:100%;border-radius:20px" alt=""></f7-card></f7-link>
  <f7-link @click="savebanner('Baby and Kids','Girls Clothing','Frocks',$f7router,'/products/')" href="javascript:void(0)" style="height:100% ;padding:0px 13px"><f7-card style="height:124px;margin:0px;border-radius:20px" class="cat_width2"><img src="../assets/k_frock.png" style="width:100%;height:100%;border-radius:20px" alt=""></f7-card></f7-link>
  <f7-link @click="savebanner('Baby and Kids','Boys Clothing','Shorts and 3 by 4ths',$f7router,'/products/')" href="javascript:void(0)" style="height:100% ;padding:0px 13px"><f7-card style="height:124px;margin:0px;border-radius:20px" class="cat_width2"><img src="../assets/k_short.png" style="width:100%;height:100%;border-radius:20px" alt=""></f7-card></f7-link>
</div>
</f7-block>-->
    </div>
    <f7-sheet ref="sizesheet1" class="sizesheet1" style="height:auto;text-align:center">
      <h4 style="font-weight:bold;color:#000000;font-size:18px;text-align:left;padding:16px" class="mpzero">FS Cashback offer</h4>
      <div style="margin:4px 16px 20px 16px;box-shadow:0px 1px 6px 0px rgba(0, 0, 0, 0.1);border-radius:4px">
          <f7-card style="padding-bottom:2px;width:100%;-webkit-box-shadow: none;box-shadow: none;border-radius:4px">
          <f7-row no-gap style="padding:8px">
           <f7-col width="25" style="padding-top:4px;text-align:center">
             <img src="../assets/scooter.svg" alt="">
           </f7-col>
           <f7-col width="75" style="padding-left:10px">
             <h4 style="font-weight:bold;color:#000000;font-size:16px;text-align:left" class="mpzero">Order Home Delivery & Get 5% Cashback</h4>
             <h5 style="color:#595959;font-size:13px;text-align:left;margin:0px">Place home delivery from Fashiostreet & get cashback</h5>
           </f7-col>
          </f7-row>
        </f7-card>
      </div>
      <span style="font-size:28px;font-weight:800;border: 1px solid #000000;border-radius:5px;padding:5px 10px;color:#595959">OR</span>
      <div style="margin:16px;margin-top:20px;box-shadow:0px 1px 6px 0px rgba(0, 0, 0, 0.1);border-radius:4px">
        <f7-card style="padding-bottom:2px;width:100%;-webkit-box-shadow: none;box-shadow: none;border-radius:4px">
          <f7-row no-gap style="padding:8px">
           <f7-col width="25" style="padding-top:4px;text-align:center">
             <img src="../assets/store.svg" alt="">
             <p style="font-size:12px;margin:0px;color:green">Coming Soon</p>
           </f7-col>
           <f7-col width="75" style="padding-left:10px">
             <h4 style="font-weight:bold;color:#000000;font-size:16px;text-align:left" class="mpzero">Get 7% Cashback On Bill Amount During Shop Visit</h4>
             <h5 style="color:#595959;font-size:13px;text-align:left;margin:0px">Just scan FS QR Code from shop to get cashback on bill amount</h5>
           </f7-col>
          </f7-row>
        </f7-card>
      </div>
      <div style="margin:16px;margin-top:20px;box-shadow:0px 1px 6px 0px rgba(0, 0, 0, 0.1);border-radius:4px">
        <f7-card style="padding-bottom:2px;width:100%;-webkit-box-shadow: none;box-shadow: none;border-radius:4px">
          <f7-row no-gap style="padding:8px;color:green">
           <f7-col width="10" style="padding-top:4px">
             <f7-icon f7="info"></f7-icon>
           </f7-col>
           <f7-col width="90" style="padding-left:10px">
             <h5 style="font-size:14px;text-align:left;margin:0px">Cashback will be added to your wallet & you can use your wallet money for next shopping.</h5>
           </f7-col>
          </f7-row>
        </f7-card>
      </div>
      <f7-button @click="sheetClose" fill big style="background-image: linear-gradient(to right, #1d2671, #dc5496);color:#00FF96;font-size:18px;font-weight:bold;border:0px;margin:10px;margin-top:20px;text-transform:capitalize">Got It &nbsp👍</f7-button>
    </f7-sheet>
    <f7-sheet ref="sizesheet2" class="sizesheet2" style="height:auto">
      <h4 style="font-weight:bold;color:#000000;font-size:18px;text-align:left;padding:16px" class="mpzero">😍 SUPER30 Promocode offer</h4>
      <div style="margin:4px 16px;margin-bottom:0px"><img src="../assets/featurebanner3.png" style="width:100%;height:90px;border-radius:5px" alt="SUPER30 Offer"></div>
      <p style="color:#323232;font-size:15px;font-weight:bold;margin:0px;padding:16px 16px 0px;text-align:left">🛍️ Apply Promocode - SUPER30 in Hd cart to Get Flat 30% OFF on First 2 orders(Upto &#8377;50)<br>[ONLY FOR FIRST 200 ORDERS FROM KOLHAPUR]</p>
      <f7-button fill big @click="sheetClose1" style="background-image: linear-gradient(to right, #1d2671, #dc5496);color:#00FF96;font-size:18px;font-weight:bold;border:0px;margin:10px;margin-top:20px;text-transform:capitalize">Got It &nbsp👍</f7-button>
    </f7-sheet>
    <f7-sheet ref="sizesheet3" class="sizesheet3" style="height:auto">
          <h4 style="font-weight:bold;color:#000000;font-size:18px;text-align:left;padding:16px" class="mpzero">🤔 What is TRY & BUY?</h4>
          <div style="margin:0px 16px;margin-bottom:0px"><img src="../assets/tryandbuy.png" style="width:100%;height:50vh;border-radius:5px" alt="try and buy"></div>
      <div style="margin:5px 16px;box-shadow:0px 1px 6px 0px rgba(0, 0, 0, 0.1);border-radius:4px">
        <f7-card style="padding-bottom:2px;width:100%;-webkit-box-shadow: none;box-shadow: none;border-radius:4px">
          <f7-row no-gap style="padding:10px;color:green">
           <f7-col width="10" style="padding-top:4px">
             <f7-icon f7="info"></f7-icon>
           </f7-col>
           <f7-col width="90">
             <h5 style="font-size:14px;text-align:left;margin:0px">You have to select atleast 2 & max 3 items of same shop for TRY.</h5>
           </f7-col>
          </f7-row>
          <f7-row no-gap style="padding:5px 10px 10px;color:green">
           <f7-col width="10" style="padding-top:4px">
             <f7-icon f7="info"></f7-icon>
           </f7-col>
           <f7-col width="90">
             <h5 style="font-size:14px;text-align:left;margin:0px">Their is no restriction on buying. You can return all items if you don't like.</h5>
           </f7-col>
          </f7-row>
        </f7-card>
      </div>
      <f7-button @click="sheetClose2" fill big style="background-image: linear-gradient(to right, #1d2671, #dc5496);color:#00FF96;font-size:18px;font-weight:bold;border:0px;margin:10px;margin-top:20px;text-transform:capitalize">Got It &nbsp👍</f7-button>
    </f7-sheet>
    </div>
    <f7-sheet ref="sizesheet4" style="height:auto">
          <f7-block-title style="margin:0px;padding:15px 15px 5px 15px;font-size:16px;font-weight:bold;line-height:20px;color:#000000">Please give your valuable feedback</f7-block-title>
          <f7-block style="margin:0px;padding:0px">
            <f7-list form no-hairlines-md style="margin:0px;color:#000000">
            <f7-list-item>
                <h5 style="color:red;text-transform:uppercase;margin:0px">{{feedbackerror}}</h5>
                <f7-label floating>Start writing ...</f7-label>
                <f7-input type="textarea" @input="feedback = $event.target.value" clear-button></f7-input>
            </f7-list-item>
            </f7-list>
            <p style="margin:0px;padding:8px 15px 5px 15px;font-size:14px">Thank you in advance to help us improve.</p>
            <f7-button @click="closeFeedback" fill big  style="background-image: linear-gradient(to right, #1d2671, #dc5496);color:#00FF96;font-size:18px;font-weight:bold;border:0px;margin:10px;margin-top:20px;text-transform:capitalize">Submit <f7-icon f7="chevron_right" style="margin:-5px 0px 0px 10px"></f7-icon></f7-button>
          </f7-block>
    </f7-sheet>
  </f7-page>
</template>
<script>


import axios from '../axios';
import Vue from 'vue';
import offline from 'v-offline';
 //import OTPAutoVerification from 'cordova-plugin-otp-auto-verification';
import { f7Navbar, f7Page, f7Block, f7Button } from 'framework7-vue';

export default {

  name: 'Home',
  data() {
    return {
      title: 'Hello World',
      popupOpened: false,
      trending:[],
      slogans: ['FREE HOME DELIVERY UPTO 12 KM','CASH ON DELIVERY UPTO 12 KM','SHOPPING FROM ALL SHOPS'],
      slogan: 'Free Home Delivery Upto 12 Km',
      shops:[],
      cartinfo:[],
      images:[],
      internet:null,
      city:null,
      showPreloader:true,
      status:'notshown',
      preloader:false,
      toast_msg:null,
      orders:[],
      page:1,
      mobile:null,
      otp:null,
      otpSend:null,
      mobileCheck:false,
      otpCheck:false,
      btn_text:'Get OTP',
      mobileError:null,
      showPreloader:true,
      allowInfinite:true,
      loadMoreData:[],
      error : false,
      feedback:null,
      feedbackerror:null,
      s1:true,
      s2:false,
      s3:false,
      sheet:false,
      userStatus:null,
      trendingShops:[],
      mensInnerwear:[],
      mensJeans:[],
      mensTShirts:[],
      mensShirts:[],
      womensKurtis:[],
      mensCasualShoes:[],
      mensChappals:[],
      mensSandals:[],
      discountTrending:[],
      discountInnerwear:[],
      discountKurtis:[],
      discountShoes:[],
      discountTShirts:[],
      discountShirts:[],
      discountJeans:[],
      discountChappals:[],
      discountSandals:[],
      loginmobile:localStorage.getItem('loginmobile'),
      AppLoader:false,
    };
  },
   created(){

     this.getCart();
    
    setInterval(() => {

     this.openPopup();

  }, 330000)
    setInterval(() => {

     this.activate1();
     //alert(this.slogan);
  }, 1800)
 }
  ,
  mounted()
  {
    //this.activate();
        this.mobile = localStorage.getItem('loginmobile');

    this.city=localStorage.getItem("city");
    this.showPreloader = true;
    this.getTrendingShops();
    this.getMensTShirts();
    this.getMensShirts();
    this.getMensJeans();
    this.getMensSandals();
    this.getMensChappals();
    this.getMensInnerwear();
    this.getMensCasualShoes();
    axios({
      method:'GET',
        url : '/product/' + this.city +'/city_offer/json?shop=All%20Shop'
      }).then(response => {
        this.showPreloader = false;
        this.trending=response.data.result.products;
        for(var i = 0;i< this.trending.length; i++)
        {
          this.trending[i].mrp_price = parseInt(this.trending[i].mrp_price);
        }
        for(var i = 0;i< this.trending.length; i++)
        {
          this.trending[i].selling_price = parseInt(this.trending[i].selling_price);
        }
        for(var i = 0;i< this.trending.length; i++)
        {
          this.discountTrending[i] = parseInt(((this.trending[i].mrp_price-this.trending[i].selling_price)/this.trending[i].mrp_price)*100);
        }
        this.shops = response.data.result.shops;
        this.images = response.data.result.images;
        console.log(this.images);
      },(error) => {
          alert('failed to load home page,please restart your app');
      });
  },
components: {
    offline
  },
  methods:{
    openFeedback()
    {
      this.$refs.sizesheet4.open();
    },
    closeFeedback()
    {
      if(this.feedback==null || this.feedback=='')
      {
        this.feedbackerror = 'Please Enter Feedback';
      }
      else
      {
        axios({
          method: 'POST',
                    url: 'feedback',
                    data: {mobile: localStorage.getItem('loginmobile'), feedback:this.feedback}
                }).then(response => {

                        this.$refs.sizesheet4.close();
                        const self = this;
          self.notificationWithButton = self.$f7.notification.create({
            icon: '',
            title: '',
            cssClass:'color1',
            subtitle: 'Feedback send successfully',
            text: ''
          });
          self.notificationWithButton.open();
            setTimeout(()=>{
              this.closepop();
            },2000);

                },(error) => {
                  if (error.response.data.message != undefined)
                  {
                    this.mobileError = error.response.data.message;
                  }
                  else
                  {
                    alert('connection error found,please retry again');
                  }
                  localStorage.setItem('mobile', this.mobile);
                });
      }

    },
    login(){
      if(this.btn_text=='Get OTP')
      {
        if(this.mobile==null || this.mobile=='' || this.mobile.length!=10)
        {
          this.mobileError = 'Enter valid phone number';
        }
        else
        {
          this.btn_text = 'Get Started';
          this.mobileCheck = true;
          this.mobileError = null;
          axios({
              method: 'POST',
              url: 'api/auth/sendOtp',
              data: {mobile: this.mobile}
            }).then(response => {
              this.userStatus = response.data.result;
              if(this.userStatus==null)
              {
                this.userStatus = 'User not found';
              }
              console.log(this.userStatus);
              this.otpSend = 'OTP sent to your mobile number';
            }, (error) => {
              if (error.response.data.message != undefined) {
                this.mobileError = error.response.data.message;
              }
              else {
                alert('connection error found,please retry again');
              }
            }
          );
        }
      }
      else
      {
        this.AppLoader = true;
        if(this.otp==null || this.otp=='' || this.otp.length!=4)
        {
          this.AppLoader = false;
          this.mobileError = 'Enter valid otp';
        }
        else{
          if(this.userStatus=='User found')
          {
            axios({
                method: 'POST',
                url: 'api/auth/completeForgetpassword_resendOTP',
                data: {mobile: this.mobile}
              }).then(response => {
                  axios({
                    method: 'POST',
                    url: 'api/auth/completeForgetpassword1',
                    data: {mobile: this.mobile, code: this.otp, password: 'fgvh'}
                }).then(response => {
                  console.log(response);
                  axios({
                    method : 'GET',
                    url : 'api/auth/getToken/'+this.mobile
                  }).then(response => {
                    this.AppLoader = false;
                    console.log(response);
                    localStorage.setItem('loginmobile', this.mobile);
                    localStorage.setItem('token', response.data.result);
                    localStorage.setItem('local_id', response.data.result);
                    location.reload();
                  },(error) => {
                      this.AppLoader = false;
                      alert('Please retry');
                  });
                },(error) => {
                  this.AppLoader = false;
                  if (error.response.data.message != undefined)
                  {
                    this.mobileError = error.response.data.message;
                  }
                  else
                  {
                    alert('connection error found,please retry again');
                  }
                });
              },(error) => {
                if (error.response.data.message != undefined) {
                  this.mobileError = error.response.data.message;
                }
                else {
                  alert('connection error found,please retry again');
                }
              }
            );
          }
          else
          {
            axios({
              method: 'POST',
              url: 'api/auth/completeRegister',
              data: {mobile: this.mobile, code: this.otp}
            }).then(response => {
                axios({
                    method: 'POST',
                    url: 'api/auth/login1',
                    data: {mobile: this.mobile, password: '123456'}
                }).then(response => {
                  console.log(response);
                  location.reload();
                  localStorage.setItem('loginmobile', this.mobile);
                  localStorage.setItem('token', response.data.result.token);
                  localStorage.setItem('local_id', response.data.result.local_id);
                  this.loginmobile = localStorage.getItem('loginmobile');
                },(error) => {
                  if (error.response.data.message != undefined)
                  {
                    this.mobileError = error.response.data.message;
                  }
                  else
                  {
                    alert('connection error found,please retry again');
                  }
                  localStorage.setItem('mobile', this.mobile);
                });
            }, (error) => {
              if (error.response.data.message != undefined) {
                this.mobileError = error.response.data.message;
              }
              else {
                alert('connection error found,please retry again');
              }
            });
          }
        }
      }
    },
    changeNumber()
    {
      this.btn_text = 'Get OTP';
      this.mobileCheck = false;
      this.otp = null;
    },
    resendOtp()
    {
      this.otpSend = 'OTP resent to your mobile number';
      this.otp = null;
      axios({
              method: 'POST',
              url: 'api/auth/completeForgetpassword_resendOTP',
              data: {mobile: this.mobile}
            }).then(response => {
             
            }, (error) => {
              if (error.response.data.message != undefined) {
                this.mobileError = error.response.data.message;
              }
              else {
                alert('connection error found,please retry again');
              }
            });
    },
    getTrendingShops()
    {
      axios({
        method:'GET',
        url : '/shop/'+this.city+'/trending'
      }).then(response => {
        this.trendingShops = response.data.result; 
        console.log(this.trendingShops); 
      },(error) => {
        alert(error.response.data.message);
      });
    },
    getMensInnerwear()
    {
      axios({
        method:'GET',
        url : '/trendingInnerwear/'+this.city
      }).then(response => {
        this.mensInnerwear = response.data.result;
        for(var i = 0;i< this.mensInnerwear.length; i++)
        {
          this.mensInnerwear[i].mrp_price = parseInt(this.mensInnerwear[i].mrp_price);
        }
        for(var i = 0;i< this.mensInnerwear.length; i++)
        {
          this.mensInnerwear[i].selling_price = parseInt(this.mensInnerwear[i].selling_price);
        }
        for(var i = 0;i< this.mensInnerwear.length; i++)
        {
          this.discountInnerwear[i] = parseInt(((this.mensInnerwear[i].mrp_price-this.mensInnerwear[i].selling_price)/this.mensInnerwear[i].mrp_price)*100);
        } 
        console.log(this.mensInnerwear); 
      },(error) => {
        alert(error.response.data.message);
      });
    },
    getMensTShirts()
    {
      axios({
        method:'GET',
        url : '/trendingTShirts/'+this.city
      }).then(response => {
        this.mensTShirts = response.data.result;
        for(var i = 0;i< this.mensTShirts.length; i++)
        {
          this.mensTShirts[i].mrp_price = parseInt(this.mensTShirts[i].mrp_price);
        }
        for(var i = 0;i< this.mensTShirts.length; i++)
        {
          this.mensTShirts[i].selling_price = parseInt(this.mensTShirts[i].selling_price);
        }
        for(var i = 0;i< this.mensTShirts.length; i++)
        {
          this.discountTShirts[i] = parseInt(((this.mensTShirts[i].mrp_price-this.mensTShirts[i].selling_price)/this.mensTShirts[i].mrp_price)*100);
        } 
        console.log(this.mensTShirts); 
      },(error) => {
        alert(error.response.data.message);
      });
    },
    getMensShirts()
    {
      axios({
        method:'GET',
        url : '/trendingShirts/'+this.city
      }).then(response => {
        this.mensShirts = response.data.result;
        for(var i = 0;i< this.mensShirts.length; i++)
        {
          this.mensShirts[i].mrp_price = parseInt(this.mensShirts[i].mrp_price);
        }
        for(var i = 0;i< this.mensShirts.length; i++)
        {
          this.mensShirts[i].selling_price = parseInt(this.mensShirts[i].selling_price);
        }
        for(var i = 0;i< this.mensShirts.length; i++)
        {
          this.discountShirts[i] = parseInt(((this.mensShirts[i].mrp_price-this.mensShirts[i].selling_price)/this.mensShirts[i].mrp_price)*100);
        } 
        console.log(this.mensShirts); 
      },(error) => {
        alert(error.response.data.message);
      });
    },
    getMensJeans()
    {
      axios({
        method:'GET',
        url : '/trendingJeans/'+this.city
      }).then(response => {
        this.mensJeans = response.data.result;
        for(var i = 0;i< this.mensJeans.length; i++)
        {
          this.mensJeans[i].mrp_price = parseInt(this.mensJeans[i].mrp_price);
        }
        for(var i = 0;i< this.mensJeans.length; i++)
        {
          this.mensJeans[i].selling_price = parseInt(this.mensJeans[i].selling_price);
        }
        for(var i = 0;i< this.mensJeans.length; i++)
        {
          this.discountJeans[i] = parseInt(((this.mensJeans[i].mrp_price-this.mensJeans[i].selling_price)/this.mensJeans[i].mrp_price)*100);
        } 
        console.log(this.mensJeans); 
      },(error) => {
        alert(error.response.data.message);
      });
    },
    getMensChappals()
    {
      axios({
        method:'GET',
        url : '/trendingChappals/'+this.city
      }).then(response => {
        this.mensChappals = response.data.result;
        for(var i = 0;i< this.mensChappals.length; i++)
        {
          this.mensChappals[i].mrp_price = parseInt(this.mensChappals[i].mrp_price);
        }
        for(var i = 0;i< this.mensChappals.length; i++)
        {
          this.mensChappals[i].selling_price = parseInt(this.mensChappals[i].selling_price);
        }
        for(var i = 0;i< this.mensChappals.length; i++)
        {
          this.discountChappals[i] = parseInt(((this.mensChappals[i].mrp_price-this.mensChappals[i].selling_price)/this.mensChappals[i].mrp_price)*100);
        } 
        console.log(this.mensChappals); 
      },(error) => {
        alert(error.response.data.message);
      });
    },
    getMensSandals()
    {
      axios({
        method:'GET',
        url : '/trendingSandals/'+this.city
      }).then(response => {
        this.mensSandals = response.data.result;
        for(var i = 0;i< this.mensSandals.length; i++)
        {
          this.mensSandals[i].mrp_price = parseInt(this.mensSandals[i].mrp_price);
        }
        for(var i = 0;i< this.mensSandals.length; i++)
        {
          this.mensSandals[i].selling_price = parseInt(this.mensSandals[i].selling_price);
        }
        for(var i = 0;i< this.mensSandals.length; i++)
        {
          this.discountSandals[i] = parseInt(((this.mensSandals[i].mrp_price-this.mensSandals[i].selling_price)/this.mensSandals[i].mrp_price)*100);
        } 
        console.log(this.mensSandals); 
      },(error) => {
        alert(error.response.data.message);
      });
    },
    getWomensKurtis()
    {
      axios({
        method:'GET',
        url : '/trendingKurtis/'+this.city
      }).then(response => {
        this.womensKurtis = response.data.result; 
        for(var i = 0;i< this.womensKurtis.length; i++)
        {
          this.womensKurtis[i].mrp_price = parseInt(this.womensKurtis[i].mrp_price);
        }
        for(var i = 0;i< this.womensKurtis.length; i++)
        {
          this.womensKurtis[i].selling_price = parseInt(this.womensKurtis[i].selling_price);
        }
        for(var i = 0;i< this.womensKurtis.length; i++)
        {
          this.discountKurtis[i] = parseInt(((this.womensKurtis[i].mrp_price-this.womensKurtis[i].selling_price)/this.womensKurtis[i].mrp_price)*100);
        }
        console.log(this.womensKurtis); 
      },(error) => {
        alert(error.response.data.message);
      });
    },
    getMensCasualShoes()
    {
      axios({
        method:'GET',
        url : '/trendingCasualShoes/'+this.city
      }).then(response => {
        this.mensCasualShoes = response.data.result; 
        for(var i = 0;i< this.mensCasualShoes.length; i++)
        {
          this.mensCasualShoes[i].mrp_price = parseInt(this.mensCasualShoes[i].mrp_price);
        }
        for(var i = 0;i< this.mensCasualShoes.length; i++)
        {
          this.mensCasualShoes[i].selling_price = parseInt(this.mensCasualShoes[i].selling_price);
        }
        for(var i = 0;i< this.mensCasualShoes.length; i++)
        {
          this.discountShoes[i] = parseInt(((this.mensCasualShoes[i].mrp_price-this.mensCasualShoes[i].selling_price)/this.mensCasualShoes[i].mrp_price)*100);
        }
        console.log(this.mensCasualShoes); 
      },(error) => {
        alert(error.response.data.message);
      });
    },
    save(value){
      localStorage.setItem('specific',value);
    },
    sheetCheck()
    {
      this.$refs.sizesheet1.open();
    },
    sheetClose()
    {
      this.$refs.sizesheet1.close();
    },
    sheetCheck1()
    {
      this.$refs.sizesheet2.open();
    },
    sheetClose1()
    {
      this.$refs.sizesheet2.close();
    },
    sheetCheck2()
    {
      this.$refs.sizesheet3.open();
    },
    sheetClose2()
    {
      this.$refs.sizesheet3.close();
    },
    saveshop1:function(sname)
    {
      localStorage.setItem("sname",sname);
    },
    activate1(){
      if(this.s1==true)
        {
          this.slogan = 'Free Home Delivery Upto 12 Km';
          this.s1=false;
          this.s2=true;
          this.s3=false;
        }
        else if(this.s2==true)
        {
          this.slogan = 'Cash On Delivery Upto 12 Km';
          this.s1=false;
          this.s2=false;
          this.s3=true;
        }
        else if(this.s3==true)
        {
          this.slogan = 'Shopping From All Shops';
          this.s1=true;
          this.s2=false;
          this.s3=false;
        }
        else
        {

        }
    },
    getCart:function(event,done){
      axios({
        method:'GET',
        url : 'user/viewcart/json'
      }).then(response => {
        this.cartinfo = response.data.result;

        done();
      }).catch(error => {
        if(error.response.data.message != undefined)
          alert(error.response.data.message);
        else
          alert('Something went wrong,please try again');

        done();
      });
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
    savegender:function(gender){
      localStorage.setItem("gender",gender);
    },
    saveshop:function(shop,bname,index,route,path){
      localStorage.setItem("shop",shop);
      localStorage.setItem("index",index);
      localStorage.setItem("bname",bname);
      console.log(shop);
      console.log(bname);
      route.navigate(path);
    },  
      openConfirm:function() {
        const app = this.$f7;
        app.dialog.confirm('New version available.Update ?', () => {
          app.dialog.alert('Great!');
        });
      },
    savedata:function(name,id,sname)
    {
      localStorage.setItem("pname",name);
      localStorage.setItem("pid",id);
      localStorage.setItem("sname",sname);
    },
    saveid:function(id)
    {
      console.log(id);
      localStorage.setItem("id",id);
    },
    savebanner:function(gender,category,product,route,path)
    {
      localStorage.setItem("gender",gender);
      localStorage.setItem("category",category);
      localStorage.setItem("product",product);
      route.navigate(path);
    }
  }

};



</script>
<style scoped>
.lineclampin{
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    width: 100%;
}
  ::-webkit-scrollbar {
    display: none;
    -moz-appearance: none;
   }
  .cat_width{
    width: 90px
  }
  .cat_width2{
    width:124px
  }
  .prod_width{
    width: 150px
  }
  @media only screen and (max-width: 350px){
   .cat_width{
    width: 80px !important
  }
  }
  .color{
    background-color:green;
  }
  .color1{
    background-color:#323232;
    bottom:0px
  }
  .checked {
  color: orange;
}


</style>
