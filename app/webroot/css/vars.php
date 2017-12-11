<?php
//    session_start();
//    var_dump($_SESSION);
    header("Content-type: text/less");
    
    $currentPath = getcwd();
    $searchPath = "app/";
    $currentPath = substr ($currentPath, 0, strpos($currentPath, $searchPath)).$searchPath;
    
    $handle = fopen($currentPath."tmp/styleUsed.txt", "r+");
    if ($handle) {
        while (($line = fgets($handle)) !== false) {
            echo $line;
        }
        fclose($handle);
    } else {
        // error opening the file.
    } 
//    echo "@color-Menus: #2f3c42;@color-MenusText: #ffffff;\n";
//    echo "@color-MenusHover: #1462FC;\n";
//    echo "@color-Buttons: #4ea74e;\n";
//    echo "@color-Buttons-White: #CBCCCC;\n";
//    echo "@color-SubHeaders: #999999;\n";
//    echo "@color-Warning: #c12e2a;\n";
//    echo "@color-Notes: #ffffb3;\n";
//    echo "@color-black: #000000;\n";
//    echo "@color-dropdown: #313c42;\n";
//    echo "@color-menubetslip: #8A8A8A;\n";
//    echo "@color-betslip-selections-messages: #333333;\n";
//    echo "@color-betslip-panel-default: #DFDFDF;\n";
//    echo "@color-betslip-modal-header: #facc2e;\n";
//    echo "@color-caution: #030536;\n";
//    echo "@color-MenusTextBold: #fa5736;\n";
?>