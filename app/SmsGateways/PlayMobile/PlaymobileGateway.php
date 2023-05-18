<?php

namespace App\SmsGateways\PlayMobile;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;
use Illuminate\Support\Str;

class PlaymobileGateway
{
    public $method = "POST";

    const INTERNAL_SERVER_ERROR = 100;
    const SYNTAX_ERROR = 101;
    const ACCOUNT_LOCK = 102;
    const EMPTY_CHANNEL = 103;
    const INVALID_PRIORITY = 104;
    const TOO_MUCH_IDS = 105;
    const EMPTY_RECIPIENT = 202;
    const EMPTY_EMAIL_ADDRESS = 204;
    const EMPTY_MESSAGE_ID = 205;
    const INVALID_VARIABLES = 206;
    const SUCCESS = 200;

    /**
     * @param int $phone
     * @param string $text
     * @return mixed
     */
    public function sendSms(int $phone, string $text)
    {
        try {
            $message_id = Str::uuid();
            $response = app(Client::class)->request($this->method, config('app.playmobile_endpoint'), [
                RequestOptions::JSON => $this->getQuery($phone, $text, $message_id),
                'auth' => [config('app.playmobile_login'), config('app.playmobile_password')]
            ]);
            $success_message = [
                'uz' => 'SMS-kod muvaffaqiyatli yuborildi',
                'ru' => 'СМС-код успешно отправлен',
                'en' => 'SMS-code successfully sent'
            ];
            return [
                'error_code' => $response->getStatusCode(),
                'error_description' => $success_message[app()->getLocale()],
                'message_id' => $message_id
            ];
        } catch (ClientException $clientException) {
            return $this->errorMessage($clientException->getMessage());
        }
    }

    /**
     * @param $phone
     * @param $text
     * @param $message_id
     * @return array[][]
     */
    private function getQuery($phone, $text, $message_id): array
    {
        return [
            'messages' => [
                [
                    'recipient' => $phone,
                    'message-id' => 'ok',
                    'sms' => [
                        'originator' => 3700,
                        'content' => [
                            'text' => $text
                        ]
                    ]
                ]
            ]
        ];
    }

    /**
     * @param string $message
     * @return mixed
     */
    public function errorMessage(string $message)
    {
        preg_match("#(?P<error>{([a-zA-Z.'\"_\-0-9:, ]+)})#", $message, $matches);

        return json_decode($matches['error'], true);
    }
}
