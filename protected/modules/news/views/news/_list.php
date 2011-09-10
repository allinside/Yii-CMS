<?php foreach ($news_list as $news): ?>
    <?php
    $url  = $this->url("/news/{$news->id}");
    $text = Text::cut($news->text, 250, " ", "...");
    ?>
    <div class="search_list">
        <a href="<?php echo $url ?>" class="search_title"><?php echo $news->title; ?></a>
        <div class="item_date"><?php echo Yii::app()->dateFormatter->format("dd MMMM yyyy", $news->date);  ?></div>

        <p><?php echo $text; ?></p>
        <a href="<?php echo $url ?>" class="more_info"><?php Yii::t('main', 'Подробнее'); ?></a>
    </div>
<?php endforeach ?>


