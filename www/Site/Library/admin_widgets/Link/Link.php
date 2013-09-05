<?php
/**
 * Действие-переключатель призанка is_link
 * @version 1.0
 */
namespace Library\admin_widgets\Link;

use Library\admin_widgets\ToggleAction\ToggleAction;

class Link extends ToggleAction
{
    protected function initState()
    {
        /** @var \Boolive\data\Entity $object */
        $object = is_array($this->_input['REQUEST']['object'])? reset($this->_input['REQUEST']['object']) : $this->_input['REQUEST']['object'];
        $this->_state = $object->isLink();
    }

    public function toggle()
    {
        $result = array();
        // Изменение признака is_hidden
        $objects = is_array($this->_input['REQUEST']['object'])? $this->_input['REQUEST']['object'] : array($this->_input['REQUEST']['object']);
        if ($first = reset($objects)){
            $result['changes'] = array();
            $link = !$first->isLink();
            foreach ($objects as $o){
                /** @var \Boolive\data\Entity $o */
                $o->isLink($link);
                // @todo Обрабатывать ошибки
                $o->save();
                $result['changes'][$o->uri()] = array(
                    'is_link' => $o->isLink()
                );
            }
            $result['state'] = $first->isLink();
        }
        return $result;
    }
}