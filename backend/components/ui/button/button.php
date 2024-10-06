<?php
function renderButton($text, $type = 'submit', $disabled = false) {
    $disabledAttribute = $disabled ? ' disabled' : '';

    echo "
        <button
            type=\"$type\"
            $disabledAttribute
            class=\"button-class\">
            $text
        </button>
    ";
}