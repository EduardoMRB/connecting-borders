<h2 class="page-title" id="page_title"><?php echo lang('user_register_header') ?></h2>
<div style="margin-left : 30px; text-align: center">
<p>
	Por gentileza, cadastre-se para que possamos enviá-lo o seu orçamento
</p>
<p>
 Caso você já tenha uma senha, faça o seu login para ter acesso as suas informações.
</p>
</div>

<?php if ( ! empty($error_string)):?>
<!-- Woops... -->
<div class="error-box">
	<?php echo $error_string;?>
</div>
<?php endif;?>

<?php echo form_open('register', array('id' => 'register')); ?>
<ul>
	
	<?php if ( ! Settings::get('auto_username')): ?>
	<li>
		<label for="username"><?php echo lang('user_username') ?></label>
		<input type="text" name="username" maxlength="100" value="<?php echo $_user->username; ?>" />
	</li>
	<?php endif; ?>
	
	<li>
		<label for="email"><?php echo lang('user_email') ?></label>
		<input type="text" name="email" maxlength="100" value="<?php echo $_user->email; ?>" />
		<?php echo form_input('d0ntf1llth1s1n', ' ', 'class="default-form" style="display:none"'); ?>
	</li>
	
	<li>
		<label for="password"><?php echo lang('user_password') ?></label>
		<input type="password" name="password" maxlength="100" />
	</li>

	<?php foreach($profile_fields as $field) { if($field['required'] and $field['field_slug'] != 'display_name') { ?>
	<li>
		<label for="<?php echo $field['field_slug']; ?>"><?php echo (lang($field['field_name'])) ? lang($field['field_name']) : $field['field_name'];  ?></label>
		<div class="input"><?php echo $field['input']; ?></div>
	</li>
	<?php } } ?>

	
	<li>
		<?php echo form_submit('btnSubmit', lang('user_register_btn')) ?>
	</li>
</ul>
<?php echo form_close(); ?>
