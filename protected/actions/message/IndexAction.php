<?php

class IndexAction extends CAction {

    public function run() {
        $this->controller->layout = "//layouts/column1";

        $sql = <<<EOD
        SELECT
        C.id AS convId,
        C.subject AS convSubject,
        (
            SELECT COUNT(id)
            FROM msg_msg
            WHERE conversation_id = C.id
        ) AS msgCount,
        (
            SELECT COUNT(id)
            FROM msg_msg
            WHERE conversation_id = C.id
        ) -
        (
            SELECT COUNT(*)
            FROM msg_msg
            LEFT JOIN msg_read
            ON msg_msg.id = msg_read.msg_id
            WHERE conversation_id = C.id
            AND msg_read.user_id = :currentUserId
        ) AS unreadCount,
        (
            SELECT MAX(send_time)
            FROM msg_msg
            WHERE conversation_id = C.id
        ) AS lastMsgTime,
        (
            SELECT content
            FROM msg_msg
            WHERE conversation_id = C.id
            ORDER BY send_time DESC
            LIMIT 1
        ) AS lastMsgContent,
        (
            SELECT id
            FROM user
            WHERE user.id = C.student_id
        ) AS studentId,
        (
            SELECT
            GROUP_CONCAT(id)
            FROM msg_conv_member
            LEFT JOIN user ON msg_conv_member.user_id = user.id
            WHERE conv_id = C.id
            AND user_id <> :currentUserId
        ) AS members
        FROM msg_conv C
        LEFT JOIN msg_conv_member M
        ON C.id =M.conv_id
        WHERE M.user_id = :currentUserId
        ORDER BY lastMsgTime DESC
EOD;
        $cmd = Yii::app()->db->createCommand($sql);
        $cmd->bindValue(':currentUserId', Yii::app()->user->id, PDO::PARAM_INT);
        $conversations = $cmd->queryAll();

        $this->controller->render('index', array(
            'conversations' => $conversations,
        ));
    }
}
