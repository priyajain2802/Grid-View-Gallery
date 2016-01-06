<?php
    /**
     * Load Saved Image Gallery settings
     */
    $CS_Settings  = unserialize( get_option("CS_Settings") );
    //echo "<pre>"; print_r($CS_Settings);

    if(count($CS_Settings)) {
        $CS_Hover_Animation     = $CS_Settings['CS_Hover_Animation'];
        $CS_Gallery_Layout      = $CS_Settings['CS_Gallery_Layout'];
        $CS_Hover_Color         = $CS_Settings['CS_Hover_Color'];
        $CS_Font_Style          = $CS_Settings['CS_Font_Style'];
        $CS_Image_View_Icon     = $CS_Settings['CS_Image_View_Icon'];
		$CS_Gallery_Title       = $CS_Settings['CS_Gallery_Title'];
    } else {
        $CS_Hover_Animation     = "flow";
        $CS_Gallery_Layout      = "col-md-6";
        $CS_Hover_Color         = "#74C9BE";
        $CS_Font_Style          = "Arial";
        $CS_Image_View_Icon     = "fa-picture-o";
		$CS_Gallery_Title		 = "yes";	
    }
?>

<h2>Custom Slider <?php _e("Settings", CIS_CS_TEXT_DOMAIN); ?></h2>
<form action="?post_type=custom-slider&page=slider-settings" method="post">
    <input type="hidden" id="cs_action" name="cs_action" value="cs-save-settings">
    <table class="form-table">
        <tbody>
            <tr>
                <th scope="row"><label><?php _e("Image Hover Animation", CIS_CS_TEXT_DOMAIN); ?></label></th>
                <td>
                    <select name="cs-hover-animation" id="cs-hover-animation">
                        <optgroup label="Select Animation">
                            <option value="flow" <?php if($CS_Hover_Animation == 'flow') echo "selected=selected"; ?>><?php _e("Flow", CIS_CS_TEXT_DOMAIN); ?></option>
                            <option value="fade" <?php if($CS_Hover_Animation == 'fade') echo "selected=selected"; ?>><?php _e("Fade", CIS_CS_TEXT_DOMAIN); ?></option>
                            <option value="stroke" <?php if($CS_Hover_Animation == 'stroke') echo "selected=selected"; ?>><?php _e("Stroke", CIS_CS_TEXT_DOMAIN); ?></option>
                            <option value="twist" <?php if($CS_Hover_Animation == 'twist') echo "selected=selected"; ?>><?php _e("Twist", CIS_CS_TEXT_DOMAIN); ?></option>
                            <option value="flip" <?php if($CS_Hover_Animation == 'flip') echo "selected=selected"; ?>><?php _e("Flip", CIS_CS_TEXT_DOMAIN); ?></option>
                            <option value="box" <?php if($CS_Hover_Animation == 'box') echo "selected=selected"; ?>><?php _e("Box", CIS_CS_TEXT_DOMAIN); ?></option>
                            <option value="stripe" <?php if($CS_Hover_Animation == 'stripe') echo "selected=selected"; ?>><?php _e("Stripe", CIS_CS_TEXT_DOMAIN); ?></option>
                            <option value="apart-horisontal" <?php if($CS_Hover_Animation == 'apart-horisontal') echo "selected=selected"; ?>><?php _e("Apart Horisontal", CIS_CS_TEXT_DOMAIN); ?></option>
                            <option value="apart-vertical" <?php if($CS_Hover_Animation == 'apart-vertical') echo "selected=selected"; ?>><?php _e("Apart Vertical", CIS_CS_TEXT_DOMAIN); ?></option>
                            <option value="diagonal" <?php if($CS_Hover_Animation == 'diagonal') echo "selected=selected"; ?>><?php _e("Diagonal", CIS_CS_TEXT_DOMAIN); ?></option>
                        </optgroup>
                    </select>
                    <p class="description"><strong><?php _e("Choose an animation effect apply on mouse hover.", CIS_CS_TEXT_DOMAIN); ?></strong> </p>
                </td>
            </tr>
            <tr>
            
                <th scope="row"><label><?php _e("Gallery Layout", CIS_CS_TEXT_DOMAIN); ?></label></th>
                <td>
                    <select name="cs-gallery-layout" id="cs-gallery-layout">
                        <optgroup label="Select Gallery Layout">
                            <option value="col-md-6" <?php if($CS_Gallery_Layout == 'col-md-6') echo "selected=selected"; ?>><?php _e("Two Column", CIS_CS_TEXT_DOMAIN); ?></option>
                            <option value="col-md-4" <?php if($CS_Gallery_Layout == 'col-md-4') echo "selected=selected"; ?>><?php _e("Three Column", CIS_CS_TEXT_DOMAIN); ?></option>
                        </optgroup>
                    </select>
                    <p class="description"><strong><?php _e("Choose a column layout for image gallery.", CIS_CS_TEXT_DOMAIN); ?></strong></p>
                </td>
            </tr>
			<tr>
                <th scope="row"><label><?php _e("Display Gallery Title", CIS_CS_TEXT_DOMAIN); ?></label></th>
                <td>
                    <input type="radio" name="cs-gallery-title" id="cs-gallery-title" value="yes" <?php if($CS_Gallery_Title == 'yes' ) { echo "checked"; } ?>> Yes
                    <input type="radio" name="cs-gallery-title" id="cs-gallery-title" value="no" <?php if($CS_Gallery_Title == 'no' ) { echo "checked"; } ?>> No

                    <p class="description"><strong><?php _e("Select yes if you want show gallery title .", CIS_CS_TEXT_DOMAIN); ?></strong> </p>
                </td>
            </tr>
            <tr>
                <th scope="row"><label><?php _e("Hover Color", CIS_CS_TEXT_DOMAIN); ?></label></th>
                <td>
                    <input type="radio" name="cs-hover-color" id="cs-hover-color" value="#74C9BE" <?php if($CS_Hover_Color == '#74C9BE' ) { echo "checked"; } ?>> <span style="color: #74C9BE; font-size: large; font-weight: bolder;"><?php _e("Color 1", CIS_CS_TEXT_DOMAIN); ?></span>
                    <input type="radio" name="cs-hover-color" id="cs-hover-color" value="#31A3DD" <?php if($CS_Hover_Color == '#31A3DD' ) { echo "checked"; } ?>> <span style="color: #31A3DD; font-size: large; font-weight: bolder;"><?php _e("Color 2", CIS_CS_TEXT_DOMAIN); ?></span>

                    <p class="description"><strong><?php _e("Choose a color apply on mouse hover.", CIS_CS_TEXT_DOMAIN); ?></strong></p>
                </td>
            </tr>

            <tr>
                <th scope="row"><label><?php _e("Image View Icon", CIS_CS_TEXT_DOMAIN); ?></label></th>
                <td>
                    <input type="radio" name="cs-image-view-icon" id="cs-image-view-icon" value="fa-picture-o"  <?php if($CS_Image_View_Icon == 'fa-picture-o' ) { echo "checked"; } ?>> <i class="fa fa-picture-o fa-2x"></i>
                    <input type="radio" name="cs-image-view-icon" id="cs-image-view-icon" value="fa-camera" <?php if($CS_Image_View_Icon == 'fa-camera' ) { echo "checked"; } ?>> <i class="fa fa-camera fa-2x"></i>
                    <input type="radio" name="cs-image-view-icon" id="cs-image-view-icon" value="fa-camera-retro" <?php if($CS_Image_View_Icon == 'fa-camera-retro' ) { echo "checked"; } ?>> <i class="fa fa-camera-retro fa-2x"></i>
                    <p class="description"><strong><?php _e("Choose image view icon.", CIS_CS_TEXT_DOMAIN); ?></strong></p>
                </td>
            </tr>

            <tr>
                <th scope="row"><label><?php _e("Caption Font Style", CIS_CS_TEXT_DOMAIN); ?></label></th>
                <td>
                    <select  name="cs-font-style" class="standard-dropdown" id="cs-font-style">
                        <optgroup label="Default Fonts">
                            <option value="Arial"           <?php if($CS_Font_Style == 'Arial' ) { echo "selected"; } ?>>Arial</option>
                            <option value="Arial Black"    <?php if($CS_Font_Style == 'Arial Black' ) { echo "selected"; } ?>>Arial Black</option>
                            <option value="Courier New"     <?php if($CS_Font_Style == 'Courier New' ) { echo "selected"; } ?>>Courier New</option>
                            <option value="Georgia"         <?php if($CS_Font_Style == 'Georgia' ) { echo "selected"; } ?>>Georgia</option>
                            <option value="Grande"          <?php if($CS_Font_Style == 'Grande' ) { echo "selected"; } ?>>Grande</option>
                            <option value="Helvetica" <?php if($CS_Font_Style == 'Helvetica' ) { echo "selected"; } ?>>Helvetica Neue</option>
                            <option value="Impact"         <?php if($CS_Font_Style == 'Impact' ) { echo "selected"; } ?>>Impact</option>
                            <option value="Lucida"         <?php if($CS_Font_Style == 'Lucida' ) { echo "selected"; } ?>>Lucida</option>
                            <option value="Lucida Grande"         <?php if($CS_Font_Style == 'Lucida Grande' ) { echo "selected"; } ?>>Lucida Grande</option>
                            <option value="_OpenSansBold"   <?php if($CS_Font_Style == '_OpenSansBold' ) { echo "selected"; } ?>>OpenSansBold</option>
                            <option value="Palatino Linotype"       <?php if($CS_Font_Style == 'Palatino Linotype' ) { echo "selected"; } ?>>Palatino</option>
                            <option value="Sans"           <?php if($CS_Font_Style == 'Sans' ) { echo "selected"; } ?>>Sans</option>
                            <option value="sans-serif"           <?php if($CS_Font_Style == 'sans-serif' ) { echo "selected"; } ?>>Sans-Serif</option>
                            <option value="Tahoma"         <?php if($CS_Font_Style == 'Tahoma' ) { echo "selected"; } ?>>Tahoma</option>
                            <option value="Times New Roman"          <?php if($CS_Font_Style == 'Times New Roman' ) { echo "selected"; } ?>>Times New Roman</option>
                            <option value="Trebuchet"      <?php if($CS_Font_Style == 'Trebuchet' ) { echo "selected"; } ?>>Trebuchet</option>
                            <option value="Verdana"        <?php if($CS_Font_Style == 'Verdana' ) { echo "selected"; } ?>>Verdana</option>
                        </optgroup>
                    </select>
                    <p class="description"><strong><?php _e("Choose a caption font style.", CIS_CS_TEXT_DOMAIN); ?></strong> </p>
                </td>
            </tr>
		
        </tbody>
    </table>
    <p class="submit">
        <input type="submit" value="<?php _e("Save Changes", CIS_CS_TEXT_DOMAIN); ?>" class="button button-primary" id="submit" name="submit">
    </p>
</form>
	
<?php
if(isset($_POST['cs_action'])) {
    $Action = $_POST['cs_action'];
    //save settings
    if($Action == "cs-save-settings") {

        $CS_Hover_Animation     = $_POST['cs-hover-animation'];
        $CS_Gallery_Layout      = $_POST['cs-gallery-layout'];
        $CS_Hover_Color         = $_POST['cs-hover-color']; 
        $CS_Font_Style          = $_POST['cs-font-style'];
        $CS_Image_View_Icon     = $_POST['cs-image-view-icon'];
		$CS_Gallery_Title		= $_POST['cs-gallery-title'];
        
        $SettingsArray = serialize( array(
            'CS_Hover_Animation' => $CS_Hover_Animation,
            'CS_Gallery_Layout' => $CS_Gallery_Layout,
            'CS_Hover_Color' => $CS_Hover_Color,
            'CS_Hover_Color_Opacity' => 1,
            'CS_Font_Style' => $CS_Font_Style,
            'CS_Image_View_Icon' => $CS_Image_View_Icon,
			'CS_Gallery_Title' => $CS_Gallery_Title
        ) );

        update_option("CS_Settings", $SettingsArray);
        echo "<script>location.href = location.href;</script>";
    }
}
