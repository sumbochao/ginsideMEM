<?php
require APPPATH.'third_party/MeAPI/Libraries/LibExcel.php';
require_once APPPATH.'third_party/PHPExcel/PHPExcel.php';

class Libcommon {

    public function __construct() {
      $this->CI = & get_instance();
    }
	public function SetHtml($params){
		$html = '<!DOCTYPE HTML>';
		$html.='<html>';
		$html.='<head>';	
		$html.='<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
		$html.='</head>';	
		$html.='<body>';
		$html.='<table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="bodyTable">';
            $html.='<tr>';
                $html.='<td align="center" valign="top">';
                    $html.='<table border="0" cellpadding="20" cellspacing="0" width="600" id="emailContainer">';
                        $html.='<tr>';
                            $html.='<td align="center" valign="top" style="background: #658db5;color:#fff;font-weight:bold">';
                                $html.=$params['title'];
                            $html.='</td>';
                        $html.='</tr>';
						$html.='<tr>';
							$html.='<tbody>';
								$html.='<table border="1" style="border-collapse: collapse;border: 0 solid #555555;" cellpadding="5" cellspacing="0" width="600" id="emailContainer">';
									$html.='<tr style="">';
										$html.='<td>PROJECTS</td>';
										$html.='<td>'.$params['names'].'</td>';
									$html.='</tr>';
									$html.='<tr style="background: #555555;color:#fff">';
										$html.='<td>USER UPDATE</td>';
										$html.='<td>'.$params['user'].'</td>';
									$html.='</tr>';
									$html.='<tr style="">';
										$html.='<td>PLATFORM</td>';
										$html.='<td>'.$params['platform'].'</td>';
									$html.='</tr>';
									$html.='<tr style="background: #555555;color:#fff">';
										$html.='<td>BUNDLEID/PACKAGENAME/PACKAGEIDENTITY</td>';
										$html.='<td>'.$params['package_name'].'</td>';
									$html.='</tr>';
									$html.='<tr style="">';
										$html.='<td>LINK LOG</td>';
										$html.='<td><a href="http://ginside.mobo.vn/?control=projects&func='.$params['log'].'">Xem Log</a></td>';
									$html.='</tr>';
									$html.='<tr style="background: #555555;color:#fff">';
										$html.='<td>LINK GINSIDE</td>';
										$html.='<td><a href="http://ginside.mobo.vn">LINK GINSIDE</a></td>';
									$html.='</tr>';
									
								$html.='</table>';
							$html.='</tbody>';
						$html.='</tr>';
                    $html.='</table>';
                $html.='</td>';
            $html.='</tr>';
        $html.='</table>';
		
		$html.='</body>';
		$html.='</html>';
		return $html;
	}
	public function SendAlert($id,$contents){
			/*http://alert.gomobi.vn/service/alertsms?id=1&email=thuonghh@mecorp.vn&phone=84909000200&content=noidungsms&service=mgo&send_sms=1/0&send_mail=1/0&part=studio&account=studio&token=token
*/
		$id=$id;
		$phone="";
		$contenthtml="Update_Projects                   ".$this->SetHtml($contents);
		$email="game.coor.lead@mecorp.vn";//game.coor.lead@mecorp.vn
		$service="GAPI";
		$send_sms="0";
		$send_mail="1";
		$part="TTKT";
		$account="m2";
		$secretkey="jh2qeQhLbR#m2";
		$token=md5($id.$email.$phone.$contenthtml.$service.$send_sms.$send_mail.$part.$account.$secretkey);
		//$param="id=$id&email=$email&phone=$phone&content=$contenthtml&service=$service&send_sms=$send_sms&send_mail=$send_mail&part=$part&account=$account&token=$token";
		
		$post_array = array(
						"id"=>$id,
						"email"=>$email,
						"phone"=>"",
						"content"=>$contenthtml,
						"service"=>$service,
						"send_sms"=>0,
						"send_mail"=>1,
						"part"=>$part,
						"account"=>$account,
						"token"=>$token
					);
		/*$data_post = http_build_query($post_array);
		$data_post_decode = urldecode($data_post);
					
		$urls="http://alert.gomobi.vn/service/alertsms";
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $urls);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_post_decode);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);
		curl_exec($ch);   
		curl_close($ch);*/
		
		//$urls="http://alert.gomobi.vn/service/alertsms?".http_build_query($post_array);
		$urls="http://alert.gomobi.vn/service/alertsms";
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $urls);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_TIMEOUT, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_array));
		curl_exec($ch);   
		curl_close($ch);
	}
	public function SendAlertTo($id,$contents,$to){
			/*http://alert.gomobi.vn/service/alertsms?id=1&email=thuonghh@mecorp.vn&phone=84909000200&content=noidungsms&service=mgo&send_sms=1/0&send_mail=1/0&part=studio&account=studio&token=token
*/
		$id=$id;
		$phone="";
		$contenthtml="Update_Projects                   ".$contents;
		$email=$to;
		$service="GAPI";
		$send_sms="0";
		$send_mail="1";
		$part="TTKT";
		$account="m2";
		$secretkey="jh2qeQhLbR#m2";
		$token=md5($id.$email.$phone.$contenthtml.$service.$send_sms.$send_mail.$part.$account.$secretkey);
		//$param="id=$id&email=$email&phone=$phone&content=$contenthtml&service=$service&send_sms=$send_sms&send_mail=$send_mail&part=$part&account=$account&token=$token";
		
		$post_array = array(
						"id"=>$id,
						"email"=>$email,
						"phone"=>"",
						"content"=>$contenthtml,
						"service"=>$service,
						"send_sms"=>0,
						"send_mail"=>1,
						"part"=>$part,
						"account"=>$account,
						"token"=>$token
					);
		$urls="http://alert.gomobi.vn/service/alertsms";
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $urls);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_TIMEOUT, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_array));
		curl_exec($ch);   
		curl_close($ch);
	}
	public function CreateCKeditor(){
		$this->CI->CKEditor->basePath = base_url().'assets/ckeditor/';
		/*$this->CI->CKEditor->config['toolbar'] = array(array( 'Source', '-', 'Bold', 'Italic', 'Underline', '-','Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo','-','NumberedList','BulletedList','Image', 'Table', 'HorizontalRule', 'SpecialChar' ));*/
		$this->CI->CKEditor->config['toolbar']='Full';
		$this->CI->CKEditor->config['language'] = 'vn';
		$this->CI->CKEditor->config['width'] = '900px';
		$this->CI->CKEditor->config['height'] = '300px';
		
		//Add Ckfinder to Ckeditor
		$this->CI->CKFinder->SetupCKEditor($this->CI->CKEditor,"assets/ckfinder/");
	}
	public function _format_json_plus($json, $html = false) {
		$tabcount = 0; 
		$result = ''; 
		$inquote = false; 
		$ignorenext = false; 
		if ($html) { 
		    $tab = "&nbsp;&nbsp;&nbsp;"; 
		    $newline = "<br/>"; 
		} else { 
		    $tab = "\t"; 
		    $newline = "\n"; 
		} 
		for($i = 0; $i < strlen($json); $i++) { 
		    $char = $json[$i]; 
		    if ($ignorenext) { 
		        $result .= $char; 
		        $ignorenext = false; 
		    } else { 
		        switch($char) { 
		            case '{': 
		                $tabcount++; 
		                $result .= $char . $newline . str_repeat($tab, $tabcount); 
		                break; 
		            case '}': 
		                $tabcount--; 
		                $result = trim($result) . $newline . str_repeat($tab, $tabcount) . $char; 
		                break; 
		            case ',': 
		                $result .= $char . $newline . str_repeat($tab, $tabcount); 
		                break; 
		            case '"': 
		                $inquote = !$inquote; 
		                $result .= $char; 
		                break; 
		            case '\\': 
		                if ($inquote) $ignorenext = true; 
		                $result .= $char; 
		                break; 
		            default: 
		                $result .= $char; 
		        } 
		    } 
		} 
		return $result; 
	}
	
	//xuất Excel format
	public function ExportExcelFormatCellOne($dataexp,$pathfile){
		$objPHPExcel = new PHPExcel();
		/*$objBorder = new PHPExcel_Style_Border();
		$objBorder->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);*/
		
		$objRichTextA = new PHPExcel_RichText();
		$objRichTextB = new PHPExcel_RichText();
		$objRichTextC = new PHPExcel_RichText();
		$objRichTextD = new PHPExcel_RichText();
		$objRichTextE = new PHPExcel_RichText();
		$objRichTextF = new PHPExcel_RichText();
		$objRichTextG = new PHPExcel_RichText();
		$objRichTextH = new PHPExcel_RichText();
		$objRichTextI = new PHPExcel_RichText();
		$objRichTextJ = new PHPExcel_RichText();
		$objRichTextK = new PHPExcel_RichText();
		$objRichTextL = new PHPExcel_RichText();
		$objRichTextM = new PHPExcel_RichText();
		$objRichTextN = new PHPExcel_RichText();
		$objRichTextO = new PHPExcel_RichText();
		
		$titA=$objRichTextA->createTextRun("Game Code");
		$titA->getFont()->setBold(true);
		$titA->getFont()->setColor( new PHPExcel_Style_Color(PHPExcel_Style_Color::COLOR_DARKGREEN  ) );
		
		$titB=$objRichTextB->createTextRun("Game Name");
		$titB->getFont()->setBold(true);
		$titB->getFont()->setColor( new PHPExcel_Style_Color(PHPExcel_Style_Color::COLOR_DARKGREEN  ) );
		
		$titC=$objRichTextC->createTextRun("Platform");
		$titC->getFont()->setBold(true);
		$titC->getFont()->setColor( new PHPExcel_Style_Color(PHPExcel_Style_Color::COLOR_DARKGREEN  ) );
		
		$titD=$objRichTextD->createTextRun("SDK Version");
		$titD->getFont()->setBold(true);
		$titD->getFont()->setColor( new PHPExcel_Style_Color(PHPExcel_Style_Color::COLOR_DARKGREEN  ) );
		
		$titE=$objRichTextE->createTextRun("Client Version");
		$titE->getFont()->setBold(true);
		$titE->getFont()->setColor( new PHPExcel_Style_Color(PHPExcel_Style_Color::COLOR_DARKGREEN  ) );
		
		$titF=$objRichTextF->createTextRun("Version Code");
		$titF->getFont()->setBold(true);
		$titF->getFont()->setColor( new PHPExcel_Style_Color(PHPExcel_Style_Color::COLOR_DARKGREEN  ) );
		
		$titG=$objRichTextG->createTextRun("Client Build");
		$titG->getFont()->setBold(true);
		$titG->getFont()->setColor( new PHPExcel_Style_Color(PHPExcel_Style_Color::COLOR_DARKGREEN  ) );
		
		$titH=$objRichTextH->createTextRun("Store Type");
		$titH->getFont()->setBold(true);
		$titH->getFont()->setColor( new PHPExcel_Style_Color(PHPExcel_Style_Color::COLOR_DARKGREEN  ) );
		
		$titI=$objRichTextI->createTextRun("Package Type");
		$titI->getFont()->setBold(true);
		$titI->getFont()->setColor( new PHPExcel_Style_Color(PHPExcel_Style_Color::COLOR_DARKGREEN  ) );
		
		$titJ=$objRichTextJ->createTextRun("Package Name");
		$titJ->getFont()->setBold(true);
		$titJ->getFont()->setColor( new PHPExcel_Style_Color(PHPExcel_Style_Color::COLOR_DARKGREEN  ) );
		
		$titK=$objRichTextK->createTextRun("MSV");
		$titK->getFont()->setBold(true);
		$titK->getFont()->setColor( new PHPExcel_Style_Color(PHPExcel_Style_Color::COLOR_DARKGREEN  ) );
		
		$titL=$objRichTextL->createTextRun("Min SDK Version");
		$titL->getFont()->setBold(true);
		$titL->getFont()->setColor( new PHPExcel_Style_Color(PHPExcel_Style_Color::COLOR_DARKGREEN  ) );
		
		$titM=$objRichTextM->createTextRun("Target SDK Version");
		$titM->getFont()->setBold(true);
		$titM->getFont()->setColor( new PHPExcel_Style_Color(PHPExcel_Style_Color::COLOR_DARKGREEN  ) );
		
		$titN=$objRichTextN->createTextRun("File Name");
		$titN->getFont()->setBold(true);
		$titN->getFont()->setColor( new PHPExcel_Style_Color(PHPExcel_Style_Color::COLOR_DARKGREEN  ) );
		
		$titO=$objRichTextO->createTextRun("Notes");
		$titO->getFont()->setBold(true);
		$titO->getFont()->setColor( new PHPExcel_Style_Color(PHPExcel_Style_Color::COLOR_DARKGREEN  ) );
		
		
		$objPHPExcel->getActiveSheet()->getCell("A1")->setValue($objRichTextA);
		$objPHPExcel->getActiveSheet()->getStyle("A1")->getAlignment()->setWrapText(false);
		$objPHPExcel->getActiveSheet()->getCell("B1")->setValue($objRichTextB);
		$objPHPExcel->getActiveSheet()->getStyle("B1")->getAlignment()->setWrapText(false);
		$objPHPExcel->getActiveSheet()->getCell("C1")->setValue($objRichTextC);
		$objPHPExcel->getActiveSheet()->getStyle("C1")->getAlignment()->setWrapText(false);
		$objPHPExcel->getActiveSheet()->getCell("D1")->setValue($objRichTextD);
		$objPHPExcel->getActiveSheet()->getStyle("D1")->getAlignment()->setWrapText(false);
		$objPHPExcel->getActiveSheet()->getCell("E1")->setValue($objRichTextE);
		$objPHPExcel->getActiveSheet()->getStyle("E1")->getAlignment()->setWrapText(false);
		$objPHPExcel->getActiveSheet()->getCell("F1")->setValue($objRichTextF);
		$objPHPExcel->getActiveSheet()->getStyle("F1")->getAlignment()->setWrapText(false);
		$objPHPExcel->getActiveSheet()->getCell("G1")->setValue($objRichTextG);
		$objPHPExcel->getActiveSheet()->getStyle("G1")->getAlignment()->setWrapText(false);
		$objPHPExcel->getActiveSheet()->getCell("H1")->setValue($objRichTextH);
		$objPHPExcel->getActiveSheet()->getStyle("H1")->getAlignment()->setWrapText(false);
		$objPHPExcel->getActiveSheet()->getCell("I1")->setValue($objRichTextI);
		$objPHPExcel->getActiveSheet()->getStyle("I1")->getAlignment()->setWrapText(false);
		$objPHPExcel->getActiveSheet()->getCell("J1")->setValue($objRichTextJ);
		$objPHPExcel->getActiveSheet()->getStyle("J1")->getAlignment()->setWrapText(false);
		$objPHPExcel->getActiveSheet()->getCell("K1")->setValue($objRichTextK);
		$objPHPExcel->getActiveSheet()->getStyle("K1")->getAlignment()->setWrapText(false);
		$objPHPExcel->getActiveSheet()->getCell("L1")->setValue($objRichTextL);
		$objPHPExcel->getActiveSheet()->getStyle("L1")->getAlignment()->setWrapText(false);
		$objPHPExcel->getActiveSheet()->getCell("M1")->setValue($objRichTextM);
		$objPHPExcel->getActiveSheet()->getStyle("M1")->getAlignment()->setWrapText(false);
		$objPHPExcel->getActiveSheet()->getCell("N1")->setValue($objRichTextN);
		$objPHPExcel->getActiveSheet()->getStyle("N1")->getAlignment()->setWrapText(false);
		$objPHPExcel->getActiveSheet()->getCell("O1")->setValue($objRichTextO);
		$objPHPExcel->getActiveSheet()->getStyle("O1")->getAlignment()->setWrapText(false);
		
		//set border
		$objPHPExcel->getActiveSheet()->getStyle('A1:O2')->applyFromArray(
		array('fill' 	=> array(
									'type'		=> PHPExcel_Style_Fill::FILL_SOLID,
									'color'		=> array('argb' => 'E6D6D6')
								),
			  'borders' => array(
			  						'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
									'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
									'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
									'right'		=> array('style' => PHPExcel_Style_Border::BORDER_THIN)
								)
			 )
		);
		
		//set value row 1+
		$objPHPExcel->getActiveSheet()->setCellValue('A2', $dataexp['game_code'])
										->getStyle("A2")->getAlignment()->setWrapText(false);
		$objPHPExcel->getActiveSheet()->setCellValue('B2', $dataexp['game_name'])
										->getStyle("B2")->getAlignment()->setWrapText(false);
		$objPHPExcel->getActiveSheet()->setCellValue('C2', $dataexp['platform'])
										->getStyle("C2")->getAlignment()->setWrapText(false);
		$objPHPExcel->getActiveSheet()->setCellValue('D2', $dataexp['sdkversion'])
										->getStyle("D2")->getAlignment()->setWrapText(false);
		$objPHPExcel->getActiveSheet()->setCellValue('E2', $dataexp['client_version'])
										->getStyle("E2")->getAlignment()->setWrapText(false);
		$objPHPExcel->getActiveSheet()->setCellValue('F2', $dataexp['version_code'])
										->getStyle("F2")->getAlignment()->setWrapText(false);
		$objPHPExcel->getActiveSheet()->setCellValue('G2', $dataexp['client_build'])
										->getStyle("G2")->getAlignment()->setWrapText(false);
		$objPHPExcel->getActiveSheet()->setCellValue('H2', $dataexp['story_stype'])
										->getStyle("H2")->getAlignment()->setWrapText(false);
		$objPHPExcel->getActiveSheet()->setCellValue('I2', $dataexp['package_type'])
										->getStyle("I2")->getAlignment()->setWrapText(false);
		$objPHPExcel->getActiveSheet()->setCellValue('J2', $dataexp['package_name'])
										->getStyle("J2")->getAlignment()->setWrapText(false);
		$objPHPExcel->getActiveSheet()->setCellValue('K2', $dataexp['msv'])
										->getStyle("K2")->getAlignment()->setWrapText(false);
		$objPHPExcel->getActiveSheet()->setCellValue('L2', $dataexp['min_sdk_version'])
										->getStyle("L2")->getAlignment()->setWrapText(false);
		$objPHPExcel->getActiveSheet()->setCellValue('M2', $dataexp['target_sdk_version'])
										->getStyle("M2")->getAlignment()->setWrapText(false);
		$objPHPExcel->getActiveSheet()->setCellValue('N2', $dataexp['file_name'])
										->getStyle("N2")->getAlignment()->setWrapText(false);
		$objPHPExcel->getActiveSheet()->setCellValue('O2', $dataexp['notes'])
										->getStyle("O2")->getAlignment()->setWrapText(false);
		
		
		
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		//$objWriter->save($pathfile);
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="'.$pathfile.'"');
		header('Cache-Control: max-age=0');
		// If you're serving to IE 9, then the following may be needed
		header('Cache-Control: max-age=1');
		
		// If you're serving to IE over SSL, then the following may be needed
		header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
		header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header ('Pragma: public'); // HTTP/1.0
		
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('php://output');
		exit;
		
	}
	public function ExportExcelFormatCellAll($dataexp,$pathfile){
		$objPHPExcel = new PHPExcel();
		
		$objRichTextA = new PHPExcel_RichText();
		$objRichTextB = new PHPExcel_RichText();
		$objRichTextC = new PHPExcel_RichText();
		$objRichTextD = new PHPExcel_RichText();
		$objRichTextE = new PHPExcel_RichText();
		$objRichTextF = new PHPExcel_RichText();
		$objRichTextG = new PHPExcel_RichText();
		$objRichTextH = new PHPExcel_RichText();
		$objRichTextI = new PHPExcel_RichText();
		$objRichTextJ = new PHPExcel_RichText();
		$objRichTextK = new PHPExcel_RichText();
		$objRichTextL = new PHPExcel_RichText();
		$objRichTextM = new PHPExcel_RichText();
		$objRichTextN = new PHPExcel_RichText();
		$objRichTextO = new PHPExcel_RichText();
		
		$titA=$objRichTextA->createTextRun("Game Code");
		$titA->getFont()->setBold(true);
		$titA->getFont()->setColor( new PHPExcel_Style_Color(PHPExcel_Style_Color::COLOR_DARKGREEN  ) );
		
		$titB=$objRichTextB->createTextRun("Game Name");
		$titB->getFont()->setBold(true);
		$titB->getFont()->setColor( new PHPExcel_Style_Color(PHPExcel_Style_Color::COLOR_DARKGREEN  ) );
		
		$titC=$objRichTextC->createTextRun("Platform");
		$titC->getFont()->setBold(true);
		$titC->getFont()->setColor( new PHPExcel_Style_Color(PHPExcel_Style_Color::COLOR_DARKGREEN  ) );
		
		$titD=$objRichTextD->createTextRun("SDK Version");
		$titD->getFont()->setBold(true);
		$titD->getFont()->setColor( new PHPExcel_Style_Color(PHPExcel_Style_Color::COLOR_DARKGREEN  ) );
		
		$titE=$objRichTextE->createTextRun("Client Version");
		$titE->getFont()->setBold(true);
		$titE->getFont()->setColor( new PHPExcel_Style_Color(PHPExcel_Style_Color::COLOR_DARKGREEN  ) );
		
		$titF=$objRichTextF->createTextRun("Version Code");
		$titF->getFont()->setBold(true);
		$titF->getFont()->setColor( new PHPExcel_Style_Color(PHPExcel_Style_Color::COLOR_DARKGREEN  ) );
		
		$titG=$objRichTextG->createTextRun("Client Build");
		$titG->getFont()->setBold(true);
		$titG->getFont()->setColor( new PHPExcel_Style_Color(PHPExcel_Style_Color::COLOR_DARKGREEN  ) );
		
		$titH=$objRichTextH->createTextRun("Store Type");
		$titH->getFont()->setBold(true);
		$titH->getFont()->setColor( new PHPExcel_Style_Color(PHPExcel_Style_Color::COLOR_DARKGREEN  ) );
		
		$titI=$objRichTextI->createTextRun("Package Type");
		$titI->getFont()->setBold(true);
		$titI->getFont()->setColor( new PHPExcel_Style_Color(PHPExcel_Style_Color::COLOR_DARKGREEN  ) );
		
		$titJ=$objRichTextJ->createTextRun("Package Name");
		$titJ->getFont()->setBold(true);
		$titJ->getFont()->setColor( new PHPExcel_Style_Color(PHPExcel_Style_Color::COLOR_DARKGREEN  ) );
		
		$titK=$objRichTextK->createTextRun("MSV");
		$titK->getFont()->setBold(true);
		$titK->getFont()->setColor( new PHPExcel_Style_Color(PHPExcel_Style_Color::COLOR_DARKGREEN  ) );
		
		$titL=$objRichTextL->createTextRun("Min SDK Version");
		$titL->getFont()->setBold(true);
		$titL->getFont()->setColor( new PHPExcel_Style_Color(PHPExcel_Style_Color::COLOR_DARKGREEN  ) );
		
		$titM=$objRichTextM->createTextRun("Target SDK Version");
		$titM->getFont()->setBold(true);
		$titM->getFont()->setColor( new PHPExcel_Style_Color(PHPExcel_Style_Color::COLOR_DARKGREEN  ) );
		
		$titN=$objRichTextN->createTextRun("File Name");
		$titN->getFont()->setBold(true);
		$titN->getFont()->setColor( new PHPExcel_Style_Color(PHPExcel_Style_Color::COLOR_DARKGREEN  ) );
		
		$titO=$objRichTextO->createTextRun("Notes");
		$titO->getFont()->setBold(true);
		$titO->getFont()->setColor( new PHPExcel_Style_Color(PHPExcel_Style_Color::COLOR_DARKGREEN  ) );
		
		
		$objPHPExcel->getActiveSheet()->getCell("A1")->setValue($objRichTextA);
		$objPHPExcel->getActiveSheet()->getStyle("A1")->getAlignment()->setWrapText(false);
		$objPHPExcel->getActiveSheet()->getCell("B1")->setValue($objRichTextB);
		$objPHPExcel->getActiveSheet()->getStyle("B1")->getAlignment()->setWrapText(false);
		$objPHPExcel->getActiveSheet()->getCell("C1")->setValue($objRichTextC);
		$objPHPExcel->getActiveSheet()->getStyle("C1")->getAlignment()->setWrapText(false);
		$objPHPExcel->getActiveSheet()->getCell("D1")->setValue($objRichTextD);
		$objPHPExcel->getActiveSheet()->getStyle("D1")->getAlignment()->setWrapText(false);
		$objPHPExcel->getActiveSheet()->getCell("E1")->setValue($objRichTextE);
		$objPHPExcel->getActiveSheet()->getStyle("E1")->getAlignment()->setWrapText(false);
		$objPHPExcel->getActiveSheet()->getCell("F1")->setValue($objRichTextF);
		$objPHPExcel->getActiveSheet()->getStyle("F1")->getAlignment()->setWrapText(false);
		$objPHPExcel->getActiveSheet()->getCell("G1")->setValue($objRichTextG);
		$objPHPExcel->getActiveSheet()->getStyle("G1")->getAlignment()->setWrapText(false);
		$objPHPExcel->getActiveSheet()->getCell("H1")->setValue($objRichTextH);
		$objPHPExcel->getActiveSheet()->getStyle("H1")->getAlignment()->setWrapText(false);
		$objPHPExcel->getActiveSheet()->getCell("I1")->setValue($objRichTextI);
		$objPHPExcel->getActiveSheet()->getStyle("I1")->getAlignment()->setWrapText(false);
		$objPHPExcel->getActiveSheet()->getCell("J1")->setValue($objRichTextJ);
		$objPHPExcel->getActiveSheet()->getStyle("J1")->getAlignment()->setWrapText(false);
		$objPHPExcel->getActiveSheet()->getCell("K1")->setValue($objRichTextK);
		$objPHPExcel->getActiveSheet()->getStyle("K1")->getAlignment()->setWrapText(false);
		$objPHPExcel->getActiveSheet()->getCell("L1")->setValue($objRichTextL);
		$objPHPExcel->getActiveSheet()->getStyle("L1")->getAlignment()->setWrapText(false);
		$objPHPExcel->getActiveSheet()->getCell("M1")->setValue($objRichTextM);
		$objPHPExcel->getActiveSheet()->getStyle("M1")->getAlignment()->setWrapText(false);
		$objPHPExcel->getActiveSheet()->getCell("N1")->setValue($objRichTextN);
		$objPHPExcel->getActiveSheet()->getStyle("N1")->getAlignment()->setWrapText(false);
		$objPHPExcel->getActiveSheet()->getCell("O1")->setValue($objRichTextO);
		$objPHPExcel->getActiveSheet()->getStyle("O1")->getAlignment()->setWrapText(false);
		
		//set value row 1+
		$j=1;
		if(count($dataexp)>0){
			for($i=0;$i<count($dataexp);$i++){
				$j++;
			$objPHPExcel->getActiveSheet()->setCellValue("A$j", $dataexp[$i]['game_code'])
											->getStyle("A$j")->getAlignment()->setWrapText(false);
			$objPHPExcel->getActiveSheet()->setCellValue("B$j", $dataexp[$i]['game_name'])
											->getStyle("B$j")->getAlignment()->setWrapText(false);
			$objPHPExcel->getActiveSheet()->setCellValue("C$j", $dataexp[$i]['platform'])
											->getStyle("C$j")->getAlignment()->setWrapText(false);
			$objPHPExcel->getActiveSheet()->setCellValue("D$j", $dataexp[$i]['sdkversion'])
											->getStyle("D$j")->getAlignment()->setWrapText(false);
			$objPHPExcel->getActiveSheet()->setCellValue("E$j", $dataexp[$i]['client_version'])
											->getStyle("E$j")->getAlignment()->setWrapText(false);
			$objPHPExcel->getActiveSheet()->setCellValue("F$j", $dataexp[$i]['version_code'])
											->getStyle("F$j")->getAlignment()->setWrapText(false);
			$objPHPExcel->getActiveSheet()->setCellValue("G$j", $dataexp[$i]['client_build'])
											->getStyle("G$j")->getAlignment()->setWrapText(false);
			$objPHPExcel->getActiveSheet()->setCellValue("H$j", $dataexp[$i]['story_stype'])
											->getStyle("H$j")->getAlignment()->setWrapText(false);
			$objPHPExcel->getActiveSheet()->setCellValue("I$j", $dataexp[$i]['package_type'])
											->getStyle("I$j")->getAlignment()->setWrapText(false);
			$objPHPExcel->getActiveSheet()->setCellValue("J$j", $dataexp[$i]['package_name'])
											->getStyle("J$j")->getAlignment()->setWrapText(false);
			$objPHPExcel->getActiveSheet()->setCellValue("K$j", $dataexp[$i]['msv'])
											->getStyle("K$j")->getAlignment()->setWrapText(false);
			$objPHPExcel->getActiveSheet()->setCellValue("L$j", $dataexp[$i]['min_sdk_version'])
											->getStyle("L$j")->getAlignment()->setWrapText(false);
			$objPHPExcel->getActiveSheet()->setCellValue("M$j", $dataexp[$i]['target_sdk_version'])
											->getStyle("M$j")->getAlignment()->setWrapText(false);
			$objPHPExcel->getActiveSheet()->setCellValue("N$j", $dataexp[$i]['file_name'])
											->getStyle("N$j")->getAlignment()->setWrapText(false);
			$objPHPExcel->getActiveSheet()->setCellValue("O$j", $dataexp[$i]['notes'])
											->getStyle("O$j")->getAlignment()->setWrapText(false);
			}//end for
		}//end if
		
		//set border
		$pos=count($dataexp)+1;
		$objPHPExcel->getActiveSheet()->getStyle("A1:O$pos")->applyFromArray(
		array('fill' 	=> array(
									'type'		=> PHPExcel_Style_Fill::FILL_SOLID,
									'color'		=> array('argb' => 'E6D6D6')
								),
			  'borders' => array(
			  						'top'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
									'left'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
									'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
									'right'		=> array('style' => PHPExcel_Style_Border::BORDER_THIN)
								)
			 )
		);
		
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		//$objWriter->save($pathfile);
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="'.$pathfile.'"');
		header('Cache-Control: max-age=0');
		// If you're serving to IE 9, then the following may be needed
		header('Cache-Control: max-age=1');
		
		// If you're serving to IE over SSL, then the following may be needed
		header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
		header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header ('Pragma: public'); // HTTP/1.0
		
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('php://output');
		exit;
		
	}
	public function ExportExcel($dataexp,$pathfile){
		$this->ExportExcelFormatCellOne($dataexp,"LibSdkVersion_".$dataexp['game_code']."_".date('Y_m_d').".xls");
		exit();
		$exporter = new ExportDataExcel('browser', "LibSdkVersion_".$dataexp['game_code']."_".date('Y_m_d').".xls");

		$exporter->initialize(); // starts streaming data to web browser
		
		// pass addRow() an array and it converts it to Excel XML format and sends 
		// it to the browser
		
		$exporter->addRow(array('Game Code','Game Name','Platform','SDK Version','Client Version','Version Code','Client Build','Store Type','Package Type','Package Name','SMV','Min SDK Version','Target SDK Version
','File Name','Notes'));
		$exporter->addRow(array($dataexp['game_code'],$dataexp['game_name'],$dataexp['platform'],$dataexp['sdkversion'],$dataexp['client_version'],$dataexp['version_code'],$dataexp['client_build'],$dataexp['story_stype'],$dataexp['package_type'],$dataexp['package_name'],$dataexp['msv'],$dataexp['min_sdk_version'],$dataexp['target_sdk_version'],$dataexp['file_name'],$dataexp['notes']));
		//$exporter->addRow(array(implode(', ',array_values($dataexp))));
		
		// doesn't care how many columns you give it
		//$exporter->addRow(array("foo")); 
		
		$exporter->finalize(); // writes the footer, flushes remaining data to browser.
		
		exit(); // all done
	}
	public function ExportExcelAll($arrData,$pathfile){
		$this->ExportExcelFormatCellAll($arrData,"LibSdkVersion_".$arrData[0]['game_code']."_".date('Y_m_d').".xls");
		exit();
		$exporter = new ExportDataExcel('browser', "LibSdkVersion_".$arrData[0]['game_code']."_".date('Y_m_d').".xls");

		$exporter->initialize(); // starts streaming data to web browser
		
		// pass addRow() an array and it converts it to Excel XML format and sends 
		// it to the browser
		$exporter->addRow(array('Game Code','Game Name','Platform','SDK Version','Client Version','Version Code','Client Build','Store Type','Package Type','Package Name','SMV','Min SDK Version','Target SDK Version
','File Name','Notes'));
		if(count($arrData)>0){
			for($i=0;$i<count($arrData);$i++){
				$exporter->addRow(array($arrData[$i]['game_code'],$arrData[$i]['game_name'],$arrData[$i]['platform'],$arrData[$i]['sdkversion'],$arrData[$i]['client_version'],$arrData[$i]['version_code'],$arrData[$i]['client_build'],$arrData[$i]['story_stype'],$arrData[$i]['package_type'],$arrData[$i]['package_name'],$arrData[$i]['msv'],$arrData[$i]['min_sdk_version'],$arrData[$i]['target_sdk_version'],$arrData[$i]['file_name'],$arrData[$i]['notes']));
			}
		}
		
		// doesn't care how many columns you give it
		//$exporter->addRow(array("foo")); 
		
		$exporter->finalize(); // writes the footer, flushes remaining data to browser.
		
		exit(); // all done
	}
	
	
	public function SendAlertCheclist($id_request,$subject,$contents,$in_email,$cc){
		$id=$id_request;
		$subject=$subject;
		$html = '<!DOCTYPE HTML>';
		$html.='<html>';
		$html.='<head>';	
		$html.='<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
		$html.='</head>';	
		$html.='<body>';
		$contenthtml=$html.$contents."</body></html>";
		
		$email='["'.$in_email.'"]'; //game.coor.lead@mecorp.vn
		$send_sms="1";
		$account="m2";
		$secretkey="jh2qeQhLbR#m2";
		$token=md5($id.$subject.$contenthtml.$email.$cc.$send_sms.$account.$secretkey);
		
		$post_array = array(
						"id"=>$id,
						"subject"=>$subject,
						"content"=>$contenthtml,
						"email"=>$email,
						"cc"=>$cc,
						"send_sms"=>1,
						"account"=>$account,
						"token"=>$token
					);
		//$urlsfull="http://alert.gomobi.vn/service/alertemail?".http_build_query($post_array);
		//$pp=$id.$subject.$contenthtml.$email.$send_sms.$account.$secretkey;
		$urls="http://alert.gomobi.vn/service/alertemail";
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $urls);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_TIMEOUT, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_array));
		$reponse = curl_exec($ch);  
		curl_close($ch);
		return $reponse;
	}//end func
	

}

?>