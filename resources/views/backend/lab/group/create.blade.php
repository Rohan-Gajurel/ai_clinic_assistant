@extends('backend.layout.app')

@section('title')
    <title>Create Lab Group - TeleMed Admin</title>
@endsection

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1 fw-semibold">Create Lab Group</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="{{ url('/dashboard') }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item active">Lab Groups</li>
            </ol>
        </nav>
    </div>
    <a href="{{ route('lab-group.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-2"></i>Back
    </a>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card shadow-sm">
            <div class="card-body">

                @if($errors->any())
                    <div class="alert alert-danger">
                        <strong>Please fix the errors below:</strong>
                        <ul class="mb-0 mt-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if(session('info'))
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle me-2"></i>{{ session('info') }}
                    </div>
                @endif

                <form action="{{ route('lab-group.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Lab Group Name</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Category</label>
                            <select name="category_id" id="category_id" class="form-select" required>
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Test</label>
                            <div id="select-category-msg" class="text-muted">Please select a category first</div>
                            <div id="tests-container" style="display: none; max-height: 300px; overflow-y: auto; border: 1px solid #dee2e6; border-radius: 0.375rem; padding: 10px;">
                                @foreach($tests as $test)
                                    <div class="form-check test-item" data-category="{{ $test->category_id }}" data-price="{{ $test->price ?? 0 }}">
                                        <input class="form-check-input test-checkbox" type="checkbox" name="test_ids[]" value="{{ $test->id }}" id="test{{ $test->id }}" {{ in_array($test->id, old('test_ids', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label d-flex justify-content-between w-100" for="test{{ $test->id }}">
                                            <span>{{ $test->name }}</span>
                                            <span class="badge bg-secondary">Rs. {{ number_format($test->price ?? 0, 2) }}</span>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            <small class="text-muted" id="no-tests-msg" style="display: none;">No tests available for this category</small>
                            
                            <div id="cost-summary" class="mt-3 p-3 bg-light rounded" style="display: none;">
                                <h6 class="mb-2">Selected Tests Cost:</h6>
                                <div id="selected-tests-list"></div>
                                <hr>
                                <div class="d-flex justify-content-between fw-bold">
                                    <span>Total:</span>
                                    <span id="total-cost">Rs. 0.00</span>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="form-label">Charge Amount</label>
                            <input type="number" name="charge_amount" class="form-control" value="{{ old('charge_amount') }}" required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-plus-lg me-1"></i>Create Lab Group
                    </button>

                    <a href="{{ route('lab-group.index') }}"
                       class="btn btn-light">
                        Cancel
                    </a>

                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('script')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const categorySelect = document.getElementById('category_id');
        const testItems = document.querySelectorAll('.test-item');
        const testCheckboxes = document.querySelectorAll('.test-checkbox');
        const noTestsMsg = document.getElementById('no-tests-msg');
        const testsContainer = document.getElementById('tests-container');
        const selectCategoryMsg = document.getElementById('select-category-msg');
        const costSummary = document.getElementById('cost-summary');
        const selectedTestsList = document.getElementById('selected-tests-list');
        const totalCostEl = document.getElementById('total-cost');

        function filterTests() {
            const selectedCategory = categorySelect.value;
            let visibleCount = 0;

            if (!selectedCategory) {
                testsContainer.style.display = 'none';
                selectCategoryMsg.style.display = 'block';
                costSummary.style.display = 'none';
                return;
            }

            selectCategoryMsg.style.display = 'none';
            testsContainer.style.display = 'block';

            testItems.forEach(function(item) {
                const testCategory = item.dataset.category;
                if (testCategory == selectedCategory) {
                    item.style.display = 'block';
                    visibleCount++;
                } else {
                    item.style.display = 'none';
                    item.querySelector('input[type="checkbox"]').checked = false;
                }
            });

            noTestsMsg.style.display = (visibleCount === 0) ? 'block' : 'none';
            calculateTotal();
        }

        function calculateTotal() {
            let total = 0;
            let selectedTests = [];

            testCheckboxes.forEach(function(checkbox) {
                if (checkbox.checked) {
                    const testItem = checkbox.closest('.test-item');
                    if (testItem.style.display !== 'none') {
                        const price = parseFloat(testItem.dataset.price) || 0;
                        const name = testItem.querySelector('.form-check-label span:first-child').textContent;
                        total += price;
                        selectedTests.push({ name: name, price: price });
                    }
                }
            });

            if (selectedTests.length > 0) {
                costSummary.style.display = 'block';
                selectedTestsList.innerHTML = selectedTests.map(test => 
                    `<div class="d-flex justify-content-between"><span>${test.name}</span><span>Rs. ${test.price.toFixed(2)}</span></div>`
                ).join('');
                totalCostEl.textContent = 'Rs. ' + total.toFixed(2);
            } else {
                costSummary.style.display = 'none';
            }
        }

        categorySelect.addEventListener('change', filterTests);
        
        testCheckboxes.forEach(function(checkbox) {
            checkbox.addEventListener('change', calculateTotal);
        });
        
        // Run on page load to handle old() values
        filterTests();
    });
</script>
@endpush
