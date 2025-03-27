@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Manage Users</h2>
    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Email</th>
                <th>Admin</th>
                <th>Master</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    <input type="checkbox" class="toggle-status" data-id="{{ $user->id }}" data-field="is_admin" 
                        {{ $user->is_admin ? 'checked' : '' }}>
                </td>
                <td>
                    <input type="checkbox" class="toggle-status" data-id="{{ $user->id }}" data-field="master" 
                        {{ $user->master ? 'checked' : '' }}>
                </td>
                <td>
                    <button class="btn btn-primary save-btn" data-id="{{ $user->id }}">Simpan</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.save-btn').forEach(button => {
        button.addEventListener('click', function () {
            let userId = this.dataset.id;
            let isAdmin = document.querySelector(`.toggle-status[data-id="${userId}"][data-field="is_admin"]`).checked ? 1 : 0;
            let isMaster = document.querySelector(`.toggle-status[data-id="${userId}"][data-field="master"]`).checked ? 1 : 0;

            fetch(`/users/${userId}/update`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ is_admin: isAdmin, master: isMaster })
            })
            .then(response => response.json())
            .then(data => {
                alert('User updated successfully');
            })
            .catch(error => console.error('Error:', error));
        });
    });
});
</script>
@endsection
