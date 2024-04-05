<?php

if (isset($message)) {
    foreach ($message as $msg) {
        if ($msg) {
            echo '
      <div class="message">
         <span>' . $msg . '</span>
         <ion-icon name="close-outline" onclick="this.parentElement.remove();"></ion-icon>
      </div>
      ';
        }
    }
}