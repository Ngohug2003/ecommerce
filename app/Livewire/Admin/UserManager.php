<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Http\Requests\UserRequest;

class UserManager extends Component
{

    use WithPagination, WithFileUploads;

    public $showModal = false;
    public $editingUser = null;


    public $name = '';
    public $email = '';
    public $is_admin = '0';
    public $password = '';
    public $password_confirmation = '';

    protected function rules()
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email' . ($this->editingUser ? ',' . $this->editingUser->id : ''),
            'is_admin' => 'boolean',
        ];

        // Chỉ yêu cầu password khi tạo mới
        if (!$this->editingUser) {
            $rules['password'] = 'required|min:6|confirmed';
        }

        return $rules;
    }

    public function create()
    {
        $this->reset(['name', 'email', 'password', 'password_confirmation', 'is_admin']);
        $this->is_admin = 0; // Đặt mặc định là Người dùng
        $this->editingUser = null;
        $this->showModal = true;
    }

    public function edit($userId)
    {
        $user = User::findOrFail($userId);
        $this->editingUser = $user;

        $this->name = $user->name;
        $this->email = $user->email;
        $this->is_admin = (string) $user->is_admin; // ép kiểu string

        $this->showModal = true;
    }

    public function save()
    {
        // Xác thực dữ liệu
        $validated = $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email' . ($this->editingUser ? ',' . $this->editingUser->id : ''),
            'is_admin' => 'boolean',
            'password' => $this->editingUser ? 'nullable|min:6|confirmed' : 'required|min:6|confirmed',
        ]);

        // Chuẩn bị dữ liệu để lưu
        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'is_admin' => $this->is_admin,
        ];

        // Nếu có mật khẩu, mã hóa và thêm vào dữ liệu
        if (!$this->editingUser || $this->password) {
            $data['password'] = bcrypt($this->password);
        }

        // Lưu hoặc cập nhật người dùng
        if (!$this->editingUser) {
            User::create($data);
            session()->flash('success', 'Tạo người dùng thành công!');
        } else {
            $this->editingUser->update($data);
            session()->flash('success', 'Cập nhật người dùng thành công!');
        }

        // Đóng modal và reset dữ liệu
        $this->closeModal();
    }

    public function delete($userId)
    {
        User::findOrFail($userId)->delete();
        session()->flash('success', 'Xóa người dùng thành công!');
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->reset(['name', 'email', 'is_admin', 'password', 'password_confirmation']);
        $this->editingUser = null;
    }

    public function render()
    {
        $users = User::latest()->paginate(10);
        return view('livewire.admin.user-manager', compact('users'));
    }
}
