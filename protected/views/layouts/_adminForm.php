<div class='form'>

    <?php echo $this->msg('Поля отмеченные * обязательны.', 'info'); ?>

    <?php echo $form->renderBegin(); ?>

    <?php
    $elements = $form->getElements();
    $model_class = get_class($form->model);

    foreach ($elements as $i => $element)
    {
        $class = '';

        switch ($element->type)
        {
            case 'text':
            case 'password':
                $class = 'text';
                break;

            case 'date':
                $class = 'text date_picker';
                $element->attributes['readonly'] = true;
                break;
        }

        if (!empty($class))
        {
            if (array_key_exists('class', $element->attributes))
            {
                $element->attributes['class'] = $element->attributes['class'] . ' ' . $class;
            }
            else
            {
                $element->attributes['class'] = $class;
            }
        }

        $elements[$i] = $element;
    }

    foreach ($form->buttons as $i => $button)
    {
        $length = mb_strlen($button->value, 'utf-8');

        if ($length > 11)
        {
            $button->attributes['class'] = 'submit long';
        }
        elseif ($length > 6)
        {
            $button->attributes['class'] = 'submit mid';
        }
        else
        {
            $button->attributes['class'] = 'submit small';
        }


        $form->buttons[$i] = $button;
    }
    ?>

    <?php foreach ($elements as $element): ?>
        <?php if ($element->type == 'date'): ?>

            <p>
                <?php echo $form->getActiveFormWidget()->labelEx($form->model, $element->name); ?>
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
            </p>

        <?php elseif ($element->type == 'editor'): ?>

            <p>
                <?php echo $form->getActiveFormWidget()->labelEx($form->model, $element->name); ?>
                <?php
                $this->widget('application.extensions.elrtef.elRTE', array(
                    'model'     => $form->model,
                    'attribute' => $element->name,
                    'name'      => "{$model_class}[{$element->name}]",
                    'options' => array(
                            'doctype'=>'js:\'<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">\'',
                            'cssClass' => 'el-rte',
                            'cssfiles' => array('/css/site/style.css'),
                            'absoluteURLs'=>true,
                            'allowSource' => true,
                            'lang' => 'ru',
                            'styleWithCss'=>'100%',
                            'height' => 200,
                            'fmAllow'=>true, //if you want to use Media-manager
                            'fmOpen'=>'js:function(callback) {$("<div id=\"elfinder\" />").elfinder(%elfopts%);}',//here used placeholder for settings
                            'toolbar' => 'maxi',
                    ),
                    'elfoptions' => array( //elfinder options
                        'url'=>'auto',  //if set auto - script tries to connect with native connector
                        'passkey'=>'mypass', //here passkey from first connector`s line
                        'lang'=>'ru',
                        'dialog'=>array('width'=>'900','modal'=>true,'title'=>'Media Manager'),
                        'closeOnEditorCallback'=>true,
                        'editorCallback'=>'js:callback'
                    ),
                    )
                );
                ?>
                <?php echo $form->getActiveFormWidget()->error($form->model, $element->name); ?>
            </p>
            <br/>

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

        <?php elseif ($element->type == 'multi_select'): ?>
            <p>
                <?php echo $form->getActiveFormWidget()->labelEx($form->model, $element->name); ?>

                <?php
                $this->widget(
                    'application.extensions.emultiselect.EMultiSelect',
                    array(
                        'sortable'   => true,
                        'searchable' => true
                    )
                );
                ?>

                <?php
                echo $form->getActiveFormWidget()->dropdownlist(
                    $form->model,
                    $element->name,
                    $element->items,
                    array('multiple' => 'multiple', 'key' => $element->name, 'class' => 'multiselect')
                );
                ?>
            </p>

        <?php elseif ($element->type == 'autocomplete'): ?>

            <p>
                <?php echo $form->getActiveFormWidget()->labelEx($form->model, $element->name); ?>

                <?php
                $this->widget('CAutoComplete',
                      array(
                         'name'      => $element->name,
                         'url'       => array($element->url),
                         'minChars'  => 2,
                         'delay'     => 500,
                         'matchCase' => false,
                         'htmlOptions'=>array('size'=>'40')
                ));
                ?>

                <?php echo $form->getActiveFormWidget()->error($form->model, $element->name); ?>
            </p>
            
        <?php elseif ($element->type == "checkbox"): ?>
              
            <div class='checkbox_input'>
                <?php echo $element->renderInput(); ?>
            </div>  
              
            <div class='checkbox_label'>  
                <?php echo $element->renderLabel(); ?>
            </div>    
            <br clear="all" />

        <?php elseif ($element->type == "widget" && isset($element->attributes['widget'])): ?>

            <?php $this->widget($element->attributes['widget'], array('model' => $form->model)); ?>

        <?php else: ?>
            <p>
                <?php echo $element->render(); ?>
            </p>
        <?php endif ?>
    <?php endforeach ?>

    <?php echo $form->renderButtons(); ?>
    <?php echo $form->renderEnd(); ?>

</div>


