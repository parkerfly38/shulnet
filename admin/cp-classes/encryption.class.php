<?php



/**
 *
 *
 * Zenbership Membership Software
 * Copyright (C) 2013-2016 Castlamp, LLC
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @author      Cove Brook Coders
 * @link        https://www.covebrookcode.com/
 * @copyright   (c) 2019 Cove Brook Coders
 * @license     http://www.gnu.org/licenses/gpl-3.0.en.html
 * @project     ShulNET Membership Software
 */
class encryption
{

    /**
     * @var string $method The openssl method to use for this instance
     */
    protected $method = '';

    /**
     * @var int $mode The openssl mode to use
     */
    protected $mode = '';

    /**
     * Constructor!
     *
     * @param string $method The openssl method to use for this instance
     * @param int    $mode   The openssl  mode to use for this instance
     */
    public function __construct($method, $mode)
    {
        $this->method = $method;
        $this->mode   = $mode;

    }

    /**
     * Decrypt the data with the provided key
     *
     * @param string $data The encrypted datat to decrypt
     * @param string $key  The key to use for decryption
     *
     * @returns string|false The returned string if decryption is successful
     *                           false if it is not

     */
    public function decrypt($data, $key)
    {
        if (mb_strlen($key, '8bit') !== 32) {
            throw new Exception("Needs a 256-bit key!");
        }
        $ivsize = openssl_cipher_iv_length($this->method);
        $iv = mb_substr($message, 0, $ivsize, '8bit');
        $ciphertext = mb_substr($data, $ivsize, null, '8bit');
        
        return openssl_decrypt(
            $ciphertext,
            $this->method,
            $key,
            OPENSSL_RAW_DATA,
            $iv
        );
    }

    /**
     * Encrypt the supplied data using the supplied key
     *
     * @param string $data The data to encrypt
     * @param string $key  The key to encrypt with
     *
     * @returns string The encrypted data
     */
    public function encrypt($data, $key)
    {
        if (mb_strlen($key, '8bit') !== 32) {
            throw new Exception("Needs a 256-bit key!");
        }
        $ivsize = openssl_cipher_iv_length($this->method);
        $iv = openssl_random_pseudo_bytes($ivsize);
        
        $ciphertext = openssl_encrypt(
            $data,
            $this->method,
            $key,
            OPENSSL_RAW_DATA,
            $iv
        );
        
        return $iv . $ciphertext;
    }

    /**
     * Generate an Initialization Vector based upon the class's cypher and mode
     *
     * @returns string The initialization vector
     */
    protected function generateIv()
    {
        $size = openssl_cipher_iv_length($this->method);

        return openssl_random_pseudo_bytes($size);

    }

    /**
     * Extract a stored initialization vector from an encrypted string
     *
     * This will shorten the $data pramater by the removed vector length.
     *
     * @see Encryption::storeIv()
     *
     * @param string &$data The encrypted string to process.
     * @param string $key   The supplied key to extract the IV with
     *
     * @returns string The initialization vector that was stored
     */
    protected function getIv(&$data, $key)
    {
        $size = openssl_cipher_iv_length($this->method);
        $iv   = '';
        for ($i = $size - 1; $i >= 0; $i--) {
            $pos  = hexdec($key[$i]);
            $iv   = substr($data, $pos, 1) . $iv;
            $data = substr_replace($data, '', $pos, 1);

        }
        if (strlen($iv) != $size) {
            return false;

        }

        return $iv;

    }

    /**
     * Store the Initialization Vector inside the encrypted string.
     *
     * We will need the IV later to decrypt the data, so we need to
     * make it available.  We don't want to just append it, since that
     * could open MITM style attacks on the data.  So we'll hide it
     * using the key to determine exactly how to hide it.  That way,
     * without knowing the key, it should be impossible to get the IV.
     *
     * @param string $data The data to hide the IV within
     * @param string $iv   The IV to hide
     * @param string $key  The key to use to hide the IV with
     *
     * @returns string The $data parameter with the hidden IV
     */
    protected function storeIv($data, $iv, $key)
    {
        for ($i = 0; $i < strlen($iv); $i++) {
            $offset = hexdec($key[$i]);
            $data   = substr_replace($data, $iv[$i], $offset, 0);

        }

        return $data;

    }

    /**
     * Stretch the key using a simple hmac based stretching algorythm
     *
     * We want to use sha1 here over something stronger since Blowfish
     * expects a key between 4 and 56 bytes.  Sha1 produces a 40 byte
     * hash, so it should be good for these purposes.  This also allows
     * an arbitrary key of any length to be used for encryption.
     *
     * Another benefit of streching the kye is that it actually slows
     * down any potential brute force attacks.
     *
     * We use 5000 runs for the stretching since it's a good balance
     * between brute force protection and system load.  We could increase
     * this if we were paranoid, but it shouldn't be necessary.
     *
     * @see http://en.wikipedia.org/wiki/Key_stretching
     *
     * @param string $key The key to stretch
     *
     * @returns string A 40 character hex string with the stretched key
     */
    protected function stretch($key)
    {
        $hash = sha1($key);
        $runs = 0;
        do {
            $hash = hash_hmac('sha1', $hash, $key);

        } while ($runs++ < 5000);

        return $hash;

    }

}


