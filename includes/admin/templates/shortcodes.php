<?php
defined('ABSPATH') or die('No script kiddies please!');
?>

<div class="dr-aspage-panel-group" style="">
  <div class="dr-aspage-panel-group-header">
    <h3>Conditional Processing Shortcodes</h3>
  </div>
  <div class="dr-aspage-panel-group-content">
    <div class="dr-aspage-panel-group-content-grid">
      <div class="dr-aspage-panel-group-content-grid-item-2">
        <h4><em>[dr_conditional_devices show=true devices=""]</em></h4>
        <p>This shortcode will display the content based on current device.
          <br>
          <br><strong>Attributes:</strong>
          <br><strong>show</strong> <em>(show or hide based on the device)</em>
          <br><strong>device</strong> <em>(a device or list of devices ("desktop,mobile,tablet") to match against current device)</em>
        </p>
      </div>
      <div class="dr-aspage-panel-group-content-grid-item-2">
        <h4><em>[dr_conditional_roles show=true roles=""]</em></h4>
        <p>This shortcode will display the content based on current user roles.
          <br>
          <br><strong>Attributes:</strong>
          <br><strong>show</strong> <em>(show or hide based on the device)</em>
          <br><strong>roles</strong> <em>(a role or list of roles to match against current user roles)</em>
        </p>
      </div>
    </div>
  </div>
</div>

<div class="dr-aspage-panel-group" style="">
  <div class="dr-aspage-panel-group-header">
    <h3>Link Shortcodes</h3>
  </div>
  <div class="dr-aspage-panel-group-content">
    <div class="dr-aspage-panel-group-content-grid">
      <div class="dr-aspage-panel-group-content-grid-item-2">
        <h4><em>[dr_menu name="" class=""]</em></h4>
        <p>This shortcode will display the selected menu wrapped in ul.
          <br>
          <br><strong>Attributes:</strong>
          <br><strong>name</strong> <em>(name of the menu to display)</em>
          <br><strong>class</strong> <em>(name of the class used to style the menu)</em>
        </p>
      </div>
      <div class="dr-aspage-panel-group-content-grid-item-2">
        <h4><em>[dr_permalink slug="" title="" target="" class=""]</em></h4>
        <p>This shortcode will display the permalink for any page/post.
          <br>
          <br><strong>Attributes:</strong>
          <br><strong>slug</strong> <em>(permalink slug name)</em>
          <br><strong>title</strong> <em>(title of the link)</em>
          <br><strong>target</strong> <em>(target of the link)</em>
          <br><strong>class</strong> <em>(name of class used to style the link)</em>
        </p>
      </div>
    </div>
  </div>
</div>

<div class="dr-aspage-panel-group" style="">
  <div class="dr-aspage-panel-group-header">
    <h3>Divi Shortcodes</h3>
  </div>
  <div class="dr-aspage-panel-group-content">
    <div class="dr-aspage-panel-group-content-grid">
      <div class="dr-aspage-panel-group-content-grid-item-2">
        <h4><em>[dr_module id=""]</em></h4>
        <p>This shortcode will display any Divi module.
          <br>
          <br><strong>Attributes:</strong>
          <br><strong>id</strong> <em>(id of the module)</em>
        </p>
      </div>
    </div>
  </div>
</div>

<div class="dr-aspage-panel-group" style="">
  <div class="dr-aspage-panel-group-header">
    <h3>User Shortcodes</h3>
  </div>
  <div class="dr-aspage-panel-group-content">
    <div class="dr-aspage-panel-group-content-grid">
      <div class="dr-aspage-panel-group-content-grid-item-2">
        <h4><em>[dr_user_login]</em></h4>
        <p>This shortcode will display user login for the user currently logged in.</p>
      </div>
      <div class="dr-aspage-panel-group-content-grid-item-2">
        <h4><em>[dr_user_id]</em></h4>
        <p>This shortcode will display user id for the user currently logged in.</p>
      </div>
      <div class="dr-aspage-panel-group-content-grid-item-2">
        <h4><em>[dr_user_email]</em></h4>
        <p>This shortcode will display user email for the user currently logged in.</p>
      </div>
      <div class="dr-aspage-panel-group-content-grid-item-2">
        <h4><em>[dr_user_level]</em></h4>
        <p>This shortcode will display user level for the user currently logged in.</p>
      </div>
      <div class="dr-aspage-panel-group-content-grid-item-2">
        <h4><em>[dr_user_firstname]</em></h4>
        <p>This shortcode will display user first name for the user currently logged in.</p>
      </div>
      <div class="dr-aspage-panel-group-content-grid-item-2">
        <h4><em>[dr_user_lastname]</em></h4>
        <p>This shortcode will display user last name for the user currently logged in.</p>
      </div>
      <div class="dr-aspage-panel-group-content-grid-item-2">
        <h4><em>[dr_user_displayname]</em></h4>
        <p>This shortcode will display user display name for the user currently logged in.</p>
      </div>
      <div class="dr-aspage-panel-group-content-grid-item-2">
        <h4><em>[dr_user_roles]</em></h4>
        <p>This shortcode will display user roles for the user currently logged in.</p>
      </div>
      <div class="dr-aspage-panel-group-content-grid-item-2">
        <h4><em>[dr_user_bio]</em></h4>
        <p>This shortcode will display user bio for the user currently logged in.</p>
      </div>
      <div class="dr-aspage-panel-group-content-grid-item-2">
        <h4><em>[dr_user_avatar id=""]</em></h4>
        <p>This shortcode will display any Divi module.
          <br>
          <br><strong>Attributes:</strong>
          <br><strong>size</strong> <em>(size of the avatar)</em>
          <br><strong>class</strong> <em>(name of class used to style the avatar)</em>
          <br><strong>extra_attr</strong> <em>(html attributes to insert in the IMG element)</em>
        </p>
      </div>
    </div>
  </div>
</div>
