<?php

class SecurePassword {

  private $password;
  private $salt;

  public function __construct($password, $salt) {
    if(!$salt)
      $salt = self::newSalt();

    $this->salt = $salt;
    $password = $password.$this->salt;
    $this->password = hash( 'sha512', $password );
  }

  /**
   * @return String   A random salt
   */
  static public function newSalt() {
    $size = mcrypt_get_iv_size(MCRYPT_CAST_256, MCRYPT_MODE_CFB);
    return bin2hex(mcrypt_create_iv($size, MCRYPT_DEV_URANDOM));
  }

  /**
   * @return String   Salt
   */
  public function getSalt() {
    return $this->salt;
  }

  /**
   * @return String   Secure password
   */
  public function getPassword() {
    return $this->password;
  }
}