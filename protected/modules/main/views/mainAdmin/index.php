<style type="text/css">
	
	.version {
		font-size: 11px;
	}
	
	.modules h3 {
		float: left;
	}
	
	.modules {
		width: 100%;
	}
	
	.modules .image {
		width: 80px;
		text-align: left;
	}
	
	.modules a {
		margin-right: 20px;	
	}
	
	.modules td {
		border: 0 !important;
	}
	
	.separator {
		border-bottom: 1px solid #DDDDDD;
		margin-top: 10px;
		margin-bottom: 20px;
	}
	
</style>

<?php
$this->page_title = 'Модули';
?>

<?php foreach ($modules as $class => $data): ?>

    <?php
    if (!isset($data['admin_menu']) || !$data['admin_menu'])
    {
        continue;
    }
    ?>

    <table class="modules">
        <tr valign="top">
            <td class="image">
                <img src="/images/admin/modules/<?php echo strtolower(str_replace("Module", "", $class)); ?>.png" border="0" />
            </td>
            <td>
				<h3><?php echo $data["name"]; ?></h3> &nbsp;
				<span class='version'>версия <?php echo $data["version"]; ?></span> 
				<br clear="all" />
				<?php echo $data["description"]; ?> 
				<br/><br/>
				
				<?php if (isset($data['admin_menu'])): ?>
					<?php foreach ($data['admin_menu'] as $title => $url): ?>
						<a href="<?php echo $url ?>"><?php echo $title ?></a>
					<?php endforeach ?>				
				<?php endif ?>

            </td>
        </tr>
    </table>
    <div class='separator'></div>
<?php endforeach ?>


