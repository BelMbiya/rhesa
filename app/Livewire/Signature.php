<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Registration;


class Signature extends Component
{
    public $signatureData;

    protected $listeners = ['signatureData' => 'storeSignature'];

    public function save()
    {
        $this->dispatchBrowserEvent('getSignature');
        $this->emit('getSignatureData');
    }

    public function storeSignature($data)
    {
        $this->signatureData = $data;

        Registration::query()->update([
            'signature' => $data
        ]);
    }

    public function clear()
    {
        $this->emit('clearSignature');
        $this->signatureData = null;
    }

    public function render()
    {
        return view('livewire.user.signature');
    }
}
