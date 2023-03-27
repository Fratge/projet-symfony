/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./assets/**/*.js",
    "./templates/**/*.html.twig",
  ],
  theme: {
    extend: {
      colors: {
        'description' : '#69707D',
        'b-grey' : '#E4E9F2',
        'marque': '#FF7E1B',
        'button': '#FFAB6A',
        primary: {"50":"#eff6ff","100":"#dbeafe","200":"#bfdbfe","300":"#93c5fd","400":"#60a5fa","500":"#3b82f6","600":"#2563eb","700":"#1d4ed8","800":"#1e40af","900":"#1e3a8a"}

      },
      fontFamily: {
        'Kumbh':  ['Kumbh Sans']
      },
      borderWidth: {
        '1': '1px',
      },
      borderRadius: {
        '15': '15px',
      },
      width: {
        '100': '475px',
      }
    },
  },
  plugins: [],
}