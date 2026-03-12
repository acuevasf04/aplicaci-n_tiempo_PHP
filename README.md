# APLICACIÓN DEL TIEMPO

<img width="1248" height="770" alt="image" src="https://github.com/user-attachments/assets/8e62169c-ab40-4dbb-adc0-e272cb8f2349" />


## 1.- INTRODUCCIÓN

En esta práctica se realizará una aplicación web la cual te dirá el pronóstico de cualquier ciudad que exista.

## 2.- ESTRUCTURA DE FICHEROS

Los ficheros se organizan de la siguiente manera:

<img width="462" height="323" alt="image" src="https://github.com/user-attachments/assets/0363abf4-9531-4a78-a2b6-bece67b46301" />

El archivo index.php es donde se guarda la página principal, donde se hace la búsqueda.

El archivo ```.sql``` es donde se encuentra el scrpit de la base de datos que se ha creado para guardar las consultas.

El fichero PHP se guardan los programas de PHP que complementan al archivo index.php. Teniendo la configuración que da la información de la API que se usa, el pronóstico por horas, el pronóstico de la semana, y la inyección sql para guardar las consultas en la base de datos que se ha creado.

## 3.- FUNCIONAMIENTO DE LA PÁGINA

La pagina funciona de tal manera que al entrar en la página, te aparece un buscador y hay que entrar una ciudad. <br>

Al entrar la ciudad que quieres buscar, aparecerán 2 botones los cuales te redirigirán a los pronósticos tanto de horas como la semanal en dos botones distintos. <br>

## 4.- AWS

Para subir los archivos de configuración de docker a una máquina en la nube, se tiene que acceder a ella a través del siguiente comando:
```
ssh -i "C:\Users\Antonio Cuevas\Desktop\labsuser.pem" admin@98.80.29.72
```
Accedemos a la máquina a través de ssh. Luego usando el comando ```sudo apt update && sudo apt upgrade -y ´´´ para actualizar los repositorios de linux, y luego actualizar el sistema. <br>

Luego hay que clonar el repositorio de GitHub en la máquina de AWS, para ello hay que hacer lo siguiente:
```
sudo apt install git -y
git clone https://github.com/acuevasf04/aplicaci-n_tiempo_PHP
```
Una vez descargado el repositorio de la aplicación web, se tiene que instalar docker en la máquina y ejecutar los siguientes comandos para que funcione esta aplicación:

```
sudo apt-get update
sudo apt-get install docker-ce docker-ce-cli containerd.io docker-buildx-plugin docker-compose-plugin -y
```

Una vez instalado docker, hay que entrar en el directorio donde se encuentre el docker file y el docker compose para que se creen los contenedores. Utilizando el comando ```docker compose up``` para crear los contenedores. <br>

Una vez hecho esto, se le asocia una IP elástica y en la página de NoIP se le da un nombre de dominio el cual tienes que asociar la IP y ponerle el nombre que quieras. <br>

Por último, la página que a la que se tiene que acceder es http://antonciclon.myftp.org/index.php
