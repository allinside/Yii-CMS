<?php

Yii::import("application.libs.yii.zii.widgets.grid.CGridView");

class GridView extends CGridView
{	
	public $cssFile = null;

    public $filters;

    public $order_links = false;

    public $pager=array('class'=>'LinkPager');

    public $buttons = null;

    public function initColumns()
    {
        parent::initColumns();

        if ($this->order_links)
        {
            $columns = $this->columns;

            $order_column = new CDataColumn($this);
            $order_column->value = 'GridView::orderLinks($data)';
            $order_column->header = 'Порядок';
            $order_column->type = 'raw';

            $last_index  = count($columns) - 1;
            $last_column = $columns[$last_index];

            $columns[$last_index] = $order_column;
            $columns[] = $last_column;

            $this->columns = $columns;
        }
    }


    public static function orderLinks($data)
    {
        $class = get_class($data);

        return "<a href='/main/mainAdmin/changeOrder/id/{$data->id}/order/up/class/{$class}/from/" . base64_encode($_SERVER["REQUEST_URI"]) . "' />
                    <img src='/images/admin/icons/arrow_up.png' border='0' />
                </a>
                &nbsp;
                <a href='/main/mainAdmin/changeOrder/id/{$data->id}/order/down/class/{$class}/from/" . base64_encode($_SERVER["REQUEST_URI"]) . "' />
                    <img src='/images/admin/icons/arrow_down.png' border='0'  />
                </a>";
    }


	public function renderFilter()
	{
        if (!$this->filters)
        {
            return;
        }

		if($this->filter!==null)
		{
			echo "<tr class=\"{$this->filterCssClass}\">\n";
			foreach($this->columns as $column)
            {
                if (isset($column->name))
                {
                    if (!in_array($column->name, $this->filters))
                    {
                        echo "<td></td>";
                        continue;
                    }
                }
            }
			echo "</tr>\n";
		}
	}


	public function renderItems()
	{
		if($this->dataProvider->getItemCount()>0 || $this->showTableOnEmpty)
		{
			echo "<table class='' cellpadding='0' cellspacing='0' width='100%'>\n";
			$this->renderTableHeader();
			$this->renderTableBody();
			$this->renderTableFooter();
			echo "</table>";
		}
		else
			$this->renderEmptyText();
	}


	public function renderTableHeader()
	{
		if(!$this->hideHeader)
		{
			echo "<thead>\n";

			if($this->filterPosition===self::FILTER_POS_HEADER)
				$this->renderFilter();

			echo "<tr>\n";
            //echo "<td><input type='checkbox'></td>";

			foreach($this->columns as $column)
            {
                $column->renderHeaderCell();
            }

			echo "</tr>\n";

			if($this->filterPosition===self::FILTER_POS_BODY)
				$this->renderFilter();

			echo "</thead>\n";
		}
		else if($this->filter!==null && ($this->filterPosition===self::FILTER_POS_HEADER || $this->filterPosition===self::FILTER_POS_BODY))
		{
			echo "<thead>\n";
			$this->renderFilter();
			echo "</thead>\n";
		}



	}


	public function renderSummary()
	{
		if(($count=$this->dataProvider->getItemCount())<=0)
			return;

		echo '<div class="'.$this->summaryCssClass.'">';
		if($this->enablePagination)
		{
			if(($summaryText=$this->summaryText)===null)
				$summaryText=Yii::t('zii','Displaying {start}-{end} of {count} result(s).');
			$pagination=$this->dataProvider->getPagination();
			$total=$this->dataProvider->getTotalItemCount();
			$start=$pagination->currentPage*$pagination->pageSize+1;
			$end=$start+$count-1;
			if($end>$total)
			{
				$end=$total;
				$start=$end-$count+1;
			}
			echo strtr($summaryText,array(
				'{start}'=>$start,
				'{end}'=>$end,
				'{count}'=>$total,
				'{page}'=>$pagination->currentPage+1,
				'{pages}'=>$pagination->pageCount,
			));
		}
		else
		{
			if(($summaryText=$this->summaryText)===null)
				$summaryText=Yii::t('zii','Total {count} result(s).');
			echo strtr($summaryText,array(
				'{count}'=>$count,
				'{start}'=>1,
				'{end}'=>$count,
				'{page}'=>1,
				'{pages}'=>1,
			));
		}

        echo $this->getPagerSelect();

		echo '</div>';
	}


    public function getPagerSelect()
    {
        $value = null;
        if (isset(Yii::app()->session[get_class($this->filter) . "PerPage"]))
        {
            $value = Yii::app()->session[get_class($this->filter) . "PerPage"];
        }

        $select = CHtml::dropDownList(
            "pager_pages",
            $value,
            array_combine(range(10, 500, 5), range(10, 500, 5)),
            array(
                'class' => 'pager_select',
                'model' => get_class($this->filter)
            )
        );

        $html = "&nbsp; &nbsp;Показывать на странице: {$select}";

        return $html;
    }
}
