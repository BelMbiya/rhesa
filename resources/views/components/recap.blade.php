@if
<div>
    <x-input label="Numéro d'indentité" wire:model="identity_number"/>
    <x-input label="Moyen de l'enregistrement" wire:model="origin">
    <x-input label="Votre nom" wire:model="Last_name" type="text" autofocus />
    <x-input label="Votre postom" wire:model="First_name" type="text" />
    
</div>
@endif