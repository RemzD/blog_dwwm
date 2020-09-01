<?php

function formatTestLine() {
    if (filter_input(INPUT_SERVER, 'REQUEST_METHOD')) {
        return function ($name, $description, $status) {
            echo '<style>
                    .ok {color: green}
                    .echec {color: red}
                  </style>
                 ';
            echo "<p>";
            echo "<span class='" . $status. "'>$status: </span>";
            echo "$name: $description";
            echo "</p>";
        };
    }

    return function ($name, $description, $status) {
        printf("%6s: %s: %s\n", $status, $name, $description);
    };
}

$formatTestLine = formatTestLine();
