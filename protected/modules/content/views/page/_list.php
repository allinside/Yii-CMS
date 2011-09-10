<?php foreach ($pages as $page): ?>
    <?php
    $url  = $this->url($page->href);
    $text = Text::cut($page->text, 250, " ", "...");
    ?>
    <div class="search_list">
        <a href="<?php echo $url ?>" class="search_title"><?php echo $page->title; ?></a>
        <p><?php echo $text; ?></p>
        <a href="<?php echo $url ?>" class="more_info"><?php Yii::t('main', 'Подробнее'); ?></a>
    </div>
<?php endforeach ?>


