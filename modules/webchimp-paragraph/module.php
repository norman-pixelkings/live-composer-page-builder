<?php

/**
 * Plugin Name: Webchimp paragraph
 * Description: A simple paragraph components
 * Version: 1.0
 */

if ( defined( 'DS_LIVE_COMPOSER_URL' ) ) {

	add_action('dslc_hook_register_modules',
		create_function('', 'return dslc_register_module( "webchimp_paragraph_module" );')
	);

	class webchimp_paragraph_module extends DSLC_Module {

		// Module Attributes
		var $module_id = 'webchimp_paragraph_module';
		var $module_title = 'Webchimp Paragraph';
		var $module_icon = 'circle';
		var $module_category = 'Webchimp';

		// Module Options
		function options() {

			// The options array
			$options = array(

				// A simple text input option
				array(
					'label' => __( 'Content', 'live-composer-page-builder' ),
					'id' => 'content',
					'std' => 'This is just placeholder text. Hover over the module and click "Edit Content" to change it.',
					'type' => 'textarea',
					'visibility' => 'hidden',
					'section' => 'styling',
				),
				// title of the paragraph
				array(
					'label' => __( 'Titel', 'live-composer-page-builder' ),
					'id' => 'title',
					'std' => 'Curabitur dignissim',
					'type' => 'text'
				),
				// images
				array(
					'label' => __( 'Image - Filesss', 'live-composer-page-builder' ),
					'id' => 'image',
					'std' => '',
					'type' => 'image',
					'section' => 'functionality',
				),

				// styling options
				array(
					'label' => __( 'Gestapeld op mobiel', 'live-composer-page-builder' ),
					'id' => 'paragraph_stack_on_mobile',
					'std' => '1',
					'type' => 'radio',
					'section' => 'styling',
					'choices' => array(
						array(
							'label' => 'Gestapeld',
							'value' => '1'
						),
						array(
							'label' => 'Naast elkaar',
							'value' => '0'
						)
					)
				),
				array(
					'label' => __( 'Paragraaf style', 'live-composer-page-builder' ),
					'id' => 'paragraph_style',
					'std' => 'default',
					'type' => 'radio',
					'section' => 'styling',
					'choices' => array(
						array(
							'label' => 'Standaard',
							'value' => 'default'
						),
						array(
							'label' => 'Variant 1',
							'value' => 'wc-paragraph--style1'
						),
						array(
							'label' => 'Variant 1',
							'value' => 'wc-paragraph--style2'
						)
					)
				),
				array(
					'label' => __( 'Verticale uitlijning', 'live-composer-page-builder' ),
					'id' => 'paragraph_align_self',
					'std' => '',
					'type' => 'radio',
					'section' => 'styling',
					'choices' => array(
						array(
							'label' => 'Standaard',
							'value' => ''
						),
						array(
							'label' => 'Start',
							'value' => 'align-top'
						),
						array(
							'label' => 'Einde',
							'value' => 'align-bottom'
						),
						array(
							'label' => 'Midden',
							'value' => 'align-middle'
						),
						array(
							'label' => 'Uitgerekt',
							'value' => 'align-stretch'
						)
					)
				),

				array(
					'label' => __( 'Positie afbeelding', 'live-composer-page-builder' ),
					'id' => 'paragraph_position_image',
					'std' => '',
					'type' => 'radio',
					'section' => 'styling',
					'choices' => array(
						array(
							'label' => 'Links',
							'value' => ''
						),
						array(
							'label' => 'Rechts',
							'value' => 'flex-dir-row-reverse'
						)
					)
				),

			);

			// Return the array
			return apply_filters( 'dslc_module_options', $options, $this->module_id );

		}

		// Module Output
		function output( $options ) {

			// REQUIRED
			$this->module_start( $options );

			global $dslc_active;

			if ( $dslc_active && is_user_logged_in() && current_user_can( DS_LIVE_COMPOSER_CAPABILITY ) ) {
				$dslc_is_admin = true;
			} else {
				$dslc_is_admin = false;
			}

			$image = $options['image'];
			// gestapeld op mobiel of niet?
			$paragraph_stack_on_mobile  = ($options['paragraph_stack_on_mobile'] == '1') ? '' : 'small-6';
			// verticale uitlijning
			$paragraph_align_self = $options['paragraph_align_self'];
			// position image
			$paragraph_position_image = $options['paragraph_position_image'];
			// paragraph style
			$paragraph_style = $options['paragraph_style'];
		?>

		<div class="grid-container  wc-paragraph  <?= $paragraph_style; ?>">

			<?php if ( $options['title'] != '' ) : ?>
				<h2 class="h2 text-center"><?php echo stripslashes( $options['title'] ); ?></h2>
			<?php endif; ?>

			<div class="grid-x  align-center  grid-margin-x  <?= $paragraph_position_image; ?> <?= $paragraph_align_self; ?> ">
				<div class="[ <?= $paragraph_stack_on_mobile; ?>  medium-6  large-5  xlarge-4  ] cell">

					<?php if ( $image ) : ?>
						<img src="<?php echo esc_url($image);?>">
					<?php endif; ?>

				</div>
				<div class="[ <?= $paragraph_stack_on_mobile; ?> medium-6  large-5 xlarge-4  ] cell">

					<?php if ( $dslc_is_admin ) : ?>

						<div class="dslca-editable-content inline-editor" data-type="simple" data-id="content"  >
							<?php
								$output_content = stripslashes( $options['content'] );
								echo apply_filters( 'dslc_before_render', $output_content );
							?>
						</div>
						<div class="dslca-wysiwyg-actions-edit">
							<span class="dslca-wysiwyg-actions-edit-hook">
								<?php _e( 'Open in WP Editor', 'live-composer-page-builder' ); ?>
							</span>
						</div>

					<?php else : ?>

						<?php
							$output_content = stripslashes( $options['content'] );
							echo apply_filters( 'dslc_before_render', $output_content );
						?>

					<?php endif; ?>

				</div>
			</div>

		</div>

		<?php

			// REQUIRED
			$this->module_end( $options );

		}

	}

}