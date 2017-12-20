<?php


    /*
    * フリーワード検索
    * freeword keyword text 
    * logic_operatio bool AND OR
    例  $cond=array_merge_recursive($cond,array(array('AND' => array($this->getFreeWordConditions($params['keyword'],'AND')))));
    **/
    protected function _getFreeWordConditions($freewords,$logic_operatio) {
        $freeword = str_replace('　', ' ', $freewords);
        $freeword_list = explode(' ', $freeword);
        $no_list = array();
        $column=$this->{$this->modelName}->getColumnTypes();
        $column=$this->trm_array($column);
        $cond=array();
        $_cond=array();
        $__cond=array();
        if ($logic_operatio=='OR') {
            foreach($column as $cl => $d){
                foreach ($freeword_list as $v) {
                    $v = trim($v);
                    if (!empty($v)) {
                        $cond = array_merge_recursive($cond,array(
                            'OR' => array(
                                array($cl.' like' => '%'.$v.'%'),
                                )));
                    }
                }
            }
        } else {
            $i=0;
            $j=0;
            foreach ($freeword_list as $v) {
                $f=false;
                foreach($column as $cl => $d){
                
                    $v = trim($v);
                    if (!empty($v)) {
                        $__cond =array($cl.' like' => '%'.$v.'%');
                        $i++;
                    }
                    if (empty($__cond)) {
                        $f=true;;
                        continue;
                    }
                    $_cond[$i]= $__cond;
                    $__cond=array();
                }
                    if ($f) {
                        continue;
                    }
                    $cond[$j] =array('OR' => $_cond);
                
                
                $j++;
                $_cond=array();
            }
        }
        $cond =array('AND' => $cond);
        return $cond;
    }
