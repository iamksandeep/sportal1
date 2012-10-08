<!doctype html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<link rel="stylesheet/less" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/css/style.less">
<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>
  <header>
    <div class="navbar navbar-fixed-top">
    <div class="navbar-inner">
      <!-- .btn-navbar is used as the toggle for collapsed navbar content -->
      <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      </a>

      <a class="brand" href="<?php echo CHtml::normalizeUrl(array('site/index')); ?>"> Applix</a>

      <?php if(!Yii::app()->user->isGuest) { ?>
      <div class="nav-collapse">
      <ul class="nav">
          <!-- messages -->
          <li>
            <a href="<?php echo CHtml::normalizeUrl(array('message/index')); ?>">
            <span class="label label-inverse">
            <i class="icon icon-envelope icon-white"></i>
            <span class="badge badge-important" id="msgCount"></span>
            </span>
            Messages
            </a>
          </li>

          <li class="divider-vertical"></li>

          <!-- todo -->
          <li>
            <a href="<?php echo CHtml::normalizeUrl(array('todo/index')); ?>">
            <span class="label label-inverse">
            <i class="icon icon-pencil icon-white"></i>
            <span class="badge badge-inverse" id="todoCount"></span>
            <span class="badge badge-warning" id="activityCount"></span>
            <span class="badge badge-success" id="approvalsCount"></span>
            </span>
            Tasks
            </a>
          </li>

          <li class="divider-vertical"></li>

          <!-- notifications -->
          <li>
            <a href="<?php echo CHtml::normalizeUrl(array('notification/index')); ?>">
            <span class="label label-inverse">
            <i class="icon icon-info-sign icon-white"></i>
            <span class="badge badge-inverse" id="notificationCount"></span>
            </span>
            Notifications
            </a>
          </li>
      </ul>
      <?php } ?>

      <ul class="nav pull-right">
      <?php if(!Yii::app()->user->isGuest) { ?>

        <?php if(Yii::app()->user->type !== 'student') { ?>
        <!-- user list -->
        <li class="dropdown">
              <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                <i class="icon icon-list icon-white"></i>
                Students
                <span class="caret"></span>
              </a>
              <ul class="dropdown-menu">
                <a href="<?php echo CHtml::normalizeUrl(array('user/assignedToMe')); ?>">
                Students assigned to me
                </a>
                <a href="<?php echo CHtml::normalizeUrl(array('user/index')); ?>">
                All users
                </a>
              </ul>
        </li>
          <li class="divider-vertical"></li>
        <!-- all applications -->
        <li>
            <a href="<?php echo CHtml::normalizeUrl(array('application/listAll')); ?>">
            <i class="icon-folder-open icon-white"></i>
            Applications
            </a>
        </li>
          <li class="divider-vertical"></li>
        <!-- all activity -->
        <li>
            <a href="<?php echo CHtml::normalizeUrl(array('activity/listAll')); ?>">
            <i class="icon icon-comment icon-white"></i>
            Activity
            </a>
        </li>
        <?php } else { ?>
        <!-- Help -->
        <li>
            <a href="<?php echo CHtml::normalizeUrl(array('help/index')); ?>">
            <i class="icon icon-question-sign icon-white"></i>
            Help
            </a>
        </li>
        <?php } ?>

        <li class="divider-vertical"></li>

        <!-- account options -->
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
          <?php echo Yii::app()->user->gravatarAndName; ?>
          <b class="caret"></b>
          </a>

          <ul class="dropdown-menu">
          <!-- my profile -->
          <li>
            <?php echo CHtml::link('<i class="icon-user"></i> Profile', array('user/view', 'id' => Yii::app()->user->id)); ?>
          </li>
          <!-- log out -->
          <li>
            <?php echo CHtml::link('<i class="icon-off"></i> Sign out', array('site/logout')); ?>
          </li>
          </ul>
        </li>
      <?php } ?>
      </ul>
      </div>

    </div>
  </div>


  </header>

  <div class="container">
    <?php
    // breadcrumbs
    if(isset($this->breadcrumbs))
    $this->widget('bootstrap.widgets.BootBreadcrumbs', array('links'=> $this->breadcrumbs));
    ?>
    <?php echo $content; ?>
  </div><!-- container -->

  <footer>
    <hr />
    <center>
    <a href="http://mnemoniceducation.com" target="_blank" title="Mnemonic Education Pvt. Ltd.">
    <img src="<?php echo Yii::app()->baseUrl; ?>/img/logo-server.png" alt="Mnemonic Education Pvt. Ltd."/>
    </a>
    </center>
  </footer>

  <?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
  <?php Yii::app()->clientScript->registerCoreScript('jquery.ui'); ?>
  <?php Yii::app()->clientScript->registerCssFile(Yii::app()->clientScript->getCoreScriptUrl() . '/jui/css/base/jquery-ui.css' ); ?>
  <?php Yii::app()->clientScript->registerScriptFile( Yii::app()->baseUrl . '/js/less-1.3.0.min.js' ); ?>

<!-- notify refresh script -->
<script type="text/javascript">
function refreshTodoCount() {
  $.get("<?php echo CHtml::normalizeUrl(array('todo/pendingCount')); ?>", function(count) {
    $("#todoCount").html(count);
    if(count > 0) $("#todoCount").show();
    else $("#todoCount").hide();
  });
}
refreshTodoCount();
setInterval(refreshTodoCount, 15000);

function refreshNewTodo() {
  $.get("<?php echo CHtml::normalizeUrl(array('todo/anyNewTasks')); ?>", function(count) {
    if(count > 0) {
      $("#todoCount").removeClass("badge-inverse");
      $("#todoCount").addClass("badge-info");
    }
    else {
      $("#todoCount").removeClass("badge-info");
      $("#todoCount").addClass("badge-inverse");
    }
  });
}
refreshNewTodo();
setInterval(refreshNewTodo, 15000);

function refreshActivityCount() {
  $.get("<?php echo CHtml::normalizeUrl(array('todo/activityCount')); ?>", function(count) {
    $("#activityCount").html(count);
    if(count > 0) $("#activityCount").show();
    else $("#activityCount").hide();
  });
}
refreshActivityCount();
setInterval(refreshActivityCount, 15000);

function refreshApprovalCount() {
  $.get("<?php echo CHtml::normalizeUrl(array('todo/pendingApprovalsCount')); ?>", function(count) {
    $("#approvalsCount").html(count);
    if(count > 0) $("#approvalsCount").show();
    else $("#approvalsCount").hide();
  });
}
refreshApprovalCount();
setInterval(refreshApprovalCount, 15000);

function refreshMessageCount() {
  $.get("<?php echo CHtml::normalizeUrl(array('message/unreadCount')); ?>", function(count) {
    $("#msgCount").html(count);
    if(count > 0) $("#msgCount").show();
    else $("#msgCount").hide();
  });
}
refreshMessageCount();
setInterval(refreshMessageCount, 15000);

function refreshNotificationCount() {
  $.get("<?php echo CHtml::normalizeUrl(array('notification/unacknowledgedCount')); ?>", function(count) {
    $("#notificationCount").html(count);
    if(count > 0) $("#notificationCount").show();
    else $("#notificationCount").hide();
  });
}
refreshNotificationCount();
setInterval(refreshNotificationCount, 15000);

</script>

  <!-- Asynchronous Google Analytics snippet. -->
  <script>
    // UNCOMMENT WHEN LIVE
    /*
    var _gaq=[['_setAccount','UA-XXXXX-X'],['_trackPageview']];
    (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
    g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
    s.parentNode.insertBefore(g,s)}(document,'script'));
    */
  </script>

</body>
</html>

