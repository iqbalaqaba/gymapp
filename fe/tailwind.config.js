/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./src/**/*.{html,js}"],
  theme: {
    extend: {
      colors: {
        'fitcamp-black': '#050403'
      },
      lineHeight: {
        '14': '14.52px',
        '19': '19.68px',
        '16': '16.94px',
        '17': '17.22px',
      },
      letterSpacing: {
        '03': '0.3px',
        '05': '0.5px',
        '59': '59.04px',
      },
      colors: {
        'fitcamp-black': '#050403',
        'fitcamp-royal-blue': '#606DE5',
      }
    },
  },
  plugins: [],
}