<form class="form-search well" id="document-search-form" method="post">
    <div class="input-prepend input-append">
      <span class="add-on"><i class="icon-search"></i></span><input id="prependedInput" name="search" class="input-large search-query" value="<?php echo $s; ?>" size="16" type="text" placeholder="search for a document"><button type="submit" class="btn btn-success">Search</button><a class="btn" href="<?php echo Yii::app()->request->getUrl(); ?>"><i class="icon-remove"></i></a>
    </div>
</form>
