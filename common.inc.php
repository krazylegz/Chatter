<?php
function get_avatar($user) {
    $avatar = "/home/brandon/public_html/teawiki/chat/avatars/" . $user . ".jpg";
    if (!file_exists($avatar)) {
        $avatar = "/chat/avatars/Zhen+Qu.jpg";
    } else {
      $avatar = "/chat/avatars/" . $user . ".jpg";
    }
    return $avatar;
}
?>
