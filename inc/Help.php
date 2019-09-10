<?php

class Help {

     /************************************************************************
    * Description: User can choose whether to clear or format phone number.
    ************************************************************************/
    public static function preparePhone($phone, $clear = false, $ddi = false) {
        
        if(!$clear) {
            return self::formatPhone($phone, $ddi);
        }

        return self::clearPhone($phone, $ddi);
    }

	/************************************************************************
    * Description: Remove all special characters and leave only numbers.
    * Remove DDI if desired and remove ZERO from DD (044) if any.
    * Params:
    *      $phone: Phone you want clear.
    *          Ex.: 55 (43) 99780-4323 | (043)997804323 | 33780-4323 | Etc.
    *      $ddi: If you want the DDI to be added to the number. True or False.
    ************************************************************************/
    public static function clearPhone($phone, $ddi = false) {

        // Removes all letters and special characters from 
        // the value sent, allowing only numbers.
        $phone = preg_replace("/[^0-9]/", "", $phone);

        // Removes the DDI (55) from the phone if any.
        $hasDDI = strpos ($phone, '55');
        if($hasDDI === 0) {
            $qtdDigits = strlen($phone);
            $phone = mb_substr($phone, 2, $qtdDigits);
        }

        // Remove ZERO from DD if any. Ex.: 045 => 45
        $hasZeroDD = strpos ($phone, '0');
         if($hasZeroDD === 0) {
            $qtdDigits = strlen($phone);
            $phone = mb_substr($phone, 1 , $qtdDigits);
        }

        // Add Brazil DDI (55), if needs.
        if($ddi) {

            $hasDDI = mb_substr($phone, 0 , 2);
            if($hasDDI != '55') {
                $phone = '55'.$phone;
            }
        }
        return $phone;
    }   


    /************************************************************************
    * Description: Formats the phone to display in the Brazilian standard.
    * Ex.: +55 (43) 99743-4323 | (43) 99743-432X | 99743-432X
    * Params:
    *      $phone: Phone you want format.
    *          Ex.: 55 (43) 99780-4323 | (043)997804323 | 33780-4323 | Etc.
    *      $ddi: If you want the DDI to be added to the number. True or False.
    ************************************************************************/
    public static function formatPhone($phone, $ddi = false) {

        // Clear phone number.
        $phone = self::clearPhone($phone);
        
        // Number of Digits.
        $qtdDigitos = strlen($phone);

        switch ($qtdDigitos) {

            case 8: // Home Phone WITHOUT DD.
                $phone = (mb_substr($phone, 0 , 4) ."-".mb_substr($phone, 4 , $qtdDigitos));
                break;
            case 9: // Cell Phone WITHOUT DD.
                $phone = (mb_substr($phone, 0 , 5) ."-".mb_substr($phone, 5 , $qtdDigitos));
                break;
            case 10: // Home Phone WITH DD.
                $dd = mb_substr($phone, 0 , 2);
                $number = (mb_substr($phone, 2 , 4) ."-".mb_substr($phone, 6 , $qtdDigitos));
                $phone = "($dd) $number";
                break;
            case 11: // Cell Phone WITH DD
                $dd = mb_substr($phone, 0 , 2);
                $number = (mb_substr($phone, 2 , 5) ."-".mb_substr($phone, 7 , $qtdDigitos));
                $phone = "($dd) $number";
                break;  
            default: // Invalid Phone. Do not have correct amount of digits.
               return false;
        }

        // Add Brazil DDI (55), if needs.
        if($ddi) {

            // Only add the DDI (55) if the phone has the DD.
            if($qtdDigitos >= 10) {

                $phone = '+55 '.$phone;
            }
        }

       return $phone;
    }


    /************************************************************************
    * Description: User can choose whether to clear or format CPF/CNPJ.
    ************************************************************************/
    public static function prepareCpfCnpj($cpf_cnpj, $clear = false) {

        if(!$clear) {
            return self::formatCpfCnpj($cpf_cnpj);
        }

        return self::clearCpfCnpj($cpf_cnpj);
    }


    /************************************************************************
    * Description: Clear CPF or CNPJ.
    ************************************************************************/
    public static function clearCpfCnpj($cpf_cnpj) {

        // Removes all letters and special characters from 
        // the value sent, allowing only numbers.
        $cpf_cnpj = preg_replace("/[^0-9]/", "", $cpf_cnpj);

        // Check if it's a CPF (11 digits) or CNPJ (15 digits)
        if(strlen($cpf_cnpj) == 11 || strlen($cpf_cnpj) == 14) {
            return $cpf_cnpj;
        }

        // If isn't a valid CPF or CNPJ, return false.
        return false;
    }


    /************************************************************************
    * Description: Convert to the default CPF or CNPJ display format.
    ************************************************************************/
    public static function formatCpfCnpj($cpf_cnpj) {
        
        if (strlen($cpf_cnpj) == 11) {
            // CPF
            return preg_replace("/(\d{3})(\d{3})(\d{3})(\d{2})/", "\$1.\$2.\$3-\$4", $cpf_cnpj);
        } 
        else if (strlen($cpf_cnpj) == 14) {
            // CNPJ
            return preg_replace("/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/", "\$1.\$2.\$3/\$4-\$5", $cpf_cnpj);
        }

        return false;
    }


    /************************************************************************
    * Description: Converts any date type to another desired format.
    * Ex.: 2019-02-22 => 22/02/2019 | 16/05/2019 => 2019-05-16
    * Params:
    *      $date: Date you want format.
    *      $format: Desired format. Ex. Y-m-d | d-Y-m | d/m/Y
    ************************************************************************/
    public static function formatDateTo($date, $format='d/m/Y') {

        $date = str_replace('/', '-', $date); // If date contains '/' replace with '-'.
        $date = date($format, strtotime($date)); // Convert the date to the format you want.
        return $date;
    }
}
?>