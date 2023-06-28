class vueUtils {

    async exectWithTimeOut(timeout, functionName) {
        const timeoutPromise = new Promise((resolve, reject) => {
            setTimeout(() => {
                self.cancel('La petición ha sido cancelada debido al límite de tiempo.');
                console.log(`Tarea cancelada después de ${timeout} ms`);
            }, timeout);
        });
    
        // Ejecutar la función y esperar a que se complete o se alcance el timeout
        const resultado = await Promise.race([self[functionName](), timeoutPromise]);
        return resultado;
    }

    sleep(milliseconds) {
        return new Promise((resolve) => setTimeout(resolve, milliseconds));
    }
}