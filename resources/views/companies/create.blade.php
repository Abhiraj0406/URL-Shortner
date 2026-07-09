<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Invite New Company</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100">
                <div class="p-8">

                    <div class="mb-8">
                        <h3 class="text-xl font-bold text-gray-800">Create a new company</h3>
                        <p class="mt-1 text-sm text-gray-500">This will create the company and assign it a dedicated Admin user.</p>
                    </div>

                    {{-- @csrf: injects hidden CSRF token to protect against Cross-Site Request Forgery --}}
                    <form method="POST" action="{{ route('companies.store') }}">
                        @csrf

                        {{-- Company Details Section --}}
                        <div class="mb-6 pb-6 border-b border-gray-100">
                            <h4 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-4">Company Details</h4>

                            <div class="mb-4">
                                <label for="company_name" class="block text-sm font-medium text-gray-700 mb-1">Company Name <span class="text-red-500">*</span></label>
                                <input
                                    type="text"
                                    id="company_name"
                                    name="company_name"
                                    value="{{ old('company_name') }}"
                                    placeholder="e.g. Acme Corp"
                                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-purple-500 focus:border-purple-500 sm:text-sm @error('company_name') border-red-300 @enderror">
                                {{-- @error: Blade directive that renders if validation fails for this field --}}
                                @error('company_name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Admin User Section --}}
                        <div class="mb-6">
                            <h4 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-4">Admin User for this Company</h4>

                            <div class="mb-4">
                                <label for="admin_name" class="block text-sm font-medium text-gray-700 mb-1">Admin Name <span class="text-red-500">*</span></label>
                                <input
                                    type="text"
                                    id="admin_name"
                                    name="admin_name"
                                    value="{{ old('admin_name') }}"
                                    placeholder="e.g. John Doe"
                                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-purple-500 focus:border-purple-500 sm:text-sm @error('admin_name') border-red-300 @enderror">
                                @error('admin_name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="admin_email" class="block text-sm font-medium text-gray-700 mb-1">Admin Email <span class="text-red-500">*</span></label>
                                <input
                                    type="email"
                                    id="admin_email"
                                    name="admin_email"
                                    value="{{ old('admin_email') }}"
                                    placeholder="e.g. admin@acme.com"
                                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-purple-500 focus:border-purple-500 sm:text-sm @error('admin_email') border-red-300 @enderror">
                                @error('admin_email')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password <span class="text-red-500">*</span></label>
                                <input
                                    type="password"
                                    id="password"
                                    name="password"
                                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-purple-500 focus:border-purple-500 sm:text-sm @error('password') border-red-300 @enderror">
                                @error('password')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-6">
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password <span class="text-red-500">*</span></label>
                                <input
                                    type="password"
                                    id="password_confirmation"
                                    name="password_confirmation"
                                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-purple-500 focus:border-purple-500 sm:text-sm">
                            </div>
                        </div>

                        {{-- Form Actions --}}
                        <div class="flex items-center justify-between border-t border-gray-100 pt-4">
                            {{-- route(): generates the named route URL for dashboard --}}
                            <a href="{{ route('dashboard') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900 transition flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                                Back to Dashboard
                            </a>
                            <button type="submit" class="inline-flex items-center px-6 py-2.5 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                Create Company
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
