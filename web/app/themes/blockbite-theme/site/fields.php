<?php

namespace Blockbite\Fields;

class siteFields
{

    // add construct
    public function __construct()
    {
        add_action('wp_nav_menu_item_custom_fields', array($this, 'menu_item_desc'), 10, 2);
        add_action('wp_nav_menu_item_custom_fields', array($this, 'menu_item_svg'), 10, 2);
        add_action('wp_update_nav_menu_item', array($this, 'save_menu_item_desc'), 10, 2);
        add_action('wp_update_nav_menu_item', array($this, 'save_menu_item_svg'), 10, 2);
        add_action( 'admin_menu', array($this,'reusable_blocks_admin_menu'),10, 2 );
        // remove_menus
        add_action('admin_menu', array($this, 'remove_menus'), 999);

        // ditch ACF for two custom fields
        add_action('add_meta_boxes', array($this, 'add_linkedin_meta_box'), 99999);
        add_action('save_post', array($this, 'save_linkedin_field_data'), 99999);
        add_action('add_meta_boxes', array($this, 'add_functie_meta_box'), 99999);
        add_action('save_post', array($this, 'save_functie_field_data'), 99999);

        
    }

    // menu description input field
    public static function menu_item_desc($item_id, $item)
    {
        $menu_item_desc = get_post_meta($item_id, '_menu_item_desc', true);
?>
        <div style="clear: both;">
            <span class="description"><?php _e("Item Description", 'menu-item-desc'); ?></span><br />
            <input type="hidden" class="nav-menu-id" value="<?php echo $item_id; ?>" />
            <div class="logged-input-holder">
                <input type="text" name="menu_item_desc[<?php echo $item_id; ?>]" id="menu-item-desc-<?php echo $item_id; ?>" value="<?php echo esc_attr($menu_item_desc); ?>" />
            </div>
        </div>
    <?php
    }

    // save menu description input field
    public static function save_menu_item_desc($menu_id, $menu_item_db_id)
    {
        if (isset($_POST['menu_item_desc'][$menu_item_db_id])) {
            $sanitized_data = sanitize_text_field($_POST['menu_item_desc'][$menu_item_db_id]);
            update_post_meta($menu_item_db_id, '_menu_item_desc', $sanitized_data);
        } else {
            delete_post_meta($menu_item_db_id, '_menu_item_desc');
        }
    }


    // menu svg input field
    public static function menu_item_svg($item_id, $item)
    {
        $menu_item_svg = get_post_meta($item_id, '_menu_item_svg', true);
    ?>
        <div style="clear: both;">
            <span class="svgription"><?php _e("Item Svg", 'menu-item-svg'); ?></span><br />
            <input type="hidden" class="nav-menu-id" value="<?php echo $item_id; ?>" />
            <div class="logged-input-holder">
                <input type="text" name="menu_item_svg[<?php echo $item_id; ?>]" id="menu-item-svg-<?php echo $item_id; ?>" value="<?php echo esc_attr($menu_item_svg); ?>" />
            </div>
        </div>
<?php
    }


    // save menu svg input field
    public static function save_menu_item_svg($menu_id, $menu_item_db_id)
    {
        if (isset($_POST['menu_item_svg'][$menu_item_db_id])) {
            $string = $_POST['menu_item_svg'][$menu_item_db_id];

            $sanitized_data =  wp_kses($string, [
                'svg' => [
                    'class' => 'fillCurent',
                    'xmlns' => [],
                    'width' => [],
                    'height' => [],
                    'viewbox' => [] //lowercase not camelcase!
                ],
                'path' => [
                    'd' => []
                ]
            ]);
            update_post_meta($menu_item_db_id, '_menu_item_svg', $sanitized_data);
        } else {
            delete_post_meta($menu_item_db_id, '_menu_item_svg');
        }
    }



    /* get custom menu fields */
    public static function menu_item($field, $item)
    {
        if (is_object($item) && isset($item->ID)) {
            $content = '';
            $menu_item_desc = get_post_meta($item->ID, '_menu_item_' . $field, true);
            if (!empty($menu_item_desc)) {
                $content =  $menu_item_desc;
            }
        }
        return $content;
    }

  
    // add reusable blocks to admin
    function reusable_blocks_admin_menu() {
        add_menu_page( 'Reusable Blocks', 'Reusable Blocks', 'edit_posts', 'edit.php?post_type=wp_block', '', 'dashicons-editor-table', 22 );
    }
   
    // remove posts from admin menu
    function remove_menus()
    {
        remove_menu_page('edit.php');
    }

    public function add_linkedin_meta_box($post_type) {
        if ($post_type === 'team') {
            add_meta_box('linkedin-meta-box', 'LinkedIn Profile', array($this, 'linkedin_meta_box_markup'), 'team', 'normal', 'default');
        }
    }

    public function linkedin_meta_box_markup($post) {
        $linkedin_value = get_post_meta($post->ID, 'linkedin', true);
        echo '<label for="linkedin_field">LinkedIn Profile:</label>';
        echo '<input type="text" id="linkedin_field" name="linkedin_field" value="' . esc_attr($linkedin_value) . '" />';
    }

    public function save_linkedin_field_data($post_id) {
        if (isset($_POST['linkedin_field']) && get_post_type($post_id) === 'team') {
            $linkedin_value = sanitize_text_field($_POST['linkedin_field']);
            update_post_meta($post_id, 'linkedin', $linkedin_value);
        }
    }
    
    public function add_functie_meta_box($post_type) {
        if ($post_type === 'team') {
            add_meta_box('functie-meta-box', 'Functie', array($this, 'functie_meta_box_markup'), 'team', 'normal', 'default');
        }
    }

    public function functie_meta_box_markup($post) {
        $functie_value = get_post_meta($post->ID, 'functie', true);
        echo '<label for="functie_field">Functie:</label>';
        echo '<input type="text" id="functie_field" name="functie_field" value="' . esc_attr($functie_value) . '" />';
    }

    public function save_functie_field_data($post_id) {
        if (isset($_POST['functie_field']) && get_post_type($post_id) === 'team') {
            $functie_value = sanitize_text_field($_POST['functie_field']);
            update_post_meta($post_id, 'functie', $functie_value);
        }
    }
    
    


}
