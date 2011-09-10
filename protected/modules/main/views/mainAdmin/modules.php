<script type="text/javascript" src="/js/admin/modules.js"></script>

<?php $this->page_title = 'Модули'; ?>

<br/>

<table id='rounded-corner'>
    <thead>
        <tr>
            <th id='settings-grid_c0' class='rounded-company'>Название</th>
            <th>Описание</th>
            <th align='center'>Версия</th>
            <th id='settings-grid_c1' class='rounded-q4 button-column'>&nbsp;</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($modules as $class => $module): ?>
            <?php if ($module['base_module']) continue; ?>

            <tr class='odd'>
                <td><b><?php echo $module['name'] ?></b></td>
                <td><?php echo $module['description'] ?></td>
                <td align='center'><?php echo $module['version'] ?></td>
                <td class='button-column' style="width:200px">

                    <?php if (in_array($class, $active_modules)): ?>
                        <a href='javascript:;' class='bt_red deactivate_module' action='deactivateModule' module_class='<?php echo $class ?>' name='<?php echo $module['name'] ?>'>
                            <span class='bt_red_lft'></span>
                            <strong>Деактивировать</strong>
                            <span class='bt_red_r'></span>
                        </a>
                    <?php else: ?>
                        <a href='javascript:;' class='bt_green activate_module' action='activateModule' module_class='<?php echo $class ?>' name='<?php echo $module['name'] ?>'>
                            <span class='bt_green_lft'></span>
                            <strong>Активировать</strong>
                            <span class='bt_green_r'></span>
                        </a>
                    <?php endif ?>

                </td>
            </tr>
        <?php endforeach ?>
    </tbody>
    <tfoot>
        <tr>
            <td class='rounded-foot-left' colspan='3'></td>
            <td class='rounded-foot-right'>&nbsp;</td>
        </tr>
    </tfoot>
</table>


