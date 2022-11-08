<?php
namespace App\Providers\Functions;

class hashValues
{
    public $enc_algorithm = "aes-256-cbc-hmac-sha256";
    public $enc_key = "d7a03VJe55465PSa37e22ff8f45bbbe45da4632";#"gqkK36YkgLurhXND28h7TkYp7Uvemzr9";
    public $enc_iv = "Cfq84/nkLYPSJBfgfvbfdW==";
    public static function secured_encrypt($data)
    {
        // encryption
        $self = new static;
        $ciphertext = openssl_encrypt($data, $self->enc_algorithm, $self->enc_key, $options = OPENSSL_RAW_DATA, base64_decode($self->enc_iv));
            return str_replace(array('==','/'),array('','|'),base64_encode($ciphertext));
    }

    public static function secured_decrypt($data)
    {
        // decryption
        $self = new static;
        $data = str_replace(array('|'),array('/'),$data);
        $decryptedtext = openssl_decrypt(base64_decode($data), $self->enc_algorithm, $self->enc_key, $options = OPENSSL_RAW_DATA, base64_decode($self->enc_iv));
        return $decryptedtext;
    }
}
