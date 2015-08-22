<?php
/**
 * This file is part of the Cygnite package.
 *
 * (c) Sanjoy Dey <dey.sanjoy0@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Cygnite\Common;

use Cygnite\Helpers\Config;

if (!defined('CF_SYSTEM')) {
    exit('No External script access allowed');
}

/**
 * Common Encrypt.
 *
 * This class used to encode and decode user input based on the salt key
 * provided in configuration
 *
 * @author Sanjoy Dey <dey.sanjoy0@gmail.com>
 */
class Encrypt
{
    private $secureKey;

    private $iv;

    private $value;

    private static $instance;

    private $defaultKey = 'BXT#ERHD!DSD#ndUOAS9821LL';

    /**
    * Constructor function
    * @false string - encryption key
    *
    */
    public function __construct()
    {
        $encryptKey = Config::get('global.config', 'encryption.key');

        $this->checkMCryptExists();

        if (is_null($encryptKey)) {
            $config = include_once CYGNITE_BASE.DS.APPPATH.DS.'Configs'.DS.'application'.EXT;
            $this->setSaltKey($config['encryption.key']);
        } else {
            $this->setSaltKey($encryptKey);
        }
    }

    private function checkMCryptExists()
    {
        /*
        |--------------------------------------------------------------------------
        | Check Extensions
        |--------------------------------------------------------------------------
        |
        | Cygnite Encrypt requires a few extensions to function. We will check if
        | extensions loaded. If not we'll just exit from here.
        |
        */
        if (! extension_loaded('mcrypt')) {
            echo 'Encrypt library requires Mcrypt PHP extension.'.PHP_EOL;
            exit(1);
        }
    }

    /**
     * We will set the Encryption key
     * @param $key
     * @throws \BadFunctionCallException
     */
    private function setSaltKey($key)
    {
        $this->set($key);

        if (!function_exists('mcrypt_create_iv')) {
            throw new \BadFunctionCallException("Mcrypt extension library not loaded");
        }

        $this->iv = mcrypt_create_iv(32);
    }

    /**
     * @param $encryptKey
     */
    public function set($encryptKey)
    {
        $this->secureKey = hash('sha256', $encryptKey, true);
    }

    /**
     * Get Encryption key
     * @return mixed
     */
    public function get()
    {
        return $this->secureKey;
    }

    /*
     *  This function is to encrypt string
     * @access  public
     *  @false string
     * @return encrypted hash
     */
    public function encode($input)
    {
        $this->value = base64_encode(
            mcrypt_encrypt(
                MCRYPT_RIJNDAEL_256,
                $this->secureKey,
                $input,
                MCRYPT_MODE_ECB,
                $this->iv
            )
        );

        return $this->value;
    }

    /*
     * This function is to decrypt the encoded string
     * @access  public
     * @false string
     * @return decrypted string
     */
    public function decode($input)
    {
        $this->value = trim(
            mcrypt_decrypt(
                MCRYPT_RIJNDAEL_256,
                $this->secureKey,
                base64_decode($input),
                MCRYPT_MODE_ECB,
                $this->iv
            )
        );

        return $this->value;
    }

    public function __call($method, $arguments = [])
    {
    }

    public static function __callStatic($method, $arguments = [])
    {
        if ($method == 'create') {
            if (self::$instance === null) {
                self::$instance = new self();
            }
            // we will return $this for method chaining
            return call_user_func_array([self::$instance, 'getInstance'], [$arguments]);
        }
    }

    /**
     * @return $this
     */
    public function getInstance()
    {
        return $this;
    }

    public function __destruct()
    {
        unset($this->secureKey);
        unset($this->iv);
    }
}
