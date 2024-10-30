<?php
$step_two_complete =  get_option( 'mplusis_api_key' ) ? true: false;
$step_three_complete = false;
$mplusis_shortcode_rendered = get_option('mplusis_shortcode_rendered', []);
if( $mplusis_shortcode_rendered ){
    $step_three_complete = true;
}
?>
<div>
    <div class="mpl-notice">
        <div class="mpl-notice-container">
            <div class="mpl-notice-supTitle">Congratulations!</div>
            <h2 class="mpl-notice-title">
            Intercom Live chat and Lead generation is now activated and already working for you.
            <?php if( ! $step_two_complete || ! $step_three_complete ): ?>
                Please configure the plugin to generate leads.
            <?php else: ?>    
                Your website should be generating leads now!		
            <?php endif; ?>
            </h2>
            <div class="mpl-notice-description">It lets you offer a subscription form to your users to subscribe to you. Plus, it gives you extensions to extend the functionality to other plugins, like WooCommerce, Contact Forms 7, Gravity Forms and many others.</div>
        </div>
    </div>
    <div>
        <div class="mplus-optionHeader ">
            <h3 class="mplus-title2">Configuration Steps</h3>
        </div>
        <div class="mplus-fieldsContainer">
            <div class="step">
                <div class="step-icon completed">&#10003;</div>
                <div class="step-content">
                    <div class="step-heading">Activation</div>
                    <div class="step-text">
                        <?php
                            $actvation_time = get_option('mplusis_plugin_activated_at');
                        ?>
                        Activated on <?php echo date("M jS, Y", $actvation_time); ?>
                    </div>
                </div>
            </div>
            <div class="step">
                <?php
                    $access_token = get_option( 'mplusis_api_key' );
                    $step_class = $step_two_complete ? 'completed' : '';
                ?>
                <div class="step-icon <?php echo $step_class; ?>">&#10003;</div>
                <div class="step-content">
                    <div class="step-heading">Basic Configuration</div>
                    <div class="step-text">
                        <?php
                            if($access_token){
                                echo "Done.";
                            }else{
                                echo "Access token is missing. <a href='#mplusis_base_settings'>Set the access token.</a>";
                            }
                        ?>
                    </div>
                </div>
            </div>
            <div class="step">
                <?php
                    $step_class = $step_three_complete && $step_two_complete? 'completed' : '';
                ?>
                <div class="step-icon <?php echo $step_class; ?>">&#10003;</div>
                <div class="step-content">
                    <div class="step-heading">Lead creation</div>
                    <div class="step-text" id="shorcode_step">
                        <?php
                        if( ! $mplusis_shortcode_rendered || ! $step_two_complete){
                            ?>
                            No form rendered yet. 
                            <?php if($step_two_complete): ?>
                                <br>
                                <a id='create_shortcode_page' href="#" class='mplus-button' style='margin: 10px 0 0 0;'>Create a page to generate lead.</a>
                            <?php endif; ?>
                            <?php
                        }else{
                            ?>
                            Lead generation form is rendered on the following <?php echo _n('page', 'pages', count($mplusis_shortcode_rendered)); ?>: 
                            <br>
                            <?php
                            echo implode("<br>", array_map(function($url){
                                return "<a href='{$url}'>{$url}</a>";
                            },$mplusis_shortcode_rendered));
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    $addons = apply_filters( 'mplus_intercom_subscription_addon_license_tabs', array() );
    if( $addons ){
        ?>
        <div>
            <div class="mplus-optionHeader ">
                <h3 class="mplus-title2">My Account</h3>
            </div>
            <div class="mplus-fieldsContainer">
                <a class="mplus-button" style="margin-top: 1rem;" href="https://www.79mplus.com/my-account/?utm_content=intercom_my_account_link_settings_page" target="_blank">VIEW MY ACCOUNT <span class="dashicons dashicons-admin-users"></span></a>
            </div>
        </div>
        <?php
    }
    ?>
    <div>
        <div class="mplus-optionHeader ">
            <h3 class="mplus-title2">Getting Started</h3>
        </div>
        <div class="mplus-fieldsContainer-fieldset">
            <ul class="">
                <li>
                    <a class="mplus-menuItem" href="https://docs.79mplus.com/docs/intercom-subscription-base-plugin/connect-to-intercom/?utm_content=intercom_getting_started_section_settings_page" style="border-top: none;">
                        <span class="dashicons dashicons-admin-page"></span> 
                        Connect with Intercom
                    </a>
                </li>
                <li>
                    <a class="mplus-menuItem" href="https://docs.79mplus.com/docs/intercom-subscription-base-plugin/configuring/?utm_content=intercom_getting_started_section_settings_page">
                        <span class="dashicons dashicons-admin-page"></span>
                        Configuring the plugin
                    </a>
                </li>
                <li>
                    <a class="mplus-menuItem" href="https://docs.79mplus.com/docs/intercom-subscription-base-plugin/using-it-in-frontend/?utm_content=intercom_getting_started_section_settings_page">
                        <span class="dashicons dashicons-admin-page"></span>
                        Using it in Frontend
                    </a>
                </li>
                <li>
                    <a class="mplus-menuItem" href="https://docs.79mplus.com/docs/intercom-subscription-base-plugin/hooks-actions-and-filters/?utm_content=intercom_getting_started_section_settings_page">
                        <span class="dashicons dashicons-admin-page"></span>
                        Hooks: Actions and filters
                    </a>
                </li>
            </ul>
            <div class="" style="padding: 16px 44px 18px 20px;border-top: 1px solid #e0e4e9;">
                <div>
                    <h3 class="" style="font-weight: bold;">Still cannot find a solution?</h3>
                    <p class="">Submit a ticket and get help from our support center.</p>
                </div>
                <div>
                    <a name="Ask Support" class="mplus-button thickbox" style="margin-top: 1rem;" href="#TB_inline?width=600&height=550&inlineId=support-modal" target="_blank">ASK SUPPORT <span class="dashicons dashicons-email"></span></a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php add_thickbox(); ?>
<?php
$current_user = wp_get_current_user();
?>
<div id="support-modal" class="mplus-fieldsContainer-fieldset" style="display:none;">
    <form id="mplusis-support-form" action="<?php echo admin_url('admin-ajax.php'); ?>" method="post">
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
    </form>
</div>
<style>
    .step {
        display: flex;
        align-items: center;
        margin-bottom: 30px;
    }

    .step-icon {
        width: 40px;
        min-width: 40px;
        height: 40px;
        border-radius: 50%;
        background-color: #ccc;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 20px;
        font-size: 24px;
    }

    .step-icon.completed {
        background-color: #19895D; /* Green color for completed steps */
        color: white;
    }

    .step-content {
        flex-grow: 1;
    }

    .step-heading {
        font-size: 24px;
        margin-bottom: 8px;
        text-transform: uppercase;
    }

    .step-text {
        font-size: 18px;
    }
</style>
<script>
    jQuery(document).ready(function($) {
        $('#mplusis-support-form').submit(function(e) {
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
                    $("#mplusis-support-form").html(success_message);
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