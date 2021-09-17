<?php
function delay_scripts_format_list($list) {
    $list = trim($list);
    $list = $list ? array_map('trim', explode("\n", str_replace("\r", "", sanitize_textarea_field($list)))) : [];
    return $list;
}

function delay_scripts_view_settings() {

    // Update config in database after form submission
    if (isset($_POST['submit'])) {
        //$load_script = $_POST['delay_scripts_load_with'] == 'onload' ? $_POST['delay_scripts_load_with'] : $_POST['delay_scripts_timeout'];
        update_option('delay_scripts_load_with', sanitize_text_field($_POST['delay_scripts_load_with']));
        update_option('delay_scripts_timeout', sanitize_text_field($_POST['delay_scripts_timeout']));
        update_option('delay_scripts_include_list', delay_scripts_format_list($_POST['delay_scripts_include_list']));
        update_option('delay_scripts_speed_test_mode', sanitize_text_field($_POST['delay_scripts_speed_test_mode']));
        update_option('delay_scripts_disable_on_login', sanitize_text_field($_POST['delay_scripts_disable_on_login']));
        update_option('delay_scripts_disabled_pages', delay_scripts_format_list($_POST['delay_scripts_disabled_pages']));
    }

    $load_with = esc_attr(get_option('delay_scripts_load_with'));
    $timeout = get_option('delay_scripts_timeout');
    $timeout = $timeout ? esc_attr($timeout) : '4';
    
    $speed_test_mode =  esc_attr(get_option('delay_scripts_speed_test_mode'));
    $disable_on_login =  esc_attr(get_option('delay_scripts_disable_on_login'));

    $include_list = get_option('delay_scripts_include_list');
    $include_list = implode("\n", $include_list);
    $include_list = esc_textarea($include_list);

    $disabled_pages = get_option('delay_scripts_disabled_pages');
    $disabled_pages = implode("\n", $disabled_pages);
    $disabled_pages = esc_textarea($disabled_pages);

    ?>
<style>
.delay-scripts .disabled {
  color: #999;
  cursor: default;
}
.delay-scripts .disabled input {
  background:rgba(255,255,255,.5);
  border-color:rgba(220,220,222,.75);
  box-shadow:inset 0 1px 2px rgba(0,0,0,.04);
  color:rgba(44,51,56,.5);
  opacity: .7;
  cursor: default;
}
.delay-scripts #scripts-timeout {
  margin-top: 7px;
}
</style>

<form method="POST">
    <?php wp_nonce_field('delay-scripts', 'delay-scripts-settings-form'); ?>
    <table class="form-table" role="presentation">
    <tbody>
        <tr>
            <th scope="row"><label for="include-list">Include Keywords</label></th>
            <td>
                <textarea id="include-list" name="delay_scripts_include_list" rows="4" cols="50"><?php echo $include_list ?></textarea>
                <p class="description">Keywords that identify scripts that should load on user interaction. One keyword per line.</p>
            </td>
        </tr>
        <tr>
            <th scope="row">Load scripts with</th>
            <td>
                <p>
								    <label for="load-onload">
								        <input type="radio" id="load-onload" name="delay_scripts_load_with" value="onload" <?php echo ( $load_with == 'onload' ) ? 'checked' : ''; ?>>
								        Onload								
                    </label>
                    <br/>
								    <label for="load-timeout">
								        <input type="radio" id="load-timeout" name="delay_scripts_load_with" value="timeout" <?php echo ( $load_with == 'timeout' ) ? 'checked' : ''; ?>>
								        Timeout								
                    </label>
							  </p>
                <select name="delay_scripts_timeout" id="scripts-timeout" data-value="<?php echo $timeout; ?>">
                    <option value="1" <?php if ($timeout == 1) {echo 'selected';} ?>>1s</option>
                    <option value="2" <?php if ($timeout == 2) {echo 'selected';} ?>>2s</option>
                    <option value="3" <?php if ($timeout == 3) {echo 'selected';} ?>>3s</option>
                    <option value="4" <?php if ($timeout == 4) {echo 'selected';} ?>>4s</option>
                    <option value="5" <?php if ($timeout == 5) {echo 'selected';} ?>>5s</option>
                    <option value="6" <?php if ($timeout == 6) {echo 'selected';} ?>>6s</option>
                    <option value="7" <?php if ($timeout == 7) {echo 'selected';} ?>>7s</option>
                    <option value="8" <?php if ($timeout == 8) {echo 'selected';} ?>>8s</option>
                    <option value="9" <?php if ($timeout == 9) {echo 'selected';} ?>>9s</option>
                    <option value="10" <?php if ($timeout == 10) {echo 'selected';} ?>>10s</option>
                    <option value="5000" <?php if ($timeout == 5000) {echo 'selected';} ?>>Never</option>
                </select>
                <p class="description">Load scripts after a timeout when there is no user interaction.</p>
            <td>
        </tr>
        <tr>
            <th scope="row"><label for="speed-test-mode">"Website Speed Test" Mode</label></th>
            <td>
                <label for="speed-test-mode">
							      <input name="delay_scripts_speed_test_mode" type="checkbox" id="speed-test-mode" value="1" <?php if($speed_test_mode) echo 'checked'; ?>>
							      Delay scripts only if bot "<strong>website speed test</strong>" detected.
							  </label>
                <p class="description">- <strong>Load script with</strong> will be set to <strong>Onload</strong><br/>- <strong>Timeout value</strong> will be set to <strong>4s</strong><br/>- <strong>Disable for logged in users</strong> will be <strong>checked</strong></p>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="disable-on-login">Disable for logged in users</label></th>
            <td>
                <label for="disable-on-login">
							      <input name="delay_scripts_disable_on_login" id="disable-on-login" type="checkbox" value="1" data-checked="<?php echo $disable_on_login ? 'true' : 'false'; ?>" <?php if($disable_on_login) echo 'checked'; ?>>
                    Users logged in will be excluded
							  </label>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="disable-pages">Disable on pages</label></th>
            <td>
                <textarea id="disable-pages" name="delay_scripts_disabled_pages" rows="4" cols="50"><?php echo $disabled_pages; ?></textarea>
                <p class="description">Keywords of URLs where <strong>Delay Scripts</strong> should be disabled.</p>
            </td>
        </tr>
    </tbody>
    </table>
    <p class="submit">
        <input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes">
    </p>
</form>

<script>
    (function($) {
        function speed_test_mode() {
          $('#load-onload').prop('checked', true);
          $('#load-timeout').parent().addClass('disabled'); //label
          $('#load-timeout').attr('disabled', 'disabled');
          
          $('#scripts-timeout').addClass('disabled');
          if( Number($('#scripts-timeout').val()) < 4 ) $('#scripts-timeout').val(4);
          
          $('#disable-on-login').parent().addClass('disabled'); //label
          $('#disable-on-login').prop('checked', true);
        }
        
        
        var load_default = "<?php echo $load_with; ?>";
        
        if( $('#speed-test-mode').is(':checked') ) speed_test_mode();
        if( $('#load-onload').is(':checked') ) $('#scripts-timeout').addClass('disabled');
        
        $('input[name="delay_scripts_load_with"]').change(function(event) {
  	        if( $(this).val() == 'onload' ) {
                $('#scripts-timeout').addClass('disabled');
            } else {
                $('#scripts-timeout').removeClass('disabled');
            }
            load_default = $(this).val();
  	    });
        
        $('#scripts-timeout').change(function(event) {
  	        if( $(this).hasClass('disabled') ) {
                $(this).val(this.dataset.value);
            } else {
                this.dataset.value = $('#scripts-timeout').val();
            }
  	    });
        
        $('#disable-on-login').change(function(event) {
  	        if( $(this).parent().hasClass('disabled') ) {
                $(this).prop('checked', true);
            } else {
                this.dataset.checked = $(this).is(':checked');
            }
  	    });
        
        $('#speed-test-mode').change(function(event) {
  	        if( $(this).is(':checked') ) {
                speed_test_mode();
  	        } else {
  	            $('#load-timeout').parent().removeClass('disabled'); //label
  	            $('#load-timeout').removeAttr('disabled', 'disabled');
                
  	            $('#disable-on-login').parent().removeClass('disabled'); //label
  	            $('#disable-on-login').prop('checked', ($('#disable-on-login')[0].dataset.checked == 'true' ? true : false));
                
  	            if ( load_default == 'timeout' ) {
                    $('#load-timeout').prop('checked', true);
                    $('#scripts-timeout').removeClass('disabled');
                }
  	        }
  	    });
        
    })(jQuery);

</script>
<?php
}
