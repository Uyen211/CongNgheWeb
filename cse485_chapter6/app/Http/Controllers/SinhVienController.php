<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// TODO 10: Import Model SinhVien
use App\Models\SinhVien;

class SinhVienController extends Controller
{
    // Phương thức index() (SELECT)
    public function index()
    {
        // TODO 11: Lấy toàn bộ sinh viên
        $danhSachSV = SinhVien::all();
        // TODO 12: Trả về view 'sinhvien.list'
        return view('sinhvien.list', compact('danhSachSV'));
    }

    // Phương thức store() (INSERT)
    public function store(Request $request)
    {
        // TODO 13: Lấy dữ liệu
        $data = $request->all();
        // TODO 14: Lưu vào CSDL
        SinhVien::create($data);
        // TODO 15: Chuyển hướng
        return redirect()->route('sinhvien.index');
    }
}