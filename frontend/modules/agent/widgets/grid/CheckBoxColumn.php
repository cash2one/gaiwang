<?php
/*
 * 重写CCheckBoxColumn，加了type的参数，来判断是checkbox或者radio
 */
Yii::import('zii.widgets.grid.CCheckBoxColumn');
class CheckBoxColumn extends CCheckBoxColumn
{
		public $type = 'checkbox';
	
		protected function renderDataCellContent($row,$data)
        {
                if($this->value!==null)
                        $value=$this->evaluateExpression($this->value,array('data'=>$data,'row'=>$row));
                else if($this->name!==null)
                        $value=CHtml::value($data,$this->name);
                else
                        $value=$this->grid->dataProvider->keys[$row];

                $checked = false;
                if($this->checked!==null)
                        $checked=$this->evaluateExpression($this->checked,array('data'=>$data,'row'=>$row));

                $options=$this->checkBoxHtmlOptions;
                $name=$options['name'];
                unset($options['name']);
                $options['value']=$value;
                $options['id']=$this->id.'_'.$row;
                if($this->type === 'checkbox')
                {
                	echo CHtml::checkBox($name,$checked,$options);
                }
                elseif ($this->type === 'radio')
                {
                	echo CHtml::radioButton($name,$checked,$options);
                }
                else 
                {
                	throw new ErrorException('参数有误');
                }
        }
}