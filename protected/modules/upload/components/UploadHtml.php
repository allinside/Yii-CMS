<?php
class UploadHtml
{
    /**
     * Возвращает URL, сформированный на основе указанного маршрута и параметров
     * @param string $route маршрут
     * @param array $params дополнительные параметры маршрута
     * @return string
     */
    public static function url($url, $params = array())
    {
        return Yii::app()->createUrl("/upload/".$url, $params);
    }

    /**
     * Возвращает ссылку, сформированный на основе указанного маршрута и параметров
     * @param string $route маршрут
     * @param array $params дополнительные параметры маршрута
     * @return string
     */
    public static function link($text, $url, $urlParams = array(), $htmlOptions = array())
    {
        return CHtml::link($text, self::url($url, $urlParams), $htmlOptions);
    }

    public static function editableLink($text, $model, $attr, $url, $htmlOptions=array())
    {
        $name = CHtml::resolveName($model, $attr);
        $htmlOptions = CMap::mergeArray($htmlOptions, array('name'=>$name));
        return CHtml::link($text, self::url($url, array('id'=>$model->id, 'attr'=>$attr )), $htmlOptions);
    }
}