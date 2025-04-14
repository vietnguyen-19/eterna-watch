<!-- Messenger Plugin chat Code -->
<div id="fb-root"></div>

<!-- Your Chat Plugin code -->
<div id="fb-customer-chat" class="fb-customerchat"></div>

<script>
  var chatbox = document.getElementById('fb-customer-chat');
  chatbox.setAttribute("page_id", "61574947422568"); // ← Thay YOUR_PAGE_ID bằng ID trang của bạn
  chatbox.setAttribute("attribution", "biz_inbox");
</script>

<script>
  window.fbAsyncInit = function () {
    FB.init({
      xfbml: true,
      version: 'v19.0' // ← phiên bản API có thể thay đổi
    });
  };

  (function (d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = 'https://connect.facebook.net/vi_VN/sdk/xfbml.customerchat.js';
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));
</script>
