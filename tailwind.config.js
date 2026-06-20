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
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                white: '#171717',
                black: '#fafafa',
                gray: {
                    50: '#0a0a0a',
                    100: '#0f0f0f',
                    200: '#262626',
                    300: '#404040',
                    400: '#525252',
                    500: '#a3a3a3',
                    600: '#d4d4d4',
                    700: '#e5e5e5',
                    800: '#f5f5f5',
                    900: '#ffffff',
                },
                blue: {
                    50: '#172554',
                    100: '#1e3a8a',
                    200: '#1e40af',
                    300: '#1d4ed8',
                    400: '#2563eb',
                    500: '#3b82f6',
                    600: '#60a5fa',
                    700: '#93c5fd',
                    800: '#bfdbfe',
                    900: '#dbeafe',
                },
                green: {
                    50: '#052e16',
                    100: '#064e3b',
                    200: '#065f46',
                    300: '#047857',
                    400: '#059669',
                    500: '#10b981',
                    600: '#34d399',
                    700: '#6ee7b7',
                    800: '#a7f3d0',
                    900: '#d1fae5',
                },
                red: {
                    50: '#4c0519',
                    100: '#881337',
                    200: '#9f1239',
                    300: '#be123c',
                    400: '#e11d48',
                    500: '#f43f5e',
                    600: '#fb7185',
                    700: '#fda4af',
                    800: '#fecdd3',
                    900: '#ffe4e6',
                },
                purple: {
                    50: '#2e1065',
                    100: '#3b0764',
                    200: '#4c1d95',
                    300: '#5b21b6',
                    400: '#6d28d9',
                    500: '#8b5cf6',
                    600: '#a78bfa',
                    700: '#c4b5fd',
                    800: '#ddd6fe',
                    900: '#ede9fe',
                },
                yellow: {
                    50: '#422006',
                    100: '#713f12',
                    200: '#854d0e',
                    300: '#a16207',
                    400: '#ca8a04',
                    500: '#eab308',
                    600: '#facc15',
                    700: '#fde047',
                    800: '#fef08a',
                    900: '#fef9c3',
                },
            }
        },
    },

    plugins: [forms],
};
