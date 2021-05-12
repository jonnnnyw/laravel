<x-layout>

    <h1>Login</h1>

    <form method="POST" action="{{ route('authenticate') }}">
        @csrf
        @error('message')
            <span>{{ $message }}</span>
        @enderror
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
        <button type="submit">Login</button>
    </form>
</x-layout>
