<?php

    /*
    * PHP Class for handling Google Authenticator 2-factor authentication
    *
    * @author Michael Kliewe
    * @copyright 2012 Michael Kliewe
    * @license http://www.opensource.org/licenses/bsd-license.php BSD License
    * @link http://www.phpgangsta.de/
    */

    class GoogleAuthenticator{

        protected $_codeLength = 6;

        /*
        * Crie um novo código secreto.
        * 16 caracteres, escolhidos aleatoriamente dos caracteres base32 permitidos.
        *
        * @param int $tamanho_codigo
        * @return string
        */
        public function createSecret($tamanho_codigo = 16){

            $validChars = $this->_getBase32LookupTable();

            unset($validChars[32]);

            $secret = '';

            for ($i = 0; $i < $tamanho_codigo; $i++) {

                $secret .= $validChars[array_rand($validChars)];

            }

            return $secret;
        }


        //------------------------------------------------------------------------------


        /*
        * Calcule o código, com determinado segredo e ponto no tempo
        *
        * @param string $secret
        * @param int|null $intervalo_tempo
        * @return string
        */
        public function getCode($secret, $intervalo_tempo = null){

            if ($intervalo_tempo === null) {

                $intervalo_tempo = floor(time() / 30);

            }

            $secretkey = $this->_base32Decode($secret);

            // Coloque o tempo na string binária
            $time = chr(0).chr(0).chr(0).chr(0).pack('N*', $intervalo_tempo);

            // Hash com a chave secreta dos usuários
            $hm = hash_hmac('SHA1', $time, $secretkey, true);

            // Use o ultimo bico do resultado como índice / deslocamento
            $offset = ord(substr($hm, -1)) & 0x0F;

            // Pegue 4 bytes do resultado
            $hashpart = substr($hm, $offset, 4);

            // Descompactar valor binário
            $value = unpack('N', $hashpart);

            $value = $value[1];

            // Apenas 32 bits
            $value = $value & 0x7FFFFFFF;

            $modulo = pow(10, $this->_codeLength);

            return str_pad($value % $modulo, $this->_codeLength, '0', STR_PAD_LEFT);

        }


        //-----------------------------------------------------------------------------


        /*
        * Obter URL do QR-Code para imagem, a partir de gráficos do google
        *
        * @param string $name
        * @param string $secret
        * @param string $title
        * @return string
        */
        public function getQRCodeGoogleUrl($name, $secret, $title = null) {

            $urlencoded = urlencode('otpauth://totp/'.$name.'?secret='.$secret.'');

            if(isset($title)) {

                $urlencoded .= urlencode('&issuer='.urlencode($title));

            }

            return 'https://chart.googleapis.com/chart?chs=200x200&chld=M|0&cht=qr&chl='.$urlencoded.'';

        }


        //----------------------------------------------------------------------------


        /*
        * Verifique se o código está correto. Isso aceitará códigos a partir de $discrepancy * 30sec atrás para $discrepancy * 30sec a partir de agora
        *
        * @param string $secret
        * @param string $code
        * @param int $discrepancy Esta é a perda de tempo permitida em unidades de 30 segundos (8 significa 4 minutos antes ou depois)
        * @param int|null $currentTimeSlice Fatia de tempo se quisermos usar outro que o time()
        * @return bool
        */
        public function verifyCode($secret, $code, $discrepancy = 1, $currentTimeSlice = null){

            if ($currentTimeSlice === null) {
                
                $currentTimeSlice = floor(time() / 30);

            }

            for ($i = -$discrepancy; $i <= $discrepancy; $i++) {

                $calculatedCode = $this->getCode($secret, $currentTimeSlice + $i);
                    
                    if ($calculatedCode == $code ) {
                    
                    return true;

                }

            }

            return false;

        }


        //------------------------------------------------------------------------------


        /*
        * Defina o comprimento do código, deve ser >= 6
        *
        * @param int $length
        * @return GoogleAuthenticator
        */
        public function setCodeLength($length){

            $this->_codeLength = $length;
            
            return $this;

        }


        //--------------------------------------------------------------------------------------


        /*
        *Classe auxiliar para decodificar base32
        *
        * @param $secret
        * @return bool|string
        */
        protected function _base32Decode($secret){

            if (empty($secret)) return '';

            $base32chars = $this->_getBase32LookupTable();

            $base32charsFlipped = array_flip($base32chars);

            $paddingCharCount = substr_count($secret, $base32chars[32]);

            $allowedValues = array(6, 4, 3, 1, 0);

            if (!in_array($paddingCharCount, $allowedValues)) return false;

            for ($i = 0; $i < 4; $i++){

                if ($paddingCharCount == $allowedValues[$i] &&
                substr($secret, -($allowedValues[$i])) != str_repeat($base32chars[32], $allowedValues[$i])) return false;
            
            }

            $secret = str_replace('=','', $secret);

            $secret = str_split($secret);

            $binaryString = "";

            for ($i = 0; $i < count($secret); $i = $i+8) {

                $x = "";
                
                if (!in_array($secret[$i], $base32chars)) return false;

                for ($j = 0; $j < 8; $j++) {

                    $x .= str_pad(base_convert(@$base32charsFlipped[@$secret[$i + $j]], 10, 2), 5, '0', STR_PAD_LEFT);
                
                }

                $eightBits = str_split($x, 8);
                
                for ($z = 0; $z < count($eightBits); $z++) {
                    
                    $binaryString .= ( ($y = chr(base_convert($eightBits[$z], 2, 10))) || ord($y) == 48 ) ? $y:"";

                }

            }

            return $binaryString;

        }


        //-----------------------------------------------------------------------------------------


        /*
        * Classe auxiliar para codificar base32
        *
        * @param string $secret
        * @param bool $padding
        * @return string
        */
        protected function _base32Encode($secret, $padding = true){

            if (empty($secret)) return '';

            $base32chars = $this->_getBase32LookupTable();

            $secret = str_split($secret);

            $binaryString = "";

            for ($i = 0; $i < count($secret); $i++) {

                $binaryString .= str_pad(base_convert(ord($secret[$i]), 10, 2), 8, '0', STR_PAD_LEFT);

            }

            $fiveBitBinaryArray = str_split($binaryString, 5);

            $base32 = "";
            
            $i = 0;
            
            while ($i < count($fiveBitBinaryArray)) {
                
                $base32 .= $base32chars[base_convert(str_pad($fiveBitBinaryArray[$i], 5, '0'), 2, 10)];
                
                $i++;

            }

            if ($padding && ($x = strlen($binaryString) % 40) != 0) {

                if ($x == 8) $base32 .= str_repeat($base32chars[32], 6);

                elseif ($x == 16) $base32 .= str_repeat($base32chars[32], 4);

                elseif ($x == 24) $base32 .= str_repeat($base32chars[32], 3);

                elseif ($x == 32) $base32 .= $base32chars[32];

            }

            return $base32;

        }


        //-----------------------------------------------------------------------------------------


        /*
        * Obtenha matriz com todos os 32 caracteres para decodificação de / codificação para base32
        *
        * @return array
        */
        protected function _getBase32LookupTable(){

            return array(

                'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', //  7
                'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', // 15
                'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', // 23
                'Y', 'Z', '2', '3', '4', '5', '6', '7', // 31
                '='

            );

        }
    }

?>
