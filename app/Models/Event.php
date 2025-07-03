<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'image',
        'start_date',
        'end_date',
        'location',
        'price',
        'max_participants',
        'status',
        'registrations'
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'price' => 'decimal:2',
        'registrations' => 'array'
    ];

    public function getCurrentParticipantsAttribute(): int
    {
        return count($this->registrations ?? []);
    }

    public function getSpotsRemainingAttribute(): int
    {
        if (!$this->max_participants) {
            return 999; // Unlimited
        }
        return max(0, $this->max_participants - $this->current_participants);
    }

    public function getIsFullAttribute(): bool
    {
        if (!$this->max_participants) {
            return false;
        }
        return $this->current_participants >= $this->max_participants;
    }

    public function getFormattedPriceAttribute(): string
    {
        if ($this->price == 0) {
            return 'Free';
        }
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    public function addRegistration(array $data): bool
    {
        if ($this->is_full) {
            return false;
        }

        $registrations = $this->registrations ?? [];
        
        // Add registration with timestamp and ID
        $registration = array_merge($data, [
            'id' => count($registrations) + 1,
            'registered_at' => now()->toISOString(),
            'status' => 'registered'
        ]);
        
        $registrations[] = $registration;
        
        $this->update(['registrations' => $registrations]);
        return true;
    }

    public function getRegistrations(): array
    {
        return $this->registrations ?? [];
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeUpcoming($query)
    {
        return $query->where('start_date', '>', now());
    }
}