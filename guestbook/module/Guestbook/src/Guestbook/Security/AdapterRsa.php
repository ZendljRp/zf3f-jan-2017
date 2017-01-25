<?php

namespace Guestbook\Security;


use Zend\Crypt\PublicKey\Rsa;
use Zend\Crypt\PublicKey\RsaOptions;

/**
 * Class AdapterRsa
 * @package Guestbook\Security
 */
class AdapterRsa
{
    /**
     * @var Rsa
     */
    private $rsa;

    /**
     * AdapterRsa constructor.
     */
    // tag::construct[]
    public function __construct()
    {
        $this->rsa = new Rsa(
            new RsaOptions(
                [
                    'passPhrase' => 'insert the passphrase here',
                    'pemPath' => 'name of the private key file .pem'
                ]
            )
        );
    }
    // end::construct[]

    /**
     * @param string $filename
     * @return string
     */
    // tag::sign[]
    public function sign($filename)
    {
        return $this->rsa->sign(
            file_get_contents($filename),
            $this->rsa->getOptions()->getPrivateKey(),
            Rsa::MODE_BASE64
        );
    }
    // end::sign[]

    /**
     * @param string $filename
     * @return string
     */
    // tag::verify[]
    public function verify($filename)
    {
        $signature = $this->sign($filename);

        $result = $this->rsa->verify(
            file_get_contents($filename),
            $signature,
            $this->rsa->getOptions()->getPrivateKey(),
            Rsa::MODE_BASE64
        );

        if ($result) {
            file_put_contents($filename . '.sig', $signature);
            return sprintf("This signature is OK. It was stored in %s.sig", $filename);
        }

        return "The signature is not valid";
    }
    // end::verify[]
}
