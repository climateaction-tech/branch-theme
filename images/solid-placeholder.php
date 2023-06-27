<?php
/**
 * Produces blank placeholder images on demand.
 *
 * Accepts background, width and height values and outputs a plain PNG image of
 * the specified background color.
 */
if ( file_exists( $_SERVER['DOCUMENT_ROOT'] . '/wp-load.php' ) ) {
	require_once( $_SERVER['DOCUMENT_ROOT'] . '/wp-load.php' );
}

$settings = [
	"background" => isset($_GET['bg']) ? sanitize_hex_color_no_hash( $_GET['bg'] ) : 'ffdd9c',
	"width" => isset($_GET['w']) ? filter_var( $_GET['w'], FILTER_SANITIZE_NUMBER_INT ) : 400,
	"height" => isset($_GET['h']) ? filter_var( $_GET['h'], FILTER_SANITIZE_NUMBER_INT ) : 300,
];

$background = explode(",",hex2rgb($settings['background']));

$options = [
	'options' => [
		'default' => 100,
		'min_range' => 1,
		'max_range' => 2000
	]
];

$width = filter_var( $settings['width'], FILTER_VALIDATE_INT, $options );
$height = filter_var( $settings['height'], FILTER_VALIDATE_INT, $options );

$image = @imagecreate($width, $height) or die("Cannot Initialize new GD image stream");

$background_color = imagecolorallocate($image, $background[0], $background[1], $background[2]);

imagettftext($image, $font_size, 0, $x, $y, $text_color, $font, $text);

header('Content-Type: image/png');

imagepng($image);

imagedestroy($image);


// Convert color code to rgb
function hex2rgb($hex) {
    $hex = str_replace("#", "", $hex);

    switch(strlen($hex)){
        case 1:
            $hex = $hex.$hex;
        case 2:
            $r = hexdec($hex);
            $g = hexdec($hex);
            $b = hexdec($hex);
            break;
        case 3:
            $r = hexdec(substr($hex,0,1).substr($hex,0,1));
            $g = hexdec(substr($hex,1,1).substr($hex,1,1));
            $b = hexdec(substr($hex,2,1).substr($hex,2,1));
            break;
        default:
            $r = hexdec(substr($hex,0,2));
            $g = hexdec(substr($hex,2,2));
            $b = hexdec(substr($hex,4,2));
            break;
    }

    $rgb = array($r, $g, $b);
    return implode(",", $rgb); 
}
