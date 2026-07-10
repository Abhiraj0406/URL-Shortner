<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            {{-- Welcome Card --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100">
                <div class="p-6 text-gray-900 flex items-center justify-between">
                    <div>
                        <h3 class="text-2xl font-bold text-gray-800">Welcome back, {{ $user->name }}! 👋</h3>
                        <p class="mt-1 text-sm text-gray-500">Here's an overview of your URL shortener statistics.</p>
                    </div>
                    <div>
                        <span class="px-4 py-1.5 rounded-full text-sm font-semibold tracking-wide shadow-sm border
                            {{ $user->role === \App\Enums\Role::SuperAdmin ? 'bg-purple-50 text-purple-700 border-purple-200' : '' }}
                            {{ $user->role === \App\Enums\Role::Admin ? 'bg-indigo-50 text-indigo-700 border-indigo-200' : '' }}
                            {{ $user->role === \App\Enums\Role::Member ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : '' }}">
                            {{ ucfirst($user->role->value) }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- Main Content Card --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100">
                <div class="p-6 text-gray-900">

                    {{-- Actions Section --}}
                    <div class="flex items-center justify-between mb-6">
                        <h4 class="text-lg font-semibold text-gray-800">
                            @if ($user->role === \App\Enums\Role::Member) My Short URLs
                            @elseif ($user->role === \App\Enums\Role::Admin) Company Short URLs
                            @elseif ($user->role === \App\Enums\Role::SuperAdmin) All Short URLs (All Companies)
                            @endif
                        </h4>

                        <div class="flex space-x-3">
                            {{-- Generate Button (Admin & Member) --}}
                            @can('create', App\Models\ShortUrl::class)
                                <a href="{{ route('urls.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition shadow-sm">
                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                    Generate URL
                                </a>
                            @endcan

                            {{-- View Team + Invite Member (Admin) --}}
                            @if ($user->role === \App\Enums\Role::Admin)
                                <a href="{{ route('team.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition">
                                    <svg class="w-4 h-4 mr-1.5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0"></path></svg>
                                    View Team
                                </a>
                                <a href="{{ route('team.create') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition">
                                    <svg class="w-4 h-4 mr-1.5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                                    Invite Member
                                </a>
                            @endif

                            {{-- View Companies + Add Company (SuperAdmin) --}}
                            @if ($user->role === \App\Enums\Role::SuperAdmin)
                                <a href="{{ route('companies.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 transition">
                                    <svg class="w-4 h-4 mr-1.5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5"></path></svg>
                                    View Companies
                                </a>
                                <a href="{{ route('companies.create') }}" class="inline-flex items-center px-4 py-2 bg-purple-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 transition shadow-sm">
                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                    Add Company
                                </a>
                            @endif
                        </div>
                    </div>

                    {{-- Table Section --}}
                    <div class="overflow-x-auto ring-1 ring-gray-200 rounded-lg shadow-sm">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Short URL</th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Long URL</th>
                                    @if ($user->role === \App\Enums\Role::SuperAdmin)
                                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Company</th>
                                    @endif
                                    {{-- Hits column: shows redirect count for each short URL --}}
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Hits</th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Created On</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($shortUrls as $url)
                                    <tr class="hover:bg-gray-50 transition duration-150">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <a href="{{ url($url->code) }}" target="_blank" class="inline-flex items-center text-indigo-600 hover:text-indigo-900 font-medium group">
                                                {{ url($url->code) }}
                                                <svg class="w-3.5 h-3.5 ml-1.5 opacity-0 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                            </a>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="max-w-xs md:max-w-md lg:max-w-lg xl:max-w-xl truncate text-sm text-gray-600" title="{{ $url->long_url }}">
                                                {{ $url->long_url }}
                                            </div>
                                        </td>
                                        @if ($user->role === \App\Enums\Role::SuperAdmin)
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-gray-100 text-gray-700 border border-gray-200">
                                                    {{ $url->company->name ?? '—' }}
                                                </span>
                                            </td>
                                        @endif
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-700">
                                            {{ $url->hits }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $url->created_at->format('M d, Y') }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        {{-- SuperAdmin: 5 cols (Short URL + Long URL + Company + Hits + Created) --}}
                                        {{-- Admin/Member: 4 cols (Short URL + Long URL + Hits + Created) --}}
                                        <td colspan="{{ $user->role === \App\Enums\Role::SuperAdmin ? '5' : '4' }}" class="px-6 py-16 text-center">
                                            <div class="flex flex-col items-center justify-center">
                                                <div class="p-3 bg-gray-50 rounded-full border border-gray-100 mb-3">
                                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                                                </div>
                                                <h3 class="text-sm font-medium text-gray-900">No short URLs</h3>
                                                <p class="mt-1 text-sm text-gray-500">Get started by generating your first short URL.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>
