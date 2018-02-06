<?php
function h($str)
{
        $s = htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
        return $s;
}

;
