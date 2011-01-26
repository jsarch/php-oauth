<?php
/*
 * Licensed under the MIT license:
 * <http://www.opensource.org/licenses/mit-license.php>
 */

namespace OAuth\SignatureMethod;

use OAuth\Util;

/**
 * The PLAINTEXT method does not provide any security protection and SHOULD only be used
 * over a secure channel such as HTTPS. It does not use the Signature Base String.
 *   - Chapter 9.4 ("PLAINTEXT")
 *
 * @author Andy Smith <termie@google.com>
 * @author Nico Kaiser <kaiser@boerse-go.de>
 */
class Plaintext extends SignatureMethod
{
    public function getName()
    {
        return "PLAINTEXT";
    }

    /**
     * oauth_signature is set to the concatenated encoded values of the Consumer Secret and
     * Token Secret, separated by a '&' character (ASCII code 38), even if either secret is
     * empty. The result MUST be encoded again.
     *   - Chapter 9.4.1 ("Generating Signatures")
     *
     * Please note that the second encoding MUST NOT happen in the SignatureMethod, as
     * OAuthRequest handles this!
     */
    public function buildSignature($request, $consumer, $token)
    {
        $key_parts = array(
            $consumer->getSecret(),
            ($token) ? $token->getSecret() : ""
        );

        $key_parts = Util::urlencodeRfc3986($key_parts);
        $key = implode('&', $key_parts);
        $request->setBaseString($key);

        return $key;
    }
}
