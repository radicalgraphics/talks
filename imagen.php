<?php
set_time_limit(300);
ini_set('memory_limit', '9200000000000000000000M');
function resizeFit($im,$width,$height) {
    //Original sizes
    $ow = imagesx($im); $oh = imagesy($im);
    
    //To fit the image in the new box by cropping data from the image, i have to check the biggest prop. in height and width
    if($width/$ow > $height/$oh) {
        $nw = $width;
        $nh = ($oh * $nw) / $ow;
        $px = 0;
        $py = ($height - $nh) / 2;
    } else {
        $nh = $height;
        $nw = ($ow * $nh) / $oh;
        $py = 0;
        $px = ($width - $nw) / 2;
    }
    
    //Create a new image width requested size
    $new = imagecreatetruecolor($width,$height);
    
    //Copy the image loosing the least space
    imagecopyresampled($new, $im, $px, $py, 0, 0, $nw, $nh, $ow, $oh);
    
    return $new;
}
//Primero creo el resource de la imagen desde el original en JPEG
$im = imagecreatefromjpeg($_GET['img']);
 
//Ahora uso la función antes definida, con unos parámetros de ancho y alto que yo quiera
$resized = resizeFit($im, 337, 161);
//Indico en la cabecera HTTP que es una imagen
header("Content-type: image/png");
 
//Por último exporto la nueva imagen
imagepng($resized);
?> 
