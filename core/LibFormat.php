<?php 


namespace Model;

class LibFormat extends Model {

    public static function strEmptyToNull($value) {


        if (is_null($value)) {
            return "NULL"; 
        }
    
        if (is_string($value)) {
            $value = trim($value);
        }

        if ($value === '' || $value === false) {
            return "NULL"; 
        }

        $sanitizedValue = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
        $sanitizedValue = addslashes($sanitizedValue);

        return "'$sanitizedValue'";
    }

public static function intEmptyToNull($value) {
    
    if ($value === null || !is_numeric($value)) {
        return "NULL";
    }

    $sanitizedValue = filter_var($value, FILTER_SANITIZE_NUMBER_INT);

    if ($sanitizedValue === '' || $sanitizedValue === false) {
        return "NULL";
    }

    return (int)$sanitizedValue;
}
}