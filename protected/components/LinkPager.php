<?php

class LinkPager extends CLinkPager
{
    public $cssFile;

	public function run()
	{
		$this->registerClientScript();
		$buttons=$this->createPageButtons();

        $this->htmlOptions['class'] = 'pagination right';

		if(empty($buttons))
			return;
		echo $this->header;
		echo CHtml::tag('div',$this->htmlOptions,implode("\n",$buttons));
		echo $this->footer;
	}


	protected function createPageButton($label,$page,$class,$hidden,$selected)
	{
		return CHtml::link($label,$this->createPageUrl($page), array('class' => $selected ? 'active' : ''));
	}
}