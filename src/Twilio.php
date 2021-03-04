<?php

namespace Arkitecht\Twilio;

use Twilio\Rest\Client;

class Twilio
{
    /**
     * @var Client
     */
    private $client;

    public function __construct($clientSid, $clientToken)
    {
        $this->client = new Client($clientSid, $clientToken);
    }

    public function sendMessage($to, $body)
    {
        return $this->client
            ->messages
            ->create($this->formatNumber($to), // to
                [
                    "messagingServiceSid" => config('twilio.messaging_service'),
                    "body"                => $body,
                ]
            );
    }

    public function makeCall($to, $from, $parameters)
    {
        return $this->client->calls
            ->create($this->formatNumber($to), // to
                $this->formatNumber($from), // from
                $parameters
            );
    }

    public static function formatNumber($number)
    {
        if (!preg_match('/^\+1/', $number)) {
            $number = '+1' . $number;
        }

        return $number;
    }
}
