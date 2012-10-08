<?php


class MarkAsReadFilter extends CFilter {

    public $controller;

    public function postFilter() {
        // mark all messages as read
        if(isset($this->controller->todo))
            $this->controller->todo->markAsRead();
    }
}
