import { createIcons, icons } from 'lucide'

export const authController = (config) => ({
    init() {
        createIcons({ icons });
    },
    loading: false,
    remember: config.remember || false,
    
    submitForm() {
        this.loading = true;
    }
});
