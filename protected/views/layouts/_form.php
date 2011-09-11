<?php
echo $form->renderBegin();

$elements = $form->getElements();
?>

<?php foreach ($elements as $element): ?>
    <?php
    $class = isset($element->attributes['class']) ? $element->attributes['class'] : '';

    $ext_class = '';

    switch ($element->type)
    {
        case 'text':
            $ext_class = 'text';

            break;

        case 'textarea':
            //$ext_class = 'textarea_feedback';
            //if ($element->required)
            //{
            //    $ext_class.= ' required_field';
            //}

            break;
    }

    if ($ext_class)
    {
        $class.= ' ' . $ext_class;
    }

    $element->attributes['class'] = $class;

    $error = $element->renderError();
    ?>

    <?php if ($element->type == 'hidden'): ?>
        <?php echo $element->renderInput(); ?>
    <?php else: ?>
        <ol>
            <li>
                <label for="<?php $element->name; ?>">
                    <?php echo $element->label; ?>
                    <?php if ($element->required): ?>
                        (<?php echo Yii::t('main', 'обязательное поле'); ?>)
                    <?php endif ?>
                </label>

                <?php if ($error): ?>
                    <?php echo $error; ?>
                <?php endif ?>

                <?php echo $element->renderInput(); ?>
            </li>
        </ol>
    <?php endif; ?>

<?php endforeach ?>

<?php echo $form->renderButtons(); ?>

<?php echo $form->renderEnd(); ?>


