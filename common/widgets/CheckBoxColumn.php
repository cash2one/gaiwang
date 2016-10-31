<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * DataColumn class file.
 * Extends {@link CDataColumn}
 */
class CheckBoxColumn extends CCheckBoxColumn {
    public $relation_id;
    
    /**
     * Renders a data cell.
     * @param integer $row the row number (zero-based)
     * Overrides the method 'renderDataCell()' of the abstract class CGridColumn
     */
    protected function renderDataCellContent($row,$data)
    {
            if($this->value!==null)
                    $value=$this->evaluateExpression($this->value,array('data'=>$data,'row'=>$row));
            elseif($this->name!==null)
                    $value=CHtml::value($data,$this->name);
            else
                    $value=$this->grid->dataProvider->keys[$row];

            $checked = false;
            if($this->checked!==null)
                    $checked=$this->evaluateExpression($this->checked,array('data'=>$data,'row'=>$row));

            $options=$this->checkBoxHtmlOptions;
            if($this->disabled!==null)
                    $options['disabled']=$this->evaluateExpression($this->disabled,array('data'=>$data,'row'=>$row));
            
            if($this->relation_id !== null)
                $relation_id = $this->evaluateExpression($this->relation_id,array('data'=>$data,'row'=>$row));
            $name=$options['name'];
            unset($options['name']);
            $options['value']=$value;
            $options['relation_id'] = $relation_id;
            $options['id']=$this->id.'_'.$row;
            echo CHtml::checkBox($name,$checked,$options);
    }

}
