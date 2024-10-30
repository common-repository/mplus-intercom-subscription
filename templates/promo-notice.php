<?php
foreach( $notices as $notice):         
    ?>
    <div class="notice mplusis-promotional-notice">
        <div class="thumbnail">
            <img src="<?php echo esc_url( $notice['thumbnail'] ); ?>" alt="<?php echo esc_attr( $notice['title'] ); ?>">
        </div>
        <div class="content">
            <h2><?php echo esc_html( $notice['title'] ); ?></h2>
            <p><?php echo esc_html( $notice['content'] ); ?></p>
            <a href="<?php echo esc_url( $notice['action']['link'] ); ?>" class="button button-primary promo-btn"
                target="<?php echo esc_url( $notice['action']['target'] ); ?>"><?php echo ! empty( $notice['action']['text'] ) ? esc_html( $notice['action']['text'] ) : esc_html__( 'Learn More &rarr;', 'mplus-intercom-subscription' ); ?></a>
        </div>
        <?php if($notice['show_close_button']): ?>
        <span class="prmotion-close-icon dashicons dashicons-no-alt" data-key="<?php echo  $notice['key']; ?>"></span>
        <?php endif; ?>
        <div class="clear"></div>
    </div>
<?php endforeach; ?>

<!-- the support form -->
<?php add_thickbox(); ?>
<?php
$current_user = wp_get_current_user();
?>
<div id="mplusis-support-modal-notice-section" class="mplus-fieldsContainer-fieldset" style="display:none; width: 100%;">
    <form id="mplusis-support-form-notice-section" action="<?php echo admin_url('admin-ajax.php'); ?>" method="post">
        <fieldset class="mplus-fieldsContainer-fieldset">
            <div class="mplus-fieldsContainer">
                <div class="mplus-fieldsContainer-description">Name</div>
                <fieldset class="mplus-fieldsContainer-fieldset">
                    <div class="mplus-field mplus-field--text">
                        <div class="mplus-text">
                            <input type="text" id="" class="mplusis_base_settings-field" name="name" required value="<?php echo $current_user->display_name; ?>">
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="mplus-fieldsContainer">
                <div class="mplus-fieldsContainer-description">Email</div>
                <fieldset class="mplus-fieldsContainer-fieldset">
                    <div class="mplus-field mplus-field--text">
                        <div class="mplus-text">
                            <input type="email" id="" class="mplusis_base_settings-field" name="email" required value="<?php echo $current_user->user_email; ?>">
                        </div>
                    </div>
                </fieldset>
            </div>
            <div id="" class="mplus-fieldsContainer">
                <div class="mplus-fieldsContainer-description">Message</div>
                <fieldset class="mplus-fieldsContainer-fieldset">
                    <div class="mplus-field mplus-field--text">
                        <div class="mplus-textarea">
                            <textarea id="" name="message" rows="4" class="" required></textarea>
                        </div>
                    </div>
                </fieldset>
            </div>
            <button type="submit" class="mplus-button" style="margin-top: 1rem;">Submit</button>
        </fieldset>
        <input type="hidden" name="promo_key" id="mplusis_promo_key">
    </form>
</div>
<?php wp_enqueue_style( 'mplusis_settings_style' ); ?>
<!-- support form end -->
<style>
    .mplusis-promotional-notice {
        padding: 20px;
        box-sizing: border-box;
        position: relative;
        display: flex;
        align-items: center;
    }

    .mplusis-promotional-notice .prmotion-close-icon {
        position: absolute;
        top: 20px;
        right: 20px;
        cursor: pointer;
    }

    .mplusis-promotional-notice .thumbnail {
        width: 96px;
        height: 96px;
        float: left;
    }

    .mplusis-promotional-notice .thumbnail img {
        width: 100%;
        height: auto;
        /* box-shadow: 0px 0px 25px #bbbbbb; */
        margin-right: 20px;
        box-sizing: border-box;
    }

    .mplusis-promotional-notice .content {
        float: left;
        margin-left: 20px;
        width: 75%;
    }

    .mplusis-promotional-notice .content h2 {
        margin: 3px 0px 5px;
        font-size: 17px;
        font-weight: bold;
        color: #555;
        line-height: 25px;
    }

    .mplusis-promotional-notice .content p {
        font-size: 14px;
        text-align: justify;
        color: #666;
        margin-bottom: 10px;
    }

    .promo-btn {
        border: none;
        box-shadow: none;
        height: 31px;
        line-height: 30px !important;
        border-radius: 3px !important;
        background: #19895D !important;
        text-shadow: none !important;
        width: 140px;
        text-align: center;
    }

</style>

<script type='text/javascript'>
    jQuery(document).ready(function ($) {
        /* the promo close action */
        $('body').on('click', '.mplusis-promotional-notice span.prmotion-close-icon', function (e) {
            e.preventDefault();

            let self = $(this),
                key = self.data('key');

            $("#mplusis_promo_key").val(key);

            self.closest('.mplusis-promotional-notice').fadeOut(200);

            wp.ajax.send('mplusis-dismiss-promotional-notice', {
                data: {
                    key: key,
                    nonce: '<?php echo esc_attr( wp_create_nonce( 'mplusis_admin' ) ); ?>'
                },
            });

            window.tb_position = function() {
                var isIE6 = typeof document.body.style.maxHeight === "undefined";
                jQuery("#TB_window").css({marginLeft: '-' + parseInt((TB_WIDTH / 2),10) + 'px', width: TB_WIDTH + 'px'});
                    if ( ! isIE6 ) { // take away IE6
                        jQuery("#TB_window").css({marginTop: '-' + parseInt((TB_HEIGHT / 2),10) + 'px'});
                    }
                }

            tb_show("Send a message","#TB_inline?width=550&height=550&inlineId=mplusis-support-modal-notice-section");
        });

        /* the support form submit */
        $('#mplusis-support-form-notice-section').submit(function(e) {
            e.preventDefault();
            const me = $(this);
            const success_message = `<div class="mpl-notice">
                <div class="mpl-notice-container">
                    <div class="mpl-notice-supTitle">Thank You!</div>
                    <h2 class="mpl-notice-title">
                        Your message has been sent.			
                    </h2>
                </div>
            </div>`;
            me.waitMe({
                effect: 'ios'
            });
            // Perform AJAX request
            $.ajax({
                type: 'POST',
                url: ajaxurl,
                data: {
                    action: 'submit_mplusis_support_form',
                    formData: $(this).serialize()
                },
                dataType: 'json',
                success: function(response) {
                    // Handle success (optional)
                    $("#mplusis-support-form-notice-section").html(success_message);
                    me.waitMe('hide');
                    // You can redirect the user or show a success message here
                },
                error: function(xhr, status, error) {
                    // Handle error (optional)
                    alert('Error submitting form');
                    me.waitMe('hide');
                }
            });
        });
    });
</script>