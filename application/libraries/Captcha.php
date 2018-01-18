<?php

/**
 * Generate verify code
 * @author ThuongHH
 */
class Captcha {

    public $width = 150;
    public $height = 50;
    public $minWordLength = 2;
    public $maxWordLength = 6;
    public $Yperiod = 12;
    public $Yamplitude = 14;
    public $Xperiod = 11;
    public $Xamplitude = 5;
    public $maxRotation = 8;
    public $scale = 2;
    public $fontPath = '/public/assets/fonts/';
    public $im;
    // color list
    public $colors = array(array(27, 78, 181), array(22, 163, 35), array(214, 36, 100), array(255, 128, 0), array(0, 128, 128));
    // font list
    public $fonts = array(
        'Antykwa' => array('spacing' => -3, 'minSize' => 25, 'maxSize' => 28, 'font' => 'AntykwaBold.ttf'),
        'Candice' => array('spacing' => -1.5, 'minSize' => 26, 'maxSize' => 29, 'font' => 'Candice.ttf'),
        'DingDong' => array('spacing' => -2, 'minSize' => 22, 'maxSize' => 28, 'font' => 'Ding-DongDaddyO.ttf'),
        'Duality' => array('spacing' => -2, 'minSize' => 28, 'maxSize' => 36, 'font' => 'Duality.ttf'),
        'Heineken' => array('spacing' => -2, 'minSize' => 22, 'maxSize' => 32, 'font' => 'Heineken.ttf'),
        'Jura' => array('spacing' => -2, 'minSize' => 26, 'maxSize' => 30, 'font' => 'Jura.ttf'),
        'StayPuft' => array('spacing' => -1.5, 'minSize' => 26, 'maxSize' => 30, 'font' => 'StayPuft.ttf'),
        'Times' => array('spacing' => -2, 'minSize' => 26, 'maxSize' => 32, 'font' => 'TimesNewRomanBold.ttf'),
        'VeraSans' => array('spacing' => -1, 'minSize' => 18, 'maxSize' => 26, 'font' => 'VeraSansBold.ttf'),
    );
    private $words = 'abcdefghijklmnopqrstuvwxyz';
    private $vocals = 'aeiou';

    public function __construct() {
        $this->fontPath = BASEPATH . '../public' . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'fonts' . DIRECTORY_SEPARATOR;
    }

    /**
     * Create image & display; return text of image
     * @return string
     * @author ThuongHH
     */
    public function CreateImage() {

        $this->ImageAllocate();
        $length = rand($this->minWordLength, $this->maxWordLength);
        for ($i = 0, $text = '', $vocal = rand(0, 1); $i < $length; $i++, $vocal = !$vocal) {
            $text.=$vocal ? substr($this->vocals, mt_rand(0, 4), 1) : substr($this->words, mt_rand(0, 22), 1);
        }
        $this->WriteText($text);
        $this->WaveImage();
        $this->ReduceImage();
        $this->WriteImage();
        $this->Cleanup();
        return $text;
    }

    /**
     * init image
     * @author ThuongHH
     */
    protected function ImageAllocate() {

        if (!empty($this->im))
            imagedestroy($this->im);
        $this->im = imagecreatetruecolor($this->width * $this->scale, $this->height * $this->scale);
        $this->GdBgColor = imagecolorallocate($this->im, 255, 255, 255);

        imagefilledrectangle($this->im, 0, 0, $this->width * $this->scale, $this->height * $this->scale, $this->GdBgColor);
        $color = $this->colors[mt_rand(0, sizeof($this->colors) - 1)];
        $this->GdFgColor = imagecolorallocate($this->im, $color[0], $color[1], $color[2]);
    }

    /**
     * write on image at random position & random fonts
     * @param <type> $text
     * @author ThuongHH
     */
    protected function WriteText($text) {

        $fontcfg = $this->fonts[array_rand($this->fonts)];
        $x = 20 * $this->scale;
        $y = round(($this->height * 27 / 40) * $this->scale);
        $length = strlen($text);
        for ($i = 0; $i < $length; $i++) {
            $degree = rand($this->maxRotation * -1, $this->maxRotation);
            $fontsize = rand($fontcfg['minSize'], $fontcfg['maxSize']) * $this->scale * (1 + (($this->maxWordLength - strlen($text)) * 0.09));
            $coords = imagettftext($this->im, $fontsize, $degree, $x, $y, $this->GdFgColor, $this->fontPath . $fontcfg['font'], substr($text, $i, 1));
            $x += ($coords[2] - $x) + ($fontcfg['spacing'] * $this->scale);
        }
    }

    /**
     * Noise image
     * @author ThuongHH
     */
    protected function WaveImage() {

        $xp = $this->scale * $this->Xperiod * rand(1, 3);
        $k = rand(0, 100);
        for ($i = 0; $i < ($this->width * $this->scale); $i++) {
            imagecopy($this->im, $this->im, $i - 1, sin($k + $i / $xp) * ($this->scale * $this->Xamplitude), $i, 0, 1, $this->height * $this->scale);
        }
        $k = rand(0, 100);
        $yp = $this->scale * $this->Yperiod * rand(1, 2);
        for ($i = 0; $i < ($this->height * $this->scale); $i++) {
            imagecopy($this->im, $this->im, sin($k + $i / $yp) * ($this->scale * $this->Yamplitude), $i - 1, 0, $i, $this->width * $this->scale, 1);
        }
    }

    /**
     * Resize image
     * @author ThuongHH
     */
    protected function ReduceImage() {

        $imResampled = imagecreatetruecolor($this->width, $this->height);
        imagecopyresampled($imResampled, $this->im, 0, 0, 0, 0, $this->width, $this->height, $this->width * $this->scale, $this->height * $this->scale);
        imagedestroy($this->im);
        $this->im = $imResampled;
    }

    /**
     * Set header & display image
     * @author ThuongHH
     */
    protected function WriteImage() {
        header("Content-type: image/jpeg");
        imagejpeg($this->im, null, 90);
    }

    /**
     * clear image source
     * @author ThuongHH
     */
    protected function Cleanup() {
        imagedestroy($this->im);
    }

}

?>