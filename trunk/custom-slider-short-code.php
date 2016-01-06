<?php
/**
 * Custom Slider Shortcode
 */
add_shortcode( 'CS', 'custom_slider_short_code' );
function custom_slider_short_code($Id) {
	ob_start();
	if(!isset($Id['id'])) {
	$Id['id'] = "";
	}
	else{
		$lbs_id = $Id['id'];
	}
    /**
     * Load Custom Slider Settings
     */
    $custom_Settings  = unserialize( get_option("CS_Settings") );
    if(count($custom_Settings)) {
        $CS_Hover_Animation     = $custom_Settings['CS_Hover_Animation'];
        $CS_Gallery_Layout      = $custom_Settings['CS_Gallery_Layout'];
        $CS_Hover_Color         = $custom_Settings['CS_Hover_Color'];
        $CS_Hover_Color_Opacity = 1;
        $CS_Font_Style          = $custom_Settings['CS_Font_Style'];
        $CS_Image_View_Icon     = $custom_Settings['CS_Image_View_Icon'];
		$CS_Gallery_Title       = $custom_Settings['CS_Gallery_Title'];
    } else {
		$CS_Hover_Color_Opacity = 1;
		$CS_Hover_Animation     = "flow";
        $CS_Gallery_Layout      = "col-md-6";
        $CS_Hover_Color         = "#74C9BE";
        $CS_Font_Style          = "Arial";
        $CS_Image_View_Icon     = "fa-picture-o";
		$CS_Gallery_Title = "yes";
    }
	if(!function_exists('cs_hex2rgb')) {
		function cs_hex2rgb($hex) {
		   $hex = str_replace("#", "", $hex);

		   if(strlen($hex) == 3) {
			  $r = hexdec(substr($hex,0,1).substr($hex,0,1));
			  $g = hexdec(substr($hex,1,1).substr($hex,1,1));
			  $b = hexdec(substr($hex,2,1).substr($hex,2,1));
		   } else {
			  $r = hexdec(substr($hex,0,2));
			  $g = hexdec(substr($hex,2,2));
			  $b = hexdec(substr($hex,4,2));
		   }
		   $rgb = array($r, $g, $b);

		   return $rgb; // returns an array with the rgb values
		}
	}
    $RGB = cs_hex2rgb($CS_Hover_Color);
    $HoverColorRGB = implode(", ", $RGB);
    ?>

    <script>
        jQuery.browser = {};
        (function () {
            jQuery.browser.msie = false;
            jQuery.browser.version = 0;
            if (navigator.userAgent.match(/MSIE ([0-9]+)\./)) {
                jQuery.browser.msie = true;
                jQuery.browser.version = RegExp.$1;
            }
        })();
    </script>

    <style>
    .b-link-fade .b-wrapper, .b-link-fade .b-top-line{
        background: rgba(<?php echo $HoverColorRGB; ?>, <?php echo $CS_Hover_Color_Opacity; ?>);
    }
    .b-link-flow .b-wrapper, .b-link-flow .b-top-line{
        background: rgba(<?php echo $HoverColorRGB; ?>, <?php echo $CS_Hover_Color_Opacity; ?>);
    }
    .b-link-stroke .b-top-line{
        background: rgba(<?php echo $HoverColorRGB; ?>, <?php echo $CS_Hover_Color_Opacity; ?>);
    }
    .b-link-stroke .b-bottom-line{
        background: rgba(<?php echo $HoverColorRGB; ?>, <?php echo $CS_Hover_Color_Opacity; ?>);
    }

    .b-link-box .b-top-line{

        border: 16px solid rgba(<?php echo $HoverColorRGB; ?>, <?php echo $CS_Hover_Color_Opacity; ?>);
    }
    .b-link-box .b-bottom-line{
        background: rgba(<?php echo $HoverColorRGB; ?>, <?php echo $CS_Hover_Color_Opacity; ?>);
    }
    .b-link-stripe .b-line{
        background: rgba(<?php echo $HoverColorRGB; ?>, <?php echo $CS_Hover_Color_Opacity; ?>);
    }
    .b-link-apart-horisontal .b-top-line, .b-link-apart-horisontal .b-top-line-up{
        background: rgba(<?php echo $HoverColorRGB; ?>, <?php echo $CS_Hover_Color_Opacity; ?>);

    }
    .b-link-apart-horisontal .b-bottom-line, .b-link-apart-horisontal .b-bottom-line-up{
        background: rgba(<?php echo $HoverColorRGB; ?>, <?php echo $CS_Hover_Color_Opacity; ?>);
    }
    .b-link-apart-vertical .b-top-line, .b-link-apart-vertical .b-top-line-up{
        background: rgba(<?php echo $HoverColorRGB; ?>, <?php echo $CS_Hover_Color_Opacity; ?>);
    }
    .b-link-apart-vertical .b-bottom-line, .b-link-apart-vertical .b-bottom-line-up{
        background: rgba(<?php echo $HoverColorRGB; ?>, <?php echo $CS_Hover_Color_Opacity; ?>);
    }
    .b-link-diagonal .b-line{
        background: rgba(<?php echo $HoverColorRGB; ?>, <?php echo $CS_Hover_Color_Opacity; ?>);
    }

    .b-wrapper{
        font-family:<?php echo str_ireplace("+", " ", $CS_Font_Style); ?>; // real name pass here
    }
	.enigma_home_portfolio_caption h3{
	font-family:<?php echo str_ireplace("+", " ", $CS_Font_Style); ?>; // real name pass here
    
	}
	.gal-container img {
	max-width:1600px !important;
	}
	.gal-container .row {
	margin-right: 0;
	margin-left: 0;
	}
	.lightbox .lb-image {
   
    max-width: 1600px !important;
	}
    </style>

    <?php
    /**
     * Load All Image Custom Custom Post Type
     */
    $IG_CPT_Name = "custom-slider";
    $IG_Taxonomy_Name = "category";
	$all_posts = wp_count_posts( 'custom-slider')->publish;
	$category = get_the_category( $Id['id'] );
	
	$AllGalleries = array( 'p' => $Id['id'], 'post_type' => $IG_CPT_Name, 'category' => $category[0]->cat_ID, 'orderby' => 'ASC','posts_per_page' =>$all_posts);
    $loop = new WP_Query( $AllGalleries );
    ?>
    <div id="gallery1" class="gal-container">
		<?php while ( $loop->have_posts() ) : $loop->the_post();?>
			<!--get the post id-->
			<?php $post_id = get_the_ID(); ?>
			<div id="<?php echo get_the_title($post_id); ?>" style="display: block; overflow:hidden; padding-bottom:20px;">
					<?php if($CS_Gallery_Title==""){ $CS_Gallery_Title == "yes"; } if($CS_Gallery_Title == "yes") { ?>
				<!-- cs gallery title-->
				<div style="font-weight: bolder;padding-bottom:20px;border-bottom:2px solid #f2f2f2;text-align:center ;margin-bottom: 20px;font-size:16px;">
					<?php echo get_the_title($post_id); ?>
				</div>
				<?php } ?>
				<!--custom gallery photos-->
				<div>
					<div class="row">
					<?php

						/**
						 * Get All Photos from Gallery Post Meta
						 */
						$cs_all_photos_details = unserialize(get_post_meta( get_the_ID(), 'cs_all_photos_details', true));
						$TotalImages =  get_post_meta( get_the_ID(), 'cs_total_images_count', true );
						$i = 1;

						foreach($cs_all_photos_details as $cs_single_photos_detail) {
							$name = $cs_single_photos_detail['cs_image_label'];
							$url = $cs_single_photos_detail['cs_image_url'];
							$desc = $cs_single_photos_detail['cs_image_desc'];
						?>
							
							
							<div class="<?php echo $CS_Gallery_Layout; ?>  wl-gallery" >
								<div style="box-shadow: 0 0 6px rgba(0,0,0,.7);">
									<div class="b-link-<?php echo $CS_Hover_Animation; ?> b-animate-go">

										<img src="<?php echo $url; ?>" class="gall-img-responsive">

										<div class="b-wrapper">
											<p class="b-scale b-animate b-delay03">
												<a href="<?php echo $url; ?>" data-lightbox="image" title="<?php echo $name; ?>" class="hover_thumb">
													<i class="fa <?php echo $CS_Image_View_Icon; ?> fa-4x"></i>
												</a>
											</p>
										</div>

									</div>
									<?php 
									if($name)
									{
									?>
										<div class="enigma_home_portfolio_caption">
											<h3><?php echo $name; ?></h3>
											<p><?php echo $desc; ?></p>
										</div>
									<?php 
									}
									?>		
								</div>
							</div>
							<?php if($CS_Gallery_Layout=="col-md-4")
							{
								 if($i%3==0){
								?>
									</div>
									<div class="row">
									<?php
								}
							}
							else{
							 if($i%2==0){
								?>
									</div>
									<div class="row">
									<?php
								}
							}
							$i++;
						}
					?>
					</div>
				</div>
			</div>
		<?php endwhile; ?>
    </div>
	
    <?php wp_reset_query(); ?>
    <?php
	return ob_get_clean();
}
?>