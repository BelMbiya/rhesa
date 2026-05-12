<?php

namespace App\Livewire\hotel;

use App\Mail\RegistrationCancelled;
use App\Mail\RegistrationConfirmed;
use App\Models\Registration;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;


class HotelClientManagement extends Component
{
    use WithPagination;

    public string $search       = '';
    public string $filterStatus = 'all'; // 'all' | 'today' | 'confirmed' | 'pending' | 'cancelled'

    protected $queryString = ['search', 'filterStatus'];

    public ?int $confirmingId = null;
public ?int $cancellingId = null;

    // ── Hotel ────────────────────────────────────────────────────────────────

    public function getHotelProperty()
    {
        $hotel = auth()->user()->hotel;
        abort_unless($hotel, 403, 'Aucun hôtel associé à votre compte.');
        return $hotel;
    }

    // ── Actions ──────────────────────────────────────────────────────────────

    public function confirmRegistration(int $registrationId): void
    {
        $registration = Registration::with(['stay.client'])->findOrFail($registrationId);
        $this->authorizeHotel($registration);

        $registration->update([
            'status'      => 'confirmed',
            'reviewed_at' => now(),
            'reviewed_by' => auth()->id(),
        ]);

        $client = $registration->stay->client;

        if ($client->email) {
            try {
                Mail::to($client->email)->send(
                    new RegistrationConfirmed($registration)
                );
            } catch (\Throwable $e) {
                \Log::error('Mail confirmation failed: ' . $e->getMessage());
            }
        }

        $this->confirmingId = null;
        $this->js('window.location.reload()');
    }

    public function cancelRegistration(int $registrationId): void
    {
        $registration = Registration::with(['stay.client'])->findOrFail($registrationId);
        $this->authorizeHotel($registration);

        $client = $registration->stay->client;
        $stay   = $registration->stay;

        if ($client->email) {
            try {
                Mail::to($client->email)->send(
                    new RegistrationCancelled($registration)
                );
            } catch (\Throwable $e) {
                \Log::error('Mail cancellation failed: ' . $e->getMessage());
            }
        }

        foreach (['identity_image', 'selfi'] as $field) {
            if ($client->$field) {
                \Storage::disk('public')->delete($client->$field);
            }
        }
        if ($registration->signature) {
            \Storage::disk('public')->delete($registration->signature);
        }

        $registration->delete();
        $stay->delete();
        $client->delete();

        $this->cancellingId = null;
        $this->js('window.location.reload()');
    }

    // ── Helpers ──────────────────────────────────────────────────────────────

    private function authorizeHotel(Registration $registration): void
    {
        abort_unless(
            $registration->hotel_id === $this->hotel->id,
            403,
            'Action non autorisée.'
        );
    }

    public function updatingSearch(): void       { $this->resetPage(); }
    public function updatingFilterStatus(): void { $this->resetPage(); }

    // ── Nettoyage séparé (ne pas mettre dans render) ─────────────────────────

    public function cleanExpired(): void
    {
        $expiredRegistrations = Registration::where('status', 'pending')
            ->whereDate('created_at', '<', now()->toDateString())
            ->get();

        foreach ($expiredRegistrations as $reg) {
            DB::transaction(function () use ($reg) {
                if ($reg->stay) {
                    if ($reg->stay->client) {
                        foreach (['identity_image', 'selfi'] as $field) {
                            if ($reg->stay->client->$field) {
                                \Storage::disk('public')->delete($reg->stay->client->$field);
                            }
                        }
                        $reg->stay->client->delete();
                    }
                    $reg->stay->delete();
                }
                if ($reg->signature) {
                    \Storage::disk('public')->delete($reg->signature);
                }
                $reg->delete();
            });
        }
    }

    // ── Render ───────────────────────────────────────────────────────────────

    public function render()
{
    $hotel = $this->hotel;

    $query = Registration::where('hotel_id', $hotel->id)
        ->with(['stay.client']);

    match ($this->filterStatus) {
        'today'     => $query->whereDate('created_at', now()->toDateString()),
        'pending'   => $query->where('status', 'pending'),
        'confirmed' => $query->where('status', 'confirmed'),
        'cancelled' => $query->where('status', 'cancelled'),
        default     => null,
    };

    if (!empty(trim($this->search))) {
        $search = trim($this->search);
        $query->whereHas('stay.client', function ($q) use ($search) {
            $q->where('first_name', 'like', "%{$search}%")
              ->orWhere('last_name', 'like', "%{$search}%")
              ->orWhere('identity_number', 'like', "%{$search}%");
        });
    }

    $registrations = $query->latest()->paginate(10);

    $countToday = Registration::where('hotel_id', $hotel->id)
        ->whereDate('created_at', now()->toDateString())
        ->count();

    return view('livewire.hotel.hotel-client-management', [
        'registrations'  => $registrations,
        'hotel'          => $hotel,
        'countToday'     => $countToday,
        // ✅ Ces deux variables manquaient
        'confirmingId'   => $this->confirmingId,
        'cancellingId'   => $this->cancellingId,
    ]);
}
}