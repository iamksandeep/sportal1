<div class="well well-small">
<?php
// get current user object to reduce db calls
if(!isset($currentUser)) $currentUser = User::model()->findByPk(Yii::app()->user->id);
?>

<?php
$authCode = 'manageProfile' . ucfirst($category) . 'Details';
$manageAccess = Yii::app()->user->checkAccess($authCode, array(
        'student' => $data,
        'currentUser' => $currentUser,
));
?>

<h4><?php echo ucfirst($category); ?> information</h4>

<?php if($manageAccess) { ?>
<div class="pull-right">
    <?php echo CHtml::link('add',
    array('profileDetail/add', 'student_id' => $data->id, 'category' => ProfileDetail::getCategoryId($category))); ?>
    /
    <?php echo CHtml::link('default set',
    array('profileDetail/defaultSet', 'student_id' => $data->id, 'category' => ProfileDetail::getCategoryId($category))); ?>
</div>
<?php } ?>
<?php
$columns = array(
    'title',
    array(
        'name' => 'content',
        'value' => 'strip_tags(trim($data->content)) != "" ? $data->content : "<p class=\"muted\">not-set</p>"',
        'type' => 'raw',
    ),
);
if($manageAccess) {
    array_push($columns, array(
            'name' => '',
            'value' => 'CHtml::link("<i class=\"icon-edit\"></i>", array("profileDetail/edit", "id" => $data->id)).
                        " ".
                        CHtml::link("<i class=\"icon-trash\"></i>", array("profileDetail/delete", "id" => $data->id))',
            'type' => 'raw',
        ));
}
?>
<?php $this->widget('bootstrap.widgets.BootGridView', array(
    'type'=>'condensed',
    'dataProvider'=>$dataProvider,
    'columns'=>$columns,
    'summaryText' => '',
    'emptyText' => '',
    'hideHeader' => true,
    'showTableOnEmpty' => false,
)); ?>
</div>
