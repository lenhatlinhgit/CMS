<x-blog-layout title="Profile">
    <h1 class="mb-6 text-2xl font-semibold text-fg-title">Profile</h1>

    <form method="POST" action="{{ route('account.profile.update') }}" class="mx-auto max-w-md space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label for="name" class="mb-1 block text-sm font-medium">Name</label>
            <input id="name" type="text" name="name" value="{{ old('name', $user->name) }}" required
                class="w-full rounded-lg border border-border bg-card px-3 py-2">
            @error('name')<p class="mt-1 text-sm text-danger">{{ $message }}</p>@enderror
        </div>

        <div>
            <label for="email" class="mb-1 block text-sm font-medium">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}" required
                class="w-full rounded-lg border border-border bg-card px-3 py-2">
            @error('email')<p class="mt-1 text-sm text-danger">{{ $message }}</p>@enderror
        </div>

        <button type="submit" class="btn btn-md btn-solid btn-solid-primary">Save changes</button>
    </form>
</x-blog-layout>
