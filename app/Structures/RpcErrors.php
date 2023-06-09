<?php
namespace App\Structures;

class RpcErrors {
    const BAD_REQUEST_CODE = -32000;
    const BAD_REQUEST_TEXT = "BAD REQUEST";
    const PAYMENT_REQUIRED_CODE = -32002;
    const PAYMENT_REQUIRED_TEXT = "PAYMENT REQUIRED";
    const FORBIDDEN_CODE = -32003;
    const FORBIDDEN_TEXT = "FORBIDDEN";
    const PERMISSION_DENIED_TEXT = "PERMISSION DENIED";
    const NOT_FOUND_CODE = -32004;
    const NOT_FOUND_TEXT = "NOT FOUND";
    const METHOD_NOT_ALLOWED_CODE = -32005;
    const METHOD_NOT_ALLOWED_TEXT = "METHOD NOT ALLOWED";
    const CRUD_ERROR_CODE = -32025;
    const CRUD_ERROR_TEXT = "CRUD ERROR";
    const CANNOT_DELETE_TEXT = "CANNOT DELETE A TEXT";
    const CANNOT_DELETE_CODE = -32600;
}
