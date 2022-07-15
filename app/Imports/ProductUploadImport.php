<?php

namespace App\Imports;

use App\Models\ProductUpload;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\WithStartRow;
use DateTime;

class ProductUploadImport implements ToModel, WithValidation, SkipsOnError, WithStartRow
{
    use Importable, SkipsErrors, SkipsFailures;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row){
        if(isset($row[4])){
            $row[4] = $this->getInterger($row[4]);
        }
        if(isset($row[5])){
            $row[5] = $this->getInterger($row[5]);
        }
        if(isset($row[6])){
            $row[6] = $this->getInterger($row[6]);
        }
        if(isset($row[10])){
            $row[10] = $this->getInterger($row[10]);
        }
        return new ProductUpload([
            'name' =>  @$row[1]?trim($row[1]):'',
            'code' => @$row[2]?trim($row[2]):'',
            'note' => @$row[3]?trim($row[3]):'',
            'retail_price' => @$row[4]?trim($row[4]):'',
            'wholesale_price' => @$row[5]?trim($row[5]):'',
            'capital_price' => @$row[6]?trim($row[6]):'',
            'status' => @$row[7]?trim($row[7]):'',
            'product_type_id' => @$row[8]?trim($row[8]):'',
            'brand_id' =>@$row[9]?trim($row[9]):'',
            'number_value' => @$row[10]?trim($row[10]):'',
            'number_value_type' => @$row[11]?trim($row[11]):'',
            'measure' =>  @$row[12]?trim($row[12]):'',
            'product_size_id' =>  @$row[13]?trim($row[13]):'',
            'product_color_id' =>  @$row[14]?trim($row[14]):'',
            'product_material_id' =>  @$row[15]?trim($row[15]):'',
            'warehouse_name' => @$row[16]?trim($row[16]):'',
            'warehouse_quantity' => @$row[17]?trim($row[17]):'',
            'upload_status' => 0 ,// upload
            'admin_id' => auth()->id(),
        ]);
    }
    public function rules(): array
    {
        return [
            // 'ten_bai_hat' => 'required',
        ];
    }
    public function startRow(): int
    {
        return 4;
    }
    public function getInterger($data){
        $data = str_replace(',','',$data);
        $data = str_replace('.','',$data);
        return $data;
    }
}
