<div class="gray_block">
    <div class="gray_block_title">
        <?php echo Yii::t('UsersModule.main', 'НОВЫЕ ЧЛЕНЫ КЛУБА'); ?>
    </div>

    <?php foreach ($users as $user): ?>
        <div class="item_list">
            <a href="" class="link_14"><?php echo $user["name"]; ?></a>
            <div><?php echo $user["position"]; ?></div>
        </div>
    <?php endforeach ?>

    <a href="" class="more left"><?php echo Yii::t('UsersModule.main', 'Все члены клуба'); ?></a>
    <br clear="all"/>
    <a href="">
        <img class="xsl_icon" src="/images/site/xsl_icon.png" alt=""/>
    </a>
    <a href="/users/user/export" class="link_13">
        <?php echo Yii::t('UsersModule.main', 'Скачать реестр членов клуба'); ?>
    </a><br/>
    <span class="file_size">(xls, 2 МБ)</span>
    <br clear="all"/>
</div>

<div class="gray_block_bottom"></div>
