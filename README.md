Diagrama de flujo

![](https://drive.google.com/uc?export=view&id=1ZCKMqO-1afNRlJyluYNRDHuJYXnmsc2T)

Descripción 

Para este ejercicio utilice el lenguaje PHP, el escenario que quise plantear fue el de un usuario que registra una venta en un sistema A, este sistema A fue creado para poder realizar el envio de la compra
en formato XML a un servicio intermedio que realizará la conversion de los datos de la compra XML a JSON, para mandar los datos a un sistema B destino que recibe estos datos y los inserta en una base de datos

En sistema A:

Se utiliza el cliente SoapCliente que nos permite realizar el envio de la información con formato XML hacia un servicio que soporte dicha comunicacion de datos.

En fake ace:

Se define un endpoint que recibe la llamada de sistema A y recibe los datos XML y crea un objeto json a partir de ellos. Se implementa el uso de una funcion middleware para realizar la deteccion de un token de autenticacion
el cual nos ayudará a evitar consumos que provengan de fuentes no autorizadas. El servicio redirecciona los datos al systema B si todo esta correctamente

en sistema B:

Se reciben los datos de la venta y se insertan en una base de datos mysql, una vez insertados los datos son mostrados en una tabla.

Menejo de errores y trazabilidad:

1 - Por cuestiones de tiempo... solo se realizó un middleware para informar sobre si un token no esta definido en la peticion o no es un token valido para el consumo
En vista de captura de ventas se realiza la validacion de si hubo un error o si la captura fue exitosa, me muestra mensaje de exito o error segun sea el caso.
2 - Se implementa un log de acciones para determinar ciertas acciones que pudieran suceder mientras el sistema A se comunica con el sistema B. Al momento de seguir el flujo de los datos, se realiza una llamada a otro archivo api
el cual se conecta a una base de datos llamada trace_log, en la cual se cuenta con una tabla donde se registran datos como la ip, token, accion y la hora de registro

Pseudocodigo

Inicio

SistemaA:
    Mostrar formulario de venta al usuario
    Capturar datos: cliente, producto, cantidad, precio, método de pago
    Enviar datos como solicitud SOAP/XML al endpoint http://localhost:3000/soap

ExpressAPI:
    Recibir solicitud SOAP/XML
    Verificar token de autenticación
    Parsear XML → extraer campos de venta
    Convertir datos a formato JSON
    Enviar JSON mediante POST a http://system-b/api

SistemaB:
    Recibir JSON con datos de venta
    Validar y almacenar en base de datos
    Retornar respuesta de éxito o error

ExpressAPI:
    Construir respuesta SOAP/XML con resultado
    Enviar respuesta de vuelta a SistemaA

SistemaA:
    Mostrar confirmación al usuario

Fin

ARCHIVO DE EVIDENCIAS DE LO REALIAZDO
[Ver documento PDF](https://drive.google.com/file/d/1KpUYDgZXLZjzx6hbqsfOa96DZF5a6z1C/view?usp=sharing)

