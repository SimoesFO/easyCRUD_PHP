<?php

class Help {


    public static function preparePhone($phone, $clear = false, $ddi = false) {
        
        if(!$clear) {
            return Help::formatPhone($phone, $ddi);
        }

        return Help::clearPhone($phone, $ddi);
    }

	/************************************************************************
    * Descrição: Remove todos os caracteres especiais e deixa apenas números.
    * Remove o DDI caso desejar e Remove o ZERO do DD (043)
    * Parâmetros:
    *      $phone: Telefone que deseja limpar.
    *          Ex.: 55 (43) 99780-4323 | (043)997804323 | 33780-4323 | Etc.
    *      $ddi: Se você deseja que o DDI seja adicionado ao número. true ou false.
    ************************************************************************/
    public static function clearPhone($phone, $ddi = false) {

        $phone = preg_replace("/[^0-9]/", "", $phone);

        // Remove o 55 do início do telefone.
        $hasDDI = strpos ($phone, '55');
        if($hasDDI === 0) {
            $phone = mb_substr($phone, 2 , $qtdDigitos);
        }

        // Remove o 0 do inídio do telefone. Ex.: 043
        $hasDDI = strpos ($phone, '0');
         if($hasDDI === 0) {
            $phone = mb_substr($phone, 1 , $qtdDigitos);
        }

        // ADICIONA O DDI DO BRASIL, CASO PRECISE.
        if($ddi) {

            $hasDDI = mb_substr($phone, 0 , 2);
            if($hasDDI != '55') {
                $phone = '55'.$phone;
            }
        }
        return $phone;
    }   


    /************************************************************************
    * Descrição: Formata Telefone para que ele seja apresentado no Formato Padrão Brasileiro.
    * Ex.: +55 (43) 99743-4323 | (43) 99743-432X | 99743-432X
    * Parâmetros:
    *      $phone: Telefone que deseja Formatar.
    *          Ex.: 55 (43) 99780-4323 | (043)997804323 | 33780-4323 | Etc.
    *      $ddi: Se você deseja que o DDI seja adicionado ao número. true ou false.
    ************************************************************************/
    public static function formatPhone($phone, $ddi = false) {

        // Remove todos as caracteres especiais. Deixa apenas número.
        $phone = preg_replace("/[^0-9]/", "", $phone);

        // Quantidade de Digítos do Telefone
        $qtdDigitos = strlen($phone);

        // Remove o 55 do início do telefone.
        $hasDDI = strpos ($phone, '55');
        if($hasDDI === 0) {
            $phone = mb_substr($phone, 2 , $qtdDigitos);
        }

        // Remove o 0 do inídio do telefone. Ex.: 043
        $hasDDI = strpos ($phone, '0');
         if($hasDDI === 0) {
            $phone = mb_substr($phone, 1 , $qtdDigitos);
        }

        // Calcula novamente a qtd de digitos para saber se é celular ou fixo.
        $qtdDigitos = strlen($phone);
        switch ($qtdDigitos) {

            case 8: // Telefone FIXO SEM DD.
                $phone = (mb_substr($phone, 0 , 4) ."-".mb_substr($phone, 4 , $qtdDigitos));
                break;
            case 9: // Telefone CELULAR SEM DD.
                $phone = (mb_substr($phone, 0 , 5) ."-".mb_substr($phone, 5 , $qtdDigitos));
                break;
            case 10: // Telefone FIXO COM DD.
                $dd = mb_substr($phone, 0 , 2);
                $number = (mb_substr($phone, 2 , 4) ."-".mb_substr($phone, 6 , $qtdDigitos));
                $phone = "($dd) $number";
                break;
            case 11: // Telefone CELULAR COM DD
                $dd = mb_substr($phone, 0 , 2);
                $number = (mb_substr($phone, 2 , 5) ."-".mb_substr($phone, 7 , $qtdDigitos));
                $phone = "($dd) $number";
                break;  
            default: // Telefone inválido. Não têm qtd de digitos certo.
               return false;
        }

        // Verifica se é para adicionar o DDI (55).
        if($ddi) {

            // Só add o 55 se o telefone tiver o DD (43).
            if($qtdDigitos >= 10) {

                $phone = '+55 '.$phone;
            }
        }

       return $phone;
    }


    public static function prepareCpfCnpj($cpf_cnpj, $clear = false) {

        if(!$clear) {
            return Help::formatCpfCnpj($cpf_cnpj);
        }

        return Help::clearCpfCnpj($cpf_cnpj);
    }


    public static function clearCpfCnpj($cpf_cnpj) {

        $cpf_cnpj = preg_replace("/[^0-9]/", "", $cpf_cnpj);

        if(strlen($cpf_cnpj) == 11 || strlen($cpf_cnpj) == 15) {
            return $cpf_cnpj;
        }

        return false;
    }


    public static function formatCpfCnpj($cpf_cnpj) {
        
        if (strlen($cpf_cnpj) == 11) {
            return preg_replace("/(\d{3})(\d{3})(\d{3})(\d{2})/", "\$1.\$2.\$3-\$4", $cpf_cnpj);
        } 
        else if (strlen($cpf_cnpj) == 14) {
            return preg_replace("/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/", "\$1.\$2.\$3/\$4-\$5", $cpf_cnpj);
        }

        return false;
    }

    public static function formatDateTo($date, $format='d/m/Y') {

        $date = str_replace('/', '-', $date);
        $date = date($format, strtotime($date));
        return $date;
    }
}
?>