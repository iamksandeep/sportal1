<?php
class RbacCommand extends CConsoleCommand
{
  private $_authManager;

  public function getHelp()
  {
    return <<<EOD
    USAGE
    rbac
    DESCRIPTION
    This command generates an initial RBAC authorization hierarchy.
EOD;
  }

  /**
  * Execute the action.
  * @param array command line parameters specific for this command
  */
  public function run($args)
  {
    //ensure that an authManager is defined as this is mandatory for creating an auth heirarchy
    if(($this->_authManager=Yii::app()->authManager)===null)
    {
      echo "Error: an authorization manager, named 'authManager' must be configured to use this command.\n";
      echo "If you already added 'authManager' component in application configuration,\n";
      echo "please quit and re-enter the yiic shell.\n";
      return;
    }

    //provide the oportunity for the use to abort the request
    echo "This command will create roles and permissions:\n";
    echo "Would you like to continue? [Yes|No] ";

    //check the input from the user and continue if they indicated yes to the above question
    if(!strncasecmp(trim(fgets(STDIN)),'y',1))
    {
      // get auth
      $auth = $this->_authManager;

      //first we need to remove all operations, roles, child relationship and assignments
      $auth->clearAll();

      // default roles
      $bizRule='return !$params["currentUser"]->isGuest;';
      $auth->createRole('authenticated', 'authenticated user', $bizRule);
      $bizRule='return $params["currentUser"]->isGuest;';
      $auth->createRole('guest', 'guest user', $bizRule);

      // operations
      include(dirname(__FILE__).'/operationSets/all.php');
      // roles
      include(dirname(__FILE__).'/roles/all.php');

      // mass assignment
      $users = User::model()->findAll();
      foreach ($users as $u) {
        $u->assignRoles();
      }

      //provide a message indicating success
      echo "Authorization hierarchy successfully generated.";
    }
  }
}
