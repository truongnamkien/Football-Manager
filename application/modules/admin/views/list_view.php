<div class="content-box"><!-- Start Content Box -->
    <div class="content-box-header">
        <h3><?php echo lang($type . '_manager_title') ?></h3>
        <ul class="content-box-tabs">
            <li><a class="current" href="<?php echo site_url('admin/' . $type . '/create') ?>"><?php echo lang($type . '_create') ?></a></li>
        </ul>
        <div class="clear"></div>
    </div>

    <div class="content-box-content">
        <?php echo form_open('admin/' . $type . '/remove', array('id' => 'frm_remove_admin')) ?>
        <input type="hidden" name="<?php echo ($type . '_id') ?>" value="" />
        <?php echo form_close(); ?>

        <div id="list" class="tab-content default-tab" style="display: block;">
            <div>
                <input name="search" id="search" value="" class="text-input small-input" />
            </div>

            <table>
                <thead>
                    <tr>
                        <th><input class="check-all" type="checkbox" /></th>
                        <?php
                        if (count($objects) > 0) {
                            foreach (array_keys($objects[0]) as $key) {
                                echo '<th>' . lang($type . '_' . $key) . '</th>';
                            }
                        }
                        ?>
                    </tr>
                </thead>

                <tbody>                       
                    <?php
                    if (count($objects) > 0) {
                        foreach ($objects as $obj) {
                            $obj_id = $obj[key($obj)];
                            echo '<tr class="inlineEdit" rel="' . $obj_id . '">';
                            echo '<td><input type="checkbox" name="checkboxes[' . $obj_id . ']" /></td>';

                            foreach ($obj as $key => $val) {
                                if (preg_match('/id$/', $key)) {
                                    echo '<td class="inlineDisable inline_id">';
                                } else {
                                    if (ctype_lower($key[0]))
                                        echo '<td field="' . $key . '" class="inlineDisable">';
                                    else
                                        echo '<td class="inlineDisable">';
                                }

                                if (preg_match('/([^\s]+(\.(?i)(jpg|png|gif|bmp))$)/i', $val)) {
                                    $base_url = '';

                                    if (strpos($val, 'http://') === FALSE) {
                                        $base_url = base_url();
                                    }
                                    echo '<img src="' . $base_url . $val . '" width=50 />';
                                } else {
                                    echo $val;
                                }
                                echo '</td>';
                            }
                            echo '</tr>';
                        }
                    } else {
                        echo lang($type . 'empty');
                    }
                    ?>
                </tbody>
            </table>

            <div>
                <div class="bulk-actions align-left"><!-- Start Group Actions -->
                    <?php
                    echo form_open_multipart('admin/' . $type . '/mass');
                    echo form_dropdown('mass_action_dropdown', $mass_action_options, 'select');
                    echo form_submit(array('name' => 'submit', 'class' => 'button delete', 'disabled' => 'disabled'), "Apply to selected");
                    ?>
                </div><!-- End Group Actions -->

                <div class="clear"></div>
            </div>

        </div> <!-- End #tab1 -->

    </div> <!-- End .content-box-content -->
</div> <!-- End .content-box -->

<script type="text/javascript">
    $(function() {
        $('.delete').click(function() {
            if ((this.className == 'button delete' && $('select[name="mass_action_dropdown"]').val() != '<?php echo key($mass_action_options) ?>')
                || this.className != 'button delete') {
                return confirm("Are you sure?");
            }
        });
        $('input[name="submit"].delete').disabled = true;

        $('select[name="mass_action_dropdown"]').change(function() {
            if ($('select[name="mass_action_dropdown"]').val() == '<?php echo key($mass_action_options) ?>') {
                $('input[name="submit"].delete').attr('disabled', 'disabled');
            } else {
                $('input[name="submit"].delete').removeAttr('disabled');
            }
        });

        
        $.fn.textWidth = function(){
            var html_org = $(this).html();
            var html_calc = '<span>' + html_org + '</span>'
            $(this).html(html_calc);
            var width = $(this).find('span:first').width();
            $(this).html(html_org);
            return width;
        };
    });
</script>
