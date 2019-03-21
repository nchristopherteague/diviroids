<?php
defined('ABSPATH') or die('No script kiddies please!');

/**
 * Renders the contents
 *
 * @since 1.0.0
*/

  // Get all of the options saved
  $allowed_html = array(
                    'p'       => array(),
                    'strong'  => array(),
                    'br'      => array(),
                    'a'       => array(
                      'id'      => array(),
                      'class'   => array(),
                      'href'    => array(),
                      'title'   => array(),
                      'target'  => array()
                    ),
                  );

  foreach ($settings as $value) {
      $fld_id               = esc_attr($value['id']);
      $fld_name             = esc_html($value['name']);
      //$fld_desc             = wp_kses(!empty($value['description']) ? $value['description'] : '', $allowed_html);
      $fld_desc             = !empty($value['description']) ? $value['description'] : '';
      $fld_type             = $value['type'];
      $fld_options          = !empty($value['options']) ? $value['options'] : '';
      $fld_default          = !empty($value['default']) ? $value['default'] : '';
      $fld_additional       = !empty($value['additional']) ? $value['additional'] : '';
      $fld_value            = DiviRoids_Settings()->get($fld_id, false, $fld_default);
      $fld_visibility       = !empty($value['visibility']) ? call_user_func(array(DiviRoids_Settings(), $value['visibility'])) : true;
      $fld_display          = !$fld_visibility ? 'display: none;' : '';

      if ('template' === $fld_type) {
          if ($fld_visibility) {
              $this->load_template($fld_name);
          }
          continue;
      }

      printf(
        '<div id="%1$s" class="dr-aspage-panel-group" style="%2$s"><div class="dr-aspage-panel-group-header"><h3>%3$s</h3><p>%4$s</p></div>',
        'panel-group-' . $fld_id,
        $fld_display,
        $fld_name,
        $fld_desc
      );

      switch ($fld_type) {

        case 'switch': // Handles the Enable/Disable Switch

          $switch_class = 'dr-input-switch-state-off';
          if (!empty($fld_value) && 'on' == $fld_value) {
              $switch_class = 'dr-input-switch-state-on';
          }

          $switch_labels = !empty($fld_additional) ? explode('|', $fld_additional) : array('Enabled', 'Disabled');
          printf(
              '<div class="dr-aspage-panel-group-content">
                <div class="dr-input-switch %5$s">
                  <input id="%1$s" name="%1$s" type="checkbox" class="dr-input-hidden" %2$s>
                  <span class="dr-input-switch-value-text dr-input-switch-value-on">%3$s</span>
                  <span class="dr-input-switch-slider"></span>
                  <span class="dr-input-switch-value-text dr-input-switch-value-off">%4$s</span>
                </div>
              </div>',
              $fld_id,
              checked('on', $fld_value, false),
              $switch_labels[0],
              $switch_labels[1],
              $switch_class
          );

          break;

        case 'switches':

          $switch_labels = !empty($fld_additional) ? explode('|', $fld_additional) : array('Enabled', 'Disabled');

          echo '<div class="dr-aspage-panel-group-content"><div class="dr-aspage-panel-group-content-grid">';

          foreach ($fld_options as $option_key => $option_value) {
              if ('' == $option_key) {
                  continue;
              }

              $checked = '';
              $switch_class = 'dr-input-switch-state-off';

              if (is_array($fld_value) && in_array(trim($option_key), $fld_value)) {
                  $checked        = 'on';
                  $switch_class   = 'dr-input-switch-state-on';
              }

              printf(
                '<div class="dr-aspage-panel-group-content-grid-item">
                  <h3>%8$s</h3>
                  <div class="dr-input-switch %7$s">
                    <input id="%1$s" name="%2$s[]" type="checkbox" class="dr-input-hidden" value="%3$s" %4$s>
                    <span class="dr-input-switch-value-text dr-input-switch-value-on">%5$s</span>
                    <span class="dr-input-switch-slider"></span>
                    <span class="dr-input-switch-value-text dr-input-switch-value-off">%6$s</span>
                  </div>
                </div>',
                $fld_id . '-' . $option_key,
                $fld_id,
                $option_key,
                checked('on', $checked, false),
                $switch_labels[0],
                $switch_labels[1],
                $switch_class,
                $option_value
              );
          };

          echo '</div></div>';

          break;

        case 'text':

            $fld_value = stripslashes($fld_value);

            printf(
                '<div class="dr-aspage-panel-group-content">
                  <input id="%1$s" name="%1$s" type="%2$s" value="%3$s">
                </div>',
                $fld_id,
                $fld_type,
                $fld_value
            );

            break;

        case 'textarea':
            break;

        case 'password':

            $fld_value = stripslashes($fld_value);

            printf(
                '<div class="dr-aspage-panel-group-content">
                  <input id="%1$s" name="%1$s" type="%2$s" value="%3$s">
                </div>',
                $fld_id,
                $fld_type,
                !empty($fld_value) ? DiviRoids_Settings()->format_password('') : ''
            );

            break;

        case 'checkboxes':

            break;

        case 'select':

          $select_options = '';
          foreach ($fld_options as $key => $value) {
              $select_active = '';
              if ('-disabled-' == trim($key)) {
                  $select_active = ' disabled="disabled" ';
              } elseif ((string)$key == (string)$fld_value) {
                  $select_active = ' selected="selected" ';
              }

              $select_options .= sprintf(
                '<option value="%1$s" %2$s>%3$s</option>',
                $key,
                $select_active,
                $value
            );
          }

          printf(
              '<div class="dr-aspage-panel-group-content">
                <select id="%1$s" name="%1$s">
                %2$s
                </select>
              </div>',
              $fld_id,
              $select_options
          );


            break;

        default:

            break;
      }

      printf('</div><!-- dr-aspage-panel-group -->');
  };
