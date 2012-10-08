<?php

class UserTest extends CDbTestCase {

  public $fixtures = array(
    'users' => 'User',
  );

  public function testPasswordEncryption() {
    $password = 'test';

    $newUser = new User('add');
    $newUser->attributes = array(
      'name_first' => 'Test',
      'name_last' => 'User',
      'email' => 'testmail@example',
      'password' => $password,
      'password_repeat' => $password,
      'type' => 0,
    );
    $this->assertTrue($newUser->save());
    $this->assertNotEquals($newUser->password, 'test');
    $this->assertTrue($newUser->checkPassword('test'));
  }

  public function testChangePassword() {
    $user = $this->users('user1');
    $newPassword = 'new password';
    $user->changePassword($newPassword);
    $this->assertTrue($user->checkPassword($newPassword));
  }
}