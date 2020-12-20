  <template>
  <f7-page>
    <f7-navbar class="bgnav" style="border-radius:0px 0px 30px 0px;box-shadow: 5px 0px 10px rgba(0, 0, 0, 0.12)" sliding v-show="loginmobile!=null">
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
    <center v-show="loginmobile==null && checkRefer==false" style="margin-top:-56px;height:calc(100% + 56px)">
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
            <h5 v-show="otpSend!=null" style="color:green;text-transform:capitalize;margin:0px;text-align:left">{{otpSend}}</h5>
            <h5 v-show="otpError!=null" style="color:red;text-transform:capitalize;margin:0px;text-align:left">{{otpError}}</h5>
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
            <a @click="login" style="background-image: linear-gradient(to right, #11998e, #38ef7d);color:#FFFFFF;font-size:18px;font-weight:bold;border:0px;text-transform:Capitalize;margin:10px;border-radius:30px" class="button button-fill button-big">{{btn_text}} <f7-icon f7="chevron_right" style="margin:-5px 0px 0px 10px"></f7-icon>
            </a>
        </div>
      </f7-block>
  </div>
  </center>
  <center v-show="checkRefer==true && loginmobile==null" style="height:100%">
    <f7-button @click="cancelRefer" style="position:absolute;top:16px;right:16px;font-size:14px;font-weight:bold;text-transform:capitalize;background-color:#FFFFFF;border-radius:30px;border:1px solid gray;color:gray;padding:0px 22px" class="button button-fill">Skip</f7-button>
    <div style="overflow:hidden;display: flex;flex-direction: column;position:relative;top:20%">
      <f7-block v-show="activateCashback==false" style="background-color:white;padding:16px 16px 0px;margin:0px">
        <f7-row>
          <f7-col style="height:160px">
              <f7-link @click="sheetCheck1" style="height:100%"><img src="../assets/refer.svg" style="width:100%;height:100%;border-radius:5px" alt="SUPER30 Promocode offer"></f7-link>
          </f7-col>
        </f7-row>
      </f7-block>
      <f7-block v-show="activateRefer==false && activateCashback==false">
        <h3 style="font-size:18px">Did anyone referred you ?</h3>
        <f7-row style="margin-top:30px">
          <f7-col>
            <f7-button @click="cancelRefer" style="font-size:18px;font-weight:bold;text-transform:capitalize;background-color:#FFFFFF;border-radius:30px;border:1px solid #1d2671;color:#1d2671" class="button button-fill button-big">No</f7-button>
          </f7-col>
          <f7-col>
            <f7-button @click="selectRefer" style="background-image: linear-gradient(to right, #11998e, #38ef7d);color:#FFFFFF;font-size:18px;font-weight:bold;border:0px;text-transform:capitalize;border-radius:30px" class="button button-fill button-big">Yes</f7-button>
          </f7-col>
        </f7-row>
      </f7-block>
      <f7-block v-show="activateRefer==true">
        <h5 style="color:red;text-transform:capitalize;margin:0px;text-align:left;padding:5px 0px 0px 16px">{{referalError}}</h5>
        <f7-list form style="margin:0px" no-hairlines>
          <f7-list-item>
                 <f7-label floating style="float:left">Enter Referal mobile number</f7-label>
                 <f7-input type="number" @input="referal = $event.target.value" clear-button></f7-input>
          </f7-list-item>
        </f7-list>
        <a @click="getCashback" style="background-image: linear-gradient(to right, #11998e, #38ef7d);color:#FFFFFF;font-size:18px;font-weight:bold;border:0px;text-transform:Capitalize;margin:10px;border-radius:30px" class="button button-fill button-big">Redeem<f7-icon f7="chevron_right" style="margin:-5px 0px 0px 10px"></f7-icon>
            </a>
      </f7-block>
      <div style="margin-top:10px" v-show="activateRefer==false && activateCashback==true">
        <center>
          <div class="check_mark">
            <div class="sa-icon sa-success animate">
              <span class="sa-line sa-tip animateSuccessTip"></span>
              <span class="sa-line sa-long animateSuccessLong"></span>
              <div class="sa-placeholder"></div>
              <div class="sa-fix"></div>
            </div>
          </div>
          <p style="color:green;font-size:28px;font-weight:bold;margin-bottom:18px">₹ 20</p>
          <h3 style="color:black;margin-bottom:18px">Refer bonus added to your FS Wallet</h3>
          <h4 style="color:black;margin-bottom:28px">(₹ 30 added to your friends wallet)</h4>
          <f7-button @click="openHomePage" fill style="background-image: linear-gradient(to right, #11998e, #38ef7d);height:50px;line-height:50px;font-size:14px;font-weight:750;border-radius:30px;margin:20px 15px 0px 15px">Continue Shopping <f7-icon f7="chevron_right" style="margin:-5px 0px 0px 10px"></f7-icon></f7-button>
        </center>
      </div>
    </div>
  </center>
  <div v-show="loginmobile!=null && checkRefer==false">
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
        <f7-block style="background-color:#0d1635;margin:18px 0px 0px 10px;border-radius:30px 0px 0px 30px;padding:18px 0px 22px 2px">
          <div style="overflow-x:scroll;overflow-y:hidden;white-space:nowrap;padding:0px 15px 0px 15px">
            <f7-link @click="savegender('Men')" href="/categorymen/" style="height:100%;padding:0px 5px">
              <center style="width:110px">
                <f7-card style="width:70px;height:70px;margin:0px;border-radius:110px;padding:3px;background-image: linear-gradient(to right, #4568DC, #B06AB3)">
                  <img src="../assets/hcb1.png" style="width:64px;height:64px;border-radius:110px;padding:3px;background-color:#0d1635" alt="">
                </f7-card>
                <span style="color:#FFFFFF;margin-top:5px;display:inline-block;">Mens Clothing</span>
              </center>
            </f7-link>
            <!--<f7-link @click="savegender('Women')" href="/categorywomen/" style="height:100% ;padding:0px 5px"><f7-card style="height:64px;margin:0px;border-radius:4px" class="cat_width"><img src="../assets/hcb2.png" style="width:100%;height:100%;border-radius:4px" alt=""></f7-card></f7-link>-->
            <f7-link @click="savegender('Footwear')" href="/categoryfootwear/" style="height:100%;padding:0px 5px">
              <center style="width:110px">
                <f7-card style="width:70px;height:70px;margin:0px;border-radius:110px;padding:3px;background-image: linear-gradient(to right, #4568DC, #B06AB3)">
                  <img src="../assets/hcb5.png" style="width:64px;height:64px;border-radius:110px;padding:3px;background-color:#0d1635" alt="">
                </f7-card>
                <span style="color:#FFFFFF;margin-top:5px;display:inline-block;">Mens Footwear</span>
              </center>
            </f7-link>
            <!--<f7-link @click="savegender('Baby and Kids')" href="/categorykids/" style="height:100% ;padding:0px 5px"><f7-card style="height:64px;margin:0px;border-radius:4px" class="cat_width"><img src="../assets/hcb3.png" style="width:100%;height:100%;border-radius:4px" alt=""></f7-card></f7-link>-->
            <f7-link @click="savegender('Deodorant')"  href="/categorydeodorant/" style="height:100%;padding:0px 5px">
              <center style="width:110px">
                <f7-card style="width:70px;height:70px;margin:0px;border-radius:110px;padding:3px;background-image: linear-gradient(to right, #4568DC, #B06AB3)">
                  <img src="../assets/hcb4.png" style="width:64px;height:64px;border-radius:110px;padding:3px;background-color:#0d1635" alt="">
                </f7-card>
                <span style="color:#FFFFFF;margin-top:5px;display:inline-block;">Deodorants</span>
              </center>
            </f7-link>
            <!--<f7-link @click="save('electronicaccs')" href="/specificPage" style="height:100% ;padding:0px 5px"><f7-card style="height:64px;margin:0px;border-radius:4px" class="cat_width"><img src="../assets/raincoat.png" style="width:100%;height:100%;border-radius:4px" alt=""></f7-card></f7-link>-->
            <f7-link  href="/specificWant" style="height:100%;padding:0px 5px">
              <center style="width:110px">
                <f7-card style="width:70px;height:70px;margin:0px;border-radius:110px;padding:3px;background-image: linear-gradient(to right, #4568DC, #B06AB3)">
                  <img src="../assets/hcbsp.png" style="width:64px;height:64px;border-radius:110px;padding:3px;background-color:#0d1635" alt="">
                </f7-card>
                <span style="color:#FFFFFF;margin-top:5px;display:inline-block;">Specific Want</span>
              </center>
            </f7-link>
          </div>
        </f7-block>
        <f7-block v-show="appVersion!='1.2.1'" style="margin:18px 10px 0px 0px;padding:18px 24px;background-image: linear-gradient(to right, #ff416c, #ff4b2b);color:#FFFFFF;font-size:16px;font-weight:bold;border-radius:0px 30px 30px 0px">
          <f7-row>
            <f7-col width="70">
              New Update Available
            </f7-col>
            <f7-link width="30" class="link external" href="https://appurl.io/nYh8w0p2a" style="color:#FFFFFF">
              Update <f7-icon f7="chevron_right" style="margin:0px 0px 0px 10px"></f7-icon>
            </f7-link>
          </f7-row>
        </f7-block>
        <f7-block style="background-color:white;margin:0px;height:56px">
            <center style="line-height:56px;color:#4caf50;font-size:17px;font-weight:bold">{{ slogan }}
            </center>
        </f7-block>
        <f7-swiper class="mpzero" style="height:400px;border-radius:30px 0px 30px 0px" :params="{speed:400,loop:true, slidesPerView: 1, autoplay: { delay: 2000, disableOnInteraction:false }}">
          <f7-swiper-slide class="swiper-slide" data-swiper-autoplay="2000" v-for="(image,index) in shopOfferBanners" :key="image.name">
            <f7-card style="width:100%;height:400px;-webkit-box-shadow: none;box-shadow:none" class="cardm">
              <f7-link v-if="index!=3"  href="javascript:void(0)" @click="saveshop(image.shop,image.name,index,$f7router,'/offercategory/')" style="width: 100%;height:400px">
                <img :src="image.banner" style="width:100%;height:100%" alt="">
              </f7-link>
              <f7-link v-else href="javascript:void(0)" @click="saveshop(image.shop,image.name,index,$f7router,'/offers1')" style="width: 100%;height:400px">
                <img :src="image.banner" style="width:100%;height:100%" alt="">
              </f7-link>
            </f7-card>
          </f7-swiper-slide>
         </f7-swiper>

      <f7-popup class="demo-popup " id="pop" :opened="popupOpened" @popup:closed="popupOpened = false">
        <f7-page login-screen>
          <f7-link style="position:absolute;top:16px;right:16px;border:1px solid gray;border-radius:30px;padding:5px 20px;color:#212121;font-weight:bold" popup-close @click="closepop()">Later</f7-link>
          <f7-block style="margin:60px 0px 90px 0px;padding:0px">
            <div class="block" style="margin-top:0px">
              <p class="text-align-center" style="margin:10px auto 10px auto;color:#1d2671;font-size:8vw;font-weight:bold">Dear Judge</p>
              <div style="text-align:center"><img src="../assets/rating.svg" style="height:40px" alt="rate"></div>
              <p class="text-align-center" style="margin:0em auto 0.5em auto;color:#000000;font-size:5vw;font-weight:bold">Please give your points</p>
              <f7-block-title style="margin:0px;padding:28px 10px;font-size:18px;font-weight:bold;color:#000000">
               1.&nbsp How was our performance ?
              </f7-block-title>
              <f7-block style="margin:0px;padding:0px">
                <div style="overflow-x:scroll;overflow-y:hidden;white-space:nowrap;padding:0px 0px 0px 22px;font-weight:bold">
                  <template v-for="(result,index) in performance">
                    <f7-chip :class="{'performance_selector_active': activePerformanceId === index}"
                      @click="setActivePerformanceId(index)" style="margin:2px 5px;cursor:pointer;text-transform: capitalize;font-size:16px" :text="result"></f7-chip>
                  </template>
                </div>
              </f7-block>
              <f7-block-title style="margin:0px;padding:28px 10px;font-size:18px;font-weight:bold;color:#000000">
               2.&nbsp How did you first hear about us ?
              </f7-block-title>
              <f7-block style="margin:0px;padding:0px">
                <f7-list style="margin:0px;color:gray;font-size:16px">
                  <template v-for="(result,index) in hear">
                    <label class="item-content item-radio">
                      <input v-model="selectedHear" :value="result" type="radio">
                      <i class="icon icon-radio"></i>
                      <div class="item-inner"><div class="item-title">{{result}}</div></div>
                    </label>
                  </template>
                </f7-list>
              </f7-block>
              <f7-block-title style="margin:0px;padding:28px 10px;font-size:18px;font-weight:bold;color:#000000">
               3.&nbsp How was our product variety ?
              </f7-block-title>
              <f7-block style="margin:0px;padding:0px">
                <div style="overflow-x:scroll;overflow-y:hidden;white-space:nowrap;padding:0px 0px 0px 22px;font-weight:bold">
                  <template v-for="(result,index) in variety">
                    <f7-chip :class="{'variety_selector_active': activeVarietyId === index}"
                      @click="setActiveVarietyId(index)" style="margin:2px 5px;cursor:pointer;text-transform: capitalize;font-size:16px" :text="result"></f7-chip>
                  </template>
                </div>
              </f7-block>
              <f7-block-title style="margin:0px;padding:28px 10px 8px 10px;font-size:18px;font-weight:bold;color:#000000">
               4.&nbsp Where we need to improve ?
              </f7-block-title>
              <f7-block style="margin:0px;padding:0px">
                <f7-list form no-hairlines-md style="margin:0px;color:#000000">
                  <f7-list-item>
                      <h5 style="color:red;text-transform:uppercase;margin:0px">{{feedbackerror}}</h5>
                      <f7-label floating>Start writing ...</f7-label>
                      <f7-input type="textarea" @input="feedback = $event.target.value" clear-button></f7-input>
                  </f7-list-item>
                </f7-list>
              </f7-block>
              <f7-block-title style="margin:0px;padding:28px 10px;font-size:18px;font-weight:bold;color:#000000">
               5.&nbsp Will you tell friends about us ?
              </f7-block-title>
              <f7-block style="margin:0px;padding:0px">
                <div style="overflow-x:scroll;overflow-y:hidden;white-space:nowrap;padding:0px 0px 0px 22px;font-weight:bold">
                  <template v-for="(result,index) in aboutus">
                    <f7-chip :class="{'aboutus_selector_active': activeAboutusId === index}"
                      @click="setActiveAboutusId(index)" style="margin:2px 5px;cursor:pointer;text-transform: capitalize;font-size:16px" :text="result"></f7-chip>
                  </template> 
                </div>
              </f7-block>
            </div>
          </f7-block>
          <div style="position:fixed;bottom:0;z-index:999;width:100%;background-color:#FFFFFF;box-shadow: 5px 0px 10px rgba(0, 0, 0, 0.12);border-radius:30px 30px 0px 0px">
            <f7-button :disabled="feedbackButton" @click="sendFeedback" class="col button button-big button-fill popup-close" style="background-image: linear-gradient(to right, #11998e, #38ef7d);color:#FFFFFF;font-size:18px;font-weight:bold;border:0px;text-transform:Capitalize;margin:10px;border-radius:30px">Send &nbsp <f7-icon f7="chevron_right"></f7-icon></f7-button>
          </div>
        </f7-page>
      </f7-popup>

    <f7-block style="background-color:white;padding:0px;margin:28px 0px 10px 10px;border:1px solid gray;border-right:0px;border-radius:30px 0px 0px 30px">
      <div style="padding:22px 16px 22px 20px">
        <div style="display:inline-block;height:30px">
          <img src="../assets/trending_icon.png" style="width:30px;height:30px;border-radius:50%;vertical-align: middle;" alt="Shops">
        </div>
        <div style="font-weight:bold;color:#000000;font-size:18px;display:inline-block;vertical-align: middle;" class="mpzero">&nbsp Top products at {{city}}</div>
      </div>
      <div style="overflow-x:scroll;overflow-y:hidden;white-space:nowrap;padding:0px 0px 18px 13px;margin-left:2px">
        <template v-for="(result,index) in trending">
          <f7-link :key="index" :href="'/productdetails/' + result.id + '/' + result.name" style="width:162px;height:46vh;margin:0px 3px" @click="saveid(result.id)">
            <f7-card style="width:100%;height:100%;margin:0px;padding:0px;-webkit-box-shadow: none;box-shadow: none">
              <div class="image_viewer" style="width: 100%;height:34vh;">
                <img :src="result.image[0]" style="width:100%;height:100%;margin:0px;object-fit: contain">
                <div v-show="result.specialDiscount == true" style="max-width:120px;position:absolute;z-index:99;bottom:84px;left:0px;background-image: linear-gradient(to right, #8E2DE2, #4A00E0);color:#FFFFFF;border-radius:0px 30px 30px 0px;font-size:16px;font-weight:bold;padding:3px 8px">
                  <p class="mpzero lineclampin" style="font-size:16px">&#8377;{{result.specialDiscountedPrice}}<span style="font-size:12px;line-height:17px;height:17px"> - {{result.offers}}</span></p>
                </div>
              </div>
              <div style="position:absolute;top:10px;left:10px;z-index:99;background-color:#5ddcf9;border-radius:50%;color:#000000;width:46px;height:46px;opacity:0.9;text-align:center">
                  <p style="font-size:20px;font-weight:bold;margin:6px 0px 0px;padding:0px;line-height:20px">{{discountTrending[index]}}</p>
                  <p style="font-size:10px;font-weight:bold;margin:0px;padding:0px;line-height:12px">% OFF</p>
              </div>
              <f7-block style="color:gray;font-size:14px;font-weight:bold;padding:8px">
                <p class="mpzero lineclampin">
                <span v-show="result.specialDiscount == false" style="color:#000000;font-size:17px">&#8377;{{result.selling_price}}</span>
                <span v-show="result.specialDiscount == true" style="color:#000000;font-size:17px;text-decoration:line-through;margin:0px">&#8377;{{result.selling_price}}</span>
                <span style="text-decoration:line-through;margin-left:3px">&#8377;{{result.mrp_price}}</span></p>
                <p class="mpzero lineclampin" style="margin-top:6px">
                <img src="../assets/shop_icon.png" style="width:24px;height:24px;border-radius:50%;vertical-align: middle;" alt="Shops">&nbsp {{result.shop_name}}</p>
              </f7-block>
            </f7-card>
          </f7-link>
        </template>
      </div>
    </f7-block>
    <f7-block style="background-color:white;padding:18px 10px 0px 0px;margin:0px">
      <f7-row>
        <f7-col style="height:90px">
            <a @click="openSheetRefer" style="height:100%"><img src="../assets/featurebanner3.png" style="width:100%;height:100%;border-radius:0px 50px 50px 0px"></a>
        </f7-col>
      </f7-row>
    </f7-block>
    <f7-block style="background-color:white;padding:0px;margin:28px 0px 10px 10px;border:1px solid gray;border-right:0px;border-radius:30px 0px 0px 30px">
      <div style="padding:22px 16px 22px 20px">
        <div style="display:inline-block;height:30px">
          <img src="../assets/deo_icon.png" style="width:30px;height:30px;border-radius:50%;vertical-align: middle;" alt="Deodorants">
        </div>
        <div style="font-weight:bold;color:#000000;font-size:18px;display:inline-block;vertical-align: middle;" class="mpzero">&nbsp Deodorants</div>
        <f7-link style="font-weight:bold;color:#1d2671;font-size:16px;margin-top:2px;float:right" class="mpzero" href="/categorydeodorant/">See all</f7-link>
      </div>
      <div style="overflow-x:scroll;overflow-y:hidden;white-space:nowrap;margin:0px;padding-bottom:26px;margin-left:2px">
        <f7-link @click="savebanner('Deodorant','Men Deodorant','Fogg',$f7router,'/products/')" href="javascript:void(0)" style="height:100%;padding:0px 8px 0px 16px"><f7-card style="height:124px;margin:0px;border-radius:16px" class="cat_width2"><img src="../assets/d_fogg.png" style="width:100%;height:100%;border-radius:16px" alt=""></f7-card></f7-link>
        <f7-link @click="savebanner('Deodorant','Men Deodorant','Axe',$f7router,'/products/')" href="javascript:void(0)" style="height:100% ;padding:0px 8px"><f7-card style="height:124px;margin:0px;border-radius:16px" class="cat_width2"><img src="../assets/d_axe.png" style="width:100%;height:100%;border-radius:16px" alt=""></f7-card></f7-link>
        <f7-link @click="savebanner('Deodorant','Men Deodorant','Denver',$f7router,'/products/')" href="javascript:void(0)" style="height:100% ;padding:0px 8px"><f7-card style="height:124px;margin:0px;border-radius:16px" class="cat_width2"><img src="../assets/d_denver.png" style="width:100%;height:100%;border-radius:16px" alt=""></f7-card></f7-link>
        <f7-link @click="savebanner('Deodorant','Men Deodorant','Wildstone',$f7router,'/products/')" href="javascript:void(0)" style="height:100% ;padding:0px 8px"><f7-card style="height:124px;margin:0px;border-radius:16px" class="cat_width2"><img src="../assets/d_wildstone.png" style="width:100%;height:100%;border-radius:16px" alt=""></f7-card></f7-link>
        <f7-link @click="savebanner('Deodorant','Men Deodorant','Park Avenue',$f7router,'/products/')" href="javascript:void(0)" style="height:100% ;padding:0px 16px 0px 8px"><f7-card style="height:124px;margin:0px;border-radius:16px" class="cat_width2"><img src="../assets/d_parkavenue.png" style="width:100%;height:100%;border-radius:16px" alt=""></f7-card></f7-link>
      </div>
    </f7-block>
    <f7-block style="background-color:white;padding:18px 10px 0px 0px;margin:0px">
      <f7-row>
        <f7-col style="height:90px">
            <f7-link @click="sheetCheck2" style="height:100%"><img src="../assets/featurebanner4.png" style="width:100%;height:100%;border-radius:0px 50px 50px 0px" alt="Try and buy feature"></f7-link>
        </f7-col>
       </f7-row>
    </f7-block>
    <f7-block style="background-color:white;padding:0px;margin:28px 0px 10px 10px;border:1px solid gray;border-right:0px;border-radius:30px 0px 0px 30px">
      <div style="padding:22px 16px 22px 20px">
        <div style="display:inline-block;height:30px">
          <img src="../assets/shop_icon.png" style="width:30px;height:30px;border-radius:50%;vertical-align: middle;" alt="Shops">
        </div>
        <div style="font-weight:bold;color:#000000;font-size:18px;display:inline-block;vertical-align: middle;" class="mpzero">&nbsp Shops at {{city}}</div>
        <f7-link style="font-weight:bold;color:#1d2671;font-size:16px;margin-top:2px;float:right" class="mpzero" href="/shop/">See all</f7-link>
      </div>
      <div style="overflow-x:scroll;overflow-y:hidden;white-space:nowrap;padding:0px 0px 16px 8px;height:170px;margin-left:2px">
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
    <f7-block style="background-color:white;padding:18px 10px 0px 0px;margin:0px">
      <f7-row>
        <f7-col style="height:90px">
            <f7-link @click="sheetCheck" style="height:100%"><img src="../assets/cashback_featurebanner.png" style="width:100%;height:100%;border-radius:0px 50px 50px 0px" alt="FS cashback"></f7-link>
        </f7-col>
       </f7-row>
    </f7-block>
    <f7-block style="background-color:white;padding:0px;margin:28px 0px 10px 10px;border:1px solid gray;border-right:0px;border-radius:30px 0px 0px 30px">
      <div style="padding:22px 16px 22px 20px">
        <div style="display:inline-block;height:30px">
          <img src="../assets/man_icon.png" style="width:30px;height:30px;border-radius:50%;vertical-align: middle;" alt="Mens Clothing">
        </div>
        <div style="font-weight:bold;color:#000000;font-size:18px;display:inline-block;vertical-align: middle;" class="mpzero">&nbsp Mens Clothing</div>
        <f7-link style="font-weight:bold;color:#1d2671;font-size:16px;margin-top:2px;float:right" class="mpzero" href="/categorymen/">See all</f7-link>
      </div>
      <div style="overflow-x:scroll;overflow-y:hidden;white-space:nowrap;margin:0px;padding-bottom:26px;margin-left:2px">
        <f7-link @click="savebanner('Men','Top wear','T-Shirts',$f7router,'/products/')" href="javascript:void(0)" style="height:100%;padding:0px 8px 0px 16px"><f7-card style="height:124px;margin:0px;border-radius:16px" class="cat_width2"><img src="../assets/m_tshirt.png" style="width:100%;height:100%;border-radius:16px" alt=""></f7-card></f7-link>
        <f7-link @click="savebanner('Men','Top wear','Casual Shirts',$f7router,'/products/')" href="javascript:void(0)" style="height:100% ;padding:0px 8px"><f7-card style="height:124px;margin:0px;border-radius:16px" class="cat_width2"><img src="../assets/m_shirt.png" style="width:100%;height:100%;border-radius:16px" alt=""></f7-card></f7-link>
        <f7-link @click="savebanner('Men','Bottom wear','Jeans',$f7router,'/products/')" href="javascript:void(0)" style="height:100% ;padding:0px 8px"><f7-card style="height:124px;margin:0px;border-radius:16px" class="cat_width2"><img src="../assets/m_jean.png" style="width:100%;height:100%;border-radius:16px" alt=""></f7-card></f7-link>
        <f7-link @click="savebanner('Men','Innerwear and sleepwear','Briefs and trunks',$f7router,'/products/')" href="javascript:void(0)" style="height:100% ;padding:0px 8px"><f7-card style="height:124px;margin:0px;border-radius:16px" class="cat_width2"><img src="../assets/m_brief.png" style="width:100%;height:100%;border-radius:16px" alt=""></f7-card></f7-link>
        <f7-link @click="savebanner('Men','Bottom wear','Shorts and 3 by 4ths',$f7router,'/products/')" href="javascript:void(0)" style="height:100% ;padding:0px 16px 0px 8px"><f7-card style="height:124px;margin:0px;border-radius:16px" class="cat_width2"><img src="../assets/m_short.png" style="width:100%;height:100%;border-radius:16px" alt=""></f7-card></f7-link>
      </div>
    </f7-block>
    <f7-block style="background-color:white;padding:18px 0px 0px;margin:0px">
      <f7-row no-gap>
        <f7-col style="height:192px;padding:0px 5px 0px 0px">
            <f7-link @click="saveshop('MJ Collection','Shirts Under Rs.550',index,$f7router,'/offers1')" style="height:100%"><img src="../assets/featurebanner8.png" style="width:100%;height:100%;border-radius:0px 30px 30px 0px" alt="Specific Want Order"></f7-link>
        </f7-col>
        <f7-col style="height:192px;padding:0px 0px 0px 5px">
            <f7-link @click="saveshop('Style hub wear','T-Shirts Under Rs.299',index,$f7router,'/offers1')" style="height:100%"><img src="../assets/featurebanner9.png" style="width:100%;height:100%;border-radius:30px 0px 0px 30px" alt="Specific Want Order"></f7-link>
        </f7-col>
       </f7-row>
    </f7-block>
    <f7-block style="background-color:white;padding:0px;margin:28px 0px 10px 10px;border:1px solid gray;border-right:0px;border-radius:30px 0px 0px 30px">
      <div style="padding:22px 16px 22px 20px">
        <div style="display:inline-block;height:30px">
          <img src="../assets/innerwear_icon.png" style="width:30px;height:30px;border-radius:50%;vertical-align: middle;" alt="Mens innerwear">
        </div>
        <div style="font-weight:bold;color:#000000;font-size:18px;display:inline-block;vertical-align: middle;" class="mpzero">&nbsp Mens Innerwear</div>
        <f7-link style="font-weight:bold;color:#1d2671;font-size:16px;margin-top:2px;float:right" class="mpzero" @click="savebanner('Men','Innerwear and sleepwear','Briefs and trunks',$f7router,'/products/')">See all</f7-link>
      </div>
      <div style="overflow-x:scroll;overflow-y:hidden;white-space:nowrap;padding:0px 0px 18px 13px;margin-left:2px">
        <template v-for="(result,index) in mensInnerwear">
          <f7-link :key="index" :href="'/productdetails/' + result.id + '/' + result.name" style="width:162px;height:46vh;margin:0px 3px" @click="saveid(result.id)">
            <f7-card style="width:100%;height:100%;margin:0px;padding:0px;-webkit-box-shadow: none;box-shadow: none">
              <div class="image_viewer" style="width: 100%;height:34vh;">
                <img :src="result.image[0]" style="width:100%;height:100%;margin:0px;object-fit: contain">
                <div v-show="result.specialDiscount == true" style="max-width:120px;position:absolute;z-index:99;bottom:84px;left:0px;background-image: linear-gradient(to right, #8E2DE2, #4A00E0);color:#FFFFFF;border-radius:0px 30px 30px 0px;font-size:16px;font-weight:bold;padding:3px 8px">
                  <p class="mpzero lineclampin" style="font-size:16px">&#8377;{{result.specialDiscountedPrice}}<span style="font-size:12px;line-height:17px;height:17px"> - {{result.offers}}</span></p>
                </div>
              </div>
              <div style="position:absolute;top:10px;left:10px;z-index:99;background-color:#5ddcf9;border-radius:50%;color:#000000;width:46px;height:46px;opacity:0.9;text-align:center">
                  <p style="font-size:20px;font-weight:bold;margin:6px 0px 0px;padding:0px;line-height:20px">{{discountInnerwear[index]}}</p>
                  <p style="font-size:10px;font-weight:bold;margin:0px;padding:0px;line-height:12px">% OFF</p>
              </div>
              <f7-block style="color:gray;font-size:14px;font-weight:bold;padding:8px">
                <p class="mpzero lineclampin">
                <span v-show="result.specialDiscount == false" style="color:#000000;font-size:17px">&#8377;{{result.selling_price}}</span>
                <span v-show="result.specialDiscount == true" style="color:#000000;font-size:17px;text-decoration:line-through;margin-left:0px">&#8377;{{result.selling_price}}</span>
                <span style="text-decoration:line-through;margin-left:3px">&#8377;{{result.mrp_price}}</span></p>
                <p class="mpzero lineclampin" style="margin-top:6px">
                <img src="../assets/shop_icon.png" style="width:24px;height:24px;border-radius:50%;vertical-align: middle;" alt="Shops">&nbsp {{result.shop_name}}</p>
              </f7-block>
            </f7-card>
          </f7-link>
        </template>
      </div>
    </f7-block>
    <f7-block style="background-color:white;padding:18px 10px 0px 0px;margin:0px">
      <f7-row>
        <f7-col style="height:90px">
            <f7-link href="/specificWant" style="height:100%"><img src="../assets/featurebanner1.png" style="width:100%;height:100%;border-radius:0px 50px 50px 0px" alt="Specific Want Order"></f7-link>
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
    <f7-block style="background-color:white;padding:0px;margin:28px 0px 10px 10px;border:1px solid gray;border-right:0px;border-radius:30px 0px 0px 30px">
      <div style="padding:22px 16px 22px 20px">
        <div style="display:inline-block;height:30px">
          <img src="../assets/footwear_icon.png" style="width:30px;height:30px;border-radius:50%;vertical-align: middle;" alt="Mens Footwear">
        </div>
        <div style="font-weight:bold;color:#000000;font-size:18px;display:inline-block;vertical-align: middle;" class="mpzero">&nbsp Mens Footwear</div>
        <f7-link style="font-weight:bold;color:#1d2671;font-size:16px;margin-top:2px;float:right" class="mpzero" href="/categoryfootwear/">See all</f7-link>
      </div>
      <div style="overflow-x:scroll;overflow-y:hidden;white-space:nowrap;margin:0px;padding-bottom:26px;margin-left:2px">
        <f7-link @click="savebanner('Footwear','Men footwear','Sandals',$f7router,'/products/')" href="javascript:void(0)" style="height:100% ;padding:0px 8px 0px 16px"><f7-card style="height:124px;margin:0px;border-radius:16px" class="cat_width2"><img src="../assets/m_sandals.png" style="width:100%;height:100%;border-radius:16px" alt=""></f7-card></f7-link>
        <f7-link @click="savebanner('Footwear','Men footwear','Chappals',$f7router,'/products/')" href="javascript:void(0)" style="height:100% ;padding:0px 8px"><f7-card style="height:124px;margin:0px;border-radius:16px" class="cat_width2"><img src="../assets/m_chapals.png" style="width:100%;height:100%;border-radius:16px" alt=""></f7-card></f7-link>
        <f7-link @click="savebanner('Footwear','Men footwear','Casual Shoes',$f7router,'/products/')" href="javascript:void(0)" style="height:100%;padding:0px 8px"><f7-card style="height:124px;margin:0px;border-radius:16px" class="cat_width2"><img src="../assets/m_casualshoes.png" style="width:100%;height:100%;border-radius:16px" alt=""></f7-card></f7-link>
        <f7-link @click="savebanner('Footwear','Men footwear','Loafers',$f7router,'/products/')" href="javascript:void(0)" style="height:100% ;padding:0px 8px"><f7-card style="height:124px;margin:0px;border-radius:16px" class="cat_width2"><img src="../assets/m_loafers.png" style="width:100%;height:100%;border-radius:16px" alt=""></f7-card></f7-link>
        <f7-link @click="savebanner('Footwear','Men footwear','Sport Shoes',$f7router,'/products/')" href="javascript:void(0)" style="height:100% ;padding:0px 16px 0px 8px"><f7-card style="height:124px;margin:0px;border-radius:16px" class="cat_width2"><img src="../assets/m_sportshoes.png" style="width:100%;height:100%;border-radius:16px" alt=""></f7-card></f7-link>
      </div>
    </f7-block>
<!--<f7-block style="background-color:white;padding:18px 16px 0px;margin:0px">
      <f7-row style="margin-bottom:1em">
        <f7-col style="height:14vh">
            <f7-link v-if="mobile!=null" href="/wallet" style="height:100%"><img src="../assets/featurebanner7.png" style="width:100%;height:100%;border-radius:5px" alt="Rate us now"></f7-link>
        </f7-col>
       </f7-row>
    </f7-block>-->
    <f7-block style="background-color:white;padding:18px 0px 0px;margin:0px">
      <f7-row no-gap>
        <f7-col style="height:192px;padding:0px 5px 0px 0px"">
            <f7-link @click="saveshop('Kingz','Shorts Under Rs.350',index,$f7router,'/offers1')"  style="height:100%"><img src="../assets/featurebanner10.png" style="width:100%;height:100%;border-radius:0px 30px 30px 0px" alt="Specific Want Order"></f7-link>
        </f7-col>
        <f7-col style="height:192px;padding:0px 0px 0px 5px"">
            <f7-link @click="saveshop('Shoe Park','Chappals Under Rs.210',index,$f7router,'/offers1')" style="height:100%"><img src="../assets/featurebanner11.png" style="width:100%;height:100%;border-radius:30px 0px 0px 30px" alt="Specific Want Order"></f7-link>
        </f7-col>
       </f7-row>
    </f7-block>
    <f7-block style="background-color:white;padding:0px;margin:28px 0px 10px 10px;border:1px solid gray;border-right:0px;border-radius:30px 0px 0px 30px">
      <div style="padding:22px 16px 22px 20px">
        <div style="display:inline-block;height:30px">
          <img src="../assets/casualshoes_icon.png" style="width:30px;height:30px;border-radius:50%;vertical-align: middle;" alt="Mens Casual Shoes">
        </div>
        <div style="font-weight:bold;color:#000000;font-size:18px;display:inline-block;vertical-align: middle;" class="mpzero">&nbsp Mens Casual Shoes</div>
        <f7-link style="font-weight:bold;color:#1d2671;font-size:16px;margin-top:2px;float:right" class="mpzero" @click="savebanner('Footwear','Men Footwear','Casual Shoes',$f7router,'/products/')">See all</f7-link>
      </div>
      <div style="overflow-x:scroll;overflow-y:hidden;white-space:nowrap;padding:0px 0px 18px 13px;margin-left:2px">
        <template v-for="(result,index) in mensCasualShoes">
          <f7-link :key="index" :href="'/productdetails/' + result.id + '/' + result.name" style="width:162px;height:46vh;margin:0px 3px" @click="saveid(result.id)">
            <f7-card style="width:100%;height:100%;margin:0px;padding:0px;-webkit-box-shadow: none;box-shadow: none">
              <div class="image_viewer" style="width: 100%;height:34vh;">
                <img :src="result.image[0]" style="width:100%;height:100%;margin:0px;object-fit: contain">
                <div v-show="result.specialDiscount == true" style="max-width:120px;position:absolute;z-index:99;bottom:84px;left:0px;background-image: linear-gradient(to right, #8E2DE2, #4A00E0);color:#FFFFFF;border-radius:0px 30px 30px 0px;font-size:16px;font-weight:bold;padding:3px 8px">
                  <p class="mpzero lineclampin" style="font-size:16px">&#8377;{{result.specialDiscountedPrice}}<span style="font-size:12px;line-height:17px;height:17px"> - {{result.offers}}</span></p>
                </div>
              </div>
              <div style="position:absolute;top:10px;left:10px;z-index:99;background-color:#5ddcf9;border-radius:50%;color:#000000;width:46px;height:46px;opacity:0.9;text-align:center">
                  <p style="font-size:20px;font-weight:bold;margin:6px 0px 0px;padding:0px;line-height:20px">{{discountShoes[index]}}</p>
                  <p style="font-size:10px;font-weight:bold;margin:0px;padding:0px;line-height:12px">% OFF</p>
              </div>
              <f7-block style="color:gray;font-size:14px;font-weight:bold;padding:8px">
                <p class="mpzero lineclampin">
                <span v-show="result.specialDiscount == false" style="color:#000000;font-size:17px">&#8377;{{result.selling_price}}</span>
                <span v-show="result.specialDiscount == true" style="color:#000000;font-size:17px;text-decoration:line-through;margin-left:0px">&#8377;{{result.selling_price}}</span>
                <span style="text-decoration:line-through;margin-left:3px">&#8377;{{result.mrp_price}}</span></p>
                <p class="mpzero lineclampin" style="margin-top:6px">
                <img src="../assets/shop_icon.png" style="width:24px;height:24px;border-radius:50%;vertical-align: middle;" alt="Shops">&nbsp {{result.shop_name}}</p>
              </f7-block>
            </f7-card>
          </f7-link>
        </template>
      </div>
    </f7-block>
    <f7-block style="background-color:white;padding:18px 10px 0px 0px;margin:0px">
      <f7-row>
        <f7-col style="height:90px">
            <f7-link href="/ongoing/" style="height:100%"><img src="../assets/featurebanner2.png" style="width:100%;height:100%;border-radius:0px 50px 50px 0px" alt="shop offers"></f7-link>
        </f7-col>
       </f7-row>
    </f7-block>  
    <f7-block style="background-color:white;padding:0px;margin:28px 0px 10px 10px;border:1px solid gray;border-right:0px;border-radius:30px 0px 0px 30px">
      <div style="padding:22px 16px 22px 20px">
        <div style="display:inline-block;height:30px">
          <img src="../assets/tshirt_icon.png" style="width:30px;height:30px;border-radius:50%;vertical-align: middle;" alt="Mens T-shirts">
        </div>
        <div style="font-weight:bold;color:#000000;font-size:18px;display:inline-block;vertical-align: middle;" class="mpzero">&nbsp Mens T-shirts</div>
        <f7-link style="font-weight:bold;color:#1d2671;font-size:16px;margin-top:2px;float:right" class="mpzero" @click="savebanner('Men','Top wear','T-Shirts',$f7router,'/products/')" href="javascript:void(0)">See all</f7-link>
      </div>
      <div style="overflow-x:scroll;overflow-y:hidden;white-space:nowrap;padding:0px 0px 18px 13px;margin-left:2px">
        <template v-for="(result,index) in mensTShirts">
          <f7-link :key="index" :href="'/productdetails/' + result.id + '/' + result.name" style="width:162px;height:46vh;margin:0px 3px" @click="saveid(result.id)">
            <f7-card style="width:100%;height:100%;margin:0px;padding:0px;-webkit-box-shadow: none;box-shadow: none">
              <div class="image_viewer" style="width: 100%;height:34vh;">
                <img :src="result.image[0]" style="width:100%;height:100%;margin:0px;object-fit: contain">
                <div v-show="result.specialDiscount == true" style="max-width:120px;position:absolute;z-index:99;bottom:84px;left:0px;background-image: linear-gradient(to right, #8E2DE2, #4A00E0);color:#FFFFFF;border-radius:0px 30px 30px 0px;font-size:16px;font-weight:bold;padding:3px 8px">
                  <p class="mpzero lineclampin" style="font-size:16px">&#8377;{{result.specialDiscountedPrice}}<span style="font-size:12px;line-height:17px;height:17px"> - {{result.offers}}</span></p>
                </div>
              </div>
              <div style="position:absolute;top:10px;left:10px;z-index:99;background-color:#5ddcf9;border-radius:50%;color:#000000;width:46px;height:46px;opacity:0.9;text-align:center">
                  <p style="font-size:20px;font-weight:bold;margin:6px 0px 0px;padding:0px;line-height:20px">{{discountTShirts[index]}}</p>
                  <p style="font-size:10px;font-weight:bold;margin:0px;padding:0px;line-height:12px">% OFF</p>
              </div>
              <f7-block style="color:gray;font-size:14px;font-weight:bold;padding:8px">
                <p class="mpzero lineclampin">
                <span v-show="result.specialDiscount == false" style="color:#000000;font-size:17px">&#8377;{{result.selling_price}}</span>
                <span v-show="result.specialDiscount == true" style="color:#000000;font-size:17px;text-decoration:line-through;margin-left:0px">&#8377;{{result.selling_price}}</span>
                <span style="text-decoration:line-through;margin-left:3px">&#8377;{{result.mrp_price}}</span></p>
                <p class="mpzero lineclampin" style="margin-top:6px">
                <img src="../assets/shop_icon.png" style="width:24px;height:24px;border-radius:50%;vertical-align: middle;" alt="Shops">&nbsp {{result.shop_name}}</p>
              </f7-block>
            </f7-card>
          </f7-link>
        </template>
      </div>
    </f7-block>
    <f7-block style="background-color:white;padding:18px 10px 0px 0px;margin:0px">
      <f7-row>
        <f7-col style="height:90px">
            <f7-link @click="savegender('Deodorant')" href="/categorydeodorant/" style="height:100%"><img src="../assets/featurebanner5.png" style="width:100%;height:100%;border-radius:0px 50px 50px 0px" alt="Deodorant"></f7-link>
        </f7-col>
       </f7-row>
    </f7-block>
    <f7-block style="background-color:white;padding:0px;margin:28px 0px 10px 10px;border:1px solid gray;border-right:0px;border-radius:30px 0px 0px 30px">
      <div style="padding:22px 16px 22px 20px">
        <div style="display:inline-block;height:30px">
          <img src="../assets/sandal_icon.png" style="width:30px;height:30px;border-radius:50%;vertical-align: middle;" alt="Mens Sandals">
        </div>
        <div style="font-weight:bold;color:#000000;font-size:18px;display:inline-block;vertical-align: middle;" class="mpzero">&nbsp Mens Sandals</div>
        <f7-link style="font-weight:bold;color:#1d2671;font-size:16px;margin-top:2px;float:right" class="mpzero" @click="savebanner('Footwear','Men footwear','Sandals',$f7router,'/products/')" href="javascript:void(0)">See all</f7-link>
      </div>
      <div style="overflow-x:scroll;overflow-y:hidden;white-space:nowrap;padding:0px 0px 18px 13px;margin-left:2px">
        <template v-for="(result,index) in mensSandals">
          <f7-link :key="index" :href="'/productdetails/' + result.id + '/' + result.name" style="width:162px;height:46vh;margin:0px 3px" @click="saveid(result.id)">
            <f7-card style="width:100%;height:100%;margin:0px;padding:0px;-webkit-box-shadow: none;box-shadow: none">
              <div class="image_viewer" style="width: 100%;height:34vh;">
                <img :src="result.image[0]" style="width:100%;height:100%;margin:0px;object-fit: contain">
                <div v-show="result.specialDiscount == true" style="max-width:120px;position:absolute;z-index:99;bottom:84px;left:0px;background-image: linear-gradient(to right, #8E2DE2, #4A00E0);color:#FFFFFF;border-radius:0px 30px 30px 0px;font-size:16px;font-weight:bold;padding:3px 8px">
                  <p class="mpzero lineclampin" style="font-size:16px">&#8377;{{result.specialDiscountedPrice}}<span style="font-size:12px;line-height:17px;height:17px"> - {{result.offers}}</span></p>
                </div>
              </div>
              <div style="position:absolute;top:10px;left:10px;z-index:99;background-color:#5ddcf9;border-radius:50%;color:#000000;width:46px;height:46px;opacity:0.9;text-align:center">
                  <p style="font-size:20px;font-weight:bold;margin:6px 0px 0px;padding:0px;line-height:20px">{{discountSandals[index]}}</p>
                  <p style="font-size:10px;font-weight:bold;margin:0px;padding:0px;line-height:12px">% OFF</p>
              </div>
              <f7-block style="color:gray;font-size:14px;font-weight:bold;padding:8px">
                <p class="mpzero lineclampin">
                <span v-show="result.specialDiscount == false" style="color:#000000;font-size:17px">&#8377;{{result.selling_price}}</span>
                <span v-show="result.specialDiscount == true" style="color:#000000;font-size:17px;text-decoration:line-through;margin-left:0px">&#8377;{{result.selling_price}}</span>
                <span style="text-decoration:line-through;margin-left:3px">&#8377;{{result.mrp_price}}</span></p>
                <p class="mpzero lineclampin" style="margin-top:6px">
                <img src="../assets/shop_icon.png" style="width:24px;height:24px;border-radius:50%;vertical-align: middle;" alt="Shops">&nbsp {{result.shop_name}}</p>
              </f7-block>
            </f7-card>
          </f7-link>
        </template>
      </div>
    </f7-block>
    <f7-block v-if="mobile!=null" style="background-color:white;padding:18px 10px 0px 0px;margin:0px">
      <f7-row>
        <f7-col style="height:90px">
            <f7-link  href="/wallet" style="height:100%"><img src="../assets/featurebanner6.png" style="width:100%;height:100%;border-radius:0px 50px 50px 0px" alt="FS Wallet"></f7-link>
        </f7-col>
       </f7-row>
    </f7-block>
    <f7-block style="background-color:white;padding:0px;margin:28px 0px 10px 10px;border:1px solid gray;border-right:0px;border-radius:30px 0px 0px 30px">
      <div style="padding:22px 16px 22px 20px">
        <div style="display:inline-block;height:30px">
          <img src="../assets/shirt_icon.png" style="width:30px;height:30px;border-radius:50%;vertical-align: middle;" alt="Mens Casual Shirt">
        </div>
        <div style="font-weight:bold;color:#000000;font-size:18px;display:inline-block;vertical-align: middle;" class="mpzero">&nbsp Mens Casual Shirts</div>
        <f7-link style="font-weight:bold;color:#1d2671;font-size:16px;margin-top:2px;float:right" class="mpzero" @click="savebanner('Men','Top wear','Casual Shirts',$f7router,'/products/')" href="javascript:void(0)">See all</f7-link>
      </div>
      <div style="overflow-x:scroll;overflow-y:hidden;white-space:nowrap;padding:0px 0px 18px 13px;margin-left:2px">
        <template v-for="(result,index) in mensShirts">
          <f7-link :key="index" :href="'/productdetails/' + result.id + '/' + result.name" style="width:162px;height:46vh;margin:0px 3px" @click="saveid(result.id)">
            <f7-card style="width:100%;height:100%;margin:0px;padding:0px;-webkit-box-shadow: none;box-shadow: none">
              <div class="image_viewer" style="width: 100%;height:34vh;">
                <img :src="result.image[0]" style="width:100%;height:100%;margin:0px;object-fit: contain">
                <div v-show="result.specialDiscount == true" style="max-width:120px;position:absolute;z-index:99;bottom:84px;left:0px;background-image: linear-gradient(to right, #8E2DE2, #4A00E0);color:#FFFFFF;border-radius:0px 30px 30px 0px;font-size:16px;font-weight:bold;padding:3px 8px">
                  <p class="mpzero lineclampin" style="font-size:16px">&#8377;{{result.specialDiscountedPrice}}<span style="font-size:12px;line-height:17px;height:17px"> - {{result.offers}}</span></p>
                </div>
              </div>
              <div style="position:absolute;top:10px;left:10px;z-index:99;background-color:#5ddcf9;border-radius:50%;color:#000000;width:46px;height:46px;opacity:0.9;text-align:center">
                  <p style="font-size:20px;font-weight:bold;margin:6px 0px 0px;padding:0px;line-height:20px">{{discountShirts[index]}}</p>
                  <p style="font-size:10px;font-weight:bold;margin:0px;padding:0px;line-height:12px">% OFF</p>
              </div>
              <f7-block style="color:gray;font-size:14px;font-weight:bold;padding:8px">
                <p class="mpzero lineclampin">
                <span v-show="result.specialDiscount == false" style="color:#000000;font-size:17px">&#8377;{{result.selling_price}}</span>
                <span v-show="result.specialDiscount == true" style="color:#000000;font-size:17px;text-decoration:line-through;margin-left:0px">&#8377;{{result.selling_price}}</span>
                <span style="text-decoration:line-through;margin-left:3px">&#8377;{{result.mrp_price}}</span></p>
                <p class="mpzero lineclampin" style="margin-top:6px">
                <img src="../assets/shop_icon.png" style="width:24px;height:24px;border-radius:50%;vertical-align: middle;" alt="Shops">&nbsp {{result.shop_name}}</p>
              </f7-block>
            </f7-card>
          </f7-link>
        </template>
      </div>
    </f7-block>
    <f7-block style="background-color:white;padding:18px 10px 0px 0px;margin:0px">
      <f7-row style="margin-bottom:1em">
        <f7-col style="height:90px">
            <f7-link class="link external" href="https://play.google.com/store/apps/details?id=com.shoping_search_engine.fashiostreet&hl=en_US" style="height:100%"><img src="../assets/featurebanner7.png" style="width:100%;height:100%;border-radius:0px 50px 50px 0px" alt="Rate us now"></f7-link>
        </f7-col>
       </f7-row>
    </f7-block> 
    <f7-block style="background-color:white;padding:0px;margin:28px 0px 10px 10px;border:1px solid gray;border-right:0px;border-radius:30px 0px 0px 30px">
      <div style="padding:22px 16px 22px 20px">
        <div style="display:inline-block;height:30px">
          <img src="../assets/chappal_icon.png" style="width:30px;height:30px;border-radius:50%;vertical-align: middle;" alt="Mens Chappals">
        </div>
        <div style="font-weight:bold;color:#000000;font-size:18px;display:inline-block;vertical-align: middle;" class="mpzero">&nbsp Mens Chappals</div>
        <f7-link style="font-weight:bold;color:#1d2671;font-size:16px;margin-top:2px;float:right" class="mpzero" @click="savebanner('Footwear','Men footwear','Chappals',$f7router,'/products/')" href="javascript:void(0)">See all</f7-link>
      </div>
      <div style="overflow-x:scroll;overflow-y:hidden;white-space:nowrap;padding:0px 0px 18px 13px;margin-left:2px">
        <template v-for="(result,index) in mensChappals">
          <f7-link :key="index" :href="'/productdetails/' + result.id + '/' + result.name" style="width:162px;height:46vh;margin:0px 3px" @click="saveid(result.id)">
            <f7-card style="width:100%;height:100%;margin:0px;padding:0px;-webkit-box-shadow: none;box-shadow: none">
              <div class="image_viewer" style="width: 100%;height:34vh;">
                <img :src="result.image[0]" style="width:100%;height:100%;margin:0px;object-fit: contain">
                <div v-show="result.specialDiscount == true" style="max-width:120px;position:absolute;z-index:99;bottom:84px;left:0px;background-image: linear-gradient(to right, #8E2DE2, #4A00E0);color:#FFFFFF;border-radius:0px 30px 30px 0px;font-size:16px;font-weight:bold;padding:3px 8px">
                  <p class="mpzero lineclampin" style="font-size:16px">&#8377;{{result.specialDiscountedPrice}}<span style="font-size:12px;line-height:17px;height:17px"> - {{result.offers}}</span></p>
                </div>
              </div>
              <div style="position:absolute;top:10px;left:10px;z-index:99;background-color:#5ddcf9;border-radius:50%;color:#000000;width:46px;height:46px;opacity:0.9;text-align:center">
                  <p style="font-size:20px;font-weight:bold;margin:6px 0px 0px;padding:0px;line-height:20px">{{discountChappals[index]}}</p>
                  <p style="font-size:10px;font-weight:bold;margin:0px;padding:0px;line-height:12px">% OFF</p>
              </div>
              <f7-block style="color:gray;font-size:14px;font-weight:bold;padding:8px">
                <p class="mpzero lineclampin">
                <span v-show="result.specialDiscount == false" style="color:#000000;font-size:17px">&#8377;{{result.selling_price}}</span>
                <span v-show="result.specialDiscount == true" style="color:#000000;font-size:17px;text-decoration:line-through;margin-left:0px">&#8377;{{result.selling_price}}</span>
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
    <f7-sheet ref="sizesheet1" class="sizesheet1" style="height:auto;text-align:center;border-radius:30px 30px 0px 0px">
      <h4 style="font-weight:bold;color:#000000;font-size:18px;text-align:left;padding:22px 20px" class="mpzero">FS Cashback offer</h4>
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
      <f7-button @click="sheetClose" fill big style="background-image: linear-gradient(to right, #11998e, #38ef7d);color:#FFFFFF;font-size:18px;font-weight:bold;border:0px;margin:10px;margin-top:20px;text-transform:capitalize;border-radius:30px">Got It &nbsp👍</f7-button>
    </f7-sheet>
    <f7-sheet ref="sizesheet2" class="sizesheet2" style="height:auto;border-radius:30px 30px 0px 0px">
      <h4 style="font-weight:bold;color:#000000;font-size:18px;text-align:left;padding:16px" class="mpzero">😍 SUPER30 Promocode offer</h4>
      <div style="margin:4px 16px;margin-bottom:0px"><img src="../assets/featurebanner3.png" style="width:100%;height:90px;border-radius:5px" alt="SUPER30 Offer"></div>
      <p style="color:#323232;font-size:15px;font-weight:bold;margin:0px;padding:16px 16px 0px;text-align:left">🛍️ Apply Promocode - SUPER30 in Hd cart to Get Flat 30% OFF on First 2 orders(Upto &#8377;50)<br>[ONLY FOR FIRST 200 ORDERS FROM KOLHAPUR]</p>
      <f7-button fill big @click="sheetClose1" style="background-image: linear-gradient(to right, #11998e, #38ef7d);color:#FFFFFF;font-size:18px;font-weight:bold;border:0px;margin:10px;margin-top:20px;text-transform:capitalize;border-radius:30px">Got It &nbsp👍</f7-button>
    </f7-sheet>
    <f7-sheet ref="sizesheet3" class="sizesheet3" style="height:auto;border-radius:30px 30px 0px 0px">
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
      <f7-button @click="sheetClose2" fill big style="background-image: linear-gradient(to right, #11998e, #38ef7d);color:#FFFFFF;font-size:18px;font-weight:bold;border:0px;margin:10px;margin-top:20px;text-transform:capitalize;border-radius:30px">Got It &nbsp👍</f7-button>
    </f7-sheet>
    </div>
    <f7-sheet ref="sizesheet4" style="height:auto;border-radius:30px 30px 0px 0px">
          <f7-block-title style="margin:0px;padding:22px 15px 5px 20px;font-size:16px;font-weight:bold;line-height:20px;color:#000000">Please give your valuable feedback</f7-block-title>
          <f7-block style="margin:0px;padding:0px 4px">
            <f7-list form no-hairlines-md style="margin:0px;color:#000000">
            <f7-list-item>
                <h5 style="color:red;text-transform:uppercase;margin:0px">{{feedbackerror}}</h5>
                <f7-label floating>Start writing ...</f7-label>
                <f7-input type="textarea" @input="feedback = $event.target.value" clear-button></f7-input>
            </f7-list-item>
            </f7-list>
            <p style="margin:0px;padding:8px 20px 5px 20px;font-size:14px">Thank you in advance to help us improve.</p>
            <f7-button @click="closeFeedback" fill big  style="background-image: linear-gradient(to right, #11998e, #38ef7d);color:#FFFFFF;font-size:18px;font-weight:bold;border:0px;margin:10px;margin-top:20px;text-transform:capitalize;border-radius:30px">Submit <f7-icon f7="chevron_right" style="margin:-5px 0px 0px 10px"></f7-icon></f7-button>
          </f7-block>
    </f7-sheet>
    <f7-sheet ref="refersheet" style="height:auto;border-radius:30px 30px 0px 0px" v-show="checkReferSheet==true">
        <f7-block-title style="margin:0px;padding:26px 20px 15px 20px;font-size:18px;font-weight:bold;color:#000000">Refer & earn ₹30</f7-block-title>
          <f7-block style="margin:0px;padding:0px 5px;font-size:16px">
            <p style="margin:16px">Refer your friends and earn ₹30 for each refer when they register by using your refer code.</p>
            <p style="margin:16px">Your mobile number is your refer code.</p>
            <f7-button @click="closeReferSheet" actions-open="#referOptions" fill big  style="background-image: linear-gradient(to right, #11998e, #38ef7d);color:#FFFFFF;font-size:18px;font-weight:bold;border:0px;margin:10px;margin-top:20px;text-transform:capitalize;border-radius:30px">Invite Friend <f7-icon f7="chevron_right" style="margin:-5px 0px 0px 10px"></f7-icon></f7-button>
          </f7-block>
    </f7-sheet>
    <f7-actions id="referOptions" style="height:auto;border-radius:30px 30px 0px 0px">
      <f7-actions-group>
        <f7-actions-label style="margin:0px;padding:26px 20px 15px 20px;font-size:18px;font-weight:bold;color:#000000">Invite friend using</f7-actions-label>
        <div style="padding:10px 20px">
          <f7-button class="link external" :href="'sms:?body=I recommend you to download Fashiostreet app and enjoy shopping from different shops of your city from home. Get Rs.20 cashback by using refer code-'+this.loginmobile+' at the time of login. Download Link- http://bit.ly/fashiostreet-app'" style="color:#212121;text-transform:capitalize;font-size:16px;text-align:left;margin-bottom:16px"><f7-icon f7="email" style="padding-right:16px"></f7-icon>Text message</f7-button>
          <f7-button class="link external" :href="'https://wa.me/?text=I%20recommend%20you%20to%20download%20Fashiostreet%20app%20and%20enjoy%20shopping%20from%20different%20shops%20of%20your%20city%20from%20home.%20Get%20Rs.20%20cashback%20by%20using%20refer%20code-'+this.loginmobile+'%20at%20the%20time%20of%20login.%20Download%20Link-%20http://bit.ly/fashiostreet-app'" style="color:#212121;text-transform:capitalize;font-size:16px;text-align:left"><img src="../assets/whatsapp-logo.svg" alt="chat with shopkeeper"><div style="display:inline-block;padding-left:16px;position: relative;bottom:5px">Whatsapp</div></f7-button>
        </div>
      </f7-actions-group>
      <f7-actions-group>
        <f7-actions-button color="red" style="padding:0px 20px">Later ( Cancel )</f7-actions-button>
      </f7-actions-group>
    </f7-actions>
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
      slogans: ['FREE HOME DELIVERY UPTO 10 KM','CASH ON DELIVERY UPTO 10 KM','SHOPPING FROM ALL SHOPS'],
      slogan: 'Free Home Delivery Upto 10 Km',
      shops:[],
      cartinfo:[],
      images:[],
      internet:null,
      city:null,
      refermobile:null,
      refermobileerror:null,
      checkReferSheet:false,
      showPreloader:true,
      loadHomePage:true,
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
      otpError:null,
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
      checkRefer:false,
      activateRefer:false,
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
      specialDiscountTrending:[],
      specialDiscountInnerwear:[],
      specialDiscountKurtis:[],
      specialDiscountShoes:[],
      loginmobile:localStorage.getItem('loginmobile'),
      response:null,
      referal:null,
      referalError:null,
      activateCashback:false,
      appVersion:null,
      shopOfferBanners:[],
      feedbackButton:true,
      performance:["10","9","8","7","6","5","4","3","2","1"],
      variety:["10","9","8","7","6","5","4","3","2","1"],
      aboutus:["Yes","No","Maybe"],
      hear:["Search results","Friend told you","Facebook & Instagram","Other"],
      activePerformanceId:null,
      activeVarietyId:null,
      activeAboutusId:null,
      selectedPerformance:null,
      selectedVariety:null,
      selectedAboutus:null,
      selectedHear:null
    };
  },
   created(){

     this.getCart();
     this.getAppVersion();
    setInterval(() => {

     this.openPopup();

  }, 0)
    setInterval(() => {

     this.activate1();
     //alert(this.slogan);
  }, 1)
 }
  ,
  mounted()
  {
    //this.activate();
        this.mobile = localStorage.getItem('loginmobile');

    this.city=localStorage.getItem("city");
    this.showPreloader = true;
    this.getShopOffersBanners();
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
        console.log(this.trending[0].offers[0]);
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
          if(this.trending[i].specialDiscount == true)
          {
            this.discountTrending[i] = this.trending[i].specialDiscountedPercentage;
            this.trending[i].offers = this.trending[i].offers[0];
          }
        }
        this.shops = response.data.result.shops;
        this.images = response.data.result.images;
        console.log(this.images);
      },(error) => {
          //alert('failed to load home page,please restart your app');
      });
  },
components: {
    offline
  },
  methods:{
    getAppVersion()
    {
      axios({
        method:'GET',
        url : 'getAppVersion'
      }).then(response => {
        this.appVersion = response.data.result; 
        console.log(this.appVersion);
      },(error) => {
        alert(error.response.data.message);
      });
    },
    setActivePerformanceId(index)
    {
      this.activePerformanceId = index;
      this.selectedPerformance = this.performance[index];
      if(this.selectedVariety!=null && this.selectedAboutus!=null && this.selectedHear!=null)
      {
        this.feedbackButton = false;
      }
    },
    setActiveVarietyId(index)
    {
      this.activeVarietyId = index;
      this.selectedVariety = this.variety[index];
      if(this.selectedPerformance!=null && this.selectedAboutus!=null && this.selectedHear!=null)
      {
        this.feedbackButton = false;
      }
    },
    setActiveAboutusId(index)
    {
      this.activeAboutusId = index;
      this.selectedAboutus = this.aboutus[index];
      if(this.selectedVariety!=null && this.selectedPerformance!=null && this.selectedHear!=null)
      {
        this.feedbackButton = false;
      }
    },
    sendFeedback()
    {
      axios({
              method: 'POST',
              url: 'feedback',
              data: {
                mobile: this.mobile,
                performance : this.selectedPerformance,
                variety:this.selectedVariety,
                hear:this.selectedHear,
                aboutus:this.selectedAboutus,
                improve:this.feedback
              }
            }).then(response => {
              const self = this;
              self.notificationWithButton = self.$f7.notification.create({
                icon: '',
                title: '',
                cssClass:'color1',
                subtitle: 'Thanks for giving valuable feedback',
                text: ''
              });
              self.notificationWithButton.open();
              setTimeout(()=>{
                this.closepop();
              },2000);
            }, (error) => {
              if (error.response.data.message != undefined) {
                alert(error.response.data.message);
              }
              else {
                alert('connection error found,please retry again');
              }
            }
          ); 
    },
    getShopOffersBanners()
    {
      axios({
        method:'GET',
        url : '/shop/shopOffers/'+localStorage.getItem('city'),
      }).then(response => {
        this.shopOfferBanners = response.data.result; 
        console.log(this.shopOfferBanners);
      },(error) => {
        alert(error.response.data.message);
      });
    },
    closeReferSheet()
    {
      this.$refs.refersheet.close();
    },
    openSheetRefer()
    {
      this.checkReferSheet = true;
      this.$refs.refersheet.open();
      this.refermobile = null;
      this.refermobileerror = null;
    },
    sendReferMsg()
    {
      if(this.refermobile==null || this.refermobile=='' || this.refermobile.length!=10)
      {
        this.refermobileerror = 'Enter valid mobile number';
      }
      else
      {
        axios({
              method: 'POST',
              url: 'sendReferalMsg',
              data: {mobile:this.mobile,refermobile:this.refermobile}
            }).then(response => {
              console.log(response);
              this.checkReferSheet = false;
              this.$refs.refersheet.close();
              this.refermobile = null;
              const self = this;
              self.notificationWithButton = self.$f7.notification.create({
                icon: '',
                title: '',
                cssClass:'color1',
                subtitle: 'Referal send successfully',
                text: ''
              });
              self.notificationWithButton.open();
              setTimeout(()=>{
                this.closepop();
              },2000);
              this.refermobile = null;
            }, (error) => {
              if (error.response.data.message != undefined) {
                this.referalmobileerror = error.response.data.message;
              }
              else {
                alert('connection error found,please retry again');
              }
            }
          );
      }
      this.refermobile = null;
      this.referalmobileerror = null;
    },
    cancelRefer()
    {
      localStorage.setItem('token', this.response.data.result);
      localStorage.setItem('local_id', this.response.data.result);
      localStorage.setItem('loginmobile', this.mobile);
      this.loadHomePage = true;
      location.reload();
      this.loadHomePage = false;
    },
    selectRefer()
    {
      this.activateRefer = true;
    },
    openHomePage()
    {
      localStorage.setItem('token', this.response.data.result);
      localStorage.setItem('local_id', this.response.data.result);
      localStorage.setItem('loginmobile', this.mobile);
      this.loadHomePage = true;
      location.reload();
      this.loadHomePage = false;
    },
    getCashback()
    {
      if(this.referal==null || this.referal=='' || this.referal.length!=10)
      {
        this.referalError = "Enter valid referal mobile number";
      }
      else
      {
        axios({
              method: 'POST',
              url: 'sendReferal',
              data: {referal: this.referal,mobile:this.mobile}
            }).then(response => {
              //alert(response.data.result);
              this.activateRefer = false;
              this.activateCashback = true;
            }, (error) => {
              if (error.response.data.message != undefined) {
                this.referalError = error.response.data.message;
              }
              else {
                alert('connection error found,please retry again');
              }
            }
          );
      }
    },
    login()
    {
      if(this.btn_text=='Get OTP')
      {
        if(this.mobile==null || this.mobile=='' || this.mobile.length!=10)
        {
          this.mobileError = 'Enter valid phone number';
        }
        else
        {
          const self = this;
          self.$f7.dialog.preloader('Sending OTP');
          this.btn_text = 'Get Started';
          this.mobileCheck = true;
          this.mobileError = null;
          axios({
              method: 'POST',
              url: 'api/auth/sendOtp',
              data: {mobile: this.mobile}
            }).then(response => {
              this.otpSend = 'OTP sent to your mobile number';
              this.userStatus = response.data.result;
              setTimeout(() => {
                self.$f7.dialog.close();
              }, 1000);
              this.otpError = null;
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
        this.mobileError = '';
        const self = this;
        //self.$f7.dialog.preloader('Entering Local World');
          axios({
              method: 'POST',
              url: 'api/auth/checkOtp',
              data: {mobile: this.mobile, code: this.otp}
            }).then(response => {
              if(this.userStatus == 'new')
              {
                this.checkRefer = true;
                this.response = response;
              } 
              else
              {
                localStorage.setItem('token', response.data.result);
                localStorage.setItem('local_id', response.data.result);
                localStorage.setItem('loginmobile', this.mobile);
                this.loadHomePage = true;
                location.reload();
                this.loadHomePage = false;
              }
            }, (error) => {
              this.otpSend = null;
              if (error.response.data.message != undefined) {
                this.otpError = error.response.data.message;
                //self.$f7.dialog.close();
              }
              else {
                alert('connection error found,please retry again');
              }
            }
          );
      } 
    },
    changeNumber()
    {
      this.btn_text = 'Get OTP';
      this.mobileCheck = false;
      this.mobileError = null;
      this.otp = null;
    },
    resendOtp()
    {
      axios({
              method: 'POST',
              url: 'api/auth/sendOtp',
              data: {mobile: this.mobile}
            }).then(response => {
              this.otpError = null;
              this.otpSend = 'OTP Resent to your mobile number';
            }, (error) => {
              if (error.response.data.message != undefined) {
                this.mobileError = error.response.data.message;
              }
              else {
                alert('connection error found,please retry again');
              }
            }
          );
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
          if(this.mensInnerwear[i].specialDiscount == true)
          {
            this.discountInnerwear[i] = this.mensInnerwear[i].specialDiscountedPercentage;
            this.mensInnerwear[i].offers = this.mensInnerwear[i].offers[0];
          }
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
          if(this.mensTShirts[i].specialDiscount == true)
          {
            this.discountTShirts[i] = this.mensTShirts[i].specialDiscountedPercentage;
            this.mensTShirts[i].offers = this.mensTShirts[i].offers[0];
          }
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
          if(this.mensShirts[i].specialDiscount == true)
          {
            this.discountShirts[i] = this.mensShirts[i].specialDiscountedPercentage;
            this.mensShirts[i].offers = this.mensShirts[i].offers[0];
          }
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
          if(this.mensJeans[i].specialDiscount == true)
          {
            this.discountJeans[i] = this.mensJeans[i].specialDiscountedPercentage;
            this.mensJeans[i].offers = this.mensJeans[i].offers[0];
          }
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
          if(this.mensChappals[i].specialDiscount == true)
          {
            this.mensChappals[i].offers = this.mensChappals[i].offers[0];
            this.discountChappals[i] = this.mensChappals[i].specialDiscountedPercentage;
          }
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
          if(this.mensSandals[i].specialDiscount == true)
          {
            this.discountSandals[i] = this.mensSandals[i].specialDiscountedPercentage;
            this.mensSandals[i].offers = this.mensSandals[i].offers[0];
          }
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
          if(this.mensCasualShoes[i].specialDiscount == true)
          {
            this.discountShoes[i] = this.mensCasualShoes[i].specialDiscountedPercentage;
            this.mensCasualShoes[i].offers = this.mensCasualShoes[i].offers[0];
          }
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
          this.slogan = 'Free Home Delivery Upto 10 Km';
          this.s1=false;
          this.s2=true;
          this.s3=false;
        }
        else if(this.s2==true)
        {
          this.slogan = 'Cash On Delivery Upto 10 Km';
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
      }).catch(error => {
        console.log(error);
        if(error.response.data.message != undefined)
          alert(error.response.data.message);
        else
          alert('Something went wrong,please try again');
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
      //alert(index);
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
.md .navbar:after{
  content:none
}
.lineclampin{
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    width: 100%;
}
.performance_selector_active{
    background-color:#273657 !important;
    color:#00FF96;
  }
.variety_selector_active{
    background-color:#273657 !important;
    color:#00FF96;
  }
.aboutus_selector_active{
    background-color:#273657 !important;
    color:#00FF96;
  }
.sa-icon {
    width: 80px;
    height: 80px;
    border: 4px solid gray;
    -webkit-border-radius: 40px;
    border-radius: 40px;
    border-radius: 50%;
    margin: 20px auto;
    padding: 0;
    position: relative;
    box-sizing: content-box;
  }

  .sa-icon.sa-success {
    border-color: #4CAF50;
  }

  .sa-icon.sa-success::before, .sa-icon.sa-success::after {
    content: '';
    -webkit-border-radius: 40px;
    border-radius: 40px;
    border-radius: 50%;
    position: absolute;
    width: 74px;
    height: 120px;
    background: white;
    -webkit-transform: rotate(45deg);
    transform: rotate(45deg);
  }

  .sa-icon.sa-success::before {
    -webkit-border-radius: 120px 0 0 120px;
    border-radius: 120px 0 0 120px;
    top: -19px;
    left: -22px;
    -webkit-transform: rotate(-45deg);
    transform: rotate(-45deg);
    -webkit-transform-origin: 60px 60px;
    transform-origin: 60px 60px;
  }

  .sa-icon.sa-success::after {
    -webkit-border-radius: 0 120px 120px 0;
    border-radius: 0 120px 120px 0;
    top: -11px;
    left: 30px;
    -webkit-transform: rotate(-45deg);
    transform: rotate(-45deg);
    -webkit-transform-origin: 0px 60px;
    transform-origin: 0px 60px;
  }

  .sa-icon.sa-success .sa-placeholder {
    width: 80px;
    height: 80px;
    border: 4px solid rgba(76, 175, 80, .5);
    -webkit-border-radius: 40px;
    border-radius: 40px;
    border-radius: 50%;
    box-sizing: content-box;
    position: absolute;
    left: -4px;
    top: -4px;
    z-index: 2;
  }

  .sa-icon.sa-success .sa-fix {
    width: 5px;
    height: 90px;
    background-color: white;
    position: absolute;
    left: 28px;
    top: 8px;
    z-index: 1;
    -webkit-transform: rotate(-45deg);
    transform: rotate(-45deg);
  }

  .sa-icon.sa-success.animate::after {
    -webkit-animation: rotatePlaceholder 4.25s ease-in;
    animation: rotatePlaceholder 4.25s ease-in;
  }

  .sa-icon.sa-success {
    border-color: transparent\9;
  }
  .sa-icon.sa-success .sa-line.sa-tip {
    -ms-transform: rotate(45deg) \9;
  }
  .sa-icon.sa-success .sa-line.sa-long {
    -ms-transform: rotate(-45deg) \9;
  }

  .animateSuccessTip {
    -webkit-animation: animateSuccessTip 0.75s;
    animation: animateSuccessTip 0.75s;
  }

  .animateSuccessLong {
    -webkit-animation: animateSuccessLong 0.75s;
    animation: animateSuccessLong 0.75s;
  }

  @-webkit-keyframes animateSuccessLong {
    0% {
      width: 0;
      right: 46px;
      top: 54px;
    }
    65% {
      width: 0;
      right: 46px;
      top: 54px;
    }
    84% {
      width: 55px;
      right: 0px;
      top: 35px;
    }
    100% {
      width: 47px;
      right: 8px;
      top: 38px;
    }
  }
  @-webkit-keyframes animateSuccessTip {
    0% {
      width: 0;
      left: 1px;
      top: 19px;
    }
    54% {
      width: 0;
      left: 1px;
      top: 19px;
    }
    70% {
      width: 50px;
      left: -8px;
      top: 37px;
    }
    84% {
      width: 17px;
      left: 21px;
      top: 48px;
    }
    100% {
      width: 25px;
      left: 14px;
      top: 45px;
    }
  }
  @keyframes animateSuccessTip {
    0% {
      width: 0;
      left: 1px;
      top: 19px;
    }
    54% {
      width: 0;
      left: 1px;
      top: 19px;
    }
    70% {
      width: 50px;
      left: -8px;
      top: 37px;
    }
    84% {
      width: 17px;
      left: 21px;
      top: 48px;
    }
    100% {
      width: 25px;
      left: 14px;
      top: 45px;
    }
  }

  @keyframes animateSuccessLong {
    0% {
      width: 0;
      right: 46px;
      top: 54px;
    }
    65% {
      width: 0;
      right: 46px;
      top: 54px;
    }
    84% {
      width: 55px;
      right: 0px;
      top: 35px;
    }
    100% {
      width: 47px;
      right: 8px;
      top: 38px;
    }
  }

  .sa-icon.sa-success .sa-line {
    height: 5px;
    background-color: #4CAF50;
    display: block;
    border-radius: 2px;
    position: absolute;
    z-index: 2;
  }

  .sa-icon.sa-success .sa-line.sa-tip {
    width: 25px;
    left: 14px;
    top: 46px;
    -webkit-transform: rotate(45deg);
    transform: rotate(45deg);
  }

  .sa-icon.sa-success .sa-line.sa-long {
    width: 47px;
    right: 8px;
    top: 38px;
    -webkit-transform: rotate(-45deg);
    transform: rotate(-45deg);
  }

  @-webkit-keyframes rotatePlaceholder {
    0% {
      transform: rotate(-45deg);
      -webkit-transform: rotate(-45deg);
    }
    5% {
      transform: rotate(-45deg);
      -webkit-transform: rotate(-45deg);
    }
    12% {
      transform: rotate(-405deg);
      -webkit-transform: rotate(-405deg);
    }
    100% {
      transform: rotate(-405deg);
      -webkit-transform: rotate(-405deg);
    }
  }
  @keyframes rotatePlaceholder {
    0% {
      transform: rotate(-45deg);
      -webkit-transform: rotate(-45deg);
    }
    5% {
      transform: rotate(-45deg);
      -webkit-transform: rotate(-45deg);
    }
    12% {
      transform: rotate(-405deg);
      -webkit-transform: rotate(-405deg);
    }
    100% {
      transform: rotate(-405deg);
      -webkit-transform: rotate(-405deg);
    }
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
