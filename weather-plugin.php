<?php
/*
Plugin Name: Weather Plugin
Plugin URI: 
Description: A simple WordPress plugin to display weather information from the OpenWeatherMap API.
Version: 1.0
Author: Amrit Thapa
Author URI:
*/

// Hook to create plugin settings menu
add_action('admin_menu', 'wp_weather_plugin_menu');

function wp_weather_plugin_menu() {
    add_menu_page('Weather Plugin Settings', 'Weather Plugin', 'administrator', 'weather-plugin-settings', 'wp_weather_plugin_settings_page', 'dashicons-cloud');
}

// Include the admin page for plugin settings
require_once(plugin_dir_path(__FILE__) . 'admin.php');

// Shortcode to display the weather
add_shortcode('wp_weather', 'wp_weather_shortcode');

function wp_weather_shortcode($atts) {
    $city = get_option('wp_weather_city', 'New York');
    $api_key = get_option('wp_weather_api_key', 'your-api-key-here');
    
    if (!$api_key) {
        return 'Please configure your API key in the plugin settings.';
    }
    
    $url = "http://api.openweathermap.org/data/2.5/weather?q=$city&appid=$api_key&units=metric";
    $response = wp_remote_get($url);
    
    if (is_wp_error($response)) {
        return 'Error fetching weather data.';
    }
    
    $weather_data = json_decode(wp_remote_retrieve_body($response));
    
    if ($weather_data->cod != 200) {
        return 'Error fetching weather data.';
    }
    
    $temperature = $weather_data->main->temp;
    $weather_description = $weather_data->weather[0]->description;
    
    return "<h3>Weather in $city:</h3><p>$weather_description with a temperature of $temperature °C.</p>";
}
