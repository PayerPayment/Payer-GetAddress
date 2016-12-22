<?php namespace Payer;
/**
 * Copyright 2016 Payer Financial Services AB
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * PHP version 5.3
 *
 * @package   Payer_GetAddress
 * @author    Payer <teknik@payer.se>
 * @copyright 2016 Payer Financial Services AB
 * @license   http://www.apache.org/licenses/LICENSE-2.0 Apache license v2.0
 */

use Payer\Sdk\Client;
USE Payer\Sdk\Exception\PayerException;
use Payer\Sdk\Resource\Challenge;

class PayerChallenge
{

    /**
     * The Credential Agent Id
     *
     * @var string
     */
    protected $agentId;

    /**
     * The Payer Webservice Gateway
     *
     * @var Sdk\PayerGatewayInterface
     */
    private $_gateway;

    /**
     * Create a new Payer Challenge
     *
     * @param array $credentials
     */
    public function __construct(array $credentials)
    {
        if (array_key_exists('agent_id', $credentials)) {
            $this->agentId = $credentials['agent_id'];
        }

        $this->_gateway = Client::create($credentials);
    }

    /**
     * Returns the Credential Agent Id
     *
     * @return string agent_id
     */
    public function getAgentId()
    {
        return $this->agentId;
    }

    /**
     * Initiates a Challenge Response and fetches
     * the unique session token from Payer
     *
     * @return string challenge token
     */
    public function fetchToken()
    {
        $challenge = new Challenge($this->_gateway);
        $challengeResponse = $challenge->create();

        var_dump($challengeResponse);
        return $challengeResponse['challenge_token'];
    }

}