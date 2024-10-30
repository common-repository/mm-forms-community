<script type="text/javascript">
var xmlhttp = false; // variable xmlhttp
//Checking whether browser is the latest version of IE i.e > IE6
try {
//If yes, create object of XMLHttpRequest
xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
//alert("You are using the latest IE browser");
} catch(e) {
//IF not latest browser i.e < IE6
//Checking if browser is a old version of IE
try {
//If yes, create object of XMLHttpRequest
xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
//alert("You are using an old version of IE browser");
} catch(e) {
//If not both, then it is a NON-IE Browser
xmlhttp=false;
}
}
//Checking if browser is a non IE browser
if(!xmlhttp && typeof XMLHttpRequest != 'undefined') {
//Creating an object of XMLHttpRequest in non-IE browsers
xmlhttp = new XMLHttpRequest();
//alert("You are using non IE Browser");
}

function ajaxRequest(scriptPage, elementID, resulturl) {
	document.getElementById(elementID).style.display = "block";
	var obj = document.getElementById(elementID);
	var title_obj = document.getElementById('Download');
	xmlhttp.open("GET", scriptPage); //Opens connection to the scriptpage using GET response method
	xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			obj.innerHTML = "<a href='" + resulturl + "'>download now</a>";
			title_obj.innerHTML = "Download CSV";
		}
	}
	xmlhttp.send(null);
}

</script>

<?php if (!$cf) : ?>
	<div class="wrap relative" style="margin-top:15px;">
	<ul id="form_tab_container">
		<li id="home_tab" class="current"><a href="<?php echo $base_url . '?page=' . $page; ?>">Home</a></li>
		<li id="new_tab"><a href="<?php echo $base_url . '?page=' . $page . '&contactform=new&tab=fo'; ?>"><?php _e('Create New form') ?></a></li>
	</ul>
	</div>
	<div style="margin-left:5px;margin-top:20px">
	<table class="widefat">
	  <thead>
	  <tr>
	<?php foreach($obj_actions->view_form_columns as $class => $column_display_name) {
		$class = ' class="'.$class.'" ';
	?>
		<th scope="col"<?php echo $class; ?> id="<?php echo $column_display_name ; ?>"><?php echo $column_display_name; ?></th>
	<?php } ?>
	  </tr>
	 </thead>
	<?php foreach ($obj_actions->contact_forms as $k => $v) : ?>
	

		<?php $class = ($obj_actions->form_info[$k]['num_of_unread_emails'] > 0) ? 'new_email' : ''; ?>
		
		<tr class="<?php echo $class ?>">
			<th style="font-weight:normal;" scope="col"><?php if ($k == $current) echo '&raquo; '; ?>
				<a href="<?php echo $base_url . '?page=' . $page . '&action=view&id=' . $k ?>"><?php echo '<b>'.$v['title'].'</b> ('.$obj_actions->form_info[$k]['num_of_unread_emails'].' New / '.$obj_actions->form_info[$k]['num_of_emails'].' Total)'; ?>
				</a> </th>
			<th style="font-weight:normal;" scope="col"><?php if ($k == $current) echo '&raquo; '; ?><?php echo '[form '.$k.' "'.$v['title'].'"]' ?></th>
			<th style="font-weight:normal;" scope="col"><?php if ($k == $current) echo '&raquo; '; ?>
				<a href="<?php echo $base_url . '?page=' . $page . '&action=view&id=' . $k ?>">
					<img src="<?php echo plugins_url('images/view.png', dirname(__FILE__) ); ?>" />
				</a></th>
				<th style="font-weight:normal;" scope="col"><?php if ($k == $current) echo '&raquo; '; ?>
					<a href="<?php echo $base_url . '?page=' . $page . '&contactform=' . $k.'&tab=fo'; ?>">
						<img src="<?php echo plugins_url('images/pencil.png', dirname(__FILE__) ); ?>" />
					</a></th>				
				<?php if($obj_actions->form_info[$k]['formFields'] || $v['all_form_fields'] ){?>

					<?php
						$url = $base_url . '?page=' . $page . '&action=export&id=' . $k ;
						setlocale(LC_CTYPE, 'en_US');
						$file_name = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', sanitize_file_name($v['title'])) . ".csv"; //Transliterates special characters in file name, example: едц.csv => aao.csv
						$file_name = plugins_url('exports/' . $file_name, dirname(__FILE__));
					?>
					<th style="font-weight:normal;" scope="col">
						<img src="<?php echo plugins_url('images/export.png', dirname(__FILE__) ); ?>" onMouseOver="this.style.cursor='pointer'" onclick="ajaxRequest('<?php echo $url ?>','ajax_result_<?php echo $k ; ?>','<?php echo $file_name ?>');" /></th>
					<th style="font-weight:normal;" scope="col">
						<div class="ajax_resultdiv" id="ajax_result_<?php echo $k ; ?>"><img src="<?php echo plugins_url( 'images/ajax-loader.gif', dirname(__FILE__) ); ?>" /></div></th>
				<?php } else { ?>
					<th style="font-weight:normal;" scope="col" colspan="2">
						<a href="<?php echo $base_url . '?page=' . $page . '&contactform=' . $k.'&tab=eo'; ?>"><?php _e("Edit export options","mm-forms"); ?></a></th>
					</th>
				<?php } ?>
			
			<th style="font-weight:normal;" scope="col"><?php if ($k == $current) echo '&raquo; '; ?>
				<a href="<?php echo $base_url . '?page=' . $page . '&action=deleteform&id=' . $k ?>">
					<img onclick="return confirm('Are you sure you want to delete this form')" src="<?php echo plugins_url('images/delete.png', dirname(__FILE__) ); ?>" />
				</a></th>	
	   </tr>
	<?php endforeach; ?>
	  </tbody>
	</table>
	<p>&nbsp;</p>

	<p><bold>Click on the icon to download the MM Forms Pro manual</bold></p>
	<p><a href="<?php echo plugins_url('manual/mm-forms_tutorial.pdf', dirname(__FILE__)); ?>"><img src="<?php echo plugins_url('images/pdf_icon.gif', dirname(__FILE__)); ?>" /></a></p>
	<p>&nbsp;</p>
		<p><button onclick="showUninstallBlock();">Uninstall MM Forms Pro</button></p>
		<div id="uninstall_block">
        <form method="post" action = "<?php echo $base_url . '?page=' . $page . '&contactform=uninstall'; ?>">
	<label for="uninstall"><?php _e('Type "Uninstall" in the box if you want to completely remove MM Forms plugin.  This includes deleting all
 your data and database tables.','mm-forms'); ?><br /></label>
                <label style="color:#fff;text-decoration:bold;">Warning : this action cannot be undone!  So please be careful when using this.</label>
				<br /><br />
            <input type="text" name="uninstall" id="uninstall"> <input type="submit" name="Uninstall" value="<?php _e("Remove MM Forms Pro"); ?>">
        </form>
		</div>
	</div>
<?php endif; ?>	
<script language="javascript">
	
	$("#uninstall_block").animate({"height": "hide"}, { duration: 0 });

	//<![CDATA[
	function showUninstallBlock(){
	$("#uninstall_block").animate({"height": "toggle"}, { duration: 1000 });
	}
	//]]>
	

	var allPageTags = new Array(); 

	var allPageTags=document.getElementsByTagName("*");
	for (i=0; i<allPageTags.length; i++) {
		if (allPageTags[i].className=="ajax_resultdiv") {
			allPageTags[i].style.display='none';
		}
	}

	$("#mmf_message").animate({"height": "hide"}, { duration: 0 });

</script>
