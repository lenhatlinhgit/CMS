<x-blog-layout title="Login">
    <div class="mx-auto max-w-md">
        <h1 class="mb-6 text-2xl font-semibold text-fg-title">Login</h1>

        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf

            <div>
                <label for="email" class="mb-1 block text-sm font-medium">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                    class="w-full rounded-lg border border-border bg-card px-3 py-2">
                @error('email')<p class="mt-1 text-sm text-danger">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="password" class="mb-1 block text-sm font-medium">Password</label>
                <input id="password" type="password" name="password" required
                    class="w-full rounded-lg border border-border bg-card px-3 py-2">
                @error('password')<p class="mt-1 text-sm text-danger">{{ $message }}</p>@enderror
            </div>

            <label class="flex items-center gap-2 text-sm">
                <input type="checkbox" name="remember">
                Remember me
            </label>

            <button type="submit" class="btn btn-md btn-solid btn-solid-primary w-full">Login</button>
        </form>

        <p class="mt-4 text-sm text-fg-muted">
            No account?
            <a href="{{ route('register') }}" class="text-primary hover:underline">Register</a>
        </p>
    </div>
</x-blog-layout>
