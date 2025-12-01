export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      fontFamily: {
        figtree: ['Figtree', 'sans-serif'],
        poppins: ['Poppins', 'sans-serif'],
        sheppards: ['Mrs Sheppards', 'cursive'],
      }, 
      colors: {
        'green-primary': '#5FB15F',
        'green-primary-dark': '#468646',
        'red-primary': '#E94E63',
        'red-primary-dark': '#AB1A2E'
      }
    },
  },
  plugins: [],
}