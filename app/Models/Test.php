<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    use HasFactory;
    protected $table = 'test';
    // create, update column
    protected $fillable = [
        'name',
        'contract_number',
        'actor_name',
        'director',
        'status'
    ];

    //query search
    protected $searchableByOrWhere = [
        'name',
        'contract_number',
    ];
    public function getSearchableByOrWhere(){
        return $this->searchableByOrWhere;
    }    
    

    protected $searchableByWhere = [
        'actor_name',
        'director',
        'status',
    ];    
    public function getSearchableByWhere(){
        return $this->searchableByWhere;
    } 

    // column table
    protected $columnTable = [
        'name',
        'contract_number',
        'actor_name',
        'director',
        'status',
    ];    
    public function getColumnTable(){
        return $this->columnTable;
    } 
    //column sorting
    protected $columnSortingTable = [
        'name',
        'contract_number',
        'actor_name',
        'director',
    ];    
    public function getColumnSortingTable(){
        return $this->columnSortingTable;
    } 

    
    //export
    protected $columnExport = [
        'name',
        'contract_number',
        'actor_name',
        'director',
        'status'
    ];  
    public function  getColumnExport() {
        return $this->columnExport;
    }

    // translate
    protected $translate = [
        'name' => 'Tên sản phẩm',
        'contract_number' => 'Số hợp đồng',
        'actor_name' => 'Đạo diễn',
        'director' => 'Giám đốc',
        'status'=> 'Trạng thái'
    ];
    public function getTranslate(){
        return $this->translate;
    }
}
