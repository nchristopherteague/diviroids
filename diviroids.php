<?php
defined('ABSPATH') or die('No script kiddies please!');

/**
* DiviRoids Plugin
*
* @link    http://www.diviroids.com
* @since   1.0.0
* @package DiviRoids
*
* @wordpress-plugin
* Plugin Name:       DiviRoids
* Plugin URI:        http://www.diviroids.com
* Description:       Useful collection of enhancements for both Wordpress and Divi.
* Version:           1.0.0
* Author:            DiviRoids Team
* Author URI:        http://www.diviroids.com
* License:           GPL2
* License URI:       https://www.gnu.org/licenses/gpl-2.0.html
* Text Domain:       diviroids
* Domain Path:       /languages
*/

if (!class_exists('DiviRoids')) :

 define('DIVIROIDS_PLUGIN_NAME', 'DiviRoids');
 define('DIVIROIDS_PLUGIN_SLUG', 'diviroids');
 define('DIVIROIDS_PLUGIN_SLUG_ABBR', 'dr');
 define('DIVIROIDS_PLUGIN_HOOK', 'diviroids');
 define('DIVIROIDS_PLUGIN_VERSION', '1.0.0');
 define('DIVIROIDS_PLUGIN_CAPABILITY', 'manage_options');
 define('DIVIROIDS_PLUGIN_ADMIN_ROLE', 'administrator');
 define('DIVIROIDS_PLUGIN_FILE', plugin_basename(__FILE__));
 define('DIVIROIDS_PLUGIN_DIR', trailingslashit(plugin_dir_path(__FILE__)));
 define('DIVIROIDS_PLUGIN_URL', trailingslashit(plugin_dir_url(__FILE__)));
 define('DIVIROIDS_PLUGIN_LIB_DIR', trailingslashit(DIVIROIDS_PLUGIN_DIR .'lib'));
 define('DIVIROIDS_PLUGIN_INCLUDES_DIR', trailingslashit(DIVIROIDS_PLUGIN_DIR .'includes'));
 define('DIVIROIDS_PLUGIN_ASSETS_URL', trailingslashit(DIVIROIDS_PLUGIN_URL .'assets'));
 define('DIVIROIDS_PLUGIN_ASSETS_DIR', trailingslashit(DIVIROIDS_PLUGIN_DIR .'assets'));
 define('DIVIROIDS_PLUGIN_TEMPLATES_DIR', trailingslashit(DIVIROIDS_PLUGIN_DIR .'templates'));
 define('DIVIROIDS_PLUGIN_MODULES_DIR', trailingslashit(DIVIROIDS_PLUGIN_DIR .'includes/modules'));
 define('DIVIROIDS_PLUGIN_MODULES_URL', trailingslashit(DIVIROIDS_PLUGIN_URL .'includes/modules'));
 define('DIVIROIDS_PLUGIN_ASSETS_JS_URL', trailingslashit(DIVIROIDS_PLUGIN_URL .'assets/js'));
 define('DIVIROIDS_PLUGIN_ASSETS_CSS_URL', trailingslashit(DIVIROIDS_PLUGIN_URL .'assets/css'));

 define(
     'DIVIROIDS_PLUGIN_GEARS',
   '<svg class="dr-logo-gears-animated" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">
     <g transform="translate(50 50)">
       <g transform="translate(19 -19) scale(0.6)">
         <g transform="rotate(150)">
           <path class="gear-large" d="M37.1-8h6c2.2,0,4,1.8,4,4v8c0,2.2-1.8,4-4,4h-6c-1,4.5-2.7,8.8-5.2,12.6l0,0l4.2,4.2c1.6,1.6,1.6,4.1,0,5.7
           l-5.7,5.7c-1.6,1.6-4.1,1.6-5.7,0L20.5,32c-3.9,2.5-8.1,4.3-12.6,5.2l0,0v6c0,2.2-1.8,4-4,4h-8c-2.2,0-4-1.8-4-4v-6
           c-4.5-1-8.8-2.7-12.6-5.2l0,0l-4.2,4.2c-1.6,1.6-4.1,1.6-5.7,0l-5.7-5.7c-1.6-1.6-1.6-4.1,0-5.7l4.2-4.2c-2.5-3.9-4.3-8.1-5.2-12.6
           l0,0h-6c-2.2,0-4-1.8-4-4v-8c0-2.2,1.8-4,4-4h6c1-4.5,2.7-8.8,5.2-12.6l0,0l-4.2-4.2c-1.6-1.6-1.6-4.1,0-5.7l5.7-5.7
           c1.6-1.6,4.1-1.6,5.7,0l4.2,4.2c3.9-2.5,8.1-4.3,12.6-5.2l0,0v-6c0-2.2,1.8-4,4-4h8c2.2,0,4,1.8,4,4v6c4.5,1,8.8,2.7,12.6,5.2l0,0
           l4.2-4.2c1.6-1.6,4.1-1.6,5.7,0l5.7,5.7c1.6,1.6,1.6,4.1,0,5.7l-4.2,4.2C34.4-16.8,36.2-12.5,37.1-8 M0-25
           c-14.3,0-25.9,12.1-25,26.6C-24.2,14-14,24.2-1.6,25C12.9,25.9,25,14.3,25,0C25-13.8,13.8-25,0-25" fill="#FFFFFF"/>
         </g>
       </g>
       <g transform="translate(-13 13) scale(0.4)">
         <g transform="rotate(175)">
           <path class="gear-small" d="M37.1-8h6c2.2,0,4,1.8,4,4v8c0,2.2-1.8,4-4,4h-6c-1,4.5-2.7,8.8-5.2,12.6l0,0l4.2,4.2c1.6,1.6,1.6,4.1,0,5.7
           l-5.7,5.7c-1.6,1.6-4.1,1.6-5.7,0l-4.2-4.2c-3.9,2.5-8.1,4.3-12.6,5.2l0,0v6c0,2.2-1.8,4-4,4h-8c-2.2,0-4-1.8-4-4v-6
           c-4.5-1-8.8-2.7-12.6-5.2l0,0l-4.2,4.2c-1.6,1.6-4.1,1.6-5.7,0l-5.7-5.7c-1.6-1.6-1.6-4.1,0-5.7l4.2-4.2c-2.5-3.9-4.3-8.1-5.2-12.6
           l0,0h-6c-2.2,0-4-1.8-4-4v-8c0-2.2,1.8-4,4-4h6c1-4.5,2.7-8.8,5.2-12.6l0,0l-4.2-4.2c-1.6-1.6-1.6-4.1,0-5.7l5.7-5.7
           c1.6-1.6,4.1-1.6,5.7,0l4.2,4.2c3.9-2.5,8.1-4.3,12.6-5.2l0,0v-6c0-2.2,1.8-4,4-4h8c2.2,0,4,1.8,4,4v6c4.5,1,8.8,2.7,12.6,5.2l0,0
           l4.2-4.2c1.6-1.6,4.1-1.6,5.7,0l5.7,5.7c1.6,1.6,1.6,4.1,0,5.7l-4.2,4.2C34.4-16.8,36.2-12.5,37.1-8 M0-25
           c-14.3,0-25.9,12.1-25,26.6C-24.2,14-14,24.2-1.6,25C12.9,25.9,25,14.3,25,0C25-13.8,13.8-25,0-25" fill="#FFFFFF" />
         </g>
       </g>
     </g>
   </svg>'
 );

 define(
     'DIVIROIDS_PLUGIN_GEARS_ANIMATED',
   '<svg class="dr-logo-gears-animated" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">
     <g transform="translate(50 50)">
       <g transform="translate(19 -19) scale(0.6)">
         <g transform="rotate(150)">
           <animateTransform attributeName="transform" type="rotate" values="360;0" keyTimes="0;1" dur="10s" begin="0s" repeatCount="indefinite"></animateTransform>
           <path class="gear-large" d="M37.1-8h6c2.2,0,4,1.8,4,4v8c0,2.2-1.8,4-4,4h-6c-1,4.5-2.7,8.8-5.2,12.6l0,0l4.2,4.2c1.6,1.6,1.6,4.1,0,5.7
           l-5.7,5.7c-1.6,1.6-4.1,1.6-5.7,0L20.5,32c-3.9,2.5-8.1,4.3-12.6,5.2l0,0v6c0,2.2-1.8,4-4,4h-8c-2.2,0-4-1.8-4-4v-6
           c-4.5-1-8.8-2.7-12.6-5.2l0,0l-4.2,4.2c-1.6,1.6-4.1,1.6-5.7,0l-5.7-5.7c-1.6-1.6-1.6-4.1,0-5.7l4.2-4.2c-2.5-3.9-4.3-8.1-5.2-12.6
           l0,0h-6c-2.2,0-4-1.8-4-4v-8c0-2.2,1.8-4,4-4h6c1-4.5,2.7-8.8,5.2-12.6l0,0l-4.2-4.2c-1.6-1.6-1.6-4.1,0-5.7l5.7-5.7
           c1.6-1.6,4.1-1.6,5.7,0l4.2,4.2c3.9-2.5,8.1-4.3,12.6-5.2l0,0v-6c0-2.2,1.8-4,4-4h8c2.2,0,4,1.8,4,4v6c4.5,1,8.8,2.7,12.6,5.2l0,0
           l4.2-4.2c1.6-1.6,4.1-1.6,5.7,0l5.7,5.7c1.6,1.6,1.6,4.1,0,5.7l-4.2,4.2C34.4-16.8,36.2-12.5,37.1-8 M0-25
           c-14.3,0-25.9,12.1-25,26.6C-24.2,14-14,24.2-1.6,25C12.9,25.9,25,14.3,25,0C25-13.8,13.8-25,0-25"/>
         </g>
       </g>
       <g transform="translate(-13 13) scale(0.4)">
         <g transform="rotate(175)">
           <animateTransform attributeName="transform" type="rotate" values="0;360" keyTimes="0;1" dur="10s" begin="-0.56s" repeatCount="indefinite"></animateTransform>
           <path class="gear-small" d="M37.1-8h6c2.2,0,4,1.8,4,4v8c0,2.2-1.8,4-4,4h-6c-1,4.5-2.7,8.8-5.2,12.6l0,0l4.2,4.2c1.6,1.6,1.6,4.1,0,5.7
           l-5.7,5.7c-1.6,1.6-4.1,1.6-5.7,0l-4.2-4.2c-3.9,2.5-8.1,4.3-12.6,5.2l0,0v6c0,2.2-1.8,4-4,4h-8c-2.2,0-4-1.8-4-4v-6
           c-4.5-1-8.8-2.7-12.6-5.2l0,0l-4.2,4.2c-1.6,1.6-4.1,1.6-5.7,0l-5.7-5.7c-1.6-1.6-1.6-4.1,0-5.7l4.2-4.2c-2.5-3.9-4.3-8.1-5.2-12.6
           l0,0h-6c-2.2,0-4-1.8-4-4v-8c0-2.2,1.8-4,4-4h6c1-4.5,2.7-8.8,5.2-12.6l0,0l-4.2-4.2c-1.6-1.6-1.6-4.1,0-5.7l5.7-5.7
           c1.6-1.6,4.1-1.6,5.7,0l4.2,4.2c3.9-2.5,8.1-4.3,12.6-5.2l0,0v-6c0-2.2,1.8-4,4-4h8c2.2,0,4,1.8,4,4v6c4.5,1,8.8,2.7,12.6,5.2l0,0
           l4.2-4.2c1.6-1.6,4.1-1.6,5.7,0l5.7,5.7c1.6,1.6,1.6,4.1,0,5.7l-4.2,4.2C34.4-16.8,36.2-12.5,37.1-8 M0-25
           c-14.3,0-25.9,12.1-25,26.6C-24.2,14-14,24.2-1.6,25C12.9,25.9,25,14.3,25,0C25-13.8,13.8-25,0-25" />
         </g>
       </g>
     </g>
   </svg>'
 );

 define(
     'DIVIROIDS_PLUGIN_GEARS_BASE64',
     'data:image/svg+xml;base64,PHN2ZyBjbGFzcz0iZHItbG9nby1nZWFycy1hbmltYXRlZCIgd2lkdGg9IjEwMCUiIGhlaWdodD0iMTAwJSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmlld0JveD0iMCAwIDEwMCAxMDAiIHByZXNlcnZlQXNwZWN0UmF0aW89InhNaWRZTWlkIj4KICA8ZyB0cmFuc2Zvcm09InRyYW5zbGF0ZSg1MCA1MCkiPgogICAgPGcgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoMTkgLTE5KSBzY2FsZSgwLjYpIj4KICAgICAgPGcgdHJhbnNmb3JtPSJyb3RhdGUoMTUwKSI+CiAgICAgICAgPHBhdGggY2xhc3M9ImdlYXItbGFyZ2UiIGQ9Ik0zNy4xLThoNmMyLjIsMCw0LDEuOCw0LDR2OGMwLDIuMi0xLjgsNC00LDRoLTZjLTEsNC41LTIuNyw4LjgtNS4yLDEyLjZsMCwwbDQuMiw0LjJjMS42LDEuNiwxLjYsNC4xLDAsNS43CiAgICAgICAgbC01LjcsNS43Yy0xLjYsMS42LTQuMSwxLjYtNS43LDBMMjAuNSwzMmMtMy45LDIuNS04LjEsNC4zLTEyLjYsNS4ybDAsMHY2YzAsMi4yLTEuOCw0LTQsNGgtOGMtMi4yLDAtNC0xLjgtNC00di02CiAgICAgICAgYy00LjUtMS04LjgtMi43LTEyLjYtNS4ybDAsMGwtNC4yLDQuMmMtMS42LDEuNi00LjEsMS42LTUuNywwbC01LjctNS43Yy0xLjYtMS42LTEuNi00LjEsMC01LjdsNC4yLTQuMmMtMi41LTMuOS00LjMtOC4xLTUuMi0xMi42CiAgICAgICAgbDAsMGgtNmMtMi4yLDAtNC0xLjgtNC00di04YzAtMi4yLDEuOC00LDQtNGg2YzEtNC41LDIuNy04LjgsNS4yLTEyLjZsMCwwbC00LjItNC4yYy0xLjYtMS42LTEuNi00LjEsMC01LjdsNS43LTUuNwogICAgICAgIGMxLjYtMS42LDQuMS0xLjYsNS43LDBsNC4yLDQuMmMzLjktMi41LDguMS00LjMsMTIuNi01LjJsMCwwdi02YzAtMi4yLDEuOC00LDQtNGg4YzIuMiwwLDQsMS44LDQsNHY2YzQuNSwxLDguOCwyLjcsMTIuNiw1LjJsMCwwCiAgICAgICAgbDQuMi00LjJjMS42LTEuNiw0LjEtMS42LDUuNywwbDUuNyw1LjdjMS42LDEuNiwxLjYsNC4xLDAsNS43bC00LjIsNC4yQzM0LjQtMTYuOCwzNi4yLTEyLjUsMzcuMS04IE0wLTI1CiAgICAgICAgYy0xNC4zLDAtMjUuOSwxMi4xLTI1LDI2LjZDLTI0LjIsMTQtMTQsMjQuMi0xLjYsMjVDMTIuOSwyNS45LDI1LDE0LjMsMjUsMEMyNS0xMy44LDEzLjgtMjUsMC0yNSIgZmlsbD0iI0ZGRkZGRiIvPgogICAgICA8L2c+CiAgICA8L2c+CiAgICA8ZyB0cmFuc2Zvcm09InRyYW5zbGF0ZSgtMTMgMTMpIHNjYWxlKDAuNCkiPgogICAgICA8ZyB0cmFuc2Zvcm09InJvdGF0ZSgxNzUpIj4KICAgICAgICA8cGF0aCBjbGFzcz0iZ2Vhci1zbWFsbCIgZD0iTTM3LjEtOGg2YzIuMiwwLDQsMS44LDQsNHY4YzAsMi4yLTEuOCw0LTQsNGgtNmMtMSw0LjUtMi43LDguOC01LjIsMTIuNmwwLDBsNC4yLDQuMmMxLjYsMS42LDEuNiw0LjEsMCw1LjcKICAgICAgICBsLTUuNyw1LjdjLTEuNiwxLjYtNC4xLDEuNi01LjcsMGwtNC4yLTQuMmMtMy45LDIuNS04LjEsNC4zLTEyLjYsNS4ybDAsMHY2YzAsMi4yLTEuOCw0LTQsNGgtOGMtMi4yLDAtNC0xLjgtNC00di02CiAgICAgICAgYy00LjUtMS04LjgtMi43LTEyLjYtNS4ybDAsMGwtNC4yLDQuMmMtMS42LDEuNi00LjEsMS42LTUuNywwbC01LjctNS43Yy0xLjYtMS42LTEuNi00LjEsMC01LjdsNC4yLTQuMmMtMi41LTMuOS00LjMtOC4xLTUuMi0xMi42CiAgICAgICAgbDAsMGgtNmMtMi4yLDAtNC0xLjgtNC00di04YzAtMi4yLDEuOC00LDQtNGg2YzEtNC41LDIuNy04LjgsNS4yLTEyLjZsMCwwbC00LjItNC4yYy0xLjYtMS42LTEuNi00LjEsMC01LjdsNS43LTUuNwogICAgICAgIGMxLjYtMS42LDQuMS0xLjYsNS43LDBsNC4yLDQuMmMzLjktMi41LDguMS00LjMsMTIuNi01LjJsMCwwdi02YzAtMi4yLDEuOC00LDQtNGg4YzIuMiwwLDQsMS44LDQsNHY2YzQuNSwxLDguOCwyLjcsMTIuNiw1LjJsMCwwCiAgICAgICAgbDQuMi00LjJjMS42LTEuNiw0LjEtMS42LDUuNywwbDUuNyw1LjdjMS42LDEuNiwxLjYsNC4xLDAsNS43bC00LjIsNC4yQzM0LjQtMTYuOCwzNi4yLTEyLjUsMzcuMS04IE0wLTI1CiAgICAgICAgYy0xNC4zLDAtMjUuOSwxMi4xLTI1LDI2LjZDLTI0LjIsMTQtMTQsMjQuMi0xLjYsMjVDMTIuOSwyNS45LDI1LDE0LjMsMjUsMEMyNS0xMy44LDEzLjgtMjUsMC0yNSIgZmlsbD0iI0ZGRkZGRiIgLz4KICAgICAgPC9nPgogICAgPC9nPgogIDwvZz4KPC9zdmc+'
 );

 define(
     'DIVIROIDS_PLUGIN_GEARS_BASE64_ANIMATED',
     'data:image/svg+xml;base64,PHN2ZyBjbGFzcz0iZHItbG9nby1nZWFycy1hbmltYXRlZCIgd2lkdGg9IjEwMCUiIGhlaWdodD0iMTAwJSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmlld0JveD0iMCAwIDEwMCAxMDAiIHByZXNlcnZlQXNwZWN0UmF0aW89InhNaWRZTWlkIj4KICA8ZyB0cmFuc2Zvcm09InRyYW5zbGF0ZSg1MCA1MCkiPgogICAgPGcgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoMTkgLTE5KSBzY2FsZSgwLjYpIj4KICAgICAgPGcgdHJhbnNmb3JtPSJyb3RhdGUoMTUwKSI+CiAgICAgICAgPGFuaW1hdGVUcmFuc2Zvcm0gYXR0cmlidXRlTmFtZT0idHJhbnNmb3JtIiB0eXBlPSJyb3RhdGUiIHZhbHVlcz0iMzYwOzAiIGtleVRpbWVzPSIwOzEiIGR1cj0iMTBzIiBiZWdpbj0iMHMiIHJlcGVhdENvdW50PSJpbmRlZmluaXRlIj48L2FuaW1hdGVUcmFuc2Zvcm0+CiAgICAgICAgPHBhdGggY2xhc3M9ImdlYXItbGFyZ2UiIGQ9Ik0zNy4xLThoNmMyLjIsMCw0LDEuOCw0LDR2OGMwLDIuMi0xLjgsNC00LDRoLTZjLTEsNC41LTIuNyw4LjgtNS4yLDEyLjZsMCwwbDQuMiw0LjJjMS42LDEuNiwxLjYsNC4xLDAsNS43CiAgICAgICAgbC01LjcsNS43Yy0xLjYsMS42LTQuMSwxLjYtNS43LDBMMjAuNSwzMmMtMy45LDIuNS04LjEsNC4zLTEyLjYsNS4ybDAsMHY2YzAsMi4yLTEuOCw0LTQsNGgtOGMtMi4yLDAtNC0xLjgtNC00di02CiAgICAgICAgYy00LjUtMS04LjgtMi43LTEyLjYtNS4ybDAsMGwtNC4yLDQuMmMtMS42LDEuNi00LjEsMS42LTUuNywwbC01LjctNS43Yy0xLjYtMS42LTEuNi00LjEsMC01LjdsNC4yLTQuMmMtMi41LTMuOS00LjMtOC4xLTUuMi0xMi42CiAgICAgICAgbDAsMGgtNmMtMi4yLDAtNC0xLjgtNC00di04YzAtMi4yLDEuOC00LDQtNGg2YzEtNC41LDIuNy04LjgsNS4yLTEyLjZsMCwwbC00LjItNC4yYy0xLjYtMS42LTEuNi00LjEsMC01LjdsNS43LTUuNwogICAgICAgIGMxLjYtMS42LDQuMS0xLjYsNS43LDBsNC4yLDQuMmMzLjktMi41LDguMS00LjMsMTIuNi01LjJsMCwwdi02YzAtMi4yLDEuOC00LDQtNGg4YzIuMiwwLDQsMS44LDQsNHY2YzQuNSwxLDguOCwyLjcsMTIuNiw1LjJsMCwwCiAgICAgICAgbDQuMi00LjJjMS42LTEuNiw0LjEtMS42LDUuNywwbDUuNyw1LjdjMS42LDEuNiwxLjYsNC4xLDAsNS43bC00LjIsNC4yQzM0LjQtMTYuOCwzNi4yLTEyLjUsMzcuMS04IE0wLTI1CiAgICAgICAgYy0xNC4zLDAtMjUuOSwxMi4xLTI1LDI2LjZDLTI0LjIsMTQtMTQsMjQuMi0xLjYsMjVDMTIuOSwyNS45LDI1LDE0LjMsMjUsMEMyNS0xMy44LDEzLjgtMjUsMC0yNSIvPgogICAgICA8L2c+CiAgICA8L2c+CiAgICA8ZyB0cmFuc2Zvcm09InRyYW5zbGF0ZSgtMTMgMTMpIHNjYWxlKDAuNCkiPgogICAgICA8ZyB0cmFuc2Zvcm09InJvdGF0ZSgxNzUpIj4KICAgICAgICA8YW5pbWF0ZVRyYW5zZm9ybSBhdHRyaWJ1dGVOYW1lPSJ0cmFuc2Zvcm0iIHR5cGU9InJvdGF0ZSIgdmFsdWVzPSIwOzM2MCIga2V5VGltZXM9IjA7MSIgZHVyPSIxMHMiIGJlZ2luPSItMC41NnMiIHJlcGVhdENvdW50PSJpbmRlZmluaXRlIj48L2FuaW1hdGVUcmFuc2Zvcm0+CiAgICAgICAgPHBhdGggY2xhc3M9ImdlYXItc21hbGwiIGQ9Ik0zNy4xLThoNmMyLjIsMCw0LDEuOCw0LDR2OGMwLDIuMi0xLjgsNC00LDRoLTZjLTEsNC41LTIuNyw4LjgtNS4yLDEyLjZsMCwwbDQuMiw0LjJjMS42LDEuNiwxLjYsNC4xLDAsNS43CiAgICAgICAgbC01LjcsNS43Yy0xLjYsMS42LTQuMSwxLjYtNS43LDBsLTQuMi00LjJjLTMuOSwyLjUtOC4xLDQuMy0xMi42LDUuMmwwLDB2NmMwLDIuMi0xLjgsNC00LDRoLThjLTIuMiwwLTQtMS44LTQtNHYtNgogICAgICAgIGMtNC41LTEtOC44LTIuNy0xMi42LTUuMmwwLDBsLTQuMiw0LjJjLTEuNiwxLjYtNC4xLDEuNi01LjcsMGwtNS43LTUuN2MtMS42LTEuNi0xLjYtNC4xLDAtNS43bDQuMi00LjJjLTIuNS0zLjktNC4zLTguMS01LjItMTIuNgogICAgICAgIGwwLDBoLTZjLTIuMiwwLTQtMS44LTQtNHYtOGMwLTIuMiwxLjgtNCw0LTRoNmMxLTQuNSwyLjctOC44LDUuMi0xMi42bDAsMGwtNC4yLTQuMmMtMS42LTEuNi0xLjYtNC4xLDAtNS43bDUuNy01LjcKICAgICAgICBjMS42LTEuNiw0LjEtMS42LDUuNywwbDQuMiw0LjJjMy45LTIuNSw4LjEtNC4zLDEyLjYtNS4ybDAsMHYtNmMwLTIuMiwxLjgtNCw0LTRoOGMyLjIsMCw0LDEuOCw0LDR2NmM0LjUsMSw4LjgsMi43LDEyLjYsNS4ybDAsMAogICAgICAgIGw0LjItNC4yYzEuNi0xLjYsNC4xLTEuNiw1LjcsMGw1LjcsNS43YzEuNiwxLjYsMS42LDQuMSwwLDUuN2wtNC4yLDQuMkMzNC40LTE2LjgsMzYuMi0xMi41LDM3LjEtOCBNMC0yNQogICAgICAgIGMtMTQuMywwLTI1LjksMTIuMS0yNSwyNi42Qy0yNC4yLDE0LTE0LDI0LjItMS42LDI1QzEyLjksMjUuOSwyNSwxNC4zLDI1LDBDMjUtMTMuOCwxMy44LTI1LDAtMjUiIC8+CiAgICAgIDwvZz4KICAgIDwvZz4KICA8L2c+Cjwvc3ZnPg=='
 );

 if (!class_exists('DiviRoids_Instance_Base')) {
     require_once(DIVIROIDS_PLUGIN_LIB_DIR . 'class-diviroids-instance-base.php');
 }

   class DiviRoids extends DiviRoids_Instance_Base
   {

       #region Constructors and Destructors

       /**
        * Initialize the plugin, load dependencies.
        * @since 1.0.0
        */
       protected function initialization()
       {
           // Setup the local properties
           $this->parent_instance      = null;
           $this->name                 = DIVIROIDS_PLUGIN_NAME;
           $this->hook                 = DIVIROIDS_PLUGIN_HOOK;
           $this->slug                 = DIVIROIDS_PLUGIN_SLUG;
           $this->dir                  = DIVIROIDS_PLUGIN_DIR;

           // Load the Files
           $this->load_dependencies();

           // Run on Plugins Loaded
           // This hook will take care of activation
           // and setting up the additional hooks
           add_action('plugins_loaded', array( $this, 'plugins_loaded' ));
       }

       #endregion

       #region Private Functions

       /**
        * Setup the locale for this plugin.
        *
        * @since  1.0.0
        * @access private
        */
       private function setup_locale()
       {
           load_plugin_textdomain(
             DIVIROIDS_PLUGIN_SLUG,
             false,
             DIVIROIDS_PLUGIN_DIR . '/languages/'
         );
       }

       #endregion

       #region Public Functions

       /**
        * Load all dependencies.
        *
        * @since  1.0.0
        * @access public
        */
       public function load_dependencies()
       {
           require_once(DIVIROIDS_PLUGIN_LIB_DIR . 'class-diviroids-security.php');
           require_once(DIVIROIDS_PLUGIN_LIB_DIR . 'class-diviroids-library.php');
           require_once(DIVIROIDS_PLUGIN_LIB_DIR . 'class-diviroids-logger.php');
           require_once(DIVIROIDS_PLUGIN_LIB_DIR . 'class-diviroids-notices.php');
           require_once(DIVIROIDS_PLUGIN_LIB_DIR . 'class-diviroids-queries.php');
           require_once(DIVIROIDS_PLUGIN_LIB_DIR . 'class-diviroids-framework.php');
           require_once(DIVIROIDS_PLUGIN_LIB_DIR . 'class-diviroids-options.php');
           require_once(DIVIROIDS_PLUGIN_LIB_DIR . 'class-diviroids-settings.php');
           require_once(DIVIROIDS_PLUGIN_LIB_DIR . 'class-diviroids-post.php');
       }

       /**
        * Load the core.
        *
        * @since  1.0.0
        * @access public
        */
       public function load_core()
       {
           require_once DIVIROIDS_PLUGIN_INCLUDES_DIR . 'class-diviroids-core.php';
       }

       /**
        * Load the modules.
        *
        * @since  1.0.0
        * @access public
        */
       public function load_modules()
       {
           require_once DIVIROIDS_PLUGIN_INCLUDES_DIR . 'class-diviroids-modules.php';
       }

       /**
        * Load the admin dashboard.
        *
        * @since  1.0.0
        * @access public
        */
       public function load_admin()
       {
           if (!is_admin()) {
               return;
           }

           require_once DIVIROIDS_PLUGIN_INCLUDES_DIR . 'class-diviroids-admin.php';
       }

       /**
        * Load the public.
        *
        * @since  1.0.0
        * @access public
        */
       public function load_public()
       {
           require_once DIVIROIDS_PLUGIN_INCLUDES_DIR . 'class-diviroids-public.php';
       }

       /**
        *  Executes on plugins_loaded action.
        *
        * @since  1.0.0
        * @access public
        */
       public function plugins_loaded()
       {
           // // check the activation
           // $activated = DiviRoids_Framework()->activate();
           //
           // // if not activated, return and stop
           // // processing any hooks
           // if (!$activated) {
           //     return;
           // }
           // /*
           //             if (! function_exists('get_current_screen')) {
           //                 require_once(ABSPATH . 'wp-admin/includes/screen.php');
           //             }
           //             $current_screen = get_current_screen();
           // */
           // // Check for any additional warning
           // if (DiviRoids_Library::is_plugin_page(DIVIROIDS_PLUGIN_SLUG) === true) {
           //     DiviRoids_Framework()->check_for_warnings();
           // }

           // Load the Languages
           $this->setup_locale();

           // Load the core
           $this->load_core();

           // Load the modules
           $this->load_modules();

           // Load the admin
           $this->load_admin();

           // Load the public
           $this->load_public();
       }

       #endregion
   }

/**
* Returns instance of this object
*
* @since 1.0.0
*/
function DiviRoids()
{
    return DiviRoids::getInstance();
}

endif;

// self initialize
DiviRoids();
