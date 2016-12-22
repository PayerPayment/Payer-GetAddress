<?php
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

require_once "../../vendor/autoload.php";

?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

        <title>Payer Get Address 2.0 Demo</title>

        <link type="text/css" href="https://fonts.googleapis.com/css?family=PT+Sans" rel="stylesheet" />
        <link type="text/css" href="assets/css/payer_getaddress.css" rel="stylesheet" />
    </head>
    <body>

        <!-- Demo View -->
        <img class="logo" src="assets/images/logo_payer.png" />
        <div class="panel">
            <div class="container">
                <h1>GetAddress Example</h1>
                <p>
                    <label for="identityNumber">Org./Personal Number:</label>
                    <input id="PayerInputIdentityNumber" type="text" name="identityNumber" placeholder="Enter your identity number">
                </p>
                <p>
                    <label for="zipCode">Zip Code:</label>
                    <input id="PayerInputZipCode" type="text" name="zipCode" placeholder="Enter your zip code">
                </p>
                <p>
                    <button id="PayerButtonFetch">Fetch Address</button>
                </p>
            </div>

            <div id="PayerResponse" class="message notification">
                <h2></h2>
                <p></p>
            </div>

        </div>

        <!-- NOTICE: The Jquery Library is mandatory to be able to run this example.
                     Include your own library or unmark this below and run
             'bower install' in the directory root
        <!-- <script src="../../external/jquery/dist/jquery.min.js"></script> -->

        <?php

            require_once "PayerCredentials.php";

            use Payer\PayerChallenge;

            $challenge      =  new PayerChallenge($credentials);

            $challengeToken =  $challenge->fetchToken();
            $agentId        =  $challenge->getAgentId();

        ?>

        <!-- Payer GetAddress Includes -->
        <script src="../../src/scripts/payer_getaddress.js"></script>
        <script>

            // Initiates the Payer GetAddress module
            var getAddress = Payer.GetAddress;
            getAddress.create({

                // Http Request Data
                'request': {
                    'data': {
                        'agent_id': '<?= $agentId ?>',
                        'token':    '<?= $challengeToken ?>'  // Return the token to the client
                    }
                },

                // Allows you to enter the current e-commerce platform
                // type for auto-fill of the response object data
                // into the checkouts input fields.
                //
                // Supported platforms:
                // woocommerce, magento, prestashop, opencart, oscommerce
                //
                // 'platform': '',

                // Custom handling of response data (optional)
                'callback': function(response) {
                    $('#PayerResponse h2').html('Response');
                    $('#PayerResponse p').html(JSON.stringify(response));
                },

                // State the input data form elements here. Used to trigger
                // the complete HTTP Request to Payer.
                'input': {
                    'elements': {
                        'submit':   document.getElementById('PayerButtonFetch'),
                        'text': {
                            'identity_number':  document.getElementById('PayerInputIdentityNumber'),
                            'zip_code':         document.getElementById('PayerInputZipCode')
                        }
                    }
                }
            });

        </script>

    </body>
</html>