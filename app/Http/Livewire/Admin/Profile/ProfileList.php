<?php

namespace app\Http\Livewire\Admin\Profile;

use Livewire\Component;
use App\Http\Livewire\Base\BaseLive;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Rules\MatchOldPassword;
use Livewire\WithFileUploads;
class ProfileList extends BaseLive {
    use WithFileUploads;
    public $name;
    public $phone;
    public $email;
    public $date;
    public $sex;
    public $image;
    public $file;
    public $listeners = [
        'changePassword'
    ];
    // public $password, $confirmPassword;
    public function mount(){
        $this->initData();
    }


    public function initData(){
        $this->file = null;
        $user = Auth()->user();
        $this->name = $user->name;
        $this->phone = $user->phone;
        $this->email = $user->email;
        $this->date = $user->date;
        $this->sex = $user->sex;
        $this->image = $user->image;
    }
    public function render(){
        return view('livewire.admin.profile.profile-list', [
        ]);
    }
    public function resetData(){
        $this->initData();
        $this->resetValidation();
        $this->dispatchBrowserEvent('show-toast', ["type" => "success", "message" => 'Hoàn tác thành công']);
    }
    protected $rules = [
        'name' => 'required',
        'phone' => 'required',
        "email"  => "required|email",
        "date"  => "required",
        'file' => 'nullable|image'
        // "sex"  => "required",
    ];
    protected $messages = [
        'name.required' => 'Tên người dùng bắt buộc',
        'phone.required' => 'Số điện thoại bắt buộc',
        "email.required"  => "Email bắt buộc",
        "email.email"  => "Email không đúng định dạng",
        "date.required"  => "Ngày sinh bắt buộc",
        "sex.required"  => "Giới tính bắt buộc",
        "file.image"  => "Ảnh đại diện chưa đúng dịnh dạng",
    ];
    public function saveData(){
        $this->standardData();
        $this->validate();
        $user =  Auth()->User();
        // if($this->file&&$user->image&&file_exists('./'. $user->image)){
        //     unlink('./'. $user->image);
        // }
        $user->update([
            'name' => $this->name,
            'phone' => $this->phone,
            'email' => $this->email,
            'date' => $this->date,
            'sex' => $this->sex,
            // 'image' =>  $this->file ? 'storage/'.$this->file ->store('uploads/profile/images') : $user->image,
        ]);
        $this->emit('setData',$user->name); 
        $this->dispatchBrowserEvent('show-toast', ["type" => "success", "message" => 'Chỉnh sửa trang cá nhân thành công']);
    }  
    public function  standardData(){
        $this->name = trim($this->name);
        $this->phone = trim($this->phone);
        $this->email = trim($this->email);
        $this->date = trim($this->date);
        $this->sex = trim($this->sex);
    }

    public function changePassword($data){
        // dd($data);
        if(!Hash::check($data['currentPassword'],Auth()->User()->password)){
            $data['password'] = null;
        }
        Validator::make($data,[
            'currentPassword' => 'required|confirmPassword:'.$data['currentPassword'],
            'newPassword' => 'required',
            'confirmPassword' => 'required|same:newPassword',
        ],[
            'currentPassword.required' => 'Mật khẩu hiện tại bắt buộc',
            'currentPassword.confirmPassword' => 'Mật khẩu hiện tại không đúng',
            'newPassword.required' => 'Mật khẩu mới bắt buộc',
            'confirmPassword.same' => 'Mật khẩu nhập lại không đúng',
            'confirmPassword.required' => 'Mật khẩu nhập lại bắt buộc',
        ])->validate();
        Auth()->User()->update([
            'password' => Hash::make($data['newPassword']),
        ]);
        $this->resetValidation();
        $this->emit('resetData');
        $this->dispatchBrowserEvent('show-toast', ["type" => "success", "message" => 'Đổi mật khẩu thành công']);
    }
}