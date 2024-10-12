<?php
function renderButton($text, $type = 'submit', $disabled = false, $task_id = null, $action = null) {
    $disabledAttribute = $disabled ? ' disabled' : '';
    $dataAttributes = $action ? "data-action=\"action\" data-task-id=\"$task_id\"" : "";

    echo "
        <button
            type=\"$type\"
            $disabledAttribute
            class=\"button-class\"
            $dataAttributes
        >
            $text
        </button>
    ";
}