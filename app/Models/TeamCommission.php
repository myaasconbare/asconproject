<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeamCommission extends Model
{
    protected $guarded = [];

    public function getRangeAttribute(){
        return $this->is_all_level ? 'ALL LEVEL' : 'Level: ' . $this->level_range_start . ' - ' . $this->level_range_end;
    }
}
