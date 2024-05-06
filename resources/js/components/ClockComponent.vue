<template>
    <div>
      <h2 style="font-weight: 600; color: white; margin: 0;">{{ time }}</h2>
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
      //Prevenir fuga de memoria
      clearInterval(this.interval);
    },
    created() {
      //Actualizar el tiempo cada segundo
      this.interval = setInterval(() => {
        //Cambiar el formate de tiempo respecto a la región indicada en el sistema
        this.time = Intl.DateTimeFormat(navigator.language, {
          hour: 'numeric',
          minute: 'numeric',
          second: 'numeric'
        }).format();
      }, 1000);
    }
  };
  </script>