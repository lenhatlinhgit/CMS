<x-blog-layout title="Register">
    <div class="mx-auto max-w-md">
        <h1 class="mb-6 text-2xl font-semibold text-fg-title">Create account</h1>

        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf

            <div>
                <label for="name" class="mb-1 block text-sm font-medium">Name</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                    class="w-full rounded-lg border border-border bg-card px-3 py-2">
                @error('name')<p class="mt-1 text-sm text-danger">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="email" class="mb-1 block text-sm font-medium">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required
                    class="w-full rounded-lg border border-border bg-card px-3 py-2">
                @error('email')<p class="mt-1 text-sm text-danger">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="password" class="mb-1 block text-sm font-medium">Password</label>
                <input id="password" type="password" name="password" required
                    class="w-full rounded-lg border border-border bg-card px-3 py-2">
                @error('password')<p class="mt-1 text-sm text-danger">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="password_confirmation" class="mb-1 block text-sm font-medium">Confirm password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required
                    class="w-full rounded-lg border border-border bg-card px-3 py-2">
            </div>

            <button type="submit" class="btn btn-md btn-solid btn-solid-primary w-full">Register</button>
        </form>

        <p class="mt-4 text-sm text-fg-muted">
            Already have an account?
            <a href="{{ route('login') }}" class="text-primary hover:underline">Login</a>
        </p>
    </div>
</x-blog-layout>
