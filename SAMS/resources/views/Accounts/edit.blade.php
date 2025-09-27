{{-- resources/views/accounts/edit.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Account</h2>

    {{-- Success message --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Validation errors --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>There were some problems with your input:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('accounts.update', $user->id) }}">
        @csrf
        @method('PUT')

        {{-- User Info --}}
        <div class="mb-3">
            <label class="form-label">Full Name</label>
            <input type="text" name="name" class="form-control" 
                   value="{{ old('name', $user->name) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Email Address</label>
            <input type="email" name="email" class="form-control" 
                   value="{{ old('email', $user->email) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Role</label>
            <select name="role" class="form-control" disabled>
                <option value="student" {{ $user->role === 'student' ? 'selected' : '' }}>Student</option>
                <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
            </select>
            <small class="text-muted">⚠ Role cannot be changed here</small>
        </div>

        {{-- Boarder Info (only for students) --}}
        @if($user->role === 'student' && $boarder)
            <hr>
            <h4>Boarder Information</h4>

            <div class="mb-3">
                <label class="form-label">First Name</label>
                <input type="text" name="first_name" class="form-control"
                       value="{{ old('first_name', $boarder->first_name) }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Last Name</label>
                <input type="text" name="last_name" class="form-control"
                       value="{{ old('last_name', $boarder->last_name) }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Phone</label>
                <input type="text" name="phone" class="form-control"
                       value="{{ old('phone', $boarder->phone) }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Course</label>
                <input type="text" name="course" class="form-control"
                       value="{{ old('course', $boarder->course) }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Year Level</label>
                <input type="text" name="year_level" class="form-control"
                       value="{{ old('year_level', $boarder->year_level) }}">
            </div>
        @endif

        <button type="submit" class="btn btn-primary">Update Account</button>
        <a href="{{ route('boarders.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
