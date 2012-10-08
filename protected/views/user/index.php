<?php
// get current user object to reduce db calls
if(!isset($currentUser)) $currentUser = User::model()->findByPk(Yii::app()->user->id);
?>

<?php
$this->breadcrumbs=array(
    'Users',
); ?>

<div class="row-fluid">
<div class="span8"><h1>User List</h1></div>
<div class="span4">
    <?php $this->renderPartial('_addUserButton', array('currentUser' => $currentUser)); ?>
    <?php $this->widget('bootstrap.widgets.BootButton', array(
        'label'=>'View students assigned to me',
        'type' => 'primary',
        'icon' => 'list white',
        'url' => array('user/assignedToMe'),
        'htmlOptions' => array('class' => 'pull-right'),
    )); ?>
</div>
</div>
<br />

<div class="row-fluid">
<?php $this->renderPartial('_searchForm', array(
      'currentUser' => $currentUser,
      's' => $s,
)); ?>
</div>


<ul class="nav nav-tabs" id="userTypes">
  <li class="active">
    <a href="#allstudents" data-toggle="tab">
    <i class='icon-user'></i> All students (<?php echo $userData['allstudents']->totalItemCount; ?>)
    </a>
  </li>
  <li>
    <a href="#ugstudents" data-toggle="tab">
    <i class='icon-user'></i> UG students (<?php echo $userData['ug']->totalItemCount; ?>)
    </a>
  </li>
  <li>
    <a href="#pgstudents" data-toggle="tab">
    <i class='icon-user'></i> PG students (<?php echo $userData['pg']->totalItemCount; ?>)
    </a>
  </li>
  <li>
    <a href="#mnemonic" data-toggle="tab">
    <i class='icon-user'></i> Mnemonic users (<?php echo $userData['mnemonic']->totalItemCount; ?>)
    </a>
  </li>
</ul>


<!-- tab content -->
<div class="tab-content">
    <div class="tab-pane active" id="allstudents">
    <?php $this->widget('zii.widgets.CListView', array(
      'dataProvider'=>$userData['allstudents'],
      'itemView'=>'/user/_view',
      'summaryText' => '',
    )); ?>
    </div>
    <div class="tab-pane" id="ugstudents">
    <?php $this->widget('zii.widgets.CListView', array(
      'dataProvider'=>$userData['ug'],
      'itemView'=>'/user/_view',
      'summaryText' => '',
    )); ?>
    </div>
    <div class="tab-pane" id="pgstudents">
    <?php $this->widget('zii.widgets.CListView', array(
      'dataProvider'=>$userData['pg'],
      'itemView'=>'/user/_view',
      'summaryText' => '',
    )); ?>
    </div>
    <div class="tab-pane" id="mnemonic">
    <?php $this->widget('zii.widgets.CListView', array(
      'dataProvider'=>$userData['mnemonic'],
      'itemView'=>'/user/_view',
      'summaryText' => '',
    )); ?>
    </div>
</div>
