<?php
echo $form->renderBegin();

$model_class = get_class($form->model);
$elements    = $form->getElements();
?>

<?php foreach ($elements as $element): ?>
    <?php
    $class = isset($element->attributes['class']) ? $element->attributes['class'] : '';

    $ext_class = '';

    switch ($element->type)
    {
        case 'text':
        case 'password':
            $ext_class = 'text';
            break;

        case 'date':
            $ext_class = 'text date_picker';
            $element->attributes['readonly'] = true;
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
                <?php if ($element->type == 'date'): ?>

                    <label for="<?php $element->name; ?>">
                        <?php echo $element->label; ?>
                        <?php if ($element->required): ?>
                            (<?php echo Yii::t('main', 'обязательное поле'); ?>)
                        <?php endif ?>
                    </label>

                    <?php echo $form->getActiveFormWidget()->textField($form->model, $element->name, $element->attributes); ?>
                    <?php
                    $this->widget('application.extensions.calendar.SCalendar',
                        array(
                        'inputField' => "{$model_class}_{$element->name}",
                        'ifFormat'   => '%d.%m.%Y',
                        'language'   => 'ru-UTF'
                    ));
                    ?>
                    <?php echo $form->getActiveFormWidget()->error($form->model, $element->name); ?>

                <?php elseif ($element->name == 'captcha'): ?>

                    <p>
                        <?php echo $form->getActiveFormWidget()->labelEx($form->model, 'captcha'); ?>
                        <?php
                        $this->widget('application.extensions.recaptcha.EReCaptcha',
                           array(
                               'model'      => $form->model,
                               'attribute'  => 'captcha',
                               'theme'      => 'red',
                               'language'   => 'ru_Ru',
                               'publicKey' => '6LcsjsMSAAAAAG5GLiFpNi5R80_tg6v3NndjyuVh'
                        ));
                        ?>
                        <?php echo $form->getActiveFormWidget()->error($form->model, 'captcha'); ?>
                    </p>

                <?php else : ?>

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

                <?php endif ?>
            </li>
        </ol>
    <?php endif; ?>

<?php endforeach ?>

<br/>

<?php echo $form->renderButtons(); ?>

<?php echo $form->renderEnd(); ?>


