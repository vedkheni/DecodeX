<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use \DateTime; 
use CodeIgniter\HTTP\RequestInterface;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Export_excel extends BaseController {
	public function __construct()
	{
		parent::__construct();
		$user_session=$this->session->get('id');
		if(!$user_session){
			return redirect()->to(base_url());	
		}
	}
	public function myRange($end_column = '', $first_letters = '') {
		$columns = array();
		$length = strlen($end_column);
		$letters = range('A', 'Z');
		foreach ($letters as $letter) {
		  $column = $first_letters . $letter; 
		  $columns[] = $column;
		  if ($column == $end_column)
			  return $columns;
		}
		foreach ($columns as $column) {
		  if (!in_array($end_column, $columns) && strlen($column) < $length) {
			  $new_columns = $this->myRange($end_column, $column);
			  $columns = array_merge($columns, $new_columns);
		  }
		}
		return $columns;
	}
	public function used_paid_leave_excel(){
		/* $this->load->library('exportexcel');
	    $objPHPExcel = new PHPExcel(); */
		$spreadsheet = new Spreadsheet();
	    $objPHPExcel = $spreadsheet;
		$objPHPExcel->setActiveSheetIndex(0);
		$alphas = $this->myRange('ZZ');
		$employee_detail = $this->Employee_Model->get_employee_list(1);		
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN)->getColor()->setRGB('DDDDDD');
		$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Month');
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR)->getStartColor()->setRGB('2f323e');
		// $objPHPExcel->getActiveSheet()->getStyle('A1')->setItalic(true);
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true)->setSize(12)->getColor()->setRGB('FFFFFF');
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);		
		$i=1;		$e=count($employee_detail);		$objPHPExcel->getActiveSheet()->getStyle('A1:'.$alphas[$e].'1')->getAlignment()->setWrapText(true);
		$year1 = $this->uri->getSegment(3);
		// $year1 = $this->input->post('year');
		$year = date("Y");
		if($year1 == 'all_year'){
			$get_prof_tax_year = $this->Leave_Report_Model->get_year_employee_paid_leaves();
			$all_data_year = array();
			foreach ($get_prof_tax_year as $k1 => $v1) {
				$all_data_year[] = $v1->year;
			}
			$year_reverse = $all_data_year;
			$year1 = count($year_reverse);
		}else{
			for($y=0;$y<$year1;$y++){$year_name[]= $year-$y;}
			$year_reverse = array_reverse($year_name);
		}
	 	foreach($employee_detail as $key => $value){
	 		$objPHPExcel->getActiveSheet()->getStyle($alphas[$i].'1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR)->getStartColor()->setRGB('2f323e');
			 $objPHPExcel->getActiveSheet()->getStyle($alphas[$i].'1')->getFont()->setBold(true)->setSize(12)->getColor()->setRGB('FFFFFF');
			 $objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$i])->setWidth(15);
			 $fullname = $value->fname.' '.$value->lname;
			 $objPHPExcel->getActiveSheet()->SetCellValue($alphas[$i].'1', $fullname);
			$m1 = 1;
			for($y=0;$y<$year1;$y++){
				$arr['year'] = $year_reverse[$y];
				$arr['id'] = $value->id;
				$employee_data = $this->Leave_Report_Model->get_employee_paid_leaves($arr);
				if(!empty($employee_data)){
					foreach ($employee_data as $k => $v){
						$month_name = date("F Y", mktime(0, 0, 0, $v->month, 10,$v->year));
						if($y > 0){
							$k2 = ($y*12)+($v->month+1);
						}else{
							$k2 = $v->month+1;
						}
						if($v->status == 'used'){
							$leave_month_use="(".date("F", mktime(0, 0, 0, $v->used_leave_month, 10,$v->year)).")";
							$excel_v = $v->leave." ".$leave_month_use;
								$objPHPExcel->getActiveSheet()->getStyle($alphas[$i].$k2)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR)->getStartColor()->setRGB('008200');
								$objPHPExcel->getActiveSheet()->getStyle($alphas[$i].$k2)->getFont()->getColor()->setRGB('FFFFFF');
							$objPHPExcel->getActiveSheet()->SetCellValue($alphas[$i].$k2, $excel_v);
						}else if($v->status == 'rejected'){
							$leave_month_use="(".date("F", mktime(0, 0, 0, $v->used_leave_month, 10,$v->year)).")";
							$excel_v = $v->leave." ".$leave_month_use;
								$objPHPExcel->getActiveSheet()->getStyle($alphas[$i].$k2)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR)->getStartColor()->setRGB('f32013');
								$objPHPExcel->getActiveSheet()->getStyle($alphas[$i].$k2)->getFont()->getColor()->setRGB('FFFFFF');
							$objPHPExcel->getActiveSheet()->SetCellValue($alphas[$i].$k2, $excel_v);
						}else{
							$leave_month_use="";
							$excel_v = $v->leave." ".$leave_month_use;
								$objPHPExcel->getActiveSheet()->getStyle($alphas[$i].$k2)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR)->getStartColor()->setRGB('ffcc00');
								$objPHPExcel->getActiveSheet()->getStyle($alphas[$i].$k2)->getFont()->getColor()->setRGB('FFFFFF');
							$objPHPExcel->getActiveSheet()->SetCellValue($alphas[$i].$k2, $excel_v);
						}
						$year_month['emp_detail'][$value->fname][$month_name]=$v->leave." ".$leave_month_use;
					}
				}
				for($m=1;$m<=12;$m++){
					$month_name = date("F Y", mktime(0, 0, 0, $m, 10,$year_reverse[$y]));
					if(!isset($year_month['emp_detail'][$value->fname][$month_name])){
						$k2 = $m1+1;
						$objPHPExcel->getActiveSheet()->SetCellValue($alphas[$i].$k2, '-');
					}
					$m1++;	
				}
			}
			$styleArray = array(
			        'borders' => array(
			            'allborders' => array(
			                // 'style' => PHPExcel_Style_Border::BORDER_THIN
							'style' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
			                )
			            )
			        );
				$objPHPExcel->getActiveSheet()->getStyle('A1:'.$alphas[$i].$k2)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('A1:'.$alphas[$i].$k2)->getFont()->setName('Italic');
			$i++;
		}
		$m1 = 1;
		for($y=0;$y<$year1;$y++){
			for($m=1;$m<=12;$m++){
				$month_name1 = date("F Y", mktime(0, 0, 0, $m, 10,$year_reverse[$y]));
				$k2 = $m1+1;
				// $objPHPExcel->getActiveSheet()->getStyle('A'.$k2)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR)->getStartColor()->setRGB('FFFFFF');
				$objPHPExcel->getActiveSheet()->getStyle('A'.$k2)->getFont()->getColor()->setRGB('2f323e');
				$objPHPExcel->getActiveSheet()->SetCellValue('A'.$k2, $month_name1);
			$m1++;
			}
		}
		$filename = "used_paid_leave_report.xls";
        header("Content-Type: application/vnd.ms-excel");
		header('Content-Disposition: attachment;filename="'.$filename.'"');
		header('Cache-Control: max-age=0');
		$writer = new Xlsx($spreadsheet);
		$writer->save('php://output');
		/* header('Content-Type: application/vnd.ms-excel'); 
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');   
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');  
        $objWriter->save('php://output'); */	
	}
	public function leave_excel(){
		$spreadsheet = new Spreadsheet();
		$objPHPExcel = $spreadsheet;
		$objPHPExcel->setActiveSheetIndex(0);
		$alphas = $this->myRange('ZZ');
		$employee_detail = $this->Employee_Model->get_employee_list(1);
		$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Month');
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR)->getStartColor()->setRGB('2f323e');
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true)->setName('Italic')->setSize(12)->getColor()->setRGB('FFFFFF');		$e=count($employee_detail);		$objPHPExcel->getActiveSheet()->getStyle('A1:'.$alphas[$e].'1')->getAlignment()->setWrapText(true);
		$i=1;		
		$year1 = $this->uri->getSegment(3);
		$year = date("Y");
		if($year1 == 'all_year'){
			$get_prof_tax_year = $this->Leave_Report_Model->get_leave_year();
			$all_data_year = array();
			foreach ($get_prof_tax_year as $k1 => $v1) {
				$all_data_year[] = $v1->year;
			}
			$year_reverse = $all_data_year;
			$year1 = count($year_reverse);
		}else{
			for($y=0;$y<$year1;$y++){$year_name[]= $year-$y;}
			$year_reverse = array_reverse($year_name);
		}
		foreach($employee_detail as $key => $value){
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$i].'1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR)->getStartColor()->setRGB('2f323e');
			 $objPHPExcel->getActiveSheet()->getStyle($alphas[$i].'1')->getFont()->setBold(true)->setName('Italic')->setSize(12)->getColor()->setRGB('FFFFFF');
			 $objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$i])->setWidth(15);
			 $fullname = $value->fname.' '.$value->lname;
			 $objPHPExcel->getActiveSheet()->SetCellValue($alphas[$i].'1', $fullname);
			$m1 = 1;
			for($y=0;$y<$year1;$y++){
				$arr['year'] = $year_reverse[$y];
				$arr['id'] = $value->id;
				$employee_data = $this->Leave_Report_Model->get_employee_list_with_leave($arr);
				if(!empty($employee_data)){
					foreach ($employee_data as $k => $v){
						if($y > 0){
							$k2 = ($y*12)+($v->month+1);
						}else{
							$k2 = $v->month+1;
						}
						$month_name = date("F Y", mktime(0, 0, 0, $v->month, 10,$v->year));
						$year_month['emp_detail'][$value->fname][$month_name]=$v->total_leaves;
						$objPHPExcel->getActiveSheet()->SetCellValue($alphas[$i].$k2, $v->total_leaves);
					}
				}
				for($m=1;$m<=12;$m++){
					$month_name = date("F Y", mktime(0, 0, 0, $m, 10,$year_reverse[$y]));
					if(!isset($year_month['emp_detail'][$value->fname][$month_name])){
						$k2 = $m1+1;
						$objPHPExcel->getActiveSheet()->SetCellValue($alphas[$i].$k2, '-');
					}
					$m1++;
				}
			}
			$styleArray = array(
			        'borders' => array(
			            'allborders' => array(
			                // 'style' => PHPExcel_Style_Border::BORDER_THIN
							'style' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
			                )
			            )
			        );
				$objPHPExcel->getActiveSheet()->getStyle('A1:'.$alphas[$i].$k2)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('A1:'.$alphas[$i].$k2)->getFont()->setName('Italic');
			$i++;
		}
		$m1 = 1;
		for($y=0;$y<$year1;$y++){
			for($m=1;$m<=12;$m++){
				$month_name1 = date("F Y", mktime(0, 0, 0, $m, 10,$year_reverse[$y]));
				$k2 = $m1+1;
				// $objPHPExcel->getActiveSheet()->getStyle('A'.$k2)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR)->getStartColor()->setRGB('FFFFFF');
				$objPHPExcel->getActiveSheet()->getStyle('A'.$k2)->getFont()->setName('Italic')->getColor()->setRGB('2f323e');
				$objPHPExcel->getActiveSheet()->SetCellValue('A'.$k2, $month_name1);
				$m1++;
			}
		}
		$filename = "Leave_report.xls";
        header("Content-Type: application/vnd.ms-excel");
		header('Content-Disposition: attachment;filename="'.$filename.'"');
		header('Cache-Control: max-age=0');
		$writer = new Xlsx($spreadsheet);
		$writer->save('php://output');
		/* header('Content-Type: application/vnd.ms-excel'); 
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');   
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');  
        $objWriter->save('php://output'); */	
	}
	public function prof_tax_excel(){
		$spreadsheet = new Spreadsheet();
		$objPHPExcel = $spreadsheet;
		$objPHPExcel->setActiveSheetIndex(0);
		$alphas = $this->myRange('ZZ');
		$employee_detail = $this->Employee_Model->get_employee_list(1);
		$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Month');
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR)->getStartColor()->setRGB('2f323e');
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true)->setSize(12)->getColor()->setRGB('FFFFFF');		$e=count($employee_detail);		$objPHPExcel->getActiveSheet()->getStyle('A1:'.$alphas[$e].'1')->getAlignment()->setWrapText(true);
		$i=1;
		$year1 = $this->uri->getSegment(3);
		$year = date("Y");
		if($year1 == 'all_year'){
			$get_prof_tax_year = $this->Prof_Tax_Model->get_prof_tax_year();
			$all_data_year = array();
			foreach ($get_prof_tax_year as $k1 => $v1) {
				$all_data_year[] = $v1->year;
			}
			$year_reverse = $all_data_year;
			$year1 = count($year_reverse);
		}else{
			for($y=0;$y<$year1;$y++){$year_name[]= $year-$y;}
			$year_reverse = array_reverse($year_name);
		}
		foreach($employee_detail as $key => $value){
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$i].'1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR)->getStartColor()->setRGB('2f323e');
			 $objPHPExcel->getActiveSheet()->getStyle($alphas[$i].'1')->getFont()->setBold(true)->setSize(12)->getColor()->setRGB('FFFFFF');
			 $objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$i])->setWidth(15);
			 $fullname = $value->fname.' '.$value->lname;
			 $objPHPExcel->getActiveSheet()->SetCellValue($alphas[$i].'1', $fullname);
			$m1 = 1;
			for($y=0;$y<$year1;$y++){
				$arr['year'] = $year_reverse[$y];
				$arr['id'] = $value->id;
				$employee_data = $this->Prof_Tax_Model->allposts_prof_tax($arr);
				if(!empty($employee_data)){
					foreach ($employee_data as $k => $v){
						if($y > 0){
							$k2 = ($y*12)+($v->month+1);
						}else{
							$k2 = $v->month+1;
						}
						$month_name = date("F Y", mktime(0, 0, 0, $v->month, 10,$v->year));
						$year_month['emp_detail'][$value->fname][$month_name]=$v->prof_tax;
						$objPHPExcel->getActiveSheet()->SetCellValue($alphas[$i].$k2, $v->prof_tax);
					}
				}
				for($m=1;$m<=12;$m++){
					$month_name = date("F Y", mktime(0, 0, 0, $m, 10,$year_reverse[$y]));
					if(!isset($year_month['emp_detail'][$value->fname][$month_name])){
						$k2 = $m1+1;
						$objPHPExcel->getActiveSheet()->SetCellValue($alphas[$i].$k2, '-');
					}
					$m1++;
				}
			}
			$styleArray = array(
			        'borders' => array(
			            'allborders' => array(
			                // 'style' => PHPExcel_Style_Border::BORDER_THIN
							'style' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
			                )
			            )
			        );
				$objPHPExcel->getActiveSheet()->getStyle('A1:'.$alphas[$i].$k2)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('A1:'.$alphas[$i].$k2)->getFont()->setName('Italic');
			$i++;
		}
		$m1 = 1;
		for($y=0;$y<$year1;$y++){
			for($m=1;$m<=12;$m++){
				$month_name1 = date("F Y", mktime(0, 0, 0, $m, 10,$year_reverse[$y]));
				$k2 = $m1+1;
				// $objPHPExcel->getActiveSheet()->getStyle('A'.$k2)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR)->getStartColor()->setRGB('FFFFFF');
				$objPHPExcel->getActiveSheet()->getStyle('A'.$k2)->getFont()->getColor()->setRGB('2f323e');
				$objPHPExcel->getActiveSheet()->SetCellValue('A'.$k2, $month_name1);
				$m1++;
			}
		}
		$filename = "Prof_tax_report.xls";
        header("Content-Type: application/vnd.ms-excel");
		header('Content-Disposition: attachment;filename="'.$filename.'"');
		header('Cache-Control: max-age=0');
		$writer = new Xlsx($spreadsheet);
		$writer->save('php://output');
		/* header('Content-Type: application/vnd.ms-excel'); 
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');   
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');  
        $objWriter->save('php://output'); */	
	}
	public function salary_excel(){
		$spreadsheet = new Spreadsheet();
		$objPHPExcel = $spreadsheet;
		$objPHPExcel->setActiveSheetIndex(0);
		$alphas = $this->myRange('ZZ');
		$employee_detail = $this->Employee_Model->get_employee_list(1);
		$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Month');
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR)->getStartColor()->setRGB('2f323e');
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true)->setSize(12)->getColor()->setRGB('FFFFFF');		$e=count($employee_detail);		$objPHPExcel->getActiveSheet()->getStyle('A1:'.$alphas[$e].'1')->getAlignment()->setWrapText(true);
		$i=1;
		$year1 = $this->uri->getSegment(3);
		$year = date("Y");
		if($year1 == 'all_year'){
			$get_prof_tax_year = $this->Leave_Report_Model->get_leave_year();
			$all_data_year = array();
			foreach ($get_prof_tax_year as $k1 => $v1) {
				$all_data_year[] = $v1->year;
			}
			$year_reverse = $all_data_year;
			$year1 = count($year_reverse);
		}else{
			for($y=0;$y<$year1;$y++){$year_name[]= $year-$y;}
			$year_reverse = array_reverse($year_name);
		}
		foreach($employee_detail as $key => $value){
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$i].'1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR)->getStartColor()->setRGB('2f323e');
			 $objPHPExcel->getActiveSheet()->getStyle($alphas[$i].'1')->getFont()->setBold(true)->setSize(12)->getColor()->setRGB('FFFFFF');
			 $objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$i])->setWidth(15);
			 $fullname = $value->fname.' '.$value->lname;
			 $objPHPExcel->getActiveSheet()->SetCellValue($alphas[$i].'1', $fullname);
			$m1 = 1;
			for($y=0;$y<$year1;$y++){
				$arr['year'] = $year_reverse[$y];
				$arr['id'] = $value->id;
				$employee_data = $this->Leave_Report_Model->get_employee_list_with_leave($arr);
				if(!empty($employee_data)){
					foreach ($employee_data as $k => $v){
						if($y > 0){
							$k2 = ($y*12)+($v->month+1);
						}else{
							$k2 = $v->month+1;
						}
						$month_name = date("F Y", mktime(0, 0, 0, $v->month, 10,$v->year));
						$year_month['emp_detail'][$value->fname][$month_name]=$v->net_salary;
						$objPHPExcel->getActiveSheet()->SetCellValue($alphas[$i].$k2, $v->net_salary);
					}
				}
				for($m=1;$m<=12;$m++){
					$month_name = date("F Y", mktime(0, 0, 0, $m, 10,$year_reverse[$y]));
					if(!isset($year_month['emp_detail'][$value->fname][$month_name])){
						$k2 = $m1+1;
						$objPHPExcel->getActiveSheet()->SetCellValue($alphas[$i].$k2, '-');
					}
					$m1++;
				}
			}
			$styleArray = array(
			        'borders' => array(
			            'allborders' => array(
			                // 'style' => PHPExcel_Style_Border::BORDER_THIN
							'style' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
			                )
			            )
			        );
				$objPHPExcel->getActiveSheet()->getStyle('A1:'.$alphas[$i].$k2)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('A1:'.$alphas[$i].$k2)->getFont()->setName('Italic');
			$i++;
		}
		$m1 = 1;
		for($y=0;$y<$year1;$y++){
			for($m=1;$m<=12;$m++){
				$month_name1 = date("F Y", mktime(0, 0, 0, $m, 10,$year_reverse[$y]));
				$k2 = $m1+1;
				// $objPHPExcel->getActiveSheet()->getStyle('A'.$k2)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR)->getStartColor()->setRGB('FFFFFF');
				$objPHPExcel->getActiveSheet()->getStyle('A'.$k2)->getFont()->getColor()->setRGB('2f323e');
				$objPHPExcel->getActiveSheet()->SetCellValue('A'.$k2, $month_name1);
				$m1++;
			}
		}
		$filename = "Salary_report.xls";
        header("Content-Type: application/vnd.ms-excel");
		header('Content-Disposition: attachment;filename="'.$filename.'"');
		header('Cache-Control: max-age=0');
		$writer = new Xlsx($spreadsheet);
		$writer->save('php://output');
		/* header('Content-Type: application/vnd.ms-excel'); 
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');   
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');  
        $objWriter->save('php://output'); */	
	}
	public function sick_leave_excel(){
		$spreadsheet = new Spreadsheet();
		$objPHPExcel = $spreadsheet;
		$objPHPExcel->setActiveSheetIndex(0);
		$alphas = $this->myRange('ZZ');
		$employee_detail = $this->Employee_Model->get_employee_list(1);
		$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Month');
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR)->getStartColor()->setRGB('2f323e');
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true)->setSize(12)->getColor()->setRGB('FFFFFF');
		$i=1;		$e=count($employee_detail);		$objPHPExcel->getActiveSheet()->getStyle('A1:'.$alphas[$e].'1')->getAlignment()->setWrapText(true);
		$year1 = $this->uri->getSegment(3);
		$year = date("Y");
		if($year1 == 'all_year'){
			$get_prof_tax_year = $this->Leave_Report_Model->get_leave_year();
			$all_data_year = array();
			foreach ($get_prof_tax_year as $k1 => $v1) {
				$all_data_year[] = $v1->year;
			}
			$year_reverse = $all_data_year;
			$year1 = count($year_reverse);
		}else{
			for($y=0;$y<$year1;$y++){$year_name[]= $year-$y;}
			$year_reverse = array_reverse($year_name);
		}
		foreach($employee_detail as $key => $value){
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$i].'1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR)->getStartColor()->setRGB('2f323e');
			 $objPHPExcel->getActiveSheet()->getStyle($alphas[$i].'1')->getFont()->setBold(true)->setSize(12)->getColor()->setRGB('FFFFFF');
			 $objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$i])->setWidth(15);
			 $fullname = $value->fname.' '.$value->lname;
			 $objPHPExcel->getActiveSheet()->SetCellValue($alphas[$i].'1', $fullname);
			$m1 = 1;
			for($y=0;$y<$year1;$y++){
				$arr['year'] = $year_reverse[$y];
				$arr['id'] = $value->id;
				$employee_data = $this->Leave_Report_Model->get_employee_list_with_leave($arr);
				if(!empty($employee_data)){
					foreach ($employee_data as $k => $v){
						if($y > 0){
							$k2 = ($y*12)+($v->month+1);
						}else{
							$k2 = $v->month+1;
						}
						$month_name = date("F Y", mktime(0, 0, 0, $v->month, 10,$v->year));
						$year_month['emp_detail'][$value->fname][$month_name]=$v->sick_leave;
						$objPHPExcel->getActiveSheet()->SetCellValue($alphas[$i].$k2, $v->sick_leave);
					}
				}
				for($m=1;$m<=12;$m++){
					$month_name = date("F Y", mktime(0, 0, 0, $m, 10,$year_reverse[$y]));
					if(!isset($year_month['emp_detail'][$value->fname][$month_name])){
						$k2 = $m1+1;
						$objPHPExcel->getActiveSheet()->SetCellValue($alphas[$i].$k2, '-');
					}
					$m1++;
				}
			}
			$styleArray = array(
			        'borders' => array(
			            'allborders' => array(
			                // 'style' => PHPExcel_Style_Border::BORDER_THIN
							'style' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
			                )
			            )
			        );
				$objPHPExcel->getActiveSheet()->getStyle('A1:'.$alphas[$i].$k2)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('A1:'.$alphas[$i].$k2)->getFont()->setName('Italic');
			$i++;
		}
		$m1 = 1;
		for($y=0;$y<$year1;$y++){
			for($m=1;$m<=12;$m++){
				$month_name1 = date("F Y", mktime(0, 0, 0, $m, 10,$year_reverse[$y]));
				$k2 = $m1+1;
				// $objPHPExcel->getActiveSheet()->getStyle('A'.$k2)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR)->getStartColor()->setRGB('FFFFFF');
				$objPHPExcel->getActiveSheet()->getStyle('A'.$k2)->getFont()->getColor()->setRGB('2f323e');
				$objPHPExcel->getActiveSheet()->SetCellValue('A'.$k2, $month_name1);
				$m1++;
			}
		}
		$filename = "Sick_leave_report.xls";
        header("Content-Type: application/vnd.ms-excel");
		header('Content-Disposition: attachment;filename="'.$filename.'"');
		header('Cache-Control: max-age=0');
		$writer = new Xlsx($spreadsheet);
		$writer->save('php://output');
		/* header('Content-Type: application/vnd.ms-excel'); 
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');   
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');  
        $objWriter->save('php://output'); */	
	}
	public function paid_leave_excel(){
		/* $this->load->library('exportexcel');
	    $objPHPExcel = new PHPExcel(); */

		/* $styleArray = array(
			'font' => array('bold' => true,),
			'alignment' => array(
			'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
			'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,),
			'borders' => array('top' => array(
			'style' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,),,
			'fill' => array(
			'type' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR,
			'startcolor' => array('argb' => '2f323e',),),);
			$spreadsheet->getActiveSheet()->getStyle('A1:F1')->applyFromArray($styleArray); */
		$spreadsheet = new Spreadsheet();
	    $objPHPExcel = $spreadsheet;
		$objPHPExcel->setActiveSheetIndex(0);
		$alphas = $this->myRange('ZZ');
		$employee_detail = $this->Employee_Model->get_employee_list(1);
		$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Month');
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR)->getStartColor()->setRGB('2f323e');
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true)->setSize(12)->getColor()->setRGB('FFFFFF');		
		$e=count($employee_detail);
		$objPHPExcel->getActiveSheet()->getStyle('A1:'.$alphas[$e].'1')->getAlignment()->setWrapText(true);
		$i=1;
		$year1 = $this->uri->getSegment(3);
		$year = date("Y");
		if($year1 == 'all_year'){
			$get_prof_tax_year = $this->Leave_Report_Model->get_leave_year();
			$all_data_year = array();
			foreach ($get_prof_tax_year as $k1 => $v1) {
				$all_data_year[] = $v1->year;
			}
			$year_reverse = $all_data_year;
			$year1 = count($year_reverse);
		}else{
			for($y=0;$y<$year1;$y++){$year_name[]= $year-$y;}
			$year_reverse = array_reverse($year_name);
		}
		foreach($employee_detail as $key => $value){
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$i].'1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR)->getStartColor()->setRGB('2f323e');
			 $objPHPExcel->getActiveSheet()->getStyle($alphas[$i].'1')->getFont()->setBold(true)->setSize(12)->getColor()->setRGB('FFFFFF');
			 $objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$i])->setWidth(15);
			 $fullname = $value->fname.' '.$value->lname;
			 $objPHPExcel->getActiveSheet()->SetCellValue($alphas[$i].'1', $fullname);
			$m1 = 1;
			for($y=0;$y<$year1;$y++){
				$arr['year'] = $year_reverse[$y];
				$arr['id'] = $value->id;
				$employee_data = $this->Leave_Report_Model->get_employee_list_with_leave($arr);
				if(!empty($employee_data)){
					foreach ($employee_data as $k => $v){
						if($y > 0){
							$k2 = ($y*12)+($v->month+1);
						}else{
							$k2 = $v->month+1;
						}
						$month_name = date("F Y", mktime(0, 0, 0, $v->month, 10,$v->year));
						$year_month['emp_detail'][$value->fname][$month_name]=$v->paid_leave;
						$objPHPExcel->getActiveSheet()->SetCellValue($alphas[$i].$k2, $v->paid_leave);
					}
				}
				for($m=1;$m<=12;$m++){
					$month_name = date("F Y", mktime(0, 0, 0, $m, 10,$year_reverse[$y]));
					if(!isset($year_month['emp_detail'][$value->fname][$month_name])){
						$k2 = $m1+1;
						$objPHPExcel->getActiveSheet()->SetCellValue($alphas[$i].$k2, '-');
					}
					$m1++;
				}
			}
			$styleArray = array(
			        'borders' => array(
			            'allborders' => array(
			                // 'style' => PHPExcel_Style_Border::BORDER_THIN
			                'style' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
			                )
			            )
			        );
				$objPHPExcel->getActiveSheet()->getStyle('A1:'.$alphas[$i].$k2)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('A1:'.$alphas[$i].$k2)->getFont()->setName('Italic');
			$i++;
		}
		$m1 = 1;
		for($y=0;$y<$year1;$y++){
			for($m=1;$m<=12;$m++){
				$month_name1 = date("F Y", mktime(0, 0, 0, $m, 10,$year_reverse[$y]));
				$k2 = $m1+1;
				// $objPHPExcel->getActiveSheet()->getStyle('A'.$k2)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR)->getStartColor()->setRGB('FFFFFF');
				$objPHPExcel->getActiveSheet()->getStyle('A'.$k2)->getFont()->getColor()->setRGB('2f323e');
				$objPHPExcel->getActiveSheet()->SetCellValue('A'.$k2, $month_name1);
				$m1++;
			}
		}
		$filename = "Paid_leave_report.xls";
		header("Content-Type: application/vnd.ms-excel");
		header('Content-Disposition: attachment;filename="'.$filename.'"');
		header('Cache-Control: max-age=0');
        $writer = new Xlsx($spreadsheet);
		$writer->save('php://output');
		// $writer->save("upload/".$filename);

		/* header('Content-Type: application/vnd.ms-excel'); 
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');   
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');  
        $objWriter->save('php://output'); */	
	}
	public function deposit_excel(){
		$spreadsheet = new Spreadsheet();
		
		$objPHPExcel = $spreadsheet;
		$objPHPExcel->setActiveSheetIndex(0);
		$alphas = $this->myRange('ZZ');
		$employee_detail = $this->Employee_Model->get_employee_list(1);
		$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Month');
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR)->getStartColor()->setRGB('2f323e');
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true)->setSize(12)->getColor()->setRGB('FFFFFF');		$e=count($employee_detail);		$objPHPExcel->getActiveSheet()->getStyle('A1:'.$alphas[$e].'1')->getAlignment()->setWrapText(true);
		$i=1;
		$year1 = $this->uri->getSegment(3);
		$year = date("Y");
		if($year1 == 'all_year'){
			$get_prof_tax_year = $this->Deposit_Model->get_deposit_year();
			$all_data_year = array();
			foreach ($get_prof_tax_year as $k1 => $v1) {
				$all_data_year[] = $v1->year;
			}
			$year_reverse = $all_data_year;
			$year1 = count($year_reverse);
		}else{
			for($y=0;$y<$year1;$y++){$year_name[]= $year-$y;}
			$year_reverse = array_reverse($year_name);
		}
		foreach($employee_detail as $key => $value){
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$i].'1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR)->getStartColor()->setRGB('2f323e');
			 $objPHPExcel->getActiveSheet()->getStyle($alphas[$i].'1')->getFont()->setBold(true)->setSize(12)->getColor()->setRGB('FFFFFF');
			 $objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$i])->setWidth(15);
			 $fullname = $value->fname.' '.$value->lname;
			 $objPHPExcel->getActiveSheet()->SetCellValue($alphas[$i].'1', $fullname);
			$m1 = 1;
			for($y=0;$y<$year1;$y++){
				$arr['year'] = $year_reverse[$y];
				$arr['id'] = $value->id;
				$employee_data = $this->Deposit_Model->get_deposit_details($arr['id'],$arr['year']);
				if(!empty($employee_data)){
					foreach ($employee_data as $k => $v){
						if($y > 0){
							$k2 = ($y*12)+($v->month+1);
						}else{
							$k2 = $v->month+1;
						}
						$month_name = date("F Y", mktime(0, 0, 0, $v->month, 10,$v->year));
						if($v->payment_status == 'paid'){
							$objPHPExcel->getActiveSheet()->getStyle($alphas[$i].$k2)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR)->getStartColor()->setRGB('008200');
			 				$objPHPExcel->getActiveSheet()->getStyle($alphas[$i].$k2)->getFont()->getColor()->setRGB('FFFFFF');
							$objPHPExcel->getActiveSheet()->SetCellValue($alphas[$i].$k2, $v->deposit_amount);
						}else{
							$objPHPExcel->getActiveSheet()->SetCellValue($alphas[$i].$k2, $v->deposit_amount);
						}
						$year_month['emp_detail'][$value->fname][$month_name]=$v->deposit_amount;
					}
				}
				for($m=1;$m<=12;$m++){
					$month_name = date("F Y", mktime(0, 0, 0, $m, 10,$year_reverse[$y]));
					if(!isset($year_month['emp_detail'][$value->fname][$month_name])){
						$k2 = $m1+1;
						$objPHPExcel->getActiveSheet()->SetCellValue($alphas[$i].$k2, '-');
					}
					$m1++;
				}
			}
			$styleArray = array(
			        'borders' => array(
			            'allborders' => array(
			                // 'style' => PHPExcel_Style_Border::BORDER_THIN
							'style' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
			                )
			            )
			        );
				$objPHPExcel->getActiveSheet()->getStyle('A1:'.$alphas[$i].$k2)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('A1:'.$alphas[$i].$k2)->getFont()->setName('Italic');
			$i++;
		}
		$m1 = 1;
		for($y=0;$y<$year1;$y++){
			for($m=1;$m<=12;$m++){
				$month_name1 = date("F Y", mktime(0, 0, 0, $m, 10,$year_reverse[$y]));
				$k2 = $m1+1;
				// $objPHPExcel->getActiveSheet()->getStyle('A'.$k2)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR)->getStartColor()->setRGB('FFFFFF');
				$objPHPExcel->getActiveSheet()->getStyle('A'.$k2)->getFont()->getColor()->setRGB('2f323e');
				$objPHPExcel->getActiveSheet()->SetCellValue('A'.$k2, $month_name1);
				$m1++;
			}
		}
		$filename = "Deposit_report.xls";
        header("Content-Type: application/vnd.ms-excel");
		header('Content-Disposition: attachment;filename="'.$filename.'"');
		header('Cache-Control: max-age=0');
		$writer = new Xlsx($spreadsheet);
		$writer->save('php://output');
		/* header('Content-Type: application/vnd.ms-excel'); 
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');   
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');  
        $objWriter->save('php://output'); */	
	}
	public function bouns_excel(){
		/* $this->load->library('exportexcel');
	    $objPHPExcel = new PHPExcel(); */
		$spreadsheet = new Spreadsheet();
	    $objPHPExcel = $spreadsheet;
		$objPHPExcel->setActiveSheetIndex(0);
		$alphas = $this->myRange('ZZ');
		$employee_detail = $this->Employee_Model->get_employee_list(1);
		$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Month');
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR)->getStartColor()->setRGB('2f323e');
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true)->setSize(12)->getColor()->setRGB('FFFFFF');		$e=count($employee_detail);		$objPHPExcel->getActiveSheet()->getStyle('A1:'.$alphas[$e].'1')->getAlignment()->setWrapText(true);
		$i=1;
		$year1 = $this->uri->getSegment(3);
		$year = date("Y");
		if($year1 == 'all_year'){
			$get_prof_tax_year = $this->Bonus_Model->get_bonus_year();
			$all_data_year = array();
			foreach ($get_prof_tax_year as $k1 => $v1) {
				$all_data_year[] = $v1->year;
			}
			$year_reverse = $all_data_year;
			$year1 = count($year_reverse);
		}else{
			for($y=0;$y<$year1;$y++){$year_name[]= $year-$y;}
			$year_reverse = array_reverse($year_name);
		}
		foreach($employee_detail as $key => $value){
			$objPHPExcel->getActiveSheet()->getStyle($alphas[$i].'1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR)->getStartColor()->setRGB('2f323e');
			 $objPHPExcel->getActiveSheet()->getStyle($alphas[$i].'1')->getFont()->setBold(true)->setSize(12)->getColor()->setRGB('FFFFFF');
			 $objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$i])->setWidth(15);
			 $fullname = $value->fname.' '.$value->lname;
			 $objPHPExcel->getActiveSheet()->SetCellValue($alphas[$i].'1', $fullname);
			$m1 = 1;
			for($y=0;$y<$year1;$y++){
				$arr['year'] = $year_reverse[$y];
				$arr['id'] = $value->id;
				$employee_data = $this->Bonus_Model->get_bonus_details($arr['id'],$arr['year']);
				if(!empty($employee_data)){
					foreach ($employee_data as $k => $v){
						if($y > 0){
							$k2 = ($y*12)+($v->month+1);
						}else{
							$k2 = $v->month+1;
						}
						$month_name = date("F Y", mktime(0, 0, 0, $v->month, 10,$v->year));
						$year_month['emp_detail'][$value->fname][$month_name]=$v->bonus;
						$objPHPExcel->getActiveSheet()->SetCellValue($alphas[$i].$k2, $v->bonus);
					}
				}
				for($m=1;$m<=12;$m++){
					$month_name = date("F Y", mktime(0, 0, 0, $m, 10,$year_reverse[$y]));
					if(!isset($year_month['emp_detail'][$value->fname][$month_name])){
						$k2 = $m1+1;
						$objPHPExcel->getActiveSheet()->SetCellValue($alphas[$i].$k2, '-');
					}
					$m1++;
				}
			}
			$styleArray = array(
			        'borders' => array(
			            'allborders' => array(
			                // 'style' => PHPExcel_Style_Border::BORDER_THIN
			                'style' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
			                )
			            )
			        );
				$objPHPExcel->getActiveSheet()->getStyle('A1:'.$alphas[$i].$k2)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle('A1:'.$alphas[$i].$k2)->getFont()->setName('Italic');
			$i++;
		}
		$m1 = 1;
		for($y=0;$y<$year1;$y++){
			for($m=1;$m<=12;$m++){
				$month_name1 = date("F Y", mktime(0, 0, 0, $m, 10,$year_reverse[$y]));
				$k2 = $m1+1;
				// $objPHPExcel->getActiveSheet()->getStyle('A'.$k2)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR)->getStartColor()->setRGB('FFFFFF');
				$objPHPExcel->getActiveSheet()->getStyle('A'.$k2)->getFont()->getColor()->setRGB('2f323e');
				$objPHPExcel->getActiveSheet()->SetCellValue('A'.$k2, $month_name1);
				$m1++;
			}
		}
		$filename = "Bouns_report.xls";
        header("Content-Type: application/vnd.ms-excel");
		header('Content-Disposition: attachment;filename="'.$filename.'"');
		header('Cache-Control: max-age=0');
        $writer = new Xlsx($spreadsheet);
		$writer->save('php://output');

		/* header('Content-Type: application/vnd.ms-excel'); 
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');   
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');  
        $objWriter->save('php://output');	 */
	}

	public function candidates_excel(){
		// $this->load->library('exportexcel');
	    // $objPHPExcel = new PHPExcel();
	    $spreadsheet = new Spreadsheet();
		$objPHPExcel = $spreadsheet; 
		$objPHPExcel->createSheet()->setTitle('Hr Round');
		$objPHPExcel->createSheet()->setTitle('Technical Round');
		$objPHPExcel->createSheet()->setTitle('Final Round');
		$objPHPExcel->setActiveSheetIndex(0)->setTitle('Candidate Detail');

		$designation_list = $this->Designation_Model->get_designation();
		$alphas = $this->myRange('ZZ');
		$designation = $this->uri->getSegment(3);
		$candidates = $this->Candidate_Model->candidates_by_designation($designation);
		$candidates1 = $this->Candidate_Model->get_exxel_data($designation);
		if(!empty($candidates1)){
			// $employee_detail = $this->Candidate_Model->get_candidates_all();
			for($i = 0; $i < 4; $i++){
				$objPHPExcel->setActiveSheetIndex($i);
				$objPHPExcel->getActiveSheet()->getStyle('A1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR)->getStartColor()->setRGB('2f323e');
				$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
				$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true)->setSize(12)->getColor()->setRGB('FFFFFF');
				// $e=count($candidates);
			}
			$k = $n = $s = $r = 0;
			foreach($candidates[0] as $key => $c){
				$objPHPExcel->setActiveSheetIndex(0);
				if($key != 'feedback' && $key != 'created_date' && $key != 'updated_date' && $key != 'id'){
					$objPHPExcel->getActiveSheet()->getStyle('A1:'.$alphas[$k].'1')->getAlignment()->setWrapText(true);
					$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$k])->setAutoSize(true);
					$objPHPExcel->getActiveSheet()->getStyle($alphas[$k].'1')->getFont()->setBold(true)->setSize(12)->getColor()->setRGB('FFFFFF');
					$objPHPExcel->getActiveSheet()->getStyle($alphas[$k].'1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR)->getStartColor()->setRGB('2f323e');
					$objPHPExcel->getActiveSheet()->SetCellValue($alphas[$k].'1', ucwords(str_replace('_',' ',$key)));
					$k++;
				}
			}
			$N = 2;
			foreach($candidates as $key => $c){
				$k1 = 0;
				foreach($c as $k => $c_v){
					if($k != 'feedback' && $k != 'created_date' && $k != 'updated_date' && $k != 'id'){
						$objPHPExcel->setActiveSheetIndex(0);
						if($k == 'experience'){
							$c_v = $this->allfunction->get_month_year($c_v);
						}
						if($k == 'designation'){
							foreach ($designation_list as $value){if($value->id == $c_v){ $c_v = ucwords($value->name); } }
						}elseif($k == 'upload_resume'){
							if($c_v != ''){
								$url = base_url().'assets/candidates_upload_resume/';
								$c_v = $url.$c_v;
							}
						}
						$objPHPExcel->getActiveSheet()->SetCellValue($alphas[$k1].$N, $c_v);
						$k1++;
					}
				}
				$N++;
			}

			foreach($candidates1[0] as $key => $c){
				if($key == 'name' || $key == 'designation' || $key == 'experience' || $key == 'interview_date' || $key == 'interview_status' || $key == 'hr_skill' || $key == 'hr_feedback'){
					$objPHPExcel->setActiveSheetIndex(1);
					$objPHPExcel->getActiveSheet()->getStyle('A1:'.$alphas[$n].'1')->getAlignment()->setWrapText(true);
					$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$n])->setAutoSize(true);
					$objPHPExcel->getActiveSheet()->getStyle($alphas[$n].'1')->getFont()->setBold(true)->setSize(12)->getColor()->setRGB('FFFFFF');
					$objPHPExcel->getActiveSheet()->getStyle($alphas[$n].'1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR)->getStartColor()->setRGB('2f323e');
					if($key == 'hr_skill'){
						$key = 'Skill';
					}
					$objPHPExcel->getActiveSheet()->SetCellValue($alphas[$n].'1', ucwords(str_replace('_',' ',$key)));
					$n++;
				}
				if($key == 'name' || $key == 'designation' || $key == 'experience' || $key == 'technical_skill' || $key == 'technical_feedback' || $key == 'taken_by'){
					$objPHPExcel->setActiveSheetIndex(2);
					$objPHPExcel->getActiveSheet()->getStyle('A1:'.$alphas[$s].'1')->getAlignment()->setWrapText(true);
					$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$s])->setAutoSize(true);
					$objPHPExcel->getActiveSheet()->getStyle($alphas[$s].'1')->getFont()->setBold(true)->setSize(12)->getColor()->setRGB('FFFFFF');
					$objPHPExcel->getActiveSheet()->getStyle($alphas[$s].'1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR)->getStartColor()->setRGB('2f323e');
					if($key == 'technical_skill'){
						$key = 'Skill';
					}
					$objPHPExcel->getActiveSheet()->SetCellValue($alphas[$s].'1', ucwords(str_replace('_',' ',$key)));
					$s++;
				}
				if($key == 'name' || $key == 'designation' || $key == 'experience' || $key == 'salary' || $key == 'joining_date' || $key == 'employee_status' || $key == 'traning_period' || $key == 'remark' || $key == 'status'){
					$objPHPExcel->setActiveSheetIndex(3);
					$objPHPExcel->getActiveSheet()->getStyle('A1:'.$alphas[$r].'1')->getAlignment()->setWrapText(true);
					$objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$r])->setAutoSize(true);
					$objPHPExcel->getActiveSheet()->getStyle($alphas[$r].'1')->getFont()->setBold(true)->setSize(12)->getColor()->setRGB('FFFFFF');
					$objPHPExcel->getActiveSheet()->getStyle($alphas[$r].'1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR)->getStartColor()->setRGB('2f323e');
					$objPHPExcel->getActiveSheet()->SetCellValue($alphas[$r].'1', ucwords(str_replace('_',' ',$key)));
					$r++;
				}
				$A = 2;
			}


			foreach($candidates1 as $key1 => $c){
				$k1 = $n = $s = $r = $num = 0;
				foreach($c as $k => $c_v){
					if($k == 'experience'){
						$exp = $this->allfunction->get_month_year($c_v);
						$c_v = $exp;
					}
					if($k == 'designation'){
						foreach ($designation_list as $value){if($value->id == $c_v){ $c_v = ucwords($value->name); } }
					}
					if($k == 'name' || $k == 'designation' || $k == 'experience' || $k == 'interview_date' || $k == 'interview_status' || $k == 'hr_skill' || $k == 'hr_feedback'){
						$objPHPExcel->setActiveSheetIndex(1);
						if($k == 'hr_skill'){
							if($c_v){
								$skills = '';
								foreach(unserialize($c_v) as $i => $v){
									if($v == ''){$v = 0;}
									$skills .= ucwords(str_replace('_',' ',$i)).' : '.$v.', ';
								}
								$c_v = $skills;
							}
						}
						if($k == 'interview_date'){
							if($c_v == '0000-00-00'){
								$c_v = '';
							}else{
								$c_v = dateFormat($c_v);
							}
						}
						$objPHPExcel->getActiveSheet()->SetCellValue($alphas[$n].$A, $c_v);
						$n++;
					}
					if($k == 'name' || $k == 'designation' || $k == 'experience' || $k == 'technical_skill' || $k == 'technical_feedback' || $k == 'taken_by'){
						$objPHPExcel->setActiveSheetIndex(2);
						if($k == 'technical_skill'){
							if($c_v){
								$skills = '';
								foreach(unserialize($c_v) as $i => $v){
									if($v == ''){$v = 0;}
									$skills .= ucwords(str_replace('_',' ',$i)).' : '.$v.', ';
								}
								$c_v = $skills;
							}
						}
						$objPHPExcel->getActiveSheet()->SetCellValue($alphas[$s].$A, $c_v);
						$s++;
					}
					if($k == 'name' || $k == 'designation' || $k == 'experience' || $k == 'salary' || $k == 'joining_date' || $k == 'employee_status' || $k == 'traning_period' || $k == 'remark' || $k == 'status'){
						$objPHPExcel->setActiveSheetIndex(3);
						if($k == 'traning_period'){
							$c_v = $this->allfunction->get_month_year($c_v);
						}elseif($k == 'joining_date'){
							if($c_v == '0000-00-00'){
								$c_v = '';
							}else{
								$c_v = dateFormat($c_v);
							}
						}
						if($c_v == ''){
							$num++;
						}
						if($num >= 2){
							if($k == 'employee_status' || $k == 'status' || $k == 'traning_period'){
								$c_v = '';
							}
						}
						$objPHPExcel->getActiveSheet()->SetCellValue($alphas[$r].$A, $c_v);
						$r++;
					}
				}
				$A++;
			}
			// $objPHPExcel->setActiveSheetIndex(1);
			
			// echo '<pre>'; print_r($candidates); exit;
			$filename = "Candidates.xls";
			header("Content-Type: application/vnd.ms-excel");
			header('Content-Disposition: attachment;filename="'.$filename.'"');
			header('Cache-Control: max-age=0');
			$writer = new Xlsx($spreadsheet);
			$writer->save('php://output');
			/* header('Content-Type: application/vnd.ms-excel'); 
			header('Content-Disposition: attachment;filename="'.$filename.'"');
			header('Cache-Control: max-age=0');   
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');  
			$objWriter->save('php://output'); */
		}else{
			return redirect()->to(base_url('candidates'));
		}
	}

	public function employeeDetail_excel(){
		$spreadsheet = new Spreadsheet();
	    $objPHPExcel = $spreadsheet;
		$objPHPExcel->setActiveSheetIndex(0);
		$alphas = $this->myRange('ZZ');
		$employee_detail = $this->Employee_Model->get_employee_list(1);		
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN)->getColor()->setRGB('DDDDDD');
		$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'No');
		$objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Name');
		$objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Joining Date');
		// $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Age');
		// $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Phone Number');
		$objPHPExcel->getActiveSheet()->getStyle('A1:C1')->getFont()->setBold(true)->setSize(12)->getColor()->setRGB('FFFFFF');
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
		// $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
		// $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
		$i=1;
		$objPHPExcel->getActiveSheet()->getStyle('A1:C1')->getAlignment()->setWrapText(true);
	 	foreach($employee_detail as $key => $value){
			 if($value->joining_date != '0000-00-00' && $value->joining_date != ''){
				 $today = new DateTime(date("Y-m-d"));
				 $diff = $today->diff(new DateTime(Format_date($value->joining_date)));
				 if($diff->y >= 1){
					 $is = $i+1;
					  $objPHPExcel->getActiveSheet()->getStyle('A1:C1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR)->getStartColor()->setRGB('2f323e');
					 $objPHPExcel->getActiveSheet()->getStyle('A1:C1')->getFont()->setBold(true)->setSize(12)->getColor()->setRGB('FFFFFF');
					 $objPHPExcel->getActiveSheet()->getColumnDimension($alphas[$key])->setWidth(15);
					// $diff = $today->diff(new DateTime(Format_date($value->date_of_birth)));
					// $diff = date_diff(Format_date($value->date_of_birth), Format_date($today));
					 $fullname = $value->fname.' '.$value->lname;
					 $objPHPExcel->getActiveSheet()->SetCellValue('A'.$is, $i);
					 $objPHPExcel->getActiveSheet()->SetCellValue('B'.$is, $fullname);
					 $objPHPExcel->getActiveSheet()->SetCellValue('C'.$is, $value->joining_date);
					//  $objPHPExcel->getActiveSheet()->SetCellValue('D'.$is, $diff->y.' Years');
					//  $objPHPExcel->getActiveSheet()->SetCellValue('E'.$is, $value->phone_number);
					
					$i++;
				 }
			 }
		}
		$filename = "employeeDetail.xls";
        header("Content-Type: application/vnd.ms-excel");
		header('Content-Disposition: attachment;filename="'.$filename.'"');
		header('Cache-Control: max-age=0');
		$writer = new Xlsx($spreadsheet);
		$writer->save('php://output');	
	}

}