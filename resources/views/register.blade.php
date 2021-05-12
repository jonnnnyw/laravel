<x-layout>

    <h1>Register</h1>

    <form method="POST" action="{{ route('create') }}">
        @csrf
        <div>
            <label for="name">Name *</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" />
            @error('name')
                <span>{{ $message }}</span>
            @enderror
        </div>
        <div>
            <label for="email">Email *</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" />
            @error('email')
                <span>{{ $message }}</span>
            @enderror
        </div>
        <div>
            <label for="password">Password *</label>
            <input type="password" name="password" id="password" />
            @error('password')
                <span>{{ $message }}</span>
            @enderror
        </div>
        <div>
            <label for="password-confirmation">Confirm Password *</label>
            <input type="password" name="password_confirmation" id="password-confirmation" />
            @error('password_confirmation')
                <span>{{ $message }}</span>
            @enderror
        </div>
        <button type="submit">Register</button>
    </form>
</x-layout>
