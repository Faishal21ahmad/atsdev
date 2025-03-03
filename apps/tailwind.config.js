import defaultTheme from 'tailwindcss/defaultTheme';
const plugin = require("tailwind-scrollbar");
import { Html5QrcodeScanner } from "html5-qrcode";

/** @type {import('tailwindcss').Config} */
export default {
    
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
        './node_modules/flowbite/**/*.js',
    ],
    darkMode: ['media'],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
                
            },
        },
    },
    plugins: [
        require('flowbite/plugin'),
        require('tailwind-scrollbar')({ preferredStrategy: 'pseudoelements' }),
        
        
    ],
    
};
