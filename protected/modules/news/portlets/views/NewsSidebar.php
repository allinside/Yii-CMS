<div class="gray_block">
    <div class="gray_block_title"><?php echo Yii::t("NewsModule.main", "ПОСЛЕДНИЕ НОВОСТИ"); ?></div>
    
    <?php foreach ($news_list as $news): ?>

    	<?php
        /*
         * TODO : неверный урл
        */
        $url = $this->url("/news/{$news->id}");
        ?>

	    <div class="item_list">

	    	<?php if ($news->photo): ?>
                <a href="<?php echo $url; ?>">
                    <?php
                     echo ImageHelper::thumb(
                        News::PHOTOS_DIR,
                        $news->photo,
                        News::PHOTO_SMALL_WIDTH,
                        News::PHOTO_SMALL_HEIGHT,
                        true,
                        "border='0' class='last_news'"
                    );
                    ?>
                </a>
	    	<?php endif ?>

            <a href="<?php echo $url; ?>" class="link_13"><?php echo Text::cut($news->title, 44, ' ', '...'); ?></a>

	        <div><?php echo Yii::app()->dateFormatter->format("dd MMMM yyyy", $news->date);  ?></div>
	        <br clear="all"/>
	    </div> 
    <?php endforeach ?>

    <a href="<?php echo $this->url('/news'); ?>" class="more left">
        <?php echo Yii::t('NewsModule.main', 'Все новости'); ?>
    </a>

    <br clear="all"/>
</div>

<div class="gray_block_bottom"></div>
