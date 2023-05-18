<?php

namespace App\Services;

use App\Contracts\SmsGatewayContract;
use App\Exceptions\SmsCodeException;
use App\Models\SmsCode;
use App\Models\SmsMonitoring;
use App\SmsGateways\PlayMobile\PlaymobileGateway;
use Carbon\Carbon;

class SmsService implements SmsGatewayContract
{
    public const NOT_VERIFIED = 0;
    public const VERIFIED = 1;

    public PlaymobileGateway $adapter;

    /**
     * @param PlaymobileGateway $adapter
     */
    public function __construct(PlaymobileGateway $adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     * @param int $phone
     * @param string $text
     * @param string|null $module
     * @return array|mixed
     */
    public function send(int $phone, string $text, string $module = null)
    {
        $response = $this->adapter->sendSms($phone, __('common.sms_text', ['code' => $text]));

        SmsMonitoring::create([
            'phone' => $phone,
            'code' => $text,
            'status' => $response['error-code'],
            'message_id' => $response['message-id'],
            'module' => $module
        ]);

        SmsCode::create([
            'phone' => $phone,
            'code' => $text
        ]);

        return $response;
    }

    /**
     * @param int $phone
     * @param string $text
     * @param string $code
     * @param string|null $module
     * @return array|mixed
     */
    public function sendWithText(int $phone, string $text, string $code, string $module = null)
    {
        $response = $this->adapter->sendSms($phone, $text.' '.$code);

        SmsMonitoring::create([
            'phone' => $phone,
            'code' => $code,
            'status' => $response['error_code'],
            'message_id' => $response['message_id'],
            'module' => $module
        ]);

        SmsCode::create([
            'phone' => $phone,
            'code' => $code
        ]);

        return $response;
    }

    /**
     * @param $phone
     * @param int $code
     * @return bool
     * @throws \App\Exceptions\SmsCodeException
     */
    public function check($phone, int $code)
    {
        $sms = SmsCode::orderBy('created_at', 'desc')->where(['phone' => $phone])->first();

        if (!$sms) {
            throw new SmsCodeException("Bunday telefon raqamga kod jo'natilmagan", 401);
        }

        $expire_timestamp = $sms->created_at->timestamp + $sms->expire_at;

        if (Carbon::now()->timestamp > $expire_timestamp) {
            throw new SmsCodeException("Kod mavjud emas yoki eskirgan", 401);
        }

        if ($sms->code != $code) {
            throw new SmsCodeException("Noto'g'ri kod kiritildi", 401);
        }

        $monitoring = SmsMonitoring::where(['phone' => $phone, 'code' => $code])->first();
        $monitoring->update([
            'is_verified' => self::VERIFIED
        ]);

        return (bool)$sms->delete();
    }
}
