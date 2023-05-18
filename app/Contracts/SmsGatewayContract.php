<?php

namespace App\Contracts;

interface SmsGatewayContract
{
    const LOGIN_MODULE = "Login";
    const REGISTRATION_MODULE = "Registration";
    /**
     * @param int $phone
     * @param string $text
     * @param string|null $module
     * @return mixed
     */
    public function send(int $phone, string $text, string $module = null);
}
