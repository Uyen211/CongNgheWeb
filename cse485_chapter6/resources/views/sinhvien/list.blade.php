@extends('layouts.app')

@section('content')
    <h2>Danh sách Sinh Viên (Chương 8 - Eloquent)</h2>

    <div style="margin-bottom: 20px; padding: 15px; border: 1px solid #ccc;">
        <h3>Thêm mới sinh viên</h3>
        <form action="{{ route('sinhvien.store') }}" method="POST">
            @csrf
            
            <div style="margin-bottom: 10px;">
                <label for="ten">Tên sinh viên:</label>
                <input type="text" id="ten" name="ten_sinh_vien" required placeholder="Nhập tên...">
            </div>

            <div style="margin-bottom: 10px;">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required placeholder="Nhập email...">
            </div>

            <button type="submit">Lưu thông tin</button>
        </form>
    </div>

    <hr>

    <h3>Dữ liệu từ Database</h3>
    <table border="1" cellpadding="10" style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="background-color: #f2f2f2;">
                <th>ID</th>
                <th>Tên Sinh Viên</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
            @foreach($danhSachSV as $sv)
            <tr>
                <td>{{ $sv->id }}</td>
                <td>{{ $sv->ten_sinh_vien }}</td>
                <td>{{ $sv->email }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endsection