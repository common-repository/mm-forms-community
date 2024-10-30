<?php
	include_once('../../../../wp-config.php');
	$db1 = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
	$rv = mysql_select_db(DB_NAME, $db1);

    function quoteString($str)
    {
         $str = "'".str_replace('\\"', '"', addslashes($str))."'";
         return $str;
    }

	
	foreach ($_REQUEST as $key => $value){
		
		
		$SQL="UPDATE wp_contactform_submit_data SET value=".quoteString(mysql_real_escape_string($value))." WHERE fk_form_joiner_id='".mysql_real_escape_string($_REQUEST['ID'])."' AND form_key='".mysql_real_escape_string($key)."'";
//		echo $SQL . "<br />";
		mysql_query($SQL);
	}
	mysql_close($db1);


header("Location: ".get_option('siteurl')."/wp-admin/options-general.php?page=" . MM_FORMS_FILE . "&action=viewDetail&t=edit&id=".$_REQUEST['ID']."&form_id=".$_REQUEST['form_id']);

exit;

?>
