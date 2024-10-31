<?php
/**
 * Plugin Name: Metal Price Calculator
 * Description: A plugin that provides a metal price calculator with a backend-admin price updater.
 * Version: 1.0
 * Author: Aadhil Nazeer
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Enqueue scripts and styles
function metal_price_calculator_enqueue_scripts() {
    wp_enqueue_style('metal-price-calculator-style', plugins_url('/css/style.css', __FILE__));
    wp_enqueue_script('metal-price-calculator-script', plugins_url('/js/calculator.js', __FILE__), array('jquery'), null, true);

    // Pass the current gold price to the script
    wp_localize_script('metal-price-calculator-script', 'metalPriceCalculatorData', array(
        'pricePerOunce' => get_option('metal_price_per_ounce', 1812.14),
        'updatedTime' => get_option('metal_price_updated_time', '')
    ));
}
add_action('wp_enqueue_scripts', 'metal_price_calculator_enqueue_scripts');

// Create shortcode to display the calculator
// Create shortcode to display the calculator
function metal_price_calculator_shortcode() {
    ob_start();
    ?>
    <div class="metal-calculator-body">
        <div class="metal-calculator-container">
            <div class="metal-calculator-header">
                <div>Our Gold Price - £<span id="pricePerOunce"><?php echo esc_html(get_option('metal_price_per_ounce', 1812.14)); ?></span> / oz</div>
                <div>Latest Updated Time - <span id="updatedtime"><?php echo esc_html(get_option('metal_price_updated_time', '')); ?></span></div>
            </div>
            <div class="metal-calculator">
                <table class="metal-calculator-table">
                    <thead>
                        <tr>
                            <th>Grams</th>
                            <th>Description</th>
                            <th>Total Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><input type="number" id="grams9k" class="metal-calculator-input" value="0" min="0"></td>
                            <td>9k Gold</td>
                            <td>£<span id="price9k">0.00</span></td>
                        </tr>
                        <tr>
                            <td><input type="number" id="grams10k" class="metal-calculator-input" value="0" min="0"></td>
                            <td>10k Gold</td>
                            <td>£<span id="price10k">0.00</span></td>
                        </tr>
                        <tr>
                            <td><input type="number" id="grams12k" class="metal-calculator-input" value="0" min="0"></td>
                            <td>12k Gold</td>
                            <td>£<span id="price12k">0.00</span></td>
                        </tr>
                        <tr>
                            <td><input type="number" id="grams14k" class="metal-calculator-input" value="0" min="0"></td>
                            <td>14k Gold</td>
                            <td>£<span id="price14k">0.00</span></td>
                        </tr>
                        <tr>
                            <td><input type="number" id="grams15k" class="metal-calculator-input" value="0" min="0"></td>
                            <td>15k Gold</td>
                            <td>£<span id="price15k">0.00</span></td>
                        </tr>
                        <tr>
                            <td><input type="number" id="grams18k" class="metal-calculator-input" value="0" min="0"></td>
                            <td>18k Gold</td>
                            <td>£<span id="price18k">0.00</span></td>
                        </tr>
                        <tr>
                            <td><input type="number" id="grams21k" class="metal-calculator-input" value="0" min="0"></td>
                            <td>21k Gold</td>
                            <td>£<span id="price21k">0.00</span></td>
                        </tr>
                        <tr>
                            <td><input type="number" id="grams22kc" class="metal-calculator-input" value="0" min="0"></td>
                            <td>22k Coins</td>
                            <td>£<span id="price22kc">0.00</span></td>
                        </tr>
                        <tr>
                            <td><input type="number" id="grams22k" class="metal-calculator-input" value="0" min="0"></td>
                            <td>22k Gold</td>
                            <td>£<span id="price22k">0.00</span></td>
                        </tr>
                        <tr>
                            <td><input type="number" id="grams24k" class="metal-calculator-input" value="0" min="0"></td>
                            <td>24k Gold</td>
                            <td>£<span id="price24k">0.00</span></td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr class="metal-calculator-total-row">
                            <td colspan="2">Total Amount</td>
                            <td>£<span id="totalAmount">0.00</span></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    <?php
    return ob_get_clean();
}

add_shortcode('metal_price_calculator', 'metal_price_calculator_shortcode');

// Add settings page for updating the gold price
function metal_price_calculator_menu() {
    add_menu_page(
        'Metal Price Calculator',
        'Metal Price Calculator',
        'manage_options',
        'metal-price-calculator',
        'metal_price_calculator_settings_page',
        'dashicons-admin-generic',
        100
    );
}
add_action('admin_menu', 'metal_price_calculator_menu');

function metal_price_calculator_settings_page() {
    if (isset($_POST['submit'])) {
        update_option('metal_price_per_ounce', sanitize_text_field($_POST['metal_price_per_ounce']));
        update_option('metal_price_updated_time', current_time('d-m-Y h.i A'));
        echo '<div class="updated"><p>Price updated successfully.</p></div>';
    }
    ?>
    <div class="wrap">
        <h1>Metal Price Calculator Settings</h1>
        <form method="POST">
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="metal_price_per_ounce">Price Per Ounce (GBP)</label></th>
                    <td><input type="text" name="metal_price_per_ounce" value="<?php echo esc_attr(get_option('metal_price_per_ounce', '1812.14')); ?>" class="regular-text"></td>
                </tr>
            </table>
            <?php submit_button('Save Changes'); ?>
        </form>
    </div>
    <?php
}
?>
