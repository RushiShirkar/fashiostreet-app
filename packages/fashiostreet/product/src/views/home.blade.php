<!DOCTYPE html>
<html lang="en-in">
<head>
    <title>Online Local Comparison Shopping - Fashiostreet</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="Keywords" content="online shopping, local shopping, home delivery, fashion shopping, online shopping site, local shopping search engine, fs, fashionstreet, fashiostreet, clothing, watches, footwear"/>
    <meta name="Description" content="Local Shopping Search Engine for fashion and lifestyle in india. Get Free Home Delivery from your city's local shop. Buy clothing, shoes, watches, accessories for women & men. Best local online fashion store * COD * FREE HOME DELIVERY * TRY & BUY Feature"/>
    <link rel="canonical" href="https://www.fashiostreet.com"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="DC.title" content="Fashiostreet" />
    <meta name="geo.region" content="IN-MH" />
    <meta name="google-play-app" content="app-id=com.shoping_search_engine.fashiostreet.app"/>
    <link rel="shortcut icon" href="{{ asset('assets/img/fs_icon.png') }}">
    <!-- Core css bootstrap.min.css -->
    <link href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Core css bootstrap.min.css -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Google Fonts StyleSheet -->
    <link href="https://fonts.googleapis.com/css?family=Lato|Roboto|Source+Sans+Pro" rel="stylesheet">
    <!-- Google Fonts StyleSheet -->
    <!-- Custom StyleSheet -->
    <link rel="stylesheet" href="{{ asset('assets/css/StyleSheet.css') }}">
    <!-- Custom StyleSheet -->
    <style type="text/css">
        body{
            background-color: #263238;
        }
        .drp{
            position:absolute;
            right:40px;
            margin-top:10px;
            font-size:18px;
        }
        .drp a
        {
            text-decoration: none;
            color:white;
        }
        .container-fluid
        {
            background-color:#FFFFFF;
            /* background: #CB356B;  /* fallback for old browsers */
        }
        #suggestion_div div a{
            display: block;
            text-decoration: none;
            color:black;
            padding:5px 5%;
        }
        #suggestion_div div a:hover{
            color:darkorange;
        }
        #suggestion_div div:hover{
            background-color: rgb(245,245,245);
        }
        .triangle{
    border-style: solid;
    border-width: 9px;
    border-color: transparent;
    border-top-width: 0;
    border-bottom: 9px solid #FFFFFF;
    width: 0;
    height: 0;
    font-size: 0;
    line-height: 0;
    position: absolute;
    top: -9px;
}
.cat-profile_content{
  display: none;
  position: absolute;
  background-color: #FFFFFF;
  min-width:170px;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
  right: 0px;
  border-radius:2px;
  margin-top: 40px;
}
.cat-profile_content ul{
  padding: 10px;
  margin: 0px
}
.cat-profile_content li {
  color: black;
  padding: 8px 5px;
  text-decoration: none;
  display: block;
}
.cat-profile_content li a {
  color: gray;
  text-decoration: none;
  display: block;
}
.cat-profile_content li a:hover{
  color: black;
}
.cat-profile:hover .cat-profile_content{
  display: block !important;
}
.cat-sign_btn{
  background-color:gray;
  display: block;
  color: #FFFFFF !important;
  padding:8px 0px;
}
input[type=number]::-webkit-inner-spin-button, 
input[type=number]::-webkit-outer-spin-button { 
  -webkit-appearance: none; 
}

input[type=number] {
  -moz-appearance: textfield;
}
    </style>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-120362424-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-120362424-1');
    </script>
    <script type="application/ld+json">
{
  "@context": "http://schema.org",
  "@type": "Organization",
  "name" : "Fashiostreet",
  "url": "https://www.fashiostreet.com",
  "logo": "https://www.fashiostreet.com/assets/img/fashiostreet_logo.png",
  "description": "Fashiostreet is local shopping search where people can find best fashion products like clothing, footwear, watches and accessories from their city and get free home delivery with TRY & BUY Feature available where they can order 3 products they like and try instantly when delivered & then buy the only products they liked",
  "contactPoint": [{
    "@type": "ContactPoint",
    "telephone": "+91 8600198512",
    "contactType": "customer service",
    "areaServed": "India",
    "availableLanguage": [
      "English",
      "Hindi",
      "Marathi"
    ]
  }],
  "sameAs" : [
                "https://www.facebook.com/fashiostreet/",
                "https://www.instagram.com/fashiostreet_official/",
                "https://www.linkedin.com/company/fashiostreet/",
                "https://plus.google.com/u/0/105052627957777439787/"
              ],
  "foundingDate":"2018-02-30",
  "founder":"Amit Ithape, Manoj Nerkar"
}
</script>
</head>
<body>
<div class="container-fluid home_section1-main">
   <div class="home_section1">
     <div class="row">
      <div class="col-md-6 col-sm-6 col-xs-6">
        <a href="#"><img src={{ asset('assets/img/fashiostreet.png') }} class="img-responsive" style="border-radius: 3px"></a>
      </div>
      <div class="col-md-6 col-sm-6 col-xs-6">
        <a href="https://play.google.com/store/apps/details?id=com.shoping_search_engine.fashiostreet" target="_blank" class="download-app_btn">DOWNLOAD OUR APP TO ORDER</a>
      </div>
    </div>
    <div class="row">
      <div class="col-md-8 home_headline">
        <div class="home_headline-div">
          Find and compare products and offers from local city shops
        </div>
        <div class="row" style="padding: 0px 10px">
          <input type="number" class="col-md-8 col-sm-8 col-xs-7 city" id="mobile" autocomplete="off" placeholder="Enter Mobile Number" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" type = "number" maxlength = "10" required>
          <button type="button" class="col-md-3 col-sm-3 col-xs-3 btn searchbutton" id="clickButton" style="vertical-align:top;margin-left: -5px">Get App Link</button>
        </div>
        <div style="font-size: 18px;font-weight: 700;padding-top: 20px">
          Right Now In : Kolhapur | Islampur
        </div>
      </div>
      <div class="col-md-4 hidden-sm hidden-xs">
        <img src={{ asset('assets/img/cloth_shops1.png') }} class="img-responsive">
      </div>
    </div>
    </div>
  </div>
  <div class="container-fluid home_section2-main">
      <img src={{ asset('assets/img/appbanner.png') }} class="img-responsive" style="height: 100%;width: 100%">
      <div class="home_section2-div1">
        <div class="home_section2-line1">
          All Local Shops</br>In Your Pocket
        </div>
        <div class="home_section2-line2">
          Compare Products and Offers from local city shops</br>
          and find out best for yourself.
        </div>
        <a href="https://play.google.com/store/apps/details?id=com.shoping_search_engine.fashiostreet" target="_blank"><img src={{ asset('assets/img/google_play.png') }} class="img-responsive google_play-btn"></a>
      </div>
  </div>

<!-- <script defer src="https://code.getmdl.io/1.3.0/material.min.js"></script> -->
<!-- Core js bootstrap.min.js  -->
<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/bootstrap/js/bootstrap.min.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function(){
      $('#clickButton').click(function(){
        if($('#mobile').val()!='' && $('#mobile').val()!=null && $('#mobile').val().length==10)
        {
          $.ajax({
            type: 'POST',
            url: '/getAppLink',
            dataType: 'json',
            data: {
              mobile : $('#mobile').val()
            },
            success: function (response) {
              alert(response); 
              $('#mobile').val('');
            },
            error: function (request, status, error) {
              alert(error); 
            }
          });
        }
        else
        {
          alert('Enter Valid 10 digit Mobile Number'); 
          $('#mobile').val('');
        }
      });
    });
</script>
</body>
</html>
