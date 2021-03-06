<?php
/*
 * Licensed under the MIT license:
 * <http://www.opensource.org/licenses/mit-license.php>
 */

namespace OAuth\SignatureMethod;

/**
 * A class for implementing a Signature Method
 * See section 9 ("Signing Requests") in the spec
 *
 * @author Andy Smith <termie@google.com>
 * @author Nico Kaiser <kaiser@boerse-go.de>
 */
abstract class SignatureMethod
{
    /**
     * Needs to return the name of the Signature Method (ie HMAC-SHA1)
     *
     * @return string
     */
    abstract public function getName();

    /**
     * Build up the signature
     * NOTE: The output of this function MUST NOT be urlencoded.
     * the encoding is handled in OAuthRequest when the final
     * request is serialized
     *
     * @param \OAuth\Request $request
     * @param \OAuth\Consumer $consumer
     * @param \OAuth\Token $token
     * @return string
     */
    abstract public function buildSignature($request, $consumer, $token);

    /**
     * Verifies that a given signature is correct
     *
     * @param \OAuth\Request $request
     * @param \OAuth\Consumer $consumer
     * @param \OAuth\Token $token
     * @param string $signature
     * @return bool
     */
    public function checkSignature($request, $consumer, $token, $signature)
    {
        $built = $this->buildSignature($request, $consumer, $token);
        return $built == $signature;
    }
}
