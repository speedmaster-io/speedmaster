<?php
add_action( 'admin_menu', 'speedmaster_admin_menu' );

function speedmaster_admin_menu() {
  add_menu_page( 'Speedmaster - Status', 'Speedmaster', 'manage_options', 'speedmaster-dashboard.php', 'speedmaster_admin_page', 'dashicons-smiley', 101);
}

function speedmaster_admin_page() {

  $rows = [
    [
      'name' => 'Cache',
      'setting' => "cache:enabled",
      'value' => speedmaster_display_status(SPEEDMASTER_CACHE_CONFIG['enabled']),
      'tag' => 'th',
      'enabled' => SPEEDMASTER_CACHE_CONFIG['enabled']
    ],
    [
      'name' => 'Exclude keywords',
      'setting' => "cache:exclude",
      'value' => speedmaster_print_array(SPEEDMASTER_CACHE_CONFIG['exclude']),
      'tag' => 'td',
      'enabled' => SPEEDMASTER_CACHE_CONFIG['enabled']
    ],

    [
      'name' => 'Optimizer',
      'setting' => "optimizer:enabled",
      'value' => speedmaster_display_status(SPEEDMASTER_OPTIMIZER_CONFIG['enabled']),
      'tag' => 'th',
      'enabled' => SPEEDMASTER_OPTIMIZER_CONFIG['enabled']
    ],

   [
      'name' => 'Minify HTML',
      'setting' => "optimizer:minify_html",
      'value' => speedmaster_display_status((SPEEDMASTER_OPTIMIZER_CONFIG['enabled'] && SPEEDMASTER_OPTIMIZER_CONFIG['minify_html'])),
      'tag' => 'td',
      'enabled' => (SPEEDMASTER_OPTIMIZER_CONFIG['enabled'] && SPEEDMASTER_OPTIMIZER_CONFIG['minify_html'])
    ],

    [
      'name' => 'Combine CSS files into one',
      'setting' => "optimizer:combine_css",
      'value' => speedmaster_display_status((SPEEDMASTER_OPTIMIZER_CONFIG['enabled'] && SPEEDMASTER_OPTIMIZER_CONFIG['combine_css'])),
      'tag' => 'td',
      'enabled' => (SPEEDMASTER_OPTIMIZER_CONFIG['enabled'] && SPEEDMASTER_OPTIMIZER_CONFIG['combine_css'])
    ],
    [
      'name' => 'Minify combined CSS',
      'setting' => "optimizer:minify_css",
      'value' => speedmaster_display_status((SPEEDMASTER_OPTIMIZER_CONFIG['enabled'] && SPEEDMASTER_OPTIMIZER_CONFIG['minify_css'])),
      'tag' => 'td',
      'enabled' => (SPEEDMASTER_OPTIMIZER_CONFIG['enabled'] && SPEEDMASTER_OPTIMIZER_CONFIG['minify_css'])
    ],
    [
      'name' => 'Combine JS files into one',
      'setting' => "optimizer:combine_js",
      'value' => speedmaster_display_status((SPEEDMASTER_OPTIMIZER_CONFIG['enabled'] && SPEEDMASTER_OPTIMIZER_CONFIG['combine_js'])),
      'tag' => 'td',
      'enabled' => (SPEEDMASTER_OPTIMIZER_CONFIG['enabled'] && SPEEDMASTER_OPTIMIZER_CONFIG['combine_js'])
    ],

    [
      'name' => 'Minify combibined JS files',
      'setting' => "optimizer:minify_js",
      'value' => speedmaster_display_status((SPEEDMASTER_OPTIMIZER_CONFIG['enabled'] && SPEEDMASTER_OPTIMIZER_CONFIG['minify_js'])),
      'tag' => 'td',
      'enabled' => (SPEEDMASTER_OPTIMIZER_CONFIG['enabled'] && SPEEDMASTER_OPTIMIZER_CONFIG['minify_js'])
    ],
    [
      'name' => 'Load combined JS files in footer',
      'setting' => "optimizer:footer_js",
      'value' => speedmaster_display_status((SPEEDMASTER_OPTIMIZER_CONFIG['enabled'] && SPEEDMASTER_OPTIMIZER_CONFIG['footer_js'])),
      'tag' => 'td',
      'enabled' => (SPEEDMASTER_OPTIMIZER_CONFIG['enabled'] && SPEEDMASTER_OPTIMIZER_CONFIG['footer_js'])
    ],
    [
      'name' => 'Disable Embed & Emojis',
      'setting' => "optimizer:disable_embed",
      'value' => speedmaster_display_status((SPEEDMASTER_OPTIMIZER_CONFIG['enabled'] && SPEEDMASTER_OPTIMIZER_CONFIG['disable_embed'])),
      'tag' => 'td',
      'enabled' => (SPEEDMASTER_OPTIMIZER_CONFIG['enabled'] && SPEEDMASTER_OPTIMIZER_CONFIG['disable_embed'])
    ],

    [
      'name' => 'Exclude CSS keywords',
      'setting' => "optimizer:exclude_css",
      'value' => speedmaster_print_array(SPEEDMASTER_OPTIMIZER_CONFIG['exclude_css']),
      'tag' => 'td',
      'enabled' => (SPEEDMASTER_OPTIMIZER_CONFIG['enabled'] && SPEEDMASTER_OPTIMIZER_CONFIG['exclude_css'])
    ],

    [
      'name' => 'Exclude JS keywords',
      'setting' => "optimizer:exclude_js",
      'value' => speedmaster_print_array(SPEEDMASTER_OPTIMIZER_CONFIG['exclude_js']),
      'tag' => 'td',
      'enabled' => (SPEEDMASTER_OPTIMIZER_CONFIG['enabled'] && SPEEDMASTER_OPTIMIZER_CONFIG['exclude_js'])
    ],



    [
      'name' => 'CDN',
      'setting' => "cdn:enabled",
      'value' => speedmaster_display_status(SPEEDMASTER_CDN_CONFIG['enabled']),
      'tag' => 'th',
      'enabled' => SPEEDMASTER_CDN_CONFIG['enabled']
    ],
    [
      'name' => 'Origin URLs',
      'setting' => "cdn:hosts",
      'value' => speedmaster_print_array(SPEEDMASTER_CDN_CONFIG['hosts']),
      'tag' => 'td',
      'enabled' => SPEEDMASTER_CDN_CONFIG['enabled']
    ],
    [
      'name' => 'CDN Endpoint',
      'setting' => "cdn:cdn_url",
      'value' => speedmaster_print_url(SPEEDMASTER_CDN_CONFIG['cdn_url']),
      'tag' => 'td',
      'enabled' => SPEEDMASTER_CDN_CONFIG['enabled']
    ],
    [
      'name' => 'Include',
      'setting' => "cdn:include",
      'value' => speedmaster_print_array(SPEEDMASTER_CDN_CONFIG['include']),
      'tag' => 'td',
      'enabled' => SPEEDMASTER_CDN_CONFIG['enabled']
    ],
    [
      'name' => 'Exclude',
      'setting' => "cdn:exclude",
      'value' => speedmaster_print_array(SPEEDMASTER_CDN_CONFIG['exclude']),
      'tag' => 'td',
      'enabled' => SPEEDMASTER_CDN_CONFIG['enabled']
    ],


  ];
  ?>
  <div class="wrap">
    <h2 class="wp-heading-inline">Speedmaster</h2>

    <div class="columns">
      <div class="column">
        <h3>Cache Status</h3>
        <table class="wp-list-table widefat">
          <thead>
            <tr>
              <th style="width: 200px">Label</th>
              <td>Status</td>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Number of cached pages</td>
              <td><?php echo speedmaster_count_cached_files(); ?></td>
            </tr>
            <tr>
              <td>Cached CSS</td>
              <td><?php echo speedmaster_display_status(count(glob(SPEEDMASTER_CACHE_DIR."*.sm.css.cache")) > 0); ?></td>
            </tr>
            <tr>
              <td>Cached Javascripts</td>
              <td><?php echo speedmaster_display_status(count(glob(SPEEDMASTER_CACHE_DIR."*.sm.js.cache")) > 0); ?></td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="column">
        <h3>System Status</h3>
        <table class="wp-list-table widefat">
          <thead>
            <tr>
              <th>Test</th>
              <td>Result</td>
              <td></td>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Data directory exists &amp; is writable</td>
              <td><?php echo speedmaster_is_writable_icon(SPEEDMASTER_DATA_DIR); ?></td>
              <td><a href="javascript:alert('Documentation not ready yet. Feel free to contribute to our repo ;)');"><span class="dashicons dashicons-info"></span> File permissions</a></td>
            </tr>
            <tr>
              <td>Cache directory exists &amp; is writable</td>
              <td><?php echo speedmaster_is_writable_icon(SPEEDMASTER_CACHE_DIR); ?></td>
              <td><a href="javascript:alert('Documentation not ready yet. Feel free to contribute to our repo ;)');"><span class="dashicons dashicons-info"></span> File permissions</a></td>
            </tr>
            <tr>
              <td>Configuration file exists &amp; is writable</td>
              <td><?php echo speedmaster_is_writable_icon(SPEEDMASTER_CONFIG_FILE); ?></td>
              <td><a href="javascript:alert('Documentation not ready yet. Feel free to contribute to our repo ;)');"><span class="dashicons dashicons-info"></span> File permissions</a></td>
            </tr>
            <tr>
              <td>Storage file exists &amp; is writable</td>
              <td><?php echo speedmaster_is_writable_icon(SPEEDMASTER_STORAGE_FILE); ?></td>
              <td><a href="javascript:alert('Documentation not ready yet. Feel free to contribute to our repo ;)');"><span class="dashicons dashicons-info"></span> File permissions</a></td>
            </tr>
            <tr>
              <td><em>wp-config.php</em> exists &amp; is writable</td>
              <td><?php echo speedmaster_is_writable_icon(SPEEDMASTER_WP_CONFIG_FILE); ?></td>
              <td><a href="javascript:alert('Documentation not ready yet. Feel free to contribute to our repo ;)');"><span class="dashicons dashicons-info"></span> File permissions</a></td>
            </tr>
            <tr>
              <td><em>advanced-cache.php</em> exists &amp; is writable</td>
              <td><?php echo speedmaster_is_writable_icon(SPEEDMASTER_ADVANCED_CACHE_FILE); ?></td>
              <td><a href="javascript:alert('Documentation not ready yet. Feel free to contribute to our repo ;)');"><span class="dashicons dashicons-info"></span> File permissions</a></td>
            </tr>
            <tr>
              <td>WP_CACHE constant is set to <em>true</em></td>
              <td><?php echo speedmaster_constant_is_icon('WP_CACHE', true); ?></td>
              <td><a href="javascript:alert('Documentation not ready yet. Feel free to contribute to our repo ;)');"><span class="dashicons dashicons-info"></span> Configuration tutorial</a></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <h3>Configuration</h3>
    <p>By using JSON for settings instead of the normal WP Dashboard admin panel, we can access config data before WordPress and mySQL is loaded. Cache & optimization settings can only be made by editing the config file <code><?php echo SPEEDMASTER_CONFIG_FILE; ?></code> directly on your host via e.g. FTP or SSH. However, we recommend you to include it in your repo if you're using git.</p>
    <p><em>This table lists your current configuration. Read the <a href="#">configuration tutorial</a> to learn more.</em></p>
    <table class="wp-list-table widefat">
      <thead>
        <tr>
          <th style="width: 200px">Setting</th>
          <th>Value(s)</th>
          <th style="width: 200px;text-align: right">Config Variable</th>
        </tr>
      </thead>
      <tbody>
        <?php
        foreach($rows as $row):
        ?>
          <tr class="<?php echo speedmaster_setting_class($row['enabled']); ?> <?php echo $row['tag']; ?>">
            <<?php echo $row['tag']; ?>><?php echo $row['name']; ?></<?php echo $row['tag']; ?>>
            <<?php echo $row['tag']; ?>><?php echo $row['value']; ?></<?php echo $row['tag']; ?>>
            <<?php echo $row['tag']; ?> style="text-align: right"><?php echo $row['setting']; ?></<?php echo $row['tag']; ?>>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

  </div>
  <style type="text/css">
    .columns {
      display: flex;
      justify-content: space-between;
    }

    .column {
      display: flex;
      flex: 1;
      flex-direction: column;
      margin: 10px;
    }

    .column:first-child {
      margin-left: 0;
    }

    .column:last-child {
      margin-right: 0;
    }

    thead th {
      font-weight: bold !important;
    }

    .disabled th:first-child {
      border-left: 4px solid #eb4d4b;
      font-weight: bold !important;
    }
    .disabled td:nth-child(1) {
      border-left: 4px solid #ff7979;
    }

    .enabled th:first-child {
      border-left: 4px solid #6ab04c;
      font-weight: bold !important;
    }
    .enabled td:nth-child(1) {
      border-left: 4px solid #badc58;
    }

    /*.disabled.th + .disabled.td,
    .disabled.th + .disabled.td + .disabled.td,
    .disabled.th + .disabled.td + .disabled.td + .disabled.td,
    .disabled.th + .disabled.td + .disabled.td + .disabled.td + .disabled.td,
    .disabled.th + .disabled.td + .disabled.td + .disabled.td + .disabled.td + .disabled.td,
    .disabled.th + .disabled.td + .disabled.td + .disabled.td + .disabled.td + .disabled.td + .disabled.td,
    .disabled.th + .disabled.td + .disabled.td + .disabled.td + .disabled.td + .disabled.td + .disabled.td + .disabled.td {
      display: none;
    }*/
  </style>
  <?php
}
