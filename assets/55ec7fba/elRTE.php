<?php
class elRTE extends CInputWidget
{
   public $options = array();
   public $elfoptions = array();

   public function run()
   {
      $cs=Yii::app()->clientScript;
      
      $dir = dirname(__FILE__).DIRECTORY_SEPARATOR;
      $baseUrl = Yii::app()->getAssetManager()->publish($dir).'/elrte';
      $baseUrlE = Yii::app()->getAssetManager()->publish($dir).'/elfinder';
      list($name, $id) = $this->resolveNameID();
      if(isset($this->htmlOptions['id']))
      {
            $id=$this->htmlOptions['id'];
      } else {
            $this->htmlOptions['id']=$id;
      }
      if(isset($this->htmlOptions['name']))
      {
            $name=$this->htmlOptions['name'];
      } else {
            $this->htmlOptions['name']=$name;
      }

      $clientScript = Yii::app()->getClientScript();

      //$clientScript->registerCssFile($baseUrl.'/js/ui-themes/base/ui.all.css');
      $clientScript->registerCssFile($baseUrl.'/css/smoothness/jquery-ui-1.8.5.custom.css');
      $clientScript->registerCssFile($baseUrl.'/css/elrte.full.css');

      $clientScript->registerCoreScript('jquery');

      $clientScript->registerScriptFile($baseUrl.'/js/elrte.full.js',CClientScript::POS_HEAD);

      if (isset($this->options['lang']))
            $clientScript->registerScriptFile($baseUrl.'/js/i18n/elrte.'.$this->options['lang'].'.js',CClientScript::POS_HEAD);
      if (!isset($this->options['name']))
            $this->options['name'] = $name;
      
      if(!empty($this->options['cssfiles']))
      {
         $css_paths = array();
         foreach ($this->options['cssfiles'] as $cssf)
         {
             $css_paths[] = $cssf;
         }
         $this->options['cssfiles'] = $css_paths;
      }

      //from here
      $elfopts = "";
      if(!empty($this->options['fmAllow']))
      {
            $clientScript->registerCssFile($baseUrlE.'/js/ui-themes/base/ui.all.css');
            $clientScript->registerCssFile($baseUrlE.'/css/elfinder.css');
            $clientScript->registerScriptFile($baseUrlE.'/js/elfinder.full.js',CClientScript::POS_HEAD);
          if (isset($this->options['lang']) && !isset($this->elfoptions['lang']))
          {
              $clientScript->registerScriptFile($baseUrlE.'/js/i18n/elfinder.'.$this->options['lang'].'.js',CClientScript::POS_HEAD);
          } elseif(isset($this->elfoptions['lang'])) {
              $clientScript->registerScriptFile($baseUrlE.'/js/i18n/elfinder.'.$this->elfoptions['lang'].'.js',CClientScript::POS_HEAD);
          }

          if(!empty($this->elfoptions))
          {
              if($this->elfoptions['url'] == 'auto') $this->elfoptions['url'] =  $baseUrlE.'/connectors/php/connector.php';
              if(!empty($this->elfoptions['passkey'])) $this->elfoptions['url'] .= '?passkey='.urlencode($this->elfoptions['passkey']) ;
          }
          $elfopts = CJavaScript::encode($this->elfoptions);
      }

      //to here!
      $optsenc = CJavaScript::encode($this->options);
      if(!empty($elfopts)) $optsenc = str_replace('%elfopts%', $elfopts, $optsenc);
      $js="$().ready(function(){";
      $js.="var opts=";
      $js.= $optsenc;
      $js.=";";
      $js.="$('#".$id."').elrte(opts);";
      $js.="})";

      $cs->registerScript($id,$js,CClientScript::POS_HEAD);
      echo '<textarea id="'.$id.'" name="'.$name.'" style="width:100%">';
          echo $this->model['attributes'][$this->attribute];
      echo '</textarea>';
    }
}
?>
