<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Spatie\Permission\Models\Role as ModelsRole;

class Role extends ModelsRole implements Auditable
{
    use HasFactory;
    // create, update column
    use \OwenIt\Auditing\Auditable;
    protected $table = "roles";
    protected $fillable = [
        'name',
        'guard_name',
        'description',
    ];

    //query search
    protected $searchableByOrWhere = [
        'name',
        'description'
    ];
    public function getSearchableByOrWhere(){
        return $this->searchableByOrWhere;
    }

    protected $searchableByWhere = [
        'name',
        'description'
    ];
    public function getSearchableByWhere(){
        return $this->searchableByWhere;
    }

    // column table
    protected $columnTable = [
        'name',
        'description',
    ];
    public function getColumnTable(){
        return $this->columnTable;
    }

    //column sorting
    protected $columnSortingTable = [
        'name',
        'description'
    ];
    public function getColumnSortingTable(){
        return $this->columnSortingTable;
    }

    //export
    protected $columnExport = [];
    public function  getColumnExport() {
        return $this->columnExport;
    }

    protected $translate = [
        'name' => 'Tên nhóm người dùng',
        'description' => 'Mô tả'
    ];
    public function getTranslate(){
        return $this->translate;
    }

    public function userGroups() {
        return $this->morphedByMany(UserGroup::class, 'model', 'model_has_roles', 'role_id', 'model_id');
    }
    public function permissionAll() {
        return $this->belongsToMany(Permission::class,'role_has_permissions');
    }
}
