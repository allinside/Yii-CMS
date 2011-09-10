<?php $this->page_title = Yii::t("main", "Результаты поиска"); ?>

<?php if ($result): ?>
    <?php foreach ($result as $model_class => $data): ?>
        <?php 
        $this->renderPartial(
            $data["partial_path"], 
            array($data['array_var'] => $data['items'])
        ); 
        ?>
    <?php endforeach ?>
<?php else: ?>
    <?php echo $this->msg("По запросу '{$query}' ничего не найдено", "ok"); ?>
<?php endif ?>

