<ul class="bottom_menu">
    <?php foreach ($sections as $section): ?>
        <li>
            <a class="parent" href="<?php echo $this->url($section->href); ?>"><?php echo $section->title; ?></a>

            <?php if ($section->childs): ?>
                <ul>
                    <?php foreach ($section->childs as $child): ?>
                        <li><a href="<?php echo $this->url($child->href); ?>"><?php echo $child->title; ?></a></li>
                    <?php endforeach ?>
                </ul>
            <?php endif ?>
        </li>
    <?php endforeach ?>
</ul>