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
                        <th class="p-4 w-10">
                            <input type="checkbox" id="selectAll" class="rounded text-orange-500 focus:ring-orange-500">
                        </th>
                        <th class="p-4 text-left">Item</th>
                        <th class="p-4">Price</th>
                        <th class="p-4">Quantity</th>
                        <th class="p-4">Total</th>
                        <th class="p-4">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cart as $id => $item)
                    <tr class="border-b hover:bg-yellow-50">
                        <td class="p-4">
                            <input type="checkbox" name="selected_items[]" value="{{ $id }}" 
                                   class="item-checkbox rounded text-orange-500 focus:ring-orange-500"
                                   data-price="{{ $item['price'] }}"
                                   data-quantity="{{ $item['quantity'] }}">
                        </td>
                        <td class="p-4 flex items-center gap-4">
                            <img src="{{ asset('storage/' . $item['image']) }}" alt="{{ $item['name'] }}" 
                                 class="w-16 h-16 object-cover rounded">
                            <span>{{ $item['name'] }}</span>
                        </td>
                        <td class="p-4">₱{{ number_format($item['price'], 2) }}</td>
                        <td class="p-4">
                            <div class="flex items-center gap-2">
                                <input type="number" name="quantities[{{ $id }}]" value="{{ $item['quantity'] }}" 
                                       min="1" class="w-16 text-center border rounded">
                            </div>
                        </td>
                        <td class="p-4">₱{{ number_format($item['price'] * $item['quantity'], 2) }}</td>
                        <td class="p-4">
                            <button type="button" onclick="removeItem('{{ $id }}')" 
                                    class="text-red-600 hover:underline">
                                🗑️ Remove
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
                const price = parseFloat(checkbox.dataset.price);
                const quantity = parseInt(checkbox.dataset.quantity);
                total += price * quantity;
            }
        });

        selectedTotal.textContent = `₱${total.toFixed(2)}`;
        selectedTotalUSD.textContent = (total / 56).toFixed(2);
        checkoutBtn.disabled = !hasSelected;
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

    // Handle form submission
    cartForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const selectedItems = Array.from(checkboxes)
            .filter(cb => cb.checked)
            .map(cb => cb.value);

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
    if (confirm('Remove this item?')) {
        fetch(`/cart/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        }).then(() => window.location.reload());
    }
}
</script>
@endsection
