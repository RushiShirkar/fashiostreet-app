<template>
  <f7-page class="bgpage" name="notice">
    <f7-navbar class="bgnav" sliding>
      <f7-nav-left>
        <f7-link icon-f7="icon-bars" panel-open="left"></f7-link>
      </f7-nav-left>
      <f7-nav-title>
        Notice Board
      </f7-nav-title>
    </f7-navbar>
    <!-- Scrollable page content-->
    <f7-block-title>{{ title }}</f7-block-title>
    <f7-block inner>
     <div class="card">
  <div class="card-header">Message Title</div>
  <div class="card-content card-content-padding">Message Content Here... dxbvkjdbcjvbajvbkjasbvkjabs kjvbsakjbvksajbcvkjasbckjsackjbasckjsb</div>
</div>
    </f7-block>

  </f7-page>
</template>

<script>
export default {
  name: 'Notice Board',
  data() {
    return {
      title: '15/06/2018  11:40 AM'
    };
  }
};
</script>