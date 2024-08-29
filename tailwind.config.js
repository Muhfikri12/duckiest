/** @type {import('tailwindcss').Config} */
export default {
  content: [
    './resources/views/**/*.blade.php',
    './resources/views/livewire/**/*.blade.php',
    './vendor/filament/**/*.blade.php',
    // Tambahkan path lain jika perlu
  ],
  theme: {
    extend: {},
  },
  plugins: [
    require('daisyui'),
  ],
}

