<?php 
    function log_debug($message) {
        _log_with_severity($message, 'DEBUG');
    }
    function log_info($message) {
        _log_with_severity($message, 'INFO');
    }
    function log_warning($message) {
        _log_with_severity($message, 'WARNING');
    }
    function log_error($message) {
        _log_with_severity($message, 'ERROR');
    }

    function _log_with_severity($message, $severity) {
        $filepath = '../logs/' . date('Y-m-d') . '.log';
        $file = fopen($filepath, 'a') or die("can't open file");
        fwrite($file, '[' . $severity . ']: ' . $message . "\n");
        fclose($file);
    }
?>
