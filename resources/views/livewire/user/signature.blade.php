<div>
    <canvas wire:ignore
        id="signature-canvas" 
        width="400" height="200" 
        class="border"></canvas>

    <div class="mt-2">
        <button wire:click="clear" type="button">Effacer</button>
        <button wire:click="save" type="button">Sauvegarder</button>
    </div>

    @if ($signatureData)
        <div class="mt-4">
            <strong>Signature enregistrée :</strong><br>
            <img src="{{ $signatureData }}" alt="Signature" />
        </div>
    @endif

    <script>
        document.addEventListener('livewire:load', function () {
            const canvas = document.getElementById('signature-canvas');

            // Resize le canvas pour bien supporter les écrans haute résolution
            function resizeCanvas() {
                const ratio = Math.max(window.devicePixelRatio || 1, 1);
                canvas.width = canvas.offsetWidth * ratio;
                canvas.height = canvas.offsetHeight * ratio;
                canvas.getContext("2d").scale(ratio, ratio);
            }

            resizeCanvas();

            const signaturePad = new SignaturePad(canvas);

            window.addEventListener('resize', resizeCanvas);

            Livewire.on('getSignatureData', () => {
                if (!signaturePad.isEmpty()) {
                    const data = signaturePad.toDataURL('image/png');
                    Livewire.emit('signatureData', data);
                }
            });

            Livewire.on('clearSignature', () => {
                signaturePad.clear();
            });

            // ✅ Écoute de l'événement dispatché par Livewire côté PHP
            window.addEventListener('get-signature', () => {
                if (!signaturePad.isEmpty()) {
                    const data = signaturePad.toDataURL('image/png');
                    Livewire.emit('signatureData', data);
                }
            });
        });
    </script>
</div>
