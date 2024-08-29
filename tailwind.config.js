/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './resources/views/**/*.blade.php',
        './resources/views/livewire/**/*.blade.php',
        './vendor/filament/**/*.blade.php',
        "./node_modules/flowbite/**/*.js"
        // Tambahkan path lain jika perlu
    ],
    theme: {
        extend: {
            container: {
                center: true,
            },
        },
    },
    plugins: [
        require('flowbite/plugin'),
    ],
}
