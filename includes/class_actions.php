<?php
class actions
{
	var $view_form_columns;
	var $form_info;
	var $contact_forms;
	var $view_emails_columns;
	var $emails;
	var $form_fields;
	var $detail_info_columns;
	var $view_all;
	var $add_edit;
	var $view_emails;
	var $view_form_details;
	var $id;
	
	var $url;
	var $records_per_page;
	var $current_page;
	var $total_records;
	
	var $cvsFileData;
	var $form_id;

	function actions($action, $forms , $id, $form_id,$current_page=0,$records_per_page)
	{

		$this->form_id = $id;
		$this->id = $id;
		
		$this->records_per_page = $records_per_page;
		$this->current_page = $current_page;
		
		switch($action)
		{
			case "view":
				$this->view_emails($id);
				break;
			case "viewDetail":
				$this->view_email_detail($id);
				break;
			case "deletemail":
				$this->delete_email($id);
				$this->view_emails($form_id);
				$this->view_emails = true;
				break;
			case "deleteAllEmails":
				$this->delete_all_emails($id);
				$this->view_emails($form_id);
				$this->view_emails = true;
				break;				
			case "deleteselection":
				$this->delete_selection($id);
				$this->view_emails($form_id);
				$this->view_emails = true;
				break;				
			case "deleteform":
				$this->delete_contactform($id);
				$this->view_all_forms($forms);
				break;
			case "export":
				$this->export_to_csv($id);
				break;				
			default:
				$this->view_all_forms($forms);
				break;				
		}
	}
	//deleting form from the table
	function delete_contactform($id)
	{
		global $wpdb;

		$wpdb->query("delete from ".$wpdb->prefix . 'contactform'." where form_id = '$id'");
		
		$sql = "select distinct(id) from ".$wpdb->prefix . 'contactform_submit'." where fk_form_id = '$id'";
		$res = $wpdb->get_results($sql);
	
		foreach ($res as $r) {
			$joiner_id = $r->id ;
			$wpdb->query("delete from ".$wpdb->prefix . "contactform_submit_data where fk_form_joiner_id = '" . $joiner_id . "'");
		}
		
		$wpdb->query("delete from ".$wpdb->prefix . 'contactform_submit'." where fk_form_id = '$id'");

	}
	function view_all_forms($forms)
	{
       // echo "<br> view_all_forms";
		$this->contact_forms = $forms;
		$this->view_form_columns = array(
		"form_name" =>   "Form Name",
		"form_id"   =>   "Form Tag",
		"view"      =>   "View",
		"Edit"      =>   "Edit",
		"Export"    =>   "Export",
		"Download"  =>   "Download",
		"Delete"    =>   "Delete");	
		if($forms)
		{
			foreach($forms as $form_id=>$form)
			{
				$this->form_info[$form_id] = array(
				'num_of_emails' => $this->get_num_of_emails($form_id),
				'num_of_unread_emails' => $this->get_unread_emails($form_id),
				'formFields' => $this->userformFields($form_id));				
			}
		}
		$this->view_all = true;	
	}
	function get_num_of_emails($form_id)
	{
		global $wpdb;
		$sql = "SELECT count(*) as num_of_emails FROM " . $wpdb->prefix."contactform_submit" . " where fk_form_id = '".$form_id."' limit 1 ";
		return $num_of_emails = $wpdb->get_var($sql);
		
	}
	function get_unread_emails($form_id)
	{
		global $wpdb;
		$sql = "SELECT count(*) as unread_emails FROM " . $wpdb->prefix."contactform_submit" . " where fk_form_id = '".$form_id."' and read_flag = 0 limit 1 ";
		return $num_of_unread_emails = $wpdb->get_var($sql);		
	}
	
	function view_emails($id)
	{
            global $wpdb,$mmf;
			$current_page = $this->current_page;
			if($current_page==1){
					$offset = 0;
			}
			else{
					$current_page = $current_page-1;
					$offset = ($current_page) * 50;
			}
   
			$limit = " LIMIT $offset,50";
		   $xyz = $mmf->contact_forms;
		   $list_fields = explode(',',$xyz[$id]['mail']['mmf_list_fields']);

		
			$sql = "SELECT fk_form_id, submit_date, id, client_ip, request_url, read_flag FROM " . $wpdb->prefix."contactform_submit" . " where fk_form_id = '".$id."' order by submit_date DESC $limit";
		   
			$this->emails = $wpdb->get_results($sql);       
		
			if ($xyz[$id]['mail']['mmf_list_fields']) {
				$this->view_emails_columns = array(
				"submit_date" => "Submit Date");
			} else {
				$this->view_emails_columns = array(
				"submit_date" => "Submit Date",
				"client_ip"   => "Client IP",
				"request_url" => "Request URL");
			}
			$this->view_emails = true;
			
			$this->total_records = count($wpdb->get_results("SELECT fk_form_id, submit_date, id, client_ip, request_url, read_flag FROM " . $wpdb->prefix."contactform_submit" . " where fk_form_id = '".$id."' order by submit_date DESC"));
		   
			return $this->emails;

	}
	
	function view_email_detail($id)
	{
		global $wpdb;
		$sql = "SELECT form_key, value FROM " . $wpdb->prefix."contactform_submit_data" . " where fk_form_joiner_id = '".$id."' ";
		$this->form_fields = $wpdb->get_results($sql);
		
		$this->detail_info_columns = array(
		"form_field"  =>  "Form Fields",
		"form_value"  =>  "Values");			
		
		$this->update_email_status($id);
		$this->view_form_details = true;
	}
	
	function update_email_status($id)
	{
		global $wpdb;
		$where = array("id" => $id);
		$values_contactform_submit['read_flag'] = 1;
		
		$where = array("id" => $id);
		$wpdb->update($wpdb->prefix."contactform_submit",$values_contactform_submit,$where);
	}
	
	function delete_email($id)
	{
		global $wpdb;
		$wpdb->query("delete from ".$wpdb->prefix . 'contactform_submit'." where id = '$id'");
		$wpdb->query("delete from ".$wpdb->prefix . 'contactform_submit_data'." where fk_form_joiner_id = '$id'");		
	}
	
	function delete_all_emails($id)
	{
		global $wpdb;
		$all_emails = $this->view_emails($id);
		foreach($all_emails as $key=>$mail)
		{
			$this->delete_email($mail->id);
		}
	}
	
	function delete_selection($id) {
		global $wpdb;
		foreach ($_REQUEST as $key => $value) {
			if (substr_count($key,'checkall_') == 1) {
				$del_id = substr($key, 9);
				$this->delete_email($del_id);
			}
		}
	}
	
	function get_pagination($current=1, $records_per_page=4)
	{
		$total_records = $this->total_records;
		$rec_per_page = 50;
		
		if (!$this->id) {
			$the_Id = $_GET['id'];
		} else {
			$the_Id = $this->id;
		}
		$no_of_pages = ceil((int)$total_records/(int)$rec_per_page);
		
		$current = $this->current_page;
		
		$str = '<th>Showing '.$current.' of '.$no_of_pages.'</th>';
		
		$base_url  = get_option('siteurl'). '?page=' . MM_FORMS_FILE . '&action=view&id=' . $this->id;
		
		$url = $this->url.'?page=' . MM_FORMS_FILE . '&action=view&id=' . $the_Id.'&rec_per_pg='.$rec_per_page;
		
		$previous_page = $current - 1;
		
		if($previous_page < 1){
			$str .= '<th>Previous</th>';
		}
		else{
			
			$url_previous = $url.'&pg='.$previous_page;
			$str .= '<th><a href="'.$url_previous.'">Prev</a></th>';
		}		
		
		if($current >= $no_of_pages){
			$str .= '<th>Next</th>';
		}
		else{
			$next_page = $current + 1;
			$url_next = $url.'&pg='.$next_page;
			$str .= '<th><a href="'.$url_next.'">Next</a></th>';
		}
		
		return $str;
	}
	
	function getFormName($formId) {
		global $wpdb;
		$sql = "SELECT form_name FROM " . $wpdb->prefix."contactform WHERE form_id = '$formId'";
		
		$r = $wpdb->get_row($sql);
		return sanitize_file_name($r->form_name);
	}

	function formFields($form_id){
		global $wpdb;
		$sql = "SELECT form_fields, csv_separator FROM " . $wpdb->prefix."contactform" . " WHERE form_id = '$form_id'";
        $frm_data = $wpdb->get_row($sql);
        $export_field = $frm_data->form_fields;
        $csv_separator = $frm_data->csv_separator;
    
    	if($export_field == "") {
			$sql = "SELECT distinct(sd.form_key) FROM " . $wpdb->prefix."contactform_submit s ";
			$sql .= "LEFT JOIN " . $wpdb->prefix."contactform_submit_data AS sd ON s.id = sd.fk_form_joiner_id ";
			$sql .= "WHERE	fk_form_id = " . $form_id ;

           $arr = $wpdb->get_results($sql);
           $exportFields = array();
			foreach($arr  as $entry){
                //$export_field .= $csv_separator.$entry->form_key;
					
				if (!in_array($entry->form_key, $exportFields)) {
					array_push($exportFields,$entry->form_key);					
				}
            }
			$export_field = implode($csv_separator, $exportFields);
        }
		return $export_field;
	}
	
	function userformFields($form_id) {
			global $wpdb;
			$sql = "SELECT form_fields FROM " . $wpdb->prefix."contactform" . " WHERE form_id = '$form_id'";
	        $frm_data = $wpdb->get_row($sql);
	        $export_fields = $frm_data->form_fields;
			return $export_fields;
	}
	
	function export_to_csv($form_id) {
        global $wpdb;

		$sql = "SELECT form_fields, csv_separator, export_form_ids FROM " . $wpdb->prefix."contactform" . " WHERE form_id = '$form_id'";
    	$frm_data = $wpdb->get_row($sql);
    	$csv_separator = $frm_data->csv_separator;
        $export_form_ids = $frm_data->export_form_ids;
		
		//IMPORTANT CHANGE: select fields only once for whole export, they should be the same for every row anyway.
		$fields = $this->formFields($form_id);
		
		setlocale(LC_CTYPE, 'en_US');
		$file_name = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $this->getFormName($form_id)) . ".csv"; //Transliterates special characters in file name, example: едц.csv => aao.csv

		$file_path = MM_FORMS_PATH . 'exports/' . $file_name; //Consider replacing ABSPATH . PLUGINDIR with better alternative
		$fh = fopen($file_path, 'w');
		fwrite($fh, pack("CCC", 0xef, 0xbb, 0xbf)); //UTF8 BOM, needed by for example MS Excel to recognize UTF8

		//File headers
		$export_fields = '';
        if ($export_form_ids) {
            $export_fields = 'id' . $csv_separator . 'submit_date' . $csv_separator . 'referer' . $csv_separator . 'client_ip' . $csv_separator;
        }
		$export_fields .= $fields . "\n";
		
		fwrite($fh, $export_fields); //Write headers to file

		$fields = explode($csv_separator, $fields); //Transform fields to array
		$form_id = $wpdb->escape($form_id); //You can never be safe enough
		
		// get all contactform_submit records
		//IMPORTANT CHANGE: THIS is the important change, SELECT all data in one query instead of doing thousands of requests to the database.
		$query = sprintf('SELECT *, %1$scontactform_submit.id AS submission_id
		FROM %1$scontactform_submit, %1$scontactform_submit_data
WHERE %1$scontactform_submit_data.fk_form_joiner_id = %1$scontactform_submit.id
AND fk_form_id = "%2$s"
ORDER BY %1$scontactform_submit.id ASC;', $wpdb->prefix, $form_id);

		$submission_data = array();
		$last_submission = -1;
        $result = mysql_query($query);
		while($data = mysql_fetch_assoc($result))
		{
			//If we encounter new submission
			if($last_submission != $data['submission_id']) {
			
				//Write last submission to file
				if($last_submission !== -1) { //Don't write an empty line at the beginning
					fwrite($fh, $this->export_data_to_line($submission_data, $fields, $csv_separator, $export_form_ids)); //Write previous submission to file
				}
				
				//Prepare new submission
				$submission_data = array();
				$submission_data['id'] = $data['submission_id'];
				$submission_data['referer'] = $data['request_url'];
				$submission_data['submit_date'] = $data['submit_date'];
				$submission_data['client_ip'] = $data['client_ip'];
			}

			//Add the current key-value pair to the current submission set
            $submission_data[$data['form_key']] = $data['value'] ;

			//Which submission did we just do?
			$last_submission = $data['submission_id'];
		}
		
		//IMPORTANT CHANGE: Write every line of the export individually, this we increase performance by reading and writing at the "same time" (disk cache, etc.) instead of first processing all data and writing in bulk.
		fwrite($fh, $this->export_data_to_line($submission_data, $fields, $csv_separator, $export_form_ids)); //Write the last submission to file
		
		fclose($fh);
		return plugins_url('exports/' . $file_name, dirname(__FILE__));
    }
	
	//This function is only to prevent code repetition
	function export_data_to_line($data, $fields, $csv_separator, $export_form_ids) {
		$row = '';
					
		if($export_form_ids) {
			$row .= '"' . $data['id'] . '"' . $csv_separator . '"' . $data['submit_date'] . '"' . $csv_separator . '"' . $data['referer'] . '"' . $csv_separator . '"' . $data['client_ip'] . '"' . $csv_separator;
		}
		
		for ( $i = 0 ; $i < count($fields) ; $i++) {
			$row .= '"' . str_replace(array('"', "\n", "\r"), array('""', '\n', '\r'), stripslashes($data[$fields[$i]])) . '"' . $csv_separator ;
		}

		return substr($row, 0, -1) . "\n";
	}
}

?>
