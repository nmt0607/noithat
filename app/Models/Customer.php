<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    // create, update column
    protected $fillable = [
        'name',
        'code',
        'email',
        'phone',
        'address',
        'province_id',
        'district_id'
    ];

    //query search
    protected $searchableByOrWhere = [
        'name',
        'code',
        'email',
        'phone',
    ];
    public function getSearchableByOrWhere(){
        return $this->searchableByOrWhere;
    }    
    

    protected $searchableByWhere = [
        'province_id',
        'district_id'
    ];    
    public function getSearchableByWhere(){
        return $this->searchableByWhere;
    } 

    // column table
    protected $columnTable = [
        'name',
        'code',
        'email',
        'phone',
        'province_id',
        'district_id'
    ];    
    public function getColumnTable(){
        return $this->columnTable;
    } 
    //column sorting
    protected $columnSortingTable = [
        'name',
        'code',
        'email',
        'phone',
        'province_id',
        'district_id'
    ];    
    public function getColumnSortingTable(){
        return $this->columnSortingTable;
    } 

    
    //export
    protected $columnExport = [
        'name',
        'code',
        'email',
        'phone',
        'province_id',
        'district_id'
    ];  
    public function  getColumnExport() {
        return $this->columnExport;
    }

    // translate
    protected $translate = [
        'name' => 'Tên khách hàng',
        'code' => 'Mã khách hàng',
        'email' => 'Email',
        'province_id' => 'Tỉnh / Thành phố',
        'district_id'=> 'Quận / Huyện'
    ];
    public function getTranslate(){
        return $this->translate;
    }

    // Dư nợ đầu kỳ
    public function ordersUnPaidBefore($date){
        $countMoneyOrder =  $this->hasMany(Order::class)
            ->where('orders.created_at','<',$date)
            ->where(function ($query){
                $query->orWhere('orders.status', '=', 2);
            })->sum('orders.total_money');
        return $countMoneyOrder;
    }
    // Dư nợ còn phải trả
    public function ordersUnPaid($date){
        $countMoneyOrder =  $this->hasMany(Order::class)
            ->where('orders.created_at','<',$date)
            ->where(function ($query){
                $query->orWhere('orders.status', '=', 2);
            })->sum('orders.total_money');
        return $countMoneyOrder;
    }
    
}
