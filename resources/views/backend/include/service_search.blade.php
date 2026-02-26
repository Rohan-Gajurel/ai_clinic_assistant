<input type="text" class="form-control form-control-sm service-search" placeholder="Type to search..." autocomplete="off">

@push('script')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Service Search AJAX (using event delegation for dynamic rows)
        const itemsBody = document.getElementById('itemsBody');
        let serviceSearchTimeout;

        if (itemsBody) {
            itemsBody.addEventListener('input', function(e) {
                if (e.target.classList.contains('service-search')) {
                    const input = e.target;
                    const row = input.closest('.item-row');
                    const resultsDiv = row.querySelector('.service-results');
                    
                    clearTimeout(serviceSearchTimeout);
                    const query = input.value.trim();
                    
                    if (query.length < 2) {
                        resultsDiv.style.display = 'none';
                        return;
                    }

                    serviceSearchTimeout = setTimeout(() => {
                        fetch(`{{ route('bills.serviceSearch') }}?query=${encodeURIComponent(query)}`, {
                            headers: {
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                        .then(services => {
                            if (services.length === 0) {
                                resultsDiv.innerHTML = '<div class="p-3 text-muted">No services found</div>';
                            } else {
                                resultsDiv.innerHTML = services.map(service => `
                                    <div class="service-item p-2 border-bottom" style="cursor: pointer;" 
                                        data-id="${service.id}" 
                                        data-name="${service.name}" 
                                        data-code="${service.code || ''}" 
                                        data-price="${service.price || 0}">
                                        <div class="fw-semibold">${service.name}</div>
                                        <small class="text-muted">${service.code || ''} | Rs. ${parseFloat(service.price || 0).toFixed(2)}</small>
                                    </div>
                                `).join('');
                            }
                            resultsDiv.style.display = 'block';
                        })
                        .catch(err => {
                            console.error('Search error:', err);
                            resultsDiv.innerHTML = '<div class="p-3 text-danger">Error searching services</div>';
                            resultsDiv.style.display = 'block';
                        });
                    }, 300);
                }
            });

            // Select service from results
            itemsBody.addEventListener('click', function(e) {
                const item = e.target.closest('.service-item');
                if (item) {
                    const row = item.closest('.item-row');
                    const serviceInput = row.querySelector('.service-search');
                    const serviceId = row.querySelector('.service-id');
                    const serviceName = row.querySelector('.service-name');
                    const rateInput = row.querySelector('.rate-input');
                    const resultsDiv = row.querySelector('.service-results');

                    const id = item.dataset.id;
                    const name = item.dataset.name;
                    const price = parseFloat(item.dataset.price) || 0;

                    serviceId.value = id;
                    serviceName.value = name;
                    serviceInput.value = name;
                    rateInput.value = price.toFixed(2);
                    resultsDiv.style.display = 'none';

                    // Trigger calculation
                    if (typeof calculateRowAmount === 'function') calculateRowAmount(row);
                    if (typeof calculateTotals === 'function') calculateTotals();
                }
            });

            // Hover effect for service items
            itemsBody.addEventListener('mouseover', function(e) {
                const item = e.target.closest('.service-item');
                if (item) item.style.backgroundColor = '#f8f9fa';
            });
            itemsBody.addEventListener('mouseout', function(e) {
                const item = e.target.closest('.service-item');
                if (item) item.style.backgroundColor = '';
            });
        }

        // Hide service results on click outside
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.item-row')) {
                document.querySelectorAll('.service-results').forEach(div => {
                    div.style.display = 'none';
                });
            }
        });
    });
</script>
@endpush