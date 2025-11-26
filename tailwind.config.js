// File: tailwind.config.js

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
                'brand-black': '#222222',
                'brand-red': '#A4161A',
                'brand-gold': '#D4AF37',
                // New Sky Blue Resort Theme
                'admin-primary': '#87CEEB',      // Sky Blue - Main
                'admin-secondary': '#4682B4',    // Steel Blue - Depth
                'admin-accent': '#FFE4B5',       // Moccasin - Cream
                'admin-tertiary': '#5F9EA0',     // Cadet Blue
                'admin-dark': '#1e293b',         // Slate 800 - Dark backgrounds
                'admin-darker': '#0f172a',       // Slate 900 - Darker backgrounds
                'admin-light': '#f8fafc',        // Slate 50 - Light backgrounds
            },

            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms],
};