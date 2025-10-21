<?php

namespace App\Enums;

enum ServerMessageTypes
{
    const VALIDATION_ERROR = "validation_error";
    const ERROR = "error";
    const SUCCESS = "success";
    const INFO = "info";
    const WARNING = "warning";

}
