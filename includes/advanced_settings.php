<script type="text/javascript">
function toggle_rss_link() {
	$("#rss_link").animate({"height": "toggle"}, { duration: 0 });
}
</script>
<h3>Data handling</h3>	
<div>
	<table>
		<?php $checked = ($cf['mail']['save_data'] == "1" || $cf['mail']['save_data'] == "") ? 'checked="checked"' : "" ?>
		<tr>
			<td width="250">Save to database and email notification</td>
			<td><input type="radio" id="mmf-save_data" name="mmf-save_data" value="1" <?php echo $checked?> /></td>
		</tr>
		<?php $checked = ($cf['mail']['save_data'] == "0") ? 'checked="checked"' : "" ?>
		<tr>
			<td>Email notification only</td>
			<td><input type="radio" id="mmf-send_mail" name="mmf-save_data" <?php echo $checked?> value="0" /></td>
		</tr>
		<?php $checked = ($cf['mail']['save_data'] == "2") ? 'checked="checked"' : "" ?>
		<tr>
			<td>Save to database only</td>
			<td><input type="radio" id="mmf-onlysave_data" name="mmf-save_data" <?php echo $checked?> value="2" /></td>
		</tr>
	</table>
</div>

<h3>Configure CSV export</h3>

<div style="margin-top:20px;">
	<table>
		<tr>
			<td valign="top" width="250">Column names</td>
			<td><input type="text" id="mmf-form_fields" name="mmf-form_fields" value="<?php echo htmlspecialchars($cf['form_fields']); ?>" size="50" /><br />
			<span style="font:Verdana, Arial, Helvetica, sans-serif; font-size:10px; font-weight:250; color:#999999;">(Example : name, subject, email)</span>
			</td>
		</tr>
		<tr>
			<td>Export all fields</td>
			<td>
				<?php $checked = ($cf['all_form_fields'] ? 'checked="checked"' : "") ?>
			     <input style="width:12px;" type="checkbox" id="mmf-all_form_fields" name="mmf-all_form_fields" <?php echo $checked?> onclick=" if(document.getElementById('mmf-all_form_fields').checked == 1) document.getElementById('mmf-form_fields').value=''"  />
			</td>
		</tr>
		<tr>
			<td>Field separator</td>
			<td>
				<input type="text" id="mmf-csv_separator" name="mmf-csv_separator" value="<?php echo htmlspecialchars($cf['csv_separator']); ?>" size="1" maxlength="1" />
			</td>
		</tr>
		<tr>
			<td>Export more information</td>
			<td>
				<?php $checked = ($cf['export_form_ids'] == "1" ? 'checked="checked"' : "") ?>
				<input style="width:12px;" type="checkbox" id="mmf-export_form_ids" name="mmf-export_form_ids" <?php echo $checked?> size="12" value="1"  /><br />
				<span style="font:Verdana, Arial, Helvetica, sans-serif; font-size:10px; font-weight:250; color:#999999;">Exports submit ID, submit date, client IP, referer.</span>
			</td>
		</tr>
	</table>			
</div>

<h3>RSS feed of submissions</h3>
<div style="margin-top:20px;">
	<table>
		<tr>
			<td valign="top" width="250"><?php _e('Enable RSS Feed','mm-forms'); ?></td>
			<td>
				<?php $checked = ($cf['rss_feed'] == "1" ? 'checked="checked"' : "") ?>
				<input style="width:12px;" type="checkbox" id="mmf-rss_feed" name="mmf-rss_feed" <?php echo $checked?> size="12" value="1" onclick="toggle_rss_link();" />
				<div id="rss_link" style="float:right;margin-left:10px;display:none">
					<?php _e('RSS link: ','mm-forms'); ?><?php echo get_option('siteurl').'/?action=rss&form_id='.$_REQUEST['contactform']; ?>
				</div>
				<?php
					if ($cf['rss_feed'] == 1) {
						?>
							<script type='text/javascript'>
								$("#rss_link").animate({"height": "show"}, { duration: 0 });
							</script>
						<?php
					}
				?>
				
			</td>
		</tr>
	</table>
</div>

<h3>More meta information</h3>
<div id="postmeta_settings" style="margin-top:20px;">
	<table>
		<tr>
			<td valign="top" width="250"><?php _e('Add post or page author','mm-forms'); ?></td>
			<td valign="top">
				<?php $checked_author = ($cf['mail']['mmf_add_meta_author'] == 1 ? 'checked="checked"' : "") ?>
				<input style="width:12px;" type="checkbox" id="mmf-add-meta-author" name="mmf-add-meta-author" size="12" <?php echo $checked_author ; ?> value="1" /><br /><span style="font:Verdana, Arial, Helvetica, sans-serif; font-size:10px; font-weight:250; color:#999999;">Adds post author id, name, email and url as hidden fields in the form. (Hidden field names = meta_post_author_id, meta_post_author_name, meta_post_author_email, meta_post_author_url)</span></td>
		</tr>
		<tr>
			<td valign="top"  width="250"><?php _e('Add post or page custom fields','mm-forms'); ?></td>
			<td valign="top">
				<?php $checked_customfields = ($cf['mail']['mmf_add_meta_customfields'] == 1 ? 'checked="checked"' : "") ?>
				<input style="width:12px;" type="checkbox" id="mmf-add-meta-customfields" name="mmf-add-meta-customfields" size="12" <?php echo $checked_customfields ; ?> value="1" /><br /><span style="font:Verdana, Arial, Helvetica, sans-serif; font-size:10px; font-weight:250; color:#999999;">Adds post custom fields as hidden fields in the form. (Hidden field name is constructed like this : customfield_CUSTOM_FIELD_NAME)</span></td>
		</tr>
		<tr>
			<td valign="top"  width="250"><?php _e('Add logged in user information','mm-forms'); ?></td>
			<td valign="top">
				<?php $checked_loggeduser = ($cf['mail']['mmf_add_meta_loggeduser'] == 1 ? 'checked="checked"' : "") ?>
				<input style="width:12px;" type="checkbox" id="mmf-add-meta-loggeduser" name="mmf-add-meta-loggeduser" size="12" <?php echo $checked_loggeduser ; ?> value="1" /><br /><span style="font:Verdana, Arial, Helvetica, sans-serif; font-size:10px; font-weight:250; color:#999999;">Adds the email address and name of the user that's logged in.  (Hidden field names are : loggedin_user_email, loggedin_user_name)</span></td>
		</tr>		
	</table>
</div>

<h3>Miscellaneous settings</h3>
<div style="margin-top:20px;">
   <!--maximum number of submissions-->
   <table>
	<tr>
		<td width="250">Allowed file types</td>
		<td>
			<input type="text" id="mmf-filetypes" name="mmf-filetypes" size="30"  value="<?php echo $cf['mmf_filetypes']; ?>" style="font-size:12px; width:200px;"/>
			<span style="font:Verdana, Arial, Helvetica, sans-serif; font-size:10px; font-weight:250; color:#999999;">Comma Separated like  (.gif,.doc)</span>
		</td>
	</tr>
	<tr>
		<td>Maximum file size (kb)</td>
		<td>
			<input type="text" id="mmf-maxfilesize" name="mmf-maxfilesize" size="10"  value="<?php echo $cf['mmf_maxfilesize']; ?>" style="font-size:12px; width:80px;"/>
		</td>
	</tr>
	<tr>
		<td>Maximum number of submissions</td>
		<td>
			<input type="text" id="mmf-maxsub" name="mmf-maxsub" size="10"  value="<?php echo $cf['mmf_maxsub']; ?>" style="font-size:12px; width:40px;"/>
		</td>
	</tr>
	<tr>
		<td>Form available from date</td>
		<td>
			<input type="text" id="datefrompicker" name="mmf-fromdate" size="10"  value="<?php 	echo $cf['mmf_fromdate']; ?>" style="font-size:12px; width:90px;"/>	
			<span style="font:Verdana, Arial, Helvetica, sans-serif; font-size:10px; font-weight:250; color:#999999;">(yyyy-mm-dd)	</span>
		</td>
	</tr>
	<tr>
		<td>Form available to date</td>
		<td>
			<input type="text" id="datetopicker" onchange="CompareDates();" name="mmf-todate" size="10"  value="<?php echo $cf['mmf_todate'];?>" style="font-size:12px; width:90px;" /> <span  style="font:Verdana, Arial, Helvetica, sans-serif; font-size:10px; font-weight:250; color:#999999;">
		        (yyyy-mm-dd)
		</td>
	</tr>
	<tr>
		<td>Hide form after submit</td>
		<td>
			<?php $checked = ($cf['mmf_hide_form'] == 'yes') ? "checked" : "" ;?>
	        <input type="checkbox" id="mmf-hide_form" name="mmf-hide_form" <?php echo $checked?> value="yes"  style="width:10px;"/>
		</td>
	</tr>
	<tr>
		<td>Show form available error message</td>
		<td>
			<?php $checked = ($cf['mail']['display_error'] == 'error') ? "checked" : "" ;?>
	        <input type="checkbox" id="mmf-display_error" name="mmf-display_error" <?php echo $checked?> value="error"  style="width:10px;"/>
		</td>
	</tr>
<!--	<tr>
		<td valign="top">Form available to users</td>
		<td>
			<select name="mmf-set_user_list[]" size="3" multiple="MULTIPLE" id="mmf-set_user_list" style="height:60px;">
			<?php //echo showsUserOptionsDrop($_REQUEST['contactform']);?>
			</select>
		</td>
	</tr> -->
	<tr>
		<td>Redirect URL on success</td>
		<td>
			<input type="text" id="url_success" name="mmf-url_success" size="50"  value="<?php echo $cf['mmf_url_success'];	?>" />
		</td>
	</tr>
	<tr>
		<td>Redirect URL on failure</td>
		<td>
			<input type="text" id="url_failure" name="mmf-url_failure" size="50"  value="<?php 	echo $cf['mmf_url_failure'];?>" />
		</td>
	</tr>
</table>	
</div>
<h3>List fields</h3>
<div id="list_settings" style="margin-top:20px;">
	<table>
		<tr>
			<td width="250"><?php _e('List fields','mm-forms'); ?></td>
			<td valign="top"><input type="text" id="mmf-list_fields" name="mmf-list_fields" size="50"  value="<?php echo $cf['mmf_list_fields'];?>" /><br /><span style="font:Verdana, Arial, Helvetica, sans-serif; font-size:10px; font-weight:250; color:#999999;">Comma separated list of the fields to show in the overview of the submissions.</span></td>
		</tr>
	</table>
</div>