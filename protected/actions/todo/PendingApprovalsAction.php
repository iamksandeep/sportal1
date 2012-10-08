<?php
class PendingApprovalsAction extends CAction {
    public function run() {
        $pendingApprovals = new CActiveDataProvider('Todo', array(
          'criteria' => array(
            'join' => 'LEFT JOIN `user` `student` ON (`student`.`id` = `t`.`student_id`)
                        LEFT JOIN `role_assignment` `roleAssignments` ON (`student`.`id` = `roleAssignments`.`student_id`)',
            'condition' => 'approved = 0
                            AND roleAssignments.role = :role
                            AND roleAssignments.user_id = :userId',
            'params' => array(
                ':role' => RoleManager::getRoleId('manager'),
                ':userId' => Yii::app()->user->id,
            ),
            'order' => '
                CASE WHEN t.last_activity_time IS NULL THEN 0 ELSE 1 END DESC, t.last_activity_time DESC,
                CASE WHEN t.complete_time IS NULL THEN 0 ELSE 1 END DESC, t.complete_time DESC,
                CASE WHEN t.deadline IS NULL THEN 1 ELSE 0 END, t.deadline,
                t.initiate_time',
            ),
        ));

        $this->controller->layout = '//layouts/column1';
        $this->controller->render('pendingApprovals', array(
            'pendingApprovals' => $pendingApprovals,
        ));
    }
}
