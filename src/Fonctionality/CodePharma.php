<?php

namespace App\Fonctionality;

class CodePharma
{

    private $bararray;

    public function getdata()
    {
        return $this->bararray;
    }

    /**
     * @param $code
     */
    public function __construct($code)
    {
        $seq = '';
        $code = intval($code);
        while ($code > 0) {
            if (($code % 2) == 0) {
                $seq .= '11100';
                $code -= 2;
            } else {
                $seq .= '100';
                $code -= 1;
            }
            $code /= 2;
        }
        $seq = substr($seq, 0, -2);
        $seq = strrev($seq);
        $this->bararray = array('code' => $code, 'maxw' => 0, 'maxh' => 1, 'bcode' => array());
        $this->binseq_to_array($seq);
    }

    /**
     * Convert binary barcode sequence to DNS1DBarcode barcode array.
     * @param $seq (string) barcode as binary sequence.
     * @param $this->bararray (array) barcode array.
     * òparam array $this->bararray DNS1DBarcode barcode array to fill up
     * @return array barcode representation.
     * @protected
     */
    protected function binseq_to_array($seq) {
        $len = strlen($seq);
        $w = 0;
        $k = 0;
        for ($i = 0; $i < $len; ++$i) {
            $w += 1;
            if (($i == ($len - 1)) OR (($i < ($len - 1)) AND ($seq[$i] != $seq[($i + 1)]))) {
                if ($seq[$i] == '1') {
                    $t = true; // bar
                } else {
                    $t = false; // space
                }
                $this->bararray['bcode'][$k] = array('t' => $t, 'w' => $w, 'h' => 1, 'p' => 0);
                $this->bararray['maxw'] += $w;
                ++$k;
                $w = 0;
            }
        }
    }
}
