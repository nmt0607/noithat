<?php

namespace App\Http\Livewire\Admin\User;

use App\Http\Livewire\Base\BaseLive;
use App\Models\User;
use App\Models\Role;
use App\Models\UserGroup;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;
class UserList extends BaseLive
{
    public $mode = 'create';
    public $editId;
    public $deleteId;
    public $key_name='id', $sortingName='desc';
    public $name;
    public $phone;
    public $email;
    public $date;
    public $sex;
    public $password;

    protected $rules = [
        'name' => 'required',
        'password'=>'required',
        'phone' => 'required|numeric',
        'email' => 'required|email',
        'date' => 'required',
        'sex' => 'required',
    ];

    protected $messages = [
        'name.required' => 'Họ và tên bắt buộc',
        'password.required' => 'Mật khẩu bắt buộc',
        'phone.required' => 'Số điện thoại bắt buộc',
        'phone.numeric' => 'Số điện thoại không đúng định dạng',
        'email.required' => 'Email bắt buộc',
        'email.email' => 'Email không đúng định dạng',
        'date.required' => 'Ngày sinh bắt buộc',
        'sex.required' => 'Giới tính bắt buộc',
    ];


    public $search;
    public $searchName;
    public $searchPhone;
    public $searchSex;


    public function mount(){
        $this->perPage = 50;

    }

    public function render(){
        $query = User::querY();

        if($this->searchName) {
            $query->where("name", "like", "%".$this->searchName."%");
        }
        if($this->searchPhone) {
            $query->where("phone", "like", "%".$this->searchPhone."%");
        }
        if($this->searchSex) {
            $query->where("sex", "like", "%".$this->searchSex."%");
        }

        $data = $query->orderBy($this->key_name,$this->sortingName)->paginate($this->perPage);
        return view('livewire.admin.user.user-list', [
            'data'=> $data,
        ]);
    }

    public function updatedSearch(){
        $this->resetPage();
    }

    public function resetValidate(){
        // dd('vào');
        $this->name = "";
        $this->password = "";
        $this->phone = "";
        $this->email = "";
        $this->date = "";
        $this->sex = "";
        $this->resetValidation();
    }

    public function create (){
        $this->mode = 'create';
        $this->resetInput();
    }
    public function resetInput(){
        $this->password = "";
    }

    public function saveData (){
        $this->standardData();
        if($this->mode=='create') {
            $this->rules['password'] = 'required';
        }
        else {
            $this->rules['password'] = '';
        }
        $this->validate();
        if($this->mode=='create'){
            $user = User::create([
                "name" => $this->name,
                "password"=>Hash::make($this->password),
                "phone" => $this->phone,
                "email" => $this->email,
                "date" => $this->date,
                "sex" => $this->sex,
            ]);

        }
        else {
            $user = User::findorfail($this->editId);
            $password = $user->password;
            $user->update([
                "name" => $this->name,
                "password"=> $this->password?Hash::make($this->password):$password,
                "phone" => $this->phone,
                "email" => $this->email,
                "date" => $this->date,
                "sex" => $this->sex,
            ]);

        }
        $this->resetValidate();
        if($this->mode=='create'){
            $this->dispatchBrowserEvent('show-toast', ["type" => "success", "message" => 'Thêm mới thành công']);
        }
        else {
            $this->dispatchBrowserEvent('show-toast', ["type" => "success", "message" => 'Chỉnh sửa thành công']);
        }
        $this->emit('closeModalCreateEdit');
    }

    public function edit($row){
        $this->mode = 'update';
        $this->editId = $row['id'];
        $this->name = $row["name"];
        // $this->password = $row["password"];
        $this->phone = $row["phone"];
        $this->email = $row["email"];
        $this->date = $row["date"];
        $this->sex = $row["sex"];
    }

    public function standardData(){
        $this->name = trim($this->name);
        $this->phone = trim($this->phone);
        $this->email = trim($this->email);
        $this->date = trim($this->date);
        $this->sex = trim($this->sex);

    }

    public function delete(){
        User::findorfail($this->deleteId)->delete();
        $this->dispatchBrowserEvent('show-toast', ["type" => "success", "message" => 'Xóa thành công']);
    }

    public function resetSearch(){
        $this->search = "";
        $this->searchName = "";
        $this->searchPhone = "";
        $this->searchSex = "";
        $this->reset('key_name');
        $this->reset('sortingName');
    }

    public function export(){
        $today = date("d_m_Y");
        return Excel::download(new UserExport($this->key_name, $this->sortingName, $this->search, $this->searchName, $this->searchAccount, $this->searchPhone, $this->searchEmail, $this->searchSex), "User-export-".$today.".xlsx");
    }

    public function sorting($key){
        if($this->key_name == $key){
            $this->sortingName = $this->getSortName();
        } else {
            $this->sortingName ='desc';
        }
        $this->key_name = $key;
    }
    public function getSortName(){
        return $this->sortingName == "desc" ? "asc" : "desc";
    }
}
