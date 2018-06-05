# Servicio de búsqueda a API Spotify, utilizando el API como Datasource.
Servicio de búsqueda solicitado por eclass, el backend fue desarrollado con CakePHP 2.10.10, el front con Bootstrap y javascript (jQuery)
La mayor parte del proyecto está en un Plugin, para mantener separadas sus rutas, DataSource y funciones
## Instalación
Se puede instalar con docker
### Configuración
Cambiar en el archivo docker-compose.yml las credenciales del API de Spotify, se pueden obtener desde acá: https://developer.spotify.com/dashboard/
### Docker compose
Debe estar instalado docker, si no lo está seguir instrucciones desde  https://docs.docker.com/install/
Ejecutar el siguiente comando en la raiz del proyecto
```
docker-compose up
```

## Funciones
### Buscador (http://localhost:8002/spotify/buscar)
Realiza una búsqueda contra artistas, albumes y canciones

### Búsqueda Avanzada (http://server:8080/spotify/busqueda-avanzada)
Realiza una búsqueda especifica contra artistas, albumes o canciones