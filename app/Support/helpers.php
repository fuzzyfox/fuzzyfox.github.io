<?php

if (! function_exists('country2emoji')) {
    /**
     * Converts a given country code to its corresponding emoji flag.
     *
     * @param  ?string  $countryCode  The two-letter country code to be converted. If null, the function returns null.
     * @return ?string The emoji flag corresponding to the country code, or null if the input is null.
     */
    function country2emoji(?string $countryCode): ?string
    {
        if (is_null($countryCode)) {
            return null;
        }

        $countryCode = strtoupper($countryCode);

        $flag = '';
        foreach (str_split($countryCode) as $char) {
            $flag .= mb_chr(0x1F1E6 + ord($char) - ord('A'), 'UTF-8');
        }

        return $flag;
    }
}
