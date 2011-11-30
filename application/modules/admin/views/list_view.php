
<div class="content-box"><!-- Start Content Box -->
    <div class="content-box-header">
        <h3><?php echo lang($type . '_manager_title') ?></h3>
        <ul class="content-box-tabs">
            <?php if (isset($main_nav) && !empty($main_nav)): ?>
                <?php foreach ($main_nav as $key => $link): ?>
                    <li><a class="current" href="<?php echo $link; ?>"><?php echo lang($key); ?></a></li>
                <?php endforeach; ?>
            <?php endif; ?>
        </ul>
        <div class="clear"></div>
    </div>

    <div class="content-box-content">
        <div id="list" class="tab-content default-tab" style="display: block;">
            <?php if (empty($objects)) : ?>
                <?php echo lang('empty_list_data'); ?>
            <?php else : ?>
                <div>
                    <input name="search" id="search" value="" class="text-input small-input" />
                </div>

                <table>
                    <thead>
                        <tr>
                            <th><input class="check-all" type="checkbox" /></th>

                            <?php
                            foreach (array_keys($objects[0]) as $key) {
                                echo '<th>' . lang($type . '_' . $key) . '</th>';
                            }
                            ?>
                        </tr>
                    </thead>

                    <tbody>                       
                        <?php
                        if (count($objects) > 0) {
                            foreach ($objects as $obj) {
                                $obj_id = $obj[get_object_key($obj, $type)];
                                echo '<tr class="inlineEdit" rel="' . $obj_id . '">';
                                echo '<td><input type="checkbox" value="' . $obj_id . '" /></td>';

                                foreach ($obj as $key => $val) {
                                    if (preg_match('/id$/', $key)) {
                                        echo '<td class="inlineDisable inline_id">';
                                    } else {
                                        if (ctype_lower($key[0])) {
                                            echo '<td field="' . $key . '" class="inlineDisable">';
                                        } else {
                                            echo '<td class="inlineDisable">';
                                        }
                                    }

                                    if ($key == 'actions' && is_array($val)) {
                                        $index = 0;
                                        foreach ($val as $action) {
                                            echo $action;
                                            if ($index < count($val) - 1) {
                                                echo ' | ';
                                            }
                                            $index++;
                                        }
                                    } else if (preg_match('/([^\s]+(\.(?i)(jpg|png|gif|bmp))$)/i', $val)) {
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
                        echo form_open_multipart('admin/' . $type . '/mass', array('id' => 'frm_mass_action', 'onsubmit' => 'return mass_submit();'));
                        echo form_hidden('ids');
                        echo form_dropdown('mass_action_dropdown', $mass_action_options, 'select');
                        echo form_submit(array('name' => 'submit', 'class' => 'button remove', 'disabled' => 'true'), lang('admin_mass_submit'));
                        echo form_close();
                        ?>
                    </div><!-- End Group Actions -->
                    <div class="clear"></div>
                </div>
            <?php endif; ?>
        </div> <!-- End #tab1 -->
    </div> <!-- End .content-box-content -->
</div> <!-- End .content-box -->

<script type="text/javascript">
    $(function() {
        $('select[name="mass_action_dropdown"]').change(function() {
            if ($('select[name="mass_action_dropdown"]').val() == '<?php echo key($mass_action_options) ?>') {
                $('input[name="submit"].remove').attr('disabled', 'true');
            } else {
                $('input[name="submit"].remove').removeAttr('disabled');
            }
        });
    });
    
    function mass_submit() {
        var _checkboxs = $('#list tbody').find('input[type="checkbox"]');
        var _ids = "";
        for (var i = 0; i < _checkboxs.length; i++) {
            if(_checkboxs[i].checked) {
                if (_ids == "") {
                    _ids = _checkboxs[i].value;
                } else {
                    _ids += "," + _checkboxs[i].value;
                }
            }
        }
        if (_ids == "") {
            alert('<?php echo lang('admin_mass_select_empty') ?>');
        } else {
            var _result = confirm('<?php echo lang('admin_confirm_content'); ?>');
            if(_result) {
                $('input[name="ids"]').val(_ids);
                return true;
            }
        }
        return false;
    }
</script>
