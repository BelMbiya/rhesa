<div class="mb-4">
    <label class="block mb-2 font-semibold">Signature du client</label>
    <div 
        wire:ignore 
        class="border rounded bg-white"
        style="width: 100%; max-width: 400px;"
    >
        <canvas id="signature-pad" width="400" height="150" class="w-full"></canvas>
    </div>
    <button type="button" onclick="clearSignature()" class="mt-2 px-3 py-1 bg-gray-200 rounded">Effacer</button>
    <input type="hidden" id="signature" wire:model="signature" />
    @error('signature') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.1.7/dist/signature_pad.umd.min.js"></script>
<script>
    let signaturePad;
    document.addEventListener('livewire:load', function () {
        const canvas = document.getElementById('signature-pad');
        signaturePad = new SignaturePad(canvas);

        signaturePad.onEnd = function () {
            document.getElementById('signature').value = signaturePad.toDataURL();
            window.livewire.find('{{ $this->id }}').set('signature', signaturePad.toDataURL());
        };
    });

    function clearSignature() {
        signaturePad.clear();
        document.getElementById('signature').value = '';
        window.livewire.find('{{ $this->id }}').set('signature', '');
    }
</script>
@endpush
