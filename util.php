<?php
    function sanitize_POST($key) {
        return isset($_POST[$key]) ? htmlentities($_POST[$key], ENT_QUOTES) : '';
    }
?>
