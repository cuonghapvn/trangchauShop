<?php

function sort_url($lang, $by, $sort, $sorder, $admin_folder)
{
    if ($sort == $by) {
        if ($sorder == 'asc') {
            $sort = 'desc';
            $icon = ' <i class="icon-chevron-up"></i>';
        } else {
            $sort = 'asc';
            $icon = ' <i class="icon-chevron-down"></i>';
        }
    } else {
        $sort = 'asc';
        $icon = '';
    }
    $return = site_url($admin_folder . '/adviser_cf/index/' . $by . '/' . $sort);
    echo '<a href="' . $return . '">' . $lang . $icon . '</a>';
}
?>
<div class="row">
    <div class="span12">
        <div class="page-header">
            <h1>Quản Trị Chỉ Số CF</h1>
        </div>
        <div class="span4">
            <?php echo $this->pagination->create_links(); ?>    &nbsp;
        </div>
        <div style="text-align:right">
            <a class="btn btn-primary"
               href="<?php echo site_url($this->config->item('admin_folder') . '/adviser_cf/form'); ?>"><i
                    class="icon-plus-sign"></i> Thêm Chỉ Số</a>
        </div>
        <?php echo form_open($this->config->item('admin_folder') . '/adviser_cf/bulk_delete', array('id' => 'delete_form', 'onsubmit' => 'return submit_form();', 'class="form-inline"')); ?>
        <table class="table table-striped" style="float: left;">
            <thead>
            <tr>
                <th style="white-space:nowrap"><input type="checkbox" id="gc_check_all"/>
                    <button type="submit" class="btn btn-small btn-danger"
                        <?php echo (count($cfs) < 1) ? 'disabled="disabled"' : '' ?>>
                        <i class="icon-trash icon-white"></i></button>
                </th>
                <th style="white-space:nowrap"><?php echo sort_url('Mã Chỉ Số', 'cfId', $order_by, $sort_order, $this->config->item('admin_folder')); ?></th>
                <th style="white-space:nowrap"><?php echo sort_url('Nội Dung', 'cfContent', $order_by, $sort_order, $this->config->item('admin_folder')); ?></th>
                <th style="white-space:nowrap"><?php echo sort_url('Giá Trị', 'cfValue', $order_by, $sort_order, $this->config->item('admin_folder')); ?></th>
                <th></th>
            </tr>
            </thead>

            <tbody>
            <?php echo (count($cfs) < 1) ? '<tr><td style="text-align:center;" colspan="8">Chưa có chỉ số cf nào!</td></tr>' : '' ?>
            <?php foreach ($cfs as $entry): ?>
                <tr>
                    <td><input name="order[]" type="checkbox" value="<?php echo $entry->cfId; ?>" class="gc_check"/>
                    </td>
                    <td style="white-space:nowrap"><?php echo $entry->cfId; ?></td>
                    <td style=""><?php echo $entry->cfContent; ?></td>
                    <td style="white-space:nowrap"><?php echo $entry->cfValue; ?></td>
                    <td>
                        <a class="btn btn-small" style="float:right;"
                           href="<?php echo site_url($this->config->item('admin_folder') . '/adviser_cf/form/' . $entry->cfId); ?>"><i
                                class="icon-pencil"></i> <?php echo lang('form_view') ?></a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        </form>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $('#gc_check_all').click(function () {
            if (this.checked) {
                $('.gc_check').prop('checked', 'checked');
            }
            else {
                $(".gc_check").removeProp("checked");
            }
        });
    });

    function submit_form() {
        if ($(".gc_check:checked").length > 0) {
            return confirm('Bạn có chắc chắn muốn xóa những chỉ số này?');
        }
        else {
            alert('Bạn chưa chọn chỉ số nào cả!');
            return false;
        }
    }

    function show_animation() {
        $('#saving_container').css('display', 'block');
        $('#saving').css('opacity', '.8');
    }

    function hide_animation() {
        $('#saving_container').fadeOut();
    }
</script>

<div id="saving_container" style="display:none;">
    <div id="saving"
         style="background-color:#000; position:fixed; width:100%; height:100%; top:0px; left:0px;z-index:100000"></div>
    <img id="saving_animation" src="<?php echo base_url('assets/img/storing_animation.gif'); ?>" alt="saving"
         style="z-index:100001; margin-left:-32px; margin-top:-32px; position:fixed; left:50%; top:50%"/>

    <div id="saving_text"
         style="text-align:center; width:100%; position:fixed; left:0px; top:50%; margin-top:40px; color:#fff; z-index:100001"><?php echo lang('saving'); ?></div>
</div>