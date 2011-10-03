<?php if ($this->items !== null && !empty($this->items)) { ?>
    <div class="files">
        <?php foreach($this->items as $item) {
            $this->render('filesListItem', array("data"=>$item));
        } ?>
        <div class="clear"></div>
    </div>
<?php } ?>

