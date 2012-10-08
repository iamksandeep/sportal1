<?php

class RoleManager {

    private $student;

    /**
     * @return array student Roles
     */
    static public function getRoles() {
        return array(
            0 => 'manager',
            1 => 'researcher',
            2 => 'counselor',
            3 => 'content-writer',
        );
    }

    public function __construct($student) {
        $this->student = $student;
    }

    /**
    * @param  int $userId Id of user to check
    * @param  String $role   Role name
    * @return boolean        If a user is assigned given role for this student
    */
    public function hasRole($userId, $role) {
        return (bool)RoleAssignment::model()->findByAttributes(array(
                'student_id' => $this->student->id,
                'user_id' => $userId,
                'role' => self::getRoleId($role),
        ));
    }

    /**
    * Assigns given user id a given role for this student
    * @param  int $userId Id of user to assign
    * @param  String $role   Role name
    * @return boolean         whether assignment was successful
    */
    public function assignRole($userId, $role) {
        if(!$this->hasRole($userId, $role)) {
            $roleA = new RoleAssignment();

            $roleA->student_id = $this->student->id;
            $roleA->user_id = $userId;
            $roleA->role = self::getRoleId($role);

            return $roleA->save();
        }
        return false;
    }

    /**
    * Removes given user id from given role for this student
    * @param  int $userId Id of user to assign
    * @param  String $role   Role name
    * @return boolean         whether removal was successful
    */
    public function removeRole($userId, $role) {
      return (bool)(RoleAssignment::model()->deleteAllByAttributes(array(
                'student_id' => $this->student->id,
                'user_id' => $userId,
                'role' => self::getRoleId($role),
        )) > 0);
    }

    /**
    * @param  String $role   Role name
    * @return boolean whether users in given role exist
    */
    public function hasUsersInRole($role) {
        return (bool)(sizeof(RoleAssignment::model()->findAllByAttributes(array(
                'student_id' => $this->student->id,
                'role' => self::getRoleId($role),
        ))) > 0);
    }

    /**
    * @param  String $role   Role name
    * @return array users in given role
    */
    public function getAssignmentsInRole($role) {
        return RoleAssignment::model()->findAllByAttributes(array(
                'student_id' => $this->student->id,
                'role' => self::getRoleId($role),
        ));
    }

    /**
    * @return array All roles
    */
    public function getAll() {
        return RoleAssignment::model()->findAllByAttributes(array(
                'student_id' => $this->student->id,
        ));
    }

    /**
     * @param  String $roleName
     * @return int         id of given role name
     */
    static public function getRoleId($roleName) {
        foreach(self::getRoles() as $id => $name) {
            if($roleName == $name)
                return $id;
        }
        return -1;
    }

    /**
     * @return String Role name for given id
     */
    static public function getRoleName($roleId) {
        $roles =  self::getRoles();
        return $roles[$roleId];
    }

    /**
     * Given a set of roles data for a student, groups under role types
     * @param  Array $roles roles data
     * @return Array        roles data grouped by role types
     */
    static public function groupRoles($roles) {
      $groupedRoles = array(
        'manager' => array(),
        'researcher' => array(),
        'counselor' => array(),
        'content-writer' => array(),
      );

      foreach($roles as $role) {
        foreach($groupedRoles as $key => $val) {
          if($role->role0 == $key) {
            array_push($groupedRoles[$key], $role);
          }
        }
      }

      return $groupedRoles;
    }
}
