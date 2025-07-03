?>
@extends('layout.headfoot')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-green-50 to-white">
    <!-- Header Section -->
    <div class="bg-green-500 text-white py-16">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-4xl font-bold mb-4">Find Your Perfect Sport Event</h1>
            <p class="text-xl opacity-90">Booking premium sports facilities for your special events</p>
        </div>
    </div>

    <!-- Events Grid -->
    <div class="container mx-auto px-4 py-12">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($events as $event)
            <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                @if($event->image)
                    <img src="{{ Storage::url($event->image) }}" alt="{{ $event->title }}" 
                         class="w-full h-48 object-cover">
                @else
                    <div class="w-full h-48 bg-gradient-to-r from-green-400 to-blue-500 flex items-center justify-center">
                        <svg class="w-16 h-16 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                @endif
                
                <div class="p-6">
                    <h3 class="text-xl font-bold mb-2 text-gray-800">{{ $event->title }}</h3>
                    <p class="text-gray-600 mb-4 line-clamp-3">{{ $event->description }}</p>
                    
                    <div class="space-y-2 mb-6">
                        <div class="flex items-center text-sm text-gray-500">
                            <svg class="w-4 h-4 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                            </svg>
                            {{ $event->start_date->format('d M Y, H:i') }}
                        </div>
                        
                        <div class="flex items-center text-sm text-gray-500">
                            <svg class="w-4 h-4 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                            </svg>
                            {{ $event->location }}
                        </div>
                        
                        <div class="flex items-center justify-between pt-2">
                            <span class="text-xl font-bold text-green-600">{{ $event->formatted_price }}</span>
                            @if($event->max_participants)
                                <span class="text-sm px-2 py-1 bg-gray-100 rounded-full">
                                    {{ $event->current_participants }}/{{ $event->max_participants }}
                                </span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="flex gap-2">
                        <button onclick="openEventModal({{ $event->id }})" 
                                class="flex-1 bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded transition-colors">
                            View Details
                        </button>
                        
                        @if($event->is_full)
                            <button disabled 
                                    class="flex-1 bg-gray-400 text-white font-medium py-2 px-4 rounded cursor-not-allowed">
                                Full
                            </button>
                        @else
                            <button onclick="openRegisterModal({{ $event->id }})" 
                                    class="flex-1 bg-green-500 hover:bg-green-600 text-white font-medium py-2 px-4 rounded transition-colors">
                                Register
                            </button>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Event Detail Modal -->
<div id="eventModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-lg max-w-2xl w-full max-h-[90vh] overflow-y-auto">
        <div class="p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 id="modalTitle" class="text-2xl font-bold"></h2>
                <button onclick="closeEventModal()" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <div id="modalImage" class="mb-4"></div>
            <div id="modalDescription" class="text-gray-600 mb-6"></div>
            
            <div class="bg-gray-50 p-4 rounded-lg">
                <h3 class="font-bold mb-3">Event Information</h3>
                <div id="modalDetails" class="space-y-2"></div>
            </div>
            
            <div class="mt-6 flex gap-3">
                <button onclick="closeEventModal()" 
                        class="flex-1 bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded transition-colors">
                    Close
                </button>
                <button id="modalRegisterBtn" onclick="switchToRegister()" 
                        class="flex-1 bg-green-500 hover:bg-green-600 text-white font-medium py-2 px-4 rounded transition-colors">
                    Register Now
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Registration Modal -->
<div id="registerModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-lg max-w-lg w-full max-h-[90vh] overflow-y-auto">
        <div class="p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 id="registerTitle" class="text-2xl font-bold">Register for Event</h2>
                <button onclick="closeRegisterModal()" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <div id="alertContainer"></div>
            
            <form id="registrationForm">
                @csrf
                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Full Name *</label>
                        <input type="text" name="name" required 
                               class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                        <input type="email" name="email" required
                               class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Phone *</label>
                        <input type="text" name="phone" required
                               class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Address</label>
                        <textarea name="address" rows="3"
                                  class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500"></textarea>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Birth Date</label>
                            <input type="date" name="birth_date"
                                   class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Gender</label>
                            <select name="gender" 
                                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
                                <option value="">Select Gender</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Emergency Contact</label>
                        <input type="text" name="emergency_contact"
                               class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Notes</label>
                        <textarea name="notes" rows="3"
                                  class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500"></textarea>
                    </div>
                    
                    <div class="flex gap-3 pt-4">
                        <button type="button" onclick="closeRegisterModal()" 
                                class="flex-1 bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded transition-colors">
                            Cancel
                        </button>
                        <button type="submit" 
                                class="flex-1 bg-green-500 hover:bg-green-600 text-white font-medium py-2 px-4 rounded transition-colors">
                            Register Now
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
let currentEvent = null;
const events = @json($events);

function openEventModal(eventId) {
    currentEvent = events.find(e => e.id === eventId);
    if (!currentEvent) return;
    
    document.getElementById('modalTitle').textContent = currentEvent.title;
    document.getElementById('modalDescription').textContent = currentEvent.description;
    
    // Set image
    const modalImage = document.getElementById('modalImage');
    if (currentEvent.image) {
        modalImage.innerHTML = `<img src="/storage/${currentEvent.image}" alt="${currentEvent.title}" class="w-full h-48 object-cover rounded-lg">`;
    } else {
        modalImage.innerHTML = '';
    }
    
    // Set details
    const details = document.getElementById('modalDetails');
    const startDate = new Date(currentEvent.start_date).toLocaleString('id-ID');
    const endDate = new Date(currentEvent.end_date).toLocaleString('id-ID');
    
    details.innerHTML = `
        <div class="flex justify-between"><span>Start Date:</span><span class="font-semibold">${startDate}</span></div>
        <div class="flex justify-between"><span>End Date:</span><span class="font-semibold">${endDate}</span></div>
        <div class="flex justify-between"><span>Location:</span><span class="font-semibold">${currentEvent.location}</span></div>
        <div class="flex justify-between"><span>Price:</span><span class="font-semibold text-green-600">${currentEvent.formatted_price}</span></div>
        ${currentEvent.max_participants ? 
            `<div class="flex justify-between"><span>Available Spots:</span><span class="font-semibold">${currentEvent.max_participants - currentEvent.current_participants}</span></div>` 
            : ''}
    `;
    
    // Handle register button
    const registerBtn = document.getElementById('modalRegisterBtn');
    if (currentEvent.current_participants >= currentEvent.max_participants && currentEvent.max_participants) {
        registerBtn.style.display = 'none';
    } else {
        registerBtn.style.display = 'block';
    }
    
    document.getElementById('eventModal').classList.remove('hidden');
}

function closeEventModal() {
    document.getElementById('eventModal').classList.add('hidden');
}

function openRegisterModal(eventId) {
    currentEvent = events.find(e => e.id === eventId);
    if (!currentEvent) return;
    
    document.getElementById('registerTitle').textContent = `Register for ${currentEvent.title}`;
    document.getElementById('alertContainer').innerHTML = '';
    document.getElementById('registrationForm').reset();
    document.getElementById('registerModal').classList.remove('hidden');
}

function closeRegisterModal() {
    document.getElementById('registerModal').classList.add('hidden');
}

function switchToRegister() {
    closeEventModal();
    openRegisterModal(currentEvent.id);
}

// Handle form submission
document.getElementById('registrationForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const submitBtn = this.querySelector('button[type="submit"]');
    
    submitBtn.disabled = true;
    submitBtn.textContent = 'Registering...';
    
    try {
        const response = await fetch(`/events/${currentEvent.id}/register`, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        });
        
        const result = await response.json();
        
        if (result.success) {
            showAlert('success', result.message);
            this.reset();
            
            // Update event data
            currentEvent.current_participants++;
            
            setTimeout(() => {
                closeRegisterModal();
                location.reload(); // Refresh to update participant count
            }, 2000);
        } else {
            showAlert('error', result.message);
        }
    } catch (error) {
        showAlert('error', 'Terjadi kesalahan. Silakan coba lagi.');
    } finally {
        submitBtn.disabled = false;
        submitBtn.textContent = 'Register Now';
    }
});

function showAlert(type, message) {
    const alertContainer = document.getElementById('alertContainer');
    const alertClass = type === 'success' ? 'bg-green-100 border-green-400 text-green-700' : 'bg-red-100 border-red-400 text-red-700';
    
    alertContainer.innerHTML = `
        <div class="${alertClass} border px-4 py-3 rounded mb-4">
            ${message}
        </div>
    `;
}

// Close modals when clicking outside
document.getElementById('eventModal').addEventListener('click', function(e) {
    if (e.target === this) closeRegisterModal();
});

// Close modals with Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeEventModal();
        closeRegisterModal();
    }
});

// Form validation
function validateForm() {
    const requiredFields = ['name', 'email', 'phone'];
    let isValid = true;
    
    requiredFields.forEach(field => {
        const input = document.querySelector(`input[name="${field}"]`);
        if (!input.value.trim()) {
            input.classList.add('border-red-500');
            isValid = false;
        } else {
            input.classList.remove('border-red-500');
        }
    });
    
    return isValid;
}

// Email validation
function validateEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
}

// Phone validation (Indonesian format)
function validatePhone(phone) {
    const re = /^(\+62|62|0)[0-9]{9,13}$/;
    return re.test(phone.replace(/[\s-]/g, ''));
}

// Enhanced form submission with validation
document.getElementById('registrationForm').addEventListener('input', function(e) {
    const field = e.target;
    
    // Remove error styling on input
    field.classList.remove('border-red-500');
    
    // Real-time validation
    if (field.name === 'email' && field.value) {
        if (!validateEmail(field.value)) {
            field.classList.add('border-red-500');
        }
    }
    
    if (field.name === 'phone' && field.value) {
        if (!validatePhone(field.value)) {
            field.classList.add('border-red-500');
        }
    }
});

// Auto-format phone number
document.querySelector('input[name="phone"]').addEventListener('input', function(e) {
    let value = e.target.value.replace(/\D/g, '');
    
    // Add +62 prefix if starting with 0
    if (value.startsWith('0')) {
        value = '62' + value.substring(1);
    }
    
    // Format display
    if (value.startsWith('62')) {
        e.target.value = '+' + value;
    }
});

// Initialize tooltips or additional features
document.addEventListener('DOMContentLoaded', function() {
    // Add loading states
    const buttons = document.querySelectorAll('button');
    buttons.forEach(button => {
        button.addEventListener('click', function() {
            if (this.type !== 'button') {
                this.style.pointerEvents = 'none';
                setTimeout(() => {
                    this.style.pointerEvents = 'auto';
                }, 1000);
            }
        });
    });
    
    // Auto-hide alerts after 5 seconds
    setTimeout(() => {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            alert.style.transition = 'opacity 0.5s';
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 500);
        });
    }, 5000);
});
</script>

@endsection