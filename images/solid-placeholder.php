<?php
/**
 * Produces blank placeholder images on demand.
 *
 * Accepts background, width and height values and outputs a plain PNG image of
 * the specified background color.
 */
$settings = [
	"background" => isset($_GET['bg']) ? $_GET['bg'] : 'ffdd9c',
	"width" => isset($_GET['w']) ? $_GET['w'] : 400,
	"height" => isset($_GET['h']) ? $_GET['h'] : 300,
];

$background = explode(",",hex2rgb($settings['background']));
$width = $settings['width'];
$height = $settings['height'];

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
