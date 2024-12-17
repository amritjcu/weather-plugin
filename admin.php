<?php
function wp_weather_plugin_settings_page() {
    ?>
    <div class="wrap">
        <h1>Weather Plugin Settings</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('wp_weather_plugin_settings_group');
            do_settings_sections('wp_weather_plugin_settings');
            ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">City</th>
                    <td><input type="text" name="wp_weather_city" value="<?php echo esc_attr(get_option('wp_weather_city', 'New York')); ?>" /></td>
                </tr>
                
                <tr valign="top">
                    <th scope="row">API Key</th>
                    <td><input type="text" name="wp_weather_api_key" value="<?php echo esc_attr(get_option('wp_weather_api_key')); ?>" /></td>
                </tr>
            </table>
            
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

add_action('admin_init', 'wp_weather_plugin_register_settings');

function wp_weather_plugin_register_settings() {
    register_setting('wp_weather_plugin_settings_group', 'wp_weather_city');
    register_setting('wp_weather_plugin_settings_group', 'wp_weather_api_key');
}
