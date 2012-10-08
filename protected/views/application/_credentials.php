<?php
// get current user object to reduce db calls
if(!isset($currentUser)) $currentUser = User::model()->findByPk(Yii::app()->user->id);
?>

<?php if(Yii::app()->user->checkAccess('viewUniversityCredentials', array(
        'student' => $model->student,
        'currentUser' => $currentUser,
      ))) { ?>

<div class="well well-small">
    <?php
        $hasDetails = $hasUrl = false;
        if($model->credentials) {
            $hasDetails = strip_tags(trim($model->credentials->details));
            $hasUrl = strip_tags(trim($model->credentials->url));
        }

    ?>
    <h3>University portal login details</h3>

    <?php if(Yii::app()->user->checkAccess('editUniversityCredentials', array(
            'student' => $model->student,
            'currentUser' => $currentUser,
          ))) { ?>
    <div class="pull-right">
        <?php echo CHtml::link('edit', array('universityCredential/edit', 'application_id' => $model->id)); ?>
    </div>
    <?php } ?>


    <table class="table table-condensed">
        <tr>
            <th>Credentials:</th>
            <td>
            <?php if($model->credentials && $hasDetails) { ?>
                <div class="university-credentials">
                <?php echo  $model->credentials->details; ?>
                </div>
                <?php $this->widget('bootstrap.widgets.BootButton', array(
                    'label'=>'click here to show',
                    'icon' => 'lock white',
                    'type' => 'danger',
                    'size' => 'mini',
                    'htmlOptions' => array('class' => 'show-university-credentials'),
                )); ?>
            <?php } else { ?>
            <p class="muted">not set</p>
            <?php } ?>
            </td>
        </tr>
        <tr>
            <th>Url</th>
            <td><?php echo ($model->credentials && $hasUrl) ? '<a href="'.$model->credentials->url.'" target="_blank">'.$model->credentials->url.'</a>' : '<p class="muted">not set</p></td>'; ?></td>
        </tr>
    </table>

</div>

<?php } ?>

<?php Yii::app()->getClientScript()->registerScriptFile(Yii::app()->baseUrl.'/js/show_credentials.js'); ?>
