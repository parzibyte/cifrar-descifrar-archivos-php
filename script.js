/**
 * Generador de multiplicaciones con JavaScript, MathJax, Vue.js y BulmaCSS
 * 
 * Visita: https://parzibyte.me/blog
 * @author parzibyte
 */
new Vue({
    el: "#app",
    data: () => ({
        cargando: false,
        titulo: "Resuelve las siguientes multiplicaciones",
        multiplicaciones: [],
        columnas: 5,
        multiplicacionesPorColumna: 9,
        rangos: {
            multiplicando: {
                inicio: 1,
                fin: 500,
            },
            multiplicador: {
                inicio: 1,
                fin: 500,
            }
        }
    }),
    methods: {
        aleatorio(minimo, maximo) {
            return Math.floor(Math.random() * (maximo - minimo + 1)) + minimo;
        },
        aleatorioMultiplicando() {
            return this.aleatorio(this.rangos.multiplicando.inicio, this.rangos.multiplicando.fin);
        },
        aleatorioMultiplicador() {
            return this.aleatorio(this.rangos.multiplicador.inicio, this.rangos.multiplicador.fin);
        },
        generarRealmente() {
            // Generar, de nuevo, las multiplicaciones
            let multiplicaciones = [];
            for (let x = 0; x < this.columnas; x++) {
                multiplicaciones[x] = [];
                for (let i = 0; i < this.multiplicacionesPorColumna; i++) {
                    multiplicaciones[x].push({
                        multiplicador: this.aleatorioMultiplicador(),
                        multiplicando: this.aleatorioMultiplicando(),
                    });
                }
            }
            // Dejar que Vue las dibuje
            this.multiplicaciones = multiplicaciones;
            Vue.nextTick().then(() => {
                // Y, por última vez, decirle a MathJax que refresque las cosas
                MathJax.Hub.Queue(["Typeset", MathJax.Hub]);
                MathJax.Hub.Queue(["indicarCargaTerminada", this]);
            });
        },
        indicarCargaTerminada() {
            this.cargando = false;
        },
        limpiarMultiplicacionesYDespuesGenerar() {
            this.cargando = true;
            // Limpiar las multiplicaciones y esperar, amablemente
            // a que Vue renderice :)
            this.multiplicaciones = [];
            // En su siguiente renderizado...
            Vue.nextTick().then(() => {
                // Encolar la "actualización" de las fórmulas
                MathJax.Hub.Queue(["Typeset", MathJax.Hub]);
                // Y encolar la función de generarRealmente
                MathJax.Hub.Queue(["generarRealmente", this]);
            });
        },
        generar() {
            if (this.columnas > 12) this.columnas = 12;
            // Nota: si no se hacía así, se duplicaban las fórmulas,
            // o mejor dicho, se iban agregando más y más como si fuera una pila
            this.limpiarMultiplicacionesYDespuesGenerar();
        },
        imprimir() {
            window.print();
        },
    }
});