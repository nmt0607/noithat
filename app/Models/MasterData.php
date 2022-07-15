<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Livewire\WithFileUploads;
use OwenIt\Auditing\Contracts\Auditable;

class MasterData extends Model implements Auditable
{
    use HasFactory,WithFileUploads;
    use \OwenIt\Auditing\Auditable;
    protected $table = 'master_data';
    protected $guarded = ['*'];
    protected $fillable = [
        'type',
        'v_key',
        'order_number',
        'v_value',
        'v_value_en',
        'parent_id',
        'image',
        'number_value',
    ];

    public $timestamps = false;

    // public function getVValueAttribute()
    // {
    //     if (auth()->user()->lang == 'en') {
    //         return ($this->attributes['v_value_en'] ?? $this->attributes['v_value']);
    //     }

    //     return ($this->attributes['v_value'] ?? $this->attributes['v_value_en']);
    // }

    public static function getDataByType($type = 0) {
        return MasterData::query()
        ->where('type', $type)
        ->get(['id', 'v_value', 'v_value_en'])
        ->mapWithKeys(fn ($item) => [$item->id => $item->v_value])
        ->all();
    }

}
