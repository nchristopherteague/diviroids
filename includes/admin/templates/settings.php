<?php
defined('ABSPATH') or die('No script kiddies please!');

/**
 * Renders the contents
 *
 * @since 1.0.0
*/
?>

<div class="wrapper">

  <?php do_action($this->hook . '_before_contents'); ?>

  <div class="dr-aspage">

    <form method="post" id="dr-aspage-form" enctype="multipart/form-data">

      <div class="dr-aspage-header">

      </div>

      <div class="dr-aspage-content-container">

        <div class="dr-aspage-content">

          <div class="dr-aspage-content-header">
            <div class="dr-logo">
              <div class="dr-logo-gears"><?php include(DIVIROIDS_PLUGIN_ASSETS_DIR . 'images/logo-gears-animated.svg') ?></div>
              <div class="dr-logo-text">Divi<span class="dr-accent-color">Roids</div>
            </div>
          </div><!-- dr-aspage-content-header -->

          <div class="dr-aspage-tabs-panel-container ui-tabs">
            <ul class="dr-aspage-tabs" role="tablist">
              <li role="tab" tabindex="1" aria-controls="panel-customizations" aria-labelledby="tab-customizations" aria-selected="false">
                <a id="tab-customizations" href="#panel-customizations" class="ui-tabs-anchor" role="presentation" tabindex="-1">Customizations</a>
              </li>
              <li role="tab" tabindex="1" aria-controls="panel-builder" aria-labelledby="tab-builder" aria-selected="false">
                <a id="tab-builder" href="#panel-builder" class="ui-tabs-anchor" role="presentation" tabindex="-1">Builder</a>
              </li>
              <li role="tab" tabindex="2" aria-controls="panel-layouts" aria-labelledby="tab-layouts" aria-selected="false">
                <a id="tab-layouts" href="#panel-layouts" class="ui-tabs-anchor" role="presentation" tabindex="-1">Layouts</a>
              </li>
              <li role="tab" tabindex="2" aria-controls="panel-css" aria-labelledby="tab-css" aria-selected="false">
                <a id="tab-css" href="#panel-css" class="ui-tabs-anchor" role="presentation" tabindex="-1">CSS</a>
              </li>
              <li role="tab" tabindex="3" aria-controls="panel-support" aria-labelledby="tab-support" aria-selected="false">
                <a id="tab-support" href="#panel-support" class="ui-tabs-anchor" role="presentation" tabindex="-1">Support</a>
              </li>
            </ul>
            <ul class="dr-aspage-tabs-action">
              <li tabindex="99">
                <a href="#" id="dr-aspage-link-reset" name="dr-link-reset" class="dr-link-action dr-link-reset" title="Reset Changes"></a>
              </li>
              <li tabindex="98">
                <a href="#" id="dr-aspage-link-save" name="dr-link-save" class="dr-link-action dr-link-save" title="Save Changes"></a>
              </li>
            </ul>
            <div id="panel-customizations" class="dr-aspage-tabs-panel-container ui-tabs ui-tabs-panel" role="tabpanel" aria-labelledby="tab-customizations" aria-expanded="false" aria-hidden="true" style="display: none;">
              <ul class="dr-aspage-tabs-sub" role="tablist">
                <li role="tab" tabindex="1" aria-controls="panel-sub-customizations" aria-labelledby="tab-sub-customizations" aria-selected="false">
                  <a id="tab-sub-customizations" href="#panel-sub-customizations" class="ui-tabs-anchor" role="presentation" tabindex="1">Customizations</a>
                </li>
                <li role="tab" tabindex="2" aria-controls="panel-sub-posttype-customizations" aria-labelledby="tab-sub-posttype-customizations" aria-selected="false">
                  <a id="tab-sub-posttype-customizations" href="#panel-sub-posttype-customizations" class="ui-tabs-anchor" role="presentation" tabindex="2">Post Type Customizations</a>
                </li>
              </ul>
              <div id="panel-sub-customizations" class="dr-aspage-tabs-panel ui-tabs-panel" role="tabpanel" aria-labelledby="tab-sub-customizations" aria-expanded="false" aria-hidden="true" style="display: none;">
                <?php
                  if (array_key_exists("customizations", $this->settings)) {
                      $settings = $this->settings['customizations'];
                      include($this->parent_instance->dir . 'templates/settings-fields.php');
                  }
                ?>
              </div>
              <div id="panel-sub-posttype-customizations" class="dr-aspage-tabs-panel ui-tabs-panel" role="tabpanel" aria-labelledby="tab-sub-posttype-customizations" aria-expanded="false" aria-hidden="true" style="display: none;">
                <?php
                  if (array_key_exists("posttype-customizations", $this->settings)) {
                      $settings = $this->settings['posttype-customizations'];
                      include($this->parent_instance->dir . 'templates/settings-fields.php');
                  }
                ?>
              </div>
            </div>
            <div id="panel-builder" class="dr-aspage-tabs-panel-container ui-tabs ui-tabs-panel" role="tabpanel" aria-labelledby="tab-builder" aria-expanded="false" aria-hidden="true" style="display: none;">
              <ul class="dr-aspage-tabs-sub" role="tablist">
                <li role="tab" tabindex="1" aria-controls="panel-sub-modules" aria-labelledby="tab-sub-modules" aria-selected="false">
                  <a id="tab-sub-modules" href="#panel-sub-modules" class="ui-tabs-anchor" role="presentation" tabindex="1">Modules</a>
                </li>
                <li role="tab" tabindex="2" aria-controls="panel-sub-shortcodes" aria-labelledby="tab-sub-shortcodes" aria-selected="false">
                  <a id="tab-sub-shortcodes" href="#panel-sub-shortcodes" class="ui-tabs-anchor" role="presentation" tabindex="2">Shortcodes</a>
                </li>
              </ul>
              <div id="panel-sub-modules" class="dr-aspage-tabs-panel ui-tabs-panel" role="tabpanel" aria-labelledby="tab-sub-modules" aria-expanded="false" aria-hidden="true" style="display: none;">
                <?php
                  if (array_key_exists("modules", $this->settings)) {
                      $settings = $this->settings['modules'];
                      include($this->parent_instance->dir . 'templates/settings-fields.php');
                  }
                ?>
              </div>
              <div id="panel-sub-shortcodes" class="dr-aspage-tabs-panel ui-tabs-panel" role="tabpanel" aria-labelledby="tab-sub-shortcodes" aria-expanded="false" aria-hidden="true" style="display: none;">
                <?php
                  if (array_key_exists("shortcodes", $this->settings)) {
                      $settings = $this->settings['shortcodes'];
                      include($this->parent_instance->dir . 'templates/settings-fields.php');
                  }
                ?>
              </div>
            </div>
            <div id="panel-layouts" class="dr-aspage-tabs-panel-container ui-tabs ui-tabs-panel" role="tabpanel" aria-labelledby="tab-layouts" aria-expanded="false" aria-hidden="true" style="display: none;">
              <ul class="dr-aspage-tabs-sub" role="tablist">
                <li role="tab" tabindex="1" aria-controls="panel-sub-single-post" aria-labelledby="tab-sub-single-post" aria-selected="false">
                  <a id="tab-sub-single-post" href="#panel-sub-single-post" class="ui-tabs-anchor" role="presentation" tabindex="1">Single Post</a>
                </li>
                <li role="tab" tabindex="2" aria-controls="panel-sub-csmr" aria-labelledby="tab-sub-csmr" aria-selected="false">
                  <a id="tab-sub-csmr" href="#panel-sub-csmr" class="ui-tabs-anchor" role="presentation" tabindex="2">Coming Soon / Maintenance / Redirect</a>
                </li>
                <li role="tab" tabindex="3" aria-controls="panel-sub-404" aria-labelledby="tab-sub-404" aria-selected="false">
                  <a id="tab-sub-404" href="#panel-sub-404" class="ui-tabs-anchor" role="presentation" tabindex="3">Custom 404 Page</a>
                </li>
              </ul>
              <div id="panel-sub-single-post" class="dr-aspage-tabs-panel ui-tabs-panel" role="tabpanel" aria-labelledby="tab-sub-single-post" aria-expanded="false" aria-hidden="true" style="display: none;">
                <?php
                  if (array_key_exists("single-post", $this->settings)) {
                      $settings = $this->settings['single-post'];
                      include($this->parent_instance->dir . 'templates/settings-fields.php');
                  }
                ?>
              </div>
              <div id="panel-sub-csmr" class="dr-aspage-tabs-panel ui-tabs-panel" role="tabpanel" aria-labelledby="tab-sub-csmr" aria-expanded="false" aria-hidden="true" style="display: none;">
                <?php
                  if (array_key_exists("csmr", $this->settings)) {
                      $settings = $this->settings['csmr'];
                      include($this->parent_instance->dir . 'templates/settings-fields.php');
                  }
                ?>
              </div>
              <div id="panel-sub-404" class="dr-aspage-tabs-panel ui-tabs-panel" role="tabpanel" aria-labelledby="tab-sub-404" aria-expanded="false" aria-hidden="true" style="display: none;">
                <?php
                  if (array_key_exists("404", $this->settings)) {
                      $settings = $this->settings['404'];
                      include($this->parent_instance->dir . 'templates/settings-fields.php');
                  }
                ?>
              </div>
            </div>

            <div id="panel-css" class="dr-aspage-tabs-panel-container ui-tabs ui-tabs-panel" role="tabpanel" aria-labelledby="tab-css" aria-expanded="false" aria-hidden="true" style="display: none;">
              <ul class="dr-aspage-tabs-sub" role="tablist">
                <li role="tab" tabindex="1" aria-controls="panel-sub-css-hover" aria-labelledby="tab-sub-css-hover" aria-selected="false">
                  <a id="tab-sub-css-hover" href="#panel-sub-css-hover" class="ui-tabs-anchor" role="presentation" tabindex="1">Hovers</a>
                </li>
                <li role="tab" tabindex="2" aria-controls="panel-sub-css-filters" aria-labelledby="tab-sub-css-filters" aria-selected="false">
                  <a id="tab-sub-css-filters" href="#panel-sub-css-filters" class="ui-tabs-anchor" role="presentation" tabindex="2">Filters</a>
                </li>
                <li role="tab" tabindex="3" aria-controls="panel-sub-css-transitions" aria-labelledby="tab-sub-css-transitions" aria-selected="false">
                  <a id="tab-sub-css-transitions" href="#panel-sub-css-transitions" class="ui-tabs-anchor" role="presentation" tabindex="3">Transitions</a>
                </li>
              </ul>
              <div id="panel-sub-css-hover" class="dr-aspage-tabs-panel ui-tabs-panel" role="tabpanel" aria-labelledby="tab-sub-css-hover" aria-expanded="false" aria-hidden="true" style="display: none;">
                <?php
                  if (array_key_exists("css-hover", $this->settings)) {
                      $settings = $this->settings['css-hover'];
                      include($this->parent_instance->dir . 'templates/settings-fields.php');
                  }
                ?>
              </div>
              <div id="panel-sub-css-filters" class="dr-aspage-tabs-panel ui-tabs-panel" role="tabpanel" aria-labelledby="tab-sub-css-filters" aria-expanded="false" aria-hidden="true" style="display: none;">
                <?php
                  if (array_key_exists("css-filters", $this->settings)) {
                      $settings = $this->settings['css-filters'];
                      include($this->parent_instance->dir . 'templates/settings-fields.php');
                  }
                ?>
              </div>
              <div id="panel-sub-css-transitions" class="dr-aspage-tabs-panel ui-tabs-panel" role="tabpanel" aria-labelledby="tab-sub-css-transitions" aria-expanded="false" aria-hidden="true" style="display: none;">
                <?php
                  if (array_key_exists("css-transitions", $this->settings)) {
                      $settings = $this->settings['css-transitions'];
                      include($this->parent_instance->dir . 'templates/settings-fields.php');
                  }
                ?>
              </div>

            </div>


            <div id="panel-support" class="dr-aspage-tabs-panel-container ui-tabs ui-tabs-panel" role="tabpanel" aria-labelledby="tab-support" aria-expanded="false" aria-hidden="true" style="display: none;">
              <ul class="dr-aspage-tabs-sub" role="tablist">
                <li role="tab" tabindex="1" aria-controls="panel-sub-support" aria-labelledby="tab-sub-support" aria-selected="false">
                  <a id="tab-sub-support" href="#panel-sub-support" class="ui-tabs-anchor" role="presentation" tabindex="-1">Support</a>
                </li>
                <li role="tab" tabindex="1" aria-controls="panel-sub-whats-coming" aria-labelledby="tab-sub-whats-coming" aria-selected="false">
                  <a id="tab-sub-whats-coming" href="#panel-sub-whats-coming" class="ui-tabs-anchor" role="presentation" tabindex="-1">What's Coming</a>
                </li>
              </ul>
              <div id="panel-sub-support" class="dr-aspage-tabs-panel ui-tabs-panel" role="tabpanel" aria-labelledby="tab-sub-support" aria-expanded="false" aria-hidden="true" style="display: none;">
                <?php
                  if (array_key_exists("support", $this->settings)) {
                      $settings = $this->settings['support'];
                      include($this->parent_instance->dir . 'templates/settings-fields.php');
                  }
                ?>
              </div>
              <div id="panel-sub-whats-coming" class="dr-aspage-tabs-panel ui-tabs-panel" role="tabpanel" aria-labelledby="tab-sub-whats-coming" aria-expanded="false" aria-hidden="true" style="display: none;">
                <?php
                  if (array_key_exists("whats-coming", $this->settings)) {
                      $settings = $this->settings['whats-coming'];
                      include($this->parent_instance->dir . 'templates/settings-fields.php');
                  }
                ?>
              </div>
            </div>
          </div><!-- dr-aspage-tabs-panel-container -->

        </div><!-- dr-aspage-content -->

      </div><!-- dr-aspage-content-container -->

      <div class="dr-aspage-footer">

        <?php
          wp_nonce_field($this->action_nonce);

          printf(
            '<button id="%1$s" name="%1$s" class="dr-button-save">%2$s</button>
            <input type="hidden" name="action" value="%3$s" id="%4$s" />',
              'dr-aspage-button-save',
              esc_html('Save Changes', DIVIROIDS_PLUGIN_SLUG),
              $this->action_save,
              'dr-aspage-input-action'
          );
        ?>

      </div><!-- dr-aspage-footer -->

    </form><!-- form -->

  </div><!-- dr-aspage -->

  <?php do_action($this->hook . '_after_contents'); ?>

</div><!-- wrapper -->

<div id="dr-action-panel-save">
  <div class="dr-action-panel-saving"><img src="<?php echo DIVIROIDS_PLUGIN_ASSETS_URL . 'images/divi-loader.gif'; ?>" alt="loading" id="loading" /></div>
  <div class="dr-action-panel-saved"></div>
</div><!-- dr-aspage-action-save -->

<div id="dr-action-panel-confirm" class="dr-modal dr-modal-transition">
  <div class="dr-modal-content">
    <h3 class="dr-modal-content-title"><?php _e('Reset', DIVIROIDS_PLUGIN_SLUG); ?></h3>
    <div>
      <p class="dr-modal-content-description"><?php _e('This will return all of the settings throughout the options page to their default values. <strong>Are you sure you want to do this?</strong>', DIVIROIDS_PLUGIN_SLUG); ?></p>
      <div class="clearfix"></div>
      <span class="dr-modal-action-no"><?php _e('No', DIVIROIDS_PLUGIN_SLUG); ?></span>
      <span class="dr-modal-action-yes"><?php _e('Yes', DIVIROIDS_PLUGIN_SLUG); ?></span>
    </div>
  </div>
</div><!-- dr-aspage-action-reset -->

<div class="dr-modal-overlay"></div>
