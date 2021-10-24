<?php

namespace App\Fonctionality;

use Illuminate\Support\Facades\Storage;
use imagickdraw;
use phpDocumentor\Reflection\Types\Null_;

class CodeBarre
{
    const CODE_ABAR = "CODABAR";
    const CODE_11 = "CODE11";
    const CODE_39 = "CODE39";
    const CODE_39PLUS = "CODE39PLUS";
    const CODE_39EXT = "CODE39EXT";
    const CODE_39EXTPLUS = "CODE39EXTPLUS";
    const CODE_93 = "CODE93";
    const CODE_128 = "CODE128";
    const CODE_128A = "CODE128A";
    const CODE_128B = "CODE128B";
    const CODE_128C = "CODE128C";
    const CODE_STD25 = "STD25";
    const CODE_STD25PLUS = "STD25PLUS";
    const CODE_INT25 = "INT25";
    const CODE_INT25PLUS = "INT25PLUS";
    const CODE_EAN2 = "EAN2";
    const CODE_EAN5 = "EAN5";
    const CODE_EAN8 = "EAN8";
    const CODE_EAN13 = "EAN13";
    const CODE_UPCA = "UPCA";
    const CODE_UPCE = "UPCE";
    const CODE_MSI = "MSI";
    const CODE_MSIPLUS = "MSIPLUS";
    const CODE_POSTNET = "POSTNET";
    const CODE_PLANET = "PLANET";
    const CODE_RMS4CC = "RMS4CC";
    const CODE_KIX = "KIX";
    const CODE_IMB = "IMB";
    const CODE_PHARMA = "PHARMA";
    const CODE_PHARMA2T = "PHARMA2T";
    const CODE_DATAMATRIX = "DATAMATRIX";
    const CODE_PDF417 = "PDF417";
    const CODE_PDF417PLUS = "PDF417PLUS";
    const CODE_QRCODE = "QRCODE";
    const CODE_QRCODELOW = "QRCODELOW";
    const CODE_QRCODEMEDIUM = "QRCODEMEDIUM";
    const CODE_QRCODEBETTER = "QRCODEBETTER";
    const CODE_QRCODEHIG = "QRCODEHIG";

    const CODE_RAW = "RAW";
    const CODE_RAW2 = "RAW2";
    const CODE_TEST = "TEST";

    private $Type = self::CODE_11;
    public function setType(string $type)
    {
        $this->Type = $type;
        $this->setBarcode();
    }

    public function getType()
    {
        return $this->Type;
    }

    private $store_path = 'cb/';

    const EXTENSIONSVG = "svg";
    const EXTENSIONPNG = "png";

    private $extension = self::EXTENSIONSVG;

    public function setExtension($extension)
    {
        $this->extension = $extension;
    }
    public function getExtension()
    {
        return $this->extension;
    }

    private function getNameFile()
    {
        $namefile = str_replace(["*", "%", "//", "/", "http:","https:","?"], "", $this->barcode_array['code']) . '.' . $this->getExtension();
        return $namefile;
    }

    private $w = 3;
    public function setwidth($width)
    {
        $this->w = $width;
    }
    public function getwidth()
    {
        return $this->w;
    }

    private $h = 3;
    public function setheight($height)
    {
        $this->h = $height;
    }
    public function getheight()
    {
        return $this->h;
    }


    private $color = "black";
    public function setColor(string $color)
    {
        $this->color = $color;
    }
    public function getColor()
    {
        return $this->color;
    }


    private $barcode_array = false;
    private  $datas = null;

    public function __construct($datas)
    {
        $this->datas = $datas;
    }

    private function setBarcode()
    {
        switch ($this->GetType()) {

            // CODE 11
            case self::CODE_11 :
            {
                $cb11 = new Code11($this->datas);
                $this->barcode_array = $cb11->getdata();
                break;
            }

            // CODE 39 - ANSI MH10.8M-1983 - USD-3 - 3 of 9.
            case self::CODE_39 :
            {
                $cb = new Code39($this->datas);
                $this->barcode_array = $cb->getdata();
                break;
            }

            // CODE 39 with checksum
            case self::CODE_39PLUS :
            {
                $cb = new Code39($this->datas, false, true);
                $this->barcode_array = $cb->getdata();
                break;
            }

            // CODE 39 EXTENDED
            case self::CODE_39EXT :
            {
                $cb = new Code39($this->datas, true, false);
                $this->barcode_array = $cb->getdata();
                break;
            }

            // CODE 39 EXTENDED + CHECKSUM
            case self::CODE_39EXTPLUS :
            {
                $cb = new Code39($this->datas, true, true);
                $this->barcode_array = $cb->getdata();
                break;
            }

            // CODE 93 - USS-93
            case  self::CODE_93 :
            {
                $cb = new Code93($this->datas);
                $this->barcode_array = $cb->getdata();
                break;
            }

            // Standard 2 of 5
            case self::CODE_STD25 :
            {
                $cb = new CodeStd25($this->datas, false);
                $this->barcode_array = $cb->getdata();
                //$this->barcode_array = $this->barcode_s25($this->datas, false);
                break;
            }

            // Standard 2 of 5 + CHECKSUM
            case self::CODE_STD25PLUS :
            {
                $cb = new CodeStd25($this->datas, true);
                $this->barcode_array = $cb->getdata();
                //$this->barcode_array = $this->barcode_s25($this->datas, true);
                break;
            }

            // Interleaved 2 of 5
            case self::CODE_INT25 :
            {
                //$this->barcode_array = $this->barcode_i25($this->datas, false);
                $cb = new CodeInt25($this->datas, false);
                $this->barcode_array = $cb->getdata();
                break;
            }

            // Interleaved 2 of 5 + CHECKSUM
            case self::CODE_INT25PLUS :
            {
                //$this->barcode_array = $this->barcode_i25($this->datas, true);
                $cb = new CodeInt25($this->datas, true);
                $this->barcode_array = $cb->getdata();
                break;
            }

            // CODE 128
            case self::CODE_128 :
            {
                //$this->barcode_array = $this->barcode_i25($this->datas, true);
                $cb = new Code128($this->datas, '');
                $this->barcode_array = $cb->getdata();
                break;
            }

            // CODE 128A
            case self::CODE_128A :
            {
                //$this->barcode_array = $this->barcode_i25($this->datas, true);
                $cb = new Code128($this->datas, 'A');
                $this->barcode_array = $cb->getdata();
                break;
            }

            // CODE 128B
            case self::CODE_128B :
            {
                //$this->barcode_array = $this->barcode_i25($this->datas, true);
                $cb = new Code128($this->datas, 'B');
                $this->barcode_array = $cb->getdata();
                break;
            }

            // CODE 128C
            case self::CODE_128C :
            {
                //$this->barcode_array = $this->barcode_i25($this->datas, true);
                $cb = new Code128($this->datas, 'C');
                $this->barcode_array = $cb->getdata();
                break;
            }


            // 2-Digits UPC-Based Extention
            case self::CODE_EAN2 :
            {
                //$this->barcode_array = $this->barcode_eanext($this->datas, 2);
                $cb = new CodeEAN($this->datas, 2);
                $this->barcode_array = $cb->getdata();
                break;
            }

            // 5-Digits UPC-Based Extention
            case self::CODE_EAN5 :
            {
                //$this->barcode_array = $this->barcode_eanext($this->datas, 5);
                $cb = new CodeEAN($this->datas, 5);
                $this->barcode_array = $cb->getdata();
                break;
            }

            // EAN 8
            case self::CODE_EAN8 :
            {
                //$this->barcode_array = $this->barcode_eanupc($this->datas, 8);
                $cb = new CodeEanUpc($this->datas, 8);
                $this->barcode_array = $cb->getdata();
                break;
            }

            // EAN 13
            case self::CODE_EAN13 :
            {
                //$this->barcode_array = $this->barcode_eanupc($this->datas, 13);
                $cb = new CodeEanUpc($this->datas, 13);
                $this->barcode_array = $cb->getdata();
                break;
            }

            // UPC-A
            case self::CODE_UPCA :
            {
                //$this->barcode_array = $this->barcode_eanupc($this->datas, 12);
                $cb = new CodeEanUpc($this->datas, 12);
                $this->barcode_array = $cb->getdata();
                break;
            }

            // UPC-E
            case self::CODE_UPCE :
            {
                //$this->barcode_array = $this->barcode_eanupc($this->datas, 6);
                $cb = new CodeEanUpc($this->datas, 6);
                $this->barcode_array = $cb->getdata();
                break;
            }

            // MSI (Variation of Plessey code)
            case self::CODE_MSI :
            {
                //$this->barcode_array = $this->barcode_msi($this->datas, false);
                $cb = new CodeMsi($this->datas, false);
                $this->barcode_array = $cb->getdata();
                break;
            }

            // MSI + CHECKSUM (modulo 11)
            case self::CODE_MSIPLUS :
            {
                //$this->barcode_array = $this->barcode_msi($this->datas, true);
                $cb = new CodeMsi($this->datas, true);
                $this->barcode_array = $cb->getdata();
                break;
            }

            // POSTNET
            case self::CODE_POSTNET :
            {
                //$this->barcode_array = $this->barcode_postnet($this->datas, false);
                $cb = new CodePosteNet($this->datas, false);
                $this->barcode_array = $cb->getdata();
                break;
            }

            // PLANET
            case self::CODE_PLANET :
            {
                //$this->barcode_array = $this->barcode_postnet($this->datas, true);
                $cb = new CodePosteNet($this->datas, true);
                $this->barcode_array = $cb->getdata();
                break;
            }

            // RMS4CC (Royal Mail 4-state Customer Code) - CBC (Customer Bar Code)
            case self::CODE_RMS4CC :
            { // RMS4CC (Royal Mail 4-state Customer Code) - CBC (Customer Bar Code)
                //$this->barcode_array = $this->barcode_rms4cc($this->datas, false);
                $cb = new CodeRMS4CC($this->datas, false);
                $this->barcode_array = $cb->getdata();
                break;
            }

            // KIX (Klant index - Customer index)
            case self::CODE_KIX :
            { // RMS4CC (Royal Mail 4-state Customer Code) - CBC (Customer Bar Code)
                //$this->barcode_array = $this->barcode_rms4cc($this->datas, true);
                $cb = new CodeRMS4CC($this->datas, true);
                $this->barcode_array = $cb->getdata();

                break;
            }

            // IMB - Intelligent Mail Barcode - Onecode - USPS-B-3200
            case self::CODE_IMB :
            {
                //$this->barcode_array = $this->barcode_imb($this->datas);
                $cb = new CodeIMB($this->datas);
                $this->barcode_array = $cb->getdata();
                break;
            }

            // CODABAR
            case self::CODE_ABAR :
            {
                //$this->barcode_array = $this->barcode_codabar($this->datas);
                $cb = new CodeABar($this->datas);
                $this->barcode_array = $cb->getdata();
                break;
            }

            // PHARMACODE
            case self::CODE_PHARMA :
            { // PHARMACODE
                //$this->barcode_array = $this->barcode_pharmacode($this->datas);
                $cb = new CodePharma($this->datas);
                $this->barcode_array = $cb->getdata();
                break;
            }

            // PHARMACODE TWO-TRACKS
            case self::CODE_PHARMA2T :
            { // PHARMACODE TWO-TRACKS
                //$this->barcode_array = $this->barcode_pharmacode2t($this->datas);
                $cb = new CodePharma2t($this->datas);
                $this->barcode_array = $cb->getdata();
                break;
            }

            // DATAMATRIX (ISO/IEC 16022)
            case self::CODE_DATAMATRIX : {
                $barcode = new Datamatrix($this->datas);
                $this->barcode_array = $barcode->getBarcodeArray();
                $this->barcode_array['code'] = $this->datas;
                break;
            }

            // PDF417 (ISO/IEC 15438:2006)
            case self::CODE_PDF417 : {
                if (!isset($mode[1]) OR ($mode[1] === '')) {
                    $aspectratio = 2; // default aspect ratio (width / height)
                } else {
                    $aspectratio = (float)$mode[1];
                }
                if (!isset($mode[2]) OR ($mode[2] === '')) {
                    $ecl = -1; // default error correction level (auto)
                } else {
                    $ecl = (int)$mode[2];
                }
                // set macro block
                $macro = array();
                if (isset($mode[3]) AND ($mode[3] !== '') AND isset($mode[4]) AND ($mode[4] !== '') AND isset($mode[5]) AND ($mode[5] !== '')) {
                    $macro['segment_total'] = intval($mode[3]);
                    $macro['segment_index'] = intval($mode[4]);
                    $macro['file_id'] = strtr($mode[5], "\xff", ',');
                    for ($i = 0; $i < 7; ++$i) {
                        $o = $i + 6;
                        if (isset($mode[$o]) AND ($mode[$o] !== '')) {
                            // add option
                            $macro['option_' . $i] = strtr($mode[$o], "\xff", ',');
                        }
                    }
                }
                $barcode = new PDF417($this->datas, $ecl, $aspectratio, $macro);
                $this->barcode_array = $barcode->getBarcodeArray();
                $this->barcode_array['code'] = $this->datas;
                break;
            }

            // QR-CODE
            case self::CODE_QRCODE : {
                if (!isset($mode[1]) OR (!in_array($mode[1], array('L', 'M', 'Q', 'H')))) {
                    $mode[1] = 'L'; // Ddefault: Low error correction
                }
                $barcode = new QRcode($this->datas, strtoupper($mode[1]));
                $this->barcode_array = $barcode->getBarcodeArray();
                $this->barcode_array['code'] = $this->datas;
                break;
            }


            default:
            {
                $this->barcode_array = false;
                break;
            }
        }
    }

    protected function toSVG($showCode = true, $inline = false)
    {
         switch ($this->getType()){
             // CODE 11
             case self::CODE_11 :
             // CODE 39 - ANSI MH10.8M-1983 - USD-3 - 3 of 9.
             case self::CODE_39 :
             // CODE 39 with checksum
             case self::CODE_39PLUS :
             // CODE 39 EXTENDED
             case self::CODE_39EXT :
             // CODE 39 EXTENDED + CHECKSUM
             case self::CODE_39EXTPLUS :
             // CODE 93 - USS-93
             case  self::CODE_93 :
             // Standard 2 of 5
             case self::CODE_STD25 :
             // Standard 2 of 5 + CHECKSUM
             case self::CODE_STD25PLUS :
             // Interleaved 2 of 5
             case self::CODE_INT25 :
             // Interleaved 2 of 5 + CHECKSUM
             case self::CODE_INT25PLUS :
             // CODE 128
             case self::CODE_128 :
             // CODE 128A
             case self::CODE_128A :
             // CODE 128B
             case self::CODE_128B :
             // CODE 128C
             case self::CODE_128C :
             // 2-Digits UPC-Based Extention
             case self::CODE_EAN2 :
             // 5-Digits UPC-Based Extention
             case self::CODE_EAN5 :
             // EAN 8
             case self::CODE_EAN8 :
             // EAN 13
             case self::CODE_EAN13 :
             // UPC-A
             case self::CODE_UPCA :
             // UPC-E
             case self::CODE_UPCE :
             // MSI (Variation of Plessey code)
             case self::CODE_MSI :
             // MSI + CHECKSUM (modulo 11)
             case self::CODE_MSIPLUS :
             // POSTNET
             case self::CODE_POSTNET :
             // PLANET
             case self::CODE_PLANET :
             // RMS4CC (Royal Mail 4-state Customer Code) - CBC (Customer Bar Code)
             case self::CODE_RMS4CC :
             // KIX (Klant index - Customer index)
             case self::CODE_KIX :
             // IMB - Intelligent Mail Barcode - Onecode - USPS-B-3200
             case self::CODE_IMB :
             // CODABAR
             case self::CODE_ABAR :
             // PHARMACODE
             case self::CODE_PHARMA :
             // PHARMACODE TWO-TRACKS
             case self::CODE_PHARMA2T :
             {
                 // replace table for special characters
                 $repstr = array("\0" => '', '&' => '&amp;', '<' => '&lt;', '>' => '&gt;');

                 if (!$inline) {
                     $svg = '<' . '?' . 'xml version="1.0" standalone="no"' . '?' . '>' . "\n";
                     $svg .= '<!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">' . "\n";
                 }

                 $svg .= '<svg width="' . round(($this->barcode_array['maxw'] * $this->getwidth()), 3) . '" height="' . $this->getheight() . '" version="1.1" xmlns="http://www.w3.org/2000/svg">' . "\n";
                 $svg .= "\t" . '<g id="bars" fill="' . $this->getColor() . '" stroke="none">' . "\n";

                 // print bars
                 $x = 0;
                 foreach ($this->barcode_array['bcode'] as $k => $v) {
                     $bw = round(($v['w'] * $this->getwidth()), 3);
                     $bh = round(($v['h'] * $this->getheight() / $this->barcode_array['maxh']), 3);
                     if ($showCode)
                         $bh -= 12;
                     if ($v['t']) {
                         $y = round(($v['p'] * $this->getheight() / $this->barcode_array['maxh']), 3);
                         // draw a vertical bar
                         $svg .= "\t\t" . '<rect x="' . $x . '" y="' . $y . '" width="' . $bw . '" height="' . $bh . '" />' . "\n";
                     }
                     $x += $bw;
                 }

                 //dd($this->barcode_array['code']);

                 if ($showCode)
                     $svg .= "\t" . '<text x="' . (round(($this->barcode_array['maxw'] * $this->getwidth()), 3) / 2) . '" text-anchor="middle"  y="' . ($bh + 12) . '" id="code" fill="' . $this->getColor() . '" font-size ="12px" >' . $this->barcode_array['code'] . '</text>' . "\n";

                 $svg .= "\t" . '</g>' . "\n";
                 $svg .= '</svg>' . "\n";

                 $this->save($svg);
                 break;
             }


             case self::CODE_DATAMATRIX :
             case self::CODE_PDF417 :
             case self::CODE_QRCODE :
             {
                 $this->getwidth()>$this->getheight() ? $this->setheight($this->getwidth()) : $this->setwidth($this->getheight());
                 //dd($this->barcode_array);

                 // replace table for special characters
                 $repstr = array("\0" => '', '&' => '&amp;', '<' => '&lt;', '>' => '&gt;');

                 $svg = '<' . '?' . 'xml version="1.0" standalone="no"' . '?' . '>' . "\n";
                 $svg .= '<!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">' . "\n";
                 $svg .= '<svg width="' . round(($this->barcode_array['num_cols'] * $this->getwidth()), 3) . '" height="' . round(($this->barcode_array['num_rows'] * $this->getheight()), 3) . '" version="1.1" xmlns="http://www.w3.org/2000/svg">' . "\n";
                 $svg .= "\t" . '<g id="elements" fill="' . $this->getColor() . '" stroke="none">' . "\n";

                 // print barcode elements
                 $y = 0;
                 // for each row
                 for ($r = 0; $r < $this->barcode_array['num_rows']; ++$r) {
                     $x = 0;
                     // for each column
                     for ($c = 0; $c < $this->barcode_array['num_cols']; ++$c) {
                         if ($this->barcode_array['bcode'][$r][$c] == 1) {
                             // draw a single barcode cell
                             $svg .= "\t\t" . '<rect x="' . $x . '" y="' . $y . '" width="' . $this->getwidth() . '" height="' . $this->getheight() . '" />' . "\n";
                         }
                         $x += $this->getwidth();
                     }
                     $y += $this->getheight();
                 }
                 $svg .= "\t" . '</g>' . "\n";
                 $svg .= '</svg>' . "\n";
                 $this->save($svg);
                 break;
             }

         }
    }

    protected function toPNG($color = array(0, 0, 0), $showCode = true)
    {

        switch ($this->getType()){
            // CODE 11
            case self::CODE_11 :
                // CODE 39 - ANSI MH10.8M-1983 - USD-3 - 3 of 9.
            case self::CODE_39 :
                // CODE 39 with checksum
            case self::CODE_39PLUS :
                // CODE 39 EXTENDED
            case self::CODE_39EXT :
                // CODE 39 EXTENDED + CHECKSUM
            case self::CODE_39EXTPLUS :
                // CODE 93 - USS-93
            case  self::CODE_93 :
                // Standard 2 of 5
            case self::CODE_STD25 :
                // Standard 2 of 5 + CHECKSUM
            case self::CODE_STD25PLUS :
                // Interleaved 2 of 5
            case self::CODE_INT25 :
                // Interleaved 2 of 5 + CHECKSUM
            case self::CODE_INT25PLUS :
                // CODE 128
            case self::CODE_128 :
                // CODE 128A
            case self::CODE_128A :
                // CODE 128B
            case self::CODE_128B :
                // CODE 128C
            case self::CODE_128C :
                // 2-Digits UPC-Based Extention
            case self::CODE_EAN2 :
                // 5-Digits UPC-Based Extention
            case self::CODE_EAN5 :
                // EAN 8
            case self::CODE_EAN8 :
                // EAN 13
            case self::CODE_EAN13 :
                // UPC-A
            case self::CODE_UPCA :
                // UPC-E
            case self::CODE_UPCE :
                // MSI (Variation of Plessey code)
            case self::CODE_MSI :
                // MSI + CHECKSUM (modulo 11)
            case self::CODE_MSIPLUS :
                // POSTNET
            case self::CODE_POSTNET :
                // PLANET
            case self::CODE_PLANET :
                // RMS4CC (Royal Mail 4-state Customer Code) - CBC (Customer Bar Code)
            case self::CODE_RMS4CC :
                // KIX (Klant index - Customer index)
            case self::CODE_KIX :
                // IMB - Intelligent Mail Barcode - Onecode - USPS-B-3200
            case self::CODE_IMB :
                // CODABAR
            case self::CODE_ABAR :
                // PHARMACODE
            case self::CODE_PHARMA :
                // PHARMACODE TWO-TRACKS
            case self::CODE_PHARMA2T :
            {
                // calculate image size
                $width = ($this->barcode_array['maxw'] * $this->getwidth());
                $height = $this->getheight();

                if (function_exists('imagecreate') || function_exists('imagecreatetruecolor')) {
                    // GD library
                    $imagick = false;
                    $png = @imagecreatetruecolor($width, $height) or die("Impossible d'initialiser la bibliothèque GD");
                    $bgcol = imagecolorallocate($png, 255, 255, 255);
                    imagefill($png, 0, 0, $bgcol);
                    imagecolortransparent($png, $bgcol);
                    $fgcol = imagecolorallocate($png, $color[0], $color[1], $color[2]);
                } elseif (extension_loaded('imagick')) {
                    $imagick = true;

                    $bgcol = new \imagickpixel('rgb(255,255,255)');
                    $fgcol = new \imagickpixel('rgb(' . $color[0] . ',' . $color[1] . ',' . $color[2] . ')');

                    $png = new Imagick();

                    $png->newImage($width, $height, 'none', 'png');
                    $bar = new imagickdraw();
                    $bar->setfillcolor($fgcol);
                } else {
                    return false;
                }

                // print bars
                $x = 0;
                foreach ($this->barcode_array['bcode'] as $k => $v) {
                    $bw = round(($v['w'] * $this->getwidth()), 3);
                    $bh = round(($v['h'] * $this->getheight() / $this->barcode_array['maxh']), 3);
                    if ($showCode)
                        $bh -= imagefontheight(3);
                    if ($v['t']) {
                        $y = round(($v['p'] * $this->getheight() / $this->barcode_array['maxh']), 3);
                        // draw a vertical bar
                        if ($imagick) {
                            $bar->rectangle($x, $y, ($x + $bw), ($y + $bh));
                        } else {
                            imagefilledrectangle($png, $x, $y, ($x + $bw) - 1, ($y + $bh), $fgcol);
                        }
                    }
                    $x += $bw;
                }

                //ob_start();

                // Add Code String in bottom
                if ($showCode) {
                    if ($imagick) {
                        $bar->setTextAlignment(\Imagick::ALIGN_CENTER);
                        $bar->annotation(10, $this->getheight() - $bh + 10, $this->barcode_array['code']);
                    } else {
                        $width_text = imagefontwidth(3) * strlen($this->barcode_array['code']);
                        $height_text = imagefontheight(3);
                        imagestring($png, 3, ($width / 2) - ($width_text / 2), ($height - $height_text), $this->barcode_array['code'], $fgcol);
                    }
                }

                ob_start();

                // get image out put
                if ($imagick === true) {
                    $png->drawimage($bar);
                    echo $png;
                } else {
                    imagepng($png);
                    imagedestroy($png);
                }

                $image = ob_get_contents();
                ob_end_clean();

                //$image = base64_encode($image);
                //dd($image);
                //$image = 'data:image/png;base64,' . base64_encode($image);
                //dd($png, $image);

                $this->save($image);
            }


            case self::CODE_DATAMATRIX :
            case self::CODE_PDF417 :
            case self::CODE_QRCODE :
            {
                $this->getwidth()>$this->getheight() ? $this->setheight($this->getwidth()) : $this->setwidth($this->getheight());

                // calculate image size
                $width = ($this->barcode_array['num_cols'] * $this->getwidth());
                $height = ($this->barcode_array['num_rows'] * $this->getheight());
                if (function_exists('imagecreate')) {
                    // GD library
                    $imagick = false;
                    $png = imagecreate($width, $height);
                    $bgcol = imagecolorallocate($png, 255, 255, 255);
                    imagecolortransparent($png, $bgcol);
                    $fgcol = imagecolorallocate($png, $color[0], $color[1], $color[2]);
                } elseif (extension_loaded('imagick')) {
                    $imagick = true;
                    $bgcol = new \imagickpixel('rgb(255,255,255');
                    $fgcol = new \imagickpixel('rgb(' . $color[0] . ',' . $color[1] . ',' . $color[2] . ')');
                    $png = new \Imagick();
                    $png->newImage($width, $height, 'none', 'png');
                    $bar = new \imagickdraw();
                    $bar->setfillcolor($fgcol);
                } else {
                    return false;
                }
                // print barcode elements
                $y = 0;
                // for each row
                for ($r = 0; $r < $this->barcode_array['num_rows']; ++$r) {
                    $x = 0;
                    // for each column
                    for ($c = 0; $c < $this->barcode_array['num_cols']; ++$c) {
                        if ($this->barcode_array['bcode'][$r][$c] == 1) {
                            // draw a single barcode cell
                            if ($imagick) {
                                $bar->rectangle($x, $y, ($x + $this->getwidth()), ($y + $this->getheight()));
                            } else {
                                imagefilledrectangle($png, $x, $y, ($x + $this->getwidth()), ($y + $this->getheight()), $fgcol);
                            }
                        }
                        $x += $this->getwidth();
                    }
                    $y += $this->getheight();
                }
                ob_start();
                // get image out put

                if ($imagick) {
                    $png->drawimage($bar);
                    echo $png;
                } else {
                    imagepng($png);
                    imagedestroy($png);
                }

                $image = ob_get_contents();
                ob_end_clean();

                //$image = ob_get_clean();
                //$image = base64_encode($image);
                //$image = 'data:image/png;base64,' . base64_encode($image);
                $this->save($image);
                break;
            }

        }


    }

    private function save(string $info)
    {
        Storage::disk('public')->put($this->store_path . $this->getNameFile(), $info);
    }

    public function toUri($extension = self::EXTENSIONSVG)
    {
        switch ($this->getExtension()) {
            case self::EXTENSIONSVG :
            {
                $this->toSVG();
                break;
            }
            case self::EXTENSIONPNG :
            {
                $this->toPNG();
                break;
            }
        }
        return Storage::disk('public')->url($this->store_path . $this->getNameFile());
    }

    public function toHTML($w = 2, $h = 30, $color = 'black', $showCode = true)
    {
        //$html = '<div style="font-size:0;position:relative;">' . "\n";
        $html = '<div style="font-size:0;position:relative;width:' . ($this->barcode_array['maxw'] * $this->getwidth()) . 'px;height:' . ($this->getheight()) . 'px;">' . "\n";
        // print bars
        $x = 0;
        foreach ($this->barcode_array['bcode'] as $k => $v) {
            $bw = round(($v['w'] * $w), 3);
            $bh = round(($v['h'] * $h / $this->barcode_array['maxh']), 3);
            if ($showCode)
                $bh -= 12;
            if ($v['t']) {
                $y = round(($v['p'] * $h / $this->barcode_array['maxh']), 3);
                // draw a vertical bar
                $html .= '<div style="background-color:' . $color . ';width:' . $bw . 'px;height:' . $bh . 'px;position:absolute;left:' . $x . 'px;top:' . $y . 'px;">&nbsp;</div>' . "\n";
            }
            $x += $bw;
        }
        if ($showCode)
            $html .= '<div style="position:absolute; margin-top:' . $bh + 2 . 'px; text-align:center; width:' . ($this->barcode_array['maxw'] * $w) . 'px;  font-size: 0.6vw;">' . $this->barcode_array['code'] . '</div>';

        $html .= '</div>' . "\n";
        return $html;
    }

}
