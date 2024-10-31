<!-- Enqueue scripts for chatbox - wordpress popup -->

<div class="wrap">
  <h1 class="wp-heading-inline">Omni ChatBox Setting</h1>

  <div>
    <form id="chatbot_update_form">      
      <div class="row">        
        <div class="el-wrap">
          <label for="title">Omni ChatBox Chat ID</label>
          <input type="text" name="projectKey" id="projectKey" value="" request/>
        </div>        
      </div>      
      <div class="row btns">
        <input type="submit" name="btnGenerateShortcode" id="btnGenerateShortcode" class="button button-primary" value="Generate ShortCode">
      </div>
      <div class="row">
        <div class="shortcode-container">
          Copy and paste the shortcode generated below into a page, post or widget.
          <div class="shortcode" id="shortcode">[omni-chatbox id="chatId"]</div>
        </div>
      </div>
    </form>
  </div>
</div>
