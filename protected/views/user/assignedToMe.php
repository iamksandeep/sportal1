<?php
// get current user object to reduce db calls
if(!isset($currentUser)) $currentUser = User::model()->findByPk(Yii::app()->user->id);
?>

<?php
$this->breadcrumbs=array(
    'Users' => array('user/index'),
    'Students assigned to me',
); ?>

<div class="row-fluid">
<div class="span8"><h1>Students assigned to me</h1></div>
<div class="span4">
<?php $this->widget('bootstrap.widgets.BootButton', array(
    'label'=>'View complete user list',
    'type' => 'primary',
    'icon' => 'list white',
    'url' => array('user/index'),
    'htmlOptions' => array('class' => 'pull-right'),
)); ?>
</div>
</div>
<br />

<?php $this->renderPartial('_searchForm', array(
      'currentUser' => $currentUser,
      's' => $s,
)); ?>

<div class="tabbable tabs-left">
<!-- tabs -->
<ul class="nav nav-tabs" id="roleTabs">
<?php $first = true; ?>
<?php foreach($dataProviders as $role => $studentdata) { ?>
  <li <?php if($first) {
            echo 'class = "active"';
            $first = false;
            } ?>>
  <a href="#role_<?php echo $role; ?>" data-toggle="tab">
    <span class="badge"><?php echo $studentdata->totalItemCount; ?></span>
    <?php echo $role; ?>
  </a>
  </li>
<?php } ?>
</ul>

<!-- tab content -->
<div class="tab-content">
    <?php $first = true; ?>
    <?php foreach($dataProviders as $role => $studentdata) { ?>
    <div class="tab-pane <?php if($first) {
            echo 'active';
            $first = false;
            } ?>" id="role_<?php echo $role; ?>">
        <?php $this->widget('zii.widgets.CListView', array(
          'dataProvider'=>$studentdata,
          'itemView'=>'/user/_view',
          'summaryText' => '{count} students',
          'emptyText' => '(no students)',
        )); ?>
    </div>
    <?php } ?>
</div>
</div>
