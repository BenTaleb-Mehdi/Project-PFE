import './bootstrap';
import Alpine from 'alpinejs';
import 'preline';

import './components/dashboard.js';
import './components/program.js';

window.Alpine = Alpine;

Alpine.store('alert', {
    visible: false,
    message: '',
    type: 'success',
    show(message, type = 'success') {
        this.message = message;
        this.type = type;
        this.visible = true;
        setTimeout(() => this.visible = false, 4000);
    }
});

// Dummy icons helper to prevent breakages in case manual calls exist
window.createIcons = () => {};

Alpine.start();