<?php

if (function_exists('xdebug_info')) {
    var_dump(xdebug_info('mode'));
}
else {
    echo "xdebug_info() no está disponible.\n";
}

if (function_exists('xdebug_is_debugger_active')) {
    if (xdebug_is_debugger_active()) {
        echo "Xdebug está activo";
    }
    else {
        echo "Xdebug no está activo";
    }
}
else {
    echo "xdebug_is_debugger_active() no está disponible. Xdebug podría no estar instalado o habilitado en este entorno.";
}

?>