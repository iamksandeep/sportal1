<table class="table table-striped">
<tbody>
<?php foreach($roleAssignments as $category => $roles) { ?>
  <tr>
    <th><?php echo ucfirst($category); ?>s</th>

    <td>
      <p>
      <?php if($roles) { ?>
      <?php foreach($roles as $role) { ?>
        <?php $this->renderPartial('/user/_nameLink', array('user' => $role->user)); ?>
        <?php
        // if in manage mode, show remove controls
        if(isset($manage) && $manage === true )
          echo CHtml::link('<i class="icon-remove"></i>', array('roles/revoke', 'id' => $role->id));
        else {
          echo CHtml::link('<i class="icon-envelope"></i>', array('message/compose', 'to' => $role->user->id, 'student_id' => $role->student_id));
          echo '&nbsp;';
          echo CHtml::link('<i class="icon-pencil"></i>', array('todo/new', 'assignee_id' => $role->user->id, 'student_id' => $role->student_id));
        }
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
