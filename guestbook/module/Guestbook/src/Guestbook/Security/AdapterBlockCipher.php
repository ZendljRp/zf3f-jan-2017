<?php

namespace Guestbook\Security;

use Zend\Crypt\BlockCipher;

class AdapterBlockCipher
{
    /**
     * @var BlockCipher
     */
    private $cipher;

    // tag::encrypt[]
    public function encrypt($text)
    {
        $this->cipher = BlockCipher::factory('mcrypt', ['algorithm' => 'aes']);
        $this->cipher->setKey('this is the encryption key');

        return $this->cipher->encrypt($text);
    }
    // end::encrypt[]

    // tag::decrypt[]
    public function decrypt($text)
    {
        $this->cipher = BlockCipher::factory('mcrypt', ['algorithm' => 'aes']);
        $this->cipher->setKey('this is the encryption key');

        return $this->cipher->decrypt($text);
    }
    // end::decrypt[]
}
