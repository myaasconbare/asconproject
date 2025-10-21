<?php

namespace App\Traits;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

trait FormattedDate {
    const FORMAT = 'Y-m-d h:i A';

    public function formatDate($dateColumn = 'created_at'){
        return formatDate($this->$dateColumn, self::FORMAT);
    }
    public function getInitiatedAtAttribute(){
        return $this->formatDate();
    }
}

