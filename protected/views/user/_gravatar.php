<?php
    $emailHash = md5(strtolower(trim($user->email)));
    $imgUrl = 'http://www.gravatar.com/avatar/'.$emailHash.'.jpg?d=identicon&r=g';

    if(isset($size))
      $imgUrl .= '&s='.$size;

    echo CHtml::image($imgUrl, CHtml::encode($user->name));
?>
