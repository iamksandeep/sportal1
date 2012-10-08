<?php
class PendingApprovalsCountAction extends CAction {
    public function run() {
        echo Todo::pendingApprovalsCount();
    }
}
