<?php

namespace App\Livewire\hotel;

use App\Models\Registration;
use App\Models\Stay;
use App\Models\Client;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Carbon\Carbon;

class HotelDashboard extends Component
{
    public function getHotelProperty()
    {
        $hotel = auth()->user()->hotel;
        abort_unless($hotel, 403, 'Aucun hôtel associé à votre compte.');
        return $hotel;
    }

    private function baseQuery()
    {
        return Registration::where('hotel_id', $this->hotel->id)
            ->whereDate('registration_date', today());
    }

    public function getTodayCountProperty(): int
    {
        return $this->baseQuery()->count();
    }

    public function getTodayPendingProperty(): int
    {
        return $this->baseQuery()->where('status', 'pending')->count();
    }

    public function getTodayConfirmedProperty(): int
    {
        return $this->baseQuery()->where('status', 'confirmed')->count();
    }

    public function getTodayCancelledProperty(): int
    {
        return $this->baseQuery()->where('status', 'cancelled')->count();
    }

    public function getTotalClientsProperty(): int
    {
        return Client::whereHas('stays.registration', function ($q) {
            $q->where('hotel_id', $this->hotel->id);
        })->count();
    }

    public function getCurrentGuestsProperty(): int
    {
        return Stay::whereHas('registration', function ($q) {
                $q->where('hotel_id', $this->hotel->id)
                  ->where('status', 'confirmed');
            })
            ->whereDate('check_in',  '<=', today())
            ->whereDate('check_out', '>=', today())
            ->count();
    }

    public function getRecentRegistrationsProperty()
    {
        return Registration::with(['stay.client'])
            ->where('hotel_id', $this->hotel->id)
            ->whereDate('registration_date', today())
            ->where('status', 'pending')
            ->latest('registration_time')
            ->take(5)
            ->get();
    }

    public function getWeeklyStatsProperty(): array
    {
        $stats = [];
        for ($i = 6; $i >= 0; $i--) {
            $date    = Carbon::today()->subDays($i);
            $stats[] = [
                'label' => $date->format('d/m'),
                'count' => Registration::where('hotel_id', $this->hotel->id)
                    ->whereDate('registration_date', $date)
                    ->where('status', 'confirmed')
                    ->count(),
            ];
        }
        return $stats;
    }

    public function render()
    {
        return view('livewire.hotel.hotel-dashboard', [
            'hotel'               => $this->hotel,
            'todayCount'          => $this->todayCount,
            'todayPending'        => $this->todayPending,
            'todayConfirmed'      => $this->todayConfirmed,
            'todayCancelled'      => $this->todayCancelled,
            'totalClients'        => $this->totalClients,
            'currentGuests'       => $this->currentGuests,
            'recentRegistrations' => $this->recentRegistrations,
            'weeklyStats'         => $this->weeklyStats,
        ]);
    }
}