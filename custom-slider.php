<?php
/**
 * Plugin Name: Grid View Gallery
 * Version: 1.0
 * Description: A Great gallery plugin to create and display various types of images galleries on WordPress blog.
 * Author: Priya Jain
 * Author URI: https://www.cisin.com/
 * Plugin URI: https://www.cisin.com/
 */

/**
 * Constant Variable
 */
define("CIS_CS_TEXT_DOMAIN","cis_cs" );
define("CIS_CS_PLUGIN_URL", plugin_dir_url(__FILE__));
/**
 * Run 'Install' script on plugin activation
 */
register_activation_hook( __FILE__, 'CS_DefaultSettings' );
function CS_DefaultSettings(){
    $CS_DefaultSettingsArray = serialize( array(
        'CS_Hover_Animation' => "fade",
        'CS_Gallery_Layout' => "col-md-6",
        'CS_Hover_Color' => "#74C9BE",
        'CS_Hover_Color_Opacity' => 1,
        'CS_Font_Style' => "Arial",
        'CS_Image_View_Icon' => "fa-picture-o",
		'CS_Gallery_Title' => "yes" 
    ) );
    add_option("CS_Settings", $CS_DefaultSettingsArray);
}

//Get Ready Plugin Translation
add_action('plugins_loaded', 'CS_GetReadyTranslation');
function Cs_GetReadyTranslation() {
	load_plugin_textdomain(CIS_CS_TEXT_DOMAIN, FALSE, dirname( plugin_basename(__FILE__)).'/languages/' );
}

// Register Custom Post Type
function CS_CPT_Function() {
    $labels = array(
        'name'                => _x( 'Custom Slider', 'Custom Slider', CIS_CS_TEXT_DOMAIN ),
        'singular_name'       => _x( 'Custom Slider', 'Custom Slider', CIS_CS_TEXT_DOMAIN ),
        'menu_name'           => __( 'Custom Slider', CIS_CS_TEXT_DOMAIN ),
        'parent_item_colon'   => __( 'Parent Item:', CIS_CS_TEXT_DOMAIN ),
        'all_items'           => __( 'All Gallery', CIS_CS_TEXT_DOMAIN ),
        'view_item'           => __( 'View Gallery', CIS_CS_TEXT_DOMAIN ),
        'add_new_item'        => __( 'Add New Gallery', CIS_CS_TEXT_DOMAIN ),
        'add_new'             => __( 'Add New Gallery', CIS_CS_TEXT_DOMAIN ),
        'edit_item'           => __( 'Edit Gallery', CIS_CS_TEXT_DOMAIN ),
        'update_item'         => __( 'Update Gallery', CIS_CS_TEXT_DOMAIN ),
        'search_items'        => __( 'Search Gallery', CIS_CS_TEXT_DOMAIN ),
        'not_found'           => __( 'No Gallery Found', CIS_CS_TEXT_DOMAIN ),
        'not_found_in_trash'  => __( 'No Gallery found in Trash', CIS_CS_TEXT_DOMAIN ),
    );
    $args = array(
        'label'               => __( 'Custom Slider', CIS_CS_TEXT_DOMAIN ),
        'description'         => __( 'Custom Slider', CIS_CS_TEXT_DOMAIN ),
        'labels'              => $labels,
        'supports'            => array( 'title', '', '', '', '', '', '', '', '', '', '', ),
        'taxonomies'          => array( 'category', 'post_tag' ),
        'hierarchical'        => false,
        'public'              => false,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => false,
        'show_in_admin_bar'   => false,
        'menu_position'       => 5,
        'menu_icon'           => 'dashicons-format-gallery',
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => false,
        'capability_type'     => 'page',
    );
    register_post_type( 'custom-slider', $args );

}

// Hook into the 'init' action
add_action( 'init', 'CS_CPT_Function', 0 );

/**
 * Add Meta Box & load required CSS and JS for interface
 */

add_action('admin_init','Custom_Slider_init');
function Custom_Slider_init() {
    add_meta_box('Custom_Slider_meta', __('Add New Images', CIS_CS_TEXT_DOMAIN), 'custom_slider_function', 'custom-slider', 'normal', 'high');
    
	add_action('save_post','custom_box_meta_save');
	add_meta_box(__('Plugin Shortcode', CIS_CS_TEXT_DOMAIN) , __('Plugin Shortcode', CIS_CS_TEXT_DOMAIN), 'cs_plugin_shortcode', 'custom-slider', 'side', 'low');
	
    wp_enqueue_script('theme-preview');
    wp_enqueue_script('cs-media-uploads',CIS_CS_PLUGIN_URL.'js/cs-media-upload-script.js',array('media-upload','thickbox','jquery'));
    wp_enqueue_style('dashboard');
    wp_enqueue_style('lbs-meta-css', CIS_CS_PLUGIN_URL.'css/rpg-meta.css');
    wp_enqueue_style('thickbox');
}

/**
*plugin shortcode
**/
function cs_plugin_shortcode(){
	?>
	<p>Use below shortcode in any Page/Post to publish your Custom Slider</p>
	<input readonly="readonly" type="text" value="<?php echo "[CS id=".get_the_ID()."]"; ?>"> 
	<?php
} 

/**
 * Meta box interface design
 */
function custom_slider_function() {
    $cs_all_photos_details = unserialize(get_post_meta( get_the_ID(), 'cs_all_photos_details', true));
    $TotalImages =  get_post_meta( get_the_ID(), 'cs_total_images_count', true );
    $i = 1;
    ?>
	<style>
	#titlediv #title {
		margin-bottom:15px;
	}
	</style>
    <input type="hidden" id="count_total" name="count_total" value="<?php if($TotalImages==0){ echo 0; } else { echo $TotalImages; } ?>"/>
    <div style="clear:left;"></div>

    <?php
    /* load saved photos into gallery */
    if($TotalImages) {
        foreach($cs_all_photos_details as $cs_single_photos_detail) {
            $name = $cs_single_photos_detail['cs_image_label'];
            $image_desc = $cs_single_photos_detail['cs_image_desc'];
            $url = $cs_single_photos_detail['cs_image_url'];
            ?>
                <div class="rpg-image-entry" id="rpg_img<?php echo $i; ?>">
					<a class="gallery_remove" href="#gallery_remove" id="rpg_remove_bt<?php echo $i; ?>"onclick="remove_meta_img(<?php echo $i; ?>)"><img src="<?php echo  CIS_CS_PLUGIN_URL.'images/Close-icon.png'; ?>" /></a>
					<img src="<?php echo  $url; ?>" class="rpg-meta-image" alt=""  style="">
					<input type="button" id="upload-background-<?php echo $i; ?>" name="upload-background-<?php echo $i; ?>" value="Upload Image" class="button-primary" onClick="cisupload_image('<?php echo $i; ?>')" />
					<input type="text" id="img_url<?php echo $i; ?>" name="img_url<?php echo $i; ?>" class="rpg_label_text"  value="<?php echo  $url; ?>"  readonly="readonly" style="display:none;" />
					<input type="text" id="image_label<?php echo $i; ?>" name="image_label<?php echo $i; ?>" placeholder="Enter Image Label" class="rpg_label_text" value="<?php echo $name; ?>">
                    <textarea style="width:100%;" id="image_desc<?php echo $i; ?>" placeholder="Enter Image Description" name="image_desc<?php echo $i; ?>" ><?php echo $image_desc; ?></textarea> 
                
                </div>
            <?php
            $i++;
        } // end of foreach
    } else {
        $TotalImages = 0;
    }
    ?>


    <div id="append_rpg_img">
    </div>
    <div class="rpg-image-entry add_rpg_new_image" onclick="add_rpg_meta_img()">
		<div class="dashicons dashicons-plus"></div>
		<p><?php _e('Add New Image', CIS_CS_TEXT_DOMAIN); ?></p>
    </div>
    <div style="clear:left;"></div>

    <script>
    var rpg_i = parseInt(jQuery("#count_total").val());
    function add_rpg_meta_img() {
        rpg_i = rpg_i + 1;

        var rpg_output = '<div class="rpg-image-entry" id="rpg_img'+ rpg_i +'">'+
                            '<a class="gallery_remove" href="#gallery_remove" id="rpg_remove_bt' + rpg_i + '"onclick="remove_meta_img(' + rpg_i + ')"><img src="<?php echo  CIS_CS_PLUGIN_URL.'images/Close-icon.png'; ?>" /></a>'+
                            '<img src="<?php echo CIS_CS_PLUGIN_URL.'images/rpg-default.jpg'; ?>" class="rpg-meta-image" alt=""  style="">'+
                            '<input type="button" id="upload-background-' + rpg_i + '" name="upload-background-' + rpg_i + '" value="Upload Image" class="button-primary" onClick="cisupload_image(' + rpg_i + ')" />'+
                            '<input type="text" id="img_url'+ rpg_i +'" name="img_url'+ rpg_i +'" class="rpg_label_text"  value="<?php echo  CIS_CS_PLUGIN_URL.'images/rpg-default.jpg'; ?>"  readonly="readonly" style="display:none;" />'+
                            '<input type="text" id="image_label'+ rpg_i +'" name="image_label'+ rpg_i +'" placeholder="Enter Image Label" class="rpg_label_text"   >'+
                            '<textarea id="image_desc'+ rpg_i +'" name="image_desc'+ rpg_i +'" placeholder="Enter Image Description" class="rpg_label_text"   ></textarea>'+
                        '</div>';
        jQuery(rpg_output).hide().appendTo("#append_rpg_img").slideDown(500);
        jQuery("#count_total").val(rpg_i);
    }

    function remove_meta_img(id){
        jQuery("#rpg_img"+id).slideUp(600, function(){
            jQuery(this).remove();
        });

        count_total = jQuery("#count_total").val();
        count_total = count_total - 1;
        var id_i= id + 1;

        for(var i=id_i;i<=rpg_i;i++){
            var j = i-1;
            jQuery("#rpg_remove_bt"+i).attr('onclick','remove_meta_img('+j+')');
            jQuery("#rpg_remove_bt"+i).attr('id','rpg_remove_bt'+j);
            jQuery("#img_url"+i).attr('name','img_url'+j);
            jQuery("#image_label"+i).attr('name','image_label'+j);
            jQuery("#img_url"+i).attr('id','img_url'+j);
            jQuery("#image_label"+i).attr('id','image_label'+j);
            jQuery("#image_desc"+i).attr('id','image_desc'+j);

            jQuery("#rpg_img"+i).attr('id','rpg_img'+j);
        }
        jQuery("#count_total").val(count_total);
        rpg_i = rpg_i - 1;
    }
    </script>
    <?php
}

/**
 * Save All Photo Gallery Images
 */
function custom_box_meta_save() {
    if(isset($_POST['post_ID'])) {
        $post_ID = $_POST['post_ID'];
        $post_type = get_post_type($post_ID);
        if($post_type == 'custom-slider') {
            $TotalImages = $_POST['count_total'];
            $ImagesArray = array();
            if($TotalImages) {
                for($i=1; $i <= $TotalImages; $i++) {
                    $name = stripslashes($_POST['image_label'.$i]);
                    $image_desc = stripslashes($_POST['image_desc'.$i]);
                    $url = $_POST['img_url'.$i];
                    $ImagesArray[] = array(
                        'cs_image_label' => $name,
                        'cs_image_desc' => $image_desc,
                        'cs_image_url' => $url
                    );
                }
                update_post_meta($post_ID, 'cs_all_photos_details', serialize($ImagesArray));
                update_post_meta($post_ID, 'cs_total_images_count', $TotalImages);
            } else {
                $TotalImages = 0;
                update_post_meta($post_ID, 'cs_total_images_count', $TotalImages);
                $ImagesArray = array();
                update_post_meta($post_ID, 'cs_all_photos_details', serialize($ImagesArray));
            }
        }
    }
}

/**
 * Plugin never load plugin CSS & JS files with all theme pages.
 * CSS & JS files only load on required pages where you use or embed [CS] shortcode.
 */
function CISCustomSliderShortCodeDetect() {
    global $wp_query;
    $Posts = $wp_query->posts;
    $Pattern = get_shortcode_regex();

    foreach ($Posts as $Post) {
        if( preg_match_all( '/'. $Pattern .'/s', $Post->post_content, $Matches ) && array_key_exists( 2, $Matches ) && in_array( 'CS', $Matches[2] ) ) {
            /**
             * js scripts
             */
				wp_enqueue_script('jquery');
				wp_enqueue_script('wl-cs-hover-pack-js',CIS_CS_PLUGIN_URL.'js/hover-pack.js', array('jquery'));
				wp_enqueue_script('wl-cs-bootstrap-js',CIS_CS_PLUGIN_URL.'js/bootstrap.min.js', array('jquery'));
				wp_enqueue_script('wl-cs-lightbox',CIS_CS_PLUGIN_URL.'js/lightbox-2.6.min.js', array('jquery'));

            /**
             * css scripts
             */
				wp_enqueue_style('wl-cs-hover-pack-css', CIS_CS_PLUGIN_URL.'css/hover-pack.css');
				wp_enqueue_style('wl-cs-reset-css', CIS_CS_PLUGIN_URL.'css/reset.css');
				wp_enqueue_style('wl-cs-boot-strap-css', CIS_CS_PLUGIN_URL.'css/bootstrap.css');
				wp_enqueue_style('wl-cs-img-gallery-css', CIS_CS_PLUGIN_URL.'css/img-gallery.css');

				wp_enqueue_style('wl-cs-font-awesome-4', CIS_CS_PLUGIN_URL.'css/font-awesome-4.0.3/css/font-awesome.min.css');
				wp_enqueue_style('wl-cs-slider', CIS_CS_PLUGIN_URL.'css/slider.css');

            break;
        } //end of if
    } //end of foreach
}
add_action( 'wp', 'CISCustomSliderShortCodeDetect' );

/**
 * Settings Page for Custom Slider
 */
add_action('admin_menu' , 'CS_SettingsPage');

function CS_SettingsPage() {
    add_submenu_page('edit.php?post_type=custom-slider', __('Settings', CIS_CS_TEXT_DOMAIN), __('Settings', CIS_CS_TEXT_DOMAIN), 'administrator', 'slider-settings', 'custom_slider_settings_page_function');
}

/**
 * Photo Gallery Settings Page
 */
function custom_slider_settings_page_function() {
    //css
	wp_enqueue_script('dashboard');
	wp_enqueue_script('jquery');
	wp_enqueue_style('dashboard');
    wp_enqueue_style('wl-lbs-font-awesome-4', CIS_CS_PLUGIN_URL.'css/font-awesome-4.0.3/css/font-awesome.min.css');
    require_once("custom-slider-settings.php");
}
/**
 * Custom Slider Short Code [CS]
 */
require_once("custom-slider-short-code.php");
