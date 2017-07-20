<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
global $product;
?>
<script type="text/javascript">
	jQuery(function ($) {
		$('#contact-form').on('submit', function (e) {
			if (!e.isDefaultPrevented()) {
				var url = "<?php echo esc_url( admin_url( 'admin-ajax.php' )) ?>";
				var message_obj = $('#contact-form').find('.messages');
				message_obj.empty();

				$.ajax({
					type: "POST",
					dataType: "json",
					url: url,
					data: $(this).serialize(),
					success: function (data)
					{
						if(data.has_error == false)
						{
							message_obj.html('<div class="alert-success">' + data.messages[0] + '</div>');
							$('#contact-form')[0].reset();
						}

						if(data.has_error == true)
						{
							var message = '';

							$.each( data.messages, function( key, value ) {
								message += '<div class="alert-danger">' + value + '</div>';
							});

							message_obj.html(message);
						}
					}
				});
				return false;
			}
		})
	});
</script>
<style>
	div.alert-success {
		color: white;
		background-color: #0f834d;
		margin: 0 0 8px 0;
		padding: 5px;
		border-radius: 4px;
	}
	div.alert-danger {
		color: white;
		background-color: #bc0b0b;
		margin: 0 0 8px 0;
		padding: 5px;
		border-radius: 4px;
	}
</style>
<form id="contact-form">
	<input type="hidden" name="action" value="send_product_question">
	<input type="hidden" name="product" value="<?php echo esc_url(get_permalink( $product->id )) ?>">
	<div class="messages"></div>

	<div class="form">
		<label for="form_name"><?php _e('Name', 'nextplugins-woocommerce-vat'); ?> *</label>
		<input id="form_name" type="text" name="name" required="required">

		<div style="display: none !important;"> <?php //simple bot protection ?>
		<label for="form_lastname"><?php _e('Lastname', 'nextplugins-woocommerce-vat'); ?></label>
		<input id="form_lastname" type="text" name="surname">
		</div>

		<label for="form_phone"><?php _e('Phone', 'nextplugins-woocommerce-vat'); ?></label>
		<input id="form_phone" type="text" name="phone">

		<label for="form_email"><?php _e('Email', 'nextplugins-woocommerce-vat'); ?></label>
		<input id="form_email" type="email" name="email">

		<label for="form_message"><?php _e('Message', 'nextplugins-woocommerce-vat'); ?> *</label>
		<textarea id="form_message" name="message" rows="4" required="required"></textarea>
		<br>
		<input type="text" name="human" placeholder="* + 8 = 11" required="required">
		<br>
		<p class="form-submit"><input type="submit" class="submit" value="<?php _e('Send message', 'nextplugins-woocommerce-vat'); ?>"></p>
	</div>
</form>