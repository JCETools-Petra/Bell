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
                // Navy Professional Theme
                'admin-primary': '#1e3a8a',      // Navy Blue - Main (elegant & professional)
                'admin-secondary': '#0ea5e9',    // Sky Blue - Bright accent
                'admin-accent': '#fbbf24',       // Amber Gold - Warm & luxurious
                'admin-tertiary': '#06b6d4',     // Cyan - Fresh touch
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