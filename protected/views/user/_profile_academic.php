<div class="well well-small">
<?php
// get current user object to reduce db calls
if(!isset($currentUser)) $currentUser = User::model()->findByPk(Yii::app()->user->id);
?>

<h4>Academic background</h4>
<?php
$manageAccess = Yii::app()->user->checkAccess('manageAcademicDetails', array(
        'student' => $data,
        'currentUser' => $currentUser,
));
?>
<?php if($manageAccess) { ?>
<div class="pull-right">
    <?php echo CHtml::link('add',
    array('academicDetail/add', 'student_id' => $data->id)); ?>
</div>
<?php } ?>

<?php
$columns = array(
    'level0',
    'institution',
    'board_univ',
    'score',
    'year',
);
if($manageAccess) {
    array_push($columns, array(
            'name' => '',
            'value' => 'CHtml::link("<i class=\"icon-edit\"></i>", array("academicDetail/edit", "id" => $data->id))',
            'type' => 'raw',
        ));
    array_push($columns, array(
            'name' => '',
            'value' => 'CHtml::link("<i class=\"icon-trash\"></i>", array("academicDetail/delete", "id" => $data->id))',
            'type' => 'raw',
        ));
}
?>
<?php $this->widget('bootstrap.widgets.BootGridView', array(
    'type'=>'condensed',
    'dataProvider'=>$academicData,
    'columns'=>$columns,
    'summaryText' => '',
    'emptyText' => '',
    'enableSorting' => false,
    'showTableOnEmpty' => false,
)); ?>
</div>
