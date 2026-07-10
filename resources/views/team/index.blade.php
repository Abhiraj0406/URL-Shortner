<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Team Members</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Flash success message --}}
            @if (session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100">
                <div class="p-6">

                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-semibold text-gray-800">Members in Your Company</h3>
                        {{-- Link to invite a new team member --}}
                        <a href="{{ route('team.create') }}"
                           class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition shadow-sm">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                            Invite Member
                        </a>
                    </div>

                    <div class="overflow-x-auto ring-1 ring-gray-200 rounded-lg shadow-sm">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Name</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Email</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Role</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Joined</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($members as $member)
                                    <tr class="hover:bg-gray-50 transition duration-150">
                                        <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">
                                            {{ $member->name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                            {{ $member->email }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium
                                                {{ $member->role === \App\Enums\Role::Admin ? 'bg-indigo-50 text-indigo-700 border border-indigo-200' : 'bg-emerald-50 text-emerald-700 border border-emerald-200' }}">
                                                {{ ucfirst($member->role->value) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $member->created_at->format('M d, Y') }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-16 text-center text-sm text-gray-500">
                                            No team members yet. <a href="{{ route('team.create') }}" class="text-indigo-600 hover:underline">Invite one</a>.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        <a href="{{ route('dashboard') }}" class="text-sm text-gray-600 hover:text-gray-900 flex items-center w-fit">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                            Back to Dashboard
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
