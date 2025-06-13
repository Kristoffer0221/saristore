@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto p-6">
    <h1 class="text-3xl font-bold text-orange-600 mb-6">🛒 Your Cart</h1>

    @if(count($cart) > 0)
        <form action="{{ route('cart.checkout') }}" method="POST" id="cartForm">
            @csrf
            <table class="w-full bg-white shadow-md rounded-lg overflow-hidden">
                <thead class="bg-orange-100 text-orange-800">
                    <tr>
                        <th class="p-4 w-16 text-center">
                            <input type="checkbox" id="selectAll" class="rounded text-orange-500 focus:ring-orange-500">
                        </th>
                        <th class="p-4 text-left w-1/3">Item</th>
                        <th class="p-4 text-center w-24">Price</th>
                        <th class="p-4 text-center w-40">Quantity</th>
                        <th class="p-4 text-center w-32">Total</th>
                        <th class="p-4 text-center w-24">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cart as $id => $item)
                    <tr class="border-b hover:bg-yellow-50" data-base-price="{{ number_format($item['price'], 2, '.', '') }}">
                        <td class="p-4 text-center">
                            <input type="checkbox" 
                                   name="selected_items[]" 
                                   value="{{ $id }}" 
                                   data-price="{{ number_format($item['price'], 2, '.', '') }}"
                                   class="item-checkbox rounded text-orange-500 focus:ring-orange-500">
                        </td>
                        <td class="p-4">
                            <div class="flex items-center gap-4">
                                <img src="{{ asset('storage/' . $item['image']) }}" 
                                     alt="{{ $item['name'] }}" 
                                     class="w-16 h-16 object-cover rounded">
                                <span class="font-medium">{{ $item['name'] }}</span>
                            </div>
                        </td>
                        <td class="p-4 text-center">₱{{ number_format($item['price'], 2, '.', ',') }}</td>
                        <td class="p-4">
                            <div class="flex items-center justify-center space-x-2">
                                <button type="button" 
                                        class="btn-minus w-8 h-8 rounded-full bg-red-500 hover:bg-red-600 text-white flex items-center justify-center focus:outline-none transition-colors">
                                    <span class="text-lg font-bold">-</span>
                                </button>
                                
                                <input type="text" 
                                       class="quantity-input w-12 h-8 text-center border rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500" 
                                       value="{{ $item['quantity'] }}" 
                                       min="1" 
                                       readonly>
                                
                                <button type="button" 
                                        class="btn-plus w-8 h-8 rounded-full bg-green-500 hover:bg-green-600 text-white flex items-center justify-center focus:outline-none transition-colors">
                                    <span class="text-lg font-bold">+</span>
                                </button>
                            </div>
                        </td>
                        <td class="p-4 text-center font-medium total-cell">
                            ₱{{ number_format($item['price'] * $item['quantity'], 2, '.', ',') }}
                        </td>
                        <td class="p-4 text-center">
                            <button onclick="removeItem({{ $id }})" 
                                    class="text-red-500 hover:text-red-700 transition-colors">
                                <span class="text-xl">🗑️</span>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-6 flex justify-between items-center">
                <div class="text-gray-600">
                    Selected Total: 
                    <span id="selectedTotal" class="font-semibold text-orange-600">₱0.00</span>
                    <span class="text-sm">
                        (Approx. $<span id="selectedTotalUSD">0.00</span> USD)
                    </span>
                </div>

                <button type="submit" 
                        class="inline-flex items-center px-6 py-2 bg-blue-600 text-white font-semibold rounded hover:bg-blue-700 transition disabled:opacity-50"
                        id="checkoutBtn" disabled>
                    💳 Checkout Selected Items
                </button>
            </div>
        </form>
    @else
        <p class="text-gray-600 text-center text-lg mt-10">Your cart is empty 😢</p>
    @endif
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const cartForm = document.getElementById('cartForm');
    const selectAll = document.getElementById('selectAll');
    const checkboxes = document.querySelectorAll('.item-checkbox');
    const checkoutBtn = document.getElementById('checkoutBtn');
    const selectedTotal = document.getElementById('selectedTotal');
    const selectedTotalUSD = document.getElementById('selectedTotalUSD');

    function updateTotal() {
        let total = 0;
        let hasSelected = false;
        
        checkboxes.forEach(checkbox => {
            if (checkbox.checked) {
                hasSelected = true;
                const row = checkbox.closest('tr');
                const quantity = parseInt(row.querySelector('.quantity-input').value);
                const price = parseFloat(checkbox.dataset.price);
                total += price * quantity;
            }
        });

        selectedTotal.textContent = `₱${number_format(total, 2, '.', ',')}`;
        checkoutBtn.disabled = !hasSelected;
    }

    // Add this helper function for number formatting
    function number_format(number, decimals, dec_point, thousands_sep) {
        return number.toLocaleString('en-US', {
            minimumFractionDigits: decimals,
            maximumFractionDigits: decimals
        });
    }

    // Handle select all
    selectAll.addEventListener('change', function() {
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
        updateTotal();
    });

    // Handle individual selections
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const allChecked = Array.from(checkboxes).every(cb => cb.checked);
            selectAll.checked = allChecked;
            updateTotal();
        });
    });

    // Handle quantity controls
    document.querySelectorAll('tr[data-base-price]').forEach(function(row) {
        const minusBtn = row.querySelector('.btn-minus');
        const plusBtn = row.querySelector('.btn-plus');
        const input = row.querySelector('.quantity-input');
        const totalCell = row.querySelector('.total-cell');
        const basePrice = parseFloat(row.dataset.basePrice);
        const checkbox = row.querySelector('.item-checkbox');
        const itemId = checkbox.value;

        async function updateQuantity(newQuantity) {
            try {
                const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                
                const response = await fetch(`/cart/${itemId}/quantity`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': token,
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({
                        quantity: newQuantity,
                        _token: token
                    })
                });

                if (!response.ok) {
                    const errorData = await response.json();
                    throw new Error(errorData.error || 'Failed to update quantity');
                }

                const data = await response.json();
                
                // Update the display
                totalCell.textContent = '₱' + data.newTotal.toFixed(2);
                input.value = newQuantity;
                checkbox.dataset.quantity = newQuantity;
                
                if (checkbox.checked) {
                    updateTotal();
                }
            } catch (error) {
                console.error('Error:', error);
                // Revert the input value
                input.value = parseInt(input.value) - (newQuantity > input.value ? 1 : -1);
                alert(error.message || 'Failed to update quantity. Please try again.');
            }
        }

        plusBtn.addEventListener('click', function() {
            const newQuantity = parseInt(input.value) + 1;
            updateQuantity(newQuantity);
        });

        minusBtn.addEventListener('click', function() {
            if (parseInt(input.value) > 1) {
                const newQuantity = parseInt(input.value) - 1;
                updateQuantity(newQuantity);
            }
        });
    });

    // Handle form submission
    cartForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const selectedItems = Array.from(checkboxes)
            .filter(cb => cb.checked)
            .map(cb => {
                const row = cb.closest('tr');
                return {
                    id: cb.value,
                    quantity: row.querySelector('.quantity-input').value
                };
            });

        if (selectedItems.length === 0) {
            alert('Please select items to checkout');
            return;
        }

        this.submit();
    });

    // Initialize totals
    updateTotal();
});

function removeItem(id) {
    if (confirm('Are you sure you want to remove this item?')) {
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        fetch(`/cart/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': token,
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Failed to remove item');
            }
            window.location.reload();
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to remove item. Please try again.');
        });
    }
}
</script>
@endsection
