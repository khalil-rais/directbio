<?php
/**
 * @file
 * Contains \Drupal\hello_world\HelloWorldController.
 */
 
namespace Drupal\direktbio\Controller;
 

use Symfony\Component\DependencyInjection\ContainerBuilder;
use \Drupal\node\Entity\Node;
use \Drupal\file\Entity\File;
use \Drupal\commerce_product\Entity\ProductVariationType;
//use Drupal\parfum\Controller\PDF;
require(drupal_get_path('module', 'direktbio') . '/fpdf17/pdf.php');

class ParfumController extends ContainerBuilder {

	private $max_parfum_price = 160;
	private $min_parfum_price = 15;
	private $seuil_limite = 5;
	
	public function _generation_pdf($order) {
		/*$order = array();
		$order ['id']= '180430-001';
		$order ['order_time']= '30-04-2018';
		$order['lines'] = array("00014|Parfum CK|5|30|150", "00125|Parfum Hugo Boss|5|20|100", "08226|Parfum Coco Channel|4|15|60");
		
		$order ['nom_client']= 'Mme/Mr Dupont';
		$order ['adresse_client']= 'Rue des Jasmins';

		$order ['Total HT'] = '5,00';
		$order ['Frais de Port'] = '5,00';
		$order ['Total TTC'] = '5,00';

		$order ['message']= "Nous procèderons à l'envoi du colis dès la réception de votre virement sur notre compte. Vous pouvez consulter nos conditions générales de vente sur cette adresse http://parfumstreet.fr/cgv Pour toute demande ou réclamation, nous sommes à votre disposition au 06 17 87 76 80 ou par e-mail contact@parfumstreet.fr";*/

		date_default_timezone_set('Europe/Berlin');
		

		//$date = mktime(12, 0, 0, $date['month'], $date['day'], $date['year']);
		//Drupal\parfum\Controller\PDF
		//$pdf = new PDF();
		$pdf = new PDF\PDF;
		//$pdf = new PDF('L');
		$pdf->AliasNbPages();
		$pdf->AddPage();
		$pdf->SetLineWidth(0.05);

		$pdf->Image('sites/default/files/logo_transparent.png', 0, 0, 200);		
		$pdf->Image('sites/default/files/logo_parfum_street.png', 5, 5);
		$pdf->SetFont('arial', 'B', 12);
		$pdf->SetTextColor(163, 2, 7);
		$pdf->Text(130, 15, utf8_decode($order ['nature'].' n°: '. $order ['id']));
		$pdf->SetTextColor(0, 0, 0);
		
		$pdf->Text(155, 28, utf8_decode(t('Tunis the').' '.date('d/m/Y',strtotime($order ['order_time'])).',' ));//Tunis le
		
		
		 
		$pdf->SetFont('arial', '', 10);
		//start from here http://www.fpdf.org/en/script/script92.php		
		//$pdf->Text(23, 50, utf8_decode('Rapport de Visite Chaufferie et Station - Relevé du '.date('d/m/Y', $node->created) ));	
		$pdf->Text(5, 35, utf8_decode(t('Transmitter').':'));	
		$pdf->SetFillColor(230,230,230);
		$pdf->Rect(5,37,82,45,'F');
		$pdf->SetFont('arial', 'B', 12);
		//$pdf->SetXY(5, 39);
		$pdf->Text(7, 42, utf8_decode('Association Direktbio'));	
		$pdf->SetFont('arial', '', 12);
		$pdf->Text(7, 48, utf8_decode('1 rue Youssou Ndour'));	
		$pdf->Text(7, 54, utf8_decode('Hammamet-Sud 8050'));
		$pdf->SetFont('arial', 'B', 12);
		$pdf->Text(7, 60, utf8_decode(t('Phone').' :'));
		$pdf->Text(7, 66, utf8_decode(t('Tax identifier').' :'));
		
		$pdf->SetFont('arial', '', 12);
		$pdf->Text(32, 60, utf8_decode('50811238'));	
		$pdf->Text(9, 72, utf8_decode('000/M/A/1235467/R'));	
		

		$pdf->SetFillColor(255,255,255);
		
		
		$pdf->SetFont('arial', '', 10);
		$pdf->Text(112, 35, utf8_decode(t('Addressed to').':'));	
		$pdf->Rect(112,37,85,45);
		$pdf->SetFont('arial', 'B', 12);
		$pdf->Text(114, 42, utf8_decode(t('Customer').':' ));		
		$pdf->Text(114, 48, utf8_decode(t('E-Mail').':' ));
		$pdf->Text(114, 54, utf8_decode(t('Phone').':' ));		
		$pdf->Text(114, 60, utf8_decode(t('Address').':' ));
		

		$pdf->SetFont('arial', '', 12);
		if ($order["language"]=="fr"){
			$pdf->Text(138, 42, utf8_decode($order ['nom_client']));
		}
		else{
			$pdf->Text(138, 42, utf8_decode($order ['nom_client']));
		}
				
		$pdf->Text(129, 48, utf8_decode($order ['email']));	
		$pdf->Text(138, 54, utf8_decode($order ['telephone']));	
		
		
		$initial_address_line =  60;
		foreach ($order ['adresse_client'] as $key_a => $value_a){
			if  ($value_a!=""){
				if  ($key_a!=0){
					$pdf->Text(114, $initial_address_line, utf8_decode(' '.$value_a));
				}
				else{
					$pdf->Text(133, $initial_address_line, utf8_decode(' '.$value_a));
				}
				
				$initial_address_line += 6;
			}
		}
		
				
		
		$pdf->SetFont('arial', '', 10);
		$pdf->Text(159, 100, utf8_decode(t('Amounts expressed in TND')));//Montants exprimés en DT
		$pdf->SetFont('arial', '', 12);
		
		
		$pdf->SetXY(5, 102);
		
		//$pdf->MultiCell(170, 10, utf8_decode("Suite à notre visite à votre usine le ").date ('d/m/Y').utf8_decode(", nous avons effectué des analyses d'eau concernant la chaufferie.Vous trouverez ci-dessous les valeurs mesurées le jour de notre visite ainsi que nos recommandations."),0);
		
		/*$pdf->SetFont('arial', 'BU', 12);
		$pdf->Ln(2);
		$pdf->MultiCell(170, 10, utf8_decode("Relevé des mesures prises:"),0);	*/
		
		// Largeurs des colonnes
		$pdf->SetFillColor(230,230,230);
		//$pdf->SetDrawColor(30,30,30);
		$w = array(35, 100, 25, 20,20);
			
		$header = array(utf8_decode("Code"),utf8_decode(t("Designation")), utf8_decode(t("U.P.")), utf8_decode(t("Qty")),utf8_decode("Total"));
		// En-tête
		for($i=0;$i<count($header);$i++){
			$pdf->Cell($w[$i],7,$header[$i],1,0,'C',true);
		}
		$pdf->Ln();
		
		
		//Code|Designation|PUHT|Qte|TotalHT
		
		
		 
		//$pdf->SetXY(5, 122);
		


		//if (isset ($node->field_presentation_pdf['und'])){//We will draw the taken paramters.
		if (isset ($order['lines'])){//We will draw the taken paramters.
			foreach ($order['lines'] as $key_l=> $value_l){
				$parameter_list = explode ('|',$value_l);
				$pdf->SetX(5);
				/*if (count ($parameter_list)==2){//we have here a section
					$pdf->SetFont('arial', 'B', 12);
					$pdf->Cell(10,7,$parameter_list[0],1,0,'C',false);
					$pdf->Cell(175,7,utf8_decode($parameter_list[1]),1,0,'L',false);
					$pdf->Ln();
				}*/
				//elseif (count ($parameter_list)==5){
				if (count ($parameter_list)==5){
							
			
					//$parameter_data =  array("1","Température (T)", "50 °C", "<60","Valeur conforme.");
					$pdf->SetFont('arial', '', 12);
					
					for($i=0;$i<count($parameter_list);$i++){
						if ($i==2 or $i==3 or $i==4 ){
							$pdf->Cell($w[$i],7,utf8_decode($parameter_list[$i]),0,0,'R',false);
						}
						else{
							$pdf->Cell($w[$i],7,utf8_decode('  '.$parameter_list[$i]),0,0,'L',false);
						}
					}
					$pdf->Ln();
				}
			}
			
			$w_totaux = array ('Sous Total H.T','Frais de Port H.T', 'TOTAL H.T');
			$w_totaux_text = array (t('Sub Total'),t('Shipping fees'), 'TOTAL');
			
			//$w_totaux = array ('Sous Total H.T', 'TOTAL H.T');
			//$w_totaux_text = array (t('Sub Total'), 'TOTAL');
			
			$w_fillcolor = array (255,248,230,212);
			
			for ($j=0;$j<3;$j++){
			//for ($j=0;$j<2;$j++){
				
				/*if ($j==2){//Juste avant le total ht on mettra la mention.
					$pdf->SetFillColor(255,255,255);
					$pdf->SetX(60);
					$pdf->Cell(75,7,utf8_decode(""),0,0,'L','F');
				}*/
				/*else{
					$pdf->SetX(140);
				}*/
				$pdf->SetX(140);
				$pdf->SetFillColor($w_fillcolor[$j],$w_fillcolor[$j],$w_fillcolor[$j]);
				/*$pdf->Cell(30,7,utf8_decode($w_totaux[$j]),0,0,'L','F');
				$pdf->Cell(35,7,utf8_decode($order [$w_totaux[$j]]),0,0,'R','F');*/
				$pdf->Cell(35,7,utf8_decode($w_totaux_text[$j]),0,0,'L','F');
				$pdf->Cell(30,7,utf8_decode($order [$w_totaux[$j]]),0,0,'R','F');
				$pdf->Ln();				

			}
			$table_height = 7 * count($order['lines']);
			
			$pdf->Rect(5,109,200,$table_height);
			$starting_position = 5;
			for($i=0;$i<count($header);$i++){
				$pdf->Rect($starting_position,109,$w[$i],$table_height);
				$starting_position += $w[$i];
			}
			/*$w = array(35, 100, 25, 20,20);
			$pdf->Rect(5,109,200,$table_height);*/
		}
		
		/*if (isset($order['sum'])){
			foreach ($order['sum'] as $key_l=> $value_l){
				$parameter_list = explode ('|',$value_l);
				if (count ($parameter_list)==2){
					
				}
				$pdf->SetFont('arial', 'B', 12);
				$pdf->Cell(10,7,$parameter_list[0],1,0,'C',false);
				$pdf->Cell(175,7,utf8_decode($parameter_list[1]),1,0,'L',false);
				$pdf->Ln();				
			}
		}*/
		$pdf->Ln();		
		$pdf->SetFont('arial', '', 12);
		$pdf->MultiCell(190, 2, utf8_decode(t("Payment choice").": ".$order ['payment_gateway']),0);
		
		$pdf->Ln();
		$pdf->Ln();
		$pdf->Ln();
		foreach ($order ['message'] as $message_line_k => $message_line_v){
			$pdf->MultiCell(190, 5, utf8_decode($message_line_v),0);
			$pdf->Ln();			
		}
		
		
		//$pdf->WriteHTML(utf8_decode($node->body['und'][0]['value']));
		
		$pdf->Ln();
		$pdf->Ln();
		
		
		

		//$file_name = "AE_" . ucfirst($societe_user->name).'_'.date ('d-m-Y', strtotime($node->field_period['und'][0]['value'])) . ".pdf";
		$file_name = $order ['file_name'];
		
		
		
		$file_path = 'sites/default/files/private/'.$order ['subdirectory'].'/'.$file_name;
		//$file_path = $file_name;
		
		$pdf->Output($file_path, "F");
			
		$file = file_save_data(file_get_contents($file_path), 'private://'.$order ['subdirectory'].'/'.$file_name,FILE_EXISTS_REPLACE );
		 
		
		$order_ui = \Drupal\commerce_order\Entity\Order::load($order ['entityid']);
		//$order->get('field_facture')->setValue(set('target_id',$file->id());
		//$order_ui->get('field_facture')->set('target_id',$file->id());
		//$order->get('field_facture')->setValue('target_id');
		//$order->set("field_facture", new \Drupal\commerce_price\Price(strval ($value['PVR']), 'EUR'));
		//$order->set("field_facture", $file->id());
		//$order_ui->get('field_facture')->setValue('target_id');
		$order_ui->get('field_'.$order ['subdirectory'])->setValue($file->id());
		$order_ui->save();

		/*ob_start();
		var_dump($order ['uid']);
		var_dump($order ['subdirectory']);
		var_dump($file_name);
		var_dump($file->id());
		$dumpy = ob_get_clean();
		\Drupal::logger('parfum')->notice('Le nombre de paramètres est :'.$dumpy);*/

		
		//$file->display = 1;
		//$file->uid = $node->uid;		
		//$node->field_rapport['und'][0] = (array)$file;
		
		return array(
		  '#type' => 'markup',
		  '#markup' => t('The invoice is generated'),
		);
		
	}
	
	public function _detect_changed_stock ($product_list){
		
		$stock_status = $this->_get_stock_status();
		//dpm ($stock_status);
		$i = 0;
		
		$product_engel_indexes = array_keys ($product_list);
		$to_be_removed_articles = array();
		$to_be_updated_prices = array();
		while ($i < count ($stock_status) and count ($product_engel_indexes)>0){
			$key = array_search($stock_status[$i]['Id'], $product_engel_indexes); 
			if (is_numeric($key) ){
				//Vérifier si la quantité est disponible.
				if ($stock_status[$i]['Stock'] < $product_list [$product_engel_indexes[$key]]['qte']+$this->seuil_limite){
					$to_be_removed_articles [$product_engel_indexes[$key]] = $stock_status[$i]['Stock'] - $this->seuil_limite;
				}
				elseif ($stock_status[$i]['Price'] != $product_list [$product_engel_indexes[$key]]['engel_unit_price']){//Vérifier si le prix n'a pas changé
					$to_be_updated_prices [$product_engel_indexes[$key]] = $stock_status[$i]['Price'];
					
				}
				unset ($product_engel_indexes[$key]);
			}
			$i++;
		}
		return (array ('Stock' => $to_be_removed_articles, 'Price'=> $to_be_updated_prices ));
	}
	
   //Get stock status.
   public function _get_stock_status (){
		$token = $this->_webservice_login ();
		

		if (isset ($token)){
			// Accès aux produits
			$collect_options = array(
				'http' => array(
					'method'  => 'GET',
				)
			);		
			
			$context = stream_context_create($collect_options);

			//10
			//http://drop.novaengel.com/api/products/paging/token/pages/elements/languaje
						
			
			$response = file_get_contents('http://drop.novaengel.com/api/stock/update/'.$token, false, $context);
			$product_data = json_decode($response, true);

			//Logout
			$this->_webservice_logout ($token);			
			return ($product_data);
		}
		else{
			return (null);
		}
   }
   
   public function ipe_debug1 (){
	   $order_ui = \Drupal\commerce_order\Entity\Order::load(50);
		$order=$order_ui->get('field_commande')->getValue();
		//$order_ui->save();
		ob_start();
		var_dump($order_ui->id());
		$dumpy = ob_get_clean();
		\Drupal::logger('parfum')->notice('ipe_debug1 :'.$dumpy);
		return array(
		  '#type' => 'markup',
		  '#markup' =>' 
			<div><p id="checkdubug">Hello21</p></div>'
		);			
		
   }

}

