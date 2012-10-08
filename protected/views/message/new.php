<h2>New Message</h2>

<div class="new-message">
<form action="<?php echo CHtml::normalizeUrl(array('message/new')); ?>" id="new-message-form" class="form" method="post">
    <hr />
    <div class="row-fluid">
        <div class="span2">
            <label>Send message to: </label>
            <a href="#userSearch" role="button" class="btn btn-danger add-user" data-toggle="modal"><i class="icon-plus icon-white"></i> Add recipients</a>
        </div>
        <div class="span10 selected-users">
        </div>
    </div>

    <hr />
    <div class="row-fluid">
        <div class="span2">
            <label>Subject: </label>
        </div>
        <div class="span10">
            <input class="text" name="Message[subject]" value="<?php if(isset($msgData['subject'])) echo $msgData['subject']; ?>" />
        </div>
    </div>

    <hr />
    <div class="row-fluid">
        <div class="span2">
            <label>Message: </label>
        </div>
        <div class="span10">
            <textarea class="markItUp" name="Message[content]"><?php if(isset($msgData['content'])) echo $msgData['content']; ?></textarea>
        </div>
    </div>

    <hr />
    <div class="row-fluid">
        <div class="span2"><label>Is this message about a student</label></div>
        <div class="span10">
            <label class="radio">
              <input type="radio" id="hasStudentContext_no" name="Message[hasStudentContext]" value="no" checked>
              No
            </label>
            <label class="radio">
              <input type="radio"  id="hasStudentContext_yes" name="Message[hasStudentContext]" value="yes">
              Yes
            </label>
        </div>
    </div>

    <div id="student-selection" class="hidden">
    <hr />
    <div class="row-fluid">
        <div class="span2"><label>Which student is this message about?</label></div>
        <div class="span10">
            <?php echo CHtml::dropDownList('Message[student_id]', 'id', CHtml::listData(User::getStudentUsers(), 'id', 'name')); ?>
        </div>
    </div>
    </div>

    <hr />
    <div class="row-fluid">
        <div class="span2"></div>
        <div class="span10">
        <button type="submit" class="btn btn-large btn-primary"><i class="icon-envelope icon-white"></i> Send Message</button>
        </div>
    </div>
</form>

<div id="userSearch" class="modal hide fade user-search">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3>Select recipients</h3>

    <div class="input-prepend input-append">
      <span class="add-on"><i class="icon-search"></i></span><input id="prependedInput" name="search" class="input-xlarge search-query" size="16" type="text" placeholder="enter a name or email to search for a user"><button type="button" class="btn btn-success search">Search</button><button type="button" class="btn clear"><i class="icon-remove"></i></button>
    </div>
  </div>
  <div class="modal-body">
    <div class="results">

    </div>
  </div>
  <div class="modal-footer">
    <a href="#" class="btn btn-primary" data-dismiss="modal" >Done</a>
  </div>
</div>
</div>

<script type="text/javascript">

(function($) {
    // when search is clicked
    $(".user-search button.search").bind("click", function() {
        startSearch();
    });

    // or when enter press
    $(".user-search input").keypress(function(e) {
        if(e.which == 13) {
            startSearch();
        }
    });

    // when clear is clicked in
    $(".user-search button.clear").bind("click", function() {
        clearSearchList();
    });

    function startSearch() {
        // get input keyword
        $searchKey = $(".user-search .search-query").val();

        // send query
        $.post("<?php echo CHtml::normalizeUrl(array('user/search')); ?>", {
            'search': $searchKey,
        }, function(results) {
            userdata = eval(results);
            listResults(userdata);
        });
    }

    function clearSearchList() {
        // blank out search
        $(".user-search .search-query").val("");

        // remove results
        $('.user-search .results').html("");
    }

    // list results
    function listResults(res) {
        var htmlData = "";
        for(var i = 0; i < res.length; i++) {
            htmlData = htmlData + "<div class=\"user\" data-id=\"" + res[i].id + "\">";
            htmlData = htmlData + "<i class=\"icon\"></i> ";
            htmlData = htmlData + "<img src=\"" + res[i].gravatarUrl + "\" /> ";
            htmlData = htmlData + res[i].name;
            if(res[i].type == 'student') {
                htmlData = htmlData + " <span class=\"muted\"><em>(student)</em></span>";
            }
            htmlData = htmlData + "</div>";
        }

        $('.user-search .results').html(htmlData);
    }

    $(".user-search .results .user").live("click", function() {
        if($(this).hasClass("selected")) {
            $(this).removeClass("selected");
            $(this).find("i").removeClass("icon-ok");
            $selectedUsr = $(".selected-users .user[data-id=\"" + $(this).data("id") + "\"]");
            removeUserFromList($selectedUsr);
        }
        else {
            $(this).addClass("selected");
            $(this).find("i").addClass("icon-ok");
            addUserToList($(this));
        }
    });

    $(".selected-users .user").live("click", function() {
        removeUserFromList($(this));
    });

    function addUserToList($usr) {
        $selectedUsersArea = $(".selected-users");

        // check if this does not already exist
        // if so, exit
        $existingUsr = $selectedUsersArea.find(".user[data-id='" + $usr.data("id") + "']");
        if($existingUsr.length > 0) return;

        // add to selected users area
        sUser = "";
        sUser += "<div class=\"user\" data-id=\"" + $usr.data("id") + "\">";
        sUser += "</div>";
        $selectedUsersArea.append(sUser);

        // edit some properties
        $newSelectedUser = $selectedUsersArea.find(".user[data-id='" + $usr.data("id") + "']");
        $newSelectedUser.html($usr.html());
        $newSelectedUser.find("i").removeClass("icon-ok");
        $newSelectedUser.find("i").addClass("icon-remove");

        // add hidden field
        $('<input>').attr({
            type: 'hidden',
            name: 'Message[user][' + $usr.data("id") + ']',
            value: '' + $usr.data("id") + ''
        }).appendTo('#new-message-form');
    }

    function removeUserFromList($usr) {
        // find hiddent field and remove that too
        $("#new-message-form input[name=\"Message[user][" + $usr.data("id") + "]\"]").remove();

        $usr.remove();
    }

    $('#hasStudentContext_yes').live('click', function() {
        $('#student-selection').removeClass("hidden");
    });
    $('#hasStudentContext_no').live('click', function() {
        $('#student-selection').addClass("hidden");
    });
})(jQuery);

</script>

<?php $this->renderPartial('/common/_markItUp'); ?>
