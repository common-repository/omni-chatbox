jQuery(document).ready(function($) {

  // submit Button Clicked
  $('#btnGenerateShortcode').click(function(e) {

    e.preventDefault();

    var projectid = $('#projectKey').val();
    //check the chat id is valid
    if( projectid != ""){
      var shortcode = "[omni-chatbox id=" + projectid + "]";
      $('#shortcode').html(shortcode);
    }
  });
});
