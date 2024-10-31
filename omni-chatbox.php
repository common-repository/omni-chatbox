<?php
/**
 * @package OmniChatBox
 */
/*
Plugin Name: Omni ChatBox
Plugin URI:
Description: Omni ChatBox Plugin 
Version: 1.0.0
Author: omnilegion
Author URI: http://omnilegion.com/
License: GPLv2
Text-Domain: http://www.gnu.org/licenses/gpl-2.0.html
*/

defined( 'ABSPATH' ) or die( 'Hey, you can\t access this file, you silly human!' );

class OmniChatBox
{
  private $userData;
  private $attributes;
  /**
   * Construct
   */
  function __construct()
  {
    //init Attributes
    $this->initAttributes();

    // Add admin menu
    add_action('admin_menu', array($this, 'addAdminMenu'));

    // Register style sheet
    add_action( 'admin_enqueue_scripts', array($this, 'register_omni_chatbox_styles') );

    // Load Style
    add_action( 'admin_enqueue_scripts', array($this, 'load_omni_chatbox_style') );

    // Load script files
    add_action( 'admin_enqueue_scripts', array($this, 'load_omni_chatbox_scripts') );

    // Load Client JS/CSS
    add_action( 'wp_enqueue_scripts', array($this, 'register_client_chatbox_css') );
    add_action( 'wp_enqueue_scripts', array($this, 'register_client_chatbox_js') );

    // Add Shortcode
    add_shortcode('omni-chatbox', array($this, 'addOmniLegionChatBoxShortcode'));
  }

  /**
   * Init Class Values
    */
  function initAttributes(){
    $this->attributes = ['orgName','apiGatewayEndpoint','contactFlowId', 'instanceId','aws_region', 'inUserName','outUserName'];
  }
  /**
   * Activation
   */
  function activate()
  {
    // Get User Data
    $this->userData = get_userdata( get_current_user_id() );    

    // flush rewrite rules
    flush_rewrite_rules();
  }

  /**
   * Deactivation
   */
  function deactivate()
  {
    // flush rewrite rules
    flush_rewrite_rules();
  }

  /**
   * Add admin menu
   */
  function addAdminMenu()
  {
    add_menu_page(
			__( 'Omni ChatBox', 'omni-chatbox' ),
			__( 'Omni ChatBox', 'omni-chatbox' ),
			'manage_options',
			'omni-dashboard-page',
			array($this, 'omniAdminPageContents'),
			'dashicons-format-chat',
			3
    );
  }

  /**
   * Load Admin Page Contents
   */
  function omniAdminPageContents()
  {
    include 'view/omni-dashboard.php';
  }

  /**
   * Register Styles
   */
  function register_omni_chatbox_styles()
  {
    wp_register_style( 'omni-chatbox', plugins_url( 'omni-chatbox/css/admin.css' ) );
    wp_register_script( 'omni-chatbox', plugins_url( 'omni-chatbox/js/admin.js' ) );
  }

  function register_client_chatbox_css(){
    wp_register_style( 'chatbox-client-css', plugins_url( 'omni-chatbox/css/chatbox.css' ) );
  }

  function register_client_chatbox_js(){
    wp_register_script( 'chatbox-client-js', plugins_url( 'omni-chatbox/js/chatbox.js' ) );
  }

  /**
   * Load Registerred Styles
   */
  function load_omni_chatbox_style($hook)
  {
    // Load only on ?page=mypluginname
    if( $hook != 'toplevel_page_omni-dashboard-page' ) {
      return;
    }

    // Load style
    wp_enqueue_style( 'omni-chatbox' );
  }

  /**
   * Load Script
   */
  function load_omni_chatbox_scripts($hook)
  {
    // Load only on ?page=mypluginname
    if( $hook != 'toplevel_page_omni-dashboard-page' ) {
      return;
    }

    $localize = array(
      'ajaxurl' => admin_url( 'admin-ajax.php' )
    );
    wp_enqueue_script('omni-chatbox', array('jquery'));
    wp_localize_script( 'omni-chatbox', 'omni_script', $localize);
  }


  /**
   * Add ShortCode for addOmniLegionChatchatboxShortcode
   * @param: CourtID
   */
  function addOmniLegionChatBoxShortcode( $atts = [], $content = null, $tag = '' ) {
    
    wp_enqueue_style('chatbox-client-css');
    wp_enqueue_script('chatbox-client-js');

    // normalize attribute keys, lowercase
    $atts = array_change_key_case((array)$atts, CASE_LOWER);

    // override default attributes with user attributes
    $wporg_atts = shortcode_atts([
                                    'id' => '12345678',
                                 ], $atts, $tag);
    
    wp_add_inline_script('chatbox-client-js', 'var omniChatBox = new Omni.MainChat("'.$wporg_atts['id'].'");');

    $content = "";
    return $content;
  }
}

if ( class_exists('OmniChatBox') ) {
  $omniChatBox = new OmniChatBox();
}

// Activation Hook
register_activation_hook( __FILE__, array($omniChatBox, 'activate') );

// Deactivation Hook
register_deactivation_hook( __FILE__, array($omniChatBox, 'deactivate') );