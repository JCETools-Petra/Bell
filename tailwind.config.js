import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            // Ocean Resort Theme Colors
            colors: {
                'brand-primary': '#1e3a8a',      // Deep Ocean Blue (Main)
                'brand-secondary': '#0ea5e9',    // Sky Blue (Fresh Accent)
                'brand-accent': '#D4AF37',       // Sand Gold (Luxury Touch)
                'brand-dark': '#0f172a',         // Midnight (Text/Footer)
                'brand-light': '#f0f9ff',        // Pale Water (Backgrounds)
                'brand-white': '#ffffff',

                // Legacy/Admin compatibility (mapping to new theme)
                'admin-primary': '#1e3a8a',
                'admin-secondary': '#0ea5e9',
                'admin-accent': '#D4AF37',
                'admin-dark': '#1e293b',
                'admin-darker': '#0f172a',
                'admin-light': '#f0f9ff',

                // Keep original for safety
                'brand-black': '#222222',
                'brand-gold': '#D4AF37',
            },

            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms],
};