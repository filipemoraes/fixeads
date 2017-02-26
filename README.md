#Configurações necessárias:

- MySql 5+
- PHP 5.6+
- Habilitar o driver PDO e o driver referente ao banco utilizado, no caso MySQL
- Habilitar o mod_rewrite do Apache

É necessário criar a base de dados manualmente.<br/>
Na raiz do projeto encontra-se o ficheiro "bd.sql" necessário.<br/>
Após criar a base de dados, é necessário editar o ficheiro "config.ini" na raiz do projeto:<br/><br/>

config.ini
-------------------
db = MySQL<br/>
dbname = fixeads<br/>
username = 'root'<br/>
passwd = 'root'<br/>
host = localhost<br/>
debug = true<br/>

<br/>
O parâmetro "debug" indica se as mensagens de erro devem ser exibidas em tela.
