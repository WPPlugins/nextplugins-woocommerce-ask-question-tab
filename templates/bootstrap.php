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
							message_obj.html('<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' + data.messages[0] + '</div>');
							$('#contact-form')[0].reset();
						}

						if(data.has_error == true)
						{
							var message = '';

							$.each( data.messages, function( key, value ) {
								message += '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' + value + '</div>';
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
<form id="contact-form">
	<input type="hidden" name="action" value="send_product_question">
	<input type="hidden" name="product" value="<?php echo esc_url(get_permalink( $product->id )) ?>">
	<div class="messages"></div>

	<div class="controls">
		<div class="row">
			<div class="col-md-4">
				<div class="form-group">
					<label for="form_name"><?php _e('Name', 'nextplugins-woocommerce-vat'); ?> *</label>
					<input id="form_name" type="text" name="name" class="form-control" required="required">
				</div>
			</div>
			<div class="col-md-4 hide">
				<div class="form-group">
					<label for="form_lastname"><?php _e('Lastname', 'nextplugins-woocommerce-vat'); ?></label>
					<input id="form_lastname" type="text" name="surname" class="form-control">
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label for="form_phone"><?php _e('Phone', 'nextplugins-woocommerce-vat'); ?></label>
					<input id="form_phone" type="text" name="phone" class="form-control">
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label for="form_email"><?php _e('Email', 'nextplugins-woocommerce-vat'); ?></label>
					<input id="form_email" type="email" name="email" class="form-control">
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="form-group">
					<label for="form_message"><?php _e('Message', 'nextplugins-woocommerce-vat'); ?> *</label>
					<textarea id="form_message" name="message" class="form-control" rows="4" required="required"></textarea>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-3">
				<div class="form-group">
					<input type="text" name="human" class="form-control" placeholder="* + 8 = 11" required="required">
				</div>
			</div>
			<div class="col-md-9">
				<input type="submit" class="btn le-button btn-send" value="<?php _e('Send message', 'nextplugins-woocommerce-vat'); ?>">
			</div>
		</div>
	</div>
</form>