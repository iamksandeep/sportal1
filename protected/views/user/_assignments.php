<table class="table table-striped table-bordered table-condensed">
<tbody>
<?php foreach($roleAssignments as $category => $roles) { ?>
  <tr>
    <td><?php echo $category; ?>s</td>

    <td>
      <p>
      <?php if($roles) { ?>
      <?php foreach($roles as $role) { ?>
        <?php $this->renderPartial('/user/_gravatar', array(
            'user' => $role->user,
            'size' => 14,
        )); ?>
        <?php echo CHtml::link(CHtml::encode($role->user->name), array('user/view', 'id' => $role->user->id)); ?>
        <?php
        // if in manage mode, show remove controls
        if(isset($manage) && $manage === true )
          echo CHtml::link('<i class="icon-remove"></i>', array('roles/revoke', 'id' => $role->id));
        ?>
        &nbsp;&nbsp;&nbsp;&nbsp;
      <?php } ?>
      </ul>
      <?php } else { ?>
        <small></em>(nobody assigned)</em></small>
      <?php } ?>
    </p>
    </td>
  </tr>
<?php } ?>
</tbody>
</table>

<?php $this->widget('bootstrap.widgets.BootButton', array(
    'label'=>'Manage roles',
    'icon' => 'user',
    'url' => array('roles/manage', 'student_id' => $student->id),
)); ?><br /><br />
