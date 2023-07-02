<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Livewire\WithFileUploads;
use OwenIt\Auditing\Contracts\Auditable;

class MasterData extends Model
{
    use HasFactory,WithFileUploads;
    protected $table = 'master_data';
    protected $guarded = ['*'];
    protected $fillable = [
        'type',
        'content',
        'image',
    ];

    public function images()
    {
        return $this->hasMany(File::class, 'model_id')->where('model_name','App\\Models\\MasterData');
    }

}
