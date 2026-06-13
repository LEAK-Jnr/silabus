import './bootstrap';

document.addEventListener('livewire:init', () => {
    import Alpine from 'alpinejs';
    window.Alpine = Alpine;
    Alpine.start();
});