<template>
    <div>
      <!-- Aquí puedes mostrar el tiempo en tu vista -->
      <h2 style="color: white; margin: 0;">{{ time }}</h2>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        interval: null,
        time: null
      };
    },
    beforeDestroy() {
      // Prevenir fuga de memoria
      clearInterval(this.interval);
    },
    created() {
      // Actualizar el tiempo cada segundo
      this.interval = setInterval(() => {
        // Formatear el tiempo según la configuración regional del sistema
        this.time = Intl.DateTimeFormat(navigator.language, {
          hour: 'numeric',
          minute: 'numeric',
          second: 'numeric'
        }).format();
      }, 1000);
    }
  };
  </script>