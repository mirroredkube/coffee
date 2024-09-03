<?php

if (!function_exists('getInitials')) {
    function getInitials($name)
    {
        $nameParts = explode(' ', $name);
        $initials = '';

        foreach ($nameParts as $part) {
            $initials .= strtoupper(substr($part, 0, 1));
        }

        return $initials;
    }
}