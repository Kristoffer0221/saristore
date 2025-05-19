@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
    {{-- Header Section --}}
    <div class="md:flex md:items-center md:justify-between mb-8">
        <div class="flex-1 min-w-0">
            <h1 class="text-3xl font-bold leading-7 text-gray-900 sm:text-4xl">
                User Management
            </h1>
        </div>
        <div class="mt-4 flex md:mt-0 md:ml-4 space-x-3">
            <button onclick="openAddModalUser(0)" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                <svg class="h-4 w-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                Add User
            </button>
            <button onclick="openAddModalAdmin(1)" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                <svg class="h-4 w-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                Add Admin
            </button>
        </div>
    </div>

    {{-- Alert Messages --}}
    @if(session('success'))
        <div class="rounded-md bg-green-50 p-4 mb-6 border border-green-200" id="flash-message">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

    {{-- Admin Accounts Section --}}
    <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-8">
        <div class="px-4 py-5 border-b border-gray-200 sm:px-6">
            <h2 class="text-xl font-bold text-red-600">Admin Accounts</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-red-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-black-500 uppercase tracking-wider">ID</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-black-500 uppercase tracking-wider">Name</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-black-500 uppercase tracking-wider">Email</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-black-500 uppercase tracking-wider">Address</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-black-500 uppercase tracking-wider">Phone</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-black-500 uppercase tracking-wider">Role</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-bold text-black-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($admins as $user)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $user->id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $user->email }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $user->address }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $user->phone }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    Admin
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-end space-x-2">
                                    <button onclick="openModal({{ $user->id }}, '{{ $user->name }}', '{{ $user->email }}' , '{{ $user->address }}' , '{{ $user->phone }}' , '{{ $user->is_admin  }}' )" class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">
                                        ✏️ Edit
                                    </button>
                                    <form action="{{ route('admin.products.delete', $user->id) }}" method="POST" onsubmit="return confirm('Delete this user?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">
                                            🗑️ Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- User Accounts Section (Similar structure as Admin section but with green theme) --}}
    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 border-b border-gray-200 sm:px-6">
            <h2 class="text-xl font-bold text-green-600">User Accounts</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-green-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-black-500 uppercase tracking-wider">ID</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-black-500 uppercase tracking-wider">Name</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-black-500 uppercase tracking-wider">Email</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-black-500 uppercase tracking-wider">Address</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-black-500 uppercase tracking-wider">Phone</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-black-500 uppercase tracking-wider">Role</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-bold text-black-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($users as $user)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $user->id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $user->email }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $user->address }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $user->phone }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    User
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-end space-x-2">
                                    <button onclick="openModal({{ $user->id }}, '{{ $user->name }}', '{{ $user->email }}' , '{{ $user->address }}' , '{{ $user->phone }}' , '{{ $user->is_admin  }}' )" class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">
                                        ✏️ Edit
                                    </button>
                                    <form action="{{ route('admin.products.delete', $user->id) }}" method="POST" onsubmit="return confirm('Delete this user?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">
                                            🗑️ Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>


<div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 transition-opacity duration-300">
    <div class="bg-white rounded-2xl w-full max-w-md p-8 relative transform transition-all scale-95 opacity-0 shadow-xl" id="editModalContent">
        <div class="absolute top-0 right-0 pt-4 pr-4">
            <button onclick="closeModal()" class="bg-white rounded-full p-2 hover:bg-gray-100 transition-colors focus:outline-none focus:ring-2 focus:ring-orange-500">
                <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <div class="text-center mb-8">
            <h2 class="text-2xl font-bold text-gray-900">Edit User</h2>
            <p class="mt-2 text-sm text-gray-500">Update user information below</p>
        </div>
        <form id="editForm" method="POST" class="space-y-4">
            @csrf
            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">Name</label>
                <input type="text" name="name" id="editName" 
                       class="w-full border-gray-300 rounded-md shadow-sm focus:ring-orange-500 focus:border-orange-500 transition-colors" 
                       required>
            </div>
            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" id="editEmail" 
                       class="w-full border-gray-300 rounded-md shadow-sm focus:ring-orange-500 focus:border-orange-500 transition-colors" 
                       required>
            </div>
            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">Address</label>
                <input type="text" name="address" id="editAddress" 
                       class="w-full border-gray-300 rounded-md shadow-sm focus:ring-orange-500 focus:border-orange-500 transition-colors" 
                       required>
            </div>
            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">Phone No.</label>
                <input type="text" name="phone" id="editPhone" 
                       class="w-full border-gray-300 rounded-md shadow-sm focus:ring-orange-500 focus:border-orange-500 transition-colors" 
                       required>
            </div>
            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">Role</label>
                <select name="is_admin" id="editRole" 
                        class="w-full border-gray-300 rounded-md shadow-sm focus:ring-orange-500 focus:border-orange-500 transition-colors">
                    <option value="0">User</option>
                    <option value="1">Admin</option>
                </select>
            </div>
            <div class="flex justify-end gap-3 mt-6">
                <button type="button" onclick="closeModal()" 
                        class="px-4 py-2 bg-white border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-colors">
                    Cancel
                </button>
                <button type="submit" 
                        class="px-4 py-2 bg-orange-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-colors">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ADD MODAL USER -->
<div id="addModalUser" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 transition-opacity duration-300">
    <div class="bg-white rounded-2xl w-full max-w-md p-8 relative transform transition-all scale-95 opacity-0 shadow-xl" id="addModalUserContent">
        <div class="absolute top-0 right-0 pt-4 pr-4">
            <button onclick="closeAddModal()" class="bg-white rounded-full p-2 hover:bg-gray-100 transition-colors focus:outline-none focus:ring-2 focus:ring-green-500">
                <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <div class="text-center mb-8">
            <h2 class="text-2xl font-bold text-green-600">Add User Account</h2>
            <p class="mt-2 text-sm text-gray-500">Fill in the information below to create a new user account</p>
        </div>
        <form action="{{ route('admin.user.add') }}" method="POST" class="space-y-4">
            @csrf
            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">Name</label>
                <input type="text" name="name" 
                       class="w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 transition-colors" 
                       required>
            </div>
            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" 
                       class="w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 transition-colors" 
                       required>
            </div>
            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" name="password" 
                       class="w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 transition-colors" 
                       required>
            </div>
            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">Address</label>
                <input type="text" name="address" 
                       class="w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 transition-colors" 
                       required>
            </div>
            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">Phone No.</label>
                <input type="text" name="phone" 
                       class="w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 transition-colors" 
                       required>
            </div>
            <input type="hidden" name="is_admin" value="0">

            <div class="flex justify-end gap-3 mt-6">
                <button type="button" onclick="closeAddModal()" 
                        class="px-4 py-2 bg-white border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors">
                    Cancel
                </button>
                <button type="submit" 
                        class="px-4 py-2 bg-green-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors">
                    Add User
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ADD MODAL ADMIN -->
<div id="addModalAdmin" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 transition-opacity duration-300">
    <div class="bg-white rounded-2xl w-full max-w-md p-8 relative transform transition-all scale-95 opacity-0 shadow-xl" id="addModalAdminContent">
        <div class="absolute top-0 right-0 pt-4 pr-4">
            <button onclick="closeAddModal()" class="bg-white rounded-full p-2 hover:bg-gray-100 transition-colors focus:outline-none focus:ring-2 focus:ring-red-500">
                <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <div class="text-center mb-8">
            <h2 class="text-2xl font-bold text-red-600">Add Admin Account</h2>
            <p class="mt-2 text-sm text-gray-500">Fill in the information below to create a new admin account</p>
        </div>
        <form action="{{ route('admin.admins.add') }}" method="POST" class="space-y-4">
            @csrf
            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">Name</label>
                <input type="text" name="name" 
                       class="w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500 transition-colors" 
                       required>
            </div>
            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" 
                       class="w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500 transition-colors" 
                       required>
            </div>
            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" name="password" 
                       class="w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500 transition-colors" 
                       required>
            </div>
            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">Address</label>
                <input type="text" name="address" 
                       class="w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500 transition-colors" 
                       required>
            </div>
            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">Phone No.</label>
                <input type="text" name="phone" 
                       class="w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500 transition-colors" 
                       required>
            </div>
            <input type="hidden" name="is_admin" value="1">

            <div class="flex justify-end gap-3 mt-6">
                <button type="button" onclick="closeAddModal()" 
                        class="px-4 py-2 bg-white border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors">
                    Cancel
                </button>
                <button type="submit" 
                        class="px-4 py-2 bg-red-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors">
                    Add Admin
                </button>
            </div>
        </form>
    </div>
</div>


<!-- MODAL SCRIPT -->
<script>
    // Enhanced animations for modals
    function animateModal(modal, modalContent, show) {
        if (show) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            // Add entrance animation
            setTimeout(() => {
                modalContent.classList.remove('scale-95', 'opacity-0');
                modalContent.classList.add('scale-100', 'opacity-100', 'translate-y-0');
            }, 50);
        } else {
            // Add exit animation
            modalContent.classList.remove('scale-100', 'opacity-100', 'translate-y-0');
            modalContent.classList.add('scale-95', 'opacity-0', '-translate-y-4');
            setTimeout(() => {
                modal.classList.remove('flex');
                modal.classList.add('hidden');
            }, 200);
        }
    }

    // Update your existing modal functions to use the new animation
    function openModal(id, name, email, address, phone, is_admin) {
        const modal = document.getElementById('editModal');
        const modalContent = document.getElementById('editModalContent');
        animateModal(modal, modalContent, true);
        // Fill form fields
        document.getElementById('editName').value = name;
        document.getElementById('editEmail').value = email;
        document.getElementById('editAddress').value = address;
        document.getElementById('editPhone').value = phone;
        document.getElementById('editRole').value = is_admin;
        document.getElementById('editForm').action = `/admin/users/${id}/update`;
    }

    function closeModal() {
        const modal = document.getElementById('editModal');
        const modalContent = document.getElementById('editModalContent');
        animateModal(modal, modalContent, false);
    }

    function openAddModalUser() {
        const modal = document.getElementById('addModalUser');
        const modalContent = document.getElementById('addModalUserContent');
        animateModal(modal, modalContent, true);
    }

    function openAddModalAdmin() {
        const modal = document.getElementById('addModalAdmin');
        const modalContent = document.getElementById('addModalAdminContent');
        animateModal(modal, modalContent, true);
    }

    function closeAddModal() {
        const userModal = document.getElementById('addModalUser');
        const adminModal = document.getElementById('addModalAdmin');
        const userModalContent = document.getElementById('addModalUserContent');
        const adminModalContent = document.getElementById('addModalAdminContent');
        
        if (!userModal.classList.contains('hidden')) {
            animateModal(userModal, userModalContent, false);
        }
        
        if (!adminModal.classList.contains('hidden')) {
            animateModal(adminModal, adminModalContent, false);
        }
    }

    // Add click outside to close functionality
    document.getElementById('addModalUser').addEventListener('click', function(e) {
        if (e.target === this) closeAddModal();
    });

    document.getElementById('addModalAdmin').addEventListener('click', function(e) {
        if (e.target === this) closeAddModal();
    });

    window.onload = function() {
        // CHECK IF FLASH MESSAGE EXISTS
        var flashMessage = document.getElementById('flash-message');
        if (flashMessage) {
            // SET A TIMER TO REMOVE THE MESSAGE AFTER 5 SECONDS (5000 MS)
            setTimeout(function() {
                flashMessage.style.display = 'none';
            }, 5000); // YOU CAN CHANGE THE TIME (5000 MS = 5 SECONDS)
        }
    }
</script>
@endsection
